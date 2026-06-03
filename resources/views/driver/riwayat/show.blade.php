@extends('driver.layouts.app')

@section('title', 'Detail Riwayat #BM-' . $pesanan->id_pesanan)
@section('header_back', true)

@push('styles')
<style>
    /* ================================================
       ORDER HEADER
    ================================================ */
    .order-header {
        display: grid;
        grid-template-columns: 1fr auto;
        gap: 12px;
        margin-bottom: 20px;
    }

    .order-id-card {
        background: var(--color-surface);
        border: 1.5px solid var(--color-border);
        border-radius: var(--radius-md);
        padding: 14px 18px;
        box-shadow: var(--shadow-card);
    }

    .order-id-label {
        font-family: var(--font-body);
        font-size: 10px;
        font-weight: 600;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        color: var(--color-text-muted);
    }

    .order-id-value {
        font-family: var(--font-headline);
        font-size: 22px;
        font-weight: 800;
        color: var(--color-neutral);
        margin-top: 2px;
    }

    .order-status-card {
        border-radius: var(--radius-md);
        padding: 14px 18px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .order-status-card.diterima {
        background: var(--color-primary);
    }

    .order-status-card.gagal {
        background: var(--color-tertiary);
    }

    .order-status-label {
        font-family: var(--font-body);
        font-size: 10px;
        font-weight: 600;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: rgba(255,255,255,0.6);
    }

    .order-status-value {
        font-family: var(--font-headline);
        font-size: 13px;
        font-weight: 700;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        color: white;
        margin-top: 4px;
    }

    /* ================================================
       SECTION CARD
    ================================================ */
    .section-card {
        background: var(--color-surface);
        border: 1.5px solid var(--color-border);
        border-radius: var(--radius-md);
        padding: 18px;
        margin-bottom: 14px;
        box-shadow: var(--shadow-card);
    }

    .section-title {
        font-family: var(--font-headline);
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: var(--color-neutral);
        margin-bottom: 14px;
        padding-bottom: 8px;
        border-bottom: 2px solid var(--color-primary-pale);
    }

    /* ================================================
       DETAIL PENGIRIMAN
    ================================================ */
    .detail-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px;
    }

    @media (max-width: 400px) {
        .detail-grid { grid-template-columns: 1fr; }
    }

    .detail-item {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .detail-label {
        font-family: var(--font-body);
        font-size: 10px;
        font-weight: 600;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: var(--color-text-muted);
    }

    .detail-value {
        font-family: var(--font-body);
        font-size: 14px;
        font-weight: 600;
        color: var(--color-neutral);
    }

    .detail-value.highlight {
        color: var(--color-primary);
        font-family: var(--font-headline);
        font-weight: 800;
    }

    /* ================================================
       PENGHASILAN
    ================================================ */
    .earning-grid {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 12px;
    }

    @media (max-width: 400px) {
        .earning-grid { grid-template-columns: 1fr; }
    }

    .earning-card {
        background: var(--color-bg);
        border-radius: var(--radius-sm);
        padding: 14px;
        text-align: center;
    }

    .earning-card.primary-card {
        background: var(--color-primary);
        grid-column: span 3;
    }

    @media (max-width: 400px) {
        .earning-card.primary-card { grid-column: span 1; }
    }

    .earning-label {
        font-family: var(--font-body);
        font-size: 10px;
        font-weight: 600;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: var(--color-text-muted);
        margin-bottom: 4px;
    }

    .earning-value {
        font-family: var(--font-headline);
        font-size: 22px;
        font-weight: 800;
        color: var(--color-neutral);
    }

    .primary-card .earning-label { color: rgba(255,255,255,0.6); }
    .primary-card .earning-value { color: var(--color-secondary); font-size: 28px; }

    /* ================================================
       INFO CUSTOMER
    ================================================ */
    .info-row {
        margin-bottom: 12px;
    }

    .info-row:last-child { margin-bottom: 0; }

    .info-label {
        font-family: var(--font-body);
        font-size: 10px;
        font-weight: 600;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: var(--color-text-muted);
        margin-bottom: 2px;
    }

    .info-value {
        font-family: var(--font-body);
        font-size: 14px;
        font-weight: 600;
        color: var(--color-neutral);
    }

    /* ================================================
       ITEM LIST
    ================================================ */
    .item-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 0;
        border-bottom: 1px solid var(--color-border);
    }

    .item-row:last-of-type { border-bottom: none; }

    .item-name {
        font-family: var(--font-body);
        font-size: 13px;
        font-weight: 600;
        color: var(--color-neutral);
    }

    .item-qty {
        font-family: var(--font-body);
        font-size: 11px;
        color: var(--color-text-muted);
    }

    .item-price {
        font-family: var(--font-body);
        font-size: 13px;
        font-weight: 600;
        color: var(--color-neutral-soft);
        text-align: right;
    }

    .item-total-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 10px;
        margin-top: 8px;
        border-top: 2px solid var(--color-primary-pale);
    }

    .item-total-label {
        font-family: var(--font-body);
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: var(--color-text-muted);
    }

    .item-total-value {
        font-family: var(--font-headline);
        font-size: 18px;
        font-weight: 800;
        color: var(--color-primary);
    }

    /* ================================================
       REVIEW CUSTOMER
    ================================================ */
    .review-box {
        background: var(--color-primary-pale);
        border-radius: var(--radius-sm);
        padding: 14px;
    }

    .review-stars {
        display: flex;
        gap: 4px;
        margin-bottom: 8px;
    }

    .review-stars i {
        font-size: 18px;
        color: var(--color-secondary);
    }

    .review-stars i.empty {
        color: var(--color-border);
    }

    .review-text {
        font-family: var(--font-body);
        font-size: 13px;
        font-style: italic;
        color: var(--color-neutral-soft);
        line-height: 1.5;
    }

    .no-review {
        font-family: var(--font-body);
        font-size: 13px;
        color: var(--color-text-muted);
        text-align: center;
        padding: 16px;
    }

    /* ================================================
       BUKTI PHOTO
    ================================================ */
    .bukti-photo {
        width: 100%;
        max-height: 200px;
        object-fit: cover;
        border-radius: var(--radius-sm);
        border: 1.5px solid var(--color-border);
    }

    .bukti-info {
        margin-top: 12px;
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
    .delay-4 { animation-delay: 0.28s; }
    .delay-5 { animation-delay: 0.36s; }
    .delay-6 { animation-delay: 0.44s; }
    .delay-7 { animation-delay: 0.52s; }

    /* ================================================
       MAP SECTION
    ================================================ */
    .map-container {
        width: 100%;
        height: 300px;
        border-radius: var(--radius-md);
        border: 1.5px solid var(--color-border);
        overflow: hidden;
        margin-bottom: 14px;
    }

    .coordinates-info {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
    }

    .coordinate-card {
        background: var(--color-bg);
        border-radius: var(--radius-sm);
        padding: 12px;
        border: 1px solid var(--color-border);
    }

    .coordinate-label {
        font-family: var(--font-body);
        font-size: 10px;
        font-weight: 600;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: var(--color-text-muted);
        margin-bottom: 4px;
    }

    .coordinate-value {
        font-family: var(--font-body);
        font-size: 13px;
        font-weight: 700;
        color: var(--color-primary);
        word-break: break-all;
    }
</style>

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
    <div class="order-status-card {{ $pesanan->status_pesanan == 'gagal_kirim' ? 'gagal' : 'diterima' }}">
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
@if($pesanan->bukti_pengiriman)
<div class="section-card fade-up delay-7">
    <h2 class="section-title">Bukti Pengiriman</h2>
    <img src="{{ asset('storage/' . $pesanan->bukti_pengiriman) }}" alt="Bukti Pengiriman" class="bukti-photo">
</div>
@endif

@endsection
