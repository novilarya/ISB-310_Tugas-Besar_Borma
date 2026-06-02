<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    protected $table = 'pelanggans';
    protected $primaryKey = 'id_pelanggan';
    protected $fillable = ['id_user', 'status_member', 'poin_member', 'provinsi', 'kota_kabupaten', 'kecamatan', 'alamat'];

    public function user() {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
 
    public function riwayatPesanan() {
        return $this->hasMany(Pesanan::class, 'id_pelanggan', 'id_pelanggan');
    }
}
