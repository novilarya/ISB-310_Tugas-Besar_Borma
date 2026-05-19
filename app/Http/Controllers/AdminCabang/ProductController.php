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
        return auth()->user()?->adminCabang?->id_cabang ?? 1;
    }

    private function getIdAdminCabang(): ?int
    {
        return auth()->user()?->adminCabang?->id_admin_cabang;
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
            $query->join('produks', 'produk_cabangs.id_produk', '=', 'produks.id_produk')
                  ->orderBy("produks.{$sort}", $direction)
                  ->select('produk_cabangs.*');
        } elseif (in_array($sort, ['id_produk_cabang', 'jumlah_stok', 'jumlah_terjual'])) {
            $query->orderBy($sort, $direction);
        }

        $produkCabangsPaginated = $query->paginate(8)->withQueryString();

        // ── Query TERPISAH untuk KPI (tanpa filter/sort) ──────────────────
        $allProdukCabang = ProdukCabang::with('produk')->where('id_cabang', $idCabang)->get();

        // KPI: Promo Aktif
        $today      = now()->toDateString();
        $promoAktif = Promo::where('id_cabang', $idCabang)
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
        $querySales = \Illuminate\Support\Facades\DB::table('pesanan_produks')
            ->join('pesanans', 'pesanan_produks.id_pesanan', '=', 'pesanans.id_pesanan')
            ->where('pesanans.id_cabang', $idCabang);

        if ($period === 'bulanan') {
            $querySales->where('pesanans.tanggal_pemesanan', '>=', now()->subMonth());
        } elseif ($period === 'mingguan') {
            $querySales->where('pesanans.tanggal_pemesanan', '>=', now()->subWeek());
        } elseif ($period === 'harian') {
            $querySales->where('pesanans.tanggal_pemesanan', '>=', now()->startOfDay());
        } else {
            $period = 'semua';
        }

        $salesPerProduct = $querySales
            ->select('pesanan_produks.id_produk', \Illuminate\Support\Facades\DB::raw('SUM(pesanan_produks.jumlah) as total_qty'))
            ->groupBy('pesanan_produks.id_produk')
            ->pluck('total_qty', 'id_produk');

        $produkCabangs->each(function ($pc) use ($salesPerProduct) {
            $pc->period_sales = $salesPerProduct->get($pc->id_produk, 0);
        });

        $topProduk = $produkCabangs->sortByDesc('period_sales')->take(3);
        $bottomProduk = $produkCabangs->sortBy('period_sales')->take(3);

        // Stats tambahan
        $stokHabis   = $produkCabangs->where('jumlah_stok', '<=', 0)->count();
        $lastUpdated = $produkCabangs->max(fn($pc) => $pc->produk?->updated_at);

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
            'bottomProduk'
        ));
    }

    /**
     * READ — Detail satu produk cabang.
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

        return view('admin-cabang.detail-produk', compact('produkCabang', 'riwayatHarga'));
    }

    /**
     * CREATE — Simpan produk baru ke produks + produk_cabangs.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_produk'   => 'required|string|max:255',
            'kategori'      => 'required|string|max:100',
            'deskripsi'     => 'nullable|string|max:1000',
            'harga_reguler' => 'required|numeric|min:0',
            'harga_member'  => 'nullable|numeric|min:0',
            'jumlah_stok'   => 'required|integer|min:0',
            'gambar_produk' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $idCabang    = $this->getIdCabang();
        $hargaReguler = (int) $request->harga_reguler;

        if ($request->filled('harga_member')) {
            $hargaMember = (int) $request->harga_member;
            $potongan = $hargaReguler - $hargaMember;

            if ($hargaReguler < 50000) {
                // Potongan persen: range 1% - 2.5%
                $minPotongan = $hargaReguler * 0.01;
                $maxPotongan = $hargaReguler * 0.025;
                if ($potongan < $minPotongan || $potongan > $maxPotongan) {
                    return back()->withErrors([
                        'harga_member' => "Untuk harga reguler di bawah Rp 50.000, potongan harga member wajib berupa persentase 1% s/d 2,5% (potongan saat ini: Rp " . number_format($potongan, 0, ',', '.') . " atau sekitar " . round($potongan / $hargaReguler * 100, 2) . "%, range diperbolehkan: Rp " . number_format($minPotongan, 0, ',', '.') . " s/d Rp " . number_format($maxPotongan, 0, ',', '.') . ")."
                    ])->withInput();
                }
            } else {
                // Potongan rupiah flat: range 1.000 - 2.500
                if ($potongan < 1000 || $potongan > 2500) {
                    return back()->withErrors([
                        'harga_member' => "Untuk harga reguler Rp 50.000 ke atas, potongan harga member wajib berkisar antara Rp 1.000 s/d Rp 2.500 (potongan saat ini: Rp " . number_format($potongan, 0, ',', '.') . ")."
                    ])->withInput();
                }
            }
        } else {
            // Otomatis hitung jika kosong
            if ($hargaReguler < 50000) {
                // Default 2% potongan
                $hargaMember = (int) round($hargaReguler * 0.98);
            } else {
                // Default Rp 2.000 potongan
                $hargaMember = $hargaReguler - 2000;
            }
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
            'harga_reguler' => $hargaReguler,
            'harga_member'  => $hargaMember,
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
            'harga_reguler_baru' => $hargaReguler,
            'harga_member_baru'  => $hargaMember,
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
            'harga_reguler' => 'required|numeric|min:0',
            'harga_member'  => 'nullable|numeric|min:0',
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
        $oldHarga        = $product->harga_reguler;
        $oldHargaMember  = $product->harga_member;
        $newHarga        = (int) $request->harga_reguler;

        if ($request->filled('harga_member')) {
            $newHargaMember = (int) $request->harga_member;
            $potongan = $newHarga - $newHargaMember;

            if ($newHarga < 50000) {
                // Potongan persen: range 1% - 2.5%
                $minPotongan = $newHarga * 0.01;
                $maxPotongan = $newHarga * 0.025;
                if ($potongan < $minPotongan || $potongan > $maxPotongan) {
                    return back()->withErrors([
                        'harga_member' => "Untuk harga reguler di bawah Rp 50.000, potongan harga member wajib berupa persentase 1% s/d 2,5% (potongan saat ini: Rp " . number_format($potongan, 0, ',', '.') . " atau sekitar " . round($potongan / $newHarga * 100, 2) . "%, range diperbolehkan: Rp " . number_format($minPotongan, 0, ',', '.') . " s/d Rp " . number_format($maxPotongan, 0, ',', '.') . ")."
                    ])->withInput();
                }
            } else {
                // Potongan rupiah flat: range 1.000 - 2.500
                if ($potongan < 1000 || $potongan > 2500) {
                    return back()->withErrors([
                        'harga_member' => "Untuk harga reguler Rp 50.000 ke atas, potongan harga member wajib berkisar antara Rp 1.000 s/d Rp 2.500 (potongan saat ini: Rp " . number_format($potongan, 0, ',', '.') . ")."
                    ])->withInput();
                }
            }
        } else {
            // Otomatis hitung jika kosong
            if ($newHarga < 50000) {
                // Default 2% potongan
                $newHargaMember = (int) round($newHarga * 0.98);
            } else {
                // Default Rp 2.000 potongan
                $newHargaMember = $newHarga - 2000;
            }
        }

        $dataToUpdate = [
            'nama_produk'   => $request->nama_produk,
            'kategori'      => $request->kategori,
            'deskripsi'     => $request->deskripsi ?? $product->deskripsi,
            'harga_reguler' => $newHarga,
            'harga_member'  => $newHargaMember,
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
        if ($oldHarga != $newHarga || $oldHargaMember != $newHargaMember) {
            HistoryProduk::create([
                'id_produk'          => $product->id_produk,
                'harga_reguler_lama' => $oldHarga,
                'harga_reguler_baru' => $newHarga,
                'harga_member_lama'  => $oldHargaMember,
                'harga_member_baru'  => $newHargaMember,
                'id_admin_cabang'    => $this->getIdAdminCabang(),
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

        $produkCabang = ProdukCabang::where('id_produk_cabang', $id)
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
            fputcsv($file, ['ID SKU Cabang', 'ID SKU Master', 'Nama Produk', 'Kategori', 'Harga Reguler', 'Harga Member', 'Stok', 'Terjual']);

            foreach ($produkCabangs as $pc) {
                fputcsv($file, [
                    "SKU-CB-" . str_pad($pc->id_produk_cabang, 3, '0', STR_PAD_LEFT),
                    "SKU-MT-" . str_pad($pc->id_produk, 3, '0', STR_PAD_LEFT),
                    $pc->produk->nama_produk ?? '-',
                    $pc->produk->kategori ?? '-',
                    $pc->produk->harga_reguler ?? 0,
                    $pc->produk->harga_member ?? 0,
                    $pc->jumlah_stok,
                    $pc->jumlah_terjual
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
