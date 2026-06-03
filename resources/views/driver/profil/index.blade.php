@extends('driver.layouts.app')

@section('title', 'Profil Driver')
@section('header_sub', 'Profil')

@push('styles')
<style>
    /* ================================================
       PAGE HEADING
    ================================================ */
    .page-heading {
        margin-bottom: 20px;
    }

    .page-heading h1 {
        font-family: var(--font-headline);
        font-size: 28px;
        font-weight: 800;
        color: var(--color-neutral);
        text-transform: uppercase;
        line-height: 1.15;
        margin-bottom: 4px;
        position: relative;
        display: inline-block;
    }

    .page-heading h1::after {
        content: '';
        display: block;
        width: 48px;
        height: 3px;
        background: var(--color-primary);
        border-radius: 2px;
        margin-top: 8px;
    }

    /* ================================================
       PROFILE CARD
    ================================================ */
    .profile-card {
        background: var(--color-surface);
        border: 1.5px solid var(--color-border);
        border-radius: var(--radius-md);
        padding: 20px;
        margin-bottom: 14px;
        box-shadow: var(--shadow-card);
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .profile-avatar {
        width: 72px;
        height: 72px;
        border-radius: var(--radius-sm);
        background: var(--color-bg);
        border: 2px solid var(--color-border);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        overflow: hidden;
    }

    .profile-avatar i {
        font-size: 32px;
        color: var(--color-text-muted);
    }

    .profile-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .profile-info {
        flex: 1;
    }

    .profile-role {
        font-family: var(--font-body);
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        color: var(--color-primary);
        margin-bottom: 2px;
    }

    .profile-name {
        font-family: var(--font-headline);
        font-size: 20px;
        font-weight: 800;
        color: var(--color-neutral);
        text-transform: uppercase;
        line-height: 1.2;
    }

    .profile-id {
        font-family: var(--font-body);
        font-size: 12px;
        font-weight: 500;
        color: var(--color-text-muted);
        margin-top: 2px;
    }

    /* ================================================
       CABANG / STATUS ROW
    ================================================ */
    .status-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
        margin-bottom: 14px;
    }

    .status-item {
        background: var(--color-surface);
        border: 1.5px solid var(--color-border);
        border-radius: var(--radius-md);
        padding: 14px 16px;
        box-shadow: var(--shadow-card);
    }

    .status-item-label {
        font-family: var(--font-body);
        font-size: 10px;
        font-weight: 600;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: var(--color-text-muted);
        margin-bottom: 4px;
    }

    .status-item-value {
        font-family: var(--font-body);
        font-size: 15px;
        font-weight: 600;
        color: var(--color-neutral);
    }

    /* ================================================
       DETAIL INFO CARD
    ================================================ */
    .detail-card {
        background: var(--color-surface);
        border: 1.5px solid var(--color-border);
        border-radius: var(--radius-md);
        padding: 18px;
        margin-bottom: 14px;
        box-shadow: var(--shadow-card);
    }

    .detail-row {
        padding: 14px 0;
        border-bottom: 1px solid var(--color-border);
    }

    .detail-row:first-child { padding-top: 0; }
    .detail-row:last-child  { border-bottom: none; padding-bottom: 0; }

    .detail-label {
        font-family: var(--font-body);
        font-size: 10px;
        font-weight: 600;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: var(--color-text-muted);
        margin-bottom: 4px;
    }

    .detail-value {
        font-family: var(--font-body);
        font-size: 15px;
        font-weight: 600;
        color: var(--color-neutral);
    }

    /* ================================================
       PERFORMANCE CARD
    ================================================ */
    .perf-grid {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 10px;
        margin-bottom: 14px;
    }

    @media (max-width: 400px) {
        .perf-grid { grid-template-columns: 1fr; }
    }

    .perf-card {
        background: var(--color-surface);
        border: 1.5px solid var(--color-border);
        border-radius: var(--radius-md);
        padding: 14px;
        text-align: center;
        box-shadow: var(--shadow-card);
    }

    .perf-card-label {
        font-family: var(--font-body);
        font-size: 10px;
        font-weight: 600;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: var(--color-text-muted);
        margin-bottom: 4px;
    }

    .perf-card-value {
        font-family: var(--font-headline);
        font-size: 24px;
        font-weight: 800;
        color: var(--color-primary);
    }

    .perf-card-unit {
        font-family: var(--font-body);
        font-size: 10px;
        font-weight: 500;
        color: var(--color-text-muted);
        text-transform: uppercase;
        letter-spacing: 0.06em;
    }

    .perf-card .stars {
        display: flex;
        justify-content: center;
        gap: 2px;
        margin-top: 4px;
    }

    .perf-card .stars i {
        font-size: 14px;
        color: var(--color-secondary);
    }

    .perf-card .stars i.empty {
        color: var(--color-border);
    }

    /* ================================================
       ACTION BUTTONS
    ================================================ */
    .btn-action {
        display: block;
        width: 100%;
        text-align: center;
        padding: 14px;
        border-radius: var(--radius-sm);
        font-family: var(--font-headline);
        font-size: 13px;
        font-weight: 700;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
        border: none;
        margin-bottom: 10px;
    }

    .btn-ubah-password {
        background: var(--color-bg);
        border: 1.5px solid var(--color-border);
        color: var(--color-neutral);
    }

    .btn-ubah-password:hover {
        background: var(--color-primary-pale);
        border-color: var(--color-primary);
        color: var(--color-primary);
    }

    .btn-keluar {
        background: var(--color-neutral);
        color: white;
    }

    .btn-keluar:hover {
        background: var(--color-tertiary);
    }

    /* ================================================
       ALERT / FLASH MESSAGE
    ================================================ */
    .alert-success {
        background: #e6f9ee;
        border: 1.5px solid #22c55e;
        border-radius: var(--radius-sm);
        padding: 12px 16px;
        margin-bottom: 16px;
        font-family: var(--font-body);
        font-size: 13px;
        font-weight: 500;
        color: #166534;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .alert-success i { font-size: 16px; }

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

{{-- ===== FLASH MESSAGE ===== --}}
@if(session('success'))
<div class="alert-success fade-up">
    <i class="bi bi-check-circle-fill"></i>
    {{ session('success') }}
</div>
@endif

{{-- ===== HEADING ===== --}}
<div class="page-heading fade-up">
    <h1>Profil</h1>
</div>

{{-- ===== PROFILE CARD ===== --}}
<div class="profile-card fade-up delay-1">
    <div class="profile-avatar">
        @if(isset($user->foto_profil) && $user->foto_profil)
            <img src="{{ asset('storage/' . $user->foto_profil) }}" alt="Avatar">
        @else
            <i class="bi bi-person-fill"></i>
        @endif
    </div>
    <div class="profile-info">
        <p class="profile-role">Driver Aktif</p>
        <p class="profile-name">{{ strtoupper($user->nama) }}</p>
        <p class="profile-id">ID: BRM-{{ $kurir->id_kurir }}</p>
    </div>
</div>

{{-- ===== CABANG & STATUS ===== --}}
<div class="status-row fade-up delay-2">
    <div class="status-item">
        <p class="status-item-label">Cabang</p>
        <p class="status-item-value">{{ $cabang ?? 'Belum ditentukan' }}</p>
    </div>
    <div class="status-item">
        <p class="status-item-label">Status</p>
        <p class="status-item-value">On-Duty</p>
    </div>
</div>

{{-- ===== DETAIL INFO ===== --}}
<div class="detail-card fade-up delay-3">
    <div class="detail-row">
        <p class="detail-label">Email / Username</p>
        <p class="detail-value">{{ $user->email }}</p>
    </div>
    <div class="detail-row">
        <p class="detail-label">Telepon</p>
        <p class="detail-value">{{ $user->no_telepon ?? '-' }}</p>
    </div>
    <div class="detail-row">
        <p class="detail-label">Kendaraan</p>
        <p class="detail-value">{{ $kurir->kendaraan }} ({{ $kurir->plat_nomor }})</p>
    </div>
</div>

{{-- ===== PERFORMA ===== --}}
<div class="perf-grid fade-up delay-4">
    <div class="perf-card">
        <p class="perf-card-label">Total Kirim</p>
        <p class="perf-card-value">{{ $totalKirim ?? 0 }}</p>
        <p class="perf-card-unit">Pesanan</p>
    </div>
    <div class="perf-card">
        <p class="perf-card-label">Berhasil</p>
        <p class="perf-card-value">{{ $berhasil ?? 0 }}</p>
        <p class="perf-card-unit">Pesanan</p>
    </div>
    <div class="perf-card">
        <p class="perf-card-label">Rating</p>
        <p class="perf-card-value">{{ number_format($rating ?? 0, 1) }}</p>
        <div class="stars">
            @for($i = 1; $i <= 5; $i++)
                <i class="bi {{ $i <= round($rating ?? 0) ? 'bi-star-fill' : 'bi-star' }} {{ $i > round($rating ?? 0) ? 'empty' : '' }}"></i>
            @endfor
        </div>
    </div>
</div>

{{-- ===== ACTION BUTTONS ===== --}}
<div class="fade-up delay-5">
    <a href="{{ route('driver.profil.ubah-password') }}" class="btn-action btn-ubah-password" id="btn-ubah-password">
        Ubah Password
    </a>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="btn-action btn-keluar" id="btn-keluar">
            Keluar
        </button>
    </form>
</div>

@endsection
