<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class kurir extends Model
{
    protected $table = 'kurirs';
    protected $primaryKey = 'id_kurir';
    protected $fillable = ['id_user', 'id_cabang', 'kendaraan', 'warna_kendaraan', 'plat_nomor', 'penghasilan_kotor', 'penghasilan_bersih', 'status_mengirim', 'status_aktif', 'driver_lat', 'driver_lng', 'location_updated_at'];

    public function user() {
        return $this->belongsTo(User::class, 'id_user');
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
