@extends('layouts.admin-cabang')

@section('title', 'Manajemen Produk - Borma Toserba')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin-cabang.css') }}">
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
@endpush

@section('content')
<!-- Header -->
<div class="d-flex justify-content-between align-items-end mb-4">
    <div class="page-header-text">
        <h1 class="mb-2" class="page-title">Manajemen Produk</h1>
        <p class="text-muted m-0" class="page-subtitle">Kelola inventaris Borma Toserba secara efisien. Pantau stok, perbarui harga member, dan aktifkan status promosi dari satu dasbor pusat.</p>
    </div>
    <div>
        <button class="btn-primary-custom" data-bs-toggle="modal" data-bs-target="#tambahProdukModal"><i class="bi bi-plus-lg me-2"></i> Tambah Produk</button>
    </div>
</div>


@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 12px; border: none; font-weight: 600;">
  <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 12px; border: none; font-weight: 600;">
  <i class="bi bi-x-circle-fill me-2"></i> {{ session('error') }}
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

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

<!-- Main Table Area -->
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
                    <th>Harga Reguler</th>
                    <th>Harga Member</th>
                    <th>
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'terjual', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}" class="text-primary-custom text-decoration-none">
                            Terjual
                            @if(request('sort') == 'terjual')
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
                    <td><strong class="text-muted">{{ number_format($pc->terjual, 0, ',', '.') }}</strong> <span class="text-muted" style="font-size: 0.7rem;">Pcs</span></td>
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

<!-- Sekat Analisis Produk -->
<div class="d-flex justify-content-between align-items-center mt-5 mb-3">
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
                <div class="text-end d-flex flex-column align-items-end justify-content-center">
                    <h4 class="text-primary-custom mb-0" style="font-weight: 800; font-family: var(--font-heading);">{{ number_format($pc->period_sales, 0, ',', '.') }}</h4>
                    <span class="badge bg-light text-dark" style="font-size: 0.7rem; border: 1px solid #E5E7EB;">Terjual</span>
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
                <div class="analysis-card-title text-tertiary-custom m-0">
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
                <div class="text-end d-flex flex-column align-items-end justify-content-center">
                    <h4 class="text-tertiary-custom mb-0" style="font-weight: 800; font-family: var(--font-heading);">{{ number_format($pc->period_sales, 0, ',', '.') }}</h4>
                    <span class="badge bg-light text-dark" style="font-size: 0.7rem; border: 1px solid #E5E7EB;">Terjual</span>
                </div>
            </div>
            @empty
            <p class="text-muted text-center py-3">Belum ada data penjualan di periode ini.</p>
            @endforelse
        </div>
    </div>
</div>

<!-- Bottom Highlight Section -->
<div class="row mt-4 mb-5">
    <div class="col-12">
        <div class="glass-card">
            <div class="row g-4 align-items-start">

                {{-- Kolom Kiri: Chart Bar --}}
                <div class="col-lg-5">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="kpi-title m-0">Distribusi Stok per Kategori</h6>
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
                    <table class="table" style="font-size:0.83rem; margin-bottom:0;">
                        <thead>
                            <tr style="background:rgba(0,0,0,0.02);">
                                <th class="text-muted" style="font-weight:700; border-bottom:2px solid #E5E7EB;">Kategori</th>
                                <th class="text-muted text-center" style="font-weight:700; border-bottom:2px solid #E5E7EB;">SKU</th>
                                <th class="text-muted text-center" style="font-weight:700; border-bottom:2px solid #E5E7EB;">Total Stok</th>
                                <th class="text-muted text-center" style="font-weight:700; border-bottom:2px solid #E5E7EB;">Terjual</th>
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

<!-- Modal Tambah Produk -->
<div class="modal fade" id="tambahProdukModal" tabindex="-1" aria-labelledby="tambahProdukModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content" style="border-radius: 20px; border: none; overflow: hidden; box-shadow: 0 10px 40px rgba(0,0,0,0.15);">
      <form action="{{ route('admin-cabang.produk.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-header" style="background: var(--borma-primary); border: none; padding: 24px 32px;">
          <h5 class="modal-title fw-800" id="tambahProdukModalLabel" style="color: var(--borma-secondary); font-family: var(--font-heading);">
            <i class="bi bi-plus-circle-fill me-2"></i> Tambah Produk Baru
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" style="padding: 32px;">
            <div class="row g-3">
                <div class="col-md-8">
                    <label class="modal-label">Nama Produk <span class="text-danger">*</span></label>
                    <input type="text" class="modal-input" name="nama_produk" required placeholder="Contoh: Indomie Goreng">
                </div>
                <div class="col-md-4">
                    <label class="modal-label">Kategori <span class="text-danger">*</span></label>
                    <select class="modal-input form-select" name="kategori" required style="cursor: pointer;">
                        <option value="Kebutuhan Pokok">Kebutuhan Pokok</option>
                        <option value="Minuman">Minuman</option>
                        <option value="Snack">Snack</option>
                        <option value="Kebersihan">Kebersihan</option>
                        <option value="Lain-lain">Lain-lain</option>
                    </select>
                </div>
                <div class="col-12">
                    <label class="modal-label">Deskripsi Produk</label>
                    <textarea class="modal-input" name="deskripsi" rows="2" placeholder="Masukkan deskripsi singkat produk..."></textarea>
                </div>
                <div class="col-12">
                    <label class="modal-label">Gambar Produk <span class="text-muted">(Opsional)</span></label>
                    <input type="file" class="modal-input" name="gambar_produk" accept="image/*" style="padding: 8px 16px;">
                    <div class="form-text mt-1" style="font-size: 0.75rem;">Format: JPG, PNG, WebP. Maks. 2MB.</div>
                </div>
                <div class="col-md-4">
                    <label class="modal-label">Harga Reguler <span class="text-danger">*</span></label>
                    <input type="number" class="modal-input" name="harga_reguler" required placeholder="0" id="tambahHargaReguler">
                </div>
                <div class="col-md-4">
                    <label class="modal-label">Harga Member</label>
                    <input type="number" class="modal-input" name="harga_member" placeholder="Otomatis" id="tambahHargaMember">
                    <div class="form-text mt-1" style="font-size: 0.75rem;">Kosongkan = Reguler - Rp2.500</div>
                </div>
                <div class="col-md-4">
                    <label class="modal-label">Jumlah Stok <span class="text-danger">*</span></label>
                    <input type="number" class="modal-input" name="jumlah_stok" required placeholder="0">
                </div>
            </div>
        </div>
        <div class="modal-footer" style="border: none; padding: 16px 32px 32px; gap: 12px;">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" style="border-radius: 10px; font-weight: 700; padding: 10px 24px;">Batal</button>
          <button type="submit" class="btn-primary-custom" style="padding: 10px 28px;">
            <i class="bi bi-check-lg me-1"></i> Simpan Produk
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection

@push('scripts')
<script src="{{ asset('js/admin-cabang.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    const kategoriLabels = @json($chartKategoriLabels);
    const kategoriStok   = @json($chartKategoriStok);
    const kategoriSku    = @json($chartKategoriSku);

    const colors = [
        '#33116C', '#FED50B', '#EB3B02', '#6366F1',
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
                    grid: { color: 'rgba(0,0,0,0.04)' },
                    ticks: {
                        font: { size: 11, weight: '700' },
                        color: '#9CA3AF'
                    }
                },
                x: {
                    grid: { display: false },
                    ticks: {
                        font: { size: 11, weight: '700' },
                        color: '#6B7280'
                    }
                }
            }
        }
    });

});
</script>
@endpush