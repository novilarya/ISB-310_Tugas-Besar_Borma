<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Promo extends Model
{
    protected $table = 'promos';
    protected $primaryKey = 'id_promo';
    protected $fillable = [
        'id_cabang', 'id_produk_pemicu', 'id_produk_hadiah', 'nama_voucher', 'kode_voucher', 
        'kuantitas_pemicu', 'kuantitas_hadiah', 'potongan_harga', 
        'min_transaksi', 'tanggal_mulai', 'tanggal_berakhir', 'kuota_promo', 'max_promo'
    ];

    protected $casts = [
        'tanggal_mulai'    => 'date',
        'tanggal_berakhir' => 'date',
    ];

    public function produkPemicu() { 
        return $this->belongsTo(Produk::class, 'id_produk_pemicu'); 
    }
    
    public function produkHadiah() { 
        return $this->belongsTo(Produk::class, 'id_produk_hadiah'); 
    }

    public function cabang() {
        return $this->belongsTo(Cabang::class, 'id_cabang');
    }

    public function statusPromo()
    {
        $today = now()->toDateString();
        if ($this->tanggal_berakhir < $today) {
            return 'berakhir';
        } elseif ($this->tanggal_mulai > $today) {
            return 'terjadwal';
        } else {
            return 'aktif';
        }
    }

    public function sisaHari()
    {
        $today = now()->startOfDay();
        $end = \Carbon\Carbon::parse($this->tanggal_berakhir)->startOfDay();
        return (int) $today->diffInDays($end, false);
    }
}
