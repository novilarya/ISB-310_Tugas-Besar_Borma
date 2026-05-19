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
            'status' => 'Aktif',
        ]);

        $cabangPusat = Cabang::create([
            'nama_cabang' => 'GUDANG PUSAT BOJONGSOANG',
            'alamat_cabang' => 'Jl. Bojongsoang, Bandung',
            'koordinat_gps' => '-6.9500,107.1000',
            'status' => 'Aktif',
        ]);

        $cabangBelumadd = Cabang::create([
            'nama_cabang' => 'BELUM ADA',
            'alamat_cabang' => 'Alamat Belum Ditentukan',
            'koordinat_gps' => '-',
            'status' => 'Tidak Aktif',
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
            'kendaraan' => 'Motor',
            'warna_kendaraan' => 'Hitam',
            'plat_nomor' => 'B 1234 ABC',
            'penghasilan_kotor' => 1000000,
            'penghasilan_bersih' => 900000,
            'status_mengirim' => 'Sedang Mengirim',
            'status_aktif' => 'Aktif',
        ]);

        $kurir2 = Kurir::create([
            'id_user' => $userDriver2->id_user,
            'id_cabang' => $cabangBelumadd->id_cabang,
            'kendaraan' => 'Mobil',
            'warna_kendaraan' => 'Putih',
            'plat_nomor' => 'B 5678 XYZ',
            'penghasilan_kotor' => 1200000,
            'penghasilan_bersih' => 1100000,
            'status_mengirim' => 'Tidak Mengirim',
            'status_aktif' => 'Aktif',
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
            'status_member' => true,
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
            'status_member' => false,
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
            'status_member' => true,
            'poin_member' => 800,
            'alamat' => 'Jl. Ahmad Yani 234, Bandung',
        ]);

        // ===== PELANGGAN SESUAI WIREFRAME =====
        $pelangganAndi = User::create([
            'nama' => 'Andi Wijaya',
            'email' => 'andi.wijaya@gmail.com',
            'password' => bcrypt('password'),
            'no_telepon' => '082211112222',
            'role' => 'pelanggan',
        ]);
        $pelAndi = Pelanggan::create([
            'id_user' => $pelangganAndi->id_user,
            'status_member' => false,
            'poin_member' => 100,
            'alamat' => 'Jl. Pahlawan No. 1, Bandung',
        ]);

        $pelangganSiti = User::create([
            'nama' => 'Siti Aminah',
            'email' => 'siti.aminah@gmail.com',
            'password' => bcrypt('password'),
            'no_telepon' => '082233334444',
            'role' => 'pelanggan',
        ]);
        $pelSiti = Pelanggan::create([
            'id_user' => $pelangganSiti->id_user,
            'status_member' => false,
            'poin_member' => 120,
            'alamat' => 'Jl. Sukajadi No. 2, Bandung',
        ]);

        $pelangganBudi = User::create([
            'nama' => 'Budi Santoso',
            'email' => 'budi.santoso@gmail.com',
            'password' => bcrypt('password'),
            'no_telepon' => '082255556666',
            'role' => 'pelanggan',
        ]);
        $pelBudi = Pelanggan::create([
            'id_user' => $pelangganBudi->id_user,
            'status_member' => false,
            'poin_member' => 150,
            'alamat' => 'Jl. Setiabudi No. 3, Bandung',
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

        // ===== CREATE PESANAN (RIWAYAT) - SESUAI WIREFRAME =====
        Pesanan::create([
            'id_pesanan' => 9920998,
            'id_pelanggan' => $pelBudi->id_pelanggan,
            'id_cabang' => $cabangAntapani->id_cabang,
            'id_kurir' => $kurir1->id_kurir,
            'id_promo' => null,
            'tanggal_pemesanan' => '2023-10-11 16:45:00',
            'total_belanja' => 150000,
            'biaya_pengiriman' => 15000,
            'diskon_voucher' => 0,
            'total_tagihan' => 165000,
            'metode_pembayaran' => 'transfer',
            'alamat_pengiriman' => 'Jl. Setiabudi No. 3, Bandung',
            'status_pesanan' => 'diterima',
            'estimasi_tiba' => '2023-10-11 17:30:00',
            'updated_at' => '2023-10-11 17:35:00',
            'latitude' => -6.8333,
            'longitude' => 107.5833,
        ]);

        Pesanan::create([
            'id_pesanan' => 9921005,
            'id_pelanggan' => $pelSiti->id_pelanggan,
            'id_cabang' => $cabangAntapani->id_cabang,
            'id_kurir' => $kurir1->id_kurir,
            'id_promo' => null,
            'tanggal_pemesanan' => '2023-10-12 11:15:00',
            'total_belanja' => 200000,
            'biaya_pengiriman' => 20000,
            'diskon_voucher' => 0,
            'total_tagihan' => 220000,
            'metode_pembayaran' => 'transfer',
            'alamat_pengiriman' => 'Jl. Sukajadi No. 2, Bandung',
            'status_pesanan' => 'gagal_kirim',
            'estimasi_tiba' => '2023-10-12 12:00:00',
            'alasan_gagal' => 'PENERIMA TIDAK DI TEMPAT',
            'updated_at' => '2023-10-12 12:15:00',
            'latitude' => -6.8833,
            'longitude' => 107.5833,
        ]);

        Pesanan::create([
            'id_pesanan' => 9921001,
            'id_pelanggan' => $pelAndi->id_pelanggan,
            'id_cabang' => $cabangAntapani->id_cabang,
            'id_kurir' => $kurir1->id_kurir,
            'id_promo' => null,
            'tanggal_pemesanan' => '2023-10-12 14:30:00',
            'total_belanja' => 100000,
            'biaya_pengiriman' => 10000,
            'diskon_voucher' => 0,
            'total_tagihan' => 110000,
            'metode_pembayaran' => 'transfer',
            'alamat_pengiriman' => 'Jl. Pahlawan No. 1, Bandung',
            'status_pesanan' => 'diterima',
            'estimasi_tiba' => '2023-10-12 15:00:00',
            'updated_at' => '2023-10-12 15:15:00',
            'latitude' => -6.8999,
            'longitude' => 107.6333,
        ]);
    }
}

