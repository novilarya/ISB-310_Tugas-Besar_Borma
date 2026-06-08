<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kurir extends Model
{
    protected $table = 'kurir';
    protected $primaryKey = 'id_kurir';
    protected $fillable = ['id_pengguna', 'id_cabang', 'kendaraan', 'warna_kendaraan', 'plat_nomor', 'pendapatan_pengiriman', 'status_mengirim', 'status_aktif', 'driver_lat', 'driver_lng', 'location_updated_at'];

    protected $casts = [
        'pendapatan_pengiriman' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_pengguna', 'id_pengguna');
    }

    /** Pesanan aktif (sedang diantarkan) */
    public function pesananAktif()
    {
        return $this->hasOne(Pesanan::class, 'id_kurir', 'id_kurir')
            ->whereIn('status_pesanan', ['Mencari Kurir', 'Sedang Dikirim']);
    }

    /** Apakah driver sedang bebas tugas? */
    public function tersedia(): bool
    {
        return $this->status_aktif === 'Aktif' 
            && $this->status_mengirim === 'Tidak Mengirim'
            && $this->pesananAktif()->doesntExist();
    }

    public function cabang() {
        return $this->belongsTo(Cabang::class, 'id_cabang');
    }

    public function penugasan() {
        return $this->hasMany(Pesanan::class, 'id_kurir');
    }

    public function penolakanPengiriman() {
        return $this->hasMany(PenolakanPengiriman::class, 'id_kurir');
    }
}
