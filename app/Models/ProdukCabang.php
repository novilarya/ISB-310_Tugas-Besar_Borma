<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class produkCabang extends Model
{
    protected $table = 'produk_cabangs';
    protected $fillable = ['id_produk', 'id_cabang', 'jumlah_stok'];

    public function produk() { 
        return $this->belongsTo(Produk::class, 'id_produk'); 
    }

    public function cabang() { 
        return $this->belongsTo(Cabang::class, 'id_cabang'); 
    }
}
