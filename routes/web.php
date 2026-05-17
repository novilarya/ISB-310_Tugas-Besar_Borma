<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Driver\DashboardController;
use App\Http\Controllers\Driver\TugasController;
use App\Http\Controllers\Driver\RiwayatController;
use App\Http\Controllers\Driver\ProfilController;

/*
|--------------------------------------------------------------------------
| Web Routes — Driver (Kurir) Module
|--------------------------------------------------------------------------
| Middleware auth & role:kurir dinonaktifkan sementara untuk testing.
| Aktifkan kembali setelah sistem auth siap.
*/

// Root redirect ke dashboard driver
Route::get('/', function () {
    return redirect()->route('driver.dashboard');
});

// Route Group: Driver (Kurir)
Route::prefix('driver')->name('driver.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
         ->name('dashboard');

    // Tugas (Pengiriman Aktif)
    Route::get('/tugas', [TugasController::class, 'index'])
         ->name('tugas.index');
    Route::get('/tugas/{id}', [TugasController::class, 'show'])
         ->name('tugas.show');
    Route::patch('/tugas/{id}/status', [TugasController::class, 'updateStatus'])
         ->name('tugas.updateStatus');

    // Riwayat Pesanan
    Route::get('/riwayat', [RiwayatController::class, 'index'])
         ->name('riwayat.index');
    Route::get('/riwayat/{id}', [RiwayatController::class, 'show'])
         ->name('riwayat.show');

    // Profil
    Route::get('/profil', [ProfilController::class, 'index'])
         ->name('profil.index');
    Route::get('/profil/ubah-password', [ProfilController::class, 'formUbahPassword'])
         ->name('profil.ubah-password');
    Route::post('/profil/ubah-password', [ProfilController::class, 'ubahPassword'])
         ->name('profil.ubah-password.post');
});

// Placeholder logout route (untuk tombol Keluar di profil)
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');
