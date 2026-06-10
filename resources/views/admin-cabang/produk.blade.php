@extends('admin-cabang.layouts.admin-cabang')

@section('title', 'Manajemen Produk - Borma Toserba')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin-cabang.css') }}">
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
@endpush

@section('content')
<!-- Header -->
<div class="d-flex justify-content-between align-items-end mb-4">
    <div class="page-header-text">
        <h1 class="page-title mb-2">Manajemen Produk</h1>
        <p class="page-subtitle text-muted m-0">Kelola inventaris Borma Toserba secara efisien. Pantau stok, perbarui harga member, dan aktifkan status promosi dari satu dasbor pusat.</p>
    </div>
    <div class="d-flex gap-2 align-items-center">
        <a href="{{ route('admin-cabang.produk.export-csv', request()->query()) }}" class="btn-action btn-action-outline" style="text-decoration: none; padding: 10px 20px; font-size: 0.9rem; font-weight: 700; border-radius: 12px; display: inline-flex; align-items: center; justify-content: center; gap: 8px;">
            <i class="bi bi-file-earmark-arrow-down" style="font-size: 1.1rem;"></i> Ekspor CSV
        </a>
        <button class="btn-primary-custom" data-bs-toggle="modal" data-bs-target="#tambahProdukModal" style="padding: 10px 24px;"><i class="bi bi-plus-lg me-2"></i> Tambah Produk</button>
    </div>
</div>



<!-- KPI Cards -->
<div class="row g-4 mb-5">
    <div class="col-md-3">
        <div class="glass-card h-100 kpi-card-interactive hover-primary">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div class="kpi-title">Total Produk</div>
                <div class="icon-box bg-primary-light"><i class="bi bi-box-seam"></i></div>
            </div>
            <div class="kpi-value mb-0">{{ number_format($produkCabangs->count(), 0, ',', '.') }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="glass-card h-100 kpi-card-interactive hover-tertiary">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div class="kpi-title">Stok Tipis</div>
                <div class="icon-box bg-tertiary-light"><i class="bi bi-exclamation-triangle"></i></div>
            </div>
            <div class="kpi-value mb-0">{{ $produkCabangs->where('jumlah_stok', '<', 20)->count() }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="glass-card h-100 kpi-card-interactive hover-secondary">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div class="kpi-title">Promo Aktif</div>
                <div class="icon-box bg-secondary-light"><i class="bi bi-tag-fill text-secondary-custom"></i></div>
            </div>
            <div class="kpi-value mb-0">{{ $promoAktif }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="glass-card h-100 kpi-card-interactive hover-primary">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div class="kpi-title">Kategori</div>
                <div class="icon-box bg-primary-light"><i class="bi bi-grid-fill"></i></div>
            </div>
            <div class="kpi-value mb-0">{{ $produkCabangs->pluck('produk.kategori')->unique()->count() }}</div>
        </div>
    </div>
</div>

<!-- Part 1: Analisis Penjualan Produk -->
<div class="d-flex justify-content-between align-items-center mt-4 mb-3">
    <div>
        <h5 class="m-0" style="font-weight: 800; color: var(--borma-neutral);">Analisis Penjualan Produk</h5>
        <p class="text-muted m-0" style="font-size: 0.85rem;">Berdasarkan periode waktu yang dipilih.</p>
    </div>
    <form action="{{ route('admin-cabang.produk') }}" method="GET" class="m-0 p-0">
        <!-- Preserve existing query strings except period -->
        @foreach(request()->except(['period', 'page']) as $key => $value)
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endforeach
        <select name="period" class="form-select border-0 bg-white shadow-sm" style="font-weight: 700; cursor: pointer; border-radius: 8px; color: var(--borma-primary);" onchange="this.form.submit()">
            <option value="semua" {{ request('period', 'semua') == 'semua' ? 'selected' : '' }}>Semua Waktu</option>
            <option value="harian" {{ request('period') == 'harian' ? 'selected' : '' }}>Hari Ini</option>
            <option value="mingguan" {{ request('period') == 'mingguan' ? 'selected' : '' }}>Minggu Ini</option>
            <option value="bulanan" {{ request('period') == 'bulanan' ? 'selected' : '' }}>Bulan Ini</option>
        </select>
    </form>
</div>

<div class="row g-4 mb-5">
    <div class="col-lg-6">
        <div class="analysis-card">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="analysis-card-title m-0">
                    Produk Terlaris
                    <i class="bi bi-arrow-up-circle-fill text-success ms-3"></i>
                </div>
            </div>
            
            @forelse($topProduk as $pc)
            <div class="list-item-modern {{ $loop->last ? 'border-bottom-0 pb-0' : '' }}">
                @if(!empty($pc->produk->gambar_produk) && $pc->produk->gambar_produk !== 'default.jpg')
                    <img src="{{ asset('storage/produk/' . $pc->produk->gambar_produk) }}" alt="{{ $pc->produk->nama_produk }}" class="icon-box" style="object-fit: cover; border-radius: 8px;">
                @else
                    <div class="icon-box bg-light text-muted" style="border-radius: 8px;"><i class="bi bi-image"></i></div>
                @endif
                <div class="info">
                    <h6>{{ $pc->produk->nama_produk }}</h6>
                    <small class="text-muted">Stok: <strong class="{{ $pc->jumlah_stok < 20 ? 'text-danger' : '' }}">{{ $pc->jumlah_stok }}</strong> unit</small>
                </div>
                <div class="text-end d-flex align-items-center justify-content-center">
                    <span class="badge-modern bg-green-100 text-green-800 d-inline-flex align-items-center gap-1 py-1.5 px-3" style="border-radius: 30px; font-weight: 800; font-size: 0.85rem;">
                        <span style="font-size: 1.05rem;">{{ number_format($pc->period_sales, 0, ',', '.') }}</span>
                        <span style="font-size: 0.72rem; opacity: 0.85; font-weight: 700; text-transform: none; letter-spacing: 0;">Terjual</span>
                    </span>
                </div>
            </div>
            @empty
            <p class="text-muted text-center py-3">Belum ada data penjualan di periode ini.</p>
            @endforelse
        </div>
    </div>
    
    <div class="col-lg-6">
        <div class="analysis-card">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="analysis-card-title m-0">
                    Produk Kurang Laku
                    <i class="bi bi-arrow-down-circle-fill text-tertiary-custom ms-3"></i>
                </div>
            </div>
            
            @forelse($bottomProduk as $pc)
            <div class="list-item-modern {{ $loop->last ? 'border-bottom-0 pb-0' : '' }}">
                @if(!empty($pc->produk->gambar_produk) && $pc->produk->gambar_produk !== 'default.jpg')
                    <img src="{{ asset('storage/produk/' . $pc->produk->gambar_produk) }}" alt="{{ $pc->produk->nama_produk }}" class="icon-box" style="object-fit: cover; border-radius: 8px;">
                @else
                    <div class="icon-box bg-light text-muted" style="border-radius: 8px;"><i class="bi bi-image"></i></div>
                @endif
                <div class="info">
                    <h6>{{ $pc->produk->nama_produk }}</h6>
                    <small class="text-muted">Stok: <strong class="{{ $pc->jumlah_stok < 20 ? 'text-danger' : '' }}">{{ $pc->jumlah_stok }}</strong> unit</small>
                </div>
                <div class="text-end d-flex align-items-center justify-content-center">
                    <span class="badge-modern bg-tertiary-light text-tertiary-custom d-inline-flex align-items-center gap-1 py-1.5 px-3" style="border-radius: 30px; font-weight: 800; font-size: 0.85rem;">
                        <span style="font-size: 1.05rem;">{{ number_format($pc->period_sales, 0, ',', '.') }}</span>
                        <span style="font-size: 0.72rem; opacity: 0.85; font-weight: 700; text-transform: none; letter-spacing: 0;">Terjual</span>
                    </span>
                </div>
            </div>
            @empty
            <p class="text-muted text-center py-3">Belum ada data penjualan di periode ini.</p>
            @endforelse
        </div>
    </div>
</div>

<!-- Part 2: Distribusi Stok per Kategori -->
<div class="d-flex justify-content-between align-items-center mt-5 mb-3">
    <div>
        <h5 class="m-0" style="font-weight: 800; color: var(--borma-neutral);">Distribusi Stok per Kategori</h5>
        <p class="text-muted m-0" style="font-size: 0.85rem;">Statistik sebaran stok dan performa penjualan per kategori barang.</p>
    </div>
</div>

<div class="row g-4 mb-5">
    <div class="col-12">
        <div class="glass-card">
            <div class="row g-4 align-items-start">
                {{-- Kolom Kiri: Chart Bar --}}
                <div class="col-lg-5">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="kpi-title m-0">Grafik Sebaran Stok</h6>
                        <span class="badge-modern badge-primary" style="font-size:0.68rem;">
                            <i class="bi bi-database-fill me-1"></i>Data Real
                        </span>
                    </div>
                    <div style="height: 220px; position:relative;">
                        <canvas id="kategoriStokChart"></canvas>
                    </div>
                </div>

                {{-- Kolom Kanan: Tabel Ringkasan + Stats --}}
                <div class="col-lg-7">
                    <h6 class="kpi-title mb-3">Ringkasan per Kategori</h6>
                    <div style="max-height: 240px; overflow-y: auto; padding-right: 4px;" class="pe-1">
                        <table class="table" style="font-size:0.83rem; margin-bottom:0; border-collapse: separate; border-spacing: 0;">
                            <thead class="sticky top-0 z-10">
                                <tr class="bg-slate-50 dark:bg-[#180933]">
                                    <th class="text-muted" style="font-weight:700; border-bottom:2px solid #E5E7EB; background: inherit; position: sticky; top: 0;">Kategori</th>
                                    <th class="text-muted text-center" style="font-weight:700; border-bottom:2px solid #E5E7EB; background: inherit; position: sticky; top: 0;">SKU</th>
                                    <th class="text-muted text-center" style="font-weight:700; border-bottom:2px solid #E5E7EB; background: inherit; position: sticky; top: 0;">Total Stok</th>
                                    <th class="text-muted text-center" style="font-weight:700; border-bottom:2px solid #E5E7EB; background: inherit; position: sticky; top: 0;">Terjual</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($distribusiKategori as $kategori => $data)
                                <tr>
                                    <td style="font-weight:700; color:var(--borma-neutral);">{{ $kategori }}</td>
                                    <td class="text-center text-muted">{{ $data['jumlah_sku'] }} produk</td>
                                    <td class="text-center">
                                        <strong class="{{ $data['total_stok'] < 20 ? 'text-danger' : 'text-success' }}">
                                            {{ number_format($data['total_stok'], 0, ',', '.') }}
                                        </strong>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge-modern badge-primary" style="font-size:0.72rem;">
                                            {{ number_format($data['total_terjual'], 0, ',', '.') }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="4" class="text-center text-muted py-3">Belum ada data.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Footer Stats --}}
                    <div class="d-flex gap-4 mt-4 pt-3" style="border-top:1px dashed #E5E7EB;">
                        <div>
                            <div style="font-size:0.7rem;font-weight:700;color:#9CA3AF;text-transform:uppercase;letter-spacing:0.5px;">Stok Habis</div>
                            <div style="font-size:1.2rem;font-weight:800;color:var(--borma-tertiary);">{{ $stokHabis }}</div>
                        </div>
                        <div>
                            <div style="font-size:0.7rem;font-weight:700;color:#9CA3AF;text-transform:uppercase;letter-spacing:0.5px;">Promo Aktif</div>
                            <div style="font-size:1.2rem;font-weight:800;color:var(--borma-secondary);">{{ $promoAktif }}</div>
                        </div>
                        <div>
                            <div style="font-size:0.7rem;font-weight:700;color:#9CA3AF;text-transform:uppercase;letter-spacing:0.5px;">Total Kategori</div>
                            <div style="font-size:1.2rem;font-weight:800;color:var(--borma-primary);">{{ $distribusiKategori->count() }}</div>
                        </div>
                        <div class="ms-auto text-end">
                             <div style="font-size:0.7rem;font-weight:700;color:#9CA3AF;text-transform:uppercase;letter-spacing:0.5px;">Terakhir Update</div>
                             <div style="font-size:0.82rem;font-weight:700;color:#6B7280;">
                                 {{ $lastUpdated ? \Carbon\Carbon::parse($lastUpdated)->diffForHumans() : '-' }}
                             </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Part 3: Daftar Inventaris & Main Table Area -->
<div class="d-flex justify-content-between align-items-center mt-5 mb-3">
    <div>
        <h5 class="m-0" style="font-weight: 800; color: var(--borma-neutral);">Daftar Inventaris Produk</h5>
        <p class="text-muted m-0" style="font-size: 0.85rem;">Cari, saring, dan kelola detail produk cabang Anda.</p>
    </div>
</div>

<div class="mb-5">
    <div class="glass-card mb-4" style="padding: 16px 24px;">
        <form action="{{ route('admin-cabang.produk') }}" method="GET" class="row g-3 w-100 align-items-center m-0">
            <div class="col-md-5 ps-0">
                <div class="search-input w-100">
                    <i class="bi bi-search"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama produk, SKU, atau kategori..." class="w-100">
                </div>
            </div>
            <div class="col-md-3">
                <select name="category" class="form-select filter-select-lg w-100" onchange="this.form.submit()">
                    <option value="">Semua Kategori</option>
                    @foreach($produkCabangs->pluck('produk.kategori')->unique() as $cat)
                        <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select filter-select-md w-100" onchange="this.form.submit()">
                    <option value="">Semua Status Stok</option>
                    <option value="tersedia" {{ request('status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                    <option value="tipis" {{ request('status') == 'tipis' ? 'selected' : '' }}>Stok Tipis (< 20)</option>
                    <option value="habis" {{ request('status') == 'habis' ? 'selected' : '' }}>Habis</option>
                </select>
            </div>
            <div class="col-md-1 pe-0 text-end">
                <a href="{{ route('admin-cabang.produk') }}" class="btn-action btn-action-outline filter-btn w-100 d-flex justify-content-center align-items-center" style="height: 42px;" title="Reset Filter"><i class="bi bi-arrow-counterclockwise"></i></a>
            </div>
        </form>
    </div>

    <div class="table-produk">
        <table>
            <thead>
                <tr>
                    <th>
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'nama_produk', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}" class="text-primary-custom text-decoration-none">
                            Nama Produk
                            @if(request('sort') == 'nama_produk')
                                <i class="bi bi-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }}"></i>
                            @else
                                <i class="bi bi-arrow-down-up text-muted" style="font-size: 0.7rem;"></i>
                            @endif
                        </a>
                    </th>
                    <th>
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'kategori', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}" class="text-primary-custom text-decoration-none">
                            Kategori
                            @if(request('sort') == 'kategori')
                                <i class="bi bi-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }}"></i>
                            @else
                                <i class="bi bi-arrow-down-up text-muted" style="font-size: 0.7rem;"></i>
                            @endif
                        </a>
                    </th>
                    <th>
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'jumlah_stok', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}" class="text-primary-custom text-decoration-none">
                            Stok
                            @if(request('sort') == 'jumlah_stok')
                                <i class="bi bi-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }}"></i>
                            @else
                                <i class="bi bi-arrow-down-up text-muted" style="font-size: 0.7rem;"></i>
                            @endif
                        </a>
                    </th>
                    <th>Harga Member</th>
                    <th>Harga Member Plus</th>
                    <th>
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'jumlah_terjual', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}" class="text-primary-custom text-decoration-none">
                            Terjual
                            @if(request('sort') == 'jumlah_terjual')
                                <i class="bi bi-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }}"></i>
                            @else
                                <i class="bi bi-arrow-down-up text-muted" style="font-size: 0.7rem;"></i>
                            @endif
                        </a>
                    </th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($produkCabangsPaginated as $pc)
                <tr>
                    <td>
                        <span class="sku-text">ID: {{ $pc->id_produk_cabang }}</span>
                        <a href="{{ route('admin-cabang.produk.detail', ['id' => $pc->id_produk_cabang]) }}" class="product-link"><strong class="text-primary-custom">{{ $pc->produk->nama_produk }}</strong></a>
                    </td>
                    <td>{{ $pc->produk->kategori }}</td>
                    <td><strong class="{{ $pc->jumlah_stok < 20 ? 'text-danger' : '' }}">{{ $pc->jumlah_stok }}</strong> <span class="text-muted">Unit</span></td>
                    <td class="text-muted">Rp {{ number_format($pc->produk->harga_reguler, 0, ',', '.') }}</td>
                    <td><strong class="harga-member">Rp {{ number_format($pc->produk->harga_member, 0, ',', '.') }}</strong></td>
                    <td><strong class="text-muted">{{ number_format($pc->jumlah_terjual, 0, ',', '.') }}</strong> <span class="text-muted" style="font-size: 0.7rem;">Pcs</span></td>
                    <td class="action-icons">
                        <a href="{{ route('admin-cabang.produk.detail', ['id' => $pc->id_produk_cabang]) }}"><i class="bi bi-pencil-square" title="Edit"></i></a>
                        <form action="{{ route('admin-cabang.produk.delete', $pc->id_produk_cabang) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini dari cabang?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background:none; border:none; padding:0; color:var(--borma-tertiary);"><i class="bi bi-trash" title="Hapus"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center py-4 text-muted">Belum ada data produk di cabang ini.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="pagination-custom mt-4 mb-2 px-3">
            <span class="text-muted me-auto pagination-info">Menampilkan {{ $produkCabangsPaginated->firstItem() ?? 0 }} - {{ $produkCabangsPaginated->lastItem() ?? 0 }} dari {{ $produkCabangsPaginated->total() }} produk</span>
            <div class="pagination-links-styled">
                {{ $produkCabangsPaginated->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>

@include('admin-cabang.modal.tambah-produk')

@endsection

@push('scripts')
<script src="{{ asset('js/admin-cabang.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    const rootStyle = getComputedStyle(document.documentElement);
    const bormaPrimary = rootStyle.getPropertyValue('--borma-primary').trim() || '#33116C';
    const bormaSecondary = rootStyle.getPropertyValue('--borma-secondary').trim() || '#FED50B';
    const bormaTertiary = rootStyle.getPropertyValue('--borma-tertiary').trim() || '#EB3B02';

    const isDark = document.documentElement.classList.contains('dark');
    const textColor = isDark ? 'rgba(255, 255, 255, 0.7)' : '#6B7280';
    const gridColor = isDark ? 'rgba(255, 255, 255, 0.08)' : 'rgba(0,0,0,0.04)';

    const kategoriLabels = @json($chartKategoriLabels);
    const kategoriStok   = @json($chartKategoriStok);
    const kategoriSku    = @json($chartKategoriSku);

    const colors = [
        bormaPrimary, bormaSecondary, bormaTertiary, '#6366F1',
        '#10B981', '#F59E0B', '#3B82F6', '#EC4899'
    ];

    const ctx = document.getElementById('kategoriStokChart');
    if (!ctx) return;

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: kategoriLabels.length ? kategoriLabels : ['Belum ada data'],
            datasets: [{
                label: 'Total Stok',
                data: kategoriStok.length ? kategoriStok : [0],
                backgroundColor: colors.slice(0, kategoriLabels.length),
                borderRadius: 8,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        title: (items) => items[0].label,
                        label: (ctx) => {
                            const idx = ctx.dataIndex;
                            return [
                                ' Stok: ' + ctx.parsed.y.toLocaleString('id-ID') + ' unit',
                                ' SKU : ' + (kategoriSku[idx] ?? 0) + ' produk'
                            ];
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: gridColor },
                    ticks: {
                        font: { size: 11, weight: '700' },
                        color: textColor
                    }
                },
                x: {
                    grid: { display: false },
                    ticks: {
                        display: false,
                        font: { size: 11, weight: '700' },
                        color: textColor
                    }
                }
            }
        }
    });

});
</script>
@endpush