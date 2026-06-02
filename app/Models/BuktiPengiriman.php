<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BuktiPengiriman extends Model
{
    protected $table = 'bukti_pengiriman';
    protected $fillable = ['id_pesanan', 'foto_bukti', 'nama_penerima', 'catatan_driver'];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'id_pesanan');
    }
}
