@extends('driver.layouts.app')

@section('title', 'Riwayat Pengiriman')
@section('header_sub', 'Riwayat Pengiriman')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/driver/riwayat-index.css') }}">
@endpush

@section('content')

{{-- ===== DRIVER INFO ===== --}}
@if($kurir)
<div class="driver-info-section fade-up" style="margin-bottom: 24px;">
    <p style="font-family: var(--font-body); font-size: 11px; font-weight: 600; letter-spacing: 0.14em; text-transform: uppercase; color: var(--color-text-muted); margin-bottom: 4px;">Driver Anda</p>
    <h2 style="font-family: var(--font-headline); font-size: 24px; font-weight: 800; color: var(--color-neutral); text-transform: uppercase; margin-bottom: 8px;">
        {{ strtoupper($kurir->user->nama ?? 'DRIVER') }}
    </h2>
    <p style="font-family: var(--font-body); font-size: 12px; font-weight: 600; letter-spacing: 0.1em; text-transform: uppercase; color: var(--color-text-muted);">
        Cabang: <span style="color: var(--color-primary);">{{ strtoupper($kurir->cabang->nama_cabang ?? 'Tidak Diketahui') }} — {{ $kurir->kode_driver ?? '-' }}</span>
    </p>
</div>
@endif

{{-- ===== HEADING ===== --}}
<div class="page-heading fade-up delay-1">
    <h1>Riwayat</h1>
    <p>Log aktivitas pengiriman selesai dan gagal.</p>
</div>

{{-- ===== FILTER TABS ===== --}}
<div class="filter-tabs fade-up delay-2">
    <a href="{{ route('driver.riwayat.index') }}"
       class="filter-tab {{ !request('status') ? 'active' : '' }}">Semua</a>
    <a href="{{ route('driver.riwayat.index', ['status' => 'diterima']) }}"
       class="filter-tab {{ request('status') == 'diterima' ? 'active' : '' }}">Diterima</a>
    <a href="{{ route('driver.riwayat.index', ['status' => 'gagal']) }}"
       class="filter-tab {{ request('status') == 'gagal' ? 'active' : '' }}">Gagal Kirim</a>
    <a href="{{ route('driver.riwayat.index', ['status' => 'ditolak_driver']) }}"
       class="filter-tab {{ request('status') == 'ditolak_driver' ? 'active' : '' }}">Ditolak</a>
</div>

{{-- ===== RIWAYAT LIST ===== --}}
<div class="riwayat-list fade-up delay-3">
    @forelse($riwayat as $pesanan)
    <div class="riwayat-item {{ in_array($pesanan->status_pesanan, ['gagal', 'ditolak_driver']) ? 'gagal' : '' }}" id="riwayat-{{ $pesanan->id_pesanan }}">
        <div class="riwayat-item-header">
            <div>
                <p class="riwayat-order-id">Order ID</p>
                <p class="riwayat-order-name">#BM-{{ $pesanan->id_pesanan }}</p>
            </div>
            <span class="riwayat-badge {{ in_array($pesanan->status_pesanan, ['gagal', 'ditolak_driver']) ? 'badge-gagal' : 'badge-diterima' }}">
                {{ strtoupper(str_replace('_', ' ', $pesanan->status_pesanan)) }}
            </span>
        </div>

        <div class="riwayat-meta">
            <div class="riwayat-meta-detail">
                <i class="bi bi-person"></i>
                <span>{{ $pesanan->pelanggan->user->nama ?? 'Pelanggan' }}</span>
            </div>
            <div class="riwayat-meta-detail">
                <i class="bi bi-calendar3"></i>
                <span>{{ \Carbon\Carbon::parse($pesanan->tanggal_pemesanan)->translatedFormat('d M Y, H:i') }}</span>
            </div>
        </div>

        @if(in_array($pesanan->status_pesanan, ['gagal', 'ditolak_driver']))
        <div class="riwayat-reason">
            @if($pesanan->status_pesanan == 'gagal' && $pesanan->alasan_gagal)
            <p>Alasan: {{ $pesanan->alasan_gagal }}</p>
            @elseif($pesanan->status_pesanan == 'ditolak_driver' && $pesanan->penolakanPengiriman)
            <p>Alasan: {{ $pesanan->penolakanPengiriman->alasan }}</p>
            @endif
        </div>
        @endif

        <a href="{{ route('driver.pengiriman.detail', $pesanan->id_pesanan) }}" class="btn-detail">
            Lihat Detail
        </a>
    </div>
    @empty
    <div class="empty-state">
        <i class="bi bi-clock-history"></i>
        <p>Belum ada riwayat pengiriman.</p>
    </div>
    @endforelse
</div>

{{-- ===== SKELETON (contoh loading state) ===== --}}
@if(isset($loading) && $loading)
<div class="riwayat-list" style="margin-top: 14px;">
    @for($i = 0; $i < 2; $i++)
    <div class="skeleton-card">
        <div class="skeleton-line w-40"></div>
        <div class="skeleton-line w-60"></div>
        <div class="skeleton-line w-80"></div>
        <div class="skeleton-line w-100" style="height: 40px; margin-bottom: 0;"></div>
    </div>
    @endfor
</div>
@endif

@endsection
