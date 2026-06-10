<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

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

        if (Auth::validate($credentials)) {
            $user = Auth::getProvider()->retrieveByCredentials($credentials);
            $role = strtolower($user->role);

            if ($role === 'pelanggan') {
                return back()->withErrors([
                    'email' => 'Role Anda tidak memiliki akses ke sistem internal.',
                ])->onlyInput('email');
            }

            // Generate OTP
            $otp = rand(100000, 999999);

            // Store in session
            session([
                'otp_code' => $otp,
                'otp_expires_at' => now()->addMinutes(5),
                'otp_email' => $user->email,
                'otp_action' => 'login_internal',
                'otp_user_id' => $user->id_pengguna
            ]);

            // Send Email
            try {
                Mail::raw("Halo! Kode OTP Anda untuk masuk ke Portal Internal Borma Toserba adalah: $otp. Kode ini berlaku selama 5 menit.", function($message) use ($user) {
                    $message->to($user->email)->subject('Kode OTP Internal Login - Borma Toserba');
                });
            } catch (\Exception $e) {
                Log::error('Gagal mengirim OTP internal login ke ' . $user->email . ': ' . $e->getMessage());
            }

            return redirect()->route('auth.otp');
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

        if (Auth::validate($credentials)) {
            $user = Auth::getProvider()->retrieveByCredentials($credentials);

            // Generate OTP
            $otp = rand(100000, 999999);

            // Store in session
            session([
                'otp_code' => $otp,
                'otp_expires_at' => now()->addMinutes(5),
                'otp_email' => $user->email,
                'otp_action' => 'login',
                'otp_user_id' => $user->id_pengguna
            ]);

            // Send Email
            try {
                Mail::raw("Halo! Kode OTP Anda untuk masuk ke Borma Toserba adalah: $otp. Kode ini berlaku selama 5 menit.", function($message) use ($user) {
                    $message->to($user->email)->subject('Kode OTP Login - Borma Toserba');
                });
            } catch (\Exception $e) {
                Log::error('Gagal mengirim OTP login ke ' . $user->email . ': ' . $e->getMessage());
            }

            return redirect()->route('auth.otp');
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

        $recaptchaResponse = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret'   => env('RECAPTCHA_SECRET_KEY'),
            'response' => $request->input('g-recaptcha-response'),
            'remoteip' => $request->ip(),
        ]);

        $recaptchaData = $recaptchaResponse->json();

        if (!$recaptchaResponse->successful() || !$recaptchaData['success']) {
            return back()->withErrors([
                'g-recaptcha-response' => 'Validasi reCAPTCHA gagal! Centang "I\'m not a robot" terlebih dahulu.',
            ])->withInput();
        }
        
        // Generate OTP
        $otp = rand(100000, 999999);

        // Store registration data in session
        session([
            'otp_code' => $otp,
            'otp_expires_at' => now()->addMinutes(5),
            'otp_email' => $request->email,
            'otp_action' => 'register',
            'register_data' => [
                'nama' => $request->nama,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'no_telepon' => $request->no_telepon,
                'role' => 'Pelanggan',
                'provinsi' => $request->provinsi,
                'kota_kabupaten' => $request->kota_kabupaten,
                'kecamatan' => $request->kecamatan,
                'alamat' => $request->alamat,
            ]
        ]);

        // Send Email
        try {
            Mail::raw("Halo! Kode OTP Anda untuk menyelesaikan pendaftaran di Borma Toserba adalah: $otp. Kode ini berlaku selama 5 menit.", function($message) use ($request) {
                $message->to($request->email)->subject('Kode OTP Registrasi - Borma Toserba');
            });
        } catch (\Exception $e) {
            Log::error('Gagal mengirim OTP registrasi ke ' . $request->email . ': ' . $e->getMessage());
        }

        return redirect()->route('auth.otp');
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

    /**
     * Show OTP verification form
     */
    public function showOtpForm()
    {
        if (!session()->has('otp_code')) {
            return redirect()->route('login')->withErrors(['email' => 'Silakan login atau daftar terlebih dahulu.']);
        }
        return view('auth.otp');
    }

    /**
     * Verify OTP
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|string|size:6',
        ]);

        if (!session()->has('otp_code')) {
            return redirect()->route('login')->withErrors(['email' => 'Sesi OTP telah berakhir. Silakan coba lagi.']);
        }

        $sessionOtp = session('otp_code');
        $expiresAt = session('otp_expires_at');
        $action = session('otp_action');
        $email = session('otp_email');

        if (now()->greaterThan($expiresAt)) {
            return back()->withErrors(['otp' => 'Kode OTP telah kedaluwarsa. Silakan kirim ulang OTP.']);
        }

        if ($request->otp != $sessionOtp) {
            return back()->withErrors(['otp' => 'Kode OTP yang Anda masukkan salah.']);
        }

        if ($action === 'register') {
            $regData = session('register_data');

            DB::beginTransaction();
            try {
                $user = User::create([
                    'nama' => $regData['nama'],
                    'email' => $regData['email'],
                    'password' => $regData['password'],
                    'no_telepon' => $regData['no_telepon'],
                    'role' => $regData['role'],
                ]);

                Pelanggan::create([
                    'id_pengguna' => $user->id_pengguna,
                    'status_member_plus' => false,
                    'poin_member' => 0,
                    'provinsi' => $regData['provinsi'],
                    'kota_kabupaten' => $regData['kota_kabupaten'],
                    'kecamatan' => $regData['kecamatan'],
                    'alamat' => $regData['alamat'],
                ]);

                DB::commit();

                // Clear session
                session()->forget(['otp_code', 'otp_expires_at', 'otp_email', 'otp_action', 'register_data']);

                Auth::login($user);
                return redirect()->route('pelanggan.dashboard')->with('success', 'Registrasi berhasil! Selamat datang di Borma.');
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Error registering user via OTP: ' . $e->getMessage());
                return redirect()->route('register')->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.']);
            }
        } elseif ($action === 'login' || $action === 'login_internal') {
            $userId = session('otp_user_id');
            $user = User::find($userId);

            if (!$user) {
                $loginRoute = $action === 'login_internal' ? 'internal.login' : 'login';
                return redirect()->route($loginRoute)->withErrors(['email' => 'User tidak ditemukan.']);
            }

            // Clear session
            session()->forget(['otp_code', 'otp_expires_at', 'otp_email', 'otp_action', 'otp_user_id']);

            Auth::login($user);
            $request->session()->regenerate();

            $role = strtolower($user->role);
            
            if (in_array($role, ['super admin', 'admin super', 'staf operasional'])) {
                return redirect()->intended(route('superadmin.dashboard'))->with('success', 'Berhasil masuk ke portal internal.');
            } elseif (in_array($role, ['admin cabang', 'admin'])) {
                return redirect()->intended(route('admin-cabang.dashboard'))->with('success', 'Berhasil masuk ke portal internal.');
            } elseif (in_array($role, ['kurir', 'driver'])) {
                return redirect()->intended(route('driver.dashboard'))->with('success', 'Berhasil masuk ke portal internal.');
            }

            return redirect()->intended(route('pelanggan.dashboard'))->with('success', 'Berhasil masuk.');
        }

        return redirect()->route('login');
    }

    /**
     * Resend OTP
     */
    public function resendOtp()
    {
        if (!session()->has('otp_email')) {
            return redirect()->route('login');
        }

        $email = session('otp_email');
        $otp = rand(100000, 999999);

        // Update session
        session([
            'otp_code' => $otp,
            'otp_expires_at' => now()->addMinutes(5)
        ]);

        // Send Email
        try {
            Mail::raw("Halo! Kode OTP baru Anda adalah: $otp. Kode ini berlaku selama 5 menit.", function($message) use ($email) {
                $message->to($email)->subject('Kode OTP Baru - Borma Toserba');
            });
        } catch (\Exception $e) {
            Log::error('Gagal mengirim ulang OTP ke ' . $email . ': ' . $e->getMessage());
        }

        return back()->with('success', 'Kode OTP baru telah dikirim ke email kamu.');
    }
}
