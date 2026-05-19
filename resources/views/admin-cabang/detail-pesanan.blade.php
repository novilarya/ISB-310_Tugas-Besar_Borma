@extends('admin-cabang.layouts.admin-cabang')
@section('title', 'Detail Pesanan #BRM-9' . str_pad($pesanan->id_pesanan, 3, '0', STR_PAD_LEFT) . ' - Borma Toserba')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin-cabang.css') }}">
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<style>
/* ===== DETAIL PESANAN PAGE ===== */
.detail-header-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 0.75rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 6px 14px;
    border-radius: 20px;
}
.order-id-display {
    font-family: var(--font-heading);
    font-size: 2rem;
    font-weight: 800;
    color: var(--borma-primary);
    letter-spacing: -0.5px;
}
.info-label {
    font-size: 0.72rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #9CA3AF;
    margin-bottom: 4px;
}
.info-value {
    font-size: 0.92rem;
    font-weight: 700;
    color: var(--borma-neutral);
}
.info-group {
    padding: 14px 0;
    border-bottom: 1px solid #F3F4F6;
}
.info-group:last-child { border-bottom: none; }

/* Timeline */
.timeline {
    position: relative;
    padding-left: 28px;
}
.timeline::before {
    content: '';
    position: absolute;
    left: 9px; top: 12px; bottom: 12px;
    width: 2px;
    background: #E5E7EB;
}
.timeline-item {
    position: relative;
    padding: 0 0 20px 20px;
}
.timeline-item:last-child { padding-bottom: 0; }
.timeline-dot {
    position: absolute;
    left: -19px;
    top: 4px;
    width: 20px; height: 20px;
    border-radius: 50%;
    border: 2px solid #E5E7EB;
    background: white;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.6rem;
    z-index: 1;
}
.timeline-dot.done {
    background: var(--borma-primary);
    border-color: var(--borma-primary);
    color: white;
}
.timeline-dot.active {
    background: #FED50B;
    border-color: #FED50B;
    color: var(--borma-neutral);
}
.timeline-title {
    font-weight: 800;
    font-size: 0.88rem;
    color: var(--borma-neutral);
    margin-bottom: 2px;
}
.timeline-sub {
    font-size: 0.75rem;
    color: #9CA3AF;
}

/* Item Table */
.item-row {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 14px 0;
    border-bottom: 1px solid #F9FAFB;
}
.item-row:last-child { border-bottom: none; }
.item-icon {
    width: 44px; height: 44px;
    border-radius: 10px;
    background: #F3F4F6;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.2rem;
    color: #9CA3AF;
    flex-shrink: 0;
}
.item-name {
    font-weight: 800;
    font-size: 0.9rem;
    color: var(--borma-neutral);
    margin-bottom: 2px;
}
.item-meta {
    font-size: 0.75rem;
    color: #9CA3AF;
}
.item-price {
    margin-left: auto;
    text-align: right;
    flex-shrink: 0;
}
.item-price .subtotal {
    font-weight: 800;
    font-size: 0.95rem;
    color: var(--borma-primary);
}
.item-price .unit {
    font-size: 0.72rem;
    color: #9CA3AF;
}

/* Summary Total */
.summary-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 0;
    font-size: 0.88rem;
    border-bottom: 1px solid #F3F4F6;
}
.summary-row:last-child { border-bottom: none; }
.summary-row.grand-total {
    font-size: 1rem;
    font-weight: 800;
    color: var(--borma-primary);
    border-top: 2px solid #F3F4F6;
    padding-top: 16px;
    margin-top: 4px;
}
.summary-row .label { color: #6B7280; font-weight: 600; }
.summary-row .value { font-weight: 700; color: var(--borma-neutral); }
</style>
@endpush

@section('content')

@php
    $statusMap = [
        'Menunggu'      => ['class' => 'status-pending',  'label' => 'Menunggu Konfirmasi', 'icon' => 'bi-clock'],
        'Disiapkan'     => ['class' => 'status-siap',     'label' => 'Sedang Disiapkan',    'icon' => 'bi-box-seam'],
        'Sedang Dikirim'=> ['class' => 'status-dikirim',  'label' => 'Sedang Dikirim',       'icon' => 'bi-truck'],
        'Diterima'      => ['class' => 'status-selesai',  'label' => 'Selesai / Diterima',   'icon' => 'bi-check-circle'],
    ];
    $st = $statusMap[$pesanan->status_pesanan] ?? ['class'=>'badge-warning','label'=>$pesanan->status_pesanan,'icon'=>'bi-question'];
    $orderId = '#BRM-9' . str_pad($pesanan->id_pesanan, 3, '0', STR_PAD_LEFT);
@endphp

{{-- ── Header ────────────────────────────────────────────────────────── --}}
<div class="d-flex justify-content-between align-items-start mb-4">
    <div>
        <div class="d-flex align-items-center gap-3 mb-2">
            <a href="{{ route('admin-cabang.pesanan') }}" class="btn-action btn-action-outline btn-action-sm">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
            <span class="status-badge-modern {{ $st['class'] }}">
                <i class="bi {{ $st['icon'] }} me-1"></i>{{ $st['label'] }}
            </span>
        </div>
        <div class="order-id-display">{{ $orderId }}</div>
        <p class="page-subtitle mt-1">
            Dipesan pada
            {{ \Carbon\Carbon::parse($pesanan->tanggal_pemesanan)->translatedFormat('l, d F Y') }}
            pukul {{ \Carbon\Carbon::parse($pesanan->tanggal_pemesanan)->format('H:i') }} WIB
        </p>
    </div>
    <div class="d-flex gap-2">
        @if($pesanan->status_pesanan === 'Menunggu')
        <form action="{{ route('admin-cabang.pesanan.confirm', $pesanan->id_pesanan) }}" method="POST">
            @csrf
            <button type="submit" class="btn-action btn-action-primary">
                <i class="bi bi-check-lg me-2"></i>Konfirmasi & Siapkan
            </button>
        </form>
        @elseif($pesanan->status_pesanan === 'Disiapkan')
        <form action="{{ route('admin-cabang.pesanan.dispatch', $pesanan->id_pesanan) }}" method="POST">
            @csrf
            <button type="submit" class="btn-action btn-action-primary">
                <i class="bi bi-truck me-2"></i>Kirim Pesanan
            </button>
        </form>
        @elseif($pesanan->status_pesanan === 'Sedang Dikirim')
        <form action="{{ route('admin-cabang.pesanan.complete', $pesanan->id_pesanan) }}" method="POST"
              onsubmit="return confirm('Tandai pesanan ini sudah diterima pelanggan?')">
            @csrf
            <button type="submit" class="btn-action btn-action-primary">
                <i class="bi bi-check-circle me-2"></i>Tandai Diterima
            </button>
        </form>
        @endif
        <a href="{{ route('admin-cabang.laporan') }}" class="btn-action btn-action-outline">
            <i class="bi bi-printer me-1"></i>Cetak
        </a>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success d-flex align-items-center gap-2 mb-4" style="border-radius:12px; font-weight:700;">
    <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
</div>
@endif

<div class="row g-4">

    {{-- ── Kolom Kiri ──────────────────────────────────────────────── --}}
    <div class="col-lg-8">

        {{-- Item Produk --}}
        <div class="glass-card mb-4">
            <h6 class="kpi-title mb-4">Produk yang Dipesan</h6>
            @foreach($pesanan->details as $item)
            <div class="item-row">
                <div class="item-icon">
                    @if($item->produk && $item->produk->gambar_produk && $item->produk->gambar_produk !== 'default.jpg')
                        <img src="{{ asset('storage/' . $item->produk->gambar_produk) }}"
                             style="width:100%;height:100%;object-fit:cover;border-radius:10px;" alt="">
                    @else
                        <i class="bi bi-box"></i>
                    @endif
                </div>
                <div>
                    <div class="item-name">{{ $item->produk->nama_produk ?? 'Produk tidak diketahui' }}</div>
                    <div class="item-meta">
                        {{ $item->produk->kategori ?? '-' }} &bull;
                        {{ $item->jumlah }} × Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}
                        @if($item->catatan_produk)
                        <br><span class="text-warning"><i class="bi bi-chat-left-text-fill me-1"></i>{{ $item->catatan_produk }}</span>
                        @endif
                    </div>
                </div>
                <div class="item-price">
                    <div class="subtotal">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</div>
                    <div class="unit">{{ $item->jumlah }} pcs</div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Ringkasan Pembayaran --}}
        <div class="glass-card mb-4">
            <h6 class="kpi-title mb-4">Ringkasan Pembayaran</h6>
            <div class="summary-row">
                <span class="label">Subtotal Belanja</span>
                <span class="value">Rp {{ number_format($pesanan->total_belanja, 0, ',', '.') }}</span>
            </div>
            <div class="summary-row">
                <span class="label">Biaya Pengiriman</span>
                <span class="value">Rp {{ number_format($pesanan->biaya_pengiriman, 0, ',', '.') }}</span>
            </div>
            @if($pesanan->diskon_voucher > 0)
            <div class="summary-row">
                <span class="label text-success"><i class="bi bi-ticket-perforated me-1"></i>Diskon Voucher</span>
                <span class="value text-success">- Rp {{ number_format($pesanan->diskon_voucher, 0, ',', '.') }}</span>
            </div>
            @endif
            <div class="summary-row grand-total">
                <span>Total Tagihan</span>
                <span>Rp {{ number_format($pesanan->total_tagihan, 0, ',', '.') }}</span>
            </div>
            <div class="mt-3 d-flex align-items-center gap-2">
                <span class="info-label mb-0">Metode Pembayaran:</span>
                <span class="badge-modern badge-primary">
                    <i class="bi bi-credit-card me-1"></i>{{ $pesanan->metode_pembayaran }}
                </span>
            </div>
        </div>

        {{-- Promo / Voucher (jika ada) --}}
        @if($pesanan->promo)
        <div class="glass-card mb-4">
            <h6 class="kpi-title mb-3">Promo Diterapkan</h6>
            <div class="d-flex align-items-center gap-3">
                <div class="icon-box bg-secondary-light"><i class="bi bi-ticket-perforated"></i></div>
                <div>
                    <div style="font-weight:800;font-size:0.9rem;">{{ $pesanan->promo->nama_voucher }}</div>
                    <div style="font-size:0.78rem;color:#9CA3AF;">Kode: <strong>{{ $pesanan->promo->kode_voucher }}</strong></div>
                </div>
                <span class="ms-auto badge-modern badge-success">Aktif</span>
            </div>
        </div>
        @endif

    </div>

    {{-- ── Kolom Kanan ─────────────────────────────────────────────── --}}
    <div class="col-lg-4">

        {{-- Status Timeline --}}
        <div class="glass-card mb-4">
            <h6 class="kpi-title mb-4">Status Pesanan</h6>
            @php
                $steps = ['Menunggu','Disiapkan','Sedang Dikirim','Diterima'];
                $currentIdx = array_search($pesanan->status_pesanan, $steps);
            @endphp
            <div class="timeline">
                @foreach($steps as $idx => $step)
                @php
                    $isDone   = $idx < $currentIdx;
                    $isActive = $idx === $currentIdx;
                @endphp
                <div class="timeline-item">
                    <div class="timeline-dot {{ $isDone ? 'done' : ($isActive ? 'active' : '') }}">
                        @if($isDone) <i class="bi bi-check-lg"></i>
                        @elseif($isActive) <i class="bi bi-circle-fill" style="font-size:6px;"></i>
                        @endif
                    </div>
                    <div class="timeline-title" style="{{ $isActive ? 'color:var(--borma-primary)' : ($isDone ? 'color:#6B7280' : 'color:#D1D5DB') }}">
                        {{ $step === 'Menunggu' ? 'Menunggu Konfirmasi' : ($step === 'Diterima' ? 'Selesai / Diterima' : $step) }}
                    </div>
                    <div class="timeline-sub">
                        @if($isDone) <i class="bi bi-check-circle-fill text-success me-1"></i>Selesai
                        @elseif($isActive) <i class="bi bi-arrow-right-circle-fill text-warning me-1"></i>Status saat ini
                        @else <span class="text-muted">Menunggu...</span>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Info Pelanggan --}}
        <div class="glass-card mb-4">
            <h6 class="kpi-title mb-3">Informasi Pelanggan</h6>
            <div class="info-group">
                <div class="info-label">Nama</div>
                <div class="info-value">{{ $pesanan->pelanggan->user->nama ?? '-' }}</div>
            </div>
            <div class="info-group">
                <div class="info-label">Telepon</div>
                <div class="info-value">{{ $pesanan->pelanggan->user->no_telepon ?? '-' }}</div>
            </div>
            <div class="info-group">
                <div class="info-label">Status Member</div>
                <div class="info-value">
                    @if($pesanan->pelanggan->status_member)
                        <span class="badge-modern badge-success"><i class="bi bi-star-fill me-1"></i>Member Aktif</span>
                    @else
                        <span class="badge-modern" style="background:#F3F4F6;color:#6B7280;">Non-Member</span>
                    @endif
                </div>
            </div>
            <div class="info-group">
                <div class="info-label">Alamat Pengiriman</div>
                <div class="info-value" style="font-size:0.85rem;line-height:1.5;">{{ $pesanan->alamat_pengiriman }}</div>
            </div>
        </div>

        {{-- Info Kurir --}}
        <div class="glass-card">
            <h6 class="kpi-title mb-3">Informasi Pengiriman</h6>
            @if($pesanan->kurir)
            <div class="info-group">
                <div class="info-label">Nama Kurir</div>
                <div class="info-value">{{ $pesanan->kurir->user->nama ?? '-' }}</div>
            </div>
            <div class="info-group">
                <div class="info-label">Kendaraan</div>
                <div class="info-value">
                    {{ $pesanan->kurir->kendaraan }}
                    <span class="text-muted" style="font-size:0.8rem;">({{ $pesanan->kurir->warna_kendaraan }})</span>
                </div>
            </div>
            <div class="info-group">
                <div class="info-label">Plat Nomor</div>
                <div class="info-value" style="font-family:monospace;font-size:1rem;letter-spacing:1px;">
                    {{ $pesanan->kurir->plat_nomor }}
                </div>
            </div>
            @if($pesanan->estimasi_tiba)
            <div class="info-group">
                <div class="info-label">Estimasi Tiba</div>
                <div class="info-value">{{ \Carbon\Carbon::parse($pesanan->estimasi_tiba)->format('d M Y, H:i') }} WIB</div>
            </div>
            @endif
            @else
            <div class="text-center py-3">
                <i class="bi bi-truck text-muted" style="font-size:2rem;opacity:0.4;"></i>
                <p class="text-muted small mt-2 mb-0">Kurir belum ditugaskan.</p>
            </div>
            @endif
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/admin-cabang.js') }}"></script>
@endpush
