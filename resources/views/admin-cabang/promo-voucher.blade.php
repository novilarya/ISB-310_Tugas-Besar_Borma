@extends('admin-cabang.layouts.admin-cabang')
@section('title', 'Promo & Voucher - Borma Toserba')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin-cabang.css') }}">
@endpush

@section('content')
{{-- Header --}}
<div class="d-flex justify-content-between align-items-end mb-4">
    <div class="page-header-text">
        <h1 class="page-title mb-2">Promo & Voucher</h1>
        <p class="page-subtitle text-muted m-0">Kelola kampanye diskon dan kode voucher untuk cabang Anda.</p>
    </div>
    <button class="btn-primary-custom" data-bs-toggle="modal" data-bs-target="#tambahPromoModal">
        <i class="bi bi-plus-lg me-2"></i> Buat Promo Baru
    </button>
</div>


@if($errors->any())
<div class="alert alert-danger alert-dismissible fade show" style="border-radius:12px;border:none;font-weight:600;">
    <i class="bi bi-x-circle-fill me-2"></i> {{ $errors->first() }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

{{-- KPI Cards --}}
<div class="row g-4 mb-5">
    <div class="col-md-4">
        <div class="glass-card kpi-card-interactive hover-primary">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div class="kpi-title text-primary-custom">Promo Aktif</div>
                <div class="icon-box bg-primary-light"><i class="bi bi-ticket-perforated"></i></div>
            </div>
            <div class="kpi-value" style="color:var(--borma-primary);">{{ $totalAktif }}</div>
            <p class="text-muted mt-2 mb-0" style="font-size:0.8rem;font-weight:600;">Sedang berjalan</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="glass-card kpi-card-interactive hover-secondary">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div class="kpi-title">Terjadwal</div>
                <div class="icon-box bg-secondary-light"><i class="bi bi-calendar-event-fill"></i></div>
            </div>
            <div class="kpi-value">{{ $totalTerjadwal }}</div>
            <p class="text-muted mt-2 mb-0" style="font-size:0.8rem;font-weight:600;">Akan datang</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="glass-card kpi-card-interactive hover-tertiary">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div class="kpi-title text-tertiary-custom">Berakhir</div>
                <div class="icon-box bg-tertiary-light"><i class="bi bi-archive-fill"></i></div>
            </div>
            <div class="kpi-value" style="color:var(--borma-tertiary);">{{ $totalBerakhir }}</div>
            <p class="text-muted mt-2 mb-0" style="font-size:0.8rem;font-weight:600;">Sudah habis masa berlaku</p>
        </div>
    </div>
</div>

{{-- Filter Bar --}}
<div class="mb-5">
    <div class="glass-card mb-4" style="padding: 16px 24px;">
        <form action="{{ route('admin-cabang.promo') }}" method="GET" class="row g-3 w-100 align-items-center m-0">
            <div class="col-md-7 ps-0">
                <div class="search-input w-100">
                    <i class="bi bi-search"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama promo atau kode voucher..." class="w-100">
                </div>
            </div>
            <div class="col-md-4">
                <select name="status" class="form-select filter-select-lg w-100" onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    <option value="aktif" {{ request('status')=='aktif'?'selected':'' }}>Aktif</option>
                    <option value="terjadwal" {{ request('status')=='terjadwal'?'selected':'' }}>Terjadwal</option>
                    <option value="berakhir" {{ request('status')=='berakhir'?'selected':'' }}>Berakhir</option>
                </select>
            </div>
            <div class="col-md-1 pe-0 text-end">
                <a href="{{ route('admin-cabang.promo') }}" class="btn-action btn-action-outline w-100 d-flex justify-content-center align-items-center" style="height: 42px;" title="Reset Filter">
                    <i class="bi bi-arrow-counterclockwise"></i>
                </a>
            </div>
        </form>
    </div>
</div>

{{-- Table --}}
<div class="table-produk">
    <table>
        <thead>
            <tr>
                <th>
                    <a href="{{ request()->fullUrlWithQuery(['sort'=>'nama_voucher','direction'=>request('sort')=='nama_voucher'&&request('direction')=='asc'?'desc':'asc']) }}" class="text-primary-custom text-decoration-none">
                        Nama Promo @if(request('sort')=='nama_voucher')<i class="bi bi-sort-{{ request('direction')=='asc'?'up':'down' }}"></i>@else<i class="bi bi-arrow-down-up text-muted" style="font-size:.7rem;"></i>@endif
                    </a>
                </th>
                <th>
                    <a href="{{ request()->fullUrlWithQuery(['sort'=>'potongan_harga','direction'=>request('sort')=='potongan_harga'&&request('direction')=='asc'?'desc':'asc']) }}" class="text-primary-custom text-decoration-none">
                        Potongan @if(request('sort')=='potongan_harga')<i class="bi bi-sort-{{ request('direction')=='asc'?'up':'down' }}"></i>@else<i class="bi bi-arrow-down-up text-muted" style="font-size:.7rem;"></i>@endif
                    </a>
                </th>
                <th>
                    <a href="{{ request()->fullUrlWithQuery(['sort'=>'tanggal_berakhir','direction'=>request('sort')=='tanggal_berakhir'&&request('direction')=='asc'?'desc':'asc']) }}" class="text-primary-custom text-decoration-none">
                        Periode @if(request('sort')=='tanggal_berakhir')<i class="bi bi-sort-{{ request('direction')=='asc'?'up':'down' }}"></i>@else<i class="bi bi-arrow-down-up text-muted" style="font-size:.7rem;"></i>@endif
                    </a>
                </th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($promos as $promo)
            @php
                $st = $promo->statusPromo();
                $sisa = $promo->sisaHari();
            @endphp
            <tr>
                <td>
                    <div style="font-weight:800;">
                        <a href="{{ route('admin-cabang.promo.detail', $promo->id_promo) }}" class="text-decoration-none" style="color: var(--borma-neutral); font-weight:800; transition: color 0.2s;" onmouseover="this.style.color='var(--borma-primary)'" onmouseout="this.style.color='var(--borma-neutral)'">
                            {{ $promo->nama_voucher }}
                        </a>
                    </div>
                    @if($promo->kode_voucher)
                        <div class="text-muted" style="font-size:.75rem;"><i class="bi bi-tag-fill me-1"></i>{{ $promo->kode_voucher }}</div>
                    @endif
                </td>
                <td>
                    <div style="font-weight:800;color:var(--borma-tertiary);font-size:1rem;">Rp {{ number_format($promo->potongan_harga, 0, ',', '.') }}</div>
                </td>
                <td>
                    <div style="font-size:.8rem;font-weight:700;">{{ $promo->tanggal_mulai->format('d M Y') }}</div>
                    <div class="text-muted" style="font-size:.75rem;">s/d {{ $promo->tanggal_berakhir->format('d M Y') }}</div>
                </td>
                <td>
                    @if($st === 'aktif')
                        <span class="status-badge-modern status-selesai">Aktif</span>
                    @elseif($st === 'terjadwal')
                        <span class="status-badge-modern status-pending">Terjadwal</span>
                    @else
                        <span class="status-badge-modern status-disabled" style="background:#F3F4F6;color:#6B7280;border:1px solid #E5E7EB;">Berakhir</span>
                    @endif
                </td>
                <td>
                    <div style="display:flex;gap:6px;align-items:center;">
                        <button class="btn-icon-member btn-edit-promo-trigger" title="Edit Promo" data-bs-toggle="modal" data-bs-target="#editPromoModal"
                            data-id="{{ $promo->id_promo }}"
                            data-action="{{ route('admin-cabang.promo.update', $promo->id_promo) }}"
                            data-nama="{{ $promo->nama_voucher }}"
                            data-kode="{{ $promo->kode_voucher }}"
                            data-pemicu="{{ $promo->id_produk_pemicu }}"
                            data-hadiah="{{ $promo->id_produk_hadiah }}"
                            data-qty-pemicu="{{ $promo->kuantitas_pemicu }}"
                            data-qty-hadiah="{{ $promo->kuantitas_hadiah }}"
                            data-potongan="{{ $promo->potongan_harga }}"
                            data-min="{{ $promo->min_transaksi }}"
                            data-max="{{ $promo->max_promo }}"
                            data-kuota="{{ $promo->kuota_promo }}"
                            data-mulai="{{ $promo->tanggal_mulai->format('Y-m-d') }}"
                            data-berakhir="{{ $promo->tanggal_berakhir->format('Y-m-d') }}">
                            <i class="bi bi-pencil-square"></i>
                        </button>
                        {{-- Delete --}}
                        <form action="{{ route('admin-cabang.promo.delete', $promo->id_promo) }}" method="POST" class="d-inline"
                            onsubmit="return confirm('Hapus promo &quot;{{ $promo->nama_voucher }}&quot;?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-icon-member btn-delete-member" title="Hapus"><i class="bi bi-trash"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center py-5 text-muted">
                    <i class="bi bi-tags" style="font-size:3rem;opacity:.2;"></i>
                    <p class="mt-3 mb-0" style="font-weight:600;">Belum ada data promo.</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="pagination-custom mt-4 mb-2 px-3">
        <span class="text-muted me-auto pagination-info">
            Menampilkan {{ $promos->firstItem() ?? 0 }} – {{ $promos->lastItem() ?? 0 }} dari {{ $promos->total() }} promo
        </span>
        <div class="pagination-links-styled">
            {{ $promos->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>


@include('admin-cabang.modal.promo')

@push('scripts')
<script src="{{ asset('js/admin-cabang/promo.js') }}"></script>
@endpush
@endsection
