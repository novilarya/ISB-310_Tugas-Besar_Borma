<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cabang extends Model
{
    protected $table = 'cabangs';
    protected $primaryKey = 'id_cabang';
    protected $fillable = ['nama_cabang', 'alamat_cabang', 'koordinat_gps', 'status', 'settings'];

    protected $casts = [
        'settings' => 'array',
    ];

    public function stokProduk() {
        return $this->hasMany(ProdukCabang::class, 'id_cabang', 'id_cabang');
    }

    public function pesanan() {
        return $this->hasMany(Pesanan::class, 'id_cabang', 'id_cabang');
    }

    public function adminCabangs() {
        return $this->hasMany(AdminCabang::class, 'id_cabang', 'id_cabang');
    }

    public function kurirs() {
        return $this->hasMany(Kurir::class, 'id_cabang', 'id_cabang');
    }

    public function promos() {
        return $this->hasMany(Promo::class, 'id_cabang', 'id_cabang');
    }

}
