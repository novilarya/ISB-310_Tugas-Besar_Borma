<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    protected $table = 'pengguna';
    protected $primaryKey = 'id_pengguna';
    protected $keyType = 'int';
    public $incrementing = true;

    protected $fillable = [
        'nama',
        'email',
        'password',
        'google_id',
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
        return $this->hasOne(Pelanggan::class, 'id_pengguna', 'id_pengguna');
    }

    public function kurir()
    {
        return $this->hasOne(Kurir::class, 'id_pengguna', 'id_pengguna');
    }

    public function adminCabang()
    {
        return $this->hasOne(AdminCabang::class, 'id_pengguna', 'id_pengguna');
    }

    public function menuPermissions()
    {
        return $this->hasMany(MenuPermission::class, 'id_pengguna', 'id_pengguna');
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
        return (bool) $permission->akses;
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
