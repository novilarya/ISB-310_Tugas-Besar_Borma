<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuperAdminController;

use App\Http\Controllers\AuthController;

Route::get('/superadmin/dashboard', [SuperAdminController::class, 'index'])->name('superadmin.dashboard');
Route::get('/superadmin/pesanan', [SuperAdminController::class, 'pesanan'])->name('superadmin.pesanan');
Route::get('/superadmin/pengemudi', [SuperAdminController::class, 'pengemudi'])->name('superadmin.pengemudi');
Route::get('/superadmin/cabang', [SuperAdminController::class, 'cabang'])->name('superadmin.cabang');
Route::post('/superadmin/cabang', [SuperAdminController::class, 'storeCabang'])->name('superadmin.cabang.store');
Route::put('/superadmin/cabang/{id}', [SuperAdminController::class, 'updateCabang'])->name('superadmin.cabang.update');

Route::get('/superadmin/admin-cabang', [SuperAdminController::class, 'adminCabang'])->name('superadmin.admin_cabang');
Route::post('/superadmin/admin-cabang', [SuperAdminController::class, 'storeAdminCabang'])->name('superadmin.admin_cabang.store');
Route::put('/superadmin/admin-cabang/{id}', [SuperAdminController::class, 'updateAdminCabang'])->name('superadmin.admin_cabang.update');
Route::delete('/superadmin/admin-cabang/{id}', [SuperAdminController::class, 'destroyAdminCabang'])->name('superadmin.admin_cabang.destroy');

Route::get('/superadmin/member', [SuperAdminController::class, 'member'])->name('superadmin.member');
Route::put('/superadmin/member/{id}', [SuperAdminController::class, 'updateMember'])->name('superadmin.member.update');
Route::delete('/superadmin/member/{id}', [SuperAdminController::class, 'destroyMember'])->name('superadmin.member.destroy');
Route::get('/internal/login', [AuthController::class, 'showInternalLoginForm'])->name('internal.login');
Route::post('/internal/login', [AuthController::class, 'authenticateInternal'])->name('internal.login.post');
Route::post('/internal/logout', [AuthController::class, 'logout'])->name('internal.logout');

Route::get('/admincabang/dashboard', function () {
    return 'Admin Cabang Dashboard';
})->name('admincabang.dashboard');

Route::get('/kurir/dashboard', function () {
    return 'Kurir Dashboard';
})->name('kurir.dashboard');