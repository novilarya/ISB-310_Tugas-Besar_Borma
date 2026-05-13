<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class cabang extends Model
{
    protected $table = 'cabangs';
    protected $primaryKey = 'id_cabang';
    protected $fillable = ['nama_cabang', 'alamat_cabang', 'koordinat_gps', 'status'];

    public function stokProduk() {
        return $this->hasMany(ProdukCabang::class, 'id_cabang');
    }

    public function pesanan() {
        return $this->hasMany(Pesanan::class, 'id_cabang');
    }
}
