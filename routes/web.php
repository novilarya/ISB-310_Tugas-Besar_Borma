<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/internal/login', [AuthController::class, 'showInternalLoginForm'])->name('internal.login');
Route::post('/internal/login', [AuthController::class, 'authenticateInternal'])->name('internal.login.post');
Route::post('/internal/logout', [AuthController::class, 'logout'])->name('internal.logout');

Route::prefix('admin-cabang')->middleware('auth')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\AdminCabang\DashboardController::class, 'index'])
        ->name('admin-cabang.dashboard');
    Route::get('/notifikasi', [\App\Http\Controllers\AdminCabang\DashboardController::class, 'notifikasi'])
        ->name('admin-cabang.notifikasi');

    // Produk
    Route::get('/produk', [\App\Http\Controllers\AdminCabang\ProductController::class, 'index'])->name('admin-cabang.produk');
    Route::get('/produk/export-csv', [\App\Http\Controllers\AdminCabang\ProductController::class, 'exportCsv'])->name('admin-cabang.produk.export-csv');
    Route::post('/produk/store', [\App\Http\Controllers\AdminCabang\ProductController::class, 'store'])->name('admin-cabang.produk.store');
    Route::get('/produk/detail', [\App\Http\Controllers\AdminCabang\ProductController::class, 'detail'])->name('admin-cabang.produk.detail');
    Route::put('/produk/update/{id}', [\App\Http\Controllers\AdminCabang\ProductController::class, 'update'])->name('admin-cabang.produk.update');
    Route::delete('/produk/delete/{id}', [\App\Http\Controllers\AdminCabang\ProductController::class, 'destroy'])->name('admin-cabang.produk.delete');

    // Pesanan — CRUD & Status Machine
    Route::get('/pesanan',                   [\App\Http\Controllers\AdminCabang\OrderController::class, 'index'])->name('admin-cabang.pesanan');
    Route::get('/pesanan/{id}',              [\App\Http\Controllers\AdminCabang\OrderController::class, 'show'])->name('admin-cabang.pesanan.show');
    Route::get('/pesanan/{id}/json',         [\App\Http\Controllers\AdminCabang\OrderController::class, 'showJson'])->name('admin-cabang.pesanan.json');
    Route::get('/pesanan/{id}/nota',         [\App\Http\Controllers\AdminCabang\OrderController::class, 'nota'])->name('admin-cabang.pesanan.nota');

    // Status Transitions
    Route::post('/pesanan/{id}/confirm',        [\App\Http\Controllers\AdminCabang\OrderController::class, 'confirm'])->name('admin-cabang.pesanan.confirm');
    Route::post('/pesanan/{id}/dispatch',       [\App\Http\Controllers\AdminCabang\OrderController::class, 'dispatch'])->name('admin-cabang.pesanan.dispatch');
    Route::post('/pesanan/{id}/cancel-dispatch',[\App\Http\Controllers\AdminCabang\OrderController::class, 'cancelDispatch'])->name('admin-cabang.pesanan.cancel-dispatch');
    Route::post('/pesanan/{id}/complete',       [\App\Http\Controllers\AdminCabang\OrderController::class, 'complete'])->name('admin-cabang.pesanan.complete');

    // API untuk Panel Driver (digunakan rekan tim)
    Route::post('/pesanan/{id}/driver-accept',  [\App\Http\Controllers\AdminCabang\OrderController::class, 'driverAccept'])->name('admin-cabang.pesanan.driver-accept');
    Route::get('/driver/{kurirId}/notifikasi',  [\App\Http\Controllers\AdminCabang\OrderController::class, 'driverNotifikasi'])->name('admin-cabang.driver.notifikasi');

    // Member
    Route::get('/member', [\App\Http\Controllers\AdminCabang\MemberController::class, 'index'])->name('admin-cabang.member');
    Route::post('/member/store', [\App\Http\Controllers\AdminCabang\MemberController::class, 'store'])->name('admin-cabang.member.store');

    // Promo & Voucher
    Route::get('/promo', [\App\Http\Controllers\AdminCabang\PromoController::class, 'index'])->name('admin-cabang.promo');
    Route::post('/promo/store', [\App\Http\Controllers\AdminCabang\PromoController::class, 'store'])->name('admin-cabang.promo.store');
    Route::put('/promo/update/{id}', [\App\Http\Controllers\AdminCabang\PromoController::class, 'update'])->name('admin-cabang.promo.update');
    Route::delete('/promo/delete/{id}', [\App\Http\Controllers\AdminCabang\PromoController::class, 'destroy'])->name('admin-cabang.promo.delete');

    // Laporan
    Route::get('/laporan', [\App\Http\Controllers\AdminCabang\ReportController::class, 'index'])->name('admin-cabang.laporan');
    Route::get('/laporan/export-csv', [\App\Http\Controllers\AdminCabang\ReportController::class, 'exportCsv'])->name('admin-cabang.laporan.export-csv');

    // Pengaturan
    Route::get('/pengaturan', [\App\Http\Controllers\AdminCabang\SettingController::class, 'index'])->name('admin-cabang.pengaturan');
    Route::post('/pengaturan/profil',     [\App\Http\Controllers\AdminCabang\SettingController::class, 'updateProfil'])->name('admin-cabang.pengaturan.profil');
    Route::post('/pengaturan/cabang',     [\App\Http\Controllers\AdminCabang\SettingController::class, 'updateCabang'])->name('admin-cabang.pengaturan.cabang');
    Route::post('/pengaturan/password',   [\App\Http\Controllers\AdminCabang\SettingController::class, 'updatePassword'])->name('admin-cabang.pengaturan.password');
    Route::post('/pengaturan/notifikasi', [\App\Http\Controllers\AdminCabang\SettingController::class, 'updateNotifikasi'])->name('admin-cabang.pengaturan.notifikasi');
});

Route::get('/preview-invoice', function () {
    $pesanan = \App\Models\Pesanan::with(['pelanggan.user', 'details.produk', 'cabang'])->first();
    if (!$pesanan) {
        return "Belum ada data pesanan di database. Silakan jalankan seeder terlebih dahulu.";
    }
    return new \App\Mail\InvoiceMail($pesanan);
})->name('preview.invoice');

Route::get('/invoice/nota/{id}', [\App\Http\Controllers\AdminCabang\OrderController::class, 'publicNota'])->name('public.pesanan.nota');
