<?php

namespace App\Http\Controllers\AdminCabang;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Promo;
use App\Models\Produk;
use App\Models\ProdukCabang;
use Carbon\Carbon;

class PromoController extends Controller
{
    private function getIdCabang(): int
    {
        return auth()->user()?->adminCabang?->id_cabang ?? 1;
    }

    /**
     * READ — Tampilkan daftar promo dengan KPI, filter, sort, paginate.
     */
    public function index(Request $request)
    {
        $idCabang  = $this->getIdCabang();
        $search    = $request->query('search');
        $status    = $request->query('status');
        $sort      = $request->query('sort', 'tanggal_mulai');
        $direction = $request->query('direction', 'desc');

        $query = Promo::query()
            ->with(['produkPemicu', 'produkHadiah', 'cabang'])
            ->where('id_cabang', $idCabang);

        // Filter nama / kode voucher
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_voucher', 'like', '%' . $search . '%')
                  ->orWhere('kode_voucher', 'like', '%' . $search . '%');
            });
        }

        // Filter status (aktif | terjadwal | berakhir)
        $today = now()->toDateString();
        if ($status === 'aktif') {
            $query->where('tanggal_mulai', '<=', $today)->where('tanggal_berakhir', '>=', $today);
        } elseif ($status === 'terjadwal') {
            $query->where('tanggal_mulai', '>', $today);
        } elseif ($status === 'berakhir') {
            $query->where('tanggal_berakhir', '<', $today);
        }

        // KPI — dihitung sebelum paginasi (scoped ke cabang)
        $totalAktif    = Promo::where('id_cabang', $idCabang)->where('tanggal_mulai', '<=', $today)->where('tanggal_berakhir', '>=', $today)->count();
        $totalTerjadwal = Promo::where('id_cabang', $idCabang)->where('tanggal_mulai', '>', $today)->count();
        $totalBerakhir = Promo::where('id_cabang', $idCabang)->where('tanggal_berakhir', '<', $today)->count();

        // Sorting
        $allowedSort = ['nama_voucher', 'tanggal_mulai', 'tanggal_berakhir', 'potongan_harga', 'kuota_promo'];
        if (in_array($sort, $allowedSort)) {
            $query->orderBy($sort, $direction);
        }

        $promos = $query->paginate(7)->withQueryString();

        // Produk cabang untuk dropdown pemicu (semua produk di cabang ini)
        $produkList = ProdukCabang::with('produk')->where('id_cabang', $idCabang)->get();

        return view('admin-cabang.promo-voucher', compact(
            'promos', 'totalAktif', 'totalTerjadwal', 'totalBerakhir', 'produkList'
        ));
    }

    /**
     * CREATE — Simpan promo baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_voucher'      => 'required|string|max:255',
            'kode_voucher'      => 'nullable|string|max:50|unique:promos,kode_voucher',
            'id_produk_pemicu'  => 'required|exists:produks,id_produk',
            'id_produk_hadiah'  => 'nullable|exists:produks,id_produk',
            'kuantitas_pemicu'  => 'required|integer|min:1',
            'kuantitas_hadiah'  => 'nullable|integer|min:0',
            'potongan_harga'    => 'nullable|numeric|min:0',
            'min_transaksi'     => 'nullable|numeric|min:0',
            'max_promo'         => 'nullable|numeric|min:0',
            'kuota_promo'       => 'required|integer|min:1',
            'tanggal_mulai'     => 'required|date',
            'tanggal_berakhir'  => 'required|date|after_or_equal:tanggal_mulai',
        ], [
            'kode_voucher.unique'      => 'Kode voucher sudah digunakan.',
            'tanggal_berakhir.after_or_equal' => 'Tanggal berakhir harus sama atau setelah tanggal mulai.',
        ]);

        Promo::create([
            'id_cabang'        => $this->getIdCabang(),
            'nama_voucher'     => $request->nama_voucher,
            'kode_voucher'     => $request->kode_voucher ? strtoupper($request->kode_voucher) : null,
            'id_produk_pemicu' => $request->id_produk_pemicu,
            'id_produk_hadiah' => $request->id_produk_hadiah ?: null,
            'kuantitas_pemicu' => $request->kuantitas_pemicu,
            'kuantitas_hadiah' => $request->kuantitas_hadiah ?? 0,
            'potongan_harga'   => $request->potongan_harga ?? 0,
            'min_transaksi'    => $request->min_transaksi ?? 0,
            'max_promo'        => $request->max_promo ?? 0,
            'kuota_promo'      => $request->kuota_promo,
            'tanggal_mulai'    => $request->tanggal_mulai,
            'tanggal_berakhir' => $request->tanggal_berakhir,
        ]);

        return redirect()->route('admin-cabang.promo')
            ->with('success', 'Promo "' . $request->nama_voucher . '" berhasil dibuat.');
    }

    /**
     * UPDATE — Perbarui data promo.
     */
    public function update(Request $request, string $id)
    {
        $promo = Promo::where('id_cabang', $this->getIdCabang())->findOrFail($id);

        $request->validate([
            'nama_voucher'      => 'required|string|max:255',
            'kode_voucher'      => 'nullable|string|max:50|unique:promos,kode_voucher,' . $id . ',id_promo',
            'id_produk_pemicu'  => 'required|exists:produks,id_produk',
            'id_produk_hadiah'  => 'nullable|exists:produks,id_produk',
            'kuantitas_pemicu'  => 'required|integer|min:1',
            'kuantitas_hadiah'  => 'nullable|integer|min:0',
            'potongan_harga'    => 'nullable|numeric|min:0',
            'min_transaksi'     => 'nullable|numeric|min:0',
            'max_promo'         => 'nullable|numeric|min:0',
            'kuota_promo'       => 'required|integer|min:1',
            'tanggal_mulai'     => 'required|date',
            'tanggal_berakhir'  => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        $promo->update([
            'nama_voucher'     => $request->nama_voucher,
            'kode_voucher'     => $request->kode_voucher ? strtoupper($request->kode_voucher) : null,
            'id_produk_pemicu' => $request->id_produk_pemicu,
            'id_produk_hadiah' => $request->id_produk_hadiah ?: null,
            'kuantitas_pemicu' => $request->kuantitas_pemicu,
            'kuantitas_hadiah' => $request->kuantitas_hadiah ?? 0,
            'potongan_harga'   => $request->potongan_harga ?? 0,
            'min_transaksi'    => $request->min_transaksi ?? 0,
            'max_promo'        => $request->max_promo ?? 0,
            'kuota_promo'      => $request->kuota_promo,
            'tanggal_mulai'    => $request->tanggal_mulai,
            'tanggal_berakhir' => $request->tanggal_berakhir,
        ]);

        return redirect()->route('admin-cabang.promo')
            ->with('success', 'Promo "' . $promo->nama_voucher . '" berhasil diperbarui.');
    }

    /**
     * DELETE — Hapus promo.
     */
    public function destroy(string $id)
    {
        $promo = Promo::where('id_cabang', $this->getIdCabang())->findOrFail($id);
        $nama  = $promo->nama_voucher;
        $promo->delete();

        return redirect()->route('admin-cabang.promo')
            ->with('success', 'Promo "' . $nama . '" berhasil dihapus.');
    }
}
