<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class pesanan extends Model
{
    protected $table = 'pesanan';
    protected $primaryKey = 'id_pesanan';
    protected $fillable = [
        'id_pelanggan', 'id_cabang', 'id_kurir', 'id_promo', 'tanggal_pemesanan',
        'total_belanja', 'biaya_pengiriman', 'diskon_voucher', 'total_tagihan',
        'metode_pembayaran', 'alamat_pengiriman', 'status_pesanan', 'estimasi_tiba', 'bukti_pengiriman'
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
