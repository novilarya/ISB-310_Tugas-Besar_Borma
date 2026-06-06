@extends('admin-cabang.layouts.admin-cabang')
@section('title', 'Pengaturan - Borma Toserba')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin-cabang.css') }}">
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<link rel="stylesheet" href="{{ asset('css/admin-cabang/pengaturan.css') }}">
@endpush

@section('content')
<div class="d-flex justify-content-between align-items-end mb-4">
    <div class="page-header-text">
        <h1 class="page-title mb-2">Pengaturan</h1>
        <p class="page-subtitle text-muted m-0">Kelola kata sandi akun dan pantau informasi cabang Anda.</p>
    </div>
</div>



@if($errors->any())
<div class="alert alert-danger alert-dismissible fade show mb-4" role="alert" style="border-radius: 12px; border: none; font-weight: 600;">
    <ul class="mb-0 ps-3">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="row g-4">
    {{-- Kolom Kiri: Informasi Cabang --}}
    <div class="col-md-6">
        <div class="glass-card h-100" style="padding: 24px;">
            <p class="settings-section-title">Informasi Cabang</p>
            <p class="settings-section-sub">Informasi identitas dan operasional yang dikelola secara terpusat oleh Super Admin.</p>

            {{-- Premium Branch Card --}}
            <div class="branch-info-card-premium">
                <div class="branch-code-premium">CBR-00{{ $cabang->id_cabang ?? '1' }}</div>
                <div class="branch-name-premium">{{ $cabang->nama_cabang ?? 'Borma Toserba' }}</div>
                <p class="branch-address-premium">
                    <i class="bi bi-geo-alt-fill me-1" style="color: var(--borma-secondary);"></i>
                    {{ $cabang->alamat_cabang ?? 'Alamat Cabang' }}
                </p>
            </div>

            {{-- Branch Detail Operasional (Sesuai Migrasi) --}}
            <div style="background: #F9FAFB; border-radius: 12px; padding: 18px; border: 1px solid #F3F4F6;">
                <div class="detail-item-row">
                    <span class="detail-item-label">ID Cabang</span>
                    <span class="detail-item-val" style="font-family: monospace; color: var(--borma-primary);">#CBR-00{{ $cabang->id_cabang ?? '1' }}</span>
                </div>
                <div class="detail-item-row">
                    <span class="detail-item-label">Nama Cabang</span>
                    <span class="detail-item-val">{{ $cabang->nama_cabang ?? 'Nama Cabang' }}</span>
                </div>
                <div class="detail-item-row">
                    <span class="detail-item-label">Koordinat GPS</span>
                    <span class="detail-item-val" style="font-family: monospace;">{{ $cabang->koordinat_gps ?? '—' }}</span>
                </div>
                <div class="detail-item-row">
                    <span class="detail-item-label">Status Cabang</span>
                    <span class="detail-item-val">
                        <span class="status-badge-modern status-selesai" style="font-size: 0.65rem;">{{ strtoupper($cabang->status ?? 'Aktif') }}</span>
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- Kolom Kanan: Ubah Password --}}
    <div class="col-md-6">
        <div class="glass-card h-100" style="padding: 24px;">
            <p class="settings-section-title">Ubah Kata Sandi</p>
            <p class="settings-section-sub">Perbarui kata sandi akun Anda secara berkala untuk menjaga keamanan akses.</p>

            <form action="{{ route('admin-cabang.pengaturan.password') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="setting-field-label">Kata Sandi Saat Ini</label>
                    <input type="password" name="password_lama" class="setting-input" placeholder="Masukkan kata sandi saat ini" required>
                </div>
                <div class="mb-3">
                    <label class="setting-field-label">Kata Sandi Baru</label>
                    <input type="password" name="password_baru" class="setting-input" placeholder="Minimal 8 karakter" required>
                </div>
                <div class="mb-4">
                    <label class="setting-field-label">Konfirmasi Kata Sandi Baru</label>
                    <input type="password" name="password_baru_confirmation" class="setting-input" placeholder="Masukkan kembali kata sandi baru" required>
                </div>

                <div style="border-top: 1px solid #F3F4F6; padding-top: 20px;" class="text-end">
                    <button type="submit" class="btn-action btn-action-primary" style="border-radius: 10px; font-weight: 800; font-size: 0.8rem; text-transform: none; letter-spacing: 0; padding: 10px 20px; font-family: var(--font-heading);">
                        <i class="bi bi-shield-lock me-1"></i> Perbarui Kata Sandi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
