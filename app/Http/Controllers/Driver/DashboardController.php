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
                'antrianTugas' => collect(),
            ]);
        }

        $kurir = Kurir::where('id_pengguna', $user->id_pengguna)->with(['cabang', 'user'])->first();

        if (!$kurir) {
            return view('driver.dashboard', [
                'kurir' => (object) ['kode_driver' => 'D00', 'cabang' => (object) ['nama_cabang' => 'Belum Ada']],
                'tugasAktif' => 0,
                'selesaiHariIni' => 0,
                'tugasBerikutnya' => null,
                'antrianTugas' => collect(),
            ]);
        }

        // Tugas yang sudah dikonfirmasi dan sedang aktif
        $tugasAktif = Pesanan::where('id_kurir', $kurir->id_kurir)
            ->whereIn('status_pesanan', ['mencari_driver', 'diterima_driver', 'diambil', 'dalam_pengiriman'])
            ->count();

        // Selesai hari ini
        $selesaiHariIni = Pesanan::where('id_kurir', $kurir->id_kurir)
            ->whereIn('status_pesanan', ['diterima', 'selesai'])
            ->whereDate('updated_at', today())
            ->count();

        // Tugas berikutnya: ambil tugas aktif yang sudah diklaim driver ini
        $tugasBerikutnya = Pesanan::where('id_kurir', $kurir->id_kurir)
            ->whereIn('status_pesanan', ['diterima_driver', 'diambil', 'dalam_pengiriman'])
            ->with(['cabang', 'pelanggan.user'])
            ->orderBy('created_at', 'asc')
            ->first();

        // Antrian tugas pengiriman: pesanan yang belum diassign ke kurir manapun (multi-driver FCFS) dan sesuai cabang kurir
        $antrianTugas = Pesanan::whereNull('id_kurir')
            ->where('status_pesanan', 'mencari_driver')
            ->where('id_cabang', $kurir->id_cabang)
            ->with(['cabang', 'pelanggan.user'])
            ->orderBy('created_at', 'asc')
            ->get();

        return view('driver.dashboard', compact('kurir', 'tugasAktif', 'selesaiHariIni', 'tugasBerikutnya', 'antrianTugas'));
    }
}
