<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class produk extends Model
{
    protected $table = 'produk';
    protected $primaryKey = 'id_produk';
    protected $fillable = ['nama_produk', 'kategori', 'deskripsi', 'harga_reguler', 'harga_member', 'gambar_produk'];

    public function inventarisCabang() {
        return $this->hasMany(ProdukCabang::class, 'id_produk');
    }
}
