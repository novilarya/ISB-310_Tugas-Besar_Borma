<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
     public function showInternalLoginForm()
    {
        $superAdmins = User::whereIn('role', ['Super Admin', 'Admin Super'])->get();
        return view('internal-login', compact('superAdmins'));
    }

    public function authenticateInternal(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'string'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();
            $role = strtolower($user->role);

            switch (true) {
                case in_array($role, ['super admin', 'admin super', 'staf operasional']):
                    return redirect()->intended('superadmin/dashboard');
                case in_array($role, ['admin cabang', 'admin']):
                    return redirect()->intended('admin-cabang/dashboard');
                case in_array($role, ['kurir', 'driver']):
                    return redirect()->intended('driver/dashboard');
                case $role === 'pelanggan':
                default:
                    Auth::logout();
                    return back()->withErrors([
                        'email' => 'Role Anda tidak memiliki akses ke sistem internal.',
                    ]);
            }
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    /**
     * Show login form
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Show register form
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Handle login
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('pelanggan.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    /**
     * Handle register
     */
    public function register(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => ['required', 'email', 'unique:pengguna,email', 'regex:/^[a-zA-Z0-9._%+\-]+@gmail\.com$/'],
            'no_telepon' => ['required', 'regex:/^[0-9]{10,15}$/'],
            'provinsi' => 'required|string|max:255',
            'kota_kabupaten' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'alamat' => 'required|string',
            'password' => [
                'required',
                'min:8',
                'confirmed',
                'regex:/[A-Z]/',      // at least one uppercase
                'regex:/[0-9]/',      // at least one digit
            ],
        ], [
            'nama.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'email.regex' => 'Email harus menggunakan @gmail.com (contoh: nama@gmail.com).',
            'no_telepon.required' => 'Nomor telepon wajib diisi.',
            'no_telepon.regex' => 'Nomor telepon hanya boleh berisi angka, tidak boleh ada huruf atau karakter khusus.',
            'no_telepon.min' => 'Nomor telepon minimal 10 digit.',
            'provinsi.required' => 'Provinsi wajib dipilih.',
            'kota_kabupaten.required' => 'Kota/Kabupaten wajib dipilih.',
            'kecamatan.required' => 'Kecamatan wajib dipilih.',
            'alamat.required' => 'Detail alamat wajib diisi.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.regex' => 'Password harus mengandung minimal 1 huruf besar dan 1 angka (contoh: Dudunk0425).',
        ]);

        DB::beginTransaction();

        try {
            $user = User::create([
                'nama' => $request->nama,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'no_telepon' => $request->no_telepon,
                'role' => 'Pelanggan',
            ]);

            Pelanggan::create([
                'id_pengguna' => $user->id_pengguna,
                'status_member' => false,
                'poin_member' => 0,
                'provinsi' => $request->provinsi,
                'kota_kabupaten' => $request->kota_kabupaten,
                'kecamatan' => $request->kecamatan,
                'alamat' => $request->alamat,
            ]);

            DB::commit();

            Auth::login($user);

            return redirect()->route('pelanggan.dashboard')->with('success', 'Registrasi berhasil! Selamat datang di Borma.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Terjadi kesalahan saat registrasi. Silakan coba lagi.'])->withInput();
        }
    }

    /**
     * Handle logout
     */
    public function logout(Request $request)
    {
        $role = Auth::user()?->role;

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if (in_array($role, ['Super Admin', 'Admin Super', 'Admin Cabang', 'Admin', 'Staf Operasional', 'Kurir', 'Driver'])) {
            return redirect('/internal/login');
        }

        return redirect()->route('login');
    }
}
