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
                'email' => 'boxcraft80@gmail.com',
                'password' => Hash::make('12345678'),
                'no_telepon' => '081234567891',
                'role' => 'Admin Super',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id_pengguna' => 2,
                'nama' => 'Admin Cabang 1',
                'email' => 'muhammadhafiz2102@gmail.com',
                'password' => Hash::make('12345678'),
                'no_telepon' => '081234567892',
                'role' => 'Admin Cabang',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id_pengguna' => 3,
                'nama' => 'Kurir 1',
                'email' => 'mj9603488@gmail.com',
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
                'status_member_plus' => 1,
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
        $originalProducts = [
            [
                'id_produk' => 1,
                'nama_produk' => 'Beras Premium 10kg',
                'kategori' => 'Sembako & Bahan Pokok',
                'deskripsi' => 'Beras premium kualitas terbaik dengan berat 10kg',
                'harga_reguler' => 240000,
                'harga_member' => 235000,
                'gambar_produk' => 'produk1.jpg',
            ],
            [
                'id_produk' => 2,   
                'nama_produk' => 'Minyak Goreng Sania 2L',
                'kategori' => 'Sembako & Bahan Pokok',
                'deskripsi' => 'Minyak goreng berkualitas dengan berat 2L',
                'harga_reguler' => 35000,
                'harga_member' => 33000,
                'gambar_produk' => 'produk2.jpg',
            ],
            [
                'id_produk' => 3,   
                'nama_produk' => 'Gula Pasir Gulaku 1kg',
                'kategori' => 'Sembako & Bahan Pokok',
                'deskripsi' => 'Gula pasir berkualitas dengan berat 1kg',
                'harga_reguler' => 17000,
                'harga_member' => 15000,
                'gambar_produk' => 'produk3.jpg',
            ],
            [
                'id_produk' => 4,   
                'nama_produk' => 'Telur Ayam Negeri 1kg',
                'kategori' => 'Sembako & Bahan Pokok',
                'deskripsi' => 'Telur ayam negeri berkualitas dengan berat 1kg',
                'harga_reguler' => 28000,
                'harga_member' => 26000,
                'gambar_produk' => 'produk4.jpg',
            ],
            [
                'id_produk' => 5,   
                'nama_produk' => 'Daging Sapi Murni 1kg',
                'kategori' => 'Daging & Ikan',
                'deskripsi' => 'Daging sapi murni kualitas terbaik dengan berat 1kg',
                'harga_reguler' => 130000,
                'harga_member' => 125000,
                'gambar_produk' => 'produk5.jpg',
            ],
            [
                'id_produk' => 6,   
                'nama_produk' => 'Ayam Broiler Utuh 1kg',
                'kategori' => 'Daging & Ikan',
                'deskripsi' => 'Ayam broiler utuh kualitas terbaik dengan berat 1kg',
                'harga_reguler' => 45000,
                'harga_member' => 42000,
                'gambar_produk' => 'produk6.jpg',
            ],
            [
                'id_produk' => 7,   
                'nama_produk' => 'Ikan Mas',
                'kategori' => 'Daging & Ikan',
                'deskripsi' => 'Ikan mas kualitas segar dengan berat 1kg',
                'harga_reguler' => 55000,
                'harga_member' => 52000,
                'gambar_produk' => 'produk7.jpg',
            ],
            [
                'id_produk' => 8,   
                'nama_produk' => 'Udang',
                'kategori' => 'Daging & Ikan',
                'deskripsi' => 'Udang segar kualitas premium dengan berat 1kg',
                'harga_reguler' => 85000,
                'harga_member' => 82000,
                'gambar_produk' => 'produk8.jpg',
            ],
            [
                'id_produk' => 9,   
                'nama_produk' => 'Sosis Sapi',
                'kategori' => 'Daging & Ikan',
                'deskripsi' => 'Sosis sapi kualitas premium dengan berat 500gr',
                'harga_reguler' => 45000,
                'harga_member' => 42000,
                'gambar_produk' => 'produk9.jpg',
            ],
            [
                'id_produk' => 10,   
                'nama_produk' => 'Bakso Sapi',
                'kategori' => 'Daging & Ikan',
                'deskripsi' => 'Bakso sapi kualitas premium dengan berat 500gr',
                'harga_reguler' => 55000,
                'harga_member' => 52000,
                'gambar_produk' => 'produk10.jpg',
            ],
        ];

        $catalogProducts = [
            // Sembako (10 products)
            ['name' => 'Beras Pandan Wangi 5kg', 'cat' => 'Sembako & Bahan Pokok', 'price' => 78000, 'sale' => 72000, 'img' => 'beras-wangi-5kg.jpg'],
            ['name' => 'Minyak Goreng Bimoli 2L', 'cat' => 'Sembako & Bahan Pokok', 'price' => 45000, 'sale' => 32500, 'img' => 'minyak-bimoli-2lt.avif'],
            ['name' => 'Gulaku Pasir 1kg', 'cat' => 'Sembako & Bahan Pokok', 'price' => 18000, 'sale' => 0, 'img' => 'gulaku-pasir-1kg.jpg'],
            ['name' => 'Tepung Terigu Segitiga Biru 1kg', 'cat' => 'Sembako & Bahan Pokok', 'price' => 14500, 'sale' => 0, 'img' => 'tepung-segitigabiru-1kg.jpg'],
            ['name' => 'Mie Instan Sedap Goreng (5pcs)', 'cat' => 'Sembako & Bahan Pokok', 'price' => 15000, 'sale' => 12500, 'img' => 'miesedap-isi5.jpg'],
            ['name' => 'Kecap Manis ABC 130ml', 'cat' => 'Sembako & Bahan Pokok', 'price' => 22000, 'sale' => 0, 'img' => 'kecapmaniABC130ml.jpg'],
            ['name' => 'Telur Ayam 1kg', 'cat' => 'Sembako & Bahan Pokok', 'price' => 28000, 'sale' => 26000, 'img' => 'telurayam-1kg.jpg'],
            ['name' => 'Garam Dapur Cap Kapal 500g', 'cat' => 'Sembako & Bahan Pokok', 'price' => 5000, 'sale' => 0, 'img' => 'garamdapur-500gr.jpg'],
            ['name' => 'Santan Kara 200ml', 'cat' => 'Sembako & Bahan Pokok', 'price' => 8500, 'sale' => 7000, 'img' => 'santankara-200ml.jpg'],
            ['name' => 'Saus Tomat ABC 335ml', 'cat' => 'Sembako & Bahan Pokok', 'price' => 12000, 'sale' => 0, 'img' => 'saustomatABC-335ml.jpg'],

            // Sayur & Buah (11 products)
            ['name' => 'Apel Fuji Premium 1kg', 'cat' => 'Sayur & Buah', 'price' => 45000, 'sale' => 36000, 'img' => 'apelfuji-1kg.jpg'],
            ['name' => 'Wortel Lokal Organik 500g', 'cat' => 'Sayur & Buah', 'price' => 12000, 'sale' => 0, 'img' => 'wortel500gr.jpg'],
            ['name' => 'Pisang Cavendish (Sisir)', 'cat' => 'Sayur & Buah', 'price' => 25000, 'sale' => 0, 'img' => 'pisang.jpg'],
            ['name' => 'Brokoli Segar 250g', 'cat' => 'Sayur & Buah', 'price' => 39000, 'sale' => 0, 'img' => 'brokoli-250gr.jpg'],
            ['name' => 'Bayam Petik (Ikat)', 'cat' => 'Sayur & Buah', 'price' => 4500, 'sale' => 0, 'img' => 'bayam.jpg'],
            ['name' => 'Strawberry Korea (Box)', 'cat' => 'Sayur & Buah', 'price' => 85000, 'sale' => 75000, 'img' => 'strawberrybox.jpg'],
            ['name' => 'Tomat Merah 500g', 'cat' => 'Sayur & Buah', 'price' => 10000, 'sale' => 0, 'img' => 'tomatmerah500gr.jpg'],
            ['name' => 'Jeruk Sunkist 1kg', 'cat' => 'Sayur & Buah', 'price' => 35000, 'sale' => 30000, 'img' => 'jeruksunkist.jpg'],
            ['name' => 'Kentang Dieng 1kg', 'cat' => 'Sayur & Buah', 'price' => 16000, 'sale' => 0, 'img' => 'kentang1kg.jpg'],
            ['name' => 'Kangkung Segar (Ikat)', 'cat' => 'Sayur & Buah', 'price' => 3500, 'sale' => 0, 'img' => 'kangkung.jpg'],
            ['name' => 'Mangga Harum Manis 1kg', 'cat' => 'Sayur & Buah', 'price' => 28000, 'sale' => 24000, 'img' => 'manggaharummanis.jpg'],

            // Daging & Ikan (10 products)
            ['name' => 'Daging Sapi Has Dalam 500g', 'cat' => 'Daging & Ikan', 'price' => 75000, 'sale' => 0, 'img' => 'daginghasdalam.jpg'],
            ['name' => 'Ayam Potong Broiler 1kg', 'cat' => 'Daging & Ikan', 'price' => 38000, 'sale' => 34000, 'img' => 'ayampotong.jpg'],
            ['name' => 'Ikan Salmon Fillet 200g', 'cat' => 'Daging & Ikan', 'price' => 65000, 'sale' => 0, 'img' => 'salmonfillet.jpg'],
            ['name' => 'Udang Vaname 500g', 'cat' => 'Daging & Ikan', 'price' => 55000, 'sale' => 48000, 'img' => 'udangvaname.jpg'],
            ['name' => 'Bakso Sapi Sule Kemasan 500g', 'cat' => 'Daging & Ikan', 'price' => 32000, 'sale' => 0, 'img' => 'baksosapipolos.jpg'],
            ['name' => 'Ikan Tuna Fillet 300g', 'cat' => 'Daging & Ikan', 'price' => 42000, 'sale' => 0, 'img' => 'ikantunafillet.jpg'],
            ['name' => 'Sosis Ayam So Nice 375g', 'cat' => 'Daging & Ikan', 'price' => 25000, 'sale' => 22000, 'img' => 'sosissonice.jpg'],
            ['name' => 'Nugget Fiesta 500g', 'cat' => 'Daging & Ikan', 'price' => 38000, 'sale' => 0, 'img' => 'nuggetfiesta.jpg'],
            ['name' => 'Cumi-Cumi Segar 500g', 'cat' => 'Daging & Ikan', 'price' => 45000, 'sale' => 0, 'img' => 'cumicumi.jpg'],
            ['name' => 'Daging Giling Sapi 500g', 'cat' => 'Daging & Ikan', 'price' => 60000, 'sale' => 55000, 'img' => 'daginggiling.jpg'],

            // Susu & Olahan (10 products)
            ['name' => 'Susu Ultra Milk Full Cream 1L', 'cat' => 'Susu & Olahan', 'price' => 21000, 'sale' => 18500, 'img' => 'susuultramilk.jpg'],
            ['name' => 'Keju Kraft Cheddar 165g', 'cat' => 'Susu & Olahan', 'price' => 18000, 'sale' => 0, 'img' => 'kejucheddar.jpg'],
            ['name' => 'Yogurt Cimory 250ml', 'cat' => 'Susu & Olahan', 'price' => 12000, 'sale' => 10000, 'img' => 'yoghurtplain.jpg'],
            ['name' => 'Mentega Blue Band 200g', 'cat' => 'Susu & Olahan', 'price' => 15000, 'sale' => 0, 'img' => 'blueband.jpg'],
            ['name' => 'Susu Kental Manis Frisian Flag 370g', 'cat' => 'Susu & Olahan', 'price' => 14000, 'sale' => 0, 'img' => 'susukental.jpg'],
            ['name' => 'Susu Indomilk Coklat 1L', 'cat' => 'Susu & Olahan', 'price' => 19000, 'sale' => 0, 'img' => 'indomilkcoklat.jpg'],
            ['name' => 'Keju Mozzarella Greenfields 200g', 'cat' => 'Susu & Olahan', 'price' => 35000, 'sale' => 30000, 'img' => 'kejumozza.jpg'],
            ['name' => 'Cream Cheese Yummy 250g', 'cat' => 'Susu & Olahan', 'price' => 42000, 'sale' => 0, 'img' => 'krimkeju.jpg'],
            ['name' => 'Susu Bear Brand Gold 140ml', 'cat' => 'Susu & Olahan', 'price' => 12000, 'sale' => 10500, 'img' => 'susuberuang.jpg'],
            ['name' => 'Butter Wijsman 200g', 'cat' => 'Susu & Olahan', 'price' => 55000, 'sale' => 0, 'img' => 'wisman.jpg'],

            // Minuman (10 products)
            ['name' => 'Teh Botol Sosro 450ml', 'cat' => 'Minuman', 'price' => 5000, 'sale' => 0, 'img' => 'sosro.jpg'],
            ['name' => 'Coca Cola 1.5L', 'cat' => 'Minuman', 'price' => 16000, 'sale' => 14000, 'img' => 'coke.jpg'],
            ['name' => 'Aqua 600ml (6pcs)', 'cat' => 'Minuman', 'price' => 12000, 'sale' => 0, 'img' => 'aqua6pcs.jpg'],
            ['name' => 'Kopi Good Day Cappuccino 10s', 'cat' => 'Minuman', 'price' => 18000, 'sale' => 15000, 'img' => 'goodday.jpg'],
            ['name' => 'Yakult 5x65ml', 'cat' => 'Minuman', 'price' => 10000, 'sale' => 0, 'img' => 'yakult.jpg'],
            ['name' => 'Pocari Sweat 500ml', 'cat' => 'Minuman', 'price' => 8000, 'sale' => 0, 'img' => 'pocari.jpg'],
            ['name' => 'Sirup Marjan Cocopandan 460ml', 'cat' => 'Minuman', 'price' => 22000, 'sale' => 19000, 'img' => 'marjan.jpg'],
            ['name' => 'Le Minerale 330ml (6pcs)', 'cat' => 'Minuman', 'price' => 11000, 'sale' => 0, 'img' => 'leminerale.jpg'],
            ['name' => 'Fanta Strawberry 1.5L', 'cat' => 'Minuman', 'price' => 14000, 'sale' => 0, 'img' => 'fantastrawberry.jpg'],
            ['name' => 'Nutrisari Jeruk Peras 10s', 'cat' => 'Minuman', 'price' => 12000, 'sale' => 10000, 'img' => 'nutrisari.jpg'],

            // Snack & Camilan (10 products)
            ['name' => 'Chitato Sapi Panggang 68g', 'cat' => 'Snack & Camilan', 'price' => 10000, 'sale' => 0, 'img' => 'chitatosapi.jpg'],
            ['name' => 'Oreo Vanilla 133g', 'cat' => 'Snack & Camilan', 'price' => 12000, 'sale' => 10000, 'img' => 'oreovanilla.jpg'],
            ['name' => 'Pringles Original 110g', 'cat' => 'Snack & Camilan', 'price' => 28000, 'sale' => 0, 'img' => 'pringles.jpg'],
            ['name' => 'Pocky Strawberry 45g', 'cat' => 'Snack & Camilan', 'price' => 9000, 'sale' => 0, 'img' => 'pockystrawberry.jpg'],
            ['name' => 'Coklat Silverqueen 65g', 'cat' => 'Snack & Camilan', 'price' => 16000, 'sale' => 14000, 'img' => 'silverqueen.jpg'],
            ['name' => 'Tango Wafer Coklat 176g', 'cat' => 'Snack & Camilan', 'price' => 14000, 'sale' => 0, 'img' => 'wafertango.jpg'],
            ['name' => 'Lays Classic 68g', 'cat' => 'Snack & Camilan', 'price' => 10000, 'sale' => 0, 'img' => 'lays.jpg'],
            ['name' => 'Biskuit Roma Kelapa 300g', 'cat' => 'Snack & Camilan', 'price' => 8000, 'sale' => 6500, 'img' => 'biskuit-roma.jpg'],
            ['name' => 'Kacang Garuda 100g', 'cat' => 'Snack & Camilan', 'price' => 12000, 'sale' => 0, 'img' => 'kacang-garuda.jpg'],
            ['name' => 'Nabati Richeese 150g', 'cat' => 'Snack & Camilan', 'price' => 11000, 'sale' => 9500, 'img' => 'nabati.jpg'],

            // Kebutuhan Rumah (10 products)
            ['name' => 'Deterjen Rinso Anti Noda 800g', 'cat' => 'Kebutuhan Rumah', 'price' => 22000, 'sale' => 0, 'img' => 'rinso.jpg'],
            ['name' => 'Sabun Cuci Piring Sunlight 800ml', 'cat' => 'Kebutuhan Rumah', 'price' => 16000, 'sale' => 14000, 'img' => 'sunlight.jpg'],
            ['name' => 'Pewangi Molto 900ml', 'cat' => 'Kebutuhan Rumah', 'price' => 24000, 'sale' => 0, 'img' => 'molto.jpg'],
            ['name' => 'Pembersih Lantai Super Pell 800ml', 'cat' => 'Kebutuhan Rumah', 'price' => 14000, 'sale' => 0, 'img' => 'super-pell.jpg'],
            ['name' => 'Tissue Paseo 250 Sheet', 'cat' => 'Kebutuhan Rumah', 'price' => 18000, 'sale' => 15000, 'img' => 'tissue.jpg'],
            ['name' => 'Sapu Ijuk Premium', 'cat' => 'Kebutuhan Rumah', 'price' => 25000, 'sale' => 0, 'img' => 'sapu.jpg'],
            ['name' => 'Kain Lap Microfiber 3pcs', 'cat' => 'Kebutuhan Rumah', 'price' => 20000, 'sale' => 0, 'img' => 'lap-microfiber.jpg'],
            ['name' => 'Baygon Aerosol 600ml', 'cat' => 'Kebutuhan Rumah', 'price' => 35000, 'sale' => 30000, 'img' => 'baygon.jpg'],
            ['name' => 'Ember Plastik 20L', 'cat' => 'Kebutuhan Rumah', 'price' => 28000, 'sale' => 0, 'img' => 'ember.jpg'],
            ['name' => 'Trash Bag Roll 45x50 20pcs', 'cat' => 'Kebutuhan Rumah', 'price' => 12000, 'sale' => 0, 'img' => 'trash-bag.jpg'],

            // Perawatan Diri (10 products)
            ['name' => 'Shampo Pantene 400ml', 'cat' => 'Perawatan Diri', 'price' => 42000, 'sale' => 38000, 'img' => 'shampo.jpg'],
            ['name' => 'Sabun Lifebuoy 100g (4pcs)', 'cat' => 'Perawatan Diri', 'price' => 18000, 'sale' => 0, 'img' => 'sabun-lifebuoy.jpg'],
            ['name' => 'Pasta Gigi Pepsodent 190g', 'cat' => 'Perawatan Diri', 'price' => 14000, 'sale' => 12000, 'img' => 'pasta-gigi.jpg'],
            ['name' => 'Deodoran Rexona 50ml', 'cat' => 'Perawatan Diri', 'price' => 22000, 'sale' => 0, 'img' => 'deodoran.jpg'],
            ['name' => 'Sunscreen Nivea SPF50 100ml', 'cat' => 'Perawatan Diri', 'price' => 48000, 'sale' => 0, 'img' => 'sunscreen.jpg'],
            ['name' => 'Hand Body Vaseline 200ml', 'cat' => 'Perawatan Diri', 'price' => 25000, 'sale' => 22000, 'img' => 'hand-body.jpg'],
            ['name' => 'Sikat Gigi Oral-B 3pcs', 'cat' => 'Perawatan Diri', 'price' => 28000, 'sale' => 0, 'img' => 'sikat-gigi.jpg'],
            ['name' => 'Kapas Wajah Selection 50g', 'cat' => 'Perawatan Diri', 'price' => 8000, 'sale' => 0, 'img' => 'kapas.jpg'],
            ['name' => 'Conditioner Dove 320ml', 'cat' => 'Perawatan Diri', 'price' => 35000, 'sale' => 30000, 'img' => 'conditioner.jpg'],
            ['name' => 'Sabun Cair Dettol 300ml', 'cat' => 'Perawatan Diri', 'price' => 32000, 'sale' => 0, 'img' => 'sabun-cair.jpg'],
        ];

        $productsToInsert = [];
        $nextId = 11;
        
        foreach ($originalProducts as $op) {
            $productsToInsert[] = [
                'id_produk' => $op['id_produk'],
                'nama_produk' => $op['nama_produk'],
                'kategori' => $op['kategori'],
                'deskripsi' => $op['deskripsi'],
                'harga_reguler' => $op['harga_reguler'],
                'harga_member' => $op['harga_member'],
                'harga_member_plus' => round($op['harga_member'] * 0.95),
                'gambar_produk' => '', // Hilangkan gambar produk
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        foreach ($catalogProducts as $cp) {
            $memberPrice = $cp['sale'] > 0 ? $cp['sale'] : $cp['price'];
            $productsToInsert[] = [
                'id_produk' => $nextId++,
                'nama_produk' => $cp['name'],
                'kategori' => $cp['cat'],
                'deskripsi' => $cp['name'] . ' berkualitas dari Borma.',
                'harga_reguler' => $cp['price'],
                'harga_member' => $memberPrice,
                'harga_member_plus' => round($memberPrice * 0.95),
                'gambar_produk' => '', // Hilangkan gambar produk
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        DB::table('produk')->insert($productsToInsert);

        // 6. Data Stok Produk di Cabang
        $produkCabangRows = [];
        $idProdukCabang = 1;
        
        foreach ($productsToInsert as $p) {
            $prodId = $p['id_produk'];
            $prodName = $p['nama_produk'];
            for ($c = 1; $c <= 14; $c++) {
                // Sembako pokok selalu ada di semua cabang
                $isStaple = str_contains(strtolower($prodName), 'beras') || 
                            str_contains(strtolower($prodName), 'minyak') || 
                            str_contains(strtolower($prodName), 'gula') || 
                            str_contains(strtolower($prodName), 'telur');
                
                // Produk lainnya dibedakan berdasarkan ganjil/genap ID produk + nomor cabang
                $isAvailable = $isStaple || (($prodId + $c) % 2 === 0);
                
                if ($isAvailable) {
                    $produkCabangRows[] = [
                        'id_produk_cabang' => $idProdukCabang++,
                        'id_produk' => $prodId,
                        'id_cabang' => $c,
                        'jumlah_stok' => rand(15, 80),
                        'jumlah_terjual' => rand(0, 25),
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ];
                }
            }
        }

        foreach (array_chunk($produkCabangRows, 200) as $chunk) {
            DB::table('produk_cabang')->insert($chunk);
        }

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
