<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Models\Kurir;
use App\Models\Pesanan;
use App\Models\PenolakanPengiriman;
use App\Models\PengirimanTracking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TugasController extends Controller
{
    /**
     * Daftar tugas aktif milik driver yang sedang login.
     * Status 'mencari_driver' TIDAK ditampilkan di sini karena belum diassign ke driver manapun.
     * Filter cabang: driver hanya melihat pesanan dari cabangnya sendiri.
     */
    public function index(Request $request)
    {
        $user  = Auth::check() ? Auth::user() : \App\Models\User::where('role', 'kurir')->first();
        $kurir = $user ? Kurir::where('id_user', $user->id_user)->first() : null;

        $query = Pesanan::where('id_kurir', $kurir->id_kurir ?? 0)
            ->where('id_cabang', $kurir->id_cabang ?? 0) // filter cabang
            ->whereIn('status_pesanan', [
                'diterima_driver',
                'diambil',
                'dalam_pengiriman',
            ])
            ->with(['pelanggan.user', 'cabang']);

        if ($request->filled('status')) {
            $query->where('status_pesanan', $request->status);
        }

        $tugas = $query->orderBy('created_at', 'desc')->get();

        return view('driver.tugas.index', compact('tugas'));
    }

    public function show($id)
    {
        $user  = Auth::user();
        $kurir = Kurir::where('id_pengguna', $user->id_pengguna)->first();

        // SECURITY: Driver hanya bisa lihat detail pesanan yang diassign padanya
        // atau pesanan berstatus 'mencari_driver' dari cabangnya (antrian)
        $pesanan = Pesanan::with([
            'pelanggan.user',
            'cabang',
            'details.produk',
            'pengirimanTracking',
            'kurir',
        ])
        ->where('id_pesanan', $id)
        ->where(function ($q) use ($kurir) {
            $q->where('id_kurir', $kurir?->id_kurir)
              ->orWhere(function ($q2) use ($kurir) {
                  $q2->where('status_pesanan', 'mencari_driver')
                     ->where('id_cabang', $kurir?->id_cabang);
              });
        })
        ->firstOrFail();

        return view('driver.tugas.show', compact('pesanan'));
    }

    /**
     * Konfirmasi pesanan — ubah status dari diterima_driver (sudah diambil lewat ambil())
     * ke tahap berikutnya. Method ini tidak dipakai untuk ambil antrian,
     * hanya sebagai fallback konfirmasi manual jika diperlukan admin.
     */
    public function confirm(Request $request, $id)
    {
        try {
            $user  = Auth::check() ? Auth::user() : \App\Models\User::where('role', 'kurir')->first();
            $kurir = Kurir::where('id_pengguna', $user->id_pengguna)->first();

            // SECURITY: Driver hanya bisa konfirmasi pesanan miliknya
            $pesanan = Pesanan::where('id_pesanan', $id)
                ->where('id_kurir', $kurir?->id_kurir)
                ->first();
            if (!$pesanan) {
                return response()->json(['success' => false, 'message' => 'Pesanan tidak ditemukan atau bukan milik Anda.'], 404);
            }

            if ($pesanan->status_pesanan !== 'diterima_driver') {
                return response()->json([
                    'success' => false,
                    'message' => 'Pesanan harus dalam status Diterima Driver untuk dikonfirmasi',
                ], 400);
            }

            $pesanan->status_pesanan = 'diterima_driver';
            $pesanan->save();

            PengirimanTracking::create([
                'id_pesanan' => $id,
                'status'     => 'diterima_driver',
                'keterangan' => 'Driver telah mengkonfirmasi pengiriman',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Pesanan berhasil dikonfirmasi',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Tolak pesanan — hanya bisa dilakukan saat status 'mencari_driver'.
     * Setelah ditolak, status berubah ke 'ditolak_driver' agar bisa diassign ulang oleh admin.
     */
    public function reject(Request $request, $id)
    {
        try {
            $request->validate([
                'alasan' => 'required|string|min:10',
            ]);

            $user  = Auth::check() ? Auth::user() : \App\Models\User::where('role', 'kurir')->first();
            $kurir = Kurir::where('id_pengguna', $user->id_pengguna)->first();

            // SECURITY: Driver hanya bisa tolak pesanan dari cabangnya yang sedang mencari driver
            $pesanan = Pesanan::where('id_pesanan', $id)
                ->where('id_cabang', $kurir?->id_cabang)
                ->first();
            if (!$pesanan) {
                return response()->json(['success' => false, 'message' => 'Pesanan tidak ditemukan atau bukan dari cabang Anda.'], 404);
            }

            if ($pesanan->status_pesanan !== 'mencari_driver') {
                return response()->json([
                    'success' => false,
                    'message' => 'Pesanan hanya dapat ditolak saat status mencari_driver',
                ], 400);
            }

            $pesanan->status_pesanan = 'ditolak_driver';
            $pesanan->save();

            PenolakanPengiriman::create([
                'id_pesanan' => $id,
                'id_kurir'   => $kurir->id_kurir,
                'alasan'     => $request->alasan,
            ]);

            PengirimanTracking::create([
                'id_pesanan' => $id,
                'status'     => 'ditolak_driver',
                'keterangan' => 'Driver menolak pengiriman: ' . $request->alasan,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Pesanan berhasil ditolak',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update status pengiriman via AJAX.
     * Flow yang valid: diterima_driver → diambil → dalam_pengiriman → diterima
     * Status 'mencari_driver' tidak masuk flow ini karena merupakan
     * status antrian sebelum driver mengambil pesanan.
     */
    public function updateStatus(Request $request, $id)
    {
        try {
            $request->validate([
                'status'       => 'required|string',
                'alasan_gagal' => 'nullable|string|min:10',
            ]);

            $user  = Auth::check() ? Auth::user() : \App\Models\User::where('role', 'kurir')->first();
            $kurir = Kurir::where('id_pengguna', $user->id_pengguna)->first();

            // SECURITY: Driver hanya bisa update status pesanan miliknya
            $pesanan = Pesanan::where('id_pesanan', $id)
                ->where('id_kurir', $kurir?->id_kurir)
                ->first();
            if (!$pesanan) {
                return response()->json(['success' => false, 'message' => 'Pesanan tidak ditemukan atau bukan milik Anda.'], 404);
            }
            $newStatus = $request->status;

            $allowedStatuses = ['diambil', 'dalam_pengiriman', 'diterima', 'gagal'];
            if (!in_array($newStatus, $allowedStatuses)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Status tidak valid',
                ], 400);
            }

            $currentStatus = $pesanan->status_pesanan;

            // Validasi urutan (sequence)
            if ($newStatus === 'diambil' && $currentStatus !== 'diterima_driver') {
                return response()->json([
                    'success' => false,
                    'message' => 'Pesanan harus berstatus Diterima Driver sebelum dapat diambil',
                ], 400);
            }

            if ($newStatus === 'dalam_pengiriman' && $currentStatus !== 'diambil') {
                return response()->json([
                    'success' => false,
                    'message' => 'Pesanan harus diambil dari gudang terlebih dahulu',
                ], 400);
            }

            if ($newStatus === 'diterima' && $currentStatus !== 'dalam_pengiriman') {
                return response()->json([
                    'success' => false,
                    'message' => 'Pesanan harus berada pada status Dalam Pengiriman sebelum dapat diterima',
                ], 400);
            }

            // Gagal hanya bisa saat pengiriman sudah di tahap akhir (Dalam Pengiriman)
            if ($newStatus === 'gagal' && $currentStatus !== 'dalam_pengiriman') {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal kirim hanya dapat dilakukan saat pesanan Dalam Pengiriman',
                ], 400);
            }

            if ($newStatus === 'gagal' && !$request->alasan_gagal) {
                return response()->json([
                    'success' => false,
                    'message' => 'Alasan gagal kirim harus diisi',
                ], 400);
            }

            $pesanan->status_pesanan = $newStatus;
            if ($newStatus === 'gagal') {
                $pesanan->alasan_gagal = $request->alasan_gagal;
            }
            $pesanan->save();

            $keteranganMap = [
                'diambil'          => 'Pesanan diambil dari gudang',
                'dalam_pengiriman' => 'Menuju lokasi pelanggan',
                'diterima'         => 'Pesanan diterima oleh pelanggan',
                'gagal'            => 'Gagal kirim: ' . ($request->alasan_gagal ?? ''),
            ];

            PengirimanTracking::create([
                'id_pesanan' => $id,
                'status'     => $newStatus,
                'keterangan' => $keteranganMap[$newStatus] ?? 'Status diperbarui oleh driver',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Status berhasil diperbarui ke ' . strtoupper(str_replace('_', ' ', $newStatus)),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Upload bukti pengiriman.
     * Hanya bisa dilakukan saat status 'dalam_pengiriman'.
     * Setelah berhasil upload, status otomatis berubah ke 'diterima'.
     */
    public function uploadProof(Request $request, $id)
    {
        try {
            $request->validate([
                'foto_bukti'     => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
                'nama_penerima'  => 'required|string|max:100',
                'catatan_driver' => 'nullable|string|max:500',
            ]);

            $user  = Auth::check() ? Auth::user() : \App\Models\User::where('role', 'kurir')->first();
            $kurir = Kurir::where('id_pengguna', $user->id_pengguna)->first();

            // SECURITY: Driver hanya bisa upload bukti untuk pesanan miliknya
            $pesanan = Pesanan::where('id_pesanan', $id)
                ->where('id_kurir', $kurir?->id_kurir)
                ->first();
            if (!$pesanan) {
                return response()->json(['success' => false, 'message' => 'Pesanan tidak ditemukan atau bukan milik Anda.'], 404);
            }

            if ($pesanan->status_pesanan !== 'dalam_pengiriman') {
                return response()->json([
                    'success' => false,
                    'message' => 'Pesanan harus berada pada status Dalam Pengiriman sebelum dapat mengunggah bukti.',
                ], 400);
            }

            if ($request->hasFile('foto_bukti')) {
                $file = $request->file('foto_bukti');
                $path = $file->store('bukti_pengiriman', 'public');

                $pesanan->bukti_pengiriman = $path;
                $pesanan->nama_penerima = $request->nama_penerima;
                $pesanan->catatan_driver = $request->catatan_driver;

                if (!in_array($pesanan->status_pesanan, ['diterima', 'gagal'])) {
                    $pesanan->status_pesanan = 'diterima';
                }
                
                $pesanan->save();

                PengirimanTracking::create([
                    'id_pesanan' => $id,
                    'status'     => 'diterima',
                    'keterangan' => 'Pesanan diterima customer dengan bukti foto',
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Bukti pengiriman berhasil diunggah',
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengunggah file',
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Ambil pesanan dari antrian FCFS dengan DB locking.
     *
     * Pesanan yang bisa diambil driver harus memenuhi semua syarat ini:
     *   1. Status = 'mencari_driver'
     *   2. id_kurir masih NULL (belum diambil siapapun)
     *   3. id_cabang = cabang driver yang sedang login
     *
     * Driver tidak boleh punya pesanan aktif sebelum mengambil pesanan baru.
     */
    public function ambil(Request $request, $id)
    {
        try {
            $user = Auth::check() ? Auth::user() : \App\Models\User::where('role', 'kurir')->first();
            $kurir = Kurir::where('id_pengguna', $user->id_pengguna)->first();

            if (!$kurir) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data kurir tidak valid',
                ], 403);
            }

            // Cek apakah driver masih punya tugas aktif
            $activeOrder = Pesanan::where('id_kurir', $kurir->id_kurir)
                ->whereIn('status_pesanan', ['diterima_driver', 'diambil', 'dalam_pengiriman'])
                ->exists();

            if ($activeOrder) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda masih memiliki pesanan aktif. Selesaikan atau tandai gagal terlebih dahulu.',
                ], 400);
            }

            $success = DB::transaction(function () use ($id, $kurir) {
                $pesanan = Pesanan::lockForUpdate()->find($id);

                if (!$pesanan) {
                    throw new \Exception('Pesanan tidak ditemukan');
                }

                // Validasi status — hanya 'mencari_driver' yang bisa diambil
                if ($pesanan->status_pesanan !== 'mencari_driver' || $pesanan->id_kurir !== null) {
                    throw new \Exception('Maaf, pesanan ini sudah diambil oleh driver lain');
                }

                // Validasi cabang
                if ($pesanan->id_cabang !== $kurir->id_cabang) {
                    throw new \Exception('Pesanan ini bukan dari cabang Anda');
                }

                $pesanan->id_kurir       = $kurir->id_kurir;
                $pesanan->status_pesanan = 'diterima_driver';
                $pesanan->accepted_at    = now();
                $pesanan->save();

                PengirimanTracking::create([
                    'id_pesanan' => $pesanan->id_pesanan,
                    'status'     => 'diterima_driver',
                    'keterangan' => 'Driver ' . ($kurir->user->nama ?? 'Driver') . ' mengambil pesanan',
                ]);

                return true;
            });

            if ($success) {
                return response()->json([
                    'success' => true,
                    'message' => 'Pesanan berhasil diambil',
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Update posisi GPS driver secara real-time.
     * Dipanggil oleh frontend setiap ~15 detik selama pengiriman aktif.
     */
    public function updateLocation(Request $request, $id)
    {
        try {
            $request->validate([
                'lat' => 'required|numeric|between:-90,90',
                'lng' => 'required|numeric|between:-180,180',
            ]);

            $user  = Auth::check() ? Auth::user() : \App\Models\User::where('role', 'kurir')->first();
            $kurir = Kurir::where('id_pengguna', $user->id_pengguna)->first();

            // SECURITY: Driver hanya bisa update lokasi pesanan yang diassign padanya
            $pesanan = Pesanan::where('id_pesanan', $id)
                ->where('id_kurir', $kurir?->id_kurir)
                ->first();
            if (!$pesanan) {
                return response()->json(['success' => false, 'message' => 'Pesanan tidak ditemukan atau bukan milik Anda.'], 404);
            }

            $activeStatuses = ['diterima_driver', 'diambil', 'dalam_pengiriman'];
            if (!in_array($pesanan->status_pesanan, $activeStatuses)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pengiriman tidak aktif',
                ], 400);
            }

            $kurir = Kurir::find($pesanan->id_kurir);
            if (!$kurir) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data kurir tidak ditemukan',
                ], 404);
            }

            $kurir->driver_lat          = $request->lat;
            $kurir->driver_lng          = $request->lng;
            $kurir->location_updated_at = now();
            $kurir->save();

            return response()->json([
                'success' => true,
                'message' => 'Lokasi driver diperbarui',
                'data'    => [
                    'lat'        => $kurir->driver_lat,
                    'lng'        => $kurir->driver_lng,
                    'updated_at' => $kurir->location_updated_at,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Polling: Ambil antrian tugas FCFS terbaru.
     *
     * Hanya menampilkan pesanan dengan status 'mencari_driver'
     * yang belum diassign ke driver manapun, dan hanya untuk cabang
     * driver yang sedang login.
     */
    public function getLatestAntrian(Request $request)
    {
        $user = Auth::check() ? Auth::user() : \App\Models\User::where('role', 'kurir')->first();
        $kurir = $user ? Kurir::where('id_pengguna', $user->id_pengguna)->first() : null;
        $idCabang = $kurir ? $kurir->id_cabang : 0;

        $antrianTugas = Pesanan::whereNull('id_kurir')
            ->where('status_pesanan', 'mencari_driver')
            ->where('id_cabang', $idCabang)
            ->with(['cabang', 'pelanggan.user'])
            ->orderBy('created_at', 'asc')                   // FCFS: yang paling lama menunggu duluan
            ->get();

        if ($request->wantsJson()) {
            $formatted = $antrianTugas->map(function ($p) {
                return [
                    'id'       => $p->id_pesanan,
                    'location' => 'GUDANG ' . strtoupper($p->cabang->nama_cabang ?? 'PUSAT'),
                    'time'     => $p->created_at->format('H:i') . ' WIB',
                    'customer' => strtoupper($p->pelanggan->user->name ?? 'PELANGGAN'),
                    'status'   => $p->status_pesanan, // bisa dipakai frontend untuk badge
                ];
            });

            return response()->json($formatted);
        }

        return view('driver.components.stacked-cards-partial', compact('antrianTugas'));
    }
}