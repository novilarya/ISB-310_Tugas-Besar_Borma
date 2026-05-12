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
        $status    = $request->query('status');   // 'member' | 'non-member'
        $sort      = $request->query('sort', 'created_at');
        $direction = $request->query('direction', 'desc');

        $query = Pelanggan::query()->with('user');

        // Filter nama atau email
        if ($search) {
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%')
                  ->orWhere('no_telepon', 'like', '%' . $search . '%');
            });
        }

        // Filter status member
        if ($status === 'member') {
            $query->where('status_member', true);
        } elseif ($status === 'non-member') {
            $query->where('status_member', false);
        }

        // Sorting
        $allowedDirectLocalSort = ['poin_member', 'created_at', 'status_member'];
        if (in_array($sort, $allowedDirectLocalSort)) {
            $query->orderBy($sort, $direction);
        } elseif ($sort === 'nama') {
            $query->join('users', 'pelanggans.id_user', '=', 'users.id_user')
                  ->orderBy('users.nama', $direction)
                  ->select('pelanggans.*');
        } elseif ($sort === 'email') {
            $query->join('users', 'pelanggans.id_user', '=', 'users.id_user')
                  ->orderBy('users.email', $direction)
                  ->select('pelanggans.*');
        }

        // KPI summary — dihitung sebelum paginasi
        $totalMember    = (clone $query)->where('status_member', true)->count();
        $totalNonMember = (clone $query)->where('status_member', false)->count();
        $totalPoin      = (clone $query)->sum('poin_member');

        $members = $query->paginate(7)->withQueryString();

        return view('admin-cabang.manajemen-member', compact(
            'members', 'totalMember', 'totalNonMember', 'totalPoin'
        ));
    }

    /**
     * CREATE — Simpan pelanggan baru (user + pelanggan).
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama'        => 'required|string|max:255',
            'email'       => 'required|email|unique:users,email',
            'no_telepon'  => 'required|string|max:20',
            'alamat'      => 'required|string',
            'poin_member' => 'nullable|integer|min:0',
            'password'    => 'required|string|min:6',
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
            'id_user'       => $user->id_user,
            'status_member' => $request->boolean('status_member'),
            'poin_member'   => $request->poin_member ?? 0,
            'alamat'        => $request->alamat,
        ]);

        return redirect()->route('admin-cabang.member')
            ->with('success', 'Member ' . $user->nama . ' berhasil ditambahkan.');
    }
}
