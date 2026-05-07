<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class promo extends Model
{
    protected $table = 'promos';
    protected $primaryKey = 'id_promo';
    protected $fillable = [
        'id_produk_pemicu', 'id_produk_hadiah', 'nama_voucher', 'kode_voucher', 
        'kuantitas_pemicu', 'kuantitas_hadiah', 'potongan_harga', 
        'min_transaksi', 'tanggal_mulai', 'kuota_promo'
    ];

    public function produkPemicu() { 
        return $this->belongsTo(Produk::class, 'id_produk_pemicu'); 
    }
    
    public function produkHadiah() { 
        return $this->belongsTo(Produk::class, 'id_produk_hadiah'); 
    }
}
