<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

// use App\Models\Pesanan;
use App\Models\Cabang;
use App\Models\Produk;
use App\Models\ProdukCabang;
// use App\Models\User;
// use App\Models\PesananProduk;
// use Illuminate\Support\Facades\DB;

class SuperAdminController extends Controller
{
    public function index()
    {

        $totalPesanan = 1284;
        $pengirimanAktif = 42;
        $totalCabang = Cabang::count();
        $promoAktif = 5;
        $penggunaanVoucher = 320;

        $overviewCabang = Cabang::all()->map(function($c) {
            return (object) [
                'nama_cabang' => $c->nama_cabang,
                // Menggunakan random karena data pesanan belum ada
                'pesanan_sum_total_tagihan' => rand(50000000, 150000000) 
            ];
        })->sortByDesc('pesanan_sum_total_tagihan')->take(5);

        $produkPopuler = Produk::take(5)->get()->map(function($p) {
            return (object) [
                'produk' => $p,
                // Menggunakan random karena data pesanan belum ada
                'total_terjual' => rand(100, 500) 
            ];
        });

        $pesananTerbaru = collect([
            (object) ['id' => 'ORD-1092', 'pelanggan' => 'Budi Santoso', 'total' => 150000, 'status' => 'Selesai'],
            (object) ['id' => 'ORD-1093', 'pelanggan' => 'Siti Aminah', 'total' => 320000, 'status' => 'Dikirim'],
            (object) ['id' => 'ORD-1094', 'pelanggan' => 'Ahmad Reza', 'total' => 85000, 'status' => 'Dikemas'],
            (object) ['id' => 'ORD-1095', 'pelanggan' => 'Nisa Farida', 'total' => 450000, 'status' => 'Menunggu'],
            (object) ['id' => 'ORD-1096', 'pelanggan' => 'Dewi Lestari', 'total' => 120000, 'status' => 'Selesai'],
        ]);

        return view('super-admin.dashboard', compact(
            'totalPesanan', 
            'pengirimanAktif', 
            'totalCabang', 
            'promoAktif', 
            'penggunaanVoucher',
            'overviewCabang', 
            'produkPopuler',
            'pesananTerbaru'
        ));
    }

    public function pesanan()
    {
        // TODO: Ganti dengan query database saat tabel sudah siap
        // $pesanan = Pesanan::with(['pelanggan', 'cabang'])->orderBy('created_at', 'desc')->get();
        
        $pesanan = collect([
            (object) ['id' => 'ORD-1092', 'tanggal' => '2026-05-08 10:30', 'pelanggan' => 'Budi Santoso', 'cabang' => 'Borma Dakota', 'total' => 150000, 'status' => 'Selesai'],
            (object) ['id' => 'ORD-1093', 'tanggal' => '2026-05-08 11:15', 'pelanggan' => 'Siti Aminah', 'cabang' => 'Borma Antapani', 'total' => 320000, 'status' => 'Dikirim'],
            (object) ['id' => 'ORD-1094', 'tanggal' => '2026-05-08 12:00', 'pelanggan' => 'Ahmad Reza', 'cabang' => 'Borma Dago', 'total' => 85000, 'status' => 'Dikemas'],
            (object) ['id' => 'ORD-1095', 'tanggal' => '2026-05-07 15:45', 'pelanggan' => 'Nisa Farida', 'cabang' => 'Borma Dakota', 'total' => 450000, 'status' => 'Menunggu'],
            (object) ['id' => 'ORD-1096', 'tanggal' => '2026-05-07 16:30', 'pelanggan' => 'Dewi Lestari', 'cabang' => 'Borma Cikutra', 'total' => 120000, 'status' => 'Selesai'],
            (object) ['id' => 'ORD-1097', 'tanggal' => '2026-05-06 09:20', 'pelanggan' => 'Rizky Pratama', 'cabang' => 'Borma Dago', 'total' => 55000, 'status' => 'Selesai'],
            (object) ['id' => 'ORD-1098', 'tanggal' => '2026-05-06 14:10', 'pelanggan' => 'Maya Sari', 'cabang' => 'Borma Antapani', 'total' => 210000, 'status' => 'Selesai'],
        ]);

        return view('super-admin.pesanan', compact('pesanan'));
    }

    public function pengemudi()
    {
        // TODO: Ganti dengan query database saat tabel sudah siap
        // $pengemudi = User::where('role', 'driver')->with('cabang')->get();
        // $riwayatPengiriman = Pengiriman::where('driver_id', $driver_id)->get();
        
        $pengemudi = collect([
            (object) ['id' => 1, 'nama' => 'Joko Widodo', 'cabang' => 'Borma Dakota', 'pengiriman_hari_ini' => 5, 'total_jarak' => 12.5],
            (object) ['id' => 2, 'nama' => 'Agus Yudhoyono', 'cabang' => 'Borma Antapani', 'pengiriman_hari_ini' => 3, 'total_jarak' => 8.2],
            (object) ['id' => 3, 'nama' => 'Megawati', 'cabang' => 'Borma Dago', 'pengiriman_hari_ini' => 7, 'total_jarak' => 18.0],
            (object) ['id' => 4, 'nama' => 'Prabowo Subianto', 'cabang' => 'Borma Dakota', 'pengiriman_hari_ini' => 0, 'total_jarak' => 0],
            (object) ['id' => 5, 'nama' => 'Ganjar Pranowo', 'cabang' => 'Borma Cikutra', 'pengiriman_hari_ini' => 4, 'total_jarak' => 9.5],
        ]);

        // Mock detail riwayat pengiriman untuk demonstrasi (bisa digenerate secara acak di view atau dikirim dari controller)
        $riwayatPengiriman = [
            1 => collect([
                (object) ['pesanan_id' => 'ORD-1092', 'jarak' => 2.1, 'status' => 'Selesai', 'waktu' => '10:30'],
                (object) ['pesanan_id' => 'ORD-1080', 'jarak' => 3.5, 'status' => 'Selesai', 'waktu' => '09:15'],
                (object) ['pesanan_id' => 'ORD-1075', 'jarak' => 5.6, 'status' => 'Selesai', 'waktu' => '08:00'],
            ]),
        ];

        return view('super-admin.pengemudi', compact('pengemudi', 'riwayatPengiriman'));
    }

    public function cabang(\Illuminate\Http\Request $request)
    {
        $cabangs = Cabang::all();
        $cabang = $cabangs->map(function($c) {
            return (object) [
                'id' => $c->id_cabang,
                'nama_cabang' => $c->nama_cabang,
                'alamat_cabang' => $c->alamat_cabang,
                'koordinat_gps' => $c->koordinat_gps,
                'pendapatan' => rand(50000000, 200000000), // mock
                'total_pesanan' => rand(500, 2000), // mock
                'status' => $c->status ?? 'Aktif',
                'produk_terlaris' => Produk::inRandomOrder()->first()->nama_produk ?? '-'
            ];
        });

        $sort = $request->input('sort', 'nama_asc');
        switch ($sort) {
            case 'nama_asc':
                $cabang = $cabang->sortBy('nama_cabang');
                break;
            case 'nama_desc':
                $cabang = $cabang->sortByDesc('nama_cabang');
                break;
            case 'pendapatan_asc':
                $cabang = $cabang->sortBy('pendapatan');
                break;
            case 'pendapatan_desc':
                $cabang = $cabang->sortByDesc('pendapatan');
                break;
            case 'pesanan_asc':
                $cabang = $cabang->sortBy('total_pesanan');
                break;
            case 'pesanan_desc':
                $cabang = $cabang->sortByDesc('total_pesanan');
                break;
            case 'status_asc':
                $cabang = $cabang->sortBy('status');
                break;
            case 'status_desc':
                $cabang = $cabang->sortByDesc('status');
                break;
        }

        return view('super-admin.cabang', compact('cabang'));
    }

    public function storeCabang(Request $request)
    {
        $request->validate([
            'nama_cabang' => 'required|string|max:255',
            'alamat_cabang' => 'required|string',
            'koordinat_gps' => 'required|string|max:255',
            'status' => 'required|string|in:Aktif,Tidak Aktif',
        ]);

        Cabang::create([
            'nama_cabang' => $request->nama_cabang,
            'alamat_cabang' => $request->alamat_cabang,
            'koordinat_gps' => $request->koordinat_gps,
            'status' => $request->status,
        ]);

        return redirect()->route('superadmin.cabang')->with('success', 'Cabang berhasil ditambahkan.');
    }

    public function updateCabang(Request $request, $id)
    {
        $request->validate([
            'nama_cabang' => 'required|string|max:255',
            'alamat_cabang' => 'required|string',
            'koordinat_gps' => 'required|string|max:255',
            'status' => 'required|string|in:Aktif,Tidak Aktif',
        ]);

        $cabang = Cabang::findOrFail($id);
        $cabang->update([
            'nama_cabang' => $request->nama_cabang,
            'alamat_cabang' => $request->alamat_cabang,
            'koordinat_gps' => $request->koordinat_gps,
            'status' => $request->status,
        ]);

        return redirect()->route('superadmin.cabang')->with('success', 'Cabang berhasil diperbarui.');
    }

    public function adminCabang()
    {
        $adminCabangs = \App\Models\User::where('role', 'Admin Cabang')->get();
        return view('super-admin.admin-cabang', compact('adminCabangs'));
    }

    public function storeAdminCabang(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'no_telepon' => 'required|string|max:15',
        ]);

        \App\Models\User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'no_telepon' => $request->no_telepon,
            'role' => 'Admin Cabang',
        ]);

        return redirect()->route('superadmin.admin_cabang')->with('success', 'Admin Cabang berhasil ditambahkan.');
    }

    public function updateAdminCabang(Request $request, $id)
    {
        $user = \App\Models\User::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id_user.',id_user',
            'no_telepon' => 'required|string|max:15',
        ]);

        $user->update([
            'nama' => $request->nama,
            'email' => $request->email,
            'no_telepon' => $request->no_telepon,
        ]);

        if ($request->filled('password')) {
            $user->update(['password' => bcrypt($request->password)]);
        }

        return redirect()->route('superadmin.admin_cabang')->with('success', 'Admin Cabang berhasil diperbarui.');
    }

    public function destroyAdminCabang($id)
    {
        $user = \App\Models\User::findOrFail($id);
        $user->delete();

        return redirect()->route('superadmin.admin_cabang')->with('success', 'Admin Cabang berhasil dihapus.');
    }

    public function member()
    {
        $members = \App\Models\Pelanggan::with(['user', 'riwayatPesanan.details.produk'])->get();
        return view('super-admin.member', compact('members'));
    }

    public function updateMember(Request $request, $id)
    {
        $member = \App\Models\Pelanggan::findOrFail($id);
        $user = $member->user;

        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id_user.',id_user',
            'no_telepon' => 'required|string|max:15',
            'status_member' => 'required|boolean',
            'poin_member' => 'required|integer|min:0',
            'alamat' => 'required|string',
        ]);

        $user->update([
            'nama' => $request->nama,
            'email' => $request->email,
            'no_telepon' => $request->no_telepon,
        ]);

        if ($request->filled('password')) {
            $user->update(['password' => bcrypt($request->password)]);
        }

        $member->update([
            'status_member' => $request->status_member,
            'poin_member' => $request->poin_member,
            'alamat' => $request->alamat,
        ]);

        return redirect()->route('superadmin.member')->with('success', 'Member berhasil diperbarui.');
    }

    public function destroyMember($id)
    {
        $member = \App\Models\Pelanggan::findOrFail($id);
        $user = $member->user;
        
        $member->delete();
        $user->delete();

        return redirect()->route('superadmin.member')->with('success', 'Member berhasil dihapus.');
    }
}
