<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class kurir extends Model
{
    protected $table = 'kurir';
    protected $primaryKey = 'id_kurir';
    protected $fillable = ['id_user', 'id_cabang', 'kode_driver', 'kendaraan', 'warna_kendaraan', 'plat_nomor'];

    public function user() {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function cabang() {
        return $this->belongsTo(Cabang::class, 'id_cabang');
    }

    public function penugasan() {
        return $this->hasMany(Pesanan::class, 'id_kurir');
    }
}
