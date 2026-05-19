<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminCabang extends Model
{
    protected $table = 'admin_cabangs';
    protected $primaryKey = 'id_admin_cabang';
    
    protected $fillable = [
        'id_user', 
        'id_cabang', 
        'tanggal_masuk', 
        'status_karyawan'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function cabang()
    {
        return $this->belongsTo(Cabang::class, 'id_cabang', 'id_cabang');
    }
}
