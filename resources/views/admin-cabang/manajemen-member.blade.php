@extends('admin-cabang.layouts.admin-cabang')

@section('title', 'Manajemen Member - Borma Toserba')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin-cabang.css') }}">
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
@endpush

@section('content')

{{-- Page Header --}}
<div class="d-flex justify-content-between align-items-end mb-4">
    <div class="page-header-text">
        <h1 class="mb-2 page-title">Manajemen Member</h1>
        <p class="m-0 page-subtitle">Kelola data pelanggan setia Borma. Tambah, ubah status member, dan pantau poin reward.</p>
    </div>
    <button class="btn-primary-custom" data-bs-toggle="modal" data-bs-target="#tambahMemberModal">
        <i class="bi bi-person-plus-fill me-2"></i> Tambah Member
    </button>
</div>

{{-- Alert --}}
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 12px; border: none; font-weight: 600;">
    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif
@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 12px; border: none; font-weight: 600;">
    <i class="bi bi-x-circle-fill me-2"></i> {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

{{-- KPI Cards --}}
<div class="row g-4 mb-5">
    <div class="col-md-4">
        <div class="glass-card kpi-card-interactive hover-primary">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div class="kpi-title text-primary-custom">Total Member Aktif</div>
                <div class="icon-box bg-primary-light"><i class="bi bi-people-fill"></i></div>
            </div>
            <div class="kpi-value" style="color: var(--borma-primary);">{{ number_format($totalMember, 0, ',', '.') }}</div>
            <p class="text-muted mt-2 mb-0" style="font-size: 0.8rem; font-weight: 600;">
                 Pelanggan berlangganan aktif
            </p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="glass-card kpi-card-interactive hover-secondary">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div class="kpi-title">Poin Terkumpul</div>
                <div class="icon-box bg-secondary-light"><i class="bi bi-star-fill"></i></div>
            </div>
            <div class="kpi-value">{{ number_format($totalPoin, 0, ',', '.') }}</div>
            <p class="text-muted mt-2 mb-0" style="font-size: 0.8rem; font-weight: 600;">
              Total poin seluruh member
            </p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="glass-card kpi-card-interactive hover-tertiary">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div class="kpi-title text-tertiary-custom">Non Member</div>
                <div class="icon-box bg-tertiary-light"><i class="bi bi-person-dash-fill"></i></div>
            </div>
            <div class="kpi-value" style="color: var(--borma-tertiary);">{{ number_format($totalNonMember, 0, ',', '.') }}</div>
            <p class="text-muted mt-2 mb-0" style="font-size: 0.8rem; font-weight: 600;">
               Pelanggan biasa
            </p>
        </div>
    </div>
</div>

{{-- Filter Bar --}}
<div class="mb-5">
    <div class="glass-card mb-4" style="padding: 16px 24px;">
        <form action="{{ route('admin-cabang.member') }}" method="GET" id="filterMemberForm" class="row g-3 w-100 align-items-center m-0">
            <div class="col-md-7 ps-0">
                <div class="search-input w-100">
                    <i class="bi bi-search"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, email, atau no. telepon..." class="w-100">
                </div>
            </div>
            <div class="col-md-4">
                <select name="status" class="form-select filter-select-lg w-100" onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    <option value="member" {{ request('status') == 'member' ? 'selected' : '' }}>Member Aktif</option>
                    <option value="non-member" {{ request('status') == 'non-member' ? 'selected' : '' }}>Non Member</option>
                </select>
            </div>
            <div class="col-md-1 pe-0 text-end">
                <a href="{{ route('admin-cabang.member') }}" class="btn-action btn-action-outline w-100 d-flex justify-content-center align-items-center" style="height: 42px;" title="Reset Filter">
                    <i class="bi bi-arrow-counterclockwise"></i>
                </a>
            </div>
        </form>
    </div>
</div>

{{-- Member Table --}}
<div class="table-produk">
    <table>
        <thead>
            <tr>
                <th>
                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'nama', 'direction' => request('sort') == 'nama' && request('direction') == 'asc' ? 'desc' : 'asc']) }}" class="text-primary-custom text-decoration-none">
                        Nama Member
                        @if(request('sort') == 'nama') <i class="bi bi-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }}"></i>
                        @else <i class="bi bi-arrow-down-up text-muted" style="font-size:0.7rem;"></i> @endif
                    </a>
                </th>
                <th>Kontak</th>
                <th>Alamat</th>
                <th>
                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'poin_member', 'direction' => request('sort') == 'poin_member' && request('direction') == 'asc' ? 'desc' : 'asc']) }}" class="text-primary-custom text-decoration-none">
                        Poin
                        @if(request('sort') == 'poin_member') <i class="bi bi-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }}"></i>
                        @else <i class="bi bi-arrow-down-up text-muted" style="font-size:0.7rem;"></i> @endif
                    </a>
                </th>
                <th>
                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'status_member', 'direction' => request('sort') == 'status_member' && request('direction') == 'asc' ? 'desc' : 'asc']) }}" class="text-primary-custom text-decoration-none">
                        Status
                        @if(request('sort') == 'status_member') <i class="bi bi-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }}"></i>
                        @else <i class="bi bi-arrow-down-up text-muted" style="font-size:0.7rem;"></i> @endif
                    </a>
                </th>
                <th>
                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'created_at', 'direction' => request('sort') == 'created_at' && request('direction') == 'asc' ? 'desc' : 'asc']) }}" class="text-primary-custom text-decoration-none">
                        Bergabung
                        @if(request('sort') == 'created_at') <i class="bi bi-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }}"></i>
                        @else <i class="bi bi-arrow-down-up text-muted" style="font-size:0.7rem;"></i> @endif
                    </a>
                </th>
            </tr>
        </thead>
        <tbody>
            @forelse($members as $member)
            <tr>
                <td>
                    <div class="d-flex align-items-center gap-3">
                        <div style="width:40px; height:40px; border-radius:50%; background: linear-gradient(135deg, var(--borma-primary), #5a2b9e); display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                            <span style="color: var(--borma-secondary); font-weight:800; font-size:1rem;">{{ strtoupper(substr($member->user->nama ?? '?', 0, 1)) }}</span>
                        </div>
                        <div>
                            <div style="font-weight:800; color: var(--borma-neutral);">{{ $member->user->nama ?? '-' }}</div>
                            <div class="text-muted" style="font-size:0.78rem;">{{ $member->user->email ?? '-' }}</div>
                        </div>
                    </div>
                </td>
                <td>
                    <div style="font-weight:700; font-size:0.85rem;">{{ $member->user->no_telepon ?? '-' }}</div>
                </td>
                <td>
                    <div class="text-muted" style="font-size:0.83rem; max-width:180px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;" title="{{ $member->alamat }}">
                        {{ $member->alamat ?? '-' }}
                    </div>
                </td>
                <td>
                    <div style="font-weight:800; font-size:1rem; color: var(--borma-primary);">{{ number_format($member->poin_member, 0, ',', '.') }}</div>
                    <div class="text-muted" style="font-size:0.72rem; font-weight:600;"></div>
                </td>
                <td>
                    @if($member->status_member)
                        <span class="status-badge-modern status-selesai">
                            Member Aktif
                        </span>
                    @else
                        <span class="status-badge-modern status-pending">
                            Non Member
                        </span>
                    @endif
                </td>
                <td>
                    <div class="text-muted" style="font-size:0.8rem; font-weight:600;">{{ \Carbon\Carbon::parse($member->created_at)->format('d M Y') }}</div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center py-5 text-muted">
                    <i class="bi bi-people" style="font-size:3rem; opacity:0.2;"></i>
                    <p class="mt-3 mb-0" style="font-weight:600;">Belum ada data member.</p>
                    @if(request('search') || request('status'))
                    <a href="{{ route('admin-cabang.member') }}" class="btn btn-sm mt-2" style="color: var(--borma-primary);">Reset filter</a>
                    @endif
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Pagination --}}
    <div class="pagination-custom mt-4 mb-2 px-3">
        <span class="text-muted me-auto pagination-info">
            Menampilkan {{ $members->firstItem() ?? 0 }} – {{ $members->lastItem() ?? 0 }} dari {{ $members->total() }} member
        </span>
        <div class="pagination-links-styled">
            {{ $members->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>


@include('admin-cabang.modal.tambah-member')


@endsection
