<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberController extends Controller
{
    /**
     * Show the membership activation page.
     */
    public function index()
    {
        $user = Auth::user();
        $pelanggan = null;

        if ($user) {
            $pelanggan = Pelanggan::where('id_pengguna', $user->id_pengguna)->first();
        }

        return view('pelanggan.member', compact('user', 'pelanggan'));
    }

    /**
     * Activate membership for the authenticated user.
     */
    public function activate(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'no_whatsapp' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'alamat' => 'required|string',
            'provinsi' => 'required|string|max:255',
            'kota_kabupaten' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'agree_terms' => 'required|accepted',
        ]);

        $user = Auth::user();

        // Update user data
        $user->update([
            'nama' => $request->nama_lengkap,
            'email' => $request->email,
            'no_telepon' => $request->no_whatsapp,
        ]);

        // Check if pelanggan record exists
        $pelanggan = Pelanggan::where('id_pengguna', $user->id_pengguna)->first();

        if ($pelanggan) {
            // Update existing record
            $pelanggan->update([
                'status_member_plus' => 1,
                'provinsi' => $request->provinsi,
                'kota_kabupaten' => $request->kota_kabupaten,
                'kecamatan' => $request->kecamatan,
                'alamat' => $request->alamat,
            ]);
        } else {
            // Create new pelanggan record
            Pelanggan::create([
                'id_pengguna' => $user->id_pengguna,
                'status_member_plus' => 1,
                'poin_member' => 0,
                'provinsi' => $request->provinsi,
                'kota_kabupaten' => $request->kota_kabupaten,
                'kecamatan' => $request->kecamatan,
                'alamat' => $request->alamat,
            ]);
        }

        return redirect()->route('pelanggan.member')->with('success', 'Selamat! Membership Member Plus Anda berhasil diaktifkan.');
    }
}
