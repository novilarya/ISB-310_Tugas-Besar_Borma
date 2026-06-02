<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PaymentController;
use App\Models\Cabang;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('pelanggan.dashboard');
});

Route::get('/pelanggan/dashboard', function () {
    $cabangs = Cabang::query()->where('status', 'Aktif')->get();
    return view('pelanggan.dashboard', compact('cabangs'));
})->name('pelanggan.dashboard');

Route::get('/pelanggan/katalog', function () {
    return view('pelanggan.katalog');
})->name('pelanggan.katalog');

Route::get('/pelanggan/keranjang', [CartController::class, 'index'])->name('pelanggan.keranjang');

// Cart API routes
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/cart/count', [CartController::class, 'count'])->name('cart.count');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

Route::get('/pelanggan/checkout', [CartController::class, 'checkout'])
    ->middleware('auth')
    ->name('pelanggan.checkout');

Route::get('/pelanggan/profil', [\App\Http\Controllers\ProfileController::class, 'index'])
    ->middleware('auth')
    ->name('pelanggan.profil');

Route::get('/pelanggan/member', [MemberController::class, 'index'])->name('pelanggan.member');
Route::post('/pelanggan/member/activate', [MemberController::class, 'activate'])
    ->middleware('auth')
    ->name('pelanggan.member.activate');

// API route for cabang data
Route::get('/api/cabangs', function () {
    $cabangs = Cabang::query()->where('status', 'Aktif')->get()->map(function ($cabang) {
        $coords = explode(',', $cabang->koordinat_gps);
        return [
            'id' => $cabang->id_cabang,
            'nama' => $cabang->nama_cabang,
            'alamat' => $cabang->alamat_cabang,
            'lat' => trim($coords[0] ?? '0'),
            'lng' => trim($coords[1] ?? '0'),
            'status' => $cabang->status,
        ];
    });
    return response()->json($cabangs);
})->name('api.cabangs');

// Auth routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Payment routes
Route::post('/payment/create', [PaymentController::class, 'createTransaction'])->name('payment.create');
Route::post('/payment/notification', [PaymentController::class, 'handleNotification'])->name('payment.notification');
Route::get('/payment/finish', [PaymentController::class, 'paymentFinish'])->name('payment.finish');
