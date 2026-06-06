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
        $user = Auth::user();
        $pelanggan = $user->pelanggan;

        if (!$pelanggan) {
            // If user somehow doesn't have a pelanggan record, create a dummy one for UI purposes
            // Or redirect back with error. Let's create an empty one for the view.
            $pelanggan = new Pelanggan();
            $pelanggan->status_member = 'REGULER';
            $pelanggan->id_pelanggan = 'BRM-' . rand(1000, 9999) . '-' . rand(1000, 9999);
        }

        // Generate unique 12-digit member ID: XXXX XXXX XXXX
        $rawId = str_pad($user->id_pengguna * 7919 + 100000000000, 12, '0', STR_PAD_LEFT);
        $memberId = substr($rawId, 0, 4) . ' ' . substr($rawId, 4, 4) . ' ' . substr($rawId, 8, 4);

        // Fetch recent orders (up to 5)
        $pesanans = [];
        if ($pelanggan->id_pelanggan) {
            $pesanans = Pesanan::query()->where('id_pelanggan', $pelanggan->id_pelanggan)
                ->with(['details.produk', 'cabang'])
                ->withCount('details')
                ->orderBy('tanggal_pemesanan', 'desc')
                ->take(5)
                ->get();
        }

        return view('pelanggan.profil', compact('user', 'pelanggan', 'memberId', 'pesanans'));
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
            
            foreach ($pesanan->details as $detail) {
                \App\Models\ProdukCabang::where('id_produk', $detail->id_produk)
                    ->where('id_cabang', $pesanan->id_cabang)
                    ->increment('jumlah_terjual', $detail->jumlah);
            }
            
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
}
