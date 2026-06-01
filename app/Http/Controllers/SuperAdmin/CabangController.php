<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cabang;

class CabangController extends Controller
{
    public function cabang(\Illuminate\Http\Request $request)
    {
        $startDate = $request->input('start_date', \Carbon\Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', \Carbon\Carbon::now()->format('Y-m-d'));

        // Get all cabangs with their order count and sum of total_tagihan filtered by date
        $cabangs = Cabang::withCount(['pesanan' => function ($query) use ($startDate, $endDate) {
                $query->whereBetween('tanggal_pemesanan', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
            }])
            ->withSum(['pesanan as pendapatan' => function ($query) use ($startDate, $endDate) {
                $query->whereBetween('tanggal_pemesanan', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
            }], 'total_tagihan')
            ->get();

        $cabang = $cabangs->map(function($c) use ($startDate, $endDate) {
            // Get produk terlaris for this branch within date range
            $terlaris = \Illuminate\Support\Facades\DB::table('pesanan_produks')
                ->join('pesanans', 'pesanans.id_pesanan', '=', 'pesanan_produks.id_pesanan')
                ->join('produks', 'produks.id_produk', '=', 'pesanan_produks.id_produk')
                ->where('pesanans.id_cabang', $c->id_cabang)
                ->whereBetween('pesanans.tanggal_pemesanan', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
                ->select('produks.nama_produk', \Illuminate\Support\Facades\DB::raw('SUM(pesanan_produks.jumlah) as total_terjual'))
                ->groupBy('produks.id_produk', 'produks.nama_produk')
                ->orderByDesc('total_terjual')
                ->first();

            return (object) [
                'id' => $c->id_cabang,
                'nama_cabang' => $c->nama_cabang,
                'alamat_cabang' => $c->alamat_cabang,
                'koordinat_gps' => $c->koordinat_gps,
                'pendapatan' => $c->pendapatan ?? 0,
                'total_pesanan' => $c->pesanan_count ?? 0,
                'status' => $c->status ?? 'Aktif',
                'produk_terlaris' => $terlaris ? $terlaris->nama_produk : '-'
            ];
        });

        $sort = $request->input('sort', 'nama_asc');
        switch ($sort) {
            case 'nama_asc':
                $cabang = $cabang->sortBy('nama_cabang');
                break;
            case 'nama_desc':
                $cabang = $cabang->sortByDesc('nama_cabang');
                break;
            case 'pendapatan_asc':
                $cabang = $cabang->sortBy('pendapatan');
                break;
            case 'pendapatan_desc':
                $cabang = $cabang->sortByDesc('pendapatan');
                break;
            case 'pesanan_asc':
                $cabang = $cabang->sortBy('total_pesanan');
                break;
            case 'pesanan_desc':
                $cabang = $cabang->sortByDesc('total_pesanan');
                break;
            case 'status_asc':
                $cabang = $cabang->sortBy('status');
                break;
            case 'status_desc':
                $cabang = $cabang->sortByDesc('status');
                break;
        }

        return view('super-admin.cabang', compact('cabang'));
    }

    public function cabangDetail($id)
    {
        $cabang = Cabang::with(['adminCabangs.user'])->findOrFail($id);
        return view('super-admin.cabang-detail', compact('cabang'));
    }

    public function storeCabang(Request $request)
    {
        $request->validate([
            'nama_cabang' => 'required|string|max:255',
            'alamat_cabang' => 'required|string',
            'koordinat_gps' => 'required|string|max:255',
            'status' => 'required|string|in:Aktif,Tidak Aktif',
        ]);

        Cabang::create([
            'nama_cabang' => $request->nama_cabang,
            'alamat_cabang' => $request->alamat_cabang,
            'koordinat_gps' => $request->koordinat_gps,
            'status' => $request->status,
        ]);

        return redirect()->route('superadmin.cabang')->with('success', 'Cabang berhasil ditambahkan.');
    }

    public function updateCabang(Request $request, $id)
    {
        $request->validate([
            'nama_cabang' => 'required|string|max:255',
            'alamat_cabang' => 'required|string',
            'koordinat_gps' => 'required|string|max:255',
            'status' => 'required|string|in:Aktif,Tidak Aktif',
        ]);

        $cabang = Cabang::findOrFail($id);
        $cabang->update([
            'nama_cabang' => $request->nama_cabang,
            'alamat_cabang' => $request->alamat_cabang,
            'koordinat_gps' => $request->koordinat_gps,
            'status' => $request->status,
        ]);

        return redirect()->route('superadmin.cabang.detail', $id)->with('success', 'Cabang berhasil diperbarui.');
    }

    public function destroyCabang($id)
    {
        $cabang = Cabang::findOrFail($id);
        $cabang->delete();

        return redirect()->route('superadmin.cabang')->with('success', 'Cabang berhasil dihapus.');
    }
}
