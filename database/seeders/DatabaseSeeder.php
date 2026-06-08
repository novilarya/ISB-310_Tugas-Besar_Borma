<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Data Pengguna (Akun Utama)
        DB::table('pengguna')->insert([
            [
                'id_pengguna' => 1,
                'nama' => 'Super Admin 1',
                // 'email' => 'isi email sendiri@gmail.com',
                'password' => Hash::make('12345678'),
                'no_telepon' => '081234567891',
                'role' => 'Admin Super',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id_pengguna' => 2,
                'nama' => 'Admin Cabang 1',
                'email' => 'admincabang@gmail.com',
                'password' => Hash::make('12345678'),
                'no_telepon' => '081234567892',
                'role' => 'Admin Cabang',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id_pengguna' => 3,
                'nama' => 'Kurir 1',
                'email' => 'kurir@gmail.com',
                'password' => Hash::make('12345678'),
                'no_telepon' => '081234567893',
                'role' => 'Kurir',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id_pengguna' => 4,
                'nama' => 'Agus Lele',
                'email' => 'user@gmail.com',
                'password' => Hash::make('12345678'),
                'no_telepon' => '081234567894',
                'role' => 'Pelanggan',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);

        // 2. Data Detail Pelanggan (Relasi ke Pengguna 4)
        DB::table('pelanggan')->insert([
            [
                'id_pelanggan' => 1,
                'id_pengguna' => 4,
                'status_member' => 1,
                'poin_member' => 100,
                'provinsi' => 'Jawa Barat',
                'kota_kabupaten' => 'Kota Bandung',
                'kecamatan' => 'Cibeunying Kaler',
                'alamat' => 'Jalan Gagak No 132', 
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);

        // 3. Data Cabang
        DB::table('cabang')->insert([
            [
                'id_cabang' => 1,
                'nama_cabang' => 'Borma Gempol',
                'alamat_cabang' => 'Jl. Gempol Sari No. 83',
                'koordinat_gps' => '-6.950396317796121, 107.57854452904492',
                'status' => 'Aktif',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id_cabang' => 2,
                'nama_cabang' => 'Borma Buah Batu',
                'alamat_cabang' => 'Jl. Buah Batu No. 225',
                'koordinat_gps' => '-6.955822369884887, 107.63231204501615',
                'status' => 'Aktif',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id_cabang' => 3,
                'nama_cabang' => 'Borma Cijerah',
                'alamat_cabang' => 'Jl. Cijerah No. 100',
                'koordinat_gps' => '-6.935190682604853, 107.54584255435934',  
                'status' => 'Aktif',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id_cabang' => 4,
                'nama_cabang' => 'Borma Cikutra',
                'alamat_cabang' => 'Jl. Cikutra No. 186',
                'koordinat_gps' => '-6.919538582489261, 107.6478291494488',
                'status' => 'Aktif',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id_cabang' => 5,
                'nama_cabang' => 'Borma Kerkof',
                'alamat_cabang' => 'Jl. Kerkof No. 186',
                'koordinat_gps' => '-6.919538582489261, 107.6478291494488',
                'status' => 'Aktif',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id_cabang' => 6,
                'nama_cabang' => 'Prama Banjaran',
                'alamat_cabang' => 'Jl. Raya Banjaran No. 100',
                'koordinat_gps' => '-7.092679391433424, 107.49744422882598',
                'status' => 'Aktif',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id_cabang' => 7,
                'nama_cabang' => 'Prama Babakan Sari',
                'alamat_cabang' => 'Jl. Babakan Sari No. 100',
                'koordinat_gps' => '-6.919538582489261, 107.6478291494488',
                'status' => 'Aktif',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id_cabang' => 8,
                'nama_cabang' => 'Prama Ciparay',
                'alamat_cabang' => 'Jl. Ciparay No. 288',
                'koordinat_gps' => '-6.919538582489261, 107.6478291494488',
                'status' => 'Aktif',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id_cabang' => 9,
                'nama_cabang' => 'Prama Fresh Burangrang',
                'alamat_cabang' => 'Jl. Burangrang No. 195',
                'koordinat_gps' => '-6.923449815611088, 107.61130913025827',
                'status' => 'Aktif',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id_cabang' => 10,
                'nama_cabang' => 'Prama Fresh Garuda',
                'alamat_cabang' => 'Jl. Garuda No. 210',
                'koordinat_gps' => '-6.919538582489261, 107.6478291494488',
                'status' => 'Aktif',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id_cabang' => 11,
                'nama_cabang' => 'Prama Fresh Mekarwangi',
                'alamat_cabang' => 'Jl. Mekarwangi No. 100',
                'koordinat_gps' => '-6.919538582489261, 107.6478291494488',
                'status' => 'Aktif',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id_cabang' => 12,
                'nama_cabang' => 'Prama Fresh Perintis',
                'alamat_cabang' => 'Jl. Perintis Kemerdekaan No. 210',
                'koordinat_gps' => '-6.919538582489261, 107.6478291494488',
                'status' => 'Aktif',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id_cabang' => 13,
                'nama_cabang' => 'Prama Leles',
                'alamat_cabang' => 'Jl. Raya Leles No. 200',
                'koordinat_gps' => '-7.02109051795237, 107.5757697995567',
                'status' => 'Aktif',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id_cabang' => 14,
                'nama_cabang' => 'Tikma Soreang',
                'alamat_cabang' => 'Jl. Raya Soreang No. 200',
                'koordinat_gps' => '-7.019687167687294, 107.48242338733801',
                'status' => 'Aktif',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);

        // 4. Data Detail Admin Cabang (Relasi ke Pengguna 2 & Cabang 1)
        DB::table('admin_cabang')->insert([
            [
                'id_admin_cabang' => 1,
                'id_pengguna' => 2,
                'id_cabang' => 1,
                'tanggal_masuk' => Carbon::now(),
                'status_karyawan' => 'Aktif',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);

        // 5. Data Master Produk
        DB::table('produk')->insert([
            [
                'id_produk' => 1,
                'nama_produk' => 'Beras Premium 10kg',
                'kategori' => 'Bahan Pokok',
                'deskripsi' => 'Beras premium kualitas terbaik dengan berat 10kg',
                'harga_reguler' => 240000,
                'harga_member' => 235000,
                'gambar_produk' => 'produk1.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id_produk' => 2,   
                'nama_produk' => 'Minyak Goreng Sania 2L',
                'kategori' => 'Bahan Pokok',
                'deskripsi' => 'Minyak goreng berkualitas dengan berat 2L',
                'harga_reguler' => 35000,
                'harga_member' => 33000,
                'gambar_produk' => 'produk2.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id_produk' => 3,   
                'nama_produk' => 'Gula Pasir Gulaku 1kg',
                'kategori' => 'Bahan Pokok',
                'deskripsi' => 'Gula pasir berkualitas dengan berat 1kg',
                'harga_reguler' => 17000,
                'harga_member' => 15000,
                'gambar_produk' => 'produk3.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id_produk' => 4,   
                'nama_produk' => 'Telur Ayam Negeri 1kg',
                'kategori' => 'Bahan Pokok',
                'deskripsi' => 'Telur ayam negeri berkualitas dengan berat 1kg',
                'harga_reguler' => 28000,
                'harga_member' => 26000,
                'gambar_produk' => 'produk4.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id_produk' => 5,   
                'nama_produk' => 'Daging Sapi Murni 1kg',
                'kategori' => 'Bahan Pokok',
                'deskripsi' => 'Daging sapi murni kualitas terbaik dengan berat 1kg',
                'harga_reguler' => 130000,
                'harga_member' => 125000,
                'gambar_produk' => 'produk5.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id_produk' => 6,   
                'nama_produk' => 'Ayam Broiler Utuh 1kg',
                'kategori' => 'Bahan Pokok',
                'deskripsi' => 'Ayam broiler utuh kualitas terbaik dengan berat 1kg',
                'harga_reguler' => 45000,
                'harga_member' => 42000,
                'gambar_produk' => 'produk6.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id_produk' => 7,   
                'nama_produk' => 'Ikan Mas',
                'kategori' => 'Bahan Pokok',
                'deskripsi' => 'Ikan mas kualitas segar dengan berat 1kg',
                'harga_reguler' => 55000,
                'harga_member' => 52000,
                'gambar_produk' => 'produk7.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id_produk' => 8,   
                'nama_produk' => 'Udang',
                'kategori' => 'Bahan Pokok',
                'deskripsi' => 'Udang segar kualitas premium dengan berat 1kg',
                'harga_reguler' => 85000,
                'harga_member' => 82000,
                'gambar_produk' => 'produk8.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id_produk' => 9,   
                'nama_produk' => 'Sosis Sapi',
                'kategori' => 'Olahan Daging',
                'deskripsi' => 'Sosis sapi kualitas premium dengan berat 500gr',
                'harga_reguler' => 45000,
                'harga_member' => 42000,
                'gambar_produk' => 'produk9.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id_produk' => 10,   
                'nama_produk' => 'Bakso Sapi',
                'kategori' => 'Olahan Daging',
                'deskripsi' => 'Bakso sapi kualitas premium dengan berat 500gr',
                'harga_reguler' => 55000,
                'harga_member' => 52000,
                'gambar_produk' => 'produk10.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]   
        ]);

        // 6. Data Stok Produk di Cabang
        DB::table('produk_cabang')->insert([
            [
                'id_produk_cabang' => 1,
                'id_produk' => 1,
                'id_cabang' => 1,
                'jumlah_stok' => 10,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id_produk_cabang' => 2,
                'id_produk' => 2,
                'id_cabang' => 1,
                'jumlah_stok' => 20,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id_produk_cabang' => 3,
                'id_produk' => 3,
                'id_cabang' => 1,
                'jumlah_stok' => 30,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id_produk_cabang' => 4,
                'id_produk' => 4,
                'id_cabang' => 1,
                'jumlah_stok' => 40,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id_produk_cabang' => 5,
                'id_produk' => 5,
                'id_cabang' => 2,
                'jumlah_stok' => 50,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id_produk_cabang' => 6,
                'id_produk' => 6,
                'id_cabang' => 2,
                'jumlah_stok' => 60,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id_produk_cabang' => 7,
                'id_produk' => 7,
                'id_cabang' => 2,
                'jumlah_stok' => 70,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id_produk_cabang' => 8,
                'id_produk' => 8,
                'id_cabang' => 2,
                'jumlah_stok' => 80,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id_produk_cabang' => 9,
                'id_produk' => 9,
                'id_cabang' => 2,
                'jumlah_stok' => 90,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id_produk_cabang' => 10,
                'id_produk' => 10,
                'id_cabang' => 2,
                'jumlah_stok' => 100,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);

        // 7. Data Detail Kurir (Relasi ke Pengguna 3 & Cabang 1)
        DB::table('kurir')->insert([
            'id_kurir' => 1,
            'id_pengguna' => 3,
            'id_cabang' => 1,
            'kendaraan' => 'Motor',
            'warna_kendaraan' => 'Hitam',
            'plat_nomor' => 'B 1234 ABC',
            'pendapatan_pengiriman' => 1000000,
            'status_mengirim' => 'Sedang Mengirim',
            'status_aktif' => 'Aktif',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        // 8. Data Transaksi Pesanan
        DB::table('pesanan')->insert([
            [
                'id_pesanan' => 1,
                'id_pelanggan' => 1,
                'id_cabang' => 1,
                'id_kurir' => 1,
                'id_promo' => null,
                'tanggal_pemesanan' => Carbon::now(),
                'total_belanja' => 310000,
                'biaya_pengiriman' => 15000,
                'diskon_voucher' => 0,
                'total_tagihan' => 325000,
                'metode_pembayaran' => 'Cash On Delivery',
                'alamat_pengiriman' => 'Jl. Contoh No. 123',
                'status_pesanan' => 'diterima',
                'estimasi_tiba' => Carbon::now(),
                'latitude' => -6.9025,
                'longitude' => 107.6186,
                'bukti_pengiriman' => 'bukti_pengiriman.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id_pesanan' => 2,
                'id_pelanggan' => 1,
                'id_cabang' => 3,
                'id_kurir' => 1,
                'id_promo' => null,
                'tanggal_pemesanan' => Carbon::now(),
                'total_belanja' => 203000,
                'biaya_pengiriman' => 15000,
                'diskon_voucher' => 0,
                'total_tagihan' => 218000,
                'metode_pembayaran' => 'Transfer',
                'alamat_pengiriman' => 'Jl. Contoh No. 123',
                'status_pesanan' => 'dalam_pengiriman',
                'estimasi_tiba' => Carbon::now(),
                'latitude' => -6.9175,
                'longitude' => 107.6090,
                'bukti_pengiriman' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ]);

        // 9. Data Detail Produk yang Dipesan
        DB::table('pesanan_produk')->insert([
            [
                'id_pesanan_produk' => 1,
                'id_pesanan' => 1,
                'id_produk' => 1,
                'jumlah' => 1,
                'harga_satuan' => 240000,
                'subtotal' => 240000,
                'catatan_produk' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id_pesanan_produk' => 2,
                'id_pesanan' => 1,
                'id_produk' => 2,
                'jumlah' => 2,
                'harga_satuan' => 35000,
                'subtotal' => 70000,
                'catatan_produk' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id_pesanan_produk' => 3,
                'id_pesanan' => 2,
                'id_produk' => 3,
                'jumlah' => 1,
                'harga_satuan' => 17000,
                'subtotal' => 17000,
                'catatan_produk' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id_pesanan_produk' => 4,
                'id_pesanan' => 2,
                'id_produk' => 4,
                'jumlah' => 2,
                'harga_satuan' => 28000,
                'subtotal' => 56000,
                'catatan_produk' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id_pesanan_produk' => 5,
                'id_pesanan' => 2,
                'id_produk' => 5,
                'jumlah' => 1,
                'harga_satuan' => 130000,
                'subtotal' => 130000,
                'catatan_produk' => 'Tenderloin Daging Sapi',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ]);

        // 10. Data Tracking Pengiriman
        DB::table('pengiriman_tracking')->insert([
            [
                'id_pesanan' => 1,
                'status' => 'Menunggu',
                'keterangan' => 'Pesanan baru',
                'created_at' => Carbon::now()->subHours(5),
                'updated_at' => Carbon::now()->subHours(5)
            ],
            [
                'id_pesanan' => 1,
                'status' => 'Disiapkan',
                'keterangan' => 'Barang sedang disiapkan',
                'created_at' => Carbon::now()->subHours(4),
                'updated_at' => Carbon::now()->subHours(4)
            ],
            [
                'id_pesanan' => 1,
                'status' => 'mencari_driver',
                'keterangan' => 'Menunggu kurir mengambil barang',
                'created_at' => Carbon::now()->subHours(3),
                'updated_at' => Carbon::now()->subHours(3)
            ],
            [
                'id_pesanan' => 1,
                'status' => 'dalam_pengiriman',
                'keterangan' => 'Kurir sedang mengantar pesanan',
                'created_at' => Carbon::now()->subHours(2),
                'updated_at' => Carbon::now()->subHours(2)
            ],
            [
                'id_pesanan' => 1,
                'status' => 'diterima',
                'keterangan' => 'Pesanan telah diterima pelanggan',
                'created_at' => Carbon::now()->subHours(1),
                'updated_at' => Carbon::now()->subHours(1)
            ],
            [
                'id_pesanan' => 2,
                'status' => 'Menunggu',
                'keterangan' => 'Pesanan baru',
                'created_at' => Carbon::now()->subHours(2),
                'updated_at' => Carbon::now()->subHours(2)
            ],
            [
                'id_pesanan' => 2,
                'status' => 'Disiapkan',
                'keterangan' => 'Barang sedang disiapkan',
                'created_at' => Carbon::now()->subHours(1),
                'updated_at' => Carbon::now()->subHours(1)
            ],
            [
                'id_pesanan' => 2,
                'status' => 'dalam_pengiriman',
                'keterangan' => 'Kurir sedang dalam perjalanan',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);

        // 11. Data History Produk (Perubahan Harga)
        DB::table('history_produk')->insert([
            [
                'id_produk' => 1,
                'harga_reguler_lama' => 230000,
                'harga_reguler_baru' => 240000,
                'harga_member_lama' => 225000,
                'harga_member_baru' => 235000,
                'id_admin_cabang' => 1,
                'created_at' => Carbon::now()->subDays(10),
                'updated_at' => Carbon::now()->subDays(10)
            ],
            [
                'id_produk' => 2,
                'harga_reguler_lama' => 32000,
                'harga_reguler_baru' => 35000,
                'harga_member_lama' => 30000,
                'harga_member_baru' => 33000,
                'id_admin_cabang' => 1,
                'created_at' => Carbon::now()->subDays(5),
                'updated_at' => Carbon::now()->subDays(5)
            ]
        ]);

        // 12. Data Promo & Voucher
        DB::table('promo')->insert([
            [
                'id_cabang' => 1,
                'id_produk_pemicu' => 2, // Minyak Goreng
                'id_produk_hadiah' => 2, // Gratis Minyak Goreng
                'nama_voucher' => 'Beli 2 Gratis 1 Minyak Goreng',
                'kode_voucher' => 'MINYAKFREE',
                'kuantitas_pemicu' => 2,
                'kuantitas_hadiah' => 1,
                'potongan_harga' => 0,
                'min_transaksi' => 70000,
                'max_promo' => 35000,
                'kuota_promo' => 100,
                'tanggal_mulai' => Carbon::now()->subDays(2)->toDateString(),
                'tanggal_berakhir' => Carbon::now()->addDays(7)->toDateString(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id_cabang' => 1,
                'id_produk_pemicu' => 1, // Beras Premium
                'id_produk_hadiah' => null,
                'nama_voucher' => 'Diskon Rp 15.000 Beras Premium',
                'kode_voucher' => 'BERASDISKON',
                'kuantitas_pemicu' => 1,
                'kuantitas_hadiah' => 0,
                'potongan_harga' => 15000,
                'min_transaksi' => 240000,
                'max_promo' => 15000,
                'kuota_promo' => 50,
                'tanggal_mulai' => Carbon::now()->subDays(1)->toDateString(),
                'tanggal_berakhir' => Carbon::now()->addDays(14)->toDateString(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);

        // 13. Data Hak Akses Menu
        DB::table('hak_akses_menu')->insert([
            // Super Admin (id_pengguna: 1)
            ['id_pengguna' => 1, 'menu_key' => 'superadmin_dashboard', 'akses' => true, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id_pengguna' => 1, 'menu_key' => 'superadmin_pesanan', 'akses' => true, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id_pengguna' => 1, 'menu_key' => 'superadmin_cabang', 'akses' => true, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id_pengguna' => 1, 'menu_key' => 'superadmin_member', 'akses' => true, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id_pengguna' => 1, 'menu_key' => 'superadmin_pengemudi', 'akses' => true, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id_pengguna' => 1, 'menu_key' => 'superadmin_promo', 'akses' => true, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            // Admin Cabang (id_pengguna: 2)
            ['id_pengguna' => 2, 'menu_key' => 'admincabang_dashboard', 'akses' => true, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id_pengguna' => 2, 'menu_key' => 'admincabang_produk', 'akses' => true, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id_pengguna' => 2, 'menu_key' => 'admincabang_pesanan', 'akses' => true, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id_pengguna' => 2, 'menu_key' => 'admincabang_member', 'akses' => true, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id_pengguna' => 2, 'menu_key' => 'admincabang_promo', 'akses' => true, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id_pengguna' => 2, 'menu_key' => 'admincabang_laporan', 'akses' => true, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id_pengguna' => 2, 'menu_key' => 'admincabang_pengaturan', 'akses' => true, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);
    }
}
