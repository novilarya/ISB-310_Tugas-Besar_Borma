<?php

namespace App\Http\Controllers\AdminCabang;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Cabang;
use Illuminate\Support\Facades\Hash;

class SettingController extends Controller
{
    private function getAdmin() {
        return auth()->user() ?? User::find(1);
    }

    private function getCabang() {
        $admin = $this->getAdmin();
        return ($admin && $admin->adminCabang) ? $admin->adminCabang->cabang : Cabang::find(1);
    }

    public function index()
    {
        $admin = $this->getAdmin();
        $cabang = $this->getCabang();
        return view('admin-cabang.pengaturan', compact('admin', 'cabang'));
    }

    public function updateProfil(Request $request)
    {
        $request->validate([
            'nama_lengkap'   => 'required|string|max:100',
            'nama_tampilan'  => 'nullable|string|max:50',
            'email'          => 'required|email|max:100',
            'telepon'        => 'nullable|string|max:20',
            'jabatan'        => 'nullable|string|max:100',
            'bio'            => 'nullable|string|max:255',
        ]);

        $admin = $this->getAdmin();
        if($admin) {
            $admin->nama = $request->nama_lengkap;
            $admin->email = $request->email;
            $admin->no_telepon = $request->telepon;
            
            $settings = $admin->settings ?? [];
            $settings['nama_tampilan'] = $request->nama_tampilan;
            $settings['jabatan'] = $request->jabatan;
            $settings['bio'] = $request->bio;
            $admin->settings = $settings;
            $admin->save();
        }

        return back()->with('success', 'Profil akun berhasil diperbarui.');
    }

    public function updateCabang(Request $request)
    {
        $request->validate([
            'nama_cabang'  => 'required|string|max:100',
            'alamat'       => 'required|string|max:255',
            'kota'         => 'required|string|max:50',
            'provinsi'     => 'required|string|max:50',
            'kode_pos'     => 'nullable|string|max:10',
            'telepon'      => 'nullable|string|max:20',
            'email_cabang' => 'nullable|email|max:100',
            'jam_buka'     => 'nullable|date_format:H:i',
            'jam_tutup'    => 'nullable|date_format:H:i',
            'deskripsi'    => 'nullable|string|max:255',
        ]);

        $cabang = $this->getCabang();
        if($cabang) {
            $cabang->nama_cabang = $request->nama_cabang;
            $cabang->alamat_cabang = $request->alamat;
            
            $settings = $cabang->settings ?? [];
            $settings['kota'] = $request->kota;
            $settings['provinsi'] = $request->provinsi;
            $settings['kode_pos'] = $request->kode_pos;
            $settings['telepon'] = $request->telepon;
            $settings['email_cabang'] = $request->email_cabang;
            $settings['jam_buka'] = $request->jam_buka;
            $settings['jam_tutup'] = $request->jam_tutup;
            $settings['deskripsi'] = $request->deskripsi;
            $cabang->settings = $settings;
            $cabang->save();
        }

        return back()->with('success', 'Info cabang berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password_lama'      => 'required',
            'password_baru'      => 'required|min:8|confirmed',
        ]);

        $admin = $this->getAdmin();
        if($admin) {
            if(!Hash::check($request->password_lama, $admin->password)) {
                return back()->with('error', 'Password lama tidak sesuai.');
            }
            $admin->password = Hash::make($request->password_baru);
            $admin->save();
        }

        return back()->with('success', 'Password berhasil diperbarui.');
    }

    public function updateNotifikasi(Request $request)
    {
        $prefs = $request->only([
            'notif_pesanan_masuk',
            'notif_status_pesanan',
            'notif_pesanan_batal',
            'notif_stok_menipis',
            'notif_produk_baru',
            'notif_promo_berakhir',
            'notif_voucher_habis',
            'channel_app',
            'channel_email',
            'channel_sms',
        ]);

        $admin = $this->getAdmin();
        if($admin) {
            $settings = $admin->settings ?? [];
            $settings['notifikasi'] = $prefs;
            $admin->settings = $settings;
            $admin->save();
        }

        return back()->with('success', 'Preferensi notifikasi berhasil disimpan.');
    }
}
