<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Models\Kurir;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TugasController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::check() ? Auth::user() : \App\Models\User::where('role', 'kurir')->first();
        $kurir = $user ? Kurir::where('id_user', $user->id_user)->first() : null;

        $query = Pesanan::where('id_kurir', $kurir->id_kurir ?? 0)
            ->whereIn('status_pesanan', ['menunggu', 'diambil', 'dalam_pengiriman'])
            ->with(['pelanggan.user', 'cabang']);

        if ($request->has('status') && $request->status) {
            $query->where('status_pesanan', $request->status);
        }

        $tugas = $query->orderBy('created_at', 'desc')->get();

        return view('driver.tugas.index', compact('tugas'));
    }

    public function show($id)
    {
        $pesanan = Pesanan::with(['pelanggan.user', 'cabang', 'details.produk'])
            ->findOrFail($id);

        return view('driver.tugas.show', compact('pesanan'));
    }

    public function updateStatus(Request $request, $id)
    {
        $pesanan = Pesanan::findOrFail($id);

        $pesanan->status_pesanan = $request->status;

        // Handle bukti pengiriman upload
        if ($request->hasFile('bukti_pengiriman')) {
            $path = $request->file('bukti_pengiriman')->store('bukti-pengiriman', 'public');
            $pesanan->bukti_pengiriman = $path;
        }

        $pesanan->save();

        return redirect()->route('driver.tugas.show', $id)
            ->with('success', 'Status pengiriman diperbarui.');
    }
}
