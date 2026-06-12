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
            // If user somehow doesn't have a pelanggan record, create a dummy one for UI purposes
            // Or redirect back with error. Let's create an empty one for the view.
            $pelanggan = new Pelanggan();
            $pelanggan->status_member_plus = false;
            $pelanggan->id_pelanggan = 'BRM-' . rand(1000, 9999) . '-' . rand(1000, 9999);
        }

        // Generate unique 12-digit member ID: XXXX XXXX XXXX
        $rawId = str_pad($user->id_pengguna * 7919 + 100000000000, 12, '0', STR_PAD_LEFT);
        $memberId = substr($rawId, 0, 4) . ' ' . substr($rawId, 4, 4) . ' ' . substr($rawId, 8, 4);

        // Fetch last 3 orders
        $pesanans = [];
        if ($pelanggan->id_pelanggan) {
            $pesanans = Pesanan::query()->where('id_pelanggan', $pelanggan->id_pelanggan)
                ->where('metode_pembayaran', '!=', 'Aktivasi Member Plus')
                ->where('alamat_pengiriman', 'not like', '%Aktivasi Borma Plus%')
                ->with(['details.produk', 'cabang'])
                ->withCount('details')
                ->orderBy('tanggal_pemesanan', 'desc')
                ->limit(3)
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
            ->where('metode_pembayaran', '!=', 'Aktivasi Member Plus')
            ->where('alamat_pengiriman', 'not like', '%Aktivasi Borma Plus%')
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

    public function getTrackingData($id)
    {
        try {
            $user = Auth::user();
            $pelanggan = $user->pelanggan;
            
            if (!$pelanggan) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data pelanggan tidak ditemukan.'
                ], 403);
            }

            $pesanan = Pesanan::with(['cabang', 'kurir.user'])
                ->where('id_pelanggan', $pelanggan->id_pelanggan)
                ->findOrFail($id);

            $cabangLat = -6.9147;
            $cabangLng = 107.6542;
            if ($pesanan->cabang && $pesanan->cabang->koordinat_gps) {
                $coords = explode(',', $pesanan->cabang->koordinat_gps);
                if (count($coords) === 2) {
                    $cabangLat = floatval(trim($coords[0]));
                    $cabangLng = floatval(trim($coords[1]));
                }
            }

            $custLat = floatval($pesanan->latitude ?? -6.9215);
            $custLng = floatval($pesanan->longitude ?? 107.6310);

            $driverLat = null;
            $driverLng = null;
            $driverInfo = null;

            if ($pesanan->kurir) {
                $driverLat = $pesanan->kurir->driver_lat ? floatval($pesanan->kurir->driver_lat) : null;
                $driverLng = $pesanan->kurir->driver_lng ? floatval($pesanan->kurir->driver_lng) : null;
                
                $driverInfo = [
                    'nama' => $pesanan->kurir->user->nama ?? 'Kurir Borma',
                    'no_telepon' => $pesanan->kurir->user->no_telepon ?? '-',
                    'kendaraan' => $pesanan->kurir->kendaraan ?? 'Motor',
                    'warna_kendaraan' => $pesanan->kurir->warna_kendaraan ?? '',
                    'plat_nomor' => $pesanan->kurir->plat_nomor ?? '',
                ];
            }

            // Calculate distances
            $distanceDriverToCust = null;
            $estimatedTime = null;

            if ($driverLat !== null && $driverLng !== null) {
                $distanceDriverToCust = $this->calculateDistance($driverLat, $driverLng, $custLat, $custLng);
                // Assume average speed is 20-30 km/h in Bandung traffic, meaning 2.5 mins per km
                $estimatedTime = max(1, round($distanceDriverToCust * 2.5)); 
            } else {
                // If driver location is not active yet, show distance from Gudang/Cabang to Customer
                $distanceDriverToCust = $this->calculateDistance($cabangLat, $cabangLng, $custLat, $custLng);
                $estimatedTime = max(1, round($distanceDriverToCust * 2.5));
            }

            return response()->json([
                'success' => true,
                'status_pesanan' => $pesanan->status_pesanan,
                'cabang' => [
                    'nama' => $pesanan->cabang->nama_cabang ?? 'Gudang Borma',
                    'lat' => $cabangLat,
                    'lng' => $cabangLng
                ],
                'pelanggan' => [
                    'nama' => $user->nama,
                    'alamat' => $pesanan->alamat_pengiriman,
                    'lat' => $custLat,
                    'lng' => $custLng
                ],
                'kurir' => [
                    'lat' => $driverLat,
                    'lng' => $driverLng,
                    'info' => $driverInfo
                ],
                'distance' => $distanceDriverToCust, // in km
                'estimated_time' => $estimatedTime // in minutes
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data tracking: ' . $e->getMessage()
            ], 500);
        }
    }

    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371; // km
        $latDelta = deg2rad($lat2 - $lat1);
        $lonDelta = deg2rad($lon2 - $lon1);
        
        $a = sin($latDelta / 2) * sin($latDelta / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($lonDelta / 2) * sin($lonDelta / 2);
        
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $distance = $earthRadius * $c;
        
        return round($distance, 2); // km
    }
}
