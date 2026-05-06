<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showInternalLoginForm()
    {
        return view('internal-login');
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
                    return redirect()->intended('superadmin/dashboard');
                case 'Admin Cabang':
                    return redirect()->intended('admincabang/dashboard');
                case 'Kurir':
                case 'Driver': 
                    return redirect()->intended('kurir/dashboard');
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
        return redirect('/internal/login');
    }
}
