<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotifikasiDriver extends Model
{
    protected $table    = 'notifikasi_drivers';
    protected $fillable = ['id_kurir', 'id_pesanan', 'status', 'pesan', 'dibaca'];

    public function kurir()
    {
        return $this->belongsTo(Kurir::class, 'id_kurir', 'id_kurir');
    }

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'id_pesanan', 'id_pesanan');
    }
}
