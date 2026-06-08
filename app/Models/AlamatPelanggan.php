<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlamatPelanggan extends Model
{
    protected $table = 'alamat_pelanggan';
    protected $primaryKey = 'id_alamat';
    protected $fillable = ['id_pelanggan', 'label', 'provinsi', 'kota_kabupaten', 'kecamatan', 'alamat', 'is_default'];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan', 'id_pelanggan');
    }
}
