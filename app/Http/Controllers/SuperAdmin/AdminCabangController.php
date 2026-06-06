<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminCabangController extends Controller
{
    // adminCabang method removed as view is replaced by super-admin

    public function storeAdminCabang(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:pengguna,email',
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/[a-zA-Z]/',
                'regex:/[0-9@$!%*#?&_\-]/',
            ],
            'no_telepon' => 'required|string|max:15',
            'id_cabang' => 'required|exists:cabang,id_cabang',
            'tanggal_masuk' => 'required|date',
            'status_karyawan' => 'required|string',
        ]);

        $user = \App\Models\User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'no_telepon' => $request->no_telepon,
            'role' => 'Admin Cabang',
        ]);

        \App\Models\AdminCabang::create([
            'id_pengguna' => $user->id_pengguna,
            'id_cabang' => $request->id_cabang,
            'tanggal_masuk' => $request->tanggal_masuk,
            'status_karyawan' => $request->status_karyawan,
        ]);

        $fromCabangId = $request->input('from_cabang_id');
        if ($fromCabangId) {
            return redirect()->route('superadmin.cabang.detail', $fromCabangId)->with('success', 'Admin Cabang berhasil ditambahkan.');
        }
        return redirect()->route('superadmin.cabang')->with('success', 'Admin Cabang berhasil ditambahkan.');
    }

    public function updateAdminCabang(Request $request, $id)
    {
        $adminCabang = \App\Models\AdminCabang::findOrFail($id);
        $user = $adminCabang->user;

        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:pengguna,email,'.$user->id_pengguna.',id_pengguna',
            'password' => [
                'nullable',
                'string',
                'min:8',
                'regex:/[a-zA-Z]/',
                'regex:/[0-9@$!%*#?&_\-]/',
            ],
            'no_telepon' => 'required|string|max:15',
            'id_cabang' => 'required|exists:cabang,id_cabang',
            'tanggal_masuk' => 'required|date',
            'status_karyawan' => 'required|string',
        ]);

        $user->update([
            'nama' => $request->nama,
            'email' => $request->email,
            'no_telepon' => $request->no_telepon,
        ]);

        if ($request->filled('password')) {
            $user->update(['password' => bcrypt($request->password)]);
        }

        $adminCabang->update([
            'id_cabang' => $request->id_cabang,
            'tanggal_masuk' => $request->tanggal_masuk,
            'status_karyawan' => $request->status_karyawan,
        ]);

        $fromCabangId = $request->input('from_cabang_id');
        if ($fromCabangId) {
            return redirect()->route('superadmin.cabang.detail', $fromCabangId)->with('success', 'Admin Cabang berhasil diperbarui.');
        }
        return redirect()->route('superadmin.cabang')->with('success', 'Admin Cabang berhasil diperbarui.');
    }

    public function destroyAdminCabang(Request $request, $id)
    {
        $adminCabang = \App\Models\AdminCabang::findOrFail($id);
        $user = $adminCabang->user;
        $fromCabangId = $adminCabang->id_cabang;

        $adminCabang->delete();
        $user->delete();

        if ($request->input('from_cabang_detail')) {
            return redirect()->route('superadmin.cabang.detail', $fromCabangId)->with('success', 'Admin Cabang berhasil dihapus.');
        }
        return redirect()->route('superadmin.cabang')->with('success', 'Admin Cabang berhasil dihapus.');
    }
}
