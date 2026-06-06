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

{{-- ===== FILTER TABS ===== --}}
<div class="filter-tabs fade-up delay-1">
    <a href="{{ route('driver.tugas.index') }}"
       class="filter-tab {{ !request('status') ? 'active' : '' }}">Semua</a>
    <a href="{{ route('driver.tugas.index', ['status' => 'mencari_driver']) }}"
       class="filter-tab {{ request('status') == 'mencari_driver' ? 'active' : '' }}">Mencari Driver</a>
    <a href="{{ route('driver.tugas.index', ['status' => 'diterima_driver']) }}"
       class="filter-tab {{ request('status') == 'diterima_driver' ? 'active' : '' }}">Dikonfirmasi</a>
    <a href="{{ route('driver.tugas.index', ['status' => 'diambil']) }}"
       class="filter-tab {{ request('status') == 'diambil' ? 'active' : '' }}">Diambil</a>
    <a href="{{ route('driver.tugas.index', ['status' => 'dalam_pengiriman']) }}"
       class="filter-tab {{ request('status') == 'dalam_pengiriman' ? 'active' : '' }}">Dalam Pengiriman</a>
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
