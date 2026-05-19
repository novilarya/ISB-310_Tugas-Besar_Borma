<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class User extends Model
{
    use Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'id_user';
    protected $keyType = 'int';
    public $incrementing = true;
    protected $fillable = ['nama', 'email', 'password', 'no_telepon', 'role'];

    public function pelanggan() {
        return $this->hasOne(Pelanggan::class, 'id_user', 'id_user');
    }

    public function kurir() {
        return $this->hasOne(Kurir::class, 'id_user', 'id_user');
    }
}
