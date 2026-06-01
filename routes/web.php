<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Super Admin Controllers
use App\Http\Controllers\SuperAdmin\DashboardController;
use App\Http\Controllers\SuperAdmin\PesananController;
use App\Http\Controllers\SuperAdmin\PengemudiController;
use App\Http\Controllers\SuperAdmin\CabangController;
use App\Http\Controllers\SuperAdmin\AdminCabangController;
use App\Http\Controllers\SuperAdmin\MemberController;
use App\Http\Controllers\SuperAdmin\PromoController;
use App\Http\Controllers\SuperAdmin\HakAksesController;

// Auth Routes
Route::get('/internal/login', [AuthController::class, 'showInternalLoginForm'])->name('internal.login');
Route::post('/internal/login', [AuthController::class, 'authenticateInternal'])->name('internal.login.post');
Route::post('/internal/logout', [AuthController::class, 'logout'])->name('internal.logout');


// Super Admin Routes
Route::prefix('superadmin')->name('superadmin.')->group(function () {
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/pesanan', [PesananController::class, 'pesanan'])->name('pesanan');
    Route::get('/pesanan/{id}', [PesananController::class, 'pesananDetail'])->name('pesanan.detail');

    Route::get('/pengemudi', [PengemudiController::class, 'pengemudi'])->name('pengemudi');
    Route::post('/pengemudi', [PengemudiController::class, 'storePengemudi'])->name('pengemudi.store');
    Route::put('/pengemudi/{id}', [PengemudiController::class, 'updatePengemudi'])->name('pengemudi.update');
    Route::delete('/pengemudi/{id}', [PengemudiController::class, 'destroyPengemudi'])->name('pengemudi.destroy');
    Route::get('/pengemudi/{id}', [PengemudiController::class, 'pengemudiDetail'])->name('pengemudi.detail');

    Route::get('/cabang', [CabangController::class, 'cabang'])->name('cabang');
    Route::post('/cabang', [CabangController::class, 'storeCabang'])->name('cabang.store');
    Route::put('/cabang/{id}', [CabangController::class, 'updateCabang'])->name('cabang.update');
    Route::delete('/cabang/{id}', [CabangController::class, 'destroyCabang'])->name('cabang.destroy');
    Route::get('/cabang/{id}', [CabangController::class, 'cabangDetail'])->name('cabang.detail');

    Route::get('/admin-cabang', [AdminCabangController::class, 'adminCabang'])->name('admin_cabang');
    Route::post('/admin-cabang', [AdminCabangController::class, 'storeAdminCabang'])->name('admin_cabang.store');
    Route::put('/admin-cabang/{id}', [AdminCabangController::class, 'updateAdminCabang'])->name('admin_cabang.update');
    Route::delete('/admin-cabang/{id}', [AdminCabangController::class, 'destroyAdminCabang'])->name('admin_cabang.destroy');

    Route::get('/member', [MemberController::class, 'member'])->name('member');
    Route::get('/member/{id}', [MemberController::class, 'detailMember'])->name('member.detail');
    Route::put('/member/{id}', [MemberController::class, 'updateMember'])->name('member.update');
    Route::delete('/member/{id}', [MemberController::class, 'destroyMember'])->name('member.destroy');

    Route::get('/promo', [PromoController::class, 'promo'])->name('promo');
    Route::post('/promo', [PromoController::class, 'storePromo'])->name('promo.store');
    Route::put('/promo/update/{id}', [PromoController::class, 'updatePromo'])->name('promo.update');
    Route::delete('/promo/delete/{id}', [PromoController::class, 'destroyPromo'])->name('promo.delete');

    Route::get('/hak-akses', [HakAksesController::class, 'hakAkses'])->name('hak_akses');
    Route::post('/hak-akses/{userId}', [HakAksesController::class, 'updateHakAkses'])->name('hak_akses.update');
});


// Admin Cabang Routes
Route::get('/admincabang/dashboard', function () {
    return 'Admin Cabang Dashboard';
})->name('admincabang.dashboard');


// Kurir Routes
Route::get('/kurir/dashboard', function () {
    return 'Kurir Dashboard';
})->name('kurir.dashboard');