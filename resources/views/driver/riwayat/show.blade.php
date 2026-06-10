@extends('driver.layouts.app')

@section('title', 'Detail Riwayat #BM-' . $pesanan->id_pesanan)
@section('header_back', true)

@push('styles')
<link rel="stylesheet" href="{{ asset('css/driver/riwayat-show.css') }}">

<!-- Leaflet CSS & JS untuk Map -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.js"></script>
@endpush

@section('content')

{{-- ===== ORDER HEADER ===== --}}
<div class="order-header fade-up">
    <div class="order-id-card">
        <p class="order-id-label">Order ID</p>
        <p class="order-id-value">#BM-{{ $pesanan->id_pesanan }}</p>
    </div>
    <div class="order-status-card {{ $pesanan->status_pesanan == 'gagal' ? 'gagal' : 'diterima' }}">
        <p class="order-status-label">Status</p>
        <p class="order-status-value">{{ strtoupper(str_replace('_', ' ', $pesanan->status_pesanan)) }}</p>
    </div>
</div>

{{-- ===== LOKASI PENGIRIMAN / MAP ===== --}}
@if($pesanan->latitude && $pesanan->longitude)
<div class="section-card fade-up delay-1">
    <h2 class="section-title">Lokasi Pengiriman</h2>
    <div id="deliveryMap" class="map-container"></div>
    <div class="coordinates-info">
        <div class="coordinate-card">
            <p class="coordinate-label">Latitude</p>
            <p class="coordinate-value">{{ $pesanan->latitude }}</p>
        </div>
        <div class="coordinate-card">
            <p class="coordinate-label">Longitude</p>
            <p class="coordinate-value">{{ $pesanan->longitude }}</p>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize map
        var map = L.map('deliveryMap').setView([{{ $pesanan->latitude }}, {{ $pesanan->longitude }}], 16);
        
        // Add map tiles
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors',
            maxZoom: 19
        }).addTo(map);
        
        // Add marker for delivery location
        L.marker([{{ $pesanan->latitude }}, {{ $pesanan->longitude }}], {
            icon: L.icon({
                iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-blue.png',
                shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                shadowSize: [41, 41]
            })
        }).bindPopup('<strong>Lokasi Pengiriman</strong><br>{{ $pesanan->alamat_pengiriman }}').addTo(map);
    });
</script>
@endif

{{-- ===== PENGHASILAN ===== --}}
<div class="section-card fade-up delay-2">
    <h2 class="section-title">Penghasilan Pengiriman</h2>
    <div class="earning-grid">
        <div class="earning-card">
            <p class="earning-label">Fee Pengiriman</p>
            <p class="earning-value">Rp {{ number_format($pesanan->biaya_pengiriman, 0, ',', '.') }}</p>
        </div>
        <div class="earning-card">
            <p class="earning-label">Penghasilan Kotor</p>
            <p class="earning-value">Rp {{ number_format($pesanan->biaya_pengiriman, 0, ',', '.') }}</p>
        </div>
        <div class="earning-card">
            <p class="earning-label">Potongan</p>
            <p class="earning-value">Rp {{ number_format(($pesanan->potongan_driver ?? 0), 0, ',', '.') }}</p>
        </div>
        <div class="earning-card primary-card">
            <p class="earning-label">Penghasilan Bersih</p>
            <p class="earning-value">Rp {{ number_format($pesanan->biaya_pengiriman - ($pesanan->potongan_driver ?? 0), 0, ',', '.') }}</p>
        </div>
    </div>
</div>

{{-- ===== DETAIL PENGIRIMAN ===== --}}
<div class="section-card fade-up delay-3">
    <h2 class="section-title">Detail Pengiriman</h2>
    <div class="detail-grid">
        <div class="detail-item">
            <span class="detail-label">Tanggal</span>
            <span class="detail-value">{{ \Carbon\Carbon::parse($pesanan->tanggal_pemesanan)->translatedFormat('d M Y') }}</span>
        </div>
        <div class="detail-item">
            <span class="detail-label">Waktu Selesai</span>
            <span class="detail-value">{{ $pesanan->estimasi_tiba ? \Carbon\Carbon::parse($pesanan->estimasi_tiba)->format('H:i') . ' WIB' : '-' }}</span>
        </div>
        <div class="detail-item">
            <span class="detail-label">Cabang Asal</span>
            <span class="detail-value">{{ $pesanan->cabang->nama_cabang ?? '-' }}</span>
        </div>
        <div class="detail-item">
            <span class="detail-label">Metode Bayar</span>
            <span class="detail-value">{{ ucfirst($pesanan->metode_pembayaran) }}</span>
        </div>
    </div>
</div>

{{-- ===== INFO CUSTOMER ===== --}}
<div class="section-card fade-up delay-4">
    <h2 class="section-title">Info Customer</h2>
    <div class="info-row">
        <p class="info-label">Nama</p>
        <p class="info-value">{{ $pesanan->pelanggan->user->nama ?? '-' }}</p>
    </div>
    <div class="info-row">
        <p class="info-label">Telepon</p>
        <p class="info-value">{{ $pesanan->pelanggan->user->no_telepon ?? '-' }}</p>
    </div>
    <div class="info-row">
        <p class="info-label">Alamat Pengiriman</p>
        <p class="info-value">{{ $pesanan->alamat_pengiriman }}</p>
    </div>
</div>

{{-- ===== RINGKASAN ITEM ===== --}}
<div class="section-card fade-up delay-5">
    <h2 class="section-title">Ringkasan Item</h2>
    @foreach($pesanan->details as $detail)
    <div class="item-row">
        <div>
            <p class="item-name">{{ $detail->produk->nama_produk ?? 'Produk' }}</p>
            <p class="item-qty">Qty: {{ $detail->jumlah }}</p>
        </div>
        <p class="item-price">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</p>
    </div>
    @endforeach

    <div class="item-total-row">
        <span class="item-total-label">Total Belanja</span>
        <span class="item-total-value">Rp {{ number_format($pesanan->total_belanja, 0, ',', '.') }}</span>
    </div>
</div>

{{-- ===== REVIEW CUSTOMER ===== --}}
<div class="section-card fade-up delay-6">
    <h2 class="section-title">Review Customer</h2>
    @if(isset($pesanan->review_rating) && $pesanan->review_rating)
    <div class="review-box">
        <div class="review-stars">
            @for($i = 1; $i <= 5; $i++)
                <i class="bi {{ $i <= $pesanan->review_rating ? 'bi-star-fill' : 'bi-star' }} {{ $i > $pesanan->review_rating ? 'empty' : '' }}"></i>
            @endfor
        </div>
        <p class="review-text">"{{ $pesanan->review_text }}"</p>
    </div>
    @else
    <p class="no-review">Belum ada review dari customer.</p>
    @endif
</div>

{{-- ===== BUKTI PENGIRIMAN ===== --}}
@if($pesanan->buktiPengiriman)
<div class="section-card fade-up delay-7">
    <h2 class="section-title">Bukti Pengiriman</h2>
    <img src="{{ asset('storage/' . $pesanan->buktiPengiriman->foto_bukti) }}" alt="Bukti Pengiriman" class="bukti-photo">
</div>
@endif

@endsection
