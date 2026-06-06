<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Models\Kurir;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RiwayatController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::check() ? Auth::user() : \App\Models\User::where('role', 'kurir')->first();
        
        if (!$user) {
            return view('driver.riwayat.index', [
                'riwayat' => [],
                'kurir' => null,
            ]);
        }

        $kurir = Kurir::where('id_pengguna', $user->id_pengguna)->with(['cabang', 'user'])->first();

        if (!$kurir) {
            return view('driver.riwayat.index', [
                'riwayat' => [],
                'kurir' => null,
            ]);
        }

        $query = Pesanan::where('id_kurir', $kurir->id_kurir)
            ->whereIn('status_pesanan', ['diterima', 'selesai', 'gagal', 'ditolak_driver'])
            ->with(['pelanggan.user', 'cabang']);

        if ($request->has('status') && $request->status) {
            if ($request->status === 'diterima') {
                $query->whereIn('status_pesanan', ['diterima', 'selesai']);
            } else {
                $query->where('status_pesanan', $request->status);
            }
        }

        $riwayat = $query->orderBy('updated_at', 'desc')->get();

        return view('driver.riwayat.index', compact('riwayat', 'kurir'));
    }

    public function show($id)
    {
        $pesanan = Pesanan::with([
            'pelanggan.user', 
            'cabang', 
            'details.produk',
            'pengirimanTracking',
            'penolakanPengiriman'
        ])->findOrFail($id);

        return view('driver.pengiriman.detail', compact('pesanan'));
    }
}
