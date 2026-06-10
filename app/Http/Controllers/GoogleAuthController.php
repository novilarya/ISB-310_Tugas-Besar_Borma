<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use App\Models\Pelanggan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class GoogleAuthController extends Controller
{
    // Redirect pengguna ke halaman login Google
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    // Proses setelah pengguna login di Google
    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors([
                'email' => 'Gagal login dengan Google. Silakan coba lagi.',
            ]);
        }

        // Cek apakah user sudah ada berdasarkan email
        $user = User::where(['email' => $googleUser->getEmail()])->first();

        if ($user) {
            // User sudah ada, update google_id jika belum ada
            if (!$user->google_id) {
                $user->update(['google_id' => $googleUser->getId()]);
            }
        } else {
            // User baru, buat akun pelanggan baru
            DB::beginTransaction();
            try {
                // Generate random name (Shopee style, e.g. 8tp8z9f8g_)
                $randomName = substr(str_shuffle("abcdefghijklmnopqrstuvwxyz0123456789"), 0, 9) . '_';

                $user = User::create([
                    'nama'       => $randomName,
                    'email'      => $googleUser->getEmail(),
                    'google_id'  => $googleUser->getId(),
                    'no_telepon' => '-',
                    'role'       => 'Pelanggan',
                ]);

                Pelanggan::create([
                    'id_pengguna'    => $user->id_pengguna,
                    'status_member_plus' => false,
                    'poin_member'    => 0,
                    'provinsi'       => '-',
                    'kota_kabupaten' => '-',
                    'kecamatan'      => '-',
                    'alamat'         => '-',
                ]);

                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->route('login')->withErrors([
                    'email' => 'Gagal membuat akun. Silakan coba lagi.',
                ]);
            }
        }

        // Generate OTP
        $otp = rand(100000, 999999);

        // Store login data in session
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
                $message->to($user->email)->subject('Kode OTP Login Google - Borma Toserba');
            });
        } catch (\Exception $e) {
            Log::error('Gagal mengirim OTP login Google ke ' . $user->email . ': ' . $e->getMessage());
        }

        return redirect()->route('auth.otp');
    }
}