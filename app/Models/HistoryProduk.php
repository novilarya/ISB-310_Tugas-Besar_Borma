<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoryProduk extends Model
{
    protected $table = 'history_produks';
    protected $primaryKey = 'id_history';
    protected $fillable = [
        'id_produk', 'harga_reguler_lama', 'harga_reguler_baru',
        'harga_member_lama', 'harga_member_baru', 'id_admin_cabang',
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id_produk');
    }

    public function adminCabang()
    {
        return $this->belongsTo(AdminCabang::class, 'id_admin_cabang', 'id_admin_cabang');
    }
}
