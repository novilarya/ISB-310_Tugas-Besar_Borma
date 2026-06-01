<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PromoController extends Controller
{
    public function promo(Request $request)
    {
        $search    = $request->query('search');
        $status    = $request->query('status');
        $sort      = $request->query('sort', 'tanggal_mulai');
        $direction = $request->query('direction', 'desc');
        $cabangId  = $request->query('id_cabang');

        $query = \App\Models\Promo::query()->with(['produkPemicu', 'produkHadiah', 'cabang']);

        if ($cabangId) {
            if ($cabangId === 'global') {
                $query->whereNull('id_cabang');
            } else {
                $query->where('id_cabang', $cabangId);
            }
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_voucher', 'like', '%' . $search . '%')
                  ->orWhere('kode_voucher', 'like', '%' . $search . '%');
            });
        }

        $today = now()->toDateString();
        if ($status === 'aktif') {
            $query->where('tanggal_mulai', '<=', $today)->where('tanggal_berakhir', '>=', $today);
        } elseif ($status === 'terjadwal') {
            $query->where('tanggal_mulai', '>', $today);
        } elseif ($status === 'berakhir') {
            $query->where('tanggal_berakhir', '<', $today);
        }

        $totalAktif    = \App\Models\Promo::where('tanggal_mulai', '<=', $today)->where('tanggal_berakhir', '>=', $today)->count();
        $totalTerjadwal = \App\Models\Promo::where('tanggal_mulai', '>', $today)->count();
        $totalBerakhir = \App\Models\Promo::where('tanggal_berakhir', '<', $today)->count();

        $allowedSort = ['nama_voucher', 'tanggal_mulai', 'tanggal_berakhir', 'potongan_harga', 'kuota_promo'];
        if (in_array($sort, $allowedSort)) {
            $query->orderBy($sort, $direction);
        }

        $promos = $query->paginate(7)->withQueryString();

        $produkList = \App\Models\Produk::all();
        $cabangList = \App\Models\Cabang::all();

        return view('super-admin.promo', compact(
            'promos', 'totalAktif', 'totalTerjadwal', 'totalBerakhir', 'produkList', 'cabangList'
        ));
    }

    public function storePromo(Request $request)
    {
        $request->validate([
            'id_cabang'         => 'nullable|exists:cabangs,id_cabang',
            'nama_voucher'      => 'required|string|max:255',
            'kode_voucher'      => 'nullable|string|max:50|unique:promos,kode_voucher',
            'id_produk_pemicu'  => 'required|exists:produks,id_produk',
            'id_produk_hadiah'  => 'nullable|exists:produks,id_produk',
            'kuantitas_pemicu'  => 'required|integer|min:1',
            'kuantitas_hadiah'  => 'nullable|integer|min:0',
            'potongan_harga'    => 'nullable|numeric|min:0',
            'min_transaksi'     => 'nullable|numeric|min:0',
            'max_promo'         => 'nullable|numeric|min:0',
            'kuota_promo'       => 'required|integer|min:1',
            'tanggal_mulai'     => 'required|date',
            'tanggal_berakhir'  => 'required|date|after_or_equal:tanggal_mulai',
        ], [
            'kode_voucher.unique'      => 'Kode voucher sudah digunakan.',
            'tanggal_berakhir.after_or_equal' => 'Tanggal berakhir harus sama atau setelah tanggal mulai.',
        ]);

        \App\Models\Promo::create([
            'id_cabang'        => $request->id_cabang ?: null,
            'nama_voucher'     => $request->nama_voucher,
            'kode_voucher'     => $request->kode_voucher ? strtoupper($request->kode_voucher) : null,
            'id_produk_pemicu' => $request->id_produk_pemicu,
            'id_produk_hadiah' => $request->id_produk_hadiah ?: null,
            'kuantitas_pemicu' => $request->kuantitas_pemicu,
            'kuantitas_hadiah' => $request->kuantitas_hadiah ?? 0,
            'potongan_harga'   => $request->potongan_harga ?? 0,
            'min_transaksi'    => $request->min_transaksi ?? 0,
            'max_promo'        => $request->max_promo ?? 0,
            'kuota_promo'      => $request->kuota_promo,
            'tanggal_mulai'    => $request->tanggal_mulai,
            'tanggal_berakhir' => $request->tanggal_berakhir,
        ]);

        return redirect()->route('superadmin.promo')->with('success', 'Promo berhasil dibuat.');
    }

    public function updatePromo(Request $request, $id)
    {
        $promo = \App\Models\Promo::findOrFail($id);

        $request->validate([
            'id_cabang'         => 'nullable|exists:cabangs,id_cabang',
            'nama_voucher'      => 'required|string|max:255',
            'kode_voucher'      => 'nullable|string|max:50|unique:promos,kode_voucher,' . $id . ',id_promo',
            'id_produk_pemicu'  => 'required|exists:produks,id_produk',
            'id_produk_hadiah'  => 'nullable|exists:produks,id_produk',
            'kuantitas_pemicu'  => 'required|integer|min:1',
            'kuantitas_hadiah'  => 'nullable|integer|min:0',
            'potongan_harga'    => 'nullable|numeric|min:0',
            'min_transaksi'     => 'nullable|numeric|min:0',
            'max_promo'         => 'nullable|numeric|min:0',
            'kuota_promo'       => 'required|integer|min:1',
            'tanggal_mulai'     => 'required|date',
            'tanggal_berakhir'  => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        $promo->update([
            'id_cabang'        => $request->id_cabang ?: null,
            'nama_voucher'     => $request->nama_voucher,
            'kode_voucher'     => $request->kode_voucher ? strtoupper($request->kode_voucher) : null,
            'id_produk_pemicu' => $request->id_produk_pemicu,
            'id_produk_hadiah' => $request->id_produk_hadiah ?: null,
            'kuantitas_pemicu' => $request->kuantitas_pemicu,
            'kuantitas_hadiah' => $request->kuantitas_hadiah ?? 0,
            'potongan_harga'   => $request->potongan_harga ?? 0,
            'min_transaksi'    => $request->min_transaksi ?? 0,
            'max_promo'        => $request->max_promo ?? 0,
            'kuota_promo'      => $request->kuota_promo,
            'tanggal_mulai'    => $request->tanggal_mulai,
            'tanggal_berakhir' => $request->tanggal_berakhir,
        ]);

        return redirect()->route('superadmin.promo')->with('success', 'Promo berhasil diperbarui.');
    }

    public function destroyPromo($id)
    {
        $promo = \App\Models\Promo::findOrFail($id);
        $promo->delete();

        return redirect()->route('superadmin.promo')->with('success', 'Promo berhasil dihapus.');
    }
}
