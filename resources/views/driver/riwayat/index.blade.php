@extends('driver.layouts.app')

@section('title', 'Riwayat Pengiriman')
@section('header_sub', 'Riwayat Pengiriman')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/driver/riwayat-index.css') }}">
@endpush

@section('content')


{{-- ===== HEADING ===== --}}
<div class="page-heading fade-up delay-1">
    <h1>Riwayat</h1>
    <p>Log aktivitas pengiriman selesai dan gagal.</p>
</div>

{{-- ===== FILTER DROPDOWN ===== --}}
<div class="filter-dropdown fade-up delay-2" style="margin-bottom: 20px;">
    <select onchange="window.location.href=this.value" style="width: 100%; padding: 12px 16px; border-radius: 8px; border: 1.5px solid var(--color-border); background: var(--color-surface); font-family: var(--font-body); font-size: 13px; color: var(--color-neutral); outline: none; cursor: pointer;">
        <option value="{{ route('driver.riwayat.index') }}" {{ !request('status') ? 'selected' : '' }}>Semua</option>
        <option value="{{ route('driver.riwayat.index', ['status' => 'diterima']) }}" {{ request('status') == 'diterima' ? 'selected' : '' }}>Diterima</option>
        <option value="{{ route('driver.riwayat.index', ['status' => 'gagal']) }}" {{ request('status') == 'gagal' ? 'selected' : '' }}>Gagal Kirim</option>
        <option value="{{ route('driver.riwayat.index', ['status' => 'ditolak_driver']) }}" {{ request('status') == 'ditolak_driver' ? 'selected' : '' }}>Ditolak</option>
    </select>
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
