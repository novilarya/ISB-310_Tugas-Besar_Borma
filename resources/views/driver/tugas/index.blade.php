@extends('driver.layouts.app')

@section('title', 'Daftar Tugas')
@section('header_sub', 'Daftar Tugas')

@push('styles')
<style>
    /* ================================================
       PAGE HEADING
    ================================================ */
    .page-heading {
        margin-bottom: 24px;
    }

    .page-heading h1 {
        font-family: var(--font-headline);
        font-size: 28px;
        font-weight: 800;
        color: var(--color-neutral);
        text-transform: uppercase;
        line-height: 1.15;
        margin-bottom: 4px;
    }

    .page-heading p {
        font-family: var(--font-body);
        font-size: 13px;
        color: var(--color-text-muted);
    }

    /* ================================================
       FILTER TABS
    ================================================ */
    .filter-tabs {
        display: flex;
        gap: 8px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }

    .filter-tab {
        font-family: var(--font-body);
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        padding: 8px 18px;
        border-radius: 100px;
        border: 1.5px solid var(--color-border);
        background: var(--color-surface);
        color: var(--color-neutral-soft);
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
    }

    .filter-tab:hover {
        border-color: var(--color-primary);
        color: var(--color-primary);
    }

    .filter-tab.active {
        background: var(--color-primary);
        border-color: var(--color-primary);
        color: white;
    }

    /* ================================================
       TASK LIST
    ================================================ */
    .task-list {
        display: flex;
        flex-direction: column;
        gap: 14px;
    }

    .task-item {
        background: var(--color-surface);
        border-radius: var(--radius-md);
        border: 1.5px solid var(--color-border);
        padding: 18px;
        box-shadow: var(--shadow-card);
        border-left: 4px solid var(--color-primary);
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .task-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 24px rgba(51, 17, 108, 0.12);
    }

    .task-item.status-pending {
        border-left-color: var(--color-secondary);
    }

    .task-item.status-dalam-pengiriman {
        border-left-color: #22c55e;
    }

    .task-item-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        margin-bottom: 10px;
    }

    .task-order-id {
        font-family: var(--font-body);
        font-size: 10px;
        font-weight: 600;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: var(--color-text-muted);
        margin-bottom: 2px;
    }

    .task-order-name {
        font-family: var(--font-headline);
        font-size: 16px;
        font-weight: 700;
        color: var(--color-neutral);
    }

    .task-status-badge {
        font-family: var(--font-body);
        font-size: 9px;
        font-weight: 700;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        padding: 4px 10px;
        border-radius: 100px;
        white-space: nowrap;
    }

    .badge-pending {
        background: var(--color-secondary);
        color: var(--color-neutral);
    }

    .badge-diterima {
        background: #dcfce7;
        color: #166534;
    }

    .badge-diambil {
        background: var(--color-primary-pale);
        color: var(--color-primary);
    }

    .badge-pengiriman {
        background: var(--color-primary);
        color: white;
    }

    .task-meta-row {
        display: flex;
        flex-direction: column;
        gap: 6px;
        margin-bottom: 14px;
    }

    .task-meta-detail {
        display: flex;
        align-items: center;
        gap: 8px;
        font-family: var(--font-body);
        font-size: 12px;
        color: var(--color-neutral-soft);
    }

    .task-meta-detail i {
        font-size: 14px;
        color: var(--color-primary);
        width: 16px;
        text-align: center;
    }

    .btn-detail {
        display: block;
        width: 100%;
        text-align: center;
        padding: 12px;
        background: var(--color-bg);
        border: 1.5px solid var(--color-border);
        border-radius: var(--radius-sm);
        font-family: var(--font-headline);
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: var(--color-neutral);
        text-decoration: none;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-detail:hover {
        background: var(--color-primary);
        border-color: var(--color-primary);
        color: white;
    }

    /* ================================================
       EMPTY STATE
    ================================================ */
    .empty-state {
        text-align: center;
        padding: 48px 20px;
    }

    .empty-state i {
        font-size: 48px;
        color: var(--color-border);
        display: block;
        margin-bottom: 12px;
    }

    .empty-state p {
        font-family: var(--font-body);
        font-size: 14px;
        color: var(--color-text-muted);
    }

    /* ================================================
       ANIMATION
    ================================================ */
    .fade-up {
        opacity: 0;
        transform: translateY(20px);
        animation: fadeUp 0.5s ease forwards;
    }

    @keyframes fadeUp {
        to { opacity: 1; transform: translateY(0); }
    }

    .delay-1 { animation-delay: 0.05s; }
    .delay-2 { animation-delay: 0.12s; }
    .delay-3 { animation-delay: 0.20s; }
</style>
@endpush

@section('content')

{{-- ===== HEADING ===== --}}
<div class="page-heading fade-up">
    <h1>Daftar Tugas</h1>
    <p>Pengiriman aktif yang ditugaskan kepada Anda.</p>
</div>

{{-- ===== FILTER DROPDOWN ===== --}}
<div class="filter-dropdown fade-up delay-1" style="margin-bottom: 20px;">
    <select onchange="window.location.href=this.value" style="width: 100%; padding: 12px 16px; border-radius: 8px; border: 1.5px solid var(--color-border); background: var(--color-surface); font-family: var(--font-body); font-size: 13px; color: var(--color-neutral); outline: none; cursor: pointer;">
        <option value="{{ route('driver.tugas.index') }}" {{ !request('status') ? 'selected' : '' }}>Semua</option>
        <option value="{{ route('driver.tugas.index', ['status' => 'diterima_driver']) }}" {{ request('status') == 'diterima_driver' ? 'selected' : '' }}>Dikonfirmasi</option>
        <option value="{{ route('driver.tugas.index', ['status' => 'diambil']) }}" {{ request('status') == 'diambil' ? 'selected' : '' }}>Diambil</option>
        <option value="{{ route('driver.tugas.index', ['status' => 'dalam_pengiriman']) }}" {{ request('status') == 'dalam_pengiriman' ? 'selected' : '' }}>Dalam Pengiriman</option>
    </select>
</div>

{{-- ===== TASK LIST ===== --}}
<div class="task-list fade-up delay-2">
    @forelse($tugas as $index => $pesanan)
    <div class="task-item {{ $pesanan->status_pesanan == 'pending' ? 'status-pending' : ($pesanan->status_pesanan == 'dalam_pengiriman' ? 'status-dalam-pengiriman' : '') }}" id="task-{{ $pesanan->id_pesanan }}">
        <div class="task-item-header">
            <div>
                <p class="task-order-id">Order ID</p>
                <p class="task-order-name">#BRM-{{ $pesanan->id_pesanan }}</p>
            </div>
            <span class="task-status-badge
                @if($pesanan->status_pesanan == 'dalam_pengiriman') badge-pengiriman
                @elseif($pesanan->status_pesanan == 'diambil') badge-diambil
                @elseif($pesanan->status_pesanan == 'diterima_driver') badge-diterima
                @else badge-pending
                @endif">
                {{ strtoupper(str_replace('_', ' ', $pesanan->status_pesanan)) }}
            </span>
        </div>

        <div class="task-meta-row">
            <div class="task-meta-detail">
                <i class="bi bi-person"></i>
                <span>{{ $pesanan->pelanggan->user->nama ?? 'Pelanggan' }}</span>
            </div>
            <div class="task-meta-detail">
                <i class="bi bi-geo-alt"></i>
                <span>{{ Str::limit($pesanan->alamat_pengiriman, 45) }}</span>
            </div>
            <div class="task-meta-detail">
                <i class="bi bi-clock"></i>
                <span>Estimasi: {{ $pesanan->estimasi_tiba ? \Carbon\Carbon::parse($pesanan->estimasi_tiba)->format('H:i') . ' WIB' : 'Menunggu' }}</span>
            </div>
        </div>

        <a href="{{ route('driver.tugas.show', $pesanan->id_pesanan) }}" class="btn-detail">
            Lihat Detail
        </a>
    </div>
    @empty
    <div class="empty-state">
        <i class="bi bi-inbox"></i>
        <p>Belum ada tugas aktif saat ini.</p>
    </div>
    @endforelse
</div>

@endsection
