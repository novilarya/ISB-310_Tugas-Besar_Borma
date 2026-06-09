<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

use Illuminate\Support\Facades\Schedule;
use App\Models\Pesanan;

Schedule::call(function () {
    $expiredOrders = Pesanan::where('status_pesanan', 'diterima')
        ->where('updated_at', '<=', now()->subHours(24))
        ->get();

    foreach ($expiredOrders as $pesanan) {
        $pesanan->update(['status_pesanan' => 'selesai']);
        
        \App\Models\PengirimanTracking::create([
            'id_pesanan' => $pesanan->id_pesanan,
            'status' => 'selesai',
            'keterangan' => 'Pesanan otomatis diselesaikan oleh sistem setelah 24 jam'
        ]);
    }
})->hourly();
