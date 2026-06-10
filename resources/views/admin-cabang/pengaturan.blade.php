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

{{-- Pembungkus Utama Informasi Cabang --}}
<div class="glass-card mb-4" style="padding: 24px;">
    <p class="settings-section-title">Informasi Cabang</p>
    <p class="settings-section-sub mb-4">Informasi identitas, operasional, dan penanggung jawab cabang Anda yang dikelola oleh Super Admin.</p>

    {{-- Premium Branch Card (Full Width) --}}
    <div class="branch-info-card-premium mb-4">
        <div class="branch-code-premium">CBR-00{{ $cabang->id_cabang ?? '1' }}</div>
        <div class="branch-name-premium">{{ $cabang->nama_cabang ?? 'Borma Toserba' }}</div>
        <p class="branch-address-premium">
            <i class="bi bi-geo-alt-fill me-1" style="color: var(--borma-secondary);"></i>
            {{ $cabang->alamat_cabang ?? 'Alamat Cabang' }}
        </p>
    </div>

    {{-- Detail Operasional & Penanggung Jawab --}}
    <div class="row g-4">
        {{-- Branch Detail Operasional --}}
        <div class="col-md-6">
            <div style="background: #F9FAFB; border-radius: 12px; padding: 18px; border: 1px solid #F3F4F6;" class="h-100 dark:bg-black/20 dark:border-white/5">
                <p class="settings-section-title" style="font-size: 0.95rem; margin-bottom: 12px;">Detail Operasional</p>
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
        
        {{-- Penanggung Jawab Info --}}
        <div class="col-md-6">
            <div style="background: #F9FAFB; border-radius: 12px; padding: 18px; border: 1px solid #F3F4F6;" class="h-100 dark:bg-black/20 dark:border-white/5">
                <p class="settings-section-title" style="font-size: 0.95rem; margin-bottom: 12px;">Penanggung Jawab</p>
                <div class="detail-item-row">
                    <span class="detail-item-label">Nama Lengkap</span>
                    <span class="detail-item-val">{{ $admin->nama }}</span>
                </div>
                <div class="detail-item-row">
                    <span class="detail-item-label">Email Resmi</span>
                    <span class="detail-item-val">{{ $admin->email }}</span>
                </div>
                <div class="detail-item-row">
                    <span class="detail-item-label">No. Telepon / HP</span>
                    <span class="detail-item-val">{{ $admin->no_telepon ?? '—' }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Tingkat Bawah: Form Ubah Kata Sandi (Premium Split Layout) --}}
<div class="glass-card mb-4" style="padding: 24px;">
    <div class="row g-4">
        {{-- Kolom Kiri: Tips Keamanan / Ilustrasi --}}
        <div class="col-md-5 d-flex flex-column justify-content-center border-b md:border-b-0 md:border-r border-slate-100 dark:border-white/10 pb-4 md:pb-0">
            <div class="text-center p-3">
                <i class="bi bi-shield-lock-fill" style="font-size: 3.5rem; color: var(--borma-primary);"></i>
                <p class="settings-section-title mt-3" style="font-size: 1.2rem;">Keamanan Akun</p>
                <p class="text-muted" style="font-size: 0.8rem; line-height: 1.6;">
                    Demi menjaga keamanan akses data Borma Toserba, harap gunakan kata sandi yang kuat dan ubah secara berkala.
                </p>
                <div style="background: rgba(254, 213, 11, 0.1); border-radius: 10px; padding: 14px; border: 1px solid rgba(254, 213, 11, 0.2); margin-top: 15px;" class="text-start">
                    <p class="m-0 text-slate-700 dark:text-amber-200" style="font-size: 0.75rem; font-weight: 700; line-height: 1.4;">
                        <i class="bi bi-info-circle-fill me-1"></i> Rekomendasi:
                    </p>
                    <ul class="mb-0 ps-3 text-slate-600 dark:text-slate-300" style="font-size: 0.72rem; list-style-type: disc; margin-top: 4px;">
                        <li>Minimal 8 karakter</li>
                        <li>Kombinasi huruf besar & kecil</li>
                        <li>Gunakan angka & karakter spesial</li>
                    </ul>
                </div>
            </div>
        </div>
        
        {{-- Kolom Kanan: Form Ubah Kata Sandi --}}
        <div class="col-md-7">
            <div class="p-3">
                <p class="settings-section-title">Ubah Kata Sandi</p>
                <p class="settings-section-sub">Perbarui kata sandi akun Anda secara berkala untuk menjaga keamanan akses.</p>

                <form action="{{ route('admin-cabang.pengaturan.password') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="setting-field-label">Kata Sandi Saat Ini</label>
                        <div class="relative">
                            <input type="password" name="password_lama" class="setting-input pr-10" placeholder="Masukkan kata sandi saat ini" required>
                            <button type="button" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 dark:text-slate-500 dark:hover:text-slate-300 focus:outline-none toggle-password">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="setting-field-label">Kata Sandi Baru</label>
                        <div class="relative">
                            <input type="password" name="password_baru" class="setting-input pr-10" placeholder="Minimal 8 karakter" required>
                            <button type="button" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 dark:text-slate-500 dark:hover:text-slate-300 focus:outline-none toggle-password">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="setting-field-label">Konfirmasi Kata Sandi Baru</label>
                        <div class="relative">
                            <input type="password" name="password_baru_confirmation" class="setting-input pr-10" placeholder="Masukkan kembali kata sandi baru" required>
                            <button type="button" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 dark:text-slate-500 dark:hover:text-slate-300 focus:outline-none toggle-password">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div style=" padding-top: 20px;" class="text-end">
                        <button type="submit" class="btn-action btn-action-primary" style="border-radius: 10px; font-weight: 800; font-size: 0.8rem; text-transform: none; letter-spacing: 0; padding: 10px 20px; font-family: var(--font-heading);">Perbarui Kata Sandi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="{{ asset('js/admin-cabang/pengaturan.js') }}"></script>
@endpush
@endsection
