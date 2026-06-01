<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;

class PesananController extends Controller
{
    public function pesanan()
    {
        $pesanan = \App\Models\Pesanan::with(['pelanggan.user', 'cabang'])->orderBy('tanggal_pemesanan', 'desc')->get();

        return view('super-admin.pesanan', compact('pesanan'));
    }

    public function pesananDetail($id)
    {
        $pesanan = \App\Models\Pesanan::with(['pelanggan.user', 'cabang', 'kurir.user', 'details.produk'])
            ->findOrFail($id);

        return view('super-admin.pesanan-detail', compact('pesanan'));
    }
}
