<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'produks';
    protected $primaryKey = 'id_produk';
    protected $fillable = ['nama_produk', 'kategori', 'deskripsi', 'harga_reguler', 'harga_member', 'gambar_produk'];

    public function inventarisCabang() {
        return $this->hasMany(ProdukCabang::class, 'id_produk');
    }
}
