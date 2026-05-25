@extends('admin-cabang.layouts.admin-cabang')
@section('title', 'Pengaturan - Borma Toserba')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin-cabang.css') }}">
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<style>
/* ===== SETTINGS PAGE ===== */
.settings-section-title {
    font-size: 1.15rem;
    font-weight: 800;
    color: var(--borma-neutral);
    margin-bottom: 4px;
}
.settings-section-sub {
    font-size: 0.82rem;
    color: #9CA3AF;
    margin-bottom: 24px;
}
.setting-field-label {
    font-size: 0.78rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #374151;
    margin-bottom: 6px;
    display: block;
}
.setting-input {
    width: 100%;
    padding: 10px 14px;
    border: 1.5px solid #E5E7EB;
    border-radius: 10px;
    font-size: 0.88rem;
    font-weight: 600;
    outline: none;
    transition: all 0.2s ease;
    font-family: var(--font-body);
    background: #fff;
    color: var(--borma-neutral);
}
.setting-input:focus {
    border-color: var(--borma-primary);
    box-shadow: 0 0 0 4px rgba(51,17,108,0.08);
}
.setting-input[readonly] {
    background: #F9FAFB;
    color: #6B7280;
    cursor: not-allowed;
    border-color: #E5E7EB;
}

/* Premium Branch Info Card */
.branch-info-card-premium {
    background: linear-gradient(135deg, #240a5e 0%, #17053c 100%);
    border-radius: 16px;
    padding: 24px;
    color: white;
    margin-bottom: 24px;
    position: relative;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(36, 10, 94, 0.15);
}
.branch-info-card-premium::after {
    content: '';
    position: absolute;
    right: -40px; top: -40px;
    width: 180px; height: 180px;
    background: rgba(254, 213, 11, 0.08);
    border-radius: 50%;
    pointer-events: none;
}
.branch-info-card-premium .branch-code-premium {
    font-size: 0.72rem;
    background: rgba(255, 255, 255, 0.15);
    display: inline-block;
    padding: 4px 12px;
    border-radius: 20px;
    font-weight: 800;
    margin-bottom: 14px;
    letter-spacing: 0.5px;
    text-transform: uppercase;
}
.branch-info-card-premium .branch-name-premium {
    font-family: var(--font-heading);
    font-size: 1.6rem;
    font-weight: 800;
    color: var(--borma-secondary);
    margin-bottom: 8px;
}
.branch-info-card-premium .branch-address-premium {
    font-size: 0.85rem;
    color: rgba(255, 255, 255, 0.85);
    line-height: 1.5;
    margin: 0;
    font-weight: 600;
}

/* Detail list styles */
.detail-item-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 0;
    border-bottom: 1px solid #F3F4F6;
}
.detail-item-row:last-child {
    border-bottom: none;
}
.detail-item-label {
    font-size: 0.8rem;
    font-weight: 700;
    color: #6B7280;
}
.detail-item-val {
    font-size: 0.85rem;
    font-weight: 800;
    color: var(--borma-neutral);
    text-align: right;
}
</style>
@endpush

@section('content')
<div class="d-flex justify-content-between align-items-end mb-4">
    <div>
        <h1 class="page-title mb-1">Pengaturan</h1>
        <p class="page-subtitle">Kelola kata sandi akun dan pantau informasi cabang Anda.</p>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show mb-4" role="alert" style="border-radius: 12px; border: none; font-weight: 600;">
    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show mb-4" role="alert" style="border-radius: 12px; border: none; font-weight: 600;">
    <i class="bi bi-x-circle-fill me-2"></i> {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

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
