<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cabang extends Model
{
    protected $table = 'cabang';
    protected $primaryKey = 'id_cabang';
    protected $fillable = ['nama_cabang', 'alamat_cabang', 'koordinat_gps', 'status', 'settings'];

    protected $casts = [
        'settings' => 'array',
    ];

    public function stokProduk() {
        return $this->hasMany(ProdukCabang::class, 'id_cabang', 'id_cabang');
    }

    public function pesanan() {
        return $this->hasMany(Pesanan::class, 'id_cabang', 'id_cabang');
    }

    public function adminCabangs() {
        return $this->hasMany(AdminCabang::class, 'id_cabang', 'id_cabang');
    }

    public function kurirs() {
        return $this->hasMany(Kurir::class, 'id_cabang', 'id_cabang');
    }

    public function promos() {
        return $this->hasMany(Promo::class, 'id_cabang', 'id_cabang');
    }

    public function getNotifications()
    {
        $notifications = [];

        // 1. Pesanan Baru (status: Menunggu / mencari_driver)
        $newOrders = \App\Models\Pesanan::with('pelanggan.user')
            ->where('id_cabang', $this->id_cabang)
            ->whereIn('status_pesanan', ['Menunggu', 'mencari_driver'])
            ->orderByDesc('tanggal_pemesanan')
            ->get();

        foreach ($newOrders as $o) {
            $notifications[] = [
                'id' => 'order_' . $o->id_pesanan,
                'type' => 'order',
                'title' => 'Pesanan Baru #' . $o->id_pesanan,
                'message' => ($o->pelanggan->user->nama ?? 'Pelanggan') . ' - Total Tagihan: Rp ' . number_format($o->total_tagihan, 0, ',', '.'),
                'time' => $o->tanggal_pemesanan ? $o->tanggal_pemesanan->diffForHumans() : 'Baru saja',
                'url' => route('admin-cabang.pesanan'),
                'icon' => 'fa-cart-shopping',
                'icon_bg' => 'bg-amber-100 dark:bg-amber-500/20 text-amber-600 dark:text-amber-400',
                'unread' => true
            ];
        }

        // 2. Stok Menipis (jumlah_stok < 20)
        $lowStocks = \App\Models\ProdukCabang::with('produk')
            ->where('id_cabang', $this->id_cabang)
            ->where('jumlah_stok', '<', 20)
            ->get();

        foreach ($lowStocks as $ls) {
            if ($ls->produk) {
                $notifications[] = [
                    'id' => 'stock_' . $ls->id_produk_cabang,
                    'type' => 'stock',
                    'title' => 'Stok Menipis',
                    'message' => $ls->produk->nama_produk . ' tersisa ' . $ls->jumlah_stok . ' unit.',
                    'time' => 'Peringatan Sistem',
                    'url' => route('admin-cabang.produk'),
                    'icon' => 'fa-triangle-exclamation',
                    'icon_bg' => 'bg-red-100 dark:bg-red-500/20 text-red-600 dark:text-red-400',
                    'unread' => true
                ];
            }
        }

        // 3. Promo Expiring (tanggal_berakhir between today and tomorrow)
        $todayStr = now()->toDateString();
        $tomorrowStr = now()->addDay()->toDateString();
        $expiringPromos = \App\Models\Promo::where('id_cabang', $this->id_cabang)
            ->where('tanggal_berakhir', '<=', $tomorrowStr)
            ->where('tanggal_berakhir', '>=', $todayStr)
            ->get();

        foreach ($expiringPromos as $p) {
            $notifications[] = [
                'id' => 'promo_' . $p->id_promo,
                'type' => 'promo',
                'title' => 'Promo Segera Berakhir',
                'message' => 'Promo "' . $p->nama_voucher . '" berakhir pada ' . $p->tanggal_berakhir->format('d M Y') . '.',
                'time' => 'Peringatan Promo',
                'url' => route('admin-cabang.promo'),
                'icon' => 'fa-tag',
                'icon_bg' => 'bg-purple-100 dark:bg-purple-500/20 text-purple-600 dark:text-purple-400',
                'unread' => true
            ];
        }

        // 4. Benefit Member Plus Diubah (updated_at >= 7 days ago)
        $benefitSetting = \App\Models\Pengaturan::where('kunci', 'member_plus_persentase')->first();
        if ($benefitSetting && $benefitSetting->updated_at && $benefitSetting->updated_at->gt(now()->subDays(7))) {
            $maksimalSetting = \App\Models\Pengaturan::where('kunci', 'member_plus_maksimal')->value('nilai') ?? 0;
            $notifications[] = [
                'id' => 'benefit_update_' . $benefitSetting->updated_at->timestamp,
                'type' => 'benefit',
                'title' => 'Benefit Member Plus Diubah',
                'message' => 'Super Admin mengubah benefit Member Plus menjadi ' . $benefitSetting->nilai . '% (maks. Rp ' . number_format($maksimalSetting, 0, ',', '.') . ').',
                'time' => $benefitSetting->updated_at->diffForHumans(),
                'url' => route('admin-cabang.produk'),
                'icon' => 'fa-users-gear',
                'icon_bg' => 'bg-blue-100 dark:bg-blue-500/20 text-blue-600 dark:text-blue-400',
                'unread' => true
            ];
        }

        return $notifications;
    }

}
