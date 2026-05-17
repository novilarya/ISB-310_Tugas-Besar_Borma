@extends('driver.layouts.app')

@section('title', 'Detail Tugas #BRM-' . $pesanan->id_pesanan)
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
        margin-bottom: 16px;
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
        background: var(--color-primary);
        border-radius: var(--radius-md);
        padding: 14px 18px;
        display: flex;
        flex-direction: column;
        justify-content: center;
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
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .order-status-dot {
        width: 8px;
        height: 8px;
        background: var(--color-secondary);
        border-radius: 50%;
        flex-shrink: 0;
    }

    /* ================================================
       MAP PLACEHOLDER
    ================================================ */
    .map-container {
        width: 100%;
        height: 180px;
        background: #E8E6EE;
        border-radius: var(--radius-md);
        margin-bottom: 20px;
        overflow: hidden;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .map-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .map-overlay {
        position: absolute;
        bottom: 12px;
        left: 50%;
        transform: translateX(-50%);
        background: var(--color-neutral);
        color: white;
        font-family: var(--font-body);
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 0.06em;
        padding: 8px 16px;
        border-radius: 100px;
        white-space: nowrap;
    }

    .map-placeholder-icon {
        font-size: 36px;
        color: var(--color-text-muted);
    }

    /* ================================================
       INFO GRID (Customer + Ringkasan Item)
    ================================================ */
    .info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
        margin-bottom: 20px;
    }

    @media (max-width: 480px) {
        .info-grid { grid-template-columns: 1fr; }
    }

    .info-card {
        background: var(--color-surface);
        border: 1.5px solid var(--color-border);
        border-radius: var(--radius-md);
        padding: 16px;
        box-shadow: var(--shadow-card);
    }

    .info-card-title {
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

    .info-note {
        background: var(--color-primary-pale);
        border-radius: var(--radius-sm);
        padding: 10px 12px;
        margin-top: 10px;
    }

    .info-note-label {
        font-family: var(--font-body);
        font-size: 9px;
        font-weight: 700;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: var(--color-primary);
        margin-bottom: 4px;
    }

    .info-note-text {
        font-family: var(--font-body);
        font-size: 12px;
        font-style: italic;
        color: var(--color-neutral-soft);
    }

    /* ===== Ringkasan Item ===== */
    .item-row {
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
        font-size: 20px;
        font-weight: 800;
        color: var(--color-primary);
    }

    .item-total-unit {
        font-size: 12px;
        font-weight: 600;
        margin-left: 4px;
        color: var(--color-text-muted);
    }

    /* ================================================
       TIMELINE
    ================================================ */
    .timeline-section {
        background: var(--color-surface);
        border: 1.5px solid var(--color-border);
        border-radius: var(--radius-md);
        padding: 18px;
        margin-bottom: 20px;
        box-shadow: var(--shadow-card);
    }

    .timeline-title {
        font-family: var(--font-headline);
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: var(--color-neutral);
        margin-bottom: 16px;
        padding-bottom: 8px;
        border-bottom: 2px solid var(--color-primary-pale);
    }

    .timeline-list {
        position: relative;
        padding-left: 28px;
    }

    .timeline-list::before {
        content: '';
        position: absolute;
        left: 10px;
        top: 4px;
        bottom: 4px;
        width: 2px;
        background: var(--color-border);
    }

    .timeline-item {
        position: relative;
        padding-bottom: 18px;
    }

    .timeline-item:last-child { padding-bottom: 0; }

    .timeline-dot {
        position: absolute;
        left: -22px;
        top: 2px;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        background: var(--color-border);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 8px;
        color: white;
    }

    .timeline-dot.done {
        background: var(--color-primary);
    }

    .timeline-dot.active {
        background: var(--color-secondary);
        color: var(--color-neutral);
        box-shadow: 0 0 0 4px rgba(254, 213, 11, 0.3);
    }

    .timeline-dot.pending {
        background: var(--color-border);
    }

    .timeline-step-title {
        font-family: var(--font-body);
        font-size: 13px;
        font-weight: 600;
        color: var(--color-neutral);
    }

    .timeline-step-time {
        font-family: var(--font-body);
        font-size: 11px;
        color: var(--color-text-muted);
        margin-top: 2px;
    }

    .timeline-item.is-pending .timeline-step-title {
        color: var(--color-text-muted);
    }

    /* ================================================
       BUKTI PENGIRIMAN
    ================================================ */
    .bukti-section {
        background: var(--color-surface);
        border: 1.5px solid var(--color-border);
        border-radius: var(--radius-md);
        padding: 18px;
        margin-bottom: 20px;
        box-shadow: var(--shadow-card);
    }

    .bukti-title {
        font-family: var(--font-headline);
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: var(--color-neutral);
        margin-bottom: 16px;
        padding-bottom: 8px;
        border-bottom: 2px solid var(--color-primary-pale);
    }

    .bukti-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px;
    }

    @media (max-width: 400px) {
        .bukti-grid { grid-template-columns: 1fr; }
    }

    .bukti-photo-box {
        background: var(--color-bg);
        border: 2px dashed var(--color-border);
        border-radius: var(--radius-sm);
        height: 140px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 8px;
        cursor: pointer;
        transition: border-color 0.2s, background 0.2s;
    }

    .bukti-photo-box:hover {
        border-color: var(--color-primary);
        background: var(--color-primary-pale);
    }

    .bukti-photo-box i {
        font-size: 28px;
        color: var(--color-text-muted);
    }

    .bukti-photo-box span {
        font-family: var(--font-body);
        font-size: 10px;
        font-weight: 600;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: var(--color-text-muted);
    }

    .bukti-photo-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: calc(var(--radius-sm) - 2px);
    }

    .bukti-form-fields {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .form-field label {
        font-family: var(--font-body);
        font-size: 10px;
        font-weight: 600;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: var(--color-text-muted);
        display: block;
        margin-bottom: 6px;
    }

    .form-field input,
    .form-field textarea {
        width: 100%;
        padding: 10px 12px;
        border: 1.5px solid var(--color-border);
        border-radius: var(--radius-sm);
        font-family: var(--font-body);
        font-size: 13px;
        color: var(--color-neutral);
        background: var(--color-bg);
        transition: border-color 0.2s;
        outline: none;
        resize: none;
    }

    .form-field input::placeholder,
    .form-field textarea::placeholder {
        color: var(--color-text-muted);
        font-size: 12px;
    }

    .form-field input:focus,
    .form-field textarea:focus {
        border-color: var(--color-primary);
    }

    /* ================================================
       STATUS BUTTONS
    ================================================ */
    .status-buttons {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 8px;
        margin-bottom: 8px;
    }

    @media (max-width: 480px) {
        .status-buttons { grid-template-columns: repeat(2, 1fr); }
    }

    .status-btn {
        padding: 12px 6px;
        border: 1.5px solid var(--color-border);
        border-radius: var(--radius-sm);
        font-family: var(--font-headline);
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        text-align: center;
        cursor: pointer;
        background: var(--color-surface);
        color: var(--color-neutral);
        transition: all 0.2s;
    }

    .status-btn:hover {
        background: var(--color-primary-pale);
        border-color: var(--color-primary);
        color: var(--color-primary);
    }

    .status-btn.active-status {
        background: var(--color-primary);
        border-color: var(--color-primary);
        color: white;
    }

    .status-btn.btn-gagal {
        border-color: var(--color-tertiary);
        color: var(--color-tertiary);
    }

    .status-btn.btn-gagal:hover,
    .status-btn.btn-gagal.active-status {
        background: var(--color-tertiary);
        border-color: var(--color-tertiary);
        color: white;
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
</style>
@endpush

@section('content')

{{-- ===== ORDER HEADER ===== --}}
<div class="order-header fade-up">
    <div class="order-id-card">
        <p class="order-id-label">Order ID</p>
        <p class="order-id-value">#BRM-{{ $pesanan->id_pesanan }}</p>
    </div>
    <div class="order-status-card">
        <p class="order-status-label">Status Pengiriman</p>
        <p class="order-status-value">
            <span class="order-status-dot"></span>
            {{ strtoupper(str_replace('_', ' ', $pesanan->status_pesanan)) }}
        </p>
    </div>
</div>

{{-- ===== MAP ===== --}}
<div class="map-container fade-up delay-1">
    <i class="bi bi-map map-placeholder-icon"></i>
    <div class="map-overlay">
        <i class="bi bi-geo-alt-fill"></i> Lokasi Penerima
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
        @foreach($pesanan->details as $detail)
            @php $totalUnit += $detail->jumlah; @endphp
            <div class="item-row">
                <p class="item-name">{{ $detail->produk->nama_produk ?? 'Produk' }}</p>
                <p class="item-qty">Qty: {{ $detail->jumlah }}</p>
            </div>
        @endforeach

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
        {{-- Pesanan Diambil --}}
        <div class="timeline-item {{ in_array($pesanan->status_pesanan, ['diambil', 'dalam_pengiriman', 'diterima']) ? '' : 'is-pending' }}">
            <div class="timeline-dot {{ in_array($pesanan->status_pesanan, ['diambil', 'dalam_pengiriman', 'diterima']) ? 'done' : 'pending' }}">
                <i class="bi bi-check"></i>
            </div>
            <p class="timeline-step-title">Pesanan Diambil</p>
            <p class="timeline-step-time">
                @if(in_array($pesanan->status_pesanan, ['diambil', 'dalam_pengiriman', 'diterima']))
                    {{ $pesanan->cabang->nama_cabang ?? 'Gudang' }}
                @else
                    Menunggu
                @endif
            </p>
        </div>

        {{-- Dalam Pengiriman --}}
        <div class="timeline-item {{ in_array($pesanan->status_pesanan, ['dalam_pengiriman', 'diterima']) ? '' : 'is-pending' }}">
            <div class="timeline-dot {{ $pesanan->status_pesanan == 'dalam_pengiriman' ? 'active' : (in_array($pesanan->status_pesanan, ['diterima']) ? 'done' : 'pending') }}">
                <i class="bi bi-truck"></i>
            </div>
            <p class="timeline-step-title">Dalam Pengiriman</p>
            <p class="timeline-step-time">
                @if(in_array($pesanan->status_pesanan, ['dalam_pengiriman', 'diterima']))
                    Menuju Lokasi
                @else
                    Menunggu
                @endif
            </p>
        </div>

        {{-- Pesanan Diterima --}}
        <div class="timeline-item {{ $pesanan->status_pesanan == 'diterima' ? '' : 'is-pending' }}">
            <div class="timeline-dot {{ $pesanan->status_pesanan == 'diterima' ? 'done' : 'pending' }}">
                <i class="bi bi-check-all"></i>
            </div>
            <p class="timeline-step-title">Pesanan Diterima</p>
            <p class="timeline-step-time">
                @if($pesanan->status_pesanan == 'diterima')
                    Selesai
                @else
                    Estimasi {{ $pesanan->estimasi_tiba ? \Carbon\Carbon::parse($pesanan->estimasi_tiba)->format('H:i') . ' WIB' : '-' }}
                @endif
            </p>
        </div>
    </div>
</div>

{{-- ===== BUKTI PENGIRIMAN ===== --}}
<form action="{{ route('driver.tugas.updateStatus', $pesanan->id_pesanan) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PATCH')

    <div class="bukti-section fade-up delay-4">
        <h2 class="bukti-title">Bukti Pengiriman</h2>
        <div class="bukti-grid">
            <label for="foto-bukti" class="bukti-photo-box" id="bukti-photo-preview">
                @if($pesanan->bukti_pengiriman)
                    <img src="{{ asset('storage/' . $pesanan->bukti_pengiriman) }}" alt="Bukti">
                @else
                    <i class="bi bi-camera"></i>
                    <span>Unggah Foto Bukti</span>
                @endif
                <input type="file" id="foto-bukti" name="bukti_pengiriman" accept="image/*" style="display:none;">
            </label>

            <div class="bukti-form-fields">
                <div class="form-field">
                    <label for="nama-penerima">Nama Penerima</label>
                    <input type="text" id="nama-penerima" name="nama_penerima"
                           placeholder="Contoh: Ibu Rina (Asisten)"
                           value="{{ old('nama_penerima') }}">
                </div>
                <div class="form-field">
                    <label for="catatan-driver">Catatan Driver</label>
                    <textarea id="catatan-driver" name="catatan_driver" rows="3"
                              placeholder="Kondisi barang saat diterima...">{{ old('catatan_driver') }}</textarea>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== STATUS BUTTONS ===== --}}
    <div class="status-buttons fade-up delay-5">
        <button type="submit" name="status" value="diambil" class="status-btn {{ $pesanan->status_pesanan == 'diambil' ? 'active-status' : '' }}">
            Diambil
        </button>
        <button type="submit" name="status" value="dalam_pengiriman" class="status-btn {{ $pesanan->status_pesanan == 'dalam_pengiriman' ? 'active-status' : '' }}">
            Dalam Pengiriman
        </button>
        <button type="submit" name="status" value="diterima" class="status-btn {{ $pesanan->status_pesanan == 'diterima' ? 'active-status' : '' }}">
            Diterima
        </button>
        <button type="submit" name="status" value="gagal_kirim" class="status-btn btn-gagal {{ $pesanan->status_pesanan == 'gagal_kirim' ? 'active-status' : '' }}">
            Gagal Kirim
        </button>
    </div>
</form>

@endsection

@push('scripts')
<script>
    // Preview uploaded photo
    document.getElementById('foto-bukti').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(ev) {
                const box = document.getElementById('bukti-photo-preview');
                box.innerHTML = '<img src="' + ev.target.result + '" alt="Preview">';
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endpush
