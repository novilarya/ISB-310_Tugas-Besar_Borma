<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PromoSeeder extends Seeder
{
    public function run(): void
    {
        $today = Carbon::today();

        // Promo aktif — "Beli 2 Gratis 1 Minyak Goreng" (Branch 1)
        DB::table('promos')->insert([
            'id_cabang'         => 1,
            'id_produk_pemicu'  => 1, // Minyak Goreng Bimoli
            'id_produk_hadiah'  => 1,
            'nama_voucher'      => 'Beli 2 Gratis 1 Minyak Goreng',
            'kode_voucher'      => 'BUY2FREE1',
            'kuantitas_pemicu'  => 2,
            'kuantitas_hadiah'  => 1,
            'potongan_harga'    => 0,
            'min_transaksi'     => 69000,
            'max_promo'         => 35000,
            'kuota_promo'       => 100,
            'tanggal_mulai'     => $today->copy()->subDays(3)->toDateString(),
            'tanggal_berakhir'  => $today->copy()->addDays(7)->toDateString(),
            'created_at'        => now(),
            'updated_at'        => now(),
        ]);

        // Promo aktif — "Diskon 15% Beras Pandan Wangi" (Branch 1)
        DB::table('promos')->insert([
            'id_cabang'         => 1,
            'id_produk_pemicu'  => 2, // Beras Pandan Wangi
            'id_produk_hadiah'  => null,
            'nama_voucher'      => 'Diskon 15% Beras Premium',
            'kode_voucher'      => 'BERAS15',
            'kuantitas_pemicu'  => 1,
            'kuantitas_hadiah'  => 0,
            'potongan_harga'    => 11250,
            'min_transaksi'     => 75000,
            'max_promo'         => 15000,
            'kuota_promo'       => 50,
            'tanggal_mulai'     => $today->copy()->subDays(1)->toDateString(),
            'tanggal_berakhir'  => $today->copy()->addDays(14)->toDateString(),
            'created_at'        => now(),
            'updated_at'        => now(),
        ]);

        // Promo terjadwal — "Spesial Akhir Bulan" (Branch 2)
        DB::table('promos')->insert([
            'id_cabang'         => 2,
            'id_produk_pemicu'  => 3, // Susu UHT
            'id_produk_hadiah'  => null,
            'nama_voucher'      => 'Spesial Akhir Bulan - Diskon 20%',
            'kode_voucher'      => 'AKHIRBULAN20',
            'kuantitas_pemicu'  => 2,
            'kuantitas_hadiah'  => 0,
            'potongan_harga'    => 7400,
            'min_transaksi'     => 37000,
            'max_promo'         => 10000,
            'kuota_promo'       => 200,
            'tanggal_mulai'     => $today->copy()->addDays(5)->toDateString(),
            'tanggal_berakhir'  => $today->copy()->addDays(10)->toDateString(),
            'created_at'        => now(),
            'updated_at'        => now(),
        ]);

        // Promo sudah berakhir — "Promo Lebaran" (Branch 2)
        DB::table('promos')->insert([
            'id_cabang'         => 2,
            'id_produk_pemicu'  => 4, // Sabun Cuci
            'id_produk_hadiah'  => null,
            'nama_voucher'      => 'Promo Lebaran - Hemat 25%',
            'kode_voucher'      => 'LEBARAN25',
            'kuantitas_pemicu'  => 1,
            'kuantitas_hadiah'  => 0,
            'potongan_harga'    => 3875,
            'min_transaksi'     => 15000,
            'max_promo'         => 5000,
            'kuota_promo'       => 300,
            'tanggal_mulai'     => $today->copy()->subDays(30)->toDateString(),
            'tanggal_berakhir'  => $today->copy()->subDays(2)->toDateString(),
            'created_at'        => now()->subDays(30),
            'updated_at'        => now()->subDays(2),
        ]);
    }
}
