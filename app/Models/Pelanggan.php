<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    protected $table = 'pelanggan';
    protected $primaryKey = 'id_pelanggan';
    protected $fillable = ['id_pengguna', 'status_member_plus', 'poin_member', 'tanggal_berakhir_member_plus', 'provinsi', 'kota_kabupaten', 'kecamatan', 'alamat'];

    public function user() {
        return $this->belongsTo(User::class, 'id_pengguna', 'id_pengguna');
    }
 
    public function riwayatPesanan() {
        return $this->hasMany(Pesanan::class, 'id_pelanggan', 'id_pelanggan');
    }

    public function alamatTambahan() {
        return $this->hasMany(AlamatPelanggan::class, 'id_pelanggan', 'id_pelanggan');
    }
}