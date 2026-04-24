<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class user extends Model
{
    use Notifiable;

    protected $fillable = ['nama', 'email', 'password', 'no_telepon', 'role'];

    public function pelanggan() {
        return $this->hasOne(Pelanggan::class, 'id_user', 'id_user');
    }

    public function kurir() {
        return $this->hasOne(Kurir::class, 'id_user', 'id_user');
    }
}
