<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminCabangSeeder::class, // cabang, admin user, produk, stok
            OrderSeeder::class,       // pelanggan, kurir, pesanan, items
            PromoSeeder::class,       // promo & voucher
        ]);
    }
}
