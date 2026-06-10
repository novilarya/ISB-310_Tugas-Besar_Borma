@extends('super-admin.layouts.app')
@section('title', 'Manajemen Member | Super Admin Borma')
@section('page_title', 'Manajemen Member')

@section('content')
<div class="grid grid-cols-1 gap-6">

    {{-- ═══════════════════════════════════════════════════════════
         DENSITY MAP CARD
    ═══════════════════════════════════════════════════════════ --}}
    <div class="bg-white dark:bg-white/5 dark:backdrop-blur-xl border border-slate-200 dark:border-white/10 shadow-sm dark:shadow-none rounded-3xl p-6">

        {{-- Header --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-5">
            <div>
                <h4 class="text-lg font-bold text-slate-800 dark:text-white flex items-center gap-2">
                    <i class="fa-solid fa-map-location-dot text-borma-purple dark:text-borma-yellow"></i>
                    Peta Sebaran Member
                </h4>
                <p class="text-xs text-slate-500 dark:text-white/40 mt-1">Kepadatan member berdasarkan kecamatan domisili</p>
            </div>
            {{-- Toggle view --}}
            <div class="flex bg-slate-100 dark:bg-white/10 rounded-xl p-1 text-xs font-bold gap-1">
                <button id="btn-heat" onclick="setMapMode('heat')"
                    class="px-3 py-1.5 rounded-lg transition-all bg-borma-purple text-white">
                    Heatmap
                </button>
                <button id="btn-bubble" onclick="setMapMode('bubble')"
                    class="px-3 py-1.5 rounded-lg transition-all text-slate-600 dark:text-white/60 hover:text-slate-800 dark:hover:text-white">
                    Bubble
                </button>
            </div>
        </div>

        {{-- Stats strip --}}
        <div class="grid grid-cols-3 gap-3 mb-5">
            <div class="bg-slate-50 dark:bg-white/5 rounded-2xl p-4 border border-slate-100 dark:border-white/10 text-center">
                <p class="text-2xl font-bold text-borma-purple dark:text-borma-yellow" id="stat-total">—</p>
                <p class="text-xs text-slate-500 dark:text-white/50 mt-1">Total Member</p>
            </div>
            <div class="bg-slate-50 dark:bg-white/5 rounded-2xl p-4 border border-slate-100 dark:border-white/10 text-center">
                <p class="text-2xl font-bold text-borma-purple dark:text-borma-yellow" id="stat-kecamatan">—</p>
                <p class="text-xs text-slate-500 dark:text-white/50 mt-1">Kecamatan Terjangkau</p>
            </div>
            <div class="bg-slate-50 dark:bg-white/5 rounded-2xl p-4 border border-slate-100 dark:border-white/10 text-center">
                <p class="text-2xl font-bold text-borma-purple dark:text-borma-yellow truncate text-sm!" id="stat-top">—</p>
                <p class="text-xs text-slate-500 dark:text-white/50 mt-1">Kecamatan Terbanyak</p>
            </div>
        </div>

        {{-- Map container --}}
        <div class="relative rounded-2xl overflow-hidden border border-slate-200 dark:border-white/10" style="height:420px">
            <div id="member-density-map" class="w-full h-full"></div>

            {{-- Loading overlay --}}
            <div id="map-loading" class="absolute inset-0 flex items-center justify-center bg-slate-100 dark:bg-slate-900/80 z-[9999] rounded-2xl">
                <div class="flex flex-col items-center gap-3">
                    <div class="w-10 h-10 border-4 border-borma-purple dark:border-borma-yellow border-t-transparent rounded-full animate-spin"></div>
                    <p class="text-sm text-slate-500 dark:text-white/50">Memuat peta...</p>
                </div>
            </div>

            {{-- No-data overlay --}}
            <div id="map-nodata" class="hidden absolute inset-0 flex items-center justify-center bg-slate-50/90 dark:bg-slate-900/80 z-[9998] rounded-2xl">
                <div class="text-center">
                    <i class="fa-solid fa-map-pin text-4xl text-slate-300 dark:text-white/20 mb-3"></i>
                    <p class="text-slate-500 dark:text-white/40 text-sm font-medium">Belum ada data kecamatan member.</p>
                    <p class="text-slate-400 dark:text-white/30 text-xs mt-1">Data akan muncul setelah member mengisi alamat.</p>
                </div>
            </div>
        </div>

        {{-- Legend --}}
        <div class="flex items-center gap-4 mt-4 flex-wrap">
            <span class="text-xs text-slate-500 dark:text-white/40 font-medium">Kepadatan:</span>
            <div class="flex items-center gap-1.5">
                <span class="w-4 h-3 rounded-sm inline-block" style="background:rgba(59,130,246,0.8)"></span>
                <span class="text-xs text-slate-500 dark:text-white/50">Rendah</span>
            </div>
            <div class="flex items-center gap-1.5">
                <span class="w-4 h-3 rounded-sm inline-block" style="background:rgba(34,197,94,0.8)"></span>
                <span class="text-xs text-slate-500 dark:text-white/50">Sedang</span>
            </div>
            <div class="flex items-center gap-1.5">
                <span class="w-4 h-3 rounded-sm inline-block" style="background:rgba(249,115,22,0.85)"></span>
                <span class="text-xs text-slate-500 dark:text-white/50">Tinggi</span>
            </div>
            <div class="flex items-center gap-1.5">
                <span class="w-4 h-3 rounded-sm inline-block" style="background:rgba(239,68,68,0.9)"></span>
                <span class="text-xs text-slate-500 dark:text-white/50">Sangat Tinggi</span>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════
         TABEL MEMBER
    ═══════════════════════════════════════════════════════════ --}}
    <div class="bg-white dark:bg-white/5 dark:backdrop-blur-xl border border-slate-200 dark:border-white/10 shadow-sm dark:shadow-none rounded-3xl p-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
            <h4 class="text-lg font-bold text-slate-800 dark:text-white">Daftar Member (Pelanggan)</h4>
            <div class="flex flex-col md:flex-row items-center gap-3 w-full md:w-auto">
                {{-- Removed Tambah Member button as requested --}}
            </div>
        </div>



        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse sortable">
                <thead>
                    <tr class="border-b border-slate-200 dark:border-white/10 text-slate-500 dark:text-white/50 text-sm">
                        <th class="pb-4 font-medium px-4 sort-header">Nama</th>
                        <th class="pb-4 font-medium px-4 sort-header">Email</th>
                        <th class="pb-4 font-medium px-4 sort-header">No Telepon</th>
                        <th class="pb-4 font-medium px-4 sort-header">Alamat</th>
                        <th class="pb-4 font-medium px-4 sort-header">Poin</th>
                        <th class="pb-4 font-medium px-4 sort-header">Status</th>
                        <th class="pb-4 font-medium px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse($members as $item)
                    <tr class="border-b border-slate-100 dark:border-white/5 hover:bg-slate-50 dark:hover:bg-white/5 transition-colors sortable-row">
                        <td class="py-4 px-4 font-bold text-slate-800 dark:text-white">{{ $item->user->nama ?? '-' }}</td>
                        <td class="py-4 px-4 text-slate-600 dark:text-white/80">{{ $item->user->email ?? '-' }}</td>
                        <td class="py-4 px-4 text-slate-600 dark:text-white/80">{{ $item->user->no_telepon ?? '-' }}</td>
                        <td class="py-4 px-4 text-slate-600 dark:text-white/80">
                            @php
                                $alamatParts = array_filter([
                                    $item->alamat,
                                    $item->kecamatan,
                                    $item->kota_kabupaten,
                                    $item->provinsi,
                                ]);
                            @endphp
                            {{ implode(', ', $alamatParts) ?: '-' }}
                        </td>
                        <td class="py-4 px-4 font-bold text-borma-purple dark:text-borma-yellow">{{ number_format($item->poin_member) }}</td>
                        <td class="py-4 px-4">
                            <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider border {{ $item->status_member_plus ? 'bg-green-100 dark:bg-green-500/20 text-green-700 dark:text-green-400 border-green-200 dark:border-green-500/20' : 'bg-red-100 dark:bg-red-500/20 text-red-700 dark:text-red-400 border-red-200 dark:border-red-500/20' }}">
                                {{ $item->status_member_plus ? 'Aktif' : 'Tidak Aktif' }}
                            </span>
                        </td>
                        <td class="py-4 px-4 text-right flex justify-end gap-2">
                            <a href="{{ route('superadmin.member.detail', $item->id_pelanggan) }}" class="text-borma-purple dark:text-borma-yellow hover:text-purple-700 dark:hover:text-yellow-300 font-bold text-sm bg-slate-100 dark:bg-white/10 px-3 py-1.5 rounded-lg transition-colors inline-block text-center">
                                Kelola
                            </a>
                            <form action="{{ route('superadmin.member.destroy', $item->id_pelanggan) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus member ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 font-bold text-sm bg-red-50 dark:bg-red-500/10 px-3 py-1.5 rounded-lg transition-colors">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-8 text-center text-slate-500 dark:text-white/50">Belum ada data member.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════════════
     SCRIPTS: Leaflet + Leaflet.heat
══════════════════════════════════════════════════════════════ --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<style>
    .density-tooltip {
        background: rgba(17, 5, 38, 0.92) !important;
        border: 1px solid rgba(255,255,255,0.15) !important;
        color: #fff !important;
        border-radius: 8px !important;
        font-size: 12px !important;
        font-family: 'Plus Jakarta Sans', sans-serif !important;
        box-shadow: 0 4px 16px rgba(0,0,0,0.3) !important;
        padding: 6px 10px !important;
    }
    .density-tooltip::before { display: none !important; }
    .leaflet-popup-content-wrapper {
        border-radius: 12px !important;
        font-family: 'Plus Jakarta Sans', sans-serif !important;
        box-shadow: 0 8px 32px rgba(0,0,0,0.2) !important;
    }
</style>

<script>
    // Data density dari server (Blade → JS)
    const densityData = @json($memberDensity);

    let mapMode = 'heat';
    let map = null;
    let heatLayer = null;
    let bubbleLayers = [];

    // ── Update stats strip ────────────────────────────────────────
    function updateStats() {
        const withCoords = densityData.filter(d => d.lat !== null);
        const total      = densityData.reduce((s, d) => s + d.jumlah, 0);
        const sorted     = [...densityData].sort((a, b) => b.jumlah - a.jumlah);
        const topItem    = sorted[0];

        document.getElementById('stat-total').textContent     = total.toLocaleString('id-ID');
        document.getElementById('stat-kecamatan').textContent = withCoords.length;
        document.getElementById('stat-top').textContent       = topItem ? topItem.kecamatan : '—';
    }

    // ── Toggle map mode ───────────────────────────────────────────
    function setMapMode(mode) {
        mapMode = mode;
        const isDark = document.documentElement.classList.contains('dark');
        ['heat', 'bubble'].forEach(m => {
            const btn = document.getElementById('btn-' + m);
            if (m === mode) {
                btn.className = isDark
                    ? 'px-3 py-1.5 rounded-lg transition-all bg-borma-yellow text-slate-900'
                    : 'px-3 py-1.5 rounded-lg transition-all bg-borma-purple text-white';
            } else {
                btn.className = isDark
                    ? 'px-3 py-1.5 rounded-lg transition-all text-white/60 hover:text-white'
                    : 'px-3 py-1.5 rounded-lg transition-all text-slate-600 hover:text-slate-800';
            }
        });
        renderLayers();
    }

    // ── Render heat / bubble layers ───────────────────────────────
    function renderLayers() {
        if (heatLayer) { map.removeLayer(heatLayer); heatLayer = null; }
        bubbleLayers.forEach(l => map.removeLayer(l));
        bubbleLayers = [];

        const pts = densityData.filter(d => d.lat !== null && d.lng !== null);
        if (!pts.length) return;

        const maxCount = Math.max(...pts.map(d => d.jumlah));

        if (mapMode === 'heat') {
            // Heatmap layer
            const heatPts = pts.map(d => [d.lat, d.lng, d.jumlah / maxCount]);
            heatLayer = L.heatLayer(heatPts, {
                radius: 38,
                blur: 28,
                maxZoom: 14,
                max: 1.0,
                gradient: {
                    0.1:  '#3b82f6',
                    0.35: '#22c55e',
                    0.60: '#f97316',
                    0.85: '#ef4444',
                    1.0:  '#7c3aed'
                }
            }).addTo(map);

            // Small dot markers for tooltips
            pts.forEach(d => {
                const m = L.circleMarker([d.lat, d.lng], {
                    radius: 4, color: '#fff', weight: 1.5,
                    fillColor: '#33116C', fillOpacity: 0.9
                }).addTo(map);
                m.bindTooltip(
                    `<strong>${d.kecamatan}</strong><br>${d.jumlah} member`,
                    { direction: 'top', offset: [0,-6], className: 'density-tooltip' }
                );
                bubbleLayers.push(m);
            });

        } else {
            // Bubble mode
            pts.forEach(d => {
                const ratio  = d.jumlah / maxCount;
                const radius = 8 + ratio * 28;
                const color  = ratio > 0.75 ? '#ef4444'
                             : ratio > 0.45 ? '#f97316'
                             : ratio > 0.20 ? '#22c55e'
                             :                '#3b82f6';

                const c = L.circleMarker([d.lat, d.lng], {
                    radius, color: '#fff', weight: 2,
                    fillColor: color, fillOpacity: 0.75
                }).addTo(map);

                c.bindTooltip(
                    `<strong>${d.kecamatan}</strong><br>${d.jumlah} member`,
                    { direction: 'top', offset: [0, -radius], className: 'density-tooltip' }
                );
                c.bindPopup(`
                    <div style="min-width:150px;font-family:'Plus Jakarta Sans',sans-serif">
                        <p style="font-weight:700;font-size:13px;margin:0 0 4px">${d.kecamatan}</p>
                        <p style="color:#6b7280;font-size:12px;margin:0">
                            <span style="color:${color}">&#9679;</span>
                            ${d.jumlah} member
                        </p>
                    </div>
                `);
                bubbleLayers.push(c);
            });
        }
    }

    // ── Init map ─────────────────────────────────────────────────
    function initMap() {
        map = L.map('member-density-map', {
            center: [-6.9175, 107.6191],
            zoom: 12,
            zoomControl: true
        });

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a>',
            maxZoom: 18
        }).addTo(map);

        document.getElementById('map-loading').style.display = 'none';

        const pts = densityData.filter(d => d.lat !== null && d.lng !== null);
        if (!pts.length) {
            document.getElementById('map-nodata').classList.remove('hidden');
            return;
        }

        renderLayers();

        // Auto-fit
        const bounds = L.latLngBounds(pts.map(d => [d.lat, d.lng]));
        map.fitBounds(bounds, { padding: [50, 50] });
    }

    // ── Bootstrap: load Leaflet → heat → init ────────────────────
    document.addEventListener('DOMContentLoaded', () => {
        updateStats();

        const s1 = document.createElement('script');
        s1.src = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js';
        s1.onload = () => {
            const s2 = document.createElement('script');
            s2.src = 'https://unpkg.com/leaflet.heat@0.2.0/dist/leaflet-heat.js';
            s2.onload = initMap;
            document.head.appendChild(s2);
        };
        document.head.appendChild(s1);
    });
</script>

@endsection
