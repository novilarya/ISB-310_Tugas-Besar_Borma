<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DetailPagesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // 1. Create Cabang
        \DB::table('cabang')->insert([
            'id_cabang' => 1,
            'nama_cabang' => 'Borma Gempol',
            'alamat_cabang' => 'Jl. Gempol No. 12',
            'koordinat_gps' => '-6.90123,107.61234',
            'status' => 'Aktif',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // 2. Create Admin Cabang
        $this->adminUser = \App\Models\User::create([
            'nama' => 'Admin Cabang',
            'email' => 'admin_cabang@gmail.com',
            'password' => bcrypt('password123'),
            'role' => 'Admin Cabang',
            'no_telepon' => '081234567891'
        ]);
        \DB::table('admin_cabang')->insert([
            'id_pengguna' => $this->adminUser->id_pengguna,
            'id_cabang' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // 3. Create Super Admin
        $this->superAdminUser = \App\Models\User::create([
            'nama' => 'Super Admin',
            'email' => 'superadmin@gmail.com',
            'password' => bcrypt('password123'),
            'role' => 'Admin Super',
            'no_telepon' => '081234567892'
        ]);

        // 4. Create Pelanggan (Member)
        $this->memberUser = \App\Models\User::create([
            'nama' => 'Member User',
            'email' => 'member@gmail.com',
            'password' => bcrypt('password123'),
            'role' => 'Pelanggan',
            'no_telepon' => '081234567890'
        ]);
        $this->pelanggan = \App\Models\Pelanggan::create([
            'id_pengguna' => $this->memberUser->id_pengguna,
            'provinsi' => 'Jawa Barat',
            'kota_kabupaten' => 'Bandung',
            'kecamatan' => 'Coblong',
            'alamat' => 'Jl. Dago No. 10',
            'status_member_plus' => false,
            'poin_member' => 10
        ]);

        // 5. Create Produk & Promo
        $this->produkPemicu = \App\Models\Produk::create([
            'nama_produk' => 'Pemicu Produk A',
            'kategori' => 'Makanan',
            'deskripsi' => 'Deskripsi produk pemicu',
            'harga_member' => 10000,
            'harga_member_plus' => 9000,
            'gambar_produk' => 'default.jpg'
        ]);
        $this->promo = \App\Models\Promo::create([
            'id_cabang' => 1,
            'id_produk_pemicu' => $this->produkPemicu->id_produk,
            'nama_voucher' => 'Promo Diskon Keren',
            'kode_voucher' => 'DISKONKEREN',
            'kuantitas_pemicu' => 2,
            'potongan_harga' => 5000,
            'min_transaksi' => 10000,
            'kuota_promo' => 100,
            'tanggal_mulai' => now()->subDays(1),
            'tanggal_berakhir' => now()->addDays(5)
        ]);
    }

    /**
     * Test Admin Cabang can access Member Detail Page.
     */
    public function test_admin_cabang_can_access_member_detail()
    {
        $response = $this->actingAs($this->adminUser)
            ->get(route('admin-cabang.member.detail', $this->pelanggan->id_pelanggan));

        $response->assertStatus(200);
        $response->assertSee('Detail Member');
        $response->assertSee($this->memberUser->nama);
    }



    /**
     * Test Admin Cabang can access Promo Detail Page.
     */
    public function test_admin_cabang_can_access_promo_detail()
    {
        $response = $this->actingAs($this->adminUser)
            ->get(route('admin-cabang.promo.detail', $this->promo->id_promo));

        $response->assertStatus(200);
        $response->assertSee('Detail Promo');
        $response->assertSee($this->promo->nama_voucher);
    }

    /**
     * Test Super Admin can access Promo Detail Page.
     */
    public function test_super_admin_can_access_promo_detail()
    {
        $response = $this->actingAs($this->superAdminUser)
            ->get(route('superadmin.promo.detail', $this->promo->id_promo));

        $response->assertStatus(200);
        $response->assertSee('Detail Promo: ' . $this->promo->nama_voucher);
    }

    /**
     * Test cart pricing based on Member Plus status.
     */
    public function test_cart_pricing_based_on_member_plus_status()
    {
        // 1. As regular user (status_member_plus = false)
        $this->pelanggan->status_member_plus = false;
        $this->pelanggan->save();

        $response = $this->actingAs($this->memberUser)
            ->post(route('cart.add'), [
                'product_name' => 'Pemicu Produk A',
                'quantity' => 1
            ]);

        $response->assertStatus(200);
        $this->assertEquals(10000, session('cart')[md5('Pemicu Produk A')]['price']);

        // Clear session cart
        session()->forget('cart');

        // 2. As Member Plus user (status_member_plus = true)
        $this->pelanggan->status_member_plus = true;
        $this->pelanggan->save();
        $this->memberUser->refresh();
        $this->memberUser->unsetRelation('pelanggan');

        $response = $this->actingAs($this->memberUser)
            ->post(route('cart.add'), [
                'product_name' => 'Pemicu Produk A',
                'quantity' => 1
            ]);

        $response->assertStatus(200);
        $this->assertEquals(9000, session('cart')[md5('Pemicu Produk A')]['price']);
    }

    /**
     * Test percentage capped voucher discount logic.
     */
    public function test_percentage_capped_voucher_discount_logic()
    {
        // 1. Create a promo with 10% max promo and Rp 20.000 nominal discount
        $promoPercentage = \App\Models\Promo::create([
            'id_cabang' => 1,
            'id_produk_pemicu' => $this->produkPemicu->id_produk,
            'nama_voucher' => 'Promo Capped 10 Percent',
            'kode_voucher' => 'CAPPED10',
            'kuantitas_pemicu' => 1,
            'potongan_harga' => 20000,
            'min_transaksi' => 50000,
            'max_promo' => 10, // 10%
            'kuota_promo' => 100,
            'tanggal_mulai' => now()->subDays(1),
            'tanggal_berakhir' => now()->addDays(5)
        ]);

        // Scenario A: Subtotal = 100.000. 10% is 10.000, which is less than 20.000.
        // Capped discount should be 10.000.
        $cartA = [
            md5($this->produkPemicu->nama_produk) => [
                'name' => $this->produkPemicu->nama_produk,
                'price' => 10000,
                'quantity' => 10
            ]
        ];

        $responseA = $this->actingAs($this->memberUser)
            ->withSession([
                'cart' => $cartA,
                'selected_cabang_id' => 1,
                'selected_cabang_distance' => 3
            ])
            ->postJson('/payment/create', [
                'payment_method' => 'qris',
                'total' => 95000, // 100.000 subtotal + 15.000 shipping - 20.000 discount (input, but backend recalculates)
                'customer_name' => $this->memberUser->nama,
                'customer_email' => $this->memberUser->email,
                'customer_phone' => $this->memberUser->no_telepon,
                'id_promo' => $promoPercentage->id_promo,
                'diskon_voucher' => 10000, // requested discount
            ]);

        $responseA->assertStatus(200);
        $orderIdA = $responseA->json('order_id');
        $pesananA = \App\Models\Pesanan::find($orderIdA);
        $this->assertNotNull($pesananA);
        $this->assertEquals(100000, $pesananA->total_belanja);
        $this->assertEquals(10000, $pesananA->diskon_voucher);
        $this->assertEquals(105000, $pesananA->total_tagihan); // 100.000 + 15.000 - 10.000

        // Mark as gagal to allow reusing the voucher for Scenario B
        $pesananA->status_pesanan = 'gagal';
        $pesananA->save();

        // Scenario B: Subtotal = 300.000. 10% is 30.000, which is greater than 20.000.
        // Discount should be capped at the base discount amount of 20.000.
        $cartB = [
            md5($this->produkPemicu->nama_produk) => [
                'name' => $this->produkPemicu->nama_produk,
                'price' => 10000,
                'quantity' => 30
            ]
        ];

        $responseB = $this->actingAs($this->memberUser)
            ->withSession([
                'cart' => $cartB,
                'selected_cabang_id' => 1,
                'selected_cabang_distance' => 3
            ])
            ->postJson('/payment/create', [
                'payment_method' => 'qris',
                'total' => 295000, // 300.000 subtotal + 15.000 shipping - 20.000 discount
                'customer_name' => $this->memberUser->nama,
                'customer_email' => $this->memberUser->email,
                'customer_phone' => $this->memberUser->no_telepon,
                'id_promo' => $promoPercentage->id_promo,
                'diskon_voucher' => 20000,
            ]);

        $responseB->assertStatus(200);
        $orderIdB = $responseB->json('order_id');
        $pesananB = \App\Models\Pesanan::find($orderIdB);
        $this->assertNotNull($pesananB);
        $this->assertEquals(300000, $pesananB->total_belanja);
        $this->assertEquals(20000, $pesananB->diskon_voucher);
        $this->assertEquals(295000, $pesananB->total_tagihan); // 300.000 + 15.000 - 20.000

        // Scenario C: Promo with no percentage limit (max_promo = 0 or null)
        // Expected discount = 20.000 (potongan_harga) even with 100.000 subtotal.
        $promoNoLimit = \App\Models\Promo::create([
            'id_cabang' => 1,
            'id_produk_pemicu' => $this->produkPemicu->id_produk,
            'nama_voucher' => 'Promo No Limit',
            'kode_voucher' => 'NOLIMIT',
            'kuantitas_pemicu' => 1,
            'potongan_harga' => 20000,
            'min_transaksi' => 50000,
            'max_promo' => 0, // 0 means no percentage cap
            'kuota_promo' => 100,
            'tanggal_mulai' => now()->subDays(1),
            'tanggal_berakhir' => now()->addDays(5)
        ]);

        $responseC = $this->actingAs($this->memberUser)
            ->withSession([
                'cart' => $cartA, // Subtotal 100.000
                'selected_cabang_id' => 1,
                'selected_cabang_distance' => 3
            ])
            ->postJson('/payment/create', [
                'payment_method' => 'qris',
                'total' => 95000, // 100.000 subtotal + 15.000 shipping - 20.000 discount
                'customer_name' => $this->memberUser->nama,
                'customer_email' => $this->memberUser->email,
                'customer_phone' => $this->memberUser->no_telepon,
                'id_promo' => $promoNoLimit->id_promo,
                'diskon_voucher' => 20000,
            ]);

        $responseC->assertStatus(200);
        $orderIdC = $responseC->json('order_id');
        $pesananC = \App\Models\Pesanan::find($orderIdC);
        $this->assertNotNull($pesananC);
        $this->assertEquals(100000, $pesananC->total_belanja);
        $this->assertEquals(20000, $pesananC->diskon_voucher);
        $this->assertEquals(95000, $pesananC->total_tagihan); // 100.000 + 15.000 - 20.000
    }

    /**
     * Test that a voucher can only be used once per user.
     */
    public function test_voucher_can_only_be_used_once_per_user()
    {
        // 1. Create a promo voucher
        $promo = \App\Models\Promo::create([
            'id_cabang' => 1,
            'id_produk_pemicu' => $this->produkPemicu->id_produk,
            'nama_voucher' => 'Single Use Promo',
            'kode_voucher' => 'SINGLEUSE',
            'kuantitas_pemicu' => 1,
            'potongan_harga' => 10000,
            'min_transaksi' => 30000,
            'max_promo' => 0,
            'kuota_promo' => 100,
            'tanggal_mulai' => now()->subDays(1),
            'tanggal_berakhir' => now()->addDays(5)
        ]);

        $cart = [
            md5($this->produkPemicu->nama_produk) => [
                'name' => $this->produkPemicu->nama_produk,
                'price' => 10000,
                'quantity' => 5 // 50.000 subtotal
            ]
        ];

        // Ensure the promo is visible on checkout page initially
        $checkoutResponse1 = $this->actingAs($this->memberUser)
            ->withSession([
                'cart' => $cart,
                'selected_cabang_id' => 1,
                'selected_cabang_distance' => 3
            ])
            ->get(route('pelanggan.checkout'));

        $checkoutResponse1->assertStatus(200);
        $vouchersInView1 = $checkoutResponse1->original->getData()['vouchers'];
        $this->assertTrue($vouchersInView1->contains('id_promo', $promo->id_promo));

        // 2. Perform the first checkout using the promo voucher
        $response1 = $this->actingAs($this->memberUser)
            ->withSession([
                'cart' => $cart,
                'selected_cabang_id' => 1,
                'selected_cabang_distance' => 3
            ])
            ->postJson('/payment/create', [
                'payment_method' => 'qris',
                'total' => 55000, // 50k subtotal + 15k shipping - 10k discount
                'customer_name' => $this->memberUser->nama,
                'customer_email' => $this->memberUser->email,
                'customer_phone' => $this->memberUser->no_telepon,
                'id_promo' => $promo->id_promo,
                'diskon_voucher' => 10000,
            ]);

        $response1->assertStatus(200);
        $orderId1 = $response1->json('order_id');
        $pesanan1 = \App\Models\Pesanan::find($orderId1);
        $this->assertNotNull($pesanan1);
        $this->assertEquals(10000, $pesanan1->diskon_voucher);

        // Ensure the promo is no longer visible on checkout page since it has been used
        $checkoutResponse2 = $this->actingAs($this->memberUser)
            ->withSession([
                'cart' => $cart,
                'selected_cabang_id' => 1,
                'selected_cabang_distance' => 3
            ])
            ->get(route('pelanggan.checkout'));

        $checkoutResponse2->assertStatus(200);
        $vouchersInView2 = $checkoutResponse2->original->getData()['vouchers'];
        $this->assertFalse($vouchersInView2->contains('id_promo', $promo->id_promo));

        // 3. Try to perform a second checkout using the same promo voucher (backend block check)
        $response2 = $this->actingAs($this->memberUser)
            ->withSession([
                'cart' => $cart,
                'selected_cabang_id' => 1,
                'selected_cabang_distance' => 3
            ])
            ->postJson('/payment/create', [
                'payment_method' => 'qris',
                'total' => 55000,
                'customer_name' => $this->memberUser->nama,
                'customer_email' => $this->memberUser->email,
                'customer_phone' => $this->memberUser->no_telepon,
                'id_promo' => $promo->id_promo,
                'diskon_voucher' => 10000,
            ]);

        $response2->assertStatus(400);
        $response2->assertJson([
            'status' => 'error',
            'message' => 'Anda sudah menggunakan voucher ini sebelumnya.'
        ]);

        // 4. Mark the first order as failed (status_pesanan = 'gagal') and verify user can use the voucher again
        $pesanan1->status_pesanan = 'gagal';
        $pesanan1->save();

        // Ensure the promo is visible again on checkout page after failure
        $checkoutResponse3 = $this->actingAs($this->memberUser)
            ->withSession([
                'cart' => $cart,
                'selected_cabang_id' => 1,
                'selected_cabang_distance' => 3
            ])
            ->get(route('pelanggan.checkout'));

        $checkoutResponse3->assertStatus(200);
        $vouchersInView3 = $checkoutResponse3->original->getData()['vouchers'];
        $this->assertTrue($vouchersInView3->contains('id_promo', $promo->id_promo));

        // Second checkout should succeed now
        $response3 = $this->actingAs($this->memberUser)
            ->withSession([
                'cart' => $cart,
                'selected_cabang_id' => 1,
                'selected_cabang_distance' => 3
            ])
            ->postJson('/payment/create', [
                'payment_method' => 'qris',
                'total' => 55000,
                'customer_name' => $this->memberUser->nama,
                'customer_email' => $this->memberUser->email,
                'customer_phone' => $this->memberUser->no_telepon,
                'id_promo' => $promo->id_promo,
                'diskon_voucher' => 10000,
            ]);

        $response3->assertStatus(200);
        $orderId3 = $response3->json('order_id');
        $pesanan3 = \App\Models\Pesanan::find($orderId3);
        $this->assertNotNull($pesanan3);
        $this->assertEquals(10000, $pesanan3->diskon_voucher);
    }
}
