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
}
