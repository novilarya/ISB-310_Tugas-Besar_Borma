@extends('driver.layouts.app')

@section('title', 'Profil Driver')
@section('header_sub', 'Profil')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/driver/profil.css') }}">
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
