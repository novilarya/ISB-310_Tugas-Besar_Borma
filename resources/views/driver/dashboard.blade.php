@extends('driver.layouts.app')

@section('title', 'Dashboard')
@section('header_sub', 'Dashboard Driver')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/driver/dashboard.css') }}">
@endpush

@section('content')

{{-- ===== GREETING ===== --}}
<div class="greeting-section fade-up">
    <p class="greeting-label">Selamat datang,</p>
    <h1 class="driver-name">{{ strtoupper(Auth::check() ? Auth::user()->nama : ($kurir->user->nama ?? 'DRIVER')) }}</h1>
    <p class="driver-cabang">
        Cabang: <span>{{ strtoupper($kurir->cabang->nama_cabang ?? 'Tidak Diketahui') }} — {{ $kurir->kode_driver ?? '-' }}</span>
    </p>
</div>

{{-- ===== STAT CARDS ===== --}}
<div class="stat-grid fade-up delay-1">
    {{-- Tugas Aktif --}}
    <div class="stat-card active-card">
        <span class="stat-label">Tugas Aktif</span>
        <span class="stat-value">{{ str_pad($tugasAktif, 2, '0', STR_PAD_LEFT) }}</span>
        <span class="stat-unit">Pengiriman</span>
    </div>

    {{-- Selesai Hari Ini --}}
    <div class="stat-card">
        <span class="stat-label">Selesai Hari Ini</span>
        <span class="stat-value">{{ str_pad($selesaiHariIni, 2, '0', STR_PAD_LEFT) }}</span>
        <span class="stat-unit">Pesanan</span>
    </div>
</div>

{{-- ===== TUGAS BERIKUTNYA ===== --}}
<p class="section-label fade-up delay-2">Tugas Berikutnya</p>

@if($tugasBerikutnya && in_array($tugasBerikutnya->status_pesanan, ['diterima_driver', 'diambil', 'dalam_pengiriman']))
@php
    $statusLabels = [
        'diterima_driver' => 'Diterima Driver',
        'diambil' => 'Diambil Dari Gudang',
        'dalam_pengiriman' => 'Dalam Pengiriman'
    ];
    $statusClasses = [
        'diterima_driver' => 'status-confirmed',
        'diambil' => 'status-confirmed',
        'dalam_pengiriman' => 'status-pending'
    ];
    $indicatorLabel = $statusLabels[$tugasBerikutnya->status_pesanan] ?? 'Dikonfirmasi';
    $indicatorClass = $statusClasses[$tugasBerikutnya->status_pesanan] ?? 'status-confirmed';
@endphp
<div class="next-task-card fade-up delay-2" id="next-task-card">
    <div class="task-header">
        <div>
            <p class="task-id">ID TUGAS: {{ $tugasBerikutnya->id_pesanan }}</p>
            <p class="task-name">Pengiriman Pesanan</p>
        </div>
        <div class="task-truck-icon">
            <i class="bi bi-truck"></i>
        </div>
    </div>

    <div class="task-status-indicator {{ $indicatorClass }}">
        <span class="status-dot-sm"></span>
        {{ $indicatorLabel }}
    </div>

    <div class="task-meta">
        <div class="task-meta-item">
            <i class="bi bi-geo-alt-fill"></i>
            <span>{{ $tugasBerikutnya->cabang->nama_cabang ?? 'Gudang Pusat' }}</span>
        </div>
        <div class="task-meta-item">
            <i class="bi bi-clock-fill"></i>
            <span>Estimasi: {{ $tugasBerikutnya->estimasi_tiba ? \Carbon\Carbon::parse($tugasBerikutnya->estimasi_tiba)->format('H:i') . ' WIB' : 'Menunggu' }}</span>
        </div>
        <div class="task-meta-item">
            <i class="bi bi-person-fill"></i>
            <span>{{ $tugasBerikutnya->pelanggan->user->nama ?? 'Pelanggan' }}</span>
        </div>
    </div>

    <a href="{{ route('driver.tugas.show', $tugasBerikutnya->id_pesanan) }}" class="btn-start-journey" id="btn-mulai-perjalanan">
        <i class="bi bi-play-fill me-1"></i> Lanjutkan Perjalanan
    </a>
</div>
@else
{{-- ===== STACKED CARDS UNTUK ANTREAN ===== --}}
@include('driver.components.stacked-cards')
@endif

{{-- ===== MENU PINTAS ===== --}}
<p class="section-label fade-up delay-3">Menu Pintas</p>

<div class="quick-menu-list fade-up delay-3">
    <a href="{{ route('driver.tugas.index') }}" class="quick-menu-item" id="menu-daftar-tugas">
        <div class="quick-menu-left">
            <i class="bi bi-list-task"></i>
            <span>Daftar Tugas</span>
        </div>
        <i class="bi bi-arrow-right arrow"></i>
    </a>
    <a href="{{ route('driver.riwayat.index') }}" class="quick-menu-item" id="menu-riwayat">
        <div class="quick-menu-left">
            <i class="bi bi-clock-history"></i>
            <span>Riwayat Pengiriman</span>
        </div>
        <i class="bi bi-arrow-right arrow"></i>
    </a>
    <a href="{{ route('driver.profil.index') }}" class="quick-menu-item" id="menu-profil">
        <div class="quick-menu-left">
            <i class="bi bi-person-circle"></i>
            <span>Profil Driver</span>
        </div>
        <i class="bi bi-arrow-right arrow"></i>
    </a>
</div>

{{-- ===== STATUS BAR ===== --}}
<div class="status-bar fade-up delay-5">
    <div class="status-online">
        <span class="status-dot"></span>
        <span>Status Sistem: Online</span>
    </div>
    <span class="status-version">v2.4.0-Stable</span>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    function confirmPesanan(pesananId) {
        Swal.fire({
            title: 'Konfirmasi Pesanan',
            text: 'Apakah Anda yakin ingin mengkonfirmasi dan menerima pesanan ini?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: '✓ Ya, Konfirmasi',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#33116C',
            cancelButtonColor: '#E4E0EE',
            reverseButtons: true,
            customClass: {
                confirmButton: 'swal-btn-confirm',
                cancelButton: 'swal-btn-cancel'
            },
            didOpen: (modal) => {
                const cancel = modal.querySelector('.swal2-cancel');
                if (cancel) cancel.style.color = '#2B2B2B';
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading
                Swal.fire({
                    title: 'Memproses...',
                    text: 'Mengirim konfirmasi pesanan',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => { Swal.showLoading(); }
                });

                fetch(`/driver/tugas/${pesananId}/confirm`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({})
                }).then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Pesanan berhasil dikonfirmasi. Silakan mulai perjalanan.',
                            icon: 'success',
                            confirmButtonColor: '#33116C',
                            timer: 2000,
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
                        text: 'Terjadi kesalahan komunikasi dengan server',
                        icon: 'error',
                        confirmButtonColor: '#33116C'
                    });
                });
            }
        });
    }

    function openRejectModal(pesananId) {
        Swal.fire({
            title: 'Tolak Pengiriman',
            html: `
                <p style="font-size: 13px; color: #7a7a9a; margin-bottom: 16px;">
                    Silakan tuliskan alasan penolakan pesanan ini. Minimal 10 karakter.
                </p>
                <textarea id="swal-alasan" class="swal2-textarea" 
                    placeholder="Contoh: Kendaraan sedang dalam perbaikan, tidak bisa mengirim hari ini..."
                    style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; min-height: 100px; border-radius: 8px; border: 1.5px solid #E4E0EE; resize: none;"
                ></textarea>
            `,
            icon: 'warning',
            iconColor: '#EB3B02',
            showCancelButton: true,
            confirmButtonText: '✕ Tolak Pesanan',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#EB3B02',
            cancelButtonColor: '#E4E0EE',
            reverseButtons: true,
            customClass: {
                confirmButton: 'swal-btn-reject',
                cancelButton: 'swal-btn-cancel'
            },
            didOpen: (modal) => {
                const cancel = modal.querySelector('.swal2-cancel');
                if (cancel) cancel.style.color = '#2B2B2B';
            },
            preConfirm: () => {
                const alasan = document.getElementById('swal-alasan').value.trim();
                if (!alasan) {
                    Swal.showValidationMessage('Alasan penolakan harus diisi');
                    return false;
                }
                if (alasan.length < 10) {
                    Swal.showValidationMessage('Alasan minimal 10 karakter');
                    return false;
                }
                return alasan;
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const alasan = result.value;

                Swal.fire({
                    title: 'Memproses...',
                    text: 'Mengirim penolakan pesanan',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => { Swal.showLoading(); }
                });

                fetch(`/driver/tugas/${pesananId}/reject`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ alasan: alasan })
                }).then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            title: 'Pesanan Ditolak',
                            text: 'Pesanan telah dikembalikan ke admin/dispatcher.',
                            icon: 'success',
                            confirmButtonColor: '#33116C',
                            timer: 2000,
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
                        text: 'Terjadi kesalahan komunikasi dengan server',
                        icon: 'error',
                        confirmButtonColor: '#33116C'
                    });
                });
            }
        });
    }
</script>
@endpush

@endsection
