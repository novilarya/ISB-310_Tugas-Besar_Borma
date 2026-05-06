<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuperAdminController;

use App\Http\Controllers\AuthController;

Route::get('/superadmin/dashboard', [SuperAdminController::class, 'index'])->name('superadmin.dashboard');

Route::get('/internal/login', [AuthController::class, 'showInternalLoginForm'])->name('internal.login');
Route::post('/internal/login', [AuthController::class, 'authenticateInternal'])->name('internal.login.post');
Route::post('/internal/logout', [AuthController::class, 'logout'])->name('internal.logout');

Route::get('/admincabang/dashboard', function () {
    return 'Admin Cabang Dashboard';
})->name('admincabang.dashboard');

Route::get('/kurir/dashboard', function () {
    return 'Kurir Dashboard';
})->name('kurir.dashboard');