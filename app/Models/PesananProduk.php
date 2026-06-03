<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PesananProduk extends Model
{
    protected $table = 'pesanan_produk';
    protected $primaryKey = 'id_pesanan_produk';
    protected $fillable = ['id_pesanan', 'id_produk', 'jumlah', 'harga_satuan', 'subtotal', 'catatan_produk'];

    public function pesanan() { 
        return $this->belongsTo(Pesanan::class, 'id_pesanan', 'id_pesanan'); 
    }
    
    public function produk() { 
        return $this->belongsTo(Produk::class, 'id_produk', 'id_produk'); 
    }
}
