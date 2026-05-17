<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Models\Kurir;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Untuk testing tanpa auth, gunakan data dummy
        // Nanti setelah auth aktif, ganti dengan Auth::user()
        $user = Auth::check() ? Auth::user() : \App\Models\User::where('role', 'kurir')->first();

        if (!$user) {
            // Fallback: tampilkan dashboard dengan data kosong
            return view('driver.dashboard', [
                'kurir' => (object) ['kode_driver' => 'D00', 'cabang' => (object) ['nama_cabang' => 'Belum Ada']],
                'tugasAktif' => 0,
                'selesaiHariIni' => 0,
                'tugasBerikutnya' => null,
            ]);
        }

        $kurir = Kurir::where('id_user', $user->id_user)->first();

        $tugasAktif = Pesanan::where('id_kurir', $kurir->id_kurir ?? 0)
            ->whereIn('status_pesanan', ['menunggu', 'diambil', 'dalam_pengiriman'])
            ->count();

        $selesaiHariIni = Pesanan::where('id_kurir', $kurir->id_kurir ?? 0)
            ->where('status_pesanan', 'diterima')
            ->whereDate('updated_at', today())
            ->count();

        $tugasBerikutnya = Pesanan::where('id_kurir', $kurir->id_kurir ?? 0)
            ->whereIn('status_pesanan', ['menunggu', 'diambil', 'dalam_pengiriman'])
            ->with(['cabang', 'pelanggan.user'])
            ->orderBy('created_at', 'asc')
            ->first();

        return view('driver.dashboard', compact('kurir', 'tugasAktif', 'selesaiHariIni', 'tugasBerikutnya'));
    }
}
