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
                ->with(['details.produk'])
                ->withCount('details')
                ->orderBy('tanggal_pemesanan', 'desc')
                ->take(5)
                ->get();
        }

        return view('pelanggan.profil', compact('user', 'pelanggan', 'memberId', 'pesanans'));
    }
}
