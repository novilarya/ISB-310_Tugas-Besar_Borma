<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenolakanPengiriman extends Model
{
    protected $table = 'penolakan_pengiriman';
    protected $fillable = ['id_pesanan', 'id_kurir', 'alasan'];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'id_pesanan');
    }

    public function kurir()
    {
        return $this->belongsTo(Kurir::class, 'id_kurir');
    }
}
