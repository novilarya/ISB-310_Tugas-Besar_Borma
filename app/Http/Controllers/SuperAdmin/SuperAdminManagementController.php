<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class SuperAdminManagementController extends Controller
{
    public function index()
    {
        $superAdmins = User::whereIn('role', ['Super Admin', 'Admin Super'])->get();
        return view('super-admin.super-admin', compact('superAdmins'));
    }

    public function store(Request $request)
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
        ]);

        User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'no_telepon' => $request->no_telepon,
            'role' => 'Super Admin',
        ]);

        return redirect()->route('superadmin.super_admin')->with('success', 'Super Admin berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

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
        ]);

        $user->update([
            'nama' => $request->nama,
            'email' => $request->email,
            'no_telepon' => $request->no_telepon,
        ]);

        if ($request->filled('password')) {
            $user->update(['password' => bcrypt($request->password)]);
        }

        return redirect()->route('superadmin.super_admin')->with('success', 'Super Admin berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Prevent deleting oneself
        if (auth()->id() == $user->id_pengguna) {
            return redirect()->route('superadmin.super_admin')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();

        return redirect()->route('superadmin.super_admin')->with('success', 'Super Admin berhasil dihapus.');
    }

    public function pengaturan()
    {
        $user = auth()->user();
        return view('super-admin.pengaturan', compact('user'));
    }

    public function updatePengaturan(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:pengguna,email,'.$user->id_pengguna.',id_pengguna',
            'no_telepon' => 'required|string|max:15',
            'password_baru' => [
                'nullable',
                'string',
                'min:8',
                'regex:/[a-zA-Z]/',
                'regex:/[0-9@$!%*#?&_\-]/',
                'confirmed'
            ],
            'password_lama' => 'required_with:password_baru'
        ]);

        if ($request->filled('password_baru')) {
            if (!\Hash::check($request->password_lama, $user->password)) {
                return back()->withErrors(['password_lama' => 'Kata sandi saat ini tidak cocok.']);
            }
            $user->password = bcrypt($request->password_baru);
        }

        $user->nama = $request->nama;
        $user->email = $request->email;
        $user->no_telepon = $request->no_telepon;
        $user->save();

        return redirect()->route('superadmin.pengaturan')->with('success', 'Pengaturan profil berhasil diperbarui.');
    }
}
