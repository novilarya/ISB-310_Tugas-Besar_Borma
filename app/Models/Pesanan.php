<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $table = 'pesanans';
    protected $primaryKey = 'id_pesanan';
    protected $fillable = [
        'id_pelanggan', 'id_cabang', 'id_kurir', 'id_promo', 'tanggal_pemesanan',
        'total_belanja', 'biaya_pengiriman', 'diskon_voucher', 'total_tagihan',
        'metode_pembayaran', 'alamat_pengiriman', 'status_pesanan', 'estimasi_tiba', 
        'bukti_pengiriman', 'latitude', 'longitude', 'alasan_gagal', 'potongan_driver',
        'review_rating', 'review_text'
    ];

    public function pelanggan() { 
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan'); 
    }
    
    public function cabang() { 
        return $this->belongsTo(Cabang::class, 'id_cabang'); 
    }
    
    public function kurir() { 
        return $this->belongsTo(Kurir::class, 'id_kurir'); 
    }
    
    public function promo() { 
        return $this->belongsTo(Promo::class, 'id_promo'); 
    }

    public function details() {
        return $this->hasMany(PesananProduk::class, 'id_pesanan');
    }
}
