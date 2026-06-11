<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    protected $table = 'pelanggan';
    protected $primaryKey = 'id_pelanggan';
    protected $fillable = ['id_pengguna', 'member_id', 'status_member_plus', 'poin_member', 'tanggal_berakhir_member_plus', 'provinsi', 'kota_kabupaten', 'kecamatan', 'alamat'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($pelanggan) {
            if (empty($pelanggan->member_id)) {
                $idPengguna = $pelanggan->id_pengguna;
                $rawId = str_pad($idPengguna * 7919 + 100000000000, 12, '0', STR_PAD_LEFT);
                $pelanggan->member_id = substr($rawId, 0, 4) . ' ' . substr($rawId, 4, 4) . ' ' . substr($rawId, 8, 4);
            }
        });
    }

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