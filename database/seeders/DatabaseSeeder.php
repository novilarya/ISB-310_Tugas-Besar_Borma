<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Seed user dasar (Super Admin, Admin Cabang, Kurir, Pelanggan) ──
        DB::table('users')->insert([
            [
                'id_user'    => 1,
                'nama'       => 'Super Admin 1',
                'email'      => 'superadmin@gmail.com',
                'password'   => Hash::make('12345678'),
                'no_telepon' => '081234567891',
                'role'       => 'Admin Super',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id_user'    => 2,
                'nama'       => 'Admin Cabang 1',
                'email'      => 'admincabang@gmail.com',
                'password'   => Hash::make('12345678'),
                'no_telepon' => '081234567892',
                'role'       => 'Admin Cabang',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id_user'    => 3,
                'nama'       => 'Kurir 1',
                'email'      => 'kurir@gmail.com',
                'password'   => Hash::make('12345678'),
                'no_telepon' => '081234567893',
                'role'       => 'Kurir',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id_user'    => 4,
                'nama'       => 'Agus Lele',
                'email'      => 'user@gmail.com',
                'password'   => Hash::make('12345678'),
                'no_telepon' => '081234567894',
                'role'       => 'Pelanggan',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        // Pelanggan untuk user id 4
        DB::table('pelanggans')->insert([
            [
                'id_user'        => 4,
                'status_member'  => 1,
                'poin_member'    => 100,
                'provinsi'       => 'Jawa Barat',
                'kota_kabupaten' => 'Kota Bandung',
                'kecamatan'      => 'Cibeunying Kaler',
                'alamat'         => 'Jalan Gagak No 132',
                'created_at'     => Carbon::now(),
                'updated_at'     => Carbon::now(),
            ],
        ]);

        // ── Sub-seeders (urutan penting: Admin sebelum Order) ──
        $this->call([
            AdminCabangSeeder::class, // cabang, admin user, produk, stok
            OrderSeeder::class,       // pelanggan, kurir, pesanan, items
            PromoSeeder::class,       // promo & voucher
        ]);
    }
}
