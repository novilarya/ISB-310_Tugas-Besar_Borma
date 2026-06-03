<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengirimanTracking extends Model
{
    protected $table = 'pengiriman_tracking';
    protected $fillable = ['id_pesanan', 'status', 'keterangan'];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'id_pesanan');
    }
}
