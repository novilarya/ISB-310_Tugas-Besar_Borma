<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuPermission extends Model
{
    protected $table = 'hak_akses_menu';

    protected $fillable = ['id_pengguna', 'menu_key', 'akses'];

    protected $casts = ['akses' => 'boolean'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_pengguna', 'id_pengguna');
    }

    /**
     * Daftar semua menu yang bisa dikontrol per role.
     * Key => Label tampilan
     */
    public static function superAdminMenus(): array
    {
        return [
            'superadmin_dashboard'    => 'Dashboard',
            'superadmin_pesanan'      => 'Manajemen Pesanan',
            'superadmin_cabang'       => 'Manajemen Cabang',
            'superadmin_admin_cabang' => 'Manajemen Admin Cabang',
            'superadmin_member'       => 'Manajemen Member',
            'superadmin_pengemudi'    => 'Manajemen Pengemudi',
            'superadmin_promo'        => 'Voucher & Promo',
        ];
    }

    /**
     * Daftar semua menu yang bisa dikontrol untuk Admin Cabang.
     */
    public static function adminCabangMenus(): array
    {
        return [
            'admincabang_dashboard'  => 'Dashboard',
            'admincabang_produk'     => 'Manajemen Produk',
            'admincabang_pesanan'    => 'Daftar Pesanan',
            'admincabang_member'     => 'Manajemen Member',
            'admincabang_promo'      => 'Promo & Voucher',
            'admincabang_laporan'    => 'Laporan Cabang',
            'admincabang_pengaturan' => 'Pengaturan',
        ];
    }
}
