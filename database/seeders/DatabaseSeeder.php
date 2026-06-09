<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Kurir;
use App\Models\Cabang;
use App\Models\Pelanggan;
use App\Models\Pesanan;
use App\Models\PesananProduk;
use App\Models\Produk;
use App\Models\PengirimanTracking;
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
        $cabangs = [
            [
                'nama_cabang' => 'Borma Toserba Antapani',
                'alamat_cabang' => 'Jl. Terusan Jakarta No.53, Cicaheum, Kec. Kiaracondong, Kota Bandung 40291',
                'koordinat_gps' => '-6.9147,107.6542',
                'status' => 'Aktif',
            ],
            [
                'nama_cabang' => 'Borma Toserba Bojongsoang',
                'alamat_cabang' => 'Jl. Terusan Bojongsoang, Bojongsoang, Kec. Bojongsoang, Kab. Bandung 40288',
                'koordinat_gps' => '-6.9700,107.6400',
                'status' => 'Aktif',
            ],
            [
                'nama_cabang' => 'Borma Toserba Dago',
                'alamat_cabang' => 'Jl. Ir. H. Juanda No. 348, Bandung',
                'koordinat_gps' => '-6.8848,107.6146',
                'status' => 'Aktif',
            ],
            [
                'nama_cabang' => 'Borma Toserba Cikutra',
                'alamat_cabang' => 'Jl. Cikutra Barat No. 66, Bandung',
                'koordinat_gps' => '-6.8967,107.6253',
                'status' => 'Aktif',
            ],
            [
                'nama_cabang' => 'Borma Toserba Dakota',
                'alamat_cabang' => 'Jl. Dakota Raya No. 109, Bandung',
                'koordinat_gps' => '-6.8941,107.5706',
                'status' => 'Aktif',
            ],
            [
                'nama_cabang' => 'Borma Toserba Buah Batu',
                'alamat_cabang' => 'Jl. Buah Batu No. 235 A, Bandung',
                'koordinat_gps' => '-6.9404,107.6277',
                'status' => 'Aktif',
            ],
            [
                'nama_cabang' => 'Borma Toserba Cibaduyut',
                'alamat_cabang' => 'Jl. Terusan Cibaduyut No. 9, Bandung',
                'koordinat_gps' => '-6.9460,107.5937',
                'status' => 'Aktif',
            ],
            [
                'nama_cabang' => 'Borma Toserba Caringin',
                'alamat_cabang' => 'Jl. Caringin No. 175, Bandung',
                'koordinat_gps' => '-6.9405,107.5755',
                'status' => 'Aktif',
            ],
            [
                'nama_cabang' => 'Borma Toserba Kopo / Gempol',
                'alamat_cabang' => 'Jl. Gempol Sari Raya No. 9, Bandung',
                'koordinat_gps' => '-6.9248,107.5562',
                'status' => 'Aktif',
            ],
            [
                'nama_cabang' => 'Borma Toserba Cihanjuang',
                'alamat_cabang' => 'Jl. Cihanjuang No. 102, Bandung',
                'koordinat_gps' => '-6.8778,107.5606',
                'status' => 'Aktif',
            ],
            [
                'nama_cabang' => 'Borma Toserba Cinunuk',
                'alamat_cabang' => 'Jl. Raya Cinunuk No. 160, Bandung',
                'koordinat_gps' => '-6.9348,107.7428',
                'status' => 'Aktif',
            ]
        ];

        $createdCabangs = [];
        foreach ($cabangs as $c) {
            $createdCabangs[] = Cabang::create($c);
        }

        // Simpan reference ke cabang pertama dan kedua untuk seeder pesanan (sama seperti sebelumnya)
        $cabangAntapani = $createdCabangs[0];
        $cabangPusat = $createdCabangs[1];
        $cabangBelumadd = $createdCabangs[3]; // Cikutra


        // ===== CREATE PRODUCTS =====
        $produk1 = Produk::create([
            'nama_produk' => 'Beras Premium 5kg',
            'kategori' => 'Sembako',
            'deskripsi' => 'Beras premium kualitas terbaik',
            'harga_reguler' => 75000,
            'harga_member' => 70000,
            'gambar_produk' => 'produk/beras-premium.jpg',
        ]);

        $produk2 = Produk::create([
            'nama_produk' => 'Minyak Goreng 2L',
            'kategori' => 'Sembako',
            'deskripsi' => 'Minyak goreng sawit 2 liter',
            'harga_reguler' => 35000,
            'harga_member' => 32000,
            'gambar_produk' => 'produk/minyak-goreng.jpg',
        ]);

        $produk3 = Produk::create([
            'nama_produk' => 'Gula Pasir 1kg',
            'kategori' => 'Sembako',
            'deskripsi' => 'Gula pasir putih 1 kilogram',
            'harga_reguler' => 16000,
            'harga_member' => 15000,
            'gambar_produk' => 'produk/gula-pasir.jpg',
        ]);

        $produk4 = Produk::create([
            'nama_produk' => 'Susu UHT 1L',
            'kategori' => 'Minuman',
            'deskripsi' => 'Susu UHT full cream 1 liter',
            'harga_reguler' => 18000,
            'harga_member' => 16500,
            'gambar_produk' => 'produk/susu-uht.jpg',
        ]);

        $produk5 = Produk::create([
            'nama_produk' => 'Tepung Terigu 1kg',
            'kategori' => 'Sembako',
            'deskripsi' => 'Tepung terigu serbaguna',
            'harga_reguler' => 12000,
            'harga_member' => 11000,
            'gambar_produk' => 'produk/tepung-terigu.jpg',
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
            'pendapatan_pengiriman' => 1000000,
            'status_mengirim' => 'Sedang Mengirim',
            'status_aktif' => 'Aktif',
        ]);

        $kurir2 = Kurir::create([
            'id_user' => $userDriver2->id_user,
            'id_cabang' => $cabangBelumadd->id_cabang,
            'kendaraan' => 'Mobil',
            'warna_kendaraan' => 'Putih',
            'plat_nomor' => 'B 5678 XYZ',
            'pendapatan_pengiriman' => 1200000,
            'status_mengirim' => 'Tidak Mengirim',
            'status_aktif' => 'Aktif',
        ]);

        // ===== CREATE PELANGGAN =====
        $pelanggan1 = User::create([
            'nama' => 'Rina Agustina',
            'email' => 'rina.agustina@gmail.com',
            'password' => bcrypt('password'),
            'no_telepon' => '+6282212345678',
            'role' => 'pelanggan',
        ]);

        $pelCustomer1 = Pelanggan::create([
            'id_user' => $pelanggan1->id_user,
            'status_member' => true,
            'poin_member' => 500,
            'alamat' => 'Jl. Merdeka 45, Bandung',
        ]);

        $pelanggan2 = User::create([
            'nama' => 'Joko Susanto',
            'email' => 'joko.susanto@gmail.com',
            'password' => bcrypt('password'),
            'no_telepon' => '+6282312345679',
            'role' => 'pelanggan',
        ]);

        $pelCustomer2 = Pelanggan::create([
            'id_user' => $pelanggan2->id_user,
            'status_member' => false,
            'poin_member' => 250,
            'alamat' => 'Jl. Gatot Subroto 78, Bandung',
        ]);

        $pelanggan3 = User::create([
            'nama' => 'Sari Indah',
            'email' => 'sari.indah@gmail.com',
            'password' => bcrypt('password'),
            'no_telepon' => '+6282412345680',
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
            'no_telepon' => '+6282211112222',
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
            'no_telepon' => '+6282233334444',
            'role' => 'pelanggan',
        ]);
        $pelSiti = Pelanggan::create([
            'id_user' => $pelangganSiti->id_user,
            'status_member' => false,
            'poin_member' => 120,
            'alamat' => 'Jl. Sukajadi No. 2, Bandung',
        ]);

        $pelangganBudiA = User::create([
            'nama' => 'Budi Ardiansyah',
            'email' => 'budi.ardiansyah@gmail.com',
            'password' => bcrypt('password'),
            'no_telepon' => '+6281234567890',
            'role' => 'pelanggan',
        ]);
        $pelBudiA = Pelanggan::create([
            'id_user' => $pelangganBudiA->id_user,
            'status_member' => false,
            'poin_member' => 150,
            'alamat' => 'Jl. Pasteur No. 123, Sukajadi, Kota Bandung, Jawa Barat 40161',
        ]);

        // ===== CREATE PESANAN — DASHBOARD TUGAS BERIKUTNYA =====

        // Pesanan 1: PENDING — harus muncul di "Tugas Berikutnya" dengan tombol Konfirmasi/Tolak
        $pesanan1 = Pesanan::create([
            'id_pelanggan' => $pelBudiA->id_pelanggan,
            'id_cabang' => $cabangPusat->id_cabang,
            'id_kurir' => $kurir2->id_kurir,
            'id_promo' => null,
            'tanggal_pemesanan' => now(),
            'total_belanja' => 250000,
            'biaya_pengiriman' => 15000,
            'diskon_voucher' => 0,
            'total_tagihan' => 265000,
            'metode_pembayaran' => 'transfer',
            'alamat_pengiriman' => 'Jl. Pasteur No. 123, Sukajadi, Kota Bandung, Jawa Barat 40161',
            'latitude' => -6.8936,
            'longitude' => 107.5965,
            'status_pesanan' => 'mencari_driver',
            'estimasi_tiba' => now()->addHours(3),
            'catatan_pengiriman' => 'Gerbang warna hitam, titip di sekurit kalau tidak ada orang.',
        ]);

        // Tambah item untuk pesanan 1
        PesananProduk::create([
            'id_pesanan' => $pesanan1->id_pesanan,
            'id_produk' => $produk1->id_produk,
            'jumlah' => 2,
            'harga_satuan' => 75000,
            'subtotal' => 150000,
        ]);
        PesananProduk::create([
            'id_pesanan' => $pesanan1->id_pesanan,
            'id_produk' => $produk2->id_produk,
            'jumlah' => 3,
            'harga_satuan' => 35000,
            'subtotal' => 105000,
        ]);
        PesananProduk::create([
            'id_pesanan' => $pesanan1->id_pesanan,
            'id_produk' => $produk3->id_produk,
            'jumlah' => 1,
            'harga_satuan' => 16000,
            'subtotal' => 16000,
        ]);

        // Pesanan 2: DITERIMA_DRIVER — sudah dikonfirmasi, tampil di dashboard sebagai "Mulai Perjalanan"
        $pesanan2 = Pesanan::create([
            'id_pelanggan' => $pelCustomer2->id_pelanggan,
            'id_cabang' => $cabangAntapani->id_cabang,
            'id_kurir' => $kurir2->id_kurir,
            'id_promo' => null,
            'tanggal_pemesanan' => now()->subHours(1),
            'total_belanja' => 180000,
            'biaya_pengiriman' => 12000,
            'diskon_voucher' => 0,
            'total_tagihan' => 192000,
            'metode_pembayaran' => 'transfer',
            'alamat_pengiriman' => 'Jl. Gatot Subroto 78, Bandung',
            'latitude' => -6.9215,
            'longitude' => 107.6310,
            'status_pesanan' => 'diterima_driver',
            'estimasi_tiba' => now()->addMinutes(45),
            'catatan_pengiriman' => 'Gedung lantai 2, hubungi sebelum datang.',
        ]);

        PesananProduk::create([
            'id_pesanan' => $pesanan2->id_pesanan,
            'id_produk' => $produk4->id_produk,
            'jumlah' => 4,
            'harga_satuan' => 18000,
            'subtotal' => 72000,
        ]);
        PesananProduk::create([
            'id_pesanan' => $pesanan2->id_pesanan,
            'id_produk' => $produk5->id_produk,
            'jumlah' => 5,
            'harga_satuan' => 12000,
            'subtotal' => 60000,
        ]);

        // Pesanan 3: DALAM_PENGIRIMAN — sudah aktif dikirim
        $pesanan3 = Pesanan::create([
            'id_pelanggan' => $pelCustomer1->id_pelanggan,
            'id_cabang' => $cabangAntapani->id_cabang,
            'id_kurir' => $kurir2->id_kurir,
            'id_promo' => null,
            'tanggal_pemesanan' => now()->subHours(2),
            'total_belanja' => 320000,
            'biaya_pengiriman' => 20000,
            'diskon_voucher' => 0,
            'total_tagihan' => 340000,
            'metode_pembayaran' => 'transfer',
            'alamat_pengiriman' => 'Jl. Merdeka 45, Bandung',
            'latitude' => -6.9175,
            'longitude' => 107.6191,
            'status_pesanan' => 'dalam_pengiriman',
            'estimasi_tiba' => now()->addMinutes(20),
            'catatan_pengiriman' => 'Taruh di depan pintu jika tidak ada orang.',
        ]);

        PesananProduk::create([
            'id_pesanan' => $pesanan3->id_pesanan,
            'id_produk' => $produk1->id_produk,
            'jumlah' => 3,
            'harga_satuan' => 75000,
            'subtotal' => 225000,
        ]);
        PesananProduk::create([
            'id_pesanan' => $pesanan3->id_pesanan,
            'id_produk' => $produk3->id_produk,
            'jumlah' => 2,
            'harga_satuan' => 16000,
            'subtotal' => 32000,
        ]);

        // Tracking for pesanan 3
        PengirimanTracking::create([
            'id_pesanan' => $pesanan3->id_pesanan,
            'status' => 'diterima_driver',
            'keterangan' => 'Driver telah mengkonfirmasi pengiriman',
            'created_at' => now()->subHours(2),
            'updated_at' => now()->subHours(2),
        ]);
        PengirimanTracking::create([
            'id_pesanan' => $pesanan3->id_pesanan,
            'status' => 'diambil',
            'keterangan' => 'Pesanan diambil dari Gudang Borma Antapani',
            'created_at' => now()->subHour(),
            'updated_at' => now()->subHour(),
        ]);
        PengirimanTracking::create([
            'id_pesanan' => $pesanan3->id_pesanan,
            'status' => 'dalam_pengiriman',
            'keterangan' => 'Menuju lokasi pelanggan',
            'created_at' => now()->subMinutes(30),
            'updated_at' => now()->subMinutes(30),
        ]);

        // ===== CREATE PESANAN (RIWAYAT) =====
        // Selesai Hari Ini 1-5
        for ($i = 1; $i <= 5; $i++) {
            $riwayatPesanan = Pesanan::create([
                'id_pelanggan' => $i % 2 == 0 ? $pelCustomer2->id_pelanggan : $pelCustomer1->id_pelanggan,
                'id_cabang' => $cabangAntapani->id_cabang,
                'id_kurir' => $kurir1->id_kurir,
                'id_promo' => null,
                'tanggal_pemesanan' => now()->startOfDay()->addHours(rand(8, 12)),
                'total_belanja' => rand(100000, 500000),
                'biaya_pengiriman' => rand(10000, 30000),
                'diskon_voucher' => 0,
                'total_tagihan' => rand(110000, 530000),
                'metode_pembayaran' => 'transfer',
                'alamat_pengiriman' => 'Jl. ' . ['Merdeka', 'Gatot Subroto', 'Ahmad Yani', 'Diponegoro', 'Sudirman'][$i % 5] . ' ' . (40 + $i * 5),
                'latitude' => -6.9000 + ($i * 0.005),
                'longitude' => 107.6000 + ($i * 0.005),
                'status_pesanan' => 'diterima',
                'estimasi_tiba' => now()->startOfDay()->addHours(rand(13, 17)),
                'updated_at' => now()->subHours(rand(1, 6)),
            ]);

            // Add items to riwayat
            PesananProduk::create([
                'id_pesanan' => $riwayatPesanan->id_pesanan,
                'id_produk' => $produk1->id_produk,
                'jumlah' => rand(1, 3),
                'harga_satuan' => 75000,
                'subtotal' => 75000 * rand(1, 3),
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
                'latitude' => -6.9300 + ($i * 0.003),
                'longitude' => 107.6100 + ($i * 0.003),
                'status_pesanan' => 'gagal',
                'estimasi_tiba' => now()->subDays($i)->addHours(14),
                'alasan_gagal' => ['Alamat tidak ditemukan', 'Penerima tidak ada', 'Tolak pesanan'][$i - 1],
                'updated_at' => now()->subDays($i),
            ]);
        }

        // ===== PESANAN SESUAI WIREFRAME =====
        $pesananWf1 = Pesanan::create([
            'id_pelanggan' => $pelCustomer1->id_pelanggan,
            'id_cabang' => $cabangAntapani->id_cabang,
            'id_kurir' => $kurir1->id_kurir,
            'id_promo' => null,
            'tanggal_pemesanan' => '2026-05-18 08:00:00',
            'total_belanja' => 150000,
            'biaya_pengiriman' => 15000,
            'diskon_voucher' => 0,
            'total_tagihan' => 165000,
            'metode_pembayaran' => 'transfer',
            'alamat_pengiriman' => 'Jl. Merdeka 45, Bandung',
            'status_pesanan' => 'diterima',
            'estimasi_tiba' => '2026-05-18 10:00:00',
            'updated_at' => '2026-05-18 08:00:00',
            'latitude' => -6.9175,
            'longitude' => 107.6191,
        ]);

        PesananProduk::create([
            'id_pesanan' => $pesananWf1->id_pesanan,
            'id_produk' => $produk1->id_produk,
            'jumlah' => 2,
            'harga_satuan' => 75000,
            'subtotal' => 150000,
        ]);

        $pesananWf2 = Pesanan::create([
            'id_pelanggan' => $pelCustomer1->id_pelanggan,
            'id_cabang' => $cabangAntapani->id_cabang,
            'id_kurir' => $kurir1->id_kurir,
            'id_promo' => null,
            'tanggal_pemesanan' => '2026-05-18 17:00:00',
            'total_belanja' => 200000,
            'biaya_pengiriman' => 20000,
            'diskon_voucher' => 0,
            'total_tagihan' => 220000,
            'metode_pembayaran' => 'transfer',
            'alamat_pengiriman' => 'Jl. Sukajadi No. 2, Bandung',
            'status_pesanan' => 'diterima',
            'estimasi_tiba' => '2026-05-18 18:30:00',
            'updated_at' => '2026-05-18 17:00:00',
            'latitude' => -6.8833,
            'longitude' => 107.6033,
        ]);

        PesananProduk::create([
            'id_pesanan' => $pesananWf2->id_pesanan,
            'id_produk' => $produk2->id_produk,
            'jumlah' => 3,
            'harga_satuan' => 35000,
            'subtotal' => 105000,
        ]);

        // ===== ANTREAN TUGAS FCFS (id_kurir = null, status = pending) =====

        // FCFS 1
        $fcfs1 = Pesanan::create([
            'id_pelanggan' => $pelCustomer1->id_pelanggan,
            'id_cabang' => $cabangPusat->id_cabang,
            'id_kurir' => null,
            'id_promo' => null,
            'tanggal_pemesanan' => now()->subMinutes(55),
            'total_belanja' => 500000,
            'biaya_pengiriman' => 25000,
            'diskon_voucher' => 0,
            'total_tagihan' => 525000,
            'metode_pembayaran' => 'transfer',
            'alamat_pengiriman' => 'Jl. Gatot Subroto No. 123, Bandung',
            'status_pesanan' => 'mencari_driver',
            'estimasi_tiba' => now()->addHours(2),
            'latitude' => -6.9215, 'longitude' => 107.6310,
            'catatan_pengiriman' => 'Gedung utama, lantai 5. Hubungi customer sebelum tiba.',
        ]);
        PesananProduk::create(['id_pesanan' => $fcfs1->id_pesanan, 'id_produk' => $produk1->id_produk, 'jumlah' => 5, 'harga_satuan' => 75000, 'subtotal' => 375000]);
        PesananProduk::create(['id_pesanan' => $fcfs1->id_pesanan, 'id_produk' => $produk2->id_produk, 'jumlah' => 3, 'harga_satuan' => 35000, 'subtotal' => 105000]);

        // FCFS 2
        $fcfs2 = Pesanan::create([
            'id_pelanggan' => $pelCustomer2->id_pelanggan,
            'id_cabang' => $cabangAntapani->id_cabang,
            'id_kurir' => null,
            'id_promo' => null,
            'tanggal_pemesanan' => now()->subMinutes(48),
            'total_belanja' => 200000,
            'biaya_pengiriman' => 15000,
            'diskon_voucher' => 0,
            'total_tagihan' => 215000,
            'metode_pembayaran' => 'cash',
            'alamat_pengiriman' => 'Jl. Diponegoro No. 45, Bandung',
            'status_pesanan' => 'mencari_driver',
            'estimasi_tiba' => now()->addHours(1),
            'latitude' => -6.9025, 'longitude' => 107.6186,
            'catatan_pengiriman' => 'Toko dengan papan merah. Titip ke karyawan toko.',
        ]);
        PesananProduk::create(['id_pesanan' => $fcfs2->id_pesanan, 'id_produk' => $produk3->id_produk, 'jumlah' => 12, 'harga_satuan' => 16000, 'subtotal' => 192000]);
        PesananProduk::create(['id_pesanan' => $fcfs2->id_pesanan, 'id_produk' => $produk5->id_produk, 'jumlah' => 1, 'harga_satuan' => 12000, 'subtotal' => 12000]);

        // FCFS 3
        $fcfs3 = Pesanan::create([
            'id_pelanggan' => $pelCustomer3->id_pelanggan,
            'id_cabang' => $cabangAntapani->id_cabang,
            'id_kurir' => null,
            'id_promo' => null,
            'tanggal_pemesanan' => now()->subMinutes(42),
            'total_belanja' => 850000,
            'biaya_pengiriman' => 35000,
            'diskon_voucher' => 50000,
            'total_tagihan' => 835000,
            'metode_pembayaran' => 'transfer',
            'alamat_pengiriman' => 'Jl. Braga No. 10, Bandung',
            'status_pesanan' => 'mencari_driver',
            'estimasi_tiba' => now()->addHours(3),
            'latitude' => -6.9175, 'longitude' => 107.6090,
            'catatan_pengiriman' => 'Gunakan pintu samping. Cek ketersediaan barang sebelum pengiriman.',
        ]);
        PesananProduk::create(['id_pesanan' => $fcfs3->id_pesanan, 'id_produk' => $produk1->id_produk, 'jumlah' => 8, 'harga_satuan' => 75000, 'subtotal' => 600000]);
        PesananProduk::create(['id_pesanan' => $fcfs3->id_pesanan, 'id_produk' => $produk4->id_produk, 'jumlah' => 10, 'harga_satuan' => 18000, 'subtotal' => 180000]);
        PesananProduk::create(['id_pesanan' => $fcfs3->id_pesanan, 'id_produk' => $produk3->id_produk, 'jumlah' => 5, 'harga_satuan' => 16000, 'subtotal' => 80000]);

        // FCFS 4
        $fcfs4 = Pesanan::create([
            'id_pelanggan' => $pelAndi->id_pelanggan,
            'id_cabang' => $cabangPusat->id_cabang,
            'id_kurir' => null,
            'id_promo' => null,
            'tanggal_pemesanan' => now()->subMinutes(36),
            'total_belanja' => 375000,
            'biaya_pengiriman' => 20000,
            'diskon_voucher' => 0,
            'total_tagihan' => 395000,
            'metode_pembayaran' => 'transfer',
            'alamat_pengiriman' => 'Jl. Pahlawan No. 1, Bandung',
            'status_pesanan' => 'mencari_driver',
            'estimasi_tiba' => now()->addHours(2),
            'latitude' => -6.9100, 'longitude' => 107.6250,
            'catatan_pengiriman' => 'Rumah cat putih pagar hijau, ketuk pintu depan.',
        ]);
        PesananProduk::create(['id_pesanan' => $fcfs4->id_pesanan, 'id_produk' => $produk1->id_produk, 'jumlah' => 3, 'harga_satuan' => 75000, 'subtotal' => 225000]);
        PesananProduk::create(['id_pesanan' => $fcfs4->id_pesanan, 'id_produk' => $produk2->id_produk, 'jumlah' => 2, 'harga_satuan' => 35000, 'subtotal' => 70000]);
        PesananProduk::create(['id_pesanan' => $fcfs4->id_pesanan, 'id_produk' => $produk4->id_produk, 'jumlah' => 5, 'harga_satuan' => 18000, 'subtotal' => 90000]);

        // FCFS 5
        $fcfs5 = Pesanan::create([
            'id_pelanggan' => $pelSiti->id_pelanggan,
            'id_cabang' => $cabangBelumadd->id_cabang,
            'id_kurir' => null,
            'id_promo' => null,
            'tanggal_pemesanan' => now()->subMinutes(30),
            'total_belanja' => 128000,
            'biaya_pengiriman' => 10000,
            'diskon_voucher' => 0,
            'total_tagihan' => 138000,
            'metode_pembayaran' => 'cash',
            'alamat_pengiriman' => 'Jl. Sukajadi No. 2, Bandung',
            'status_pesanan' => 'mencari_driver',
            'estimasi_tiba' => now()->addMinutes(90),
            'latitude' => -6.8833, 'longitude' => 107.6033,
            'catatan_pengiriman' => 'Kios sebelah warung nasi. Hubungi dulu via telepon.',
        ]);
        PesananProduk::create(['id_pesanan' => $fcfs5->id_pesanan, 'id_produk' => $produk3->id_produk, 'jumlah' => 8, 'harga_satuan' => 16000, 'subtotal' => 128000]);

        // FCFS 6
        $fcfs6 = Pesanan::create([
            'id_pelanggan' => $pelBudiA->id_pelanggan,
            'id_cabang' => $cabangAntapani->id_cabang,
            'id_kurir' => null,
            'id_promo' => null,
            'tanggal_pemesanan' => now()->subMinutes(25),
            'total_belanja' => 660000,
            'biaya_pengiriman' => 30000,
            'diskon_voucher' => 0,
            'total_tagihan' => 690000,
            'metode_pembayaran' => 'transfer',
            'alamat_pengiriman' => 'Jl. Pasteur No. 123, Sukajadi, Bandung',
            'status_pesanan' => 'mencari_driver',
            'estimasi_tiba' => now()->addHours(2),
            'latitude' => -6.8936, 'longitude' => 107.5965,
            'catatan_pengiriman' => 'Komplek perumahan blok C-12. Masuk dari gerbang utara.',
        ]);
        PesananProduk::create(['id_pesanan' => $fcfs6->id_pesanan, 'id_produk' => $produk1->id_produk, 'jumlah' => 6, 'harga_satuan' => 75000, 'subtotal' => 450000]);
        PesananProduk::create(['id_pesanan' => $fcfs6->id_pesanan, 'id_produk' => $produk2->id_produk, 'jumlah' => 4, 'harga_satuan' => 35000, 'subtotal' => 140000]);
        PesananProduk::create(['id_pesanan' => $fcfs6->id_pesanan, 'id_produk' => $produk5->id_produk, 'jumlah' => 6, 'harga_satuan' => 12000, 'subtotal' => 72000]);

        // FCFS 7
        $fcfs7 = Pesanan::create([
            'id_pelanggan' => $pelCustomer1->id_pelanggan,
            'id_cabang' => $cabangBelumadd->id_cabang,
            'id_kurir' => null,
            'id_promo' => null,
            'tanggal_pemesanan' => now()->subMinutes(20),
            'total_belanja' => 270000,
            'biaya_pengiriman' => 18000,
            'diskon_voucher' => 0,
            'total_tagihan' => 288000,
            'metode_pembayaran' => 'cash',
            'alamat_pengiriman' => 'Jl. Merdeka 45, Bandung',
            'status_pesanan' => 'mencari_driver',
            'estimasi_tiba' => now()->addMinutes(75),
            'latitude' => -6.9175, 'longitude' => 107.6191,
            'catatan_pengiriman' => 'Lantai 3 apartemen, unit 305. Lift dari lobi utama.',
        ]);
        PesananProduk::create(['id_pesanan' => $fcfs7->id_pesanan, 'id_produk' => $produk4->id_produk, 'jumlah' => 15, 'harga_satuan' => 18000, 'subtotal' => 270000]);

        // FCFS 8
        $fcfs8 = Pesanan::create([
            'id_pelanggan' => $pelCustomer3->id_pelanggan,
            'id_cabang' => $cabangPusat->id_cabang,
            'id_kurir' => null,
            'id_promo' => null,
            'tanggal_pemesanan' => now()->subMinutes(15),
            'total_belanja' => 432000,
            'biaya_pengiriman' => 22000,
            'diskon_voucher' => 20000,
            'total_tagihan' => 434000,
            'metode_pembayaran' => 'transfer',
            'alamat_pengiriman' => 'Jl. Ahmad Yani 234, Bandung',
            'status_pesanan' => 'mencari_driver',
            'estimasi_tiba' => now()->addHours(2),
            'latitude' => -6.9300, 'longitude' => 107.6350,
            'catatan_pengiriman' => 'Belakang Masjid Al-Falah, gang kecil masuk 50m.',
        ]);
        PesananProduk::create(['id_pesanan' => $fcfs8->id_pesanan, 'id_produk' => $produk1->id_produk, 'jumlah' => 4, 'harga_satuan' => 75000, 'subtotal' => 300000]);
        PesananProduk::create(['id_pesanan' => $fcfs8->id_pesanan, 'id_produk' => $produk3->id_produk, 'jumlah' => 4, 'harga_satuan' => 16000, 'subtotal' => 64000]);
        PesananProduk::create(['id_pesanan' => $fcfs8->id_pesanan, 'id_produk' => $produk5->id_produk, 'jumlah' => 3, 'harga_satuan' => 12000, 'subtotal' => 36000]);

        // FCFS 9
        $fcfs9 = Pesanan::create([
            'id_pelanggan' => $pelAndi->id_pelanggan,
            'id_cabang' => $cabangAntapani->id_cabang,
            'id_kurir' => null,
            'id_promo' => null,
            'tanggal_pemesanan' => now()->subMinutes(10),
            'total_belanja' => 156000,
            'biaya_pengiriman' => 12000,
            'diskon_voucher' => 0,
            'total_tagihan' => 168000,
            'metode_pembayaran' => 'cash',
            'alamat_pengiriman' => 'Jl. Pahlawan No. 1, Bandung',
            'status_pesanan' => 'mencari_driver',
            'estimasi_tiba' => now()->addMinutes(60),
            'latitude' => -6.9100, 'longitude' => 107.6250,
            'catatan_pengiriman' => 'Pesanan kedua hari ini. Taruh di teras samping.',
        ]);
        PesananProduk::create(['id_pesanan' => $fcfs9->id_pesanan, 'id_produk' => $produk2->id_produk, 'jumlah' => 2, 'harga_satuan' => 35000, 'subtotal' => 70000]);
        PesananProduk::create(['id_pesanan' => $fcfs9->id_pesanan, 'id_produk' => $produk4->id_produk, 'jumlah' => 3, 'harga_satuan' => 18000, 'subtotal' => 54000]);
        PesananProduk::create(['id_pesanan' => $fcfs9->id_pesanan, 'id_produk' => $produk5->id_produk, 'jumlah' => 3, 'harga_satuan' => 12000, 'subtotal' => 36000]);

        // FCFS 10
        $fcfs10 = Pesanan::create([
            'id_pelanggan' => $pelSiti->id_pelanggan,
            'id_cabang' => $cabangPusat->id_cabang,
            'id_kurir' => null,
            'id_promo' => null,
            'tanggal_pemesanan' => now()->subMinutes(3),
            'total_belanja' => 1050000,
            'biaya_pengiriman' => 40000,
            'diskon_voucher' => 100000,
            'total_tagihan' => 990000,
            'metode_pembayaran' => 'transfer',
            'alamat_pengiriman' => 'Jl. Sukajadi No. 2, Bandung',
            'status_pesanan' => 'mencari_driver',
            'estimasi_tiba' => now()->addHours(3),
            'latitude' => -6.8833, 'longitude' => 107.6033,
            'catatan_pengiriman' => 'Pesanan besar, pastikan kendaraan cukup. Hubungi 30 menit sebelum tiba.',
        ]);
        PesananProduk::create(['id_pesanan' => $fcfs10->id_pesanan, 'id_produk' => $produk1->id_produk, 'jumlah' => 10, 'harga_satuan' => 75000, 'subtotal' => 750000]);
        PesananProduk::create(['id_pesanan' => $fcfs10->id_pesanan, 'id_produk' => $produk2->id_produk, 'jumlah' => 5, 'harga_satuan' => 35000, 'subtotal' => 175000]);
        PesananProduk::create(['id_pesanan' => $fcfs10->id_pesanan, 'id_produk' => $produk3->id_produk, 'jumlah' => 3, 'harga_satuan' => 16000, 'subtotal' => 48000]);
        PesananProduk::create(['id_pesanan' => $fcfs10->id_pesanan, 'id_produk' => $produk4->id_produk, 'jumlah' => 5, 'harga_satuan' => 18000, 'subtotal' => 90000]);
    }
}
