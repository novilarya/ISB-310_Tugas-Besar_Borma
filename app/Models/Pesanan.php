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
        'midtrans_order_id', 'snap_token',
        'metode_pembayaran', 'alamat_pengiriman', 'status_pesanan', 'estimasi_tiba', 
        'bukti_pengiriman', 'latitude', 'longitude', 'alasan_gagal', 'potongan_driver',
        'review_rating', 'review_text', 'accepted_at', 'rejected_at'
    ];

    protected $casts = [
        'accepted_at' => 'datetime',
        'rejected_at' => 'datetime',
        'tanggal_pemesanan' => 'datetime',
        'estimasi_tiba' => 'datetime',
    ];

    public function pelanggan() { 
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan', 'id_pelanggan'); 
    }
    
    public function cabang() { 
        return $this->belongsTo(Cabang::class, 'id_cabang', 'id_cabang'); 
    }
    
    public function kurir() { 
        return $this->belongsTo(Kurir::class, 'id_kurir', 'id_kurir'); 
    }
    
    public function promo() { 
        return $this->belongsTo(Promo::class, 'id_promo', 'id_promo'); 
    }

    public function details() {
        return $this->hasMany(PesananProduk::class, 'id_pesanan', 'id_pesanan');
    }

    public function buktiPengiriman() {
        return $this->hasOne(BuktiPengiriman::class, 'id_pesanan');
    }

    public function penolakanPengiriman() {
        return $this->hasOne(PenolakanPengiriman::class, 'id_pesanan');
    }

    public function pengirimanTracking() {
        return $this->hasMany(PengirimanTracking::class, 'id_pesanan');
    }
}
