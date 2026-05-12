@extends('layouts.admin-cabang')

@section('title', 'Detail Produk - Borma Toserba')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin-cabang.css') }}">
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
@endpush

@section('content')
<!-- Header dengan Tombol Kembali -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div class="d-flex align-items-center gap-3">
        <a href="{{ route('admin-cabang.produk') }}" class="btn-action btn-action-outline btn-action-sm">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
        <div>
            <h1 class="page-title m-0">Detail Produk</h1>
            <p class="page-subtitle">ID Cabang: {{ $produkCabang->id_produk_cabang }} &bull; {{ $produkCabang->produk->kategori }}</p>
        </div>
    </div>
    <div class="d-flex gap-3">
        <form action="{{ route('admin-cabang.produk.delete', $produkCabang->id_produk_cabang) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus produk ini dari cabang?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-action btn-action-outline text-danger border-danger"><i class="bi bi-trash me-2"></i> Hapus Produk</button>
        </form>
        <button class="btn-action btn-action-primary" data-bs-toggle="modal" data-bs-target="#editProdukModal"><i class="bi bi-pencil-square me-2"></i> Edit Informasi</button>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show mb-4" role="alert" style="border-radius: 12px; border: none; font-weight: 600;">
    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show mb-4" role="alert" style="border-radius: 12px; border: none; font-weight: 600;">
    <i class="bi bi-x-circle-fill me-2"></i> {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="row g-4">
    <!-- Kolom Kiri: Informasi Utama & Gambar -->
    <div class="col-lg-8">
        <!-- Riwayat Perubahan Harga (Paling atas) -->
        <div class="glass-card mb-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h6 class="kpi-title m-0">Riwayat Perubahan Harga</h6>
                <i class="bi bi-clock-history text-muted" style="font-size: 1.2rem;"></i>
            </div>
            <div class="table-responsive">
                <table class="table table-hover" style="font-size: 0.85rem; margin-bottom: 0;">
                    <thead>
                        <tr style="background: rgba(0,0,0,0.02);">
                            <th class="text-muted" style="font-weight: 700; border-bottom: 2px solid #E5E7EB;">Waktu</th>
                            <th class="text-muted" style="font-weight: 700; border-bottom: 2px solid #E5E7EB;">Harga Reguler</th>
                            <th class="text-muted" style="font-weight: 700; border-bottom: 2px solid #E5E7EB;">Harga Member</th>
                            <th class="text-muted" style="font-weight: 700; border-bottom: 2px solid #E5E7EB;">Admin</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($riwayatHarga->take(5) as $riwayat)
                        <tr>
                            <td style="font-weight: 600; color: var(--borma-neutral);">{{ \Carbon\Carbon::parse($riwayat->created_at)->format('d M Y, H:i') }}</td>
                            <td><strong style="color: var(--borma-neutral);">Rp {{ number_format($riwayat->harga_reguler_baru, 0, ',', '.') }}</strong></td>
                            <td><strong class="text-tertiary-custom">Rp {{ number_format($riwayat->harga_member_baru, 0, ',', '.') }}</strong></td>
                            <td class="text-muted"><i class="bi bi-person-circle me-1"></i> {{ $riwayat->admin }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center text-muted py-3">Belum ada riwayat perubahan harga.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <!-- Pagination UI -->
            <div class="d-flex justify-content-between align-items-center mt-3 pt-3" style="border-top: 1px dashed #E5E7EB;">
                <span class="text-muted" style="font-size: 0.8rem;">Menampilkan {{ min(5, $riwayatHarga->count()) }} dari {{ $riwayatHarga->count() }} data</span>
                <div class="d-flex gap-1">
                    <button class="btn-action btn-action-outline btn-action-sm disabled" style="padding: 4px 8px;"><i class="bi bi-chevron-left"></i></button>
                    <button class="btn-action btn-action-primary btn-action-sm" style="padding: 4px 10px;">1</button>
                    <button class="btn-action btn-action-outline btn-action-sm disabled" style="padding: 4px 8px;"><i class="bi bi-chevron-right"></i></button>
                </div>
            </div>
        </div>

        <!-- Informasi Utama & Gambar -->
        <div class="glass-card mb-4" style="padding: 32px;">
            <div class="row g-4">
                <div class="col-md-5">
                    <div style="background: #F9FAFB; border-radius: 16px; border: 1px dashed #D1D5DB; aspect-ratio: 1/1; display: flex; align-items: center; justify-content: center; position: relative; overflow: hidden;">
                        @if($produkCabang->produk->gambar_produk && $produkCabang->produk->gambar_produk !== 'default.jpg')
                            <img src="{{ Storage::url($produkCabang->produk->gambar_produk) }}" alt="{{ $produkCabang->produk->nama_produk }}" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <i class="bi bi-image text-muted" style="font-size: 4rem; opacity: 0.2;"></i>
                        @endif
                        <div class="status-badge" style="position: absolute; top: 16px; right: 16px; background: {{ $produkCabang->jumlah_stok > 0 ? '#E8F5E9' : '#FFEBEE' }}; color: {{ $produkCabang->jumlah_stok > 0 ? '#2E7D32' : '#C62828' }}; padding: 4px 12px; border-radius: 8px; font-size: 0.75rem; font-weight: 700;">{{ $produkCabang->jumlah_stok > 0 ? 'TERSEDIA' : 'HABIS' }}</div>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="d-flex flex-column h-100 justify-content-center">
                        <div class="badge-modern badge-primary-custom mb-2 w-auto" style="display: inline-block; width: fit-content;">{{ $produkCabang->produk->kategori }}</div>
                        <h2 class="text-primary-custom" style="font-weight: 800; font-family: var(--font-heading); margin-bottom: 8px;">{{ $produkCabang->produk->nama_produk }}</h2>
                        <p class="text-muted mb-4" style="font-size: 0.95rem; line-height: 1.6;">{{ $produkCabang->produk->deskripsi }}</p>
                        
                        <div class="row g-3 mb-4">
                            <div class="col-6">
                                <div class="reward-card mb-0 h-100">
                                    <div>
                                        <div class="text-muted list-title-sm">Harga Reguler</div>
                                        <div class="harga-reguler text-muted mt-1">Rp {{ number_format($produkCabang->produk->harga_reguler, 0, ',', '.') }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="reward-card mb-0 h-100" style="background: rgba(235, 59, 2, 0.05); border: 1px solid rgba(235, 59, 2, 0.1);">
                                    <div>
                                        <div class="text-tertiary-custom list-title-sm">Harga Member</div>
                                        <div class="harga-member mt-1" style="font-size: 1.2rem; font-weight: 800;">Rp {{ number_format($produkCabang->produk->harga_member, 0, ',', '.') }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Spesifikasi Detail -->
        <div class="glass-card">
            <h6 class="kpi-title mb-4">Spesifikasi Detail</h6>
            <table class="table" style="font-size: 0.9rem;">
                <tbody>
                    <tr>
                        <td class="text-muted" style="width: 30%; font-weight: 600;">Nama Produk</td>
                        <td style="font-weight: 700; color: var(--borma-neutral);">{{ $produkCabang->produk->nama_produk }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted" style="width: 30%; font-weight: 600;">Kategori</td>
                        <td style="font-weight: 700; color: var(--borma-neutral);">{{ $produkCabang->produk->kategori }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted" style="width: 30%; font-weight: 600;">Cabang</td>
                        <td style="font-weight: 700; color: var(--borma-neutral);">{{ $produkCabang->cabang->nama_cabang ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted" style="width: 30%; font-weight: 600;">ID Produk Master</td>
                        <td style="font-weight: 700; color: var(--borma-neutral);">{{ $produkCabang->id_produk }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted" style="width: 30%; font-weight: 600; border-bottom: none;">Terakhir Diperbarui</td>
                        <td style="font-weight: 700; color: var(--borma-neutral); border-bottom: none;">{{ $produkCabang->produk->updated_at ? $produkCabang->produk->updated_at->format('d M Y, H:i') : '-' }} WIB</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Kolom Kanan: Status Stok & Analitik -->
    <div class="col-lg-4">
        <!-- Kartu Stok -->
        <div class="glass-card mb-4 kpi-card-interactive hover-primary">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h6 class="kpi-title m-0">Ketersediaan Stok</h6>
                <div class="icon-box-md icon-box-rounded bg-primary-light d-flex align-items-center justify-content-center">
                    <i class="bi bi-box-seam text-primary-custom icon-lg"></i>
                </div>
            </div>
            <div class="d-flex align-items-end gap-2 mb-3">
                <h2 class="kpi-value-lg m-0 text-primary-custom" style="font-weight: 800;">{{ $produkCabang->jumlah_stok }}</h2>
                <span class="text-muted pb-1" style="font-weight: 600;">Unit tersisa</span>
            </div>
            @php
                $maxStok = 300;
                $stokPercent = min(100, ($produkCabang->jumlah_stok / $maxStok) * 100);
                $stokStatus = $produkCabang->jumlah_stok > 50 ? 'Aman' : ($produkCabang->jumlah_stok > 20 ? 'Perlu Restok' : 'Kritis');
                $stokColor = $produkCabang->jumlah_stok > 50 ? 'text-success' : ($produkCabang->jumlah_stok > 20 ? 'text-warning' : 'text-danger');
            @endphp
            <div class="progress mb-3" style="height: 8px; border-radius: 4px; background: #E5E7EB;">
                <div class="progress-bar" style="width: {{ $stokPercent }}%; background: var(--borma-primary);"></div>
            </div>
            <p class="text-muted m-0" style="font-size: 0.8rem;">Status: <strong class="{{ $stokColor }}">{{ $stokStatus }}</strong> (Minimal stok: 20)</p>
        </div>

        <!-- Kartu Harga -->
        <div class="glass-card mb-4 kpi-card-interactive hover-secondary">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h6 class="kpi-title m-0">Informasi Harga</h6>
                <div class="icon-box-md icon-box-rounded bg-secondary-light d-flex align-items-center justify-content-center">
                    <i class="bi bi-currency-dollar text-secondary-custom icon-lg"></i>
                </div>
            </div>
            <div class="mb-3">
                <div class="text-muted" style="font-size: 0.8rem; font-weight: 600;">Harga Reguler</div>
                <h4 class="m-0 text-primary-custom" style="font-weight: 800;">Rp {{ number_format($produkCabang->produk->harga_reguler, 0, ',', '.') }}</h4>
            </div>
            <div>
                <div class="text-muted" style="font-size: 0.8rem; font-weight: 600;">Harga Member</div>
                <h4 class="m-0 text-tertiary-custom" style="font-weight: 800;">Rp {{ number_format($produkCabang->produk->harga_member, 0, ',', '.') }}</h4>
            </div>
            @php
                $selisih = $produkCabang->produk->harga_reguler - $produkCabang->produk->harga_member;
            @endphp
            <div class="mt-3 pt-3" style="border-top: 1px dashed #E5E7EB;">
                <small class="text-muted">Selisih: <strong class="text-success">Rp {{ number_format($selisih, 0, ',', '.') }}</strong> ({{ round(($selisih / $produkCabang->produk->harga_reguler) * 100, 1) }}% diskon member)</small>
            </div>
        </div>

        <!-- Kartu Aksi Cepat -->
        <div class="glass-card">
            <h6 class="kpi-title mb-3">Aksi Cepat</h6>
            <div class="d-grid gap-2">
                <button class="btn-action btn-action-primary w-100" data-bs-toggle="modal" data-bs-target="#editProdukModal">
                    <i class="bi bi-pencil-square me-2"></i> Edit Produk
                </button>
                <a href="{{ route('admin-cabang.produk') }}" class="btn-action btn-action-outline w-100 text-center">
                    <i class="bi bi-arrow-left me-2"></i> Kembali ke Daftar
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Produk -->
<div class="modal fade" id="editProdukModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content" style="border-radius: 20px; border: none; overflow: hidden; box-shadow: 0 10px 40px rgba(0,0,0,0.15);">
      <form action="{{ route('admin-cabang.produk.update', $produkCabang->id_produk_cabang) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="modal-header" style="background: var(--borma-primary); border: none; padding: 24px 32px;">
          <h5 class="modal-title fw-800" style="color: var(--borma-secondary); font-family: var(--font-heading);">
            <i class="bi bi-pencil-square me-2"></i> Edit Informasi Produk
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" style="padding: 32px;">
            <div class="row g-3">
                <div class="col-md-8">
                    <label class="modal-label">Nama Produk <span class="text-danger">*</span></label>
                    <input type="text" class="modal-input" name="nama_produk" required value="{{ $produkCabang->produk->nama_produk }}">
                </div>
                <div class="col-md-4">
                    <label class="modal-label">Kategori <span class="text-danger">*</span></label>
                    <select class="modal-input form-select" name="kategori" required style="cursor: pointer;">
                        <option value="Kebutuhan Pokok" {{ $produkCabang->produk->kategori == 'Kebutuhan Pokok' ? 'selected' : '' }}>Kebutuhan Pokok</option>
                        <option value="Minuman" {{ $produkCabang->produk->kategori == 'Minuman' ? 'selected' : '' }}>Minuman</option>
                        <option value="Snack" {{ $produkCabang->produk->kategori == 'Snack' ? 'selected' : '' }}>Snack</option>
                        <option value="Kebersihan" {{ $produkCabang->produk->kategori == 'Kebersihan' ? 'selected' : '' }}>Kebersihan</option>
                        <option value="Lain-lain" {{ $produkCabang->produk->kategori == 'Lain-lain' ? 'selected' : '' }}>Lain-lain</option>
                    </select>
                </div>
                <div class="col-12">
                    <label class="modal-label">Deskripsi Produk</label>
                    <textarea class="modal-input" name="deskripsi" rows="2">{{ $produkCabang->produk->deskripsi }}</textarea>
                </div>
                <div class="col-12">
                    <label class="modal-label">Gambar Produk Baru <small class="text-muted text-lowercase">(opsional)</small></label>
                    <input type="file" class="modal-input" name="gambar_produk" accept="image/*" style="padding: 8px 16px;">
                    <div class="form-text mt-1" style="font-size: 0.75rem;">Biarkan kosong jika tidak ingin mengubah gambar.</div>
                </div>
                <div class="col-md-4">
                    <label class="modal-label">Harga Reguler <span class="text-danger">*</span></label>
                    <input type="number" class="modal-input" name="harga_reguler" required value="{{ $produkCabang->produk->harga_reguler }}" id="editHargaReguler">
                </div>
                <div class="col-md-4">
                    <label class="modal-label">Harga Member</label>
                    <input type="number" class="modal-input" name="harga_member" value="{{ $produkCabang->produk->harga_member }}" id="editHargaMember">
                    <div class="form-text mt-1" style="font-size: 0.75rem;">Kosongkan = Reguler - Rp2.500</div>
                </div>
                <div class="col-md-4">
                    <label class="modal-label">Jumlah Stok <span class="text-danger">*</span></label>
                    <input type="number" class="modal-input" name="jumlah_stok" required value="{{ $produkCabang->jumlah_stok }}">
                </div>
            </div>
        </div>
        <div class="modal-footer" style="border: none; padding: 16px 32px 32px; gap: 12px;">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" style="border-radius: 10px; font-weight: 700; padding: 10px 24px;">Batal</button>
          <button type="submit" class="btn-primary-custom" style="padding: 10px 28px;">
            <i class="bi bi-check-lg me-1"></i> Simpan Perubahan
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
