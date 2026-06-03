<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Models\Kurir;
use App\Models\Pesanan;
use App\Models\PenolakanPengiriman;
use App\Models\PengirimanTracking;
use App\Models\BuktiPengiriman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TugasController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::check() ? Auth::user() : \App\Models\User::where('role', 'kurir')->first();
        $kurir = $user ? Kurir::where('id_user', $user->id_user)->first() : null;

        $query = Pesanan::where('id_kurir', $kurir->id_kurir ?? 0)
            ->whereIn('status_pesanan', ['pending', 'diterima_driver', 'diambil', 'dalam_pengiriman'])
            ->with(['pelanggan.user', 'cabang']);

        if ($request->has('status') && $request->status) {
            $query->where('status_pesanan', $request->status);
        }

        $tugas = $query->orderBy('created_at', 'desc')->get();

        return view('driver.tugas.index', compact('tugas'));
    }

    public function show($id)
    {
        $pesanan = Pesanan::with(['pelanggan.user', 'cabang', 'details.produk', 'pengirimanTracking', 'buktiPengiriman'])
            ->findOrFail($id);

        return view('driver.tugas.show', compact('pesanan'));
    }

    /**
     * Konfirmasi pesanan - ubah status dari pending ke diterima_driver
     */
    public function confirm(Request $request, $id)
    {
        try {
            $pesanan = Pesanan::findOrFail($id);

            // Cek status harus pending
            if ($pesanan->status_pesanan !== 'pending') {
                return response()->json([
                    'success' => false,
                    'message' => 'Pesanan harus dalam status pending untuk dikonfirmasi'
                ], 400);
            }

            // Update status
            $pesanan->status_pesanan = 'diterima_driver';
            $pesanan->save();

            // Catat tracking
            PengirimanTracking::create([
                'id_pesanan' => $id,
                'status' => 'diterima_driver',
                'keterangan' => 'Driver telah mengkonfirmasi pengiriman'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Pesanan berhasil dikonfirmasi'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Tolak pesanan - ubah status ke ditolak_driver dan catat alasan
     */
    public function reject(Request $request, $id)
    {
        try {
            $request->validate([
                'alasan' => 'required|string|min:10'
            ]);

            $pesanan = Pesanan::findOrFail($id);
            $user = Auth::check() ? Auth::user() : \App\Models\User::where('role', 'kurir')->first();
            $kurir = Kurir::where('id_user', $user->id_user)->first();

            // Cek status harus pending
            if ($pesanan->status_pesanan !== 'pending') {
                return response()->json([
                    'success' => false,
                    'message' => 'Pesanan harus dalam status pending untuk ditolak'
                ], 400);
            }

            // Update status
            $pesanan->status_pesanan = 'ditolak_driver';
            $pesanan->save();

            // Catat penolakan
            PenolakanPengiriman::create([
                'id_pesanan' => $id,
                'id_kurir' => $kurir->id_kurir,
                'alasan' => $request->alasan
            ]);

            // Catat tracking
            PengirimanTracking::create([
                'id_pesanan' => $id,
                'status' => 'ditolak_driver',
                'keterangan' => 'Driver menolak pengiriman: ' . $request->alasan
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Pesanan berhasil ditolak'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update status pengiriman via AJAX
     */
    public function updateStatus(Request $request, $id)
    {
        try {
            $request->validate([
                'status' => 'required|string',
                'alasan_gagal' => 'nullable|string|min:10'
            ]);

            $pesanan = Pesanan::findOrFail($id);
            $newStatus = $request->status;

            // Validasi status yang diizinkan
            $allowedStatuses = ['diambil', 'dalam_pengiriman', 'diterima', 'gagal'];
            if (!in_array($newStatus, $allowedStatuses)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Status tidak valid'
                ], 400);
            }

            // Validasi alur pengiriman (Sequence)
            $currentStatus = $pesanan->status_pesanan;
            
            if ($newStatus === 'diambil' && $currentStatus !== 'diterima_driver') {
                return response()->json([
                    'success' => false,
                    'message' => 'Pesanan harus dikonfirmasi terlebih dahulu sebelum dapat diambil'
                ], 400);
            }

            if ($newStatus === 'dalam_pengiriman' && $currentStatus !== 'diambil') {
                return response()->json([
                    'success' => false,
                    'message' => 'Pesanan harus diambil dari gudang terlebih dahulu sebelum dalam pengiriman'
                ], 400);
            }

            if ($newStatus === 'diterima' && $currentStatus !== 'dalam_pengiriman') {
                return response()->json([
                    'success' => false,
                    'message' => 'Pesanan harus berada pada status Dalam Pengiriman sebelum dapat diterima'
                ], 400);
            }

            // Jika gagal, wajib ada alasan
            if ($newStatus === 'gagal' && !$request->alasan_gagal) {
                return response()->json([
                    'success' => false,
                    'message' => 'Alasan gagal kirim harus diisi'
                ], 400);
            }

            // Update status
            $pesanan->status_pesanan = $newStatus;
            if ($newStatus === 'gagal') {
                $pesanan->alasan_gagal = $request->alasan_gagal;
            }
            $pesanan->save();

            // Keterangan tracking
            $keteranganMap = [
                'diambil' => 'Pesanan diambil dari gudang',
                'dalam_pengiriman' => 'Menuju lokasi pelanggan',
                'diterima' => 'Pesanan diterima oleh pelanggan',
                'gagal' => 'Gagal kirim: ' . ($request->alasan_gagal ?? ''),
            ];

            // Catat tracking
            PengirimanTracking::create([
                'id_pesanan' => $id,
                'status' => $newStatus,
                'keterangan' => $keteranganMap[$newStatus] ?? 'Status diperbarui oleh driver'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Status berhasil diperbarui ke ' . strtoupper(str_replace('_', ' ', $newStatus))
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Upload bukti pengiriman
     */
    public function uploadProof(Request $request, $id)
    {
        try {
            $request->validate([
                'foto_bukti' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
                'nama_penerima' => 'required|string|max:100',
                'catatan_driver' => 'nullable|string|max:500'
            ]);

            $pesanan = Pesanan::findOrFail($id);

            // Validasi status harus dalam_pengiriman sebelum upload bukti
            if ($pesanan->status_pesanan !== 'dalam_pengiriman') {
                return response()->json([
                    'success' => false,
                    'message' => 'Pesanan harus berada pada status Dalam Pengiriman sebelum dapat mengunggah bukti dan menyelesaikan pesanan.'
                ], 400);
            }

            // Upload file
            if ($request->hasFile('foto_bukti')) {
                $file = $request->file('foto_bukti');
                $path = $file->store('bukti_pengiriman', 'public');

                // Simpan bukti pengiriman
                BuktiPengiriman::updateOrCreate(
                    ['id_pesanan' => $id],
                    [
                        'foto_bukti' => $path,
                        'nama_penerima' => $request->nama_penerima,
                        'catatan_driver' => $request->catatan_driver
                    ]
                );

                // Update status jika belum diterima
                if (!in_array($pesanan->status_pesanan, ['diterima', 'gagal'])) {
                    $pesanan->status_pesanan = 'diterima';
                    $pesanan->save();

                    PengirimanTracking::create([
                        'id_pesanan' => $id,
                        'status' => 'diterima',
                        'keterangan' => 'Pesanan diterima customer dengan bukti foto'
                    ]);
                }

                return response()->json([
                    'success' => true,
                    'message' => 'Bukti pengiriman berhasil diunggah'
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengunggah file'
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Ambil pesanan dari antrian FCFS (Dengan Locking)
     */
    public function ambil(Request $request, $id)
    {
        try {
            $user = Auth::check() ? Auth::user() : \App\Models\User::where('role', 'kurir')->first();
            $kurir = Kurir::where('id_user', $user->id_user)->first();

            if (!$kurir) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data kurir tidak valid'
                ], 403);
            }

            // Pengecekan jika kurir masih memiliki tugas aktif
            $activeOrder = Pesanan::where('id_kurir', $kurir->id_kurir)
                ->whereIn('status_pesanan', ['diterima_driver', 'diambil', 'dalam_pengiriman'])
                ->exists();

            if ($activeOrder) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda masih memiliki pesanan aktif. Selesaikan pesanan Anda terlebih dahulu atau jika gagal, tandai sebagai gagal kirim.'
                ], 400);
            }

            // Gunakan DB Transaction untuk locking
            $success = DB::transaction(function () use ($id, $kurir) {
                // Lock row pesanan untuk menghindari race condition (FCFS)
                $pesanan = Pesanan::lockForUpdate()->find($id);

                if (!$pesanan) {
                    throw new \Exception('Pesanan tidak ditemukan');
                }

                // Verifikasi apakah masih pending dan belum diambil driver lain
                if ($pesanan->status_pesanan !== 'pending' || $pesanan->id_kurir !== null) {
                    throw new \Exception('Maaf, pesanan ini sudah diambil oleh driver lain');
                }

                // Update data pesanan
                $pesanan->id_kurir = $kurir->id_kurir;
                $pesanan->status_pesanan = 'diterima_driver';
                $pesanan->accepted_at = now();
                $pesanan->save();

                // Catat tracking
                PengirimanTracking::create([
                    'id_pesanan' => $pesanan->id_pesanan,
                    'status' => 'diterima_driver',
                    'keterangan' => 'Driver ' . $kurir->user->nama . ' mengambil pesanan'
                ]);

                return true;
            });

            if ($success) {
                return response()->json([
                    'success' => true,
                    'message' => 'Pesanan berhasil diambil'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400); // 400 Bad Request agar Frontend memprosesnya sebagai kegagalan logic
        }
    }

    /**
     * Polling: Ambil antrian tugas FCFS terbaru
     */
    public function getLatestAntrian(Request $request)
    {
        $antrianTugas = Pesanan::whereNull('id_kurir')
            ->where('status_pesanan', 'pending')
            ->with(['cabang', 'pelanggan.user'])
            ->orderBy('created_at', 'asc')
            ->get();

        if ($request->wantsJson()) {
            // Format to match JS needs
            $formatted = $antrianTugas->map(function($p) {
                return [
                    'id' => $p->id_pesanan,
                    'location' => 'GUDANG ' . strtoupper($p->cabang->nama_cabang ?? 'PUSAT'),
                    'time' => $p->created_at->format('H:i') . ' WIB',
                    'customer' => strtoupper($p->pelanggan->user->name ?? 'PELANGGAN')
                ];
            });
            return response()->json($formatted);
        }

        // Mengembalikan view partial untuk dirender ulang di sisi klien
        return view('driver.components.stacked-cards-partial', compact('antrianTugas'));
    }
}
