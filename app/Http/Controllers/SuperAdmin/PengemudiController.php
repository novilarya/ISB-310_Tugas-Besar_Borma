<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PengemudiController extends Controller
{
    public function pengemudi()
    {
        $pengemudi = \App\Models\Kurir::with(['user', 'penugasan' => function($query) {
            $query->orderBy('tanggal_pemesanan', 'desc');
        }])->get();
        $cabangs = \App\Models\Cabang::all();

        return view('super-admin.pengemudi', compact('pengemudi', 'cabangs'));
    }

    public function pengemudiDetail($id)
    {
        $kurir = \App\Models\Kurir::with(['user', 'penugasan' => function($query) {
            $query->orderBy('tanggal_pemesanan', 'desc');
        }])->findOrFail($id);
        $cabangs = \App\Models\Cabang::all();

        return view('super-admin.pengemudi-detail', compact('kurir', 'cabangs'));
    }

    public function storePengemudi(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/[a-zA-Z]/', // must contain at least one letter
                'regex:/[0-9@$!%*#?&_\-]/', // must contain at least one number or special character
            ],
            'no_telepon' => 'required|string|max:15',
            'kendaraan' => 'required|string|max:255',
            'warna_kendaraan' => 'required|string|max:255',
            'plat_nomor' => 'required|string|max:20',
            'id_cabang' => 'required|exists:cabangs,id_cabang',
        ]);

        $user = \App\Models\User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'no_telepon' => $request->no_telepon,
            'role' => 'Kurir',
        ]);

        \App\Models\Kurir::create([
            'id_user' => $user->id_user,
            'id_cabang' => $request->id_cabang,
            'kendaraan' => $request->kendaraan,
            'warna_kendaraan' => $request->warna_kendaraan,
            'plat_nomor' => $request->plat_nomor,
            'penghasilan_kotor' => 0,
            'penghasilan_bersih' => 0,
            'status_mengirim' => 'Tidak Mengirim',
            'status_aktif' => 'Aktif',
        ]);

        return redirect()->route('superadmin.pengemudi')->with('success', 'Pengemudi berhasil ditambahkan.');
    }

    public function updatePengemudi(Request $request, $id)
    {
        $kurir = \App\Models\Kurir::findOrFail($id);
        $user = $kurir->user;

        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id_user.',id_user',
            'password' => [
                'nullable',
                'string',
                'min:8',
                'regex:/[a-zA-Z]/',
                'regex:/[0-9@$!%*#?&_\-]/',
            ],
            'no_telepon' => 'required|string|max:15',
            'kendaraan' => 'required|string|max:255',
            'warna_kendaraan' => 'required|string|max:255',
            'plat_nomor' => 'required|string|max:20',
        ]);

        $user->update([
            'nama' => $request->nama,
            'email' => $request->email,
            'no_telepon' => $request->no_telepon,
        ]);

        if ($request->filled('password')) {
            $user->update(['password' => bcrypt($request->password)]);
        }

        $kurir->update([
            'kendaraan' => $request->kendaraan,
            'warna_kendaraan' => $request->warna_kendaraan,
            'plat_nomor' => $request->plat_nomor,
        ]);

        return redirect()->route('superadmin.pengemudi')->with('success', 'Pengemudi berhasil diperbarui.');
    }

    public function destroyPengemudi($id)
    {
        $kurir = \App\Models\Kurir::findOrFail($id);
        $user = $kurir->user;
        
        $kurir->delete();
        $user->delete();

        return redirect()->route('superadmin.pengemudi')->with('success', 'Pengemudi berhasil dihapus.');
    }
}
