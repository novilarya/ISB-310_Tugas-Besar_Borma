<?php

namespace App\Http\Controllers\AdminCabang;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\PesananProduk;
use App\Models\ProdukCabang;
use App\Models\Pelanggan;
use App\Models\Cabang;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    private function getIdCabang(): int
    {
        return auth()->user()?->adminCabang?->id_cabang ?? 1;
    }

    /**
     * READ — Halaman laporan utama dengan ringkasan dan filter periode.
     */
    public function index(Request $request)
    {
        $idCabang = $this->getIdCabang();

        // Periode filter (default: bulan ini)
        $bulan  = (int) $request->get('bulan', now()->month);
        $tahun  = (int) $request->get('tahun', now()->year);
        $mulai  = Carbon::create($tahun, $bulan, 1)->startOfMonth();
        $akhir  = Carbon::create($tahun, $bulan, 1)->endOfMonth();

        // Info cabang
        $cabang = Cabang::find($idCabang);

        // ── KPI Bulan Ini ───────────────────────────────────────────────
        $pesananBulanIni = Pesanan::where('id_cabang', $idCabang)
            ->whereBetween('tanggal_pemesanan', [$mulai, $akhir]);

        $totalPendapatan   = (clone $pesananBulanIni)->where('status_pesanan', 'Diterima')->sum('total_tagihan');
        $totalPesanan      = (clone $pesananBulanIni)->count();
        $pesananSelesai    = (clone $pesananBulanIni)->where('status_pesanan', 'Diterima')->count();
        $totalDiskon       = (clone $pesananBulanIni)->where('status_pesanan', 'Diterima')->sum('diskon_voucher');
        $rataTagihan       = $pesananSelesai > 0 ? $totalPendapatan / $pesananSelesai : 0;

        // ── Penjualan Harian (untuk chart) ──────────────────────────────
        $penjualanHarian = Pesanan::where('id_cabang', $idCabang)
            ->whereBetween('tanggal_pemesanan', [$mulai, $akhir])
            ->where('status_pesanan', 'Diterima')
            ->selectRaw('DATE(tanggal_pemesanan) as tanggal, SUM(total_tagihan) as total, COUNT(*) as jumlah')
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        // ── Produk Terlaris Bulan Ini ────────────────────────────────────
        $produkTerlaris = PesananProduk::query()
            ->join('pesanans', 'pesanan_produks.id_pesanan', '=', 'pesanans.id_pesanan')
            ->join('produks', 'pesanan_produks.id_produk', '=', 'produks.id_produk')
            ->where('pesanans.id_cabang', $idCabang)
            ->whereBetween('pesanans.tanggal_pemesanan', [$mulai, $akhir])
            ->where('pesanans.status_pesanan', 'Diterima')
            ->selectRaw('produks.id_produk, produks.nama_produk, produks.kategori, SUM(pesanan_produks.jumlah) as total_terjual, SUM(pesanan_produks.subtotal) as total_revenue')
            ->groupBy('produks.id_produk', 'produks.nama_produk', 'produks.kategori')
            ->orderByDesc('total_terjual')
            ->limit(10)
            ->get();

        // ── Penjualan per Kategori ────────────────────────────────────────
        $penjualanKategori = PesananProduk::query()
            ->join('pesanans', 'pesanan_produks.id_pesanan', '=', 'pesanans.id_pesanan')
            ->join('produks', 'pesanan_produks.id_produk', '=', 'produks.id_produk')
            ->where('pesanans.id_cabang', $idCabang)
            ->whereBetween('pesanans.tanggal_pemesanan', [$mulai, $akhir])
            ->where('pesanans.status_pesanan', 'Diterima')
            ->selectRaw('produks.kategori, SUM(pesanan_produks.subtotal) as total_revenue, SUM(pesanan_produks.jumlah) as total_item')
            ->groupBy('produks.kategori')
            ->orderByDesc('total_revenue')
            ->get();

        // ── Rekap Pesanan per Status ──────────────────────────────────────
        $rekapStatus = Pesanan::where('id_cabang', $idCabang)
            ->whereBetween('tanggal_pemesanan', [$mulai, $akhir])
            ->selectRaw('status_pesanan, COUNT(*) as jumlah, SUM(total_tagihan) as total')
            ->groupBy('status_pesanan')
            ->get()
            ->keyBy('status_pesanan');

        // ── Metode Pembayaran ────────────────────────────────────────────
        $rekapPembayaran = Pesanan::where('id_cabang', $idCabang)
            ->whereBetween('tanggal_pemesanan', [$mulai, $akhir])
            ->where('status_pesanan', 'Diterima')
            ->selectRaw('metode_pembayaran, COUNT(*) as jumlah, SUM(total_tagihan) as total')
            ->groupBy('metode_pembayaran')
            ->get();

        // ── Stok Kritis Cabang ────────────────────────────────────────────
        $stokKritis = ProdukCabang::with('produk')
            ->where('id_cabang', $idCabang)
            ->where('jumlah_stok', '<', 20)
            ->orderBy('jumlah_stok')
            ->get();

        // ── Daftar Transaksi Lengkap (Paginated) ─────────────────────────
        $semuaPesanan = Pesanan::with(['pelanggan.user', 'details'])
            ->where('id_cabang', $idCabang)
            ->whereBetween('tanggal_pemesanan', [$mulai, $akhir])
            ->orderByDesc('tanggal_pemesanan')
            ->paginate(15)
            ->withQueryString();

        // Opsi bulan/tahun untuk filter
        $daftarTahun = range(now()->year, now()->year - 3);
        $daftarBulan = [
            1=>'Januari', 2=>'Februari', 3=>'Maret', 4=>'April',
            5=>'Mei', 6=>'Juni', 7=>'Juli', 8=>'Agustus',
            9=>'September', 10=>'Oktober', 11=>'November', 12=>'Desember',
        ];

        return view('admin-cabang.laporan-cabang', compact(
            'cabang', 'bulan', 'tahun', 'mulai', 'akhir',
            'totalPendapatan', 'totalPesanan', 'pesananSelesai',
            'totalDiskon', 'rataTagihan',
            'penjualanHarian', 'produkTerlaris', 'penjualanKategori',
            'rekapStatus', 'rekapPembayaran', 'stokKritis',
            'semuaPesanan', 'daftarTahun', 'daftarBulan'
        ));
    }

    /**
     * EXPORT — Download laporan transaksi berformat CSV.
     */
    public function exportCsv(Request $request)
    {
        $idCabang = $this->getIdCabang();
        $bulan  = (int) $request->get('bulan', now()->month);
        $tahun  = (int) $request->get('tahun', now()->year);
        $mulai  = Carbon::create($tahun, $bulan, 1)->startOfMonth();
        $akhir  = Carbon::create($tahun, $bulan, 1)->endOfMonth();

        $pesanan = Pesanan::with(['pelanggan.user', 'details'])
            ->where('id_cabang', $idCabang)
            ->whereBetween('tanggal_pemesanan', [$mulai, $akhir])
            ->orderByDesc('tanggal_pemesanan')
            ->get();

        $filename = "laporan_transaksi_{$tahun}_{$bulan}.csv";
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use ($pesanan) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['No. Pesanan', 'Tanggal', 'Pelanggan', 'Total Item', 'Total Belanja', 'Diskon', 'Total Tagihan', 'Pembayaran', 'Status']);

            foreach ($pesanan as $p) {
                fputcsv($file, [
                    "#BRM-9" . str_pad($p->id_pesanan, 3, '0', STR_PAD_LEFT),
                    Carbon::parse($p->tanggal_pemesanan)->format('Y-m-d H:i:s'),
                    $p->pelanggan->user->nama ?? '-',
                    $p->details->sum('jumlah'),
                    $p->total_belanja,
                    $p->diskon_voucher,
                    $p->total_tagihan,
                    $p->metode_pembayaran,
                    $p->status_pesanan
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
