<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kurir extends Model
{
    protected $table      = 'kurirs';
    protected $primaryKey = 'id_kurir';
    protected $fillable   = [
        'id_user', 'kendaraan', 'warna_kendaraan', 'plat_nomor',
        'id_cabang', 'penghasilan_kotor', 'penghasilan_bersih',
        'status_mengirim', 'status_aktif',
    ];

    protected $casts = [
        'penghasilan_kotor'  => 'decimal:2',
        'penghasilan_bersih' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function cabang()
    {
        return $this->belongsTo(Cabang::class, 'id_cabang', 'id_cabang');
    }

    /** Semua pesanan yang pernah ditugaskan ke kurir ini */
    public function penugasan()
    {
        return $this->hasMany(Pesanan::class, 'id_kurir', 'id_kurir');
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
}
