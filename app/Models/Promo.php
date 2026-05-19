<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    protected $table = 'promos';
    protected $primaryKey = 'id_promo';
    protected $fillable = [
        'id_cabang', 'id_produk_pemicu', 'id_produk_hadiah', 'nama_voucher', 'kode_voucher',
        'kuantitas_pemicu', 'kuantitas_hadiah', 'potongan_harga',
        'min_transaksi', 'max_promo', 'kuota_promo', 'tanggal_mulai', 'tanggal_berakhir',
    ];

    protected $casts = [
        'tanggal_mulai'    => 'date',
        'tanggal_berakhir' => 'date',
    ];

    public function cabang()
    {
        return $this->belongsTo(Cabang::class, 'id_cabang', 'id_cabang');
    }

    public function produkPemicu()
    {
        return $this->belongsTo(Produk::class, 'id_produk_pemicu', 'id_produk');
    }

    public function produkHadiah()
    {
        return $this->belongsTo(Produk::class, 'id_produk_hadiah', 'id_produk');
    }

    /** Hitung sisa hari, -1 = sudah berakhir, 0 = hari ini */
    public function sisaHari(): int
    {
        return now()->startOfDay()->diffInDays($this->tanggal_berakhir->startOfDay(), false);
    }

    /** Status: aktif | terjadwal | berakhir */
    public function statusPromo(): string
    {
        $now = now()->startOfDay();
        if ($now->gt($this->tanggal_berakhir)) return 'berakhir';
        if ($now->lt($this->tanggal_mulai))    return 'terjadwal';
        return 'aktif';
    }
}
