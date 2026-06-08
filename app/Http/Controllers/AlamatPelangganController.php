<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AlamatPelanggan;

class AlamatPelangganController extends Controller
{
    /**
     * Get all additional addresses for the authenticated user.
     */
    public function index()
    {
        $user = Auth::user();
        if (!$user || !$user->pelanggan) {
            return response()->json(['data' => []], 200);
        }

        $addresses = AlamatPelanggan::where('id_pelanggan', $user->pelanggan->id_pelanggan)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json(['data' => $addresses], 200);
    }

    /**
     * Store a new additional address.
     */
    public function store(Request $request)
    {
        $request->validate([
            'label' => 'nullable|string|max:100',
            'provinsi' => 'required|string|max:255',
            'kota_kabupaten' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'alamat' => 'required|string',
        ]);

        $user = Auth::user();
        if (!$user || !$user->pelanggan) {
            return response()->json(['message' => 'Profil pelanggan tidak ditemukan.'], 400);
        }

        $pelangganId = $user->pelanggan->id_pelanggan;

        $alamat = AlamatPelanggan::create([
            'id_pelanggan' => $pelangganId,
            'label' => $request->input('label', 'Alamat Tambahan'),
            'provinsi' => $request->input('provinsi'),
            'kota_kabupaten' => $request->input('kota_kabupaten'),
            'kecamatan' => $request->input('kecamatan'),
            'alamat' => $request->input('alamat'),
            'is_default' => false,
        ]);

        return response()->json([
            'message' => 'Alamat berhasil disimpan.',
            'data' => $alamat,
        ], 201);
    }

    /**
     * Update an existing additional address.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'label' => 'nullable|string|max:100',
            'provinsi' => 'required|string|max:255',
            'kota_kabupaten' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'alamat' => 'required|string',
        ]);

        $user = Auth::user();
        if (!$user || !$user->pelanggan) {
            return response()->json(['message' => 'Profil pelanggan tidak ditemukan.'], 400);
        }

        $alamat = AlamatPelanggan::where('id_alamat', $id)
            ->where('id_pelanggan', $user->pelanggan->id_pelanggan)
            ->first();

        if (!$alamat) {
            return response()->json(['message' => 'Alamat tidak ditemukan.'], 404);
        }

        $alamat->update([
            'label' => $request->input('label', $alamat->label),
            'provinsi' => $request->input('provinsi'),
            'kota_kabupaten' => $request->input('kota_kabupaten'),
            'kecamatan' => $request->input('kecamatan'),
            'alamat' => $request->input('alamat'),
        ]);

        return response()->json([
            'message' => 'Alamat berhasil diperbarui.',
            'data' => $alamat,
        ], 200);
    }

    /**
     * Delete an additional address.
     */
    public function destroy($id)
    {
        $user = Auth::user();
        if (!$user || !$user->pelanggan) {
            return response()->json(['message' => 'Profil pelanggan tidak ditemukan.'], 400);
        }

        $alamat = AlamatPelanggan::where('id_alamat', $id)
            ->where('id_pelanggan', $user->pelanggan->id_pelanggan)
            ->first();

        if (!$alamat) {
            return response()->json(['message' => 'Alamat tidak ditemukan.'], 404);
        }

        $alamat->delete();

        return response()->json(['message' => 'Alamat berhasil dihapus.'], 200);
    }
}
