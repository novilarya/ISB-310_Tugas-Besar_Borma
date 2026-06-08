<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Driver\DashboardController as DriverDashboardController;
use App\Http\Controllers\Driver\TugasController;
use App\Http\Controllers\Driver\RiwayatController;
use App\Http\Controllers\Driver\ProfilController as DriverProfilController;

// Super Admin Controllers
use App\Http\Controllers\SuperAdmin\DashboardController;
use App\Http\Controllers\SuperAdmin\PesananController;
use App\Http\Controllers\SuperAdmin\PengemudiController;
use App\Http\Controllers\SuperAdmin\CabangController;
use App\Http\Controllers\SuperAdmin\AdminCabangController;
use App\Http\Controllers\SuperAdmin\SuperAdminManagementController;
use App\Http\Controllers\SuperAdmin\MemberController;
use App\Http\Controllers\SuperAdmin\PromoController;
use App\Http\Controllers\SuperAdmin\HakAksesController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\MemberController as PelangganMemberController;
use App\Http\Controllers\PaymentController;
use App\Models\Cabang;

// Auth Routes
Route::get('/internal/login', [AuthController::class, 'showInternalLoginForm'])->name('internal.login');
Route::post('/internal/login', [AuthController::class, 'authenticateInternal'])->name('internal.login.post');
Route::post('/internal/logout', [AuthController::class, 'logout'])->name('internal.logout');

// Super Admin Routes
Route::prefix('superadmin')->middleware(['auth', 'superadmin'])->name('superadmin.')->group(function () {
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/notifikasi', [DashboardController::class, 'notifikasi'])->name('notifikasi');

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

    Route::post('/admin-cabang', [AdminCabangController::class, 'storeAdminCabang'])->name('admin_cabang.store');
    Route::put('/admin-cabang/{id}', [AdminCabangController::class, 'updateAdminCabang'])->name('admin_cabang.update');
    Route::delete('/admin-cabang/{id}', [AdminCabangController::class, 'destroyAdminCabang'])->name('admin_cabang.destroy');

    Route::get('/super-admin', [SuperAdminManagementController::class, 'index'])->name('super_admin');
    Route::post('/super-admin', [SuperAdminManagementController::class, 'store'])->name('super_admin.store');
    Route::put('/super-admin/{id}', [SuperAdminManagementController::class, 'update'])->name('super_admin.update');
    Route::delete('/super-admin/{id}', [SuperAdminManagementController::class, 'destroy'])->name('super_admin.destroy');

    Route::get('/member', [MemberController::class, 'member'])->name('member');
    Route::get('/member/density', [MemberController::class, 'memberDensity'])->name('member.density');
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

Route::prefix('admin-cabang')->middleware(['auth', 'admin_cabang'])->group(function () {
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

Route::get('/', function () {
    $user = auth()->user();
    if (!$user) return redirect()->route('login');
    $role = strtolower($user->role);
    if (in_array($role, ['super admin', 'admin super', 'staf operasional'])) return redirect()->route('superadmin.dashboard');
    if (in_array($role, ['admin cabang', 'admin'])) return redirect()->route('admin-cabang.dashboard');
    if (in_array($role, ['kurir', 'driver'])) return redirect()->route('driver.dashboard');
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

Route::post('/pelanggan/pesanan/{id}/confirm-received', [\App\Http\Controllers\ProfileController::class, 'confirmReceived'])
    ->middleware('auth')
    ->name('pelanggan.pesanan.confirm-received');

Route::get('/pelanggan/member', [PelangganMemberController::class, 'index'])->name('pelanggan.member');
Route::post('/pelanggan/member/activate', [PelangganMemberController::class, 'activate'])
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
/*
|--------------------------------------------------------------------------
| Web Routes — Driver (Kurir) Module
|--------------------------------------------------------------------------
*/

// Route Group: Driver (Kurir) — dilindungi middleware auth & kurir
Route::prefix('driver')->middleware(['auth', 'kurir'])->name('driver.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DriverDashboardController::class, 'index'])
         ->name('dashboard');

    // Tugas (Pengiriman Aktif)
    Route::get('/tugas', [TugasController::class, 'index'])
         ->name('tugas.index');
    Route::get('/tugas/{id}', [TugasController::class, 'show'])
         ->name('tugas.show');
    Route::post('/tugas/{id}/confirm', [TugasController::class, 'confirm'])
         ->name('tugas.confirm');
    Route::post('/tugas/{id}/reject', [TugasController::class, 'reject'])
         ->name('tugas.reject');
    Route::post('/tugas/{id}/update-status', [TugasController::class, 'updateStatus'])
         ->name('tugas.updateStatus');
    Route::post('/tugas/{id}/upload-proof', [TugasController::class, 'uploadProof'])
         ->name('tugas.uploadProof');
    Route::post('/tugas/{id}/update-location', [TugasController::class, 'updateLocation'])
         ->name('tugas.updateLocation');
         
    // Antrian Pesanan FCFS
    Route::post('/pesanan/{id}/ambil', [TugasController::class, 'ambil'])
         ->name('pesanan.ambil');
    Route::get('/pesanan/antrian/latest', [TugasController::class, 'getLatestAntrian'])
         ->name('pesanan.antrian.latest');

    // Riwayat Pesanan
    Route::get('/riwayat', [RiwayatController::class, 'index'])
         ->name('riwayat.index');
    Route::get('/pengiriman/{id}', [RiwayatController::class, 'show'])
         ->name('pengiriman.detail');
    Route::get('/riwayat/{id}', [RiwayatController::class, 'show'])
         ->name('riwayat.show');

    // Profil
    Route::get('/profil', [DriverProfilController::class, 'index'])
         ->name('profil.index');
    Route::get('/profil/ubah-password', [DriverProfilController::class, 'formUbahPassword'])
         ->name('profil.ubah-password');
    Route::post('/profil/ubah-password', [DriverProfilController::class, 'ubahPassword'])
         ->name('profil.ubah-password.post');
});
