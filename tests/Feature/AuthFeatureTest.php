<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_redirects_to_login()
    {
        $response = $this->get('/');
        $response->assertRedirect('/login');
    }

    public function test_login_page_is_accessible()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    /**
     * Uji apakah endpoint Google Redirect mengembalikan status 302 (Redirect).
     */
    public function test_google_redirect_route()
    {
        $response = $this->get('/auth/google/redirect');

        // Memastikan aplikasi mencoba melakukan redirect ke sistem Google
        $response->assertStatus(302);
    }

    /**
     * Uji akses ke halaman OTP tanpa session
     */
    public function test_otp_page_requires_session()
    {
        $response = $this->get('/auth/otp');
        $response->assertRedirect('/login');
    }

    /**
     * Uji checkout dialihkan ke profil jika alamat tidak lengkap
     */
    public function test_checkout_redirects_if_profile_incomplete()
    {
        $user = \App\Models\User::create([
            'nama' => 'Test User',
            'email' => 'test_' . uniqid() . '@gmail.com',
            'password' => bcrypt('password123'),
            'role' => 'Pelanggan',
            'no_telepon' => '-'
        ]);

        \App\Models\Pelanggan::create([
            'id_pengguna' => $user->id_pengguna,
            'provinsi' => '-',
            'kota_kabupaten' => '-',
            'kecamatan' => '-',
            'alamat' => '-',
            'status_member' => false,
            'poin_member' => 0
        ]);

        $response = $this->actingAs($user)
            ->withSession(['cart' => [['id' => 1, 'name' => 'Produk A', 'price' => 10000, 'quantity' => 1]]])
            ->get('/pelanggan/checkout');

        $response->assertRedirect('/pelanggan/profil');
    }

    /**
     * Uji akses ke halaman edit profil
     */
    public function test_edit_profile_page_is_accessible()
    {
        $user = \App\Models\User::create([
            'nama' => 'Test User',
            'email' => 'test_' . uniqid() . '@gmail.com',
            'password' => bcrypt('password123'),
            'role' => 'Pelanggan',
            'no_telepon' => '081234567890'
        ]);

        $response = $this->actingAs($user)->get('/pelanggan/profil/edit');
        $response->assertStatus(200);
    }

    /**
     * Uji pembaruan profil berhasil dengan data valid
     */
    public function test_profile_update_success()
    {
        $user = \App\Models\User::create([
            'nama' => 'Original Name',
            'email' => 'test_' . uniqid() . '@gmail.com',
            'password' => bcrypt('password123'),
            'role' => 'Pelanggan',
            'no_telepon' => '081234567890'
        ]);

        \App\Models\Pelanggan::create([
            'id_pengguna' => $user->id_pengguna,
            'provinsi' => 'Jawa Barat',
            'kota_kabupaten' => 'Bandung',
            'kecamatan' => 'Coblong',
            'alamat' => 'Jl. Dago',
            'status_member' => false,
            'poin_member' => 0
        ]);

        $response = $this->actingAs($user)->post('/pelanggan/profil/update', [
            'nama' => 'New Name',
            'no_telepon' => '089876543210',
            'provinsi' => 'DKI Jakarta',
            'kota_kabupaten' => 'Jakarta Selatan',
            'kecamatan' => 'Kebayoran Baru',
            'alamat' => 'Jl. Sudirman No. 45',
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123'
        ]);

        $response->assertRedirect('/pelanggan/profil');
        $this->assertDatabaseHas('pengguna', [
            'id_pengguna' => $user->id_pengguna,
            'nama' => 'New Name',
            'no_telepon' => '089876543210'
        ]);

        $this->assertDatabaseHas('pelanggan', [
            'id_pengguna' => $user->id_pengguna,
            'provinsi' => 'DKI Jakarta',
            'kota_kabupaten' => 'Jakarta Selatan',
            'kecamatan' => 'Kebayoran Baru',
            'alamat' => 'Jl. Sudirman No. 45'
        ]);
    }

    /**
     * Uji pembelian Borma Plus (aktivasi member plus) dan perhitungan tanggal kedaluwarsa.
     */
    public function test_borma_plus_purchase_flow()
    {
        // Buat cabang dengan ID 1 untuk memenuhi constraint kunci asing
        \DB::table('cabang')->insert([
            'id_cabang' => 1,
            'nama_cabang' => 'Borma Gempol',
            'alamat_cabang' => 'Jl. Gempol No. 12',
            'koordinat_gps' => '-6.90123,107.61234',
            'status' => 'Aktif',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $user = \App\Models\User::create([
            'nama' => 'Borma Plus User',
            'email' => 'plus_' . uniqid() . '@gmail.com',
            'password' => bcrypt('password123'),
            'role' => 'Pelanggan',
            'no_telepon' => '081234567890'
        ]);

        $pelanggan = \App\Models\Pelanggan::create([
            'id_pengguna' => $user->id_pengguna,
            'provinsi' => 'Jawa Barat',
            'kota_kabupaten' => 'Bandung',
            'kecamatan' => 'Coblong',
            'alamat' => 'Jl. Dago No. 10',
            'status_member' => false,
            'poin_member' => 0
        ]);

        // 1. Kirim request buat transaksi Borma Plus 2 Bulan
        $response = $this->actingAs($user)->postJson('/payment/create', [
            'payment_method' => 'qris',
            'total' => 49900,
            'customer_name' => $user->nama,
            'customer_email' => $user->email,
            'customer_phone' => $user->no_telepon,
            'items' => [
                [
                    'id' => 'MEMBER-2_BULAN',
                    'price' => 49900,
                    'quantity' => 1,
                    'name' => 'Borma Plus - 2 Bulan'
                ]
            ]
        ]);

        $response->assertStatus(200);
        $data = $response->json();
        $this->assertArrayHasKey('order_id', $data);

        $orderId = $data['order_id'];
        $pesanan = \App\Models\Pesanan::find($orderId);
        $this->assertNotNull($pesanan);
        $this->assertStringContainsString('2_BULAN', $pesanan->alamat_pengiriman);

        // 2. Simulasikan pemanggilan endpoint finish pembayaran (landed from Snap/Webhook)
        $finishResponse = $this->actingAs($user)->get('/payment/finish?order_id=' . $pesanan->midtrans_order_id);
        
        $finishResponse->assertRedirect('/pelanggan/profil');
        $finishResponse->assertSessionHas('success', 'Pembayaran berhasil! Status Anda telah berubah menjadi pelanggan Borma Plus.');

        // 3. Pastikan database pelanggan diperbarui dengan status_member = 1 dan durasi +2 bulan
        $pelanggan->refresh();
        $this->assertEquals(1, $pelanggan->status_member);
        $this->assertEquals(now()->addMonths(2)->toDateString(), $pelanggan->tanggal_berakhir_member_plus);
    }
}