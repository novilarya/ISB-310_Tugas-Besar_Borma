<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProdukCabang extends Model
{
    protected $table = 'produk_cabangs';
    protected $primaryKey = 'id_produk_cabang';
    protected $fillable = ['id_produk', 'id_cabang', 'jumlah_stok', 'jumlah_terjual'];

    public function produk() { 
        return $this->belongsTo(Produk::class, 'id_produk', 'id_produk'); 
    }

    public function cabang() { 
        return $this->belongsTo(Cabang::class, 'id_cabang', 'id_cabang'); 
    }
}
