<?php

namespace App\Http\Controllers\AdminCabang;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Pelanggan;
use App\Models\User;

class MemberController extends Controller
{
    /**
     * READ — Tampilkan daftar pelanggan dengan filter, sorting, dan paginasi.
     */
    public function index(Request $request)
    {
        $search    = $request->query('search');
        $status    = $request->query('status');   // 'member' | 'member-plus'
        $sort      = $request->query('sort', 'created_at');
        $direction = $request->query('direction', 'desc');

        $query = Pelanggan::query()->with('user');

        // Filter nama, email, no_telepon, alamat, atau lokasi
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($sub) use ($search) {
                    $sub->where('nama', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%')
                        ->orWhere('no_telepon', 'like', '%' . $search . '%');
                })
                ->orWhere('alamat', 'like', '%' . $search . '%')
                ->orWhere('kecamatan', 'like', '%' . $search . '%')
                ->orWhere('kota_kabupaten', 'like', '%' . $search . '%')
                ->orWhere('provinsi', 'like', '%' . $search . '%');
            });
        }

        // Filter status member
        if ($status === 'member-plus') {
            $query->where('status_member_plus', true);
        } elseif ($status === 'member') {
            $query->where('status_member_plus', false);
        }

        // Sorting
        $allowedDirectLocalSort = ['poin_member', 'created_at', 'status_member_plus'];
        if (in_array($sort, $allowedDirectLocalSort)) {
            $query->orderBy($sort, $direction);
        } elseif ($sort === 'nama') {
            $query->join('pengguna', 'pelanggan.id_pengguna', '=', 'pengguna.id_pengguna')
                  ->orderBy('pengguna.nama', $direction)
                  ->select('pelanggan.*');
        } elseif ($sort === 'email') {
            $query->join('pengguna', 'pelanggan.id_pengguna', '=', 'pengguna.id_pengguna')
                  ->orderBy('pengguna.email', $direction)
                  ->select('pelanggan.*');
        }

        // KPI summary — dihitung sebelum paginasi
        $totalMemberPlus = (clone $query)->where('status_member_plus', true)->count();
        $totalMember     = (clone $query)->where('status_member_plus', false)->count();
        $totalPoin       = (clone $query)->sum('poin_member');

        $members = $query->paginate(7)->withQueryString();

        return view('admin-cabang.manajemen-member', compact(
            'members', 'totalMemberPlus', 'totalMember', 'totalPoin'
        ));
    }

    /**
     * CREATE — Simpan pelanggan baru (user + pelanggan).
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama'           => 'required|string|max:255',
            'email'          => 'required|email|unique:pengguna,email',
            'no_telepon'     => 'required|string|max:20',
            'alamat'         => 'required|string',
            'kecamatan'      => 'required|string|max:255',
            'kota_kabupaten' => 'required|string|max:255',
            'provinsi'       => 'required|string|max:255',
            'poin_member'    => 'nullable|integer|min:0',
            'password'       => 'required|string|min:6',
        ], [
            'email.unique'   => 'Email sudah terdaftar.',
            'password.min'   => 'Password minimal 6 karakter.',
        ]);

        $user = User::create([
            'nama'       => $request->nama,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'no_telepon' => $request->no_telepon,
            'role'       => 'Pelanggan',
        ]);

        Pelanggan::create([
            'id_pengguna'        => $user->id_pengguna,
            'status_member_plus' => $request->boolean('status_member_plus'),
            'poin_member'        => $request->poin_member ?? 0,
            'alamat'             => $request->alamat,
            'kecamatan'          => $request->kecamatan,
            'kota_kabupaten'     => $request->kota_kabupaten,
            'provinsi'           => $request->provinsi,
        ]);

        return redirect()->route('admin-cabang.member')
            ->with('success', 'Member ' . $user->nama . ' berhasil ditambahkan.');
    }

    /**
     * DETAIL — Tampilkan detail pelanggan beserta riwayat pesanan.
     */
    public function show($id)
    {
        $member = Pelanggan::with(['user', 'riwayatPesanan' => function($query) {
            $query->orderBy('tanggal_pemesanan', 'desc');
        }, 'riwayatPesanan.details.produk', 'riwayatPesanan.cabang'])->findOrFail($id);
        
        return view('admin-cabang.member-detail', compact('member'));
    }
}
