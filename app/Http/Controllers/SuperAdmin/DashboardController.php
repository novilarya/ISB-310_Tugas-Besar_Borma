<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cabang;
use App\Models\Produk;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPesanan = \App\Models\Pesanan::count();
        $pengirimanAktif = \App\Models\Pesanan::whereIn('status_pesanan', ['Disiapkan', 'Sedang Dikirim'])->count();
        $totalCabang = Cabang::where('status', 'Aktif')->count();
        $promoAktif = \App\Models\Promo::where('tanggal_mulai', '<=', now())->where('tanggal_berakhir', '>=', now())->count();
        $penggunaanVoucher = \App\Models\Pesanan::where('diskon_voucher', '>', 0)->count();

        $armadaAktif = \App\Models\Kurir::where('status_aktif', 'Aktif')->count();
        $totalKurir  = \App\Models\Kurir::count();
        $menungguPickup = \App\Models\Pesanan::whereIn('status_pesanan', ['Menunggu', 'Disiapkan'])->count();

        $overviewCabang = Cabang::withSum('pesanan as pesanan_sum_total_tagihan', 'total_tagihan')
            ->get()
            ->map(function($c) {
                return (object) [
                    'nama_cabang' => $c->nama_cabang,
                    'pesanan_sum_total_tagihan' => $c->pesanan_sum_total_tagihan ?? 0
                ];
            })->sortByDesc('pesanan_sum_total_tagihan')->take(5);

        $produkPopuler = Produk::withSum('details as total_terjual', 'jumlah')
            ->get()
            ->map(function($p) {
                return (object) [
                    'produk' => $p,
                    'total_terjual' => $p->total_terjual ?? 0
                ];
            })->sortByDesc('total_terjual')->take(5);

        $pesananTerbaru = \App\Models\Pesanan::with('pelanggan.user')
            ->orderBy('tanggal_pemesanan', 'desc')
            ->take(5)
            ->get()
            ->map(function($p) {
                return (object) [
                    'id' => 'ORD-' . str_pad($p->id_pesanan, 4, '0', STR_PAD_LEFT),
                    'pelanggan' => $p->pelanggan->user->nama ?? '-',
                    'total' => $p->total_tagihan,
                    'status' => $p->status_pesanan
                ];
            });

        return view('super-admin.dashboard', compact(
            'totalPesanan', 
            'pengirimanAktif', 
            'totalCabang', 
            'promoAktif', 
            'penggunaanVoucher',
            'overviewCabang', 
            'produkPopuler',
            'pesananTerbaru',
            'armadaAktif',
            'totalKurir',
            'menungguPickup'
        ));
    }
}
