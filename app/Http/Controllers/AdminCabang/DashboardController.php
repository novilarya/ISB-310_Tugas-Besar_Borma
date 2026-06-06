<?php

namespace App\Http\Controllers\AdminCabang;

use App\Http\Controllers\Controller;
use App\Models\ProdukCabang;
use App\Models\Pesanan;
use App\Models\Pelanggan;
use App\Models\Promo;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    private function getIdCabang(): int
    {
        return auth()->user()?->adminCabang?->id_cabang ?? 1;
    }

    public function index()
    {
        $idCabang = $this->getIdCabang();
        $today    = now()->startOfDay();
        $week     = now()->startOfWeek();
        $month    = now()->startOfMonth();

        // ── KPI Penjualan ───────────────────────────────────────────────
        $allOrders = Pesanan::where('id_cabang', $idCabang)->get();

        $todaySales   = $allOrders->filter(fn($o) => $o->tanggal_pemesanan && $o->tanggal_pemesanan >= $today)->sum('total_tagihan');
        $weeklySales  = $allOrders->filter(fn($o) => $o->tanggal_pemesanan && $o->tanggal_pemesanan >= $week)->sum('total_tagihan');
        $monthlySales = $allOrders->filter(fn($o) => $o->tanggal_pemesanan && $o->tanggal_pemesanan >= $month)->sum('total_tagihan');

        $pendingOrders   = $allOrders->where('status_pesanan', 'Menunggu')->count();
        $processOrders   = $allOrders->whereIn('status_pesanan', ['Disiapkan', 'mencari_driver', 'diterima_driver', 'diambil', 'dalam_pengiriman', 'diterima'])->count();
        $completedOrders = $allOrders->where('status_pesanan', 'selesai')->count();

        // ── Produk Cabang ───────────────────────────────────────────────
        $produkCabangs = ProdukCabang::with('produk')
            ->where('id_cabang', $idCabang)
            ->get();
        $totalProduk = $produkCabangs->count();
        $stokKritis  = $produkCabangs->where('jumlah_stok', '<', 20)->count();

        // ── Member ──────────────────────────────────────────────────────
        $totalCustomers = Pelanggan::where('status_member', true)->count();
        $memberMingguIni = Pelanggan::where('status_member', true)->where('created_at', '>=', $week)->count();

        // ── Promo & Voucher ─────────────────────────────────────────────
        $todayStr  = now()->toDateString();
        $promoAktif = Promo::where('id_cabang', $idCabang)
            ->where('tanggal_mulai', '<=', $todayStr)
            ->where('tanggal_berakhir', '>=', $todayStr)
            ->count();
        
        $promoQuota = Promo::where('id_cabang', $idCabang)->sum('kuota_promo');
        $promoDigunakan = $allOrders->whereNotNull('id_promo')->count();

        // ── Poin & Reward ───────────────────────────────────────────────
        $totalDiskon = $allOrders->sum('diskon_voucher');
        $totalGratisOngkir = $allOrders->where('biaya_pengiriman', 0)->count();

        // ── Pesanan Terbaru (5) ─────────────────────────────────────────
        $pesananTerbaru = Pesanan::with('pelanggan.user')
            ->where('id_cabang', $idCabang)
            ->orderByDesc('tanggal_pemesanan')
            ->limit(5)
            ->get();

        // ── Produk Stok Tipis ───────────────────────────────────────────
        $produkStokTipis = ProdukCabang::with('produk')
            ->where('id_cabang', $idCabang)
            ->where('jumlah_stok', '<', 20)
            ->orderBy('jumlah_stok')
            ->limit(5)
            ->get();

        // ── Chart Trend Penjualan 7 Hari ────────────────────────────────
        $chartLabels = [];
        $chartData   = [];
        for ($i = 6; $i >= 0; $i--) {
            $day = Carbon::today()->subDays($i);
            $chartLabels[] = $day->translatedFormat('D, d M') ?: $day->format('D, d M');
            $start = $day->copy()->startOfDay();
            $end = $day->copy()->endOfDay();
            $chartData[] = (float) $allOrders->filter(function ($order) use ($start, $end) {
                return $order->tanggal_pemesanan && $order->tanggal_pemesanan->between($start, $end);
            })->sum('total_tagihan');
        }

        // ── Top 5 Kategori Terjual (Pie Chart) ──────────────────────────
        $topKategori = DB::table('pesanan_produk')
            ->join('produk', 'pesanan_produk.id_produk', '=', 'produk.id_produk')
            ->join('pesanan', 'pesanan_produk.id_pesanan', '=', 'pesanan.id_pesanan')
            ->where('pesanan.id_cabang', $idCabang)
            ->select('produk.kategori', DB::raw('SUM(pesanan_produk.subtotal) as total'))
            ->groupBy('produk.kategori')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        $pieLabels = $topKategori->pluck('kategori')->toArray();
        $pieData   = $topKategori->pluck('total')->map(fn($v) => (float)$v)->toArray();

        // ── Top 2 Produk Terlaris (by jumlah_terjual di produk_cabangs) ─
        $topTerlaris = ProdukCabang::with('produk')
            ->where('id_cabang', $idCabang)
            ->orderByDesc('jumlah_terjual')
            ->limit(2)
            ->get();

        // ── Member Insights (Top Spenders di Cabang ini) ──────────────
        $topMembers = DB::table('pesanan')
            ->join('pelanggan', 'pesanan.id_pelanggan', '=', 'pelanggan.id_pelanggan')
            ->join('pengguna', 'pelanggan.id_pengguna', '=', 'pengguna.id_pengguna')
            ->where('pesanan.id_cabang', $idCabang)
            ->where('pelanggan.status_member', true)
            ->select('pengguna.nama', DB::raw('COUNT(pesanan.id_pesanan) as total_transaksi'), DB::raw('SUM(pesanan.total_tagihan) as total_spent'))
            ->groupBy('pengguna.id_pengguna', 'pengguna.nama')
            ->orderByDesc('total_spent')
            ->limit(2)
            ->get();

        // ── Informasi Cabang ──────────────────────────────────────────
        $cabangInfo = auth()->user()?->adminCabang?->cabang ?? \App\Models\Cabang::find($idCabang);

        return view('admin-cabang.dashboard', compact(
            'todaySales', 'weeklySales', 'monthlySales',
            'pendingOrders', 'processOrders', 'completedOrders',
            'totalProduk', 'stokKritis', 'totalCustomers', 'promoAktif',
            'pesananTerbaru', 'produkStokTipis', 'produkCabangs', 'allOrders',
            'chartLabels', 'chartData',
            'pieLabels', 'pieData',
            'topTerlaris', 'topMembers', 'cabangInfo',
            'memberMingguIni', 'promoQuota', 'promoDigunakan', 'totalDiskon', 'totalGratisOngkir'
        ));
    }

    public function notifikasi()
    {
        return view('admin-cabang.notifikasi');
    }
}
