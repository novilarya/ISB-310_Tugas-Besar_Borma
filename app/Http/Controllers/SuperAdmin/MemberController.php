<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MemberController extends Controller
{
    public function member()
    {
        $members = Pelanggan::with(['user', 'riwayatPesanan.details.produk'])->get();

        // Data density per kecamatan untuk density map
        $memberDensity = $this->buildDensityData();

        $persenBenefit = \App\Models\Pengaturan::where('kunci', 'member_plus_persentase')->value('nilai') ?? 0;
        $maksimalBenefit = \App\Models\Pengaturan::where('kunci', 'member_plus_maksimal')->value('nilai') ?? 0;

        return view('super-admin.member', compact('members', 'memberDensity', 'persenBenefit', 'maksimalBenefit'));
    }

    public function updateBenefit(Request $request)
    {
        $request->validate([
            'persentase' => 'required|numeric|min:0|max:100',
            'maksimal' => 'required|numeric|min:0'
        ]);

        $persentase = $request->persentase;
        $maksimal = $request->maksimal;

        \App\Models\Pengaturan::updateOrCreate(
            ['kunci' => 'member_plus_persentase'],
            ['nilai' => $persentase]
        );

        \App\Models\Pengaturan::updateOrCreate(
            ['kunci' => 'member_plus_maksimal'],
            ['nilai' => $maksimal]
        );

        // Update semua harga_member_plus di produk
        \App\Models\Produk::chunk(100, function($produk) use ($persentase, $maksimal) {
            foreach ($produk as $p) {
                $diskon = min(($p->harga_member * $persentase / 100), $maksimal);
                $p->harga_member_plus = max(0, $p->harga_member - $diskon);
                $p->save();
            }
        });

        return redirect()->route('superadmin.member')->with('success', 'Benefit Member Plus berhasil diperbarui dan diterapkan ke semua produk.');
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

        $request->validate([
            'status_member_plus' => 'required|boolean',
            'poin_member' => 'required|integer|min:0',
        ]);

        $member->update([
            'status_member_plus' => $request->status_member_plus,
            'poin_member' => $request->poin_member,
        ]);

        return redirect()->route('superadmin.member.detail', $member->id_pelanggan)->with('success', 'Data member berhasil diperbarui.');
    }

    public function destroyMember($id)
    {
        $member = Pelanggan::findOrFail($id);
        $user = $member->user;
        
        $member->delete();
        $user->delete();

        return redirect()->route('superadmin.member')->with('success', 'Member berhasil dihapus.');
    }

    /**
     * API endpoint JSON: jumlah member per kecamatan beserta koordinat GPS.
     * Dipanggil oleh Leaflet heatmap di halaman manajemen member.
     */
    public function memberDensity()
    {
        return response()->json($this->buildDensityData());
    }

    /**
     * Bangun array data density: kecamatan → jumlah member → koordinat GPS.
     */
    private function buildDensityData(): array
    {
        // Koordinat pusat tiap kecamatan (Bandung Raya & sekitarnya)
        $kecamatanCoords = [
            // ── Kota Bandung ──────────────────────────────────────
            'Andir'             => [-6.9109, 107.5891],
            'Astana Anyar'      => [-6.9321, 107.5974],
            'Babakan Ciparay'   => [-6.9461, 107.5767],
            'Bandung Kidul'     => [-6.9584, 107.6218],
            'Bandung Kulon'     => [-6.9209, 107.5786],
            'Bandung Wetan'     => [-6.9043, 107.6243],
            'Batununggal'       => [-6.9448, 107.6358],
            'Bojongloa Kaler'   => [-6.9280, 107.5883],
            'Bojongloa Kidul'   => [-6.9430, 107.5912],
            'Buahbatu'          => [-6.9604, 107.6484],
            'Cibeunying Kaler'  => [-6.8878, 107.6341],
            'Cibeunying Kidul'  => [-6.9058, 107.6347],
            'Cibiru'            => [-6.9267, 107.7143],
            'Cicendo'           => [-6.9010, 107.5952],
            'Cidadap'           => [-6.8695, 107.6005],
            'Cinambo'           => [-6.9275, 107.7014],
            'Coblong'           => [-6.8841, 107.6151],
            'Gedebage'          => [-6.9620, 107.6987],
            'Kiaracondong'      => [-6.9298, 107.6539],
            'Lengkong'          => [-6.9299, 107.6285],
            'Mandalajati'       => [-6.8975, 107.6761],
            'Panyileukan'       => [-6.9337, 107.7086],
            'Rancasari'         => [-6.9538, 107.6751],
            'Regol'             => [-6.9380, 107.6152],
            'Sukajadi'          => [-6.8905, 107.5990],
            'Sukasari'          => [-6.8800, 107.5917],
            'Sumur Bandung'     => [-6.9158, 107.6132],
            'Ujungberung'       => [-6.9088, 107.7047],
            // ── Kabupaten Bandung ─────────────────────────────────
            'Margahayu'         => [-6.9562, 107.5895],
            'Margaasih'         => [-6.9544, 107.5698],
            'Katapang'          => [-6.9892, 107.5775],
            'Banjaran'          => [-7.0498, 107.5851],
            'Majalaya'          => [-7.0484, 107.7561],
            'Cileunyi'          => [-6.9395, 107.7302],
            'Rancaekek'         => [-6.9710, 107.7644],
            'Solokanjeruk'      => [-7.0082, 107.7568],
            'Paseh'             => [-7.0481, 107.7241],
            'Cimenyan'          => [-6.8634, 107.6735],
            'Cilengkrang'       => [-6.9060, 107.7312],
            'Dayeuhkolot'       => [-6.9840, 107.6295],
            'Bojongsoang'       => [-6.9884, 107.6497],
            'Baleendah'         => [-7.0076, 107.6292],
            'Arjasari'          => [-7.0850, 107.5974],
            'Ciwidey'           => [-7.1173, 107.5076],
            'Rancabali'         => [-7.1717, 107.4590],
            'Pangalengan'       => [-7.1559, 107.5998],
            'Pacet'             => [-6.9951, 107.7162],
            'Kertasari'         => [-7.1371, 107.7021],
            'Ibun'              => [-7.0720, 107.7299],
            'Soreang'           => [-7.0298, 107.5442],
            'Kutawaringin'      => [-6.9937, 107.5255],
            'Cangkuang'         => [-7.0188, 107.5670],
            'Pameungpeuk'       => [-7.0303, 107.5685],
            // ── Kota Cimahi ───────────────────────────────────────
            'Cimahi Utara'      => [-6.8720, 107.5408],
            'Cimahi Tengah'     => [-6.8889, 107.5425],
            'Cimahi Selatan'    => [-6.9114, 107.5400],
            'Cimahi'            => [-6.8905, 107.5426],
            // ── Sumedang ─────────────────────────────────────────
            'Sumedang Utara'    => [-6.8488, 107.9271],
            'Sumedang Selatan'  => [-6.8590, 107.9207],
            'Jatinangor'        => [-6.9286, 107.7703],
            'Cimanggung'        => [-6.9582, 107.7926],
            'Tanjungsari'       => [-6.9018, 107.7918],
            // ── Fallback tengah Bandung ───────────────────────────
            'Bandung'           => [-6.9175, 107.6191],
        ];

        $rawData = Pelanggan::select('kecamatan', DB::raw('count(*) as jumlah'))
            ->whereNotNull('kecamatan')
            ->where('kecamatan', '!=', '')
            ->groupBy('kecamatan')
            ->get();

        $result = [];
        foreach ($rawData as $row) {
            $coords = null;

            // Exact match (case-insensitive)
            foreach ($kecamatanCoords as $nama => $latLng) {
                if (strcasecmp(trim($row->kecamatan), trim($nama)) === 0) {
                    $coords = $latLng;
                    break;
                }
            }

            // Fuzzy fallback: substring
            if (!$coords) {
                foreach ($kecamatanCoords as $nama => $latLng) {
                    if (stripos($row->kecamatan, $nama) !== false
                        || stripos($nama, $row->kecamatan) !== false) {
                        $coords = $latLng;
                        break;
                    }
                }
            }

            $result[] = [
                'kecamatan' => $row->kecamatan,
                'jumlah'    => (int) $row->jumlah,
                'lat'       => $coords ? $coords[0] : null,
                'lng'       => $coords ? $coords[1] : null,
            ];
        }

        return $result;
    }
}
