<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            
            switch ($user->role) {
                case 'Super Admin':
                case 'Admin Super':
                case 'Staf Operasional':
                    return redirect()->intended('superadmin/dashboard');
                case 'Admin Cabang':
                case 'Admin':
                    return redirect()->intended('admin-cabang/dashboard');
                case 'Kurir':
                case 'Driver':
                    return redirect()->intended('kurir/dashboard');
                case 'Pelanggan':
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

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/internal/login');
    }
}
