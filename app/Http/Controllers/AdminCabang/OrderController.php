<?php

namespace App\Http\Controllers\AdminCabang;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\ProdukCabang;
use App\Models\Kurir;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\InvoiceMail;

class OrderController extends Controller
{
    private function getIdCabang(): int
    {
        return auth()->user()?->adminCabang?->id_cabang ?? 1;
    }


    private function pesananMilikCabang(int|string $id): ?Pesanan
    {
        return Pesanan::where('id_pesanan', $id)
            ->where('id_cabang', $this->getIdCabang())
            ->first();
    }

    public function index(Request $request)
    {
        $idCabang  = $this->getIdCabang();

        // Lazy auto-complete orders that have been 'diterima' for more than 24 hours
        $expiredOrders = Pesanan::where('status_pesanan', 'diterima')
            ->where('id_cabang', $idCabang)
            ->where('updated_at', '<=', now()->subHours(24))
            ->get();
        foreach ($expiredOrders as $ep) {
            $ep->update(['status_pesanan' => 'selesai']);
            \App\Models\PengirimanTracking::create([
                'id_pesanan' => $ep->id_pesanan,
                'status' => 'selesai',
                'keterangan' => 'Pesanan otomatis diselesaikan oleh sistem setelah 24 jam'
            ]);
        }

        $search       = $request->query('search');
        $status       = $request->query('status');
        $driverFilter = $request->query('driver_filter');
        $sort         = $request->query('sort', 'tanggal_pemesanan');
        $direction    = $request->query('direction', 'desc');
        $date         = $request->query('date');

        $query = Pesanan::query()
            ->with(['pelanggan.user', 'kurir.user', 'details.produk'])
            ->where('id_cabang', $idCabang);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('pelanggan.user', fn($q2) =>
                    $q2->where('nama', 'like', "%{$search}%")
                )->orWhere('id_pesanan', 'like', '%' . ltrim($search, '#BRM-90') . '%');
            });
        }

        $validStatus = ['Menunggu', 'Disiapkan', 'mencari_driver', 'diterima_driver', 'diambil', 'dalam_pengiriman', 'diterima', 'selesai', 'gagal', 'ditolak_driver'];
        if ($status && in_array($status, $validStatus)) {
            $query->where('status_pesanan', $status);
        }

        if ($driverFilter === 'ada') {
            $query->whereNotNull('id_kurir');
        } elseif ($driverFilter === 'tidak') {
            $query->whereNull('id_kurir');
        }

        if ($date) {
            $query->whereDate('tanggal_pemesanan', $date);
        }

        $allowedSort = ['id_pesanan', 'tanggal_pemesanan', 'total_tagihan', 'status_pesanan'];
        if (in_array($sort, $allowedSort)) {
            $query->orderBy($sort, $direction);
        }

        $allCabangOrders = Pesanan::where('id_cabang', $idCabang)->get();
        $pesanans        = $query->paginate(10)->withQueryString();

        return view('admin-cabang.daftar-pesanan', compact('pesanans', 'allCabangOrders'));
    }

    public function show(string $id)
    {
        $pesanan = Pesanan::with([
            'pelanggan.user', 'kurir.user',
            'details.produk', 'promo', 'cabang',
        ])
        ->where('id_cabang', $this->getIdCabang())
        ->where('id_pesanan', $id)
        ->firstOrFail();

        return view('admin-cabang.detail-pesanan', compact('pesanan'));
    }

    public function showJson(string $id)
    {
        $pesanan = Pesanan::with(['pelanggan.user', 'details.produk', 'kurir.user'])
            ->where('id_cabang', $this->getIdCabang())
            ->where('id_pesanan', $id)
            ->firstOrFail();

        return response()->json([
            'id'          => $pesanan->id_pesanan,
            'order_id'    => '#BRM-9' . str_pad($pesanan->id_pesanan, 3, '0', STR_PAD_LEFT),
            'customer'    => $pesanan->pelanggan->user->nama ?? '-',
            'phone'       => $pesanan->pelanggan->user->no_telepon ?? '-',
            'alamat'      => $pesanan->alamat_pengiriman,
            'tanggal'     => Carbon::parse($pesanan->tanggal_pemesanan)->format('d M Y, H:i'),
            'metode'      => $pesanan->metode_pembayaran,
            'total'       => $pesanan->total_tagihan,
            'total_fmt'   => 'Rp ' . number_format($pesanan->total_tagihan, 0, ',', '.'),
            'status'      => $pesanan->status_pesanan,
            'items'       => $pesanan->details->map(fn($d) => [
                'nama'     => $d->produk->nama_produk ?? '-',
                'jumlah'   => $d->jumlah,
                'harga'    => $d->harga_satuan,
                'harga_fmt'=> 'Rp ' . number_format($d->harga_satuan, 0, ',', '.'),
                'subtotal' => $d->subtotal,
                'sub_fmt'  => 'Rp ' . number_format($d->subtotal, 0, ',', '.'),
            ]),
        ]);
    }

    public function nota(string $id)
    {
        $pesanan = Pesanan::with(['pelanggan.user', 'details.produk', 'kurir.user', 'cabang'])
            ->where('id_cabang', $this->getIdCabang())
            ->where('id_pesanan', $id)
            ->firstOrFail();

        return view('admin-cabang.nota-pesanan', compact('pesanan'));
    }

    public function confirm(string $id)
    {
        $pesanan = $this->pesananMilikCabang($id);
        if (!$pesanan) return back()->with('error', 'Pesanan tidak ditemukan.');
        if ($pesanan->status_pesanan !== 'Menunggu') return back()->with('error', 'Pesanan tidak dalam status Menunggu Konfirmasi.');

        $pesanan->update(['status_pesanan' => 'Disiapkan']);

        // Eager load relations for invoice email
        $pesanan->load(['pelanggan.user', 'details.produk', 'cabang']);

        // Kirim email invoice otomatis ke pelanggan
        try {
            if ($pesanan->pelanggan && $pesanan->pelanggan->user && $pesanan->pelanggan->user->email) {
                Mail::to($pesanan->pelanggan->user->email)->send(new InvoiceMail($pesanan));
            }
        } catch (\Exception $e) {
            Log::error('Gagal mengirim email invoice pesanan #' . $pesanan->id_pesanan . ': ' . $e->getMessage());
        }

        return back()->with('success', '#BRM-9' . str_pad($id, 3, '0', STR_PAD_LEFT) . ' dikonfirmasi dan email invoice telah dikirim.');
    }

    public function dispatch(string $id)
    {
        $pesanan  = $this->pesananMilikCabang($id);
        if (!$pesanan) return back()->with('error', 'Pesanan tidak ditemukan.');
        if ($pesanan->status_pesanan !== 'Disiapkan') return back()->with('error', 'Pesanan harus berstatus Disiapkan.');

        $pesanan->update([
            'id_kurir'       => null,
            'status_pesanan' => 'mencari_driver',
            'estimasi_tiba'  => now()->addHours(2),
        ]);

        return back()->with('success', 'Mencari kurir untuk pesanan #BRM-9' . str_pad($id, 3, '0', STR_PAD_LEFT));
    }

    public function cancelDispatch(string $id)
    {
        $pesanan = $this->pesananMilikCabang($id);
        if (!$pesanan || $pesanan->status_pesanan !== 'mencari_driver') {
            return back()->with('error', 'Tidak dapat membatalkan pengiriman ini.');
        }
        if ($pesanan->kurir) $pesanan->kurir->update(['status_mengirim' => 'Tidak Mengirim']);

        $pesanan->update(['id_kurir' => null, 'status_pesanan' => 'Disiapkan', 'estimasi_tiba' => null]);
        return back()->with('success', 'Pencarian kurir dibatalkan.');
    }

    public function driverAccept(string $id)
    {
        $pesanan = Pesanan::with('kurir')->where('id_pesanan', $id)->firstOrFail();
        if ($pesanan->status_pesanan !== 'mencari_driver') {
            return response()->json(['message' => 'Status pesanan tidak valid.'], 422);
        }
        $pesanan->update(['status_pesanan' => 'dalam_pengiriman']);
        return response()->json(['message' => 'Kurir mengkonfirmasi pengambilan.', 'status' => 'dalam_pengiriman', 'order_id' => $id]);
    }

    public function complete(string $id)
    {
        $pesanan = Pesanan::with(['details', 'kurir'])->where('id_pesanan', $id)->firstOrFail();
        if (!in_array($pesanan->status_pesanan, ['dalam_pengiriman', 'diterima'])) {
            if (request()->expectsJson()) return response()->json(['message' => 'Pesanan tidak dalam status Sedang Dikirim atau Tiba.'], 422);
            return back()->with('error', 'Pesanan harus berstatus Sedang Dikirim atau Tiba.');
        }

        // If transitioning from dalam_pengiriman, set default proof if not present
        if ($pesanan->status_pesanan === 'dalam_pengiriman') {
            $pesanan->bukti_pengiriman = request('bukti') ?? 'confirmed_by_admin';
        }
        
        $pesanan->status_pesanan = 'selesai';
        $pesanan->save();

        if ($pesanan->kurir) {
            $pesanan->kurir->update(['status_mengirim' => 'Tidak Mengirim']);
        }

        \App\Models\PengirimanTracking::create([
            'id_pesanan' => $id,
            'status' => 'selesai',
            'keterangan' => 'Pesanan dikonfirmasi selesai oleh Admin Cabang'
        ]);

        if (request()->expectsJson()) return response()->json(['message' => 'Pesanan selesai.', 'status' => 'Selesai', 'order_id' => $id]);
        return back()->with('success', 'Pesanan #BRM-9' . str_pad($id, 3, '0', STR_PAD_LEFT) . ' telah diselesaikan.');
    }

    public function driverNotifikasi(string $kurirId)
    {
        $pesanan = Pesanan::with('pelanggan.user')
            ->where('id_kurir', $kurirId)
            ->whereIn('status_pesanan', ['mencari_driver', 'diterima_driver', 'diambil', 'dalam_pengiriman'])
            ->orderByDesc('created_at')->get();
        return response()->json($pesanan);
    }

    public function publicNota(string $id)
    {
        $pesanan = Pesanan::with(['pelanggan.user', 'details.produk', 'kurir.user', 'cabang'])
            ->where('id_pesanan', $id)
            ->firstOrFail();

        $user = auth()->user();

        // SECURITY: Harus login terlebih dahulu
        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login untuk melihat nota pesanan.');
        }

        $role = strtolower($user->role ?? '');

        // Super Admin / Admin Super / Staf Operasional → akses penuh
        if (in_array($role, ['super admin', 'admin super', 'staf operasional'])) {
            return view('admin-cabang.nota-pesanan', compact('pesanan'));
        }

        // Admin Cabang → hanya bisa akses nota dari cabangnya sendiri
        if (in_array($role, ['admin cabang', 'admin'])) {
            $idCabangAdmin = $user?->adminCabang?->id_cabang;
            if ($idCabangAdmin && $pesanan->id_cabang === $idCabangAdmin) {
                return view('admin-cabang.nota-pesanan', compact('pesanan'));
            }
            abort(403, 'Anda tidak memiliki akses ke nota pesanan ini.');
        }

        // Pelanggan → hanya bisa akses nota pesanannya sendiri
        $idPelanggan = $user?->pelanggan?->id_pelanggan;
        if ($idPelanggan && $pesanan->id_pelanggan === $idPelanggan) {
            return view('admin-cabang.nota-pesanan', compact('pesanan'));
        }

        abort(403, 'Anda tidak memiliki akses ke nota pesanan ini.');
    }
}
