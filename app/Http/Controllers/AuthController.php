<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showInternalLoginForm()
    {
        return view('auth.internal-login');
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
            
            // Role enum dari migration: 'Pelanggan', 'Admin', 'Staf Operasional', 'Kurir'
            switch ($user->role) {
                case 'Staf Operasional':
                    return redirect()->intended('superadmin/dashboard');
                case 'Admin':
                    return redirect()->intended('admin-cabang/dashboard');
                case 'Kurir':
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

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('internal/login');
    }
}
