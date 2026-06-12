<?php

namespace App\Http\Controllers\AdminCabang;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Produk;
use App\Models\ProdukCabang;
use App\Models\HistoryProduk;
use App\Models\Promo;

class ProductController extends Controller
{
    private function getIdCabang(): int
    {
        /** @var \App\Models\User|null $user */
        $user = auth()->user();
        return $user?->adminCabang?->id_cabang ?? 1;
    }

    private function getIdAdminCabang(): ?int
    {
        /** @var \App\Models\User|null $user */
        $user = auth()->user();
        return $user?->adminCabang?->id_admin_cabang;
    }

    /**
     * READ — Daftar produk berdasarkan cabang.
     */
    public function index(Request $request)
    {
        $idCabang  = $this->getIdCabang();
        $search    = $request->query('search');
        $category  = $request->query('category');
        $status    = $request->query('status');
        $sort      = $request->query('sort', 'id_produk_cabang');
        $direction = $request->query('direction', 'desc');

        // ── Query UTAMA untuk tabel + pagination ──────────────────────────
        $query = ProdukCabang::with('produk')->where('id_cabang', $idCabang);

        if ($search) {
            $query->whereHas('produk', fn($q) =>
                $q->where('nama_produk', 'like', "%{$search}%")
                  ->orWhere('kategori', 'like', "%{$search}%")
            );
        }

        if ($category && $category !== 'Semua Kategori') {
            $query->whereHas('produk', fn($q) => $q->where('kategori', $category));
        }

        if ($status === 'tersedia') {
            $query->where('jumlah_stok', '>=', 20);
        } elseif ($status === 'tipis') {
            $query->where('jumlah_stok', '>', 0)->where('jumlah_stok', '<', 20);
        } elseif ($status === 'habis') {
            $query->where('jumlah_stok', '<=', 0);
        }

        // Sorting
        $allowedSort = ['id_produk_cabang', 'jumlah_stok', 'jumlah_terjual', 'nama_produk', 'kategori'];
        if (in_array($sort, ['nama_produk', 'kategori'])) {
            $query->join('produk', 'produk_cabang.id_produk', '=', 'produk.id_produk')
                  ->orderBy("produk.{$sort}", $direction)
                  ->select('produk_cabang.*');
        } elseif (in_array($sort, ['id_produk_cabang', 'jumlah_stok', 'jumlah_terjual'])) {
            $query->orderBy($sort, $direction);
        }

        $produkCabangsPaginated = $query->paginate(8)->withQueryString();

        // ── Query TERPISAH untuk KPI (tanpa filter/sort) ──────────────────
        $allProdukCabang = ProdukCabang::with('produk')->where('id_cabang', $idCabang)->get();

        // KPI: Promo Aktif
        $today      = now()->toDateString();
        $promoAktif = Promo::query()->where('id_cabang', $idCabang)
                           ->where('tanggal_mulai', '<=', $today)
                           ->where('tanggal_berakhir', '>=', $today)
                           ->count();

        // Untuk filter dropdown kategori & analisis terlaris
        $produkCabangs = $allProdukCabang;

        // ── Data untuk Distribusi Stok per Kategori (chart & tabel) ──────
        $distribusiKategori = $produkCabangs
            ->groupBy(fn($pc) => $pc->produk->kategori ?? 'Lainnya')
            ->map(fn($group) => [
                'jumlah_sku'  => $group->count(),
                'total_stok'  => $group->sum('jumlah_stok'),
                'total_terjual' => $group->sum('jumlah_terjual'),
            ])
            ->sortByDesc('total_stok');

        $chartKategoriLabels = $distribusiKategori->keys()->values()->toArray();
        $chartKategoriStok   = $distribusiKategori->pluck('total_stok')->values()->toArray();
        $chartKategoriSku    = $distribusiKategori->pluck('jumlah_sku')->values()->toArray();

        // ── Analisis Terlaris & Kurang Laku (dengan Filter Periode) ──────
        $period = $request->query('period', 'semua');
        $querySales = \Illuminate\Support\Facades\DB::table('pesanan_produk')
            ->join('pesanan', 'pesanan_produk.id_pesanan', '=', 'pesanan.id_pesanan')
            ->where('pesanan.id_cabang', $idCabang);

        if ($period === 'bulanan') {
            $querySales->where('pesanan.tanggal_pemesanan', '>=', now()->subMonth());
        } elseif ($period === 'mingguan') {
            $querySales->where('pesanan.tanggal_pemesanan', '>=', now()->subWeek());
        } elseif ($period === 'harian') {
            $querySales->where('pesanan.tanggal_pemesanan', '>=', now()->startOfDay());
        } else {
            $period = 'semua';
        }

        $salesPerProduct = $querySales
            ->select('pesanan_produk.id_produk', \Illuminate\Support\Facades\DB::raw('SUM(pesanan_produk.jumlah) as total_qty'))
            ->groupBy('pesanan_produk.id_produk')
            ->pluck('total_qty', 'id_produk');

        $produkCabangs->each(function ($pc) use ($salesPerProduct) {
            $pc->period_sales = $salesPerProduct->get($pc->id_produk, 0);
        });

        $topProduk = $produkCabangs->sortByDesc('period_sales')->take(3);
        $bottomProduk = $produkCabangs->sortBy('period_sales')->take(3);
        // Stats tambahan
        $stokHabis   = $produkCabangs->where('jumlah_stok', '<=', 0)->count();
        $lastUpdated = $produkCabangs->max(fn($pc) => $pc->produk?->updated_at);

        $persenBenefit = \App\Models\Pengaturan::where('kunci', 'member_plus_persentase')->value('nilai') ?? 0;
        $maksimalBenefit = \App\Models\Pengaturan::where('kunci', 'member_plus_maksimal')->value('nilai') ?? 0;

        return view('admin-cabang.produk', compact(
            'produkCabangs',
            'produkCabangsPaginated',
            'promoAktif',
            'distribusiKategori',
            'chartKategoriLabels',
            'chartKategoriStok',
            'chartKategoriSku',
            'stokHabis',
            'lastUpdated',
            'period',
            'topProduk',
            'bottomProduk',
            'persenBenefit',
            'maksimalBenefit'
        ));
    }

    /**
     * READ — Detail informasi produk cabang.
     */
    public function detail(Request $request)
    {
        $idProdukCabang = $request->query('id');
        $idCabang       = $this->getIdCabang();

        $produkCabang = ProdukCabang::with(['produk', 'cabang'])
            ->where('id_produk_cabang', $idProdukCabang)
            ->where('id_cabang', $idCabang)
            ->first();

        if (!$produkCabang) {
            return redirect()->route('admin-cabang.produk')
                ->with('error', 'Produk tidak ditemukan di cabang ini.');
        }

        $riwayatHarga = HistoryProduk::with('adminCabang.user')
            ->where('id_produk', $produkCabang->id_produk)
            ->orderByDesc('created_at')
            ->get();

        $persenBenefit = \App\Models\Pengaturan::where('kunci', 'member_plus_persentase')->value('nilai') ?? 0;
        $maksimalBenefit = \App\Models\Pengaturan::where('kunci', 'member_plus_maksimal')->value('nilai') ?? 0;

        return view('admin-cabang.detail-produk', compact('produkCabang', 'riwayatHarga', 'persenBenefit', 'maksimalBenefit'));
    }


    /**
     * CREATE — Simpan produk baru ke produks + produk_cabang.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_produk'   => 'required|string|max:255',
            'kategori'      => 'required|string|max:100',
            'deskripsi'     => 'nullable|string|max:1000',
            'harga_member' => 'required|numeric|min:0',
            'harga_member_plus'  => 'nullable|numeric|min:0',
            'jumlah_stok'   => 'required|integer|min:0',
            'gambar_produk' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $idCabang    = $this->getIdCabang();
        $harga_member = (int) $request->harga_member;

        $persenBenefit = \App\Models\Pengaturan::where('kunci', 'member_plus_persentase')->value('nilai') ?? 0;
        $maksimalBenefit = \App\Models\Pengaturan::where('kunci', 'member_plus_maksimal')->value('nilai') ?? 0;

        if ($request->filled('harga_member_plus')) {
            $harga_member_plus = (int) $request->harga_member_plus;
            $potongan = $harga_member - $harga_member_plus;
            $maxDiskon = min(($harga_member * $persenBenefit / 100), $maksimalBenefit);

            if ($potongan < 0) {
                return back()->withErrors([
                    'harga_member_plus' => "Harga Member Plus tidak boleh lebih besar dari Harga Member."
                ])->withInput();
            }

            if ($potongan > $maxDiskon) {
                return back()->withErrors([
                    'harga_member_plus' => "Potongan harga Member Plus (Rp " . number_format($potongan, 0, ',', '.') . ") melebihi batas diskon benefit dari Super Admin (Maksimal Rp " . number_format($maxDiskon, 0, ',', '.') . ")."
                ])->withInput();
            }
        } else {
            // Otomatis hitung jika kosong berdasarkan benefit super admin
            $diskon = min(($harga_member * $persenBenefit / 100), $maksimalBenefit);
            $harga_member_plus = max(0, $harga_member - $diskon);
        }

        // Upload gambar
        $gambarPath = 'default.jpg';
        if ($request->hasFile('gambar_produk')) {
            $gambarPath = $request->file('gambar_produk')->store('produk_images', 'public');
        }

        // Simpan produk master
        $product = Produk::create([
            'nama_produk'   => $request->nama_produk,
            'kategori'      => $request->kategori,
            'deskripsi'     => $request->deskripsi ?? 'Deskripsi produk.',
            'harga_member' => $harga_member,
            'harga_member_plus'  => $harga_member_plus,
            'gambar_produk' => $gambarPath,
        ]);

        // Stok per cabang
        ProdukCabang::create([
            'id_produk'       => $product->id_produk,
            'id_cabang'       => $idCabang,
            'jumlah_stok'     => $request->jumlah_stok,
            'jumlah_terjual'  => 0,
        ]);

        // Catat history harga awal
        HistoryProduk::create([
            'id_produk'          => $product->id_produk,
            'harga_member_baru' => $harga_member,
            'harga_member_plus_baru'  => $harga_member_plus,
            'id_admin_cabang'    => $this->getIdAdminCabang(),
        ]);

        return redirect()->route('admin-cabang.produk')
            ->with('success', "Produk \"{$request->nama_produk}\" berhasil ditambahkan.");
    }

    /**
     * UPDATE — Edit produk dan stok. Catat history jika harga berubah.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_produk'   => 'required|string|max:255',
            'kategori'      => 'required|string|max:100',
            'deskripsi'     => 'nullable|string|max:1000',
            'harga_member' => 'required|numeric|min:0',
            'harga_member_plus'  => 'nullable|numeric|min:0',
            'jumlah_stok'   => 'required|integer|min:0',
            'gambar_produk' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $idCabang = $this->getIdCabang();

        $produkCabang = ProdukCabang::with('produk')
            ->where('id_produk_cabang', $id)
            ->where('id_cabang', $idCabang)
            ->first();

        if (!$produkCabang || !$produkCabang->produk) {
            return redirect()->route('admin-cabang.produk')
                ->with('error', 'Produk tidak ditemukan.');
        }

        $product         = $produkCabang->produk;
        $oldHarga        = $product->harga_member;
        $oldHargaMember  = $product->harga_member_plus;
        $newHarga        = (int) $request->harga_member;

        $persenBenefit = \App\Models\Pengaturan::where('kunci', 'member_plus_persentase')->value('nilai') ?? 0;
        $maksimalBenefit = \App\Models\Pengaturan::where('kunci', 'member_plus_maksimal')->value('nilai') ?? 0;

        if ($request->filled('harga_member_plus')) {
            $newHargaMemberPlus = (int) $request->harga_member_plus;
            $potongan = $newHarga - $newHargaMemberPlus;
            $maxDiskon = min(($newHarga * $persenBenefit / 100), $maksimalBenefit);

            if ($potongan < 0) {
                return back()->withErrors([
                    'harga_member_plus' => "Harga Member Plus tidak boleh lebih besar dari Harga Member."
                ])->withInput();
            }

            if ($potongan > $maxDiskon) {
                return back()->withErrors([
                    'harga_member_plus' => "Potongan harga Member Plus (Rp " . number_format($potongan, 0, ',', '.') . ") melebihi batas diskon benefit dari Super Admin (Maksimal Rp " . number_format($maxDiskon, 0, ',', '.') . ")."
                ])->withInput();
            }
        } else {
            // Otomatis hitung jika kosong berdasarkan benefit super admin
            $diskon = min(($newHarga * $persenBenefit / 100), $maksimalBenefit);
            $newHargaMemberPlus = max(0, $newHarga - $diskon);
        }

        $dataToUpdate = [
            'nama_produk'       => $request->nama_produk,
            'kategori'          => $request->kategori,
            'deskripsi'         => $request->deskripsi ?? $product->deskripsi,
            'harga_member'      => $newHarga,
            'harga_member_plus' => $newHargaMemberPlus,
        ];

        if ($request->hasFile('gambar_produk')) {
            if ($product->gambar_produk && $product->gambar_produk !== 'default.jpg') {
                Storage::disk('public')->delete($product->gambar_produk);
            }
            $dataToUpdate['gambar_produk'] = $request->file('gambar_produk')
                ->store('produk_images', 'public');
        }

        $product->update($dataToUpdate);

        $produkCabang->update([
            'jumlah_stok' => $request->jumlah_stok,
        ]);

        // Catat history jika harga berubah
        if ($oldHarga != $newHarga || $oldHargaMember != $newHargaMemberPlus) {
            HistoryProduk::create([
                'id_produk'              => $product->id_produk,
                'harga_member_lama'      => $oldHarga,
                'harga_member_baru'      => $newHarga,
                'harga_member_plus_lama' => $oldHargaMember,
                'harga_member_plus_baru' => $newHargaMemberPlus,
                'id_admin_cabang'        => $this->getIdAdminCabang(),
            ]);
        }

        return redirect()
            ->route('admin-cabang.produk.detail', ['id' => $produkCabang->id_produk_cabang])
            ->with('success', "Produk \"{$request->nama_produk}\" berhasil diperbarui.");
    }

    /**
     * DELETE — Hapus produk dari cabang (bukan produk master).
     */
    public function destroy(string $id)
    {
        $idCabang = $this->getIdCabang();

        $produkCabang = ProdukCabang::query()->where('id_produk_cabang', $id)
            ->where('id_cabang', $idCabang)
            ->first();

        if ($produkCabang) {
            $produkCabang->delete();
        }

        return redirect()->route('admin-cabang.produk')
            ->with('success', 'Produk berhasil dihapus dari cabang ini.');
    }

    /**
     * EXPORT — Download daftar produk cabang berformat CSV.
     */
    public function exportCsv(Request $request)
    {
        $idCabang = $this->getIdCabang();
        $search    = $request->query('search');
        $category  = $request->query('category');
        $status    = $request->query('status');

        $query = ProdukCabang::with('produk')->where('id_cabang', $idCabang);

        if ($search) {
            $query->whereHas('produk', fn($q) =>
                $q->where('nama_produk', 'like', "%{$search}%")
                  ->orWhere('kategori', 'like', "%{$search}%")
            );
        }

        if ($category && $category !== 'Semua Kategori') {
            $query->whereHas('produk', fn($q) => $q->where('kategori', $category));
        }

        if ($status === 'tersedia') {
            $query->where('jumlah_stok', '>=', 20);
        } elseif ($status === 'tipis') {
            $query->where('jumlah_stok', '>', 0)->where('jumlah_stok', '<', 20);
        } elseif ($status === 'habis') {
            $query->where('jumlah_stok', '<=', 0);
        }

        $produkCabangs = $query->get();

        $filename = "laporan_produk_cabang_" . now()->format('Y_m_d') . ".csv";
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use ($produkCabangs) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID SKU Cabang', 'ID SKU Master', 'Nama Produk', 'Kategori', 'Harga Member', 'Harga Member Plus', 'Stok', 'Terjual']);

            foreach ($produkCabangs as $pc) {
                fputcsv($file, [
                    "SKU-CB-" . str_pad($pc->id_produk_cabang, 3, '0', STR_PAD_LEFT),
                    "SKU-MT-" . str_pad($pc->id_produk, 3, '0', STR_PAD_LEFT),
                    $pc->produk->nama_produk ?? '-',
                    $pc->produk->kategori ?? '-',
                    $pc->produk->harga_member ?? 0,
                    $pc->produk->harga_member_plus ?? 0,
                    $pc->jumlah_stok,
                    $pc->jumlah_terjual
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
