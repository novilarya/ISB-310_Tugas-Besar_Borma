@extends('driver.layouts.app')

@section('title', 'Detail Tugas #BRM-' . $pesanan->id_pesanan)
@section('header_back', true)

@push('styles')
{{-- Leaflet CSS --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<link rel="stylesheet" href="{{ asset('css/driver/tugas-show.css') }}">
@endpush

@section('content')

@php
    $statusLabels = [
        'mencari_driver' => 'Mencari Driver',
        'diterima_driver' => 'Diterima Driver',
        'diambil' => 'Diambil',
        'dalam_pengiriman' => 'Dalam Pengiriman',
        'diterima' => 'Diterima',
        'gagal' => 'Gagal Kirim',
        'ditolak_driver' => 'Ditolak',
    ];

    $statusFlow = ['diterima_driver', 'diambil', 'dalam_pengiriman', 'diterima'];
    $currentIndex = array_search($pesanan->status_pesanan, $statusFlow);
    $isGagal = $pesanan->status_pesanan === 'gagal';

    // Parse koordinat cabang
    $cabangKoordinat = explode(',', $pesanan->cabang->koordinat_gps ?? '-6.9147,107.6542');
    $cabangLat = trim($cabangKoordinat[0] ?? '-6.9147');
    $cabangLng = trim($cabangKoordinat[1] ?? '107.6542');

    // Koordinat customer
    $custLat = $pesanan->latitude ?? -6.9215;
    $custLng = $pesanan->longitude ?? 107.6310;
@endphp

{{-- ===== ORDER HEADER ===== --}}
<div class="order-header fade-up">
    <div class="order-id-card">
        <p class="order-id-label">Order ID</p>
        <p class="order-id-value">#BRM-{{ $pesanan->id_pesanan }}</p>
    </div>
    <div class="order-status-card status-{{ $pesanan->status_pesanan }}">
        <p class="order-status-label">Status Pengiriman</p>
        <p class="order-status-value">
            <span class="order-status-dot"></span>
            {{ $statusLabels[$pesanan->status_pesanan] ?? strtoupper(str_replace('_', ' ', $pesanan->status_pesanan)) }}
        </p>
    </div>
</div>

{{-- ===== ORDER EXTRA INFO ===== --}}
<div class="order-extra fade-up delay-1">
    <div class="order-extra-item">
        <p class="order-extra-label">Estimasi Tiba</p>
        <p class="order-extra-value">{{ $pesanan->estimasi_tiba ? \Carbon\Carbon::parse($pesanan->estimasi_tiba)->format('H:i') . ' WIB' : '-' }}</p>
    </div>
    <div class="order-extra-item">
        <p class="order-extra-label">Gudang Asal</p>
        <p class="order-extra-value">{{ $pesanan->cabang->nama_cabang ?? '-' }}</p>
    </div>
</div>

{{-- ===== MAP (Leaflet.js + OSRM Routing) ===== --}}
<div class="map-section fade-up delay-1">
    <div class="map-container">
        <div id="delivery-map"></div>

        {{-- Loading overlay --}}
        <div class="map-loading-overlay" id="map-loading">
            <div class="map-spinner"></div>
            <span class="map-loading-text">Memuat rute jalan...</span>
        </div>

        {{-- Route info badge --}}
        <div class="map-route-info" id="map-route-info">
            <i class="bi bi-signpost-2-fill"></i>
            <span id="route-distance">-</span>
            <div class="map-route-divider"></div>
            <i class="bi bi-clock-fill"></i>
            <span id="route-duration">-</span>
        </div>

        {{-- Error badge --}}
        <div class="map-route-error" id="map-route-error">
            <i class="bi bi-exclamation-triangle-fill"></i> Rute jalan tidak tersedia
        </div>
    </div>
    <div class="map-legend">
        <div class="map-legend-item">
            <span class="legend-dot gudang"></span>
            Gudang
        </div>
        <div class="map-legend-item">
            <span class="legend-dot customer"></span>
            Lokasi Penerima
        </div>
        <div class="map-legend-item">
            <span class="legend-route">
                <span class="legend-route-line"></span>
            </span>
            Rute Jalan
        </div>
    </div>
</div>

{{-- ===== INFO CUSTOMER + RINGKASAN ITEM ===== --}}
<div class="info-grid fade-up delay-2">
    {{-- Info Customer --}}
    <div class="info-card">
        <h2 class="info-card-title">Info Customer</h2>
        <div class="info-row">
            <p class="info-label">Nama</p>
            <p class="info-value">{{ $pesanan->pelanggan->user->nama ?? '-' }}</p>
        </div>
        <div class="info-row">
            <p class="info-label">Telepon</p>
            <p class="info-value">{{ $pesanan->pelanggan->user->no_telepon ?? '-' }}</p>
        </div>
        <div class="info-row">
            <p class="info-label">Alamat</p>
            <p class="info-value">{{ $pesanan->alamat_pengiriman }}</p>
        </div>

        @if($pesanan->catatan_pengiriman)
        <div class="info-note">
            <p class="info-note-label">Catatan</p>
            <p class="info-note-text">"{{ $pesanan->catatan_pengiriman }}"</p>
        </div>
        @endif
    </div>

    {{-- Ringkasan Item --}}
    <div class="info-card">
        <h2 class="info-card-title">Ringkasan Item</h2>
        @php $totalUnit = 0; @endphp
        @forelse($pesanan->details as $detail)
            @php $totalUnit += $detail->jumlah; @endphp
            <div class="item-row">
                <p class="item-name">{{ $detail->produk->nama_produk ?? 'Produk' }}</p>
                <p class="item-qty">Qty: {{ $detail->jumlah }}</p>
            </div>
        @empty
            <p style="font-size: 12px; color: var(--color-text-muted); padding: 8px 0;">Tidak ada item.</p>
        @endforelse

        <div class="item-total-row">
            <span class="item-total-label">Total Item</span>
            <span class="item-total-value">{{ $totalUnit }}<span class="item-total-unit">Unit</span></span>
        </div>
    </div>
</div>

{{-- ===== TIMELINE ===== --}}
<div class="timeline-section fade-up delay-3">
    <h2 class="timeline-title">Timeline</h2>
    <div class="timeline-list">

        @php
            $trackingMap = [];
            foreach ($pesanan->pengirimanTracking as $t) {
                $trackingMap[$t->status] = $t;
            }

            $timelineSteps = [
                ['status' => 'diterima_driver', 'label' => 'Pesanan Dikonfirmasi', 'icon' => 'bi-check', 'desc' => 'Driver mengkonfirmasi pesanan'],
                ['status' => 'diambil', 'label' => 'Pesanan Diambil', 'icon' => 'bi-box-seam', 'desc' => $pesanan->cabang->nama_cabang ?? 'Gudang'],
                ['status' => 'dalam_pengiriman', 'label' => 'Dalam Pengiriman', 'icon' => 'bi-truck', 'desc' => 'Menuju lokasi pelanggan'],
                ['status' => 'diterima', 'label' => 'Pesanan Diterima', 'icon' => 'bi-check-all', 'desc' => 'Diterima oleh pelanggan'],
            ];
        @endphp

        @foreach($timelineSteps as $step)
            @php
                $tracking = $trackingMap[$step['status']] ?? null;
                $stepIndex = array_search($step['status'], $statusFlow);
                $isDone = $currentIndex !== false && $stepIndex !== false && $stepIndex < $currentIndex;
                $isActive = $pesanan->status_pesanan === $step['status'];
                $isPending = !$isDone && !$isActive;

                if ($isGagal) {
                    // Jika gagal, semua step sebelum gagal = done
                    $isDone = false;
                    $isActive = false;
                    $isPending = true;
                    if ($tracking) $isDone = true;
                }

                $dotClass = $isDone ? 'done' : ($isActive ? 'active' : 'pending');
            @endphp
            <div class="timeline-item {{ $isPending && !$isDone ? 'is-pending' : '' }}">
                <div class="timeline-dot {{ $dotClass }}">
                    <i class="bi {{ $step['icon'] }}"></i>
                </div>
                <p class="timeline-step-title">{{ $step['label'] }}</p>
                <p class="timeline-step-time">
                    @if($tracking)
                        {{ \Carbon\Carbon::parse($tracking->created_at)->format('H:i') }} WIB â€” {{ $tracking->keterangan ?? $step['desc'] }}
                    @elseif($isActive)
                        {{ now()->format('H:i') }} WIB â€” {{ $step['desc'] }}
                    @elseif($step['status'] === 'diterima' && !$isGagal)
                        Estimasi {{ $pesanan->estimasi_tiba ? \Carbon\Carbon::parse($pesanan->estimasi_tiba)->format('H:i') . ' WIB' : '-' }}
                    @else
                        Menunggu
                    @endif
                </p>
            </div>
        @endforeach

        {{-- Gagal Kirim --}}
        @if($isGagal)
        <div class="timeline-item">
            <div class="timeline-dot failed">
                <i class="bi bi-x-lg"></i>
            </div>
            <p class="timeline-step-title" style="color: var(--color-tertiary);">Gagal Kirim</p>
            <p class="timeline-step-time">
                @if(isset($trackingMap['gagal']))
                    {{ \Carbon\Carbon::parse($trackingMap['gagal']->created_at)->format('H:i') }} WIB â€” {{ $pesanan->alasan_gagal ?? 'Gagal kirim' }}
                @else
                    {{ $pesanan->alasan_gagal ?? 'Gagal kirim' }}
                @endif
            </p>
        </div>
        @endif
    </div>
</div>

{{-- ===== BUKTI PENGIRIMAN (READ ONLY) ===== --}}
@if($pesanan->status_pesanan === 'diterima' && $pesanan->bukti_pengiriman)
<div class="bukti-section fade-up delay-4">
    <h2 class="bukti-title">Informasi Pengiriman</h2>
    <div class="bukti-grid">
        <div class="bukti-photo-box" style="cursor: default;">
            @if($pesanan->bukti_pengiriman)
                <img src="{{ asset('storage/' . $pesanan->bukti_pengiriman) }}" alt="Bukti Pengiriman">
            @else
                <i class="bi bi-image"></i>
                <span>Tidak ada foto</span>
            @endif
        </div>
        <div class="bukti-form-fields" style="justify-content: center;">
            <div class="info-row">
                <p class="info-label">Penerima</p>
                <p class="info-value">{{ $pesanan->nama_penerima }}</p>
            </div>
            @if($pesanan->catatan_driver)
            <div class="info-row" style="margin-top: 12px;">
                <p class="info-label">Catatan Driver</p>
                <p class="info-value" style="font-style: italic;">"{{ $pesanan->catatan_driver }}"</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endif

{{-- ===== STATUS BUTTONS ===== --}}
@if(in_array($pesanan->status_pesanan, ['diterima_driver', 'diambil', 'dalam_pengiriman']))
<div class="status-buttons fade-up delay-5" id="status-buttons">
    @if($pesanan->status_pesanan === 'diterima_driver')
        <button type="button" class="status-btn" style="grid-column: span 4;"
                onclick="updateStatus('diambil')" data-status="diambil">
            <i class="bi bi-box-seam me-1"></i> Tandai Diambil Dari Gudang
        </button>
    @elseif($pesanan->status_pesanan === 'diambil')
        <button type="button" class="status-btn" style="grid-column: span 4;"
                onclick="updateStatus('dalam_pengiriman')" data-status="dalam_pengiriman">
            <i class="bi bi-truck me-1"></i> Mulai Pengiriman (Perjalanan)
        </button>
    @elseif($pesanan->status_pesanan === 'dalam_pengiriman')
        <button type="button" class="status-btn" style="grid-column: span 2;"
                onclick="openBuktiModal()" data-status="diterima">
            <i class="bi bi-check-circle me-1"></i> Diterima / Selesai
        </button>
        <button type="button" class="status-btn btn-gagal" style="grid-column: span 2;"
                onclick="updateStatusGagal()" data-status="gagal">
            <i class="bi bi-x-circle me-1"></i> Gagal Kirim
        </button>
    @endif
</div>
@endif

@endsection

@push('scripts')
{{-- Leaflet JS --}}
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

{{-- SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    const pesananId = {{ $pesanan->id_pesanan }};

    // =============================================
    // LEAFLET MAP
    // =============================================
    document.addEventListener('DOMContentLoaded', function() {
        const gudangLat = {{ $cabangLat }};
        const gudangLng = {{ $cabangLng }};
        const custLat = {{ $custLat }};
        const custLng = {{ $custLng }};

        // Pusat map di tengah antara gudang dan customer
        const centerLat = (gudangLat + custLat) / 2;
        const centerLng = (gudangLng + custLng) / 2;

        const map = L.map('delivery-map', {
            zoomControl: true,
            attributionControl: false
        }).setView([centerLat, centerLng], 13);

        // Tile layer OpenStreetMap
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
        }).addTo(map);

        // Custom icon gudang (ungu)
        const gudangIcon = L.divIcon({
            className: 'custom-marker',
            html: `<div style="background: #33116C; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 8px rgba(51,17,108,0.4); border: 3px solid white;">
                    <svg width="14" height="14" fill="white" viewBox="0 0 16 16"><path d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5l2.404.961L10.404 2l-2.218-.887zm3.564 1.426L5.596 5 8 5.961 14.154 3.5l-2.404-.961zm3.25 1.7-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923l6.5 2.6zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464L7.443.184z"/></svg>
                   </div>`,
            iconSize: [32, 32],
            iconAnchor: [16, 16],
            popupAnchor: [0, -20],
        });

        // Custom icon customer (merah)
        const customerIcon = L.divIcon({
            className: 'custom-marker',
            html: `<div style="background: #EB3B02; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 8px rgba(235,59,2,0.4); border: 3px solid white;">
                    <svg width="14" height="14" fill="white" viewBox="0 0 16 16"><path d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A31.493 31.493 0 0 1 8 14.58a31.481 31.481 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94zM8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10z"/><path d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/></svg>
                   </div>`,
            iconSize: [32, 32],
            iconAnchor: [16, 32],
            popupAnchor: [0, -34],
        });

        // Markers
        let gudangMarker = L.marker([gudangLat, gudangLng], { icon: gudangIcon })
            .addTo(map)
            .bindPopup('<b>Gudang {{ $pesanan->cabang->nama_cabang ?? "Borma" }}</b><br>{{ $pesanan->cabang->alamat_cabang ?? "" }}');

        let customerMarker = L.marker([custLat, custLng], { icon: customerIcon })
            .addTo(map)
            .bindPopup('<b>Lokasi Penerima</b><br>{{ $pesanan->alamat_pengiriman }}');

        // Fit bounds awal (before route loads)
        const bounds = L.latLngBounds([
            [gudangLat, gudangLng],
            [custLat, custLng]
        ]);
        map.fitBounds(bounds, { padding: [40, 40] });

        // Fix map rendering setelah animasi
        setTimeout(() => { map.invalidateSize(); }, 600);

        const STATUS = '{{ $pesanan->status_pesanan }}';

        // Checkmark Icon
        const checkIcon = L.divIcon({
            className: 'custom-marker',
            html: `<div style="background: #22C55E; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 8px rgba(34,197,94,0.4); border: 3px solid white;">
                    <svg width="20" height="20" fill="white" viewBox="0 0 16 16"><path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/></svg>
                   </div>`,
            iconSize: [32, 32],
            iconAnchor: [16, 16],
            popupAnchor: [0, -20],
        });

        // Driver Motor Icon
        const driverIcon = L.divIcon({
            className: 'custom-marker',
            html: `<div style="background: #16A34A; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 8px rgba(22,163,74,0.4); border: 3px solid white;">
                    <svg width="18" height="18" fill="white" viewBox="0 0 16 16"><path d="M6.315 2.114a.5.5 0 0 1 .63-.061l2.5 1.5a.5.5 0 0 1 .15.75l-1.5 2.5a.5.5 0 1 1-.858-.514l1.205-2.008-2.066-1.24a.5.5 0 0 1-.06-.627zM2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1"/><path d="M4 11a3 3 0 0 0 5.613 1.488l3.199-3.2a1 1 0 0 0 .188-1.2l-1.215-2.025a1.5 1.5 0 0 0-2.455-.26l-1.127 1.127-1.393-.836a.5.5 0 0 0-.514.858l1.79 1.074-2.22 2.22A3 3 0 1 0 4 11m0-2a2 2 0 1 1 0 4 2 2 0 0 1 0-4m8 4a2 2 0 1 1 0-4 2 2 0 0 1 0 4"/></svg>
                   </div>`,
            iconSize: [32, 32],
            iconAnchor: [16, 32],
            popupAnchor: [0, -34],
        });

        let driverMarker;
        let driverLat = gudangLat - 0.008; // ~800m away
        let driverLng = gudangLng + 0.008;

        // Atur marker icon saja untuk diterima
        if (STATUS === 'diterima') {
            customerMarker.setIcon(checkIcon); 
        } else if (STATUS === 'diterima_driver') {
            // Posisi mock driver sebelum ambil barang
            driverMarker = L.marker([driverLat, driverLng], { icon: driverIcon })
                .addTo(map)
                .bindPopup('<b>Posisi Driver Saat Ini</b>');
        }

        // =============================================
        // ROUTING BERDASARKAN STATUS
        // =============================================
        const loadingEl = document.getElementById('map-loading');
        const routeInfoEl = document.getElementById('map-route-info');

        function drawFallbackRoute(lat1, lng1, lat2, lng2, isGray = false) {
            L.polyline([[lat1, lng1], [lat2, lng2]], {
                color: isGray ? '#9ca3af' : '#33116C',
                weight: 4,
                opacity: 0.6,
                dashArray: '8, 8',
                lineCap: 'round'
            }).addTo(map);
            map.fitBounds(L.latLngBounds([[lat1, lng1], [lat2, lng2]]), { padding: [40, 40] });
            loadingEl.classList.add('hidden');
            document.getElementById('map-route-error').style.display = 'flex';
        }

        function drawOsrmRoute(startLat, startLng, endLat, endLng) {
            const osrmUrl =
                `https://router.project-osrm.org/route/v1/driving/` +
                `${startLng},${startLat};${endLng},${endLat}` +
                `?overview=full&geometries=geojson&steps=false`;

            const timeoutId = setTimeout(() => {
                drawFallbackRoute(startLat, startLng, endLat, endLng, STATUS === 'diterima');
            }, 6000);

            fetch(osrmUrl)
                .then(res => { if (!res.ok) throw new Error('err'); return res.json(); })
                .then(data => {
                    clearTimeout(timeoutId);
                    if (!data.routes || data.routes.length === 0) throw new Error('no route');
                    const route   = data.routes[0];
                    const latLngs = route.geometry.coordinates.map(c => [c[1], c[0]]);
                    const km      = (route.distance / 1000).toFixed(1);
                    const mins    = Math.round(route.duration / 60);
                    const hrs     = Math.floor(mins / 60);
                    const rem     = mins % 60;

                    document.getElementById('route-distance').textContent = `${km} km`;
                    document.getElementById('route-duration').textContent = hrs > 0 ? `${hrs} jam ${rem} mnt` : `${rem} mnt`;

                    if (STATUS === 'diterima') {
                        // Full gray route
                        L.polyline(latLngs, { color: '#e5e7eb', weight: 7, opacity: 0.5, lineCap: 'round' }).addTo(map);
                        const line = L.polyline(latLngs, { color: '#9ca3af', weight: 4.5, opacity: 0.92, lineCap: 'round' }).addTo(map);
                        map.fitBounds(line.getBounds(), { padding: [36, 36] });
                        
                    } else if (STATUS === 'dalam_pengiriman' || STATUS === 'diambil') {
                        // Split line into gray (passed) and blue (upcoming)
                        let percent = STATUS === 'diambil' ? 0.05 : 0.6;
                        let posIndex = Math.floor(latLngs.length * percent);
                        if (posIndex >= latLngs.length) posIndex = latLngs.length - 1;
                        if (posIndex < 0) posIndex = 0;
                        
                        let passedPath = latLngs.slice(0, posIndex + 1);
                        let upcomingPath = latLngs.slice(posIndex);

                        // draw gray for passed
                        if (passedPath.length > 1) {
                            L.polyline(passedPath, { color: '#9ca3af', weight: 4.5, opacity: 0.8, lineCap: 'round' }).addTo(map);
                        }
                        // draw blue for upcoming
                        if (upcomingPath.length > 1) {
                            L.polyline(upcomingPath, { color: '#1d4ed8', weight: 7, opacity: 0.25, lineCap: 'round' }).addTo(map);
                            L.polyline(upcomingPath, { color: '#2563eb', weight: 4.5, opacity: 0.92, lineCap: 'round' }).addTo(map);
                        }
                        map.fitBounds(L.polyline(latLngs).getBounds(), { padding: [36, 36] });

                        // place driver marker exactly on the route
                        L.marker(latLngs[posIndex], { icon: driverIcon }).addTo(map).bindPopup('<b>Posisi Driver Saat Ini</b>');

                    } else {
                        // diterima_driver
                        L.polyline(latLngs, { color: '#1d4ed8', weight: 7, opacity: 0.25, lineCap: 'round' }).addTo(map);
                        const line = L.polyline(latLngs, { color: '#2563eb', weight: 4.5, opacity: 0.92, lineCap: 'round' }).addTo(map);
                        map.fitBounds(line.getBounds(), { padding: [36, 36] });
                    }

                    loadingEl.classList.add('hidden');
                    routeInfoEl.classList.add('visible');
                })
                .catch(() => {
                    clearTimeout(timeoutId);
                    drawFallbackRoute(startLat, startLng, endLat, endLng, STATUS === 'diterima');
                });
        }

        if (STATUS === 'diterima_driver') {
            drawOsrmRoute(driverLat, driverLng, gudangLat, gudangLng);
        } else {
            drawOsrmRoute(gudangLat, gudangLng, custLat, custLng);
        }
    });






    // =============================================
    // UPDATE STATUS via AJAX
    // =============================================
    function updateStatus(status) {
        const currentStatus = "{{ $pesanan->status_pesanan }}";
        
        // Frontend Sequence Validation
        if (status === 'diambil' && currentStatus !== 'diterima_driver') {
            Swal.fire('Tidak Sesuai Urutan!', 'Pesanan harus dikonfirmasi terlebih dahulu sebelum dapat diambil.', 'warning');
            return;
        }
        if (status === 'dalam_pengiriman' && currentStatus !== 'diambil') {
            Swal.fire('Tidak Sesuai Urutan!', 'Pesanan harus diambil dari gudang terlebih dahulu sebelum dikirim.', 'warning');
            return;
        }

        const statusLabels = {
            'diambil': 'DIAMBIL',
            'dalam_pengiriman': 'DALAM PENGIRIMAN',
            'diterima': 'DITERIMA',
        };

        Swal.fire({
            title: 'Update Status',
            text: `Ubah status pesanan menjadi "${statusLabels[status]}"?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Update',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#33116C',
            cancelButtonColor: '#E4E0EE',
            reverseButtons: true,
            didOpen: (modal) => {
                const cancel = modal.querySelector('.swal2-cancel');
                if (cancel) cancel.style.color = '#2B2B2B';
            }
        }).then((result) => {
            if (result.isConfirmed) {
                sendStatusUpdate(status);
            }
        });
    }

    function updateStatusGagal() {
        const currentStatus = "{{ $pesanan->status_pesanan }}";
        
        if (currentStatus !== 'dalam_pengiriman') {
            Swal.fire('Tidak Sesuai Urutan!', 'Pesanan harus berada pada status Dalam Pengiriman sebelum dapat ditandai sebagai Gagal Kirim.', 'warning');
            return;
        }

        Swal.fire({
            title: 'Gagal Kirim',
            html: `
                <p style="font-size: 13px; color: #7a7a9a; margin-bottom: 12px;">
                    Tuliskan alasan gagal kirim. Minimal 10 karakter.
                </p>
                <textarea id="swal-alasan-gagal" class="swal2-textarea"
                    placeholder="Contoh: Alamat tidak ditemukan, penerima tidak ada di tempat..."
                    style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; min-height: 80px; border-radius: 8px; border: 1.5px solid #E4E0EE; resize: none;"
                ></textarea>
            `,
            icon: 'warning',
            iconColor: '#EB3B02',
            showCancelButton: true,
            confirmButtonText: 'Gagal Kirim',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#EB3B02',
            cancelButtonColor: '#E4E0EE',
            reverseButtons: true,
            didOpen: (modal) => {
                const cancel = modal.querySelector('.swal2-cancel');
                if (cancel) cancel.style.color = '#2B2B2B';
            },
            preConfirm: () => {
                const alasan = document.getElementById('swal-alasan-gagal').value.trim();
                if (!alasan || alasan.length < 10) {
                    Swal.showValidationMessage('Alasan minimal 10 karakter');
                    return false;
                }
                return alasan;
            }
        }).then((result) => {
            if (result.isConfirmed) {
                sendStatusUpdate('gagal', result.value);
            }
        });
    }

    function sendStatusUpdate(status, alasanGagal = null) {
        Swal.fire({
            title: 'Memproses...',
            text: 'Mengupdate status pengiriman',
            allowOutsideClick: false,
            allowEscapeKey: false,
            didOpen: () => { Swal.showLoading(); }
        });

        const body = { status: status };
        if (alasanGagal) body.alasan_gagal = alasanGagal;

        fetch(`/driver/tugas/${pesananId}/update-status`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify(body)
        }).then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    title: 'Berhasil!',
                    text: data.message,
                    icon: 'success',
                    confirmButtonColor: '#33116C',
                    timer: 1500,
                    timerProgressBar: true
                }).then(() => {
                    location.reload();
                });
            } else {
                Swal.fire({
                    title: 'Gagal!',
                    text: data.message || 'Terjadi kesalahan',
                    icon: 'error',
                    confirmButtonColor: '#33116C'
                });
            }
        }).catch(error => {
            Swal.fire({
                title: 'Error!',
                text: 'Terjadi kesalahan komunikasi',
                icon: 'error',
                confirmButtonColor: '#33116C'
            });
        });
    }

    // =============================================
    // MODAL BUKTI PENGIRIMAN
    // =============================================
    function openBuktiModal() {
        const currentStatus = "{{ $pesanan->status_pesanan }}";
        
        if (currentStatus !== 'dalam_pengiriman') {
            Swal.fire('Tidak Sesuai Urutan!', 'Pesanan harus berada pada status Dalam Pengiriman sebelum dapat diterima.', 'warning');
            return;
        }
        
        Swal.fire({
            title: 'Bukti Pengiriman',
            html: `
                <div style="text-align: left; margin-top: 10px;">
                    <form id="modalBuktiForm" enctype="multipart/form-data">
                        <label for="modal-foto-bukti" class="bukti-photo-box" id="modal-bukti-photo-preview" style="margin-bottom: 15px;">
                            <i class="bi bi-camera"></i>
                            <span>Unggah Foto Bukti</span>
                            <input type="file" id="modal-foto-bukti" accept="image/*" style="display:none;" onchange="previewModalFoto(this)">
                        </label>
                        <div class="form-field" style="margin-bottom: 12px;">
                            <label for="modal-nama-penerima" style="display: block; font-size: 10px; font-weight: 600; color: #7a7a9a; margin-bottom: 6px;">NAMA PENERIMA *</label>
                            <input type="text" id="modal-nama-penerima" placeholder="Contoh: Ibu Rina (Asisten)" class="swal2-input" style="margin: 0; width: 100%; box-sizing: border-box; height: 42px; font-size: 13px;">
                        </div>
                        <div class="form-field">
                            <label for="modal-catatan-driver" style="display: block; font-size: 10px; font-weight: 600; color: #7a7a9a; margin-bottom: 6px;">CATATAN DRIVER</label>
                            <textarea id="modal-catatan-driver" placeholder="Kondisi barang saat diterima..." class="swal2-textarea" style="margin: 0; width: 100%; box-sizing: border-box; height: 80px; font-size: 13px; resize: none;"></textarea>
                        </div>
                    </form>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: '<i class="bi bi-upload"></i> Unggah Bukti Pengiriman',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#33116C',
            cancelButtonColor: '#E4E0EE',
            reverseButtons: true,
            didOpen: (modal) => {
                const cancel = modal.querySelector('.swal2-cancel');
                if (cancel) cancel.style.color = '#2B2B2B';
            },
            preConfirm: () => {
                const fileInput = document.getElementById('modal-foto-bukti');
                const namaPenerima = document.getElementById('modal-nama-penerima').value.trim();
                
                if (!fileInput.files.length) {
                    Swal.showValidationMessage('Silakan pilih foto bukti pengiriman');
                    return false;
                }
                if (fileInput.files[0].size > 5 * 1024 * 1024) {
                    Swal.showValidationMessage('Ukuran file maksimal 5MB');
                    return false;
                }
                if (!namaPenerima) {
                    Swal.showValidationMessage('Nama penerima harus diisi');
                    return false;
                }
                
                return {
                    file: fileInput.files[0],
                    namaPenerima: namaPenerima,
                    catatanDriver: document.getElementById('modal-catatan-driver').value.trim()
                };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                submitBuktiModal(result.value);
            }
        });
    }

    window.previewModalFoto = function(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const box = document.getElementById('modal-bukti-photo-preview');
                box.innerHTML = `<img src="${e.target.result}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 6px;">`;
                box.appendChild(input); // Kembalikan input agar file tidak hilang
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function submitBuktiModal(data) {
        Swal.fire({
            title: 'Mengunggah...',
            text: 'Mengirim bukti pengiriman',
            allowOutsideClick: false,
            allowEscapeKey: false,
            didOpen: () => { Swal.showLoading(); }
        });

        const formData = new FormData();
        formData.append('foto_bukti', data.file);
        formData.append('nama_penerima', data.namaPenerima);
        formData.append('catatan_driver', data.catatanDriver);

        fetch(`/driver/tugas/${pesananId}/upload-proof`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: formData
        }).then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    title: 'Berhasil!',
                    text: data.message,
                    icon: 'success',
                    confirmButtonColor: '#33116C',
                    timer: 1500,
                    timerProgressBar: true
                }).then(() => {
                    location.reload();
                });
            } else {
                Swal.fire({
                    title: 'Gagal!',
                    text: data.message || 'Terjadi kesalahan',
                    icon: 'error',
                    confirmButtonColor: '#33116C'
                });
            }
        }).catch(error => {
            Swal.fire({
                title: 'Error!',
                text: 'Terjadi kesalahan komunikasi',
                icon: 'error',
                confirmButtonColor: '#33116C'
            });
        });
    }
</script>
@endpush

