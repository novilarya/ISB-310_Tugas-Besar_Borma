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

        DB::table('users')->insert([
            [
                'id_user' => 1,
                'nama' => 'Super Admin 1',
                'email' => 'superadmin@gmail.com',
                'password' => Hash::make('12345678'),
                'no_telepon' => '081234567891',
                'role' => 'Admin Super',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id_user' => 2,
                'nama' => 'Admin Cabang 1',
                'email' => 'admincabang@gmail.com',
                'password' => Hash::make('12345678'),
                'no_telepon' => '081234567892',
                'role' => 'Admin Cabang',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id_user' => 3,
                'nama' => 'Kurir 1',
                'email' => 'kurir@gmail.com',
                'password' => Hash::make('12345678'),
                'no_telepon' => '081234567893',
                'role' => 'Kurir',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id_user' => 4,
                'nama' => 'Agus Lele',
                'email' => 'user@gmail.com',
                'password' => Hash::make('12345678'),
                'no_telepon' => '081234567894',
                'role' => 'Pelanggan',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);
        
        $this->call([
            AdminCabangSeeder::class, // cabang, admin user, produk, stok
            OrderSeeder::class,       // pelanggan, kurir, pesanan, items
            PromoSeeder::class,       // promo & voucher

        ]);

        DB::table('pelanggans')->insert([
            [
                'id_pelanggan' => 1,
                'id_user' => 4,
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

        DB::table('cabangs')->insert([
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

        DB::table('admin_cabangs')->insert([
            [
                'id_admin_cabang' => 1,
                'id_user' => 2,
                'id_cabang' => 1,
                'tanggal_masuk' => Carbon::now(),
                'status_karyawan' => 'Aktif',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);

        DB::table('produks')->insert([
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

        DB::table('produk_cabangs')->insert([
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

        DB::table('kurirs')->insert([
            'id_kurir' => 1,
            'id_user' => 3,
            'kendaraan' => 'Motor',
            'warna_kendaraan' => 'Merah',
            'plat_nomor' => 'D 1234 ABC',
            'id_cabang' => 1,
            'penghasilan_kotor' => 0,
            'penghasilan_bersih' => 0,
            'status_mengirim' => 'Tidak Mengirim',
            'status_aktif' => 'Aktif',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        
        DB::table('pesanans')->insert([
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
                'status_pesanan' => 'Diterima',
                'estimasi_tiba' => Carbon::now(),
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
                'status_pesanan' => 'Sedang Dikirim',
                'estimasi_tiba' => Carbon::now(),
                'bukti_pengiriman' => 'bukti_pengiriman.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ]);

        DB::table('pesanan_produks')->insert([
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

    }
}   
