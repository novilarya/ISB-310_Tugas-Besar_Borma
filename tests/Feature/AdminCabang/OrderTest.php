<?php

namespace Tests\Feature\AdminCabang;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Pelanggan;
use App\Models\Kurir;
use App\Models\Pesanan;
use App\Models\PengirimanTracking;
use App\Mail\InvoiceMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    protected $adminUser;
    protected $pelanggan;
    protected $kurir;

    protected function setUp(): void
    {
        parent::setUp();

        // 1. Buat Cabang Utama (ID = 1)
        DB::table('cabang')->insert([
            'id_cabang' => 1,
            'nama_cabang' => 'Borma Gempol',
            'alamat_cabang' => 'Jl. Gempol No. 12',
            'koordinat_gps' => '-6.90123,107.61234',
            'status' => 'Aktif',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Buat Cabang Lain (ID = 2) untuk menguji batasan hak akses cabang
        DB::table('cabang')->insert([
            'id_cabang' => 2,
            'nama_cabang' => 'Borma Dago',
            'alamat_cabang' => 'Jl. Dago No. 100',
            'koordinat_gps' => '-6.80123,107.61234',
            'status' => 'Aktif',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // 2. Buat Admin Cabang Borma Gempol (Cabang 1)
        $this->adminUser = User::create([
            'nama' => 'Admin Gempol',
            'email' => 'admin.gempol@borma.com',
            'password' => Hash::make('password123'),
            'role' => 'Admin Cabang',
            'no_telepon' => '081234567891'
        ]);
        DB::table('admin_cabang')->insert([
            'id_pengguna' => $this->adminUser->id_pengguna,
            'id_cabang' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // 3. Buat Pelanggan (User + Pelanggan)
        $userPelanggan = User::create([
            'nama' => 'Budi Santoso',
            'email' => 'budi@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'Pelanggan',
            'no_telepon' => '081234567890'
        ]);
        $this->pelanggan = Pelanggan::create([
            'id_pengguna' => $userPelanggan->id_pengguna,
            'provinsi' => 'Jawa Barat',
            'kota_kabupaten' => 'Bandung',
            'kecamatan' => 'Coblong',
            'alamat' => 'Jl. Coblong No. 5',
            'status_member_plus' => false,
            'poin_member' => 0
        ]);

        // 4. Buat Kurir (User + Kurir)
        $userKurir = User::create([
            'nama' => 'Asep Driver',
            'email' => 'asep@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'Kurir',
            'no_telepon' => '089987654321'
        ]);
        $this->kurir = Kurir::create([
            'id_pengguna' => $userKurir->id_pengguna,
            'id_cabang' => 1,
            'kendaraan' => 'Motor',
            'warna_kendaraan' => 'Hitam',
            'plat_nomor' => 'D 1234 ABC',
            'status_mengirim' => 'Tidak Mengirim',
            'status_aktif' => 'Aktif',
            'driver_lat' => '-6.90123',
            'driver_lng' => '107.61234'
        ]);
    }

    /**
     * White-Box Test: Dashboard & Filter Pesanan (OrderController@index)
     * Menguji query filter status, pencarian nama pelanggan, dan sorting tanggal.
     */
    public function test_admin_cabang_can_list_orders_with_filters()
    {
        // 1. Buat data pesanan tiruan (Mock)
        $pesananMenunggu = Pesanan::create([
            'id_pelanggan' => $this->pelanggan->id_pelanggan,
            'id_cabang' => 1,
            'tanggal_pemesanan' => now(),
            'total_belanja' => 100000,
            'biaya_pengiriman' => 10000,
            'total_tagihan' => 110000,
            'metode_pembayaran' => 'qris',
            'alamat_pengiriman' => 'Jl. Coblong No. 5',
            'status_pesanan' => 'Menunggu'
        ]);

        $pesananDisiapkan = Pesanan::create([
            'id_pelanggan' => $this->pelanggan->id_pelanggan,
            'id_cabang' => 1,
            'tanggal_pemesanan' => now()->subDay(),
            'total_belanja' => 50000,
            'biaya_pengiriman' => 5000,
            'total_tagihan' => 55000,
            'metode_pembayaran' => 'cod',
            'alamat_pengiriman' => 'Jl. Coblong No. 5',
            'status_pesanan' => 'Disiapkan'
        ]);

        $this->actingAs($this->adminUser);

        // Percabangan 1: Tampilkan Semua Pesanan Cabang 1
        $responseAll = $this->get(route('admin-cabang.pesanan'));
        $responseAll->assertStatus(200);
        $this->assertCount(2, $responseAll->viewData('pesanans'));

        // Percabangan 2: Filter Status = "Menunggu"
        $responseFilterStatus = $this->get(route('admin-cabang.pesanan', ['status' => 'Menunggu']));
        $responseFilterStatus->assertStatus(200);
        $pesanansFilter = $responseFilterStatus->viewData('pesanans');
        $this->assertCount(1, $pesanansFilter);
        $this->assertEquals('Menunggu', $pesanansFilter->first()->status_pesanan);

        // Percabangan 3: Filter Pencarian berdasarkan Nama "Budi" (Search query)
        $responseSearch = $this->get(route('admin-cabang.pesanan', ['search' => 'Budi']));
        $responseSearch->assertStatus(200);
        $this->assertCount(2, $responseSearch->viewData('pesanans'));
    }

    /**
     * White-Box Test: Konfirmasi Pesanan (OrderController@confirm)
     * Menguji transisi status dari 'Menunggu' ke 'Disiapkan' dan pengiriman email otomatis.
     */
    public function test_admin_cabang_can_confirm_pending_order()
    {
        Mail::fake();

        // 1. Buat pesanan dengan status 'Menunggu'
        $pesanan = Pesanan::create([
            'id_pelanggan' => $this->pelanggan->id_pelanggan,
            'id_cabang' => 1,
            'tanggal_pemesanan' => now(),
            'total_belanja' => 150000,
            'biaya_pengiriman' => 10000,
            'total_tagihan' => 160000,
            'metode_pembayaran' => 'qris',
            'alamat_pengiriman' => 'Jl. Coblong No. 5',
            'status_pesanan' => 'Menunggu'
        ]);

        $this->actingAs($this->adminUser);

        // Eksekusi aksi konfirmasi
        $response = $this->post(route('admin-cabang.pesanan.confirm', $pesanan->id_pesanan));

        // Harus dialihkan kembali dengan sukses
        $response->assertRedirect();
        $response->assertSessionHas('success');

        // Pastikan status di database berubah menjadi 'Disiapkan'
        $pesanan->refresh();
        $this->assertEquals('Disiapkan', $pesanan->status_pesanan);

        // Pastikan sistem memicu pengiriman email InvoiceMail ke pelanggan
        Mail::assertSent(InvoiceMail::class, function ($mail) use ($pesanan) {
            return $mail->hasTo($this->pelanggan->user->email) &&
                   $mail->pesanan->id_pesanan === $pesanan->id_pesanan;
        });
    }

    /**
     * White-Box Test: Pengaman Konfirmasi (Guard Clause) pada OrderController@confirm
     * Menguji penolakan aksi jika status pesanan bukan 'Menunggu'.
     */
    public function test_admin_cabang_cannot_confirm_non_pending_order()
    {
        Mail::fake();

        // Buat pesanan yang sudah berstatus 'Disiapkan'
        $pesanan = Pesanan::create([
            'id_pelanggan' => $this->pelanggan->id_pelanggan,
            'id_cabang' => 1,
            'tanggal_pemesanan' => now(),
            'total_belanja' => 150000,
            'biaya_pengiriman' => 10000,
            'total_tagihan' => 160000,
            'metode_pembayaran' => 'qris',
            'alamat_pengiriman' => 'Jl. Coblong No. 5',
            'status_pesanan' => 'Disiapkan'
        ]);

        $this->actingAs($this->adminUser);

        $response = $this->post(route('admin-cabang.pesanan.confirm', $pesanan->id_pesanan));
        $response->assertSessionHas('error', 'Pesanan tidak dalam status Menunggu Konfirmasi.');

        // Status harus tetap 'Disiapkan' (tidak berubah)
        $pesanan->refresh();
        $this->assertEquals('Disiapkan', $pesanan->status_pesanan);

        // Tidak ada email yang dikirim
        Mail::assertNothingSent();
    }

    /**
     * White-Box Test: Proteksi Cabang (Multi-Branch Isolation Guard)
     * Menguji bahwa Admin Cabang A tidak dapat mengelola pesanan milik Cabang B.
     */
    public function test_admin_cabang_cannot_manage_orders_from_other_cabang()
    {
        // Buat pesanan milik Cabang 2 (Dago)
        $pesananCabangLain = Pesanan::create([
            'id_pelanggan' => $this->pelanggan->id_pelanggan,
            'id_cabang' => 2, // Cabang lain
            'tanggal_pemesanan' => now(),
            'total_belanja' => 100000,
            'biaya_pengiriman' => 10000,
            'total_tagihan' => 110000,
            'metode_pembayaran' => 'qris',
            'alamat_pengiriman' => 'Jl. Dago No. 100',
            'status_pesanan' => 'Menunggu'
        ]);

        // Login sebagai Admin Cabang Gempol (Cabang 1)
        $this->actingAs($this->adminUser);

        // Mencoba konfirmasi pesanan Cabang 2
        $response = $this->post(route('admin-cabang.pesanan.confirm', $pesananCabangLain->id_pesanan));
        
        // Harus mengembalikan pesan error "Pesanan tidak ditemukan" (karena ter-filter oleh query scope cabang)
        $response->assertSessionHas('error', 'Pesanan tidak ditemukan.');

        // Status pesanan Cabang 2 harus tetap 'Menunggu'
        $pesananCabangLain->refresh();
        $this->assertEquals('Menunggu', $pesananCabangLain->status_pesanan);
    }

    /**
     * White-Box Test: Pengiriman Driver (OrderController@dispatch)
     * Menguji inisiasi pencarian driver dari status 'Disiapkan' ke 'mencari_driver'.
     */
    public function test_admin_cabang_can_dispatch_order()
    {
        // Buat pesanan 'Disiapkan'
        $pesanan = Pesanan::create([
            'id_pelanggan' => $this->pelanggan->id_pelanggan,
            'id_cabang' => 1,
            'tanggal_pemesanan' => now(),
            'total_belanja' => 150000,
            'biaya_pengiriman' => 10000,
            'total_tagihan' => 160000,
            'metode_pembayaran' => 'qris',
            'alamat_pengiriman' => 'Jl. Coblong No. 5',
            'status_pesanan' => 'Disiapkan'
        ]);

        $this->actingAs($this->adminUser);

        $response = $this->post(route('admin-cabang.pesanan.dispatch', $pesanan->id_pesanan));
        $response->assertRedirect();
        $response->assertSessionHas('success');

        $pesanan->refresh();
        $this->assertEquals('mencari_driver', $pesanan->status_pesanan);
        $this->assertNull($pesanan->id_kurir);
        $this->assertNotNull($pesanan->estimasi_tiba);
    }

    /**
     * White-Box Test: Pembatalan Pengiriman (OrderController@cancelDispatch)
     * Menguji pembatalan pencarian kurir kembali ke status 'Disiapkan'.
     */
    public function test_admin_cabang_can_cancel_dispatch()
    {
        // Buat pesanan 'mencari_driver'
        $pesanan = Pesanan::create([
            'id_pelanggan' => $this->pelanggan->id_pelanggan,
            'id_cabang' => 1,
            'tanggal_pemesanan' => now(),
            'total_belanja' => 150000,
            'biaya_pengiriman' => 10000,
            'total_tagihan' => 160000,
            'metode_pembayaran' => 'qris',
            'alamat_pengiriman' => 'Jl. Coblong No. 5',
            'status_pesanan' => 'mencari_driver'
        ]);

        $this->actingAs($this->adminUser);

        $response = $this->post(route('admin-cabang.pesanan.cancel-dispatch', $pesanan->id_pesanan));
        $response->assertRedirect();
        $response->assertSessionHas('success');

        $pesanan->refresh();
        $this->assertEquals('Disiapkan', $pesanan->status_pesanan);
        $this->assertNull($pesanan->estimasi_tiba);
    }

    /**
     * White-Box Test: Penyelesaian Pengiriman (OrderController@complete)
     * Menguji transisi status ke 'selesai', pembebasan tugas kurir, dan pencatatan tracking log.
     */
    public function test_admin_cabang_can_complete_order()
    {
        // Buat pesanan 'dalam_pengiriman' lengkap dengan id_kurir
        $pesanan = Pesanan::create([
            'id_pelanggan' => $this->pelanggan->id_pelanggan,
            'id_cabang' => 1,
            'id_kurir' => $this->kurir->id_kurir,
            'tanggal_pemesanan' => now(),
            'total_belanja' => 150000,
            'biaya_pengiriman' => 10000,
            'total_tagihan' => 160000,
            'metode_pembayaran' => 'qris',
            'alamat_pengiriman' => 'Jl. Coblong No. 5',
            'status_pesanan' => 'dalam_pengiriman'
        ]);

        // Tandai kurir sedang sibuk mengirim
        $this->kurir->update(['status_mengirim' => 'Sedang Mengirim']);

        $this->actingAs($this->adminUser);

        $response = $this->post(route('admin-cabang.pesanan.complete', $pesanan->id_pesanan));
        $response->assertRedirect();
        $response->assertSessionHas('success');

        $pesanan->refresh();
        $this->assertEquals('selesai', $pesanan->status_pesanan);

        // Pastikan kurir kembali dibebaskan tugasnya ('Tidak Mengirim')
        $this->kurir->refresh();
        $this->assertEquals('Tidak Mengirim', $this->kurir->status_mengirim);

        // Memverifikasi penulisan log tracking internal
        $this->assertDatabaseHas('pengiriman_tracking', [
            'id_pesanan' => $pesanan->id_pesanan,
            'status' => 'selesai',
            'keterangan' => 'Pesanan dikonfirmasi selesai oleh Admin Cabang'
        ]);
    }
}
