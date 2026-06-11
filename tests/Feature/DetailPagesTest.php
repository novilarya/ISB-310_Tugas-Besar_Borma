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
}
