<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kurir extends Model
{
    protected $table = 'kurirs';
    protected $primaryKey = 'id_kurir';
    protected $fillable = ['id_user', 'kendaraan', 'warna_kendaraan', 'plat_nomor'];

    public function user() {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function penugasan() {
        return $this->hasMany(Pesanan::class, 'id_kurir');
    }
}
