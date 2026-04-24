<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class pelanggan extends Model
{
    protected $table = 'pelanggan';
    protected $primaryKey = 'id_pelanggan';
    protected $fillable = ['id_user', 'status_member', 'poin_member', 'alamat'];

    public function user() {
        return $this->belongsTo(User::class, 'id_user');
    }
 
    public function riwayatPesanan() {
        return $this->hasMany(Pesanan::class, 'id_pelanggan');
    }
}
