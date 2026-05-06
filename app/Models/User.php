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
}
