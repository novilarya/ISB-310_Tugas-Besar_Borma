<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Models\Kurir;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfilController extends Controller
{
    public function index()
    {
        $user = Auth::check() ? Auth::user() : \App\Models\User::where('role', 'kurir')->first();

        if (!$user) {
            return view('driver.profil.index', [
                'user' => (object) ['nama' => 'Driver', 'email' => '-', 'no_telepon' => '-'],
                'kurir' => (object) ['id_kurir' => 0, 'kendaraan' => '-', 'plat_nomor' => '-'],
                'cabang' => 'Belum ditentukan',
                'totalKirim' => 0,
                'berhasil' => 0,
                'rating' => 0,
            ]);
        }

        $kurir = Kurir::where('id_pengguna', $user->id_pengguna)->first();

        // Hitung statistik
        $totalKirim = Pesanan::where('id_kurir', $kurir->id_kurir ?? 0)
            ->whereIn('status_pesanan', ['diterima', 'selesai', 'gagal'])
            ->count();

        $berhasil = Pesanan::where('id_kurir', $kurir->id_kurir ?? 0)
            ->whereIn('status_pesanan', ['diterima', 'selesai'])
            ->count();

        // Rating placeholder (bisa diganti dengan logika review nanti)
        $rating = $berhasil > 0 ? min(5, round(($berhasil / max($totalKirim, 1)) * 5, 1)) : 0;

        // Ambil nama cabang dari pesanan terakhir
        $cabangTerakhir = Pesanan::where('id_kurir', $kurir->id_kurir ?? 0)
            ->with('cabang')
            ->latest()
            ->first();
        $cabang = $cabangTerakhir?->cabang?->nama_cabang ?? 'Belum ditentukan';

        return view('driver.profil.index', compact('user', 'kurir', 'cabang', 'totalKirim', 'berhasil', 'rating'));
    }

    public function formUbahPassword()
    {
        return view('driver.profil.ubah-password');
    }

    public function ubahPassword(Request $request)
    {
        $request->validate([
            'password_lama' => 'required',
            'password_baru' => 'required|min:8|confirmed',
        ]);

        $user = Auth::check() ? Auth::user() : \App\Models\User::where('role', 'kurir')->first();

        if (!$user || !Hash::check($request->password_lama, $user->password)) {
            return back()->withErrors(['password_lama' => 'Password lama tidak sesuai.']);
        }

        $user->password = Hash::make($request->password_baru);
        $user->save();

        return redirect()->route('driver.profil.index')->with('success', 'Password berhasil diubah.');
    }
}
