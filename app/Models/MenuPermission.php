<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuPermission extends Model
{
    protected $table = 'menu_permissions';

    protected $fillable = ['id_user', 'menu_key', 'is_enabled'];

    protected $casts = ['is_enabled' => 'boolean'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    /**
     * Daftar semua menu yang bisa dikontrol per role.
     * Key => Label tampilan
     */
    public static function superAdminMenus(): array
    {
        return [
            'superadmin_dashboard'  => 'Dashboard',
            'superadmin_pesanan'    => 'Manajemen Pesanan',
            'superadmin_cabang'     => 'Manajemen Cabang',
            'superadmin_member'     => 'Manajemen Member',
            'superadmin_pengemudi'  => 'Manajemen Pengemudi',
            'superadmin_promo'      => 'Voucher & Promo',
        ];
    }
}
