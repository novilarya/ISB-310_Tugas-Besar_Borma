<?php

namespace Tests\Feature\AdminCabang;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Pelanggan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MemberTest extends TestCase
{
    use RefreshDatabase;

    protected $adminUser;
    protected $cabang;

    protected function setUp(): void
    {
        parent::setUp();

        // 1. Buat Cabang
        DB::table('cabang')->insert([
            'id_cabang' => 1,
            'nama_cabang' => 'Borma Gempol',
            'alamat_cabang' => 'Jl. Gempol No. 12',
            'koordinat_gps' => '-6.90123,107.61234',
            'status' => 'Aktif',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // 2. Buat Admin Cabang
        $this->adminUser = User::create([
            'nama' => 'Admin Cabang Gempol',
            'email' => 'admin.gempol@borma.com',
            'password' => Hash::make('password123'),
            'role' => 'Admin Cabang',
            'no_telepon' => '081234567891'
        ]);

        DB::table('admin_cabang')->insert([
            'id_pengguna' => $this->adminUser->id_pengguna,
            'id_cabang' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    /**
     * White-Box Test: Otorisasi Keamanan (Authorization Guard)
     * Menguji bahwa endpoint member hanya dapat diakses oleh user ber-role Admin Cabang.
     */
    public function test_non_admin_cabang_cannot_access_member_features()
    {
        // Jalur A: Tanpa Login (Tamu) -> Redirect ke halaman login
        $responseGuest = $this->get(route('admin-cabang.member'));
        $responseGuest->assertRedirect(route('login'));

        // Jalur B: Login sebagai Pelanggan -> Ditolak (Redirect ke dashboard pelanggan atau abort)
        $pelangganUser = User::create([
            'nama' => 'Budi Pelanggan',
            'email' => 'budi@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'Pelanggan',
            'no_telepon' => '081234567890'
        ]);

        $responsePelanggan = $this->actingAs($pelangganUser)
            ->get(route('admin-cabang.member'));
        
        // Memastikan route ditolak dengan HTTP 403 Forbidden
        $responsePelanggan->assertStatus(403);
    }

    /**
     * White-Box Test: Percabangan Logika Filter & Sorting pada MemberController@index
     * Menguji filter pencarian, filter status_member_plus, dan pengurutan (sorting) data.
     */
    public function test_admin_cabang_can_list_members_with_filters_and_sorting()
    {
        // 1. Buat beberapa dummy member untuk pengujian filter
        $user1 = User::create([
            'nama' => 'Alice Member Plus',
            'email' => 'alice@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'Pelanggan',
            'no_telepon' => '08111111111'
        ]);
        $pelanggan1 = Pelanggan::create([
            'id_pengguna' => $user1->id_pengguna,
            'provinsi' => 'Jawa Barat',
            'kota_kabupaten' => 'Bandung',
            'kecamatan' => 'Coblong',
            'alamat' => 'Dago',
            'status_member_plus' => true,
            'poin_member' => 150
        ]);

        $user2 = User::create([
            'nama' => 'Bob Member Regular',
            'email' => 'bob@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'Pelanggan',
            'no_telepon' => '08222222222'
        ]);
        $pelanggan2 = Pelanggan::create([
            'id_pengguna' => $user2->id_pengguna,
            'provinsi' => 'Jawa Barat',
            'kota_kabupaten' => 'Bandung',
            'kecamatan' => 'Lengkong',
            'alamat' => 'Buah Batu',
            'status_member_plus' => false,
            'poin_member' => 50
        ]);

        // Login sebagai Admin Cabang
        $this->actingAs($this->adminUser);

        // Kasus 1: Tanpa Filter (Menampilkan semua)
        $responseAll = $this->get(route('admin-cabang.member'));
        $responseAll->assertStatus(200);
        $responseAll->assertViewHas('members');
        $this->assertCount(2, $responseAll->viewData('members'));

        // Kasus 2: Filter Pencarian Kata Kunci "Alice" (Jalur $search)
        $responseSearch = $this->get(route('admin-cabang.member', ['search' => 'Alice']));
        $responseSearch->assertStatus(200);
        $membersSearch = $responseSearch->viewData('members');
        $this->assertCount(1, $membersSearch);
        $this->assertEquals('Alice Member Plus', $membersSearch->first()->user->nama);

        // Kasus 3: Filter Status Member Plus (Jalur $status === 'member_plus')
        $responseFilterPlus = $this->get(route('admin-cabang.member', ['status' => 'member_plus']));
        $responseFilterPlus->assertStatus(200);
        $membersPlus = $responseFilterPlus->viewData('members');
        $this->assertCount(1, $membersPlus);
        $this->assertEquals('Alice Member Plus', $membersPlus->first()->user->nama);

        // Kasus 4: Filter Status Member Regular (Jalur $status === 'member')
        $responseFilterReg = $this->get(route('admin-cabang.member', ['status' => 'member']));
        $responseFilterReg->assertStatus(200);
        $membersReg = $responseFilterReg->viewData('members');
        $this->assertCount(1, $membersReg);
        $this->assertEquals('Bob Member Regular', $membersReg->first()->user->nama);

        // Kasus 5: Sorting berdasarkan poin_member (Jalur $sort === 'poin_member' ASC)
        $responseSortPoin = $this->get(route('admin-cabang.member', ['sort' => 'poin_member', 'direction' => 'asc']));
        $responseSortPoin->assertStatus(200);
        $membersSort = $responseSortPoin->viewData('members');
        $this->assertEquals(50, $membersSort->first()->poin_member); // Bob (50) di depan Alice (150)
    }

    /**
     * White-Box Test: Jalur Sukses (Happy Path) pada MemberController@store
     * Menguji penyimpanan member baru dengan data valid ke dalam database.
     */
    public function test_admin_cabang_can_store_member_with_valid_data()
    {
        $this->actingAs($this->adminUser);

        $response = $this->post(route('admin-cabang.member.store'), [
            'nama' => 'Joko Susilo',
            'email' => 'joko@gmail.com',
            'no_telepon' => '087712345678',
            'alamat' => 'Jl. Kebon Waru No. 12',
            'provinsi' => 'Jawa Barat',
            'kota_kabupaten' => 'Bandung',
            'kecamatan' => 'Batununggal',
            'poin_member' => 100,
            'password' => 'joko123',
            'status_member_plus' => '1'
        ]);

        // Harus dialihkan kembali ke daftar member dengan flash session success
        $response->assertRedirect(route('admin-cabang.member'));
        $response->assertSessionHas('success');

        // Pastikan record tersimpan di tabel pengguna
        $this->assertDatabaseHas('pengguna', [
            'nama' => 'Joko Susilo',
            'email' => 'joko@gmail.com',
            'role' => 'Pelanggan'
        ]);

        // Ambil data user yang baru dibuat untuk asersi tabel pelanggan
        $user = User::where('email', 'joko@gmail.com')->first();
        $this->assertNotNull($user);

        // Pastikan record tersimpan di tabel pelanggan dengan relasi yang benar
        $this->assertDatabaseHas('pelanggan', [
            'id_pengguna' => $user->id_pengguna,
            'status_member_plus' => 1,
            'poin_member' => 100,
            'alamat' => 'Jl. Kebon Waru No. 12'
        ]);
    }

    /**
     * White-Box Test: Jalur Kegagalan Validasi (Failure/Validation Path) pada MemberController@store
     * Menguji batasan validator (email duplikat dan password minimal 6 karakter).
     */
    public function test_admin_cabang_cannot_store_member_with_invalid_data()
    {
        $this->actingAs($this->adminUser);

        // Daftarkan satu user terlebih dahulu untuk menguji email unik
        User::create([
            'nama' => 'User Eksisting',
            'email' => 'eksisting@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'Pelanggan',
            'no_telepon' => '081234567890'
        ]);

        // Percabangan A: Email Duplikat
        $responseDuplicateEmail = $this->post(route('admin-cabang.member.store'), [
            'nama' => 'Joko Baru',
            'email' => 'eksisting@gmail.com', // email sudah ada
            'no_telepon' => '087712345678',
            'alamat' => 'Jl. Kebon Waru No. 12',
            'provinsi' => 'Jawa Barat',
            'kota_kabupaten' => 'Bandung',
            'kecamatan' => 'Batununggal',
            'password' => 'joko123',
        ]);

        $responseDuplicateEmail->assertSessionHasErrors('email');
        $this->assertDatabaseMissing('pengguna', [
            'nama' => 'Joko Baru'
        ]);

        // Percabangan B: Password terlalu pendek (< 6 karakter)
        $responseShortPassword = $this->post(route('admin-cabang.member.store'), [
            'nama' => 'Joko Pendek',
            'email' => 'jokopendek@gmail.com',
            'no_telepon' => '087712345678',
            'alamat' => 'Jl. Kebon Waru No. 12',
            'provinsi' => 'Jawa Barat',
            'kota_kabupaten' => 'Bandung',
            'kecamatan' => 'Batununggal',
            'password' => '12345', // < 6 karakter
        ]);

        $responseShortPassword->assertSessionHasErrors('password');
        $this->assertDatabaseMissing('pengguna', [
            'nama' => 'Joko Pendek'
        ]);
    }

    /**
     * White-Box Test: Detail Member (MemberController@show)
     * Menguji pencarian dan tampilan detail member cabang dengan model binding atau findOrFail.
     */
    public function test_admin_cabang_can_view_member_detail()
    {
        $this->actingAs($this->adminUser);

        $user = User::create([
            'nama' => 'Joni S',
            'email' => 'joni@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'Pelanggan',
            'no_telepon' => '087712345678'
        ]);
        $pelanggan = Pelanggan::create([
            'id_pengguna' => $user->id_pengguna,
            'provinsi' => 'Jawa Barat',
            'kota_kabupaten' => 'Bandung',
            'kecamatan' => 'Batununggal',
            'alamat' => 'Jl. Kebon Waru No. 12',
            'status_member_plus' => 0,
            'poin_member' => 0
        ]);

        // Jalur Sukses: Cari ID yang ada
        $responseSuccess = $this->get(route('admin-cabang.member.detail', $pelanggan->id_pelanggan));
        $responseSuccess->assertStatus(200);
        $responseSuccess->assertViewHas('member');

        // Jalur Gagal: Cari ID fiktif -> Harus memicu findOrFail (HTTP 404)
        $responseNotFound = $this->get(route('admin-cabang.member.detail', 99999));
        $responseNotFound->assertStatus(404);
    }
}
