<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Kurir;
use App\Models\Cabang;
use App\Models\Pelanggan;
use App\Models\Pesanan;
use App\Models\PesananProduk;
use App\Models\Produk;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ===== CREATE CABANG =====
        $cabangAntapani = Cabang::create([
            'nama_cabang' => 'ANTAPANI',
            'alamat_cabang' => 'Jl. Antapani No. 123, Bandung',
            'koordinat_gps' => '-6.9147,107.0842',
        ]);

        $cabangPusat = Cabang::create([
            'nama_cabang' => 'GUDANG PUSAT BOJONGSOANG',
            'alamat_cabang' => 'Jl. Bojongsoang, Bandung',
            'koordinat_gps' => '-6.9500,107.1000',
        ]);

        $cabangBelumadd = Cabang::create([
            'nama_cabang' => 'BELUM ADA',
            'alamat_cabang' => 'Alamat Belum Ditentukan',
            'koordinat_gps' => '-',
        ]);

        // ===== CREATE DRIVER USERS =====
        $userDriver1 = User::create([
            'nama' => 'ANDI PRATAMA',
            'email' => 'andi@borma.com',
            'password' => bcrypt('password'),
            'no_telepon' => '081234567890',
            'role' => 'kurir',
        ]);

        $userDriver2 = User::create([
            'nama' => 'BUDI SANTOSO',
            'email' => 'budi@borma.com',
            'password' => bcrypt('password'),
            'no_telepon' => '081234567891',
            'role' => 'kurir',
        ]);

        // ===== CREATE KURIR =====
        $kurir1 = Kurir::create([
            'id_user' => $userDriver1->id_user,
            'id_cabang' => $cabangAntapani->id_cabang,
            'kode_driver' => 'D45',
            'kendaraan' => 'Motor',
            'warna_kendaraan' => 'Hitam',
            'plat_nomor' => 'B 1234 ABC',
        ]);

        $kurir2 = Kurir::create([
            'id_user' => $userDriver2->id_user,
            'id_cabang' => $cabangBelumadd->id_cabang,
            'kode_driver' => 'D00',
            'kendaraan' => 'Mobil',
            'warna_kendaraan' => 'Putih',
            'plat_nomor' => 'B 5678 XYZ',
        ]);

        // ===== CREATE PELANGGAN =====
        $pelanggan1 = User::create([
            'nama' => 'PT. MEDIS JAYA',
            'email' => 'medis@gmail.com',
            'password' => bcrypt('password'),
            'no_telepon' => '082212345678',
            'role' => 'pelanggan',
        ]);

        $pelCustomer1 = Pelanggan::create([
            'id_user' => $pelanggan1->id_user,
            'status_member' => 'premium',
            'poin_member' => 500,
            'alamat' => 'Jl. Merdeka 45, Bandung',
        ]);

        $pelanggan2 = User::create([
            'nama' => 'CV JAYA SENTOSA',
            'email' => 'jaya@gmail.com',
            'password' => bcrypt('password'),
            'no_telepon' => '082312345679',
            'role' => 'pelanggan',
        ]);

        $pelCustomer2 = Pelanggan::create([
            'id_user' => $pelanggan2->id_user,
            'status_member' => 'reguler',
            'poin_member' => 250,
            'alamat' => 'Jl. Gatot Subroto 78, Bandung',
        ]);

        $pelanggan3 = User::create([
            'nama' => 'TOKO ABC',
            'email' => 'tokoabc@gmail.com',
            'password' => bcrypt('password'),
            'no_telepon' => '082412345680',
            'role' => 'pelanggan',
        ]);

        $pelCustomer3 = Pelanggan::create([
            'id_user' => $pelanggan3->id_user,
            'status_member' => 'premium',
            'poin_member' => 800,
            'alamat' => 'Jl. Ahmad Yani 234, Bandung',
        ]);

        // ===== CREATE PESANAN (DASHBOARD) =====
        // Tugas Aktif 1: Menunggu
        Pesanan::create([
            'id_pelanggan' => $pelCustomer1->id_pelanggan,
            'id_cabang' => $cabangPusat->id_cabang,
            'id_kurir' => $kurir1->id_kurir,
            'id_promo' => null,
            'tanggal_pemesanan' => now(),
            'total_belanja' => 250000,
            'biaya_pengiriman' => 15000,
            'diskon_voucher' => 0,
            'total_tagihan' => 265000,
            'metode_pembayaran' => 'transfer',
            'alamat_pengiriman' => 'Jl. Merdeka 45, Bandung',
            'status_pesanan' => 'menunggu',
            'estimasi_tiba' => now()->addHours(3),
            'catatan' => 'Pengiriman Stok Logistik',
        ]);

        // Tugas Aktif 2: Dalam Pengiriman
        Pesanan::create([
            'id_pelanggan' => $pelCustomer2->id_pelanggan,
            'id_cabang' => $cabangAntapani->id_cabang,
            'id_kurir' => $kurir1->id_kurir,
            'id_promo' => null,
            'tanggal_pemesanan' => now()->subHours(2),
            'total_belanja' => 180000,
            'biaya_pengiriman' => 12000,
            'diskon_voucher' => 0,
            'total_tagihan' => 192000,
            'metode_pembayaran' => 'transfer',
            'alamat_pengiriman' => 'Jl. Gatot Subroto 78, Bandung',
            'status_pesanan' => 'dalam_pengiriman',
            'estimasi_tiba' => now()->addMinutes(45),
        ]);

        // ===== CREATE PESANAN (RIWAYAT) =====
        // Selesai Hari Ini 1-14
        for ($i = 1; $i <= 14; $i++) {
            Pesanan::create([
                'id_pelanggan' => $i % 2 == 0 ? $pelCustomer2->id_pelanggan : $pelCustomer1->id_pelanggan,
                'id_cabang' => $cabangAntapani->id_cabang,
                'id_kurir' => $kurir1->id_kurir,
                'id_promo' => null,
                'tanggal_pemesanan' => now()->subHours(rand(1, 12))->startOfDay()->addHours(rand(8, 18)),
                'total_belanja' => rand(100000, 500000),
                'biaya_pengiriman' => rand(10000, 30000),
                'diskon_voucher' => 0,
                'total_tagihan' => rand(110000, 530000),
                'metode_pembayaran' => 'transfer',
                'alamat_pengiriman' => 'Jl. ' . ['Merdeka', 'Gatot Subroto', 'Ahmad Yani', 'Diponegoro', 'Sudirman'][$i % 5] . ' ' . (40 + $i * 5),
                'status_pesanan' => 'diterima',
                'estimasi_tiba' => now()->subHours(rand(1, 12))->startOfDay()->addHours(rand(8, 18)),
                'updated_at' => now()->subHours(rand(1, 12))->startOfDay()->addHours(rand(8, 18)),
            ]);
        }

        // Riwayat Gagal
        for ($i = 1; $i <= 3; $i++) {
            Pesanan::create([
                'id_pelanggan' => $i % 2 == 0 ? $pelCustomer3->id_pelanggan : $pelCustomer2->id_pelanggan,
                'id_cabang' => $cabangAntapani->id_cabang,
                'id_kurir' => $kurir1->id_kurir,
                'id_promo' => null,
                'tanggal_pemesanan' => now()->subDays($i),
                'total_belanja' => rand(100000, 500000),
                'biaya_pengiriman' => rand(10000, 30000),
                'diskon_voucher' => 0,
                'total_tagihan' => rand(110000, 530000),
                'metode_pembayaran' => 'transfer',
                'alamat_pengiriman' => 'Jl. Test ' . $i,
                'status_pesanan' => 'gagal_kirim',
                'estimasi_tiba' => now()->subDays($i)->addHours(14),
                'alasan_gagal' => ['Alamat tidak ditemukan', 'Penerima tidak ada', 'Tolak pesanan'][$i - 1],
                'updated_at' => now()->subDays($i),
            ]);
        }
    }
}

