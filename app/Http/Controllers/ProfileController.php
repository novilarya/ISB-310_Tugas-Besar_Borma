<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pesanan;
use App\Models\Pelanggan;

class ProfileController extends Controller
{
    public function index()
    {
        // Lazy auto-complete orders that have been 'diterima' for more than 24 hours
        $expiredOrders = Pesanan::where('status_pesanan', 'diterima')
            ->where('updated_at', '<=', now()->subHours(24))
            ->get();
        foreach ($expiredOrders as $ep) {
            $ep->update(['status_pesanan' => 'selesai']);
            \App\Models\PengirimanTracking::create([
                'id_pesanan' => $ep->id_pesanan,
                'status' => 'selesai',
                'keterangan' => 'Pesanan otomatis diselesaikan oleh sistem setelah 24 jam'
            ]);
        }

        $user = Auth::user();
        $pelanggan = $user->pelanggan;

        if (!$pelanggan) {
            $pelanggan = new Pelanggan();
            $pelanggan->status_member_plus = false;
            $pelanggan->id_pelanggan = 0;
        }

        // Fetch recent orders (up to 3)
        $pesanans = [];
        if ($pelanggan->id_pelanggan) {
            $pesanans = Pesanan::query()->where('id_pelanggan', $pelanggan->id_pelanggan)
                ->with(['details.produk', 'cabang'])
                ->withCount('details')
                ->orderBy('tanggal_pemesanan', 'desc')
                ->limit(3)
                ->get();
        }

        return view('pelanggan.profil', compact('user', 'pelanggan', 'pesanans'));
    }

    public function confirmReceived($id)
    {
        try {
            $pesanan = Pesanan::with('details')->findOrFail($id);
            
            if ($pesanan->status_pesanan !== 'diterima') {
                return response()->json([
                    'success' => false,
                    'message' => 'Pesanan harus dalam status Diterima (oleh Kurir) untuk dikonfirmasi.'
                ], 400);
            }
            
            $pesanan->status_pesanan = 'selesai';
            $pesanan->save();
            
            \App\Models\PengirimanTracking::create([
                'id_pesanan' => $id,
                'status' => 'selesai',
                'keterangan' => 'Pesanan telah diterima dan dikonfirmasi selesai oleh pelanggan'
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Pesanan berhasil dikonfirmasi selesai.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function edit()
    {
        $user = Auth::user();
        $pelanggan = $user->pelanggan;

        if (!$pelanggan) {
            $pelanggan = new Pelanggan();
            $pelanggan->provinsi = '-';
            $pelanggan->kota_kabupaten = '-';
            $pelanggan->kecamatan = '-';
            $pelanggan->alamat = '-';
        }

        return view('pelanggan.profil-edit', compact('user', 'pelanggan'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        
        $rules = [
            'nama' => 'required|string|max:255',
            'no_telepon' => ['required', 'regex:/^[0-9]{10,15}$/'],
            'provinsi' => 'required|string|max:255',
            'kota_kabupaten' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'alamat' => 'required|string',
        ];

        $messages = [
            'nama.required' => 'Nama lengkap wajib diisi.',
            'no_telepon.required' => 'Nomor telepon wajib diisi.',
            'no_telepon.regex' => 'Nomor telepon hanya boleh berisi angka (10-15 digit).',
            'provinsi.required' => 'Provinsi wajib diisi.',
            'kota_kabupaten.required' => 'Kota/Kabupaten wajib diisi.',
            'kecamatan.required' => 'Kecamatan wajib diisi.',
            'alamat.required' => 'Detail alamat wajib diisi.',
        ];

        if ($request->filled('password')) {
            $rules['password'] = 'required|string|min:8|confirmed';
            $messages['password.min'] = 'Password baru minimal harus 8 karakter.';
            $messages['password.confirmed'] = 'Konfirmasi password baru tidak cocok.';
        }

        $request->validate($rules, $messages);

        $userData = [
            'nama' => $request->nama,
            'no_telepon' => $request->no_telepon,
        ];

        if ($request->filled('password')) {
            $userData['password'] = bcrypt($request->password);
        }

        $user->update($userData);

        $pelanggan = $user->pelanggan;
        if ($pelanggan) {
            $pelanggan->update([
                'provinsi' => $request->provinsi,
                'kota_kabupaten' => $request->kota_kabupaten,
                'kecamatan' => $request->kecamatan,
                'alamat' => $request->alamat,
            ]);
        } else {
            Pelanggan::create([
                'id_pengguna' => $user->id_pengguna,
                'status_member_plus' => false,
                'poin_member' => 0,
                'provinsi' => $request->provinsi,
                'kota_kabupaten' => $request->kota_kabupaten,
                'kecamatan' => $request->kecamatan,
                'alamat' => $request->alamat,
            ]);
        }

        return redirect()->route('pelanggan.profil')->with('success', 'Profil berhasil diperbarui.');
    }

    public function pesananList(Request $request)
    {
        $user = Auth::user();
        $pelanggan = $user->pelanggan;
        
        if (!$pelanggan) {
            return redirect()->route('pelanggan.dashboard')->with('error', 'Data pelanggan tidak ditemukan.');
        }

        $activeTab = strtolower($request->query('status', 'all'));

        $query = Pesanan::query()
            ->where('id_pelanggan', $pelanggan->id_pelanggan)
            ->with(['details.produk', 'cabang'])
            ->orderBy('tanggal_pemesanan', 'desc');

        if ($activeTab === 'menunggu') {
            $query->where('status_pesanan', 'Menunggu');
        } elseif ($activeTab === 'disiapkan') {
            $query->where('status_pesanan', 'Disiapkan');
        } elseif ($activeTab === 'dalam_pengiriman') {
            $query->whereIn('status_pesanan', ['mencari_driver', 'diterima_driver', 'diambil', 'dalam_pengiriman']);
        } elseif ($activeTab === 'diterima') {
            $query->where('status_pesanan', 'diterima');
        } elseif ($activeTab === 'selesai') {
            $query->where('status_pesanan', 'selesai');
        }

        $pesanans = $query->get();

        return view('pelanggan.pesanan-list', compact('user', 'pelanggan', 'pesanans', 'activeTab'));
    }
}
