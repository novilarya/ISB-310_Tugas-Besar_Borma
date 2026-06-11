@extends('driver.layouts.app')

@section('title', 'Daftar Tugas')
@section('header_sub', 'Daftar Tugas')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/driver/tugas-index.css') }}">
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
    <div class="task-item {{ $pesanan->status_pesanan == 'mencari_driver' ? 'status-pending' : ($pesanan->status_pesanan == 'dalam_pengiriman' ? 'status-dalam-pengiriman' : '') }}" id="task-{{ $pesanan->id_pesanan }}">
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
