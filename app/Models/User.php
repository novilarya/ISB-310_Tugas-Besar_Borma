<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $primaryKey = 'id_user';

    protected $fillable = ['nama', 'email', 'password', 'no_telepon', 'role'];

    protected $hidden = [
        'password',
    ];

    public function pelanggan() {
        return $this->hasOne(Pelanggan::class, 'id_user', 'id_user');
    }

    public function kurir() {
        return $this->hasOne(Kurir::class, 'id_user', 'id_user');
    }

    public function adminCabang() {
        return $this->hasOne(AdminCabang::class, 'id_user', 'id_user');
    }

    public function menuPermissions() {
        return $this->hasMany(MenuPermission::class, 'id_user', 'id_user');
    }

    /**
     * Cek apakah user memiliki akses ke menu tertentu.
     * Default: true (semua aktif jika belum ada record).
     */
    public function canAccessMenu(string $key): bool
    {
        $permission = $this->menuPermissions->firstWhere('menu_key', $key);
        if ($permission === null) return true; // default aktif
        return (bool) $permission->is_enabled;
    }
}
