<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $primaryKey = 'id_user';

    protected $fillable = ['nama', 'email', 'password', 'no_telepon', 'role', 'settings'];

    protected $hidden = ['password'];

    protected $casts = [
        'settings' => 'array',
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
}
