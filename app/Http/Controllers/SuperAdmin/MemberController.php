<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function member()
    {
        $members = \App\Models\Pelanggan::with(['user', 'riwayatPesanan.details.produk'])->get();
        return view('super-admin.member', compact('members'));
    }

    public function detailMember($id)
    {
        $member = \App\Models\Pelanggan::with(['user', 'riwayatPesanan' => function($query) {
            $query->orderBy('tanggal_pemesanan', 'desc');
        }, 'riwayatPesanan.details.produk', 'riwayatPesanan.cabang'])->findOrFail($id);
        
        return view('super-admin.member-detail', compact('member'));
    }

    public function updateMember(Request $request, $id)
    {
        $member = \App\Models\Pelanggan::findOrFail($id);
        $user = $member->user;

        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id_user.',id_user',
            'password' => [
                'nullable',
                'string',
                'min:8',
                'regex:/[a-zA-Z]/',
                'regex:/[0-9@$!%*#?&_\-]/',
            ],
            'no_telepon' => 'required|string|max:15',
            'status_member' => 'required|boolean',
            'poin_member' => 'required|integer|min:0',
            'provinsi' => 'nullable|string|max:100',
            'kota_kabupaten' => 'nullable|string|max:100',
            'kecamatan' => 'nullable|string|max:100',
            'alamat' => 'nullable|string',
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
            'provinsi' => $request->provinsi,
            'kota_kabupaten' => $request->kota_kabupaten,
            'kecamatan' => $request->kecamatan,
            'alamat' => $request->alamat,
        ]);

        return redirect()->route('superadmin.member.detail', $member->id_pelanggan)->with('success', 'Data member berhasil diperbarui.');
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
