<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'id_user';
    protected $keyType = 'int';
    public $incrementing = true;

    protected $fillable = [
        'nama',
        'email',
        'password',
        'no_telepon',
        'role',
        'settings',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'settings'  => 'array',
        'password'  => 'hashed',
    ];

    // ─── Relasi ───────────────────────────────────────────────

    public function pelanggan()
    {
        return $this->hasOne(Pelanggan::class, 'id_user', 'id_user');
    }

    public function kurir()
    {
        return $this->hasOne(Kurir::class, 'id_user', 'id_user');
    }

    public function adminCabang()
    {
        return $this->hasOne(AdminCabang::class, 'id_user', 'id_user');
    }

    public function menuPermissions()
    {
        return $this->hasMany(MenuPermission::class, 'id_user', 'id_user');
    }

    // ─── Helper ───────────────────────────────────────────────

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

    /**
     * Cek apakah user adalah internal (super_admin, admin_cabang, kurir).
     */
    public function isInternal(): bool
    {
        return in_array($this->role, ['super_admin', 'admin_cabang', 'kurir']);
    }

    /**
     * Cek apakah user adalah pelanggan.
     */
    public function isPelanggan(): bool
    {
        return $this->role === 'pelanggan';
    }
}
