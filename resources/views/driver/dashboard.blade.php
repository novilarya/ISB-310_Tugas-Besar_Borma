@extends('driver.layouts.app')

@section('title', 'Dashboard')
@section('header_sub', 'Dashboard Driver')

@push('styles')
<style>
    /* ================================================
       DASHBOARD — Driver Greeting Section
    ================================================ */
    .greeting-section {
        margin-bottom: 24px;
    }

    .greeting-section .greeting-label {
        font-family: var(--font-body);
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        color: var(--color-text-muted);
        margin-bottom: 4px;
    }

    .greeting-section .driver-name {
        font-family: var(--font-headline);
        font-size: 28px;
        font-weight: 800;
        color: var(--color-neutral);
        letter-spacing: -0.01em;
        line-height: 1.15;
        text-transform: uppercase;
    }

    .greeting-section .driver-cabang {
        font-family: var(--font-body);
        font-size: 12px;
        font-weight: 600;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: var(--color-text-muted);
        margin-top: 4px;
    }

    .greeting-section .driver-cabang span {
        color: var(--color-primary);
    }

    /* ================================================
       STAT CARDS
    ================================================ */
    .stat-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
        margin-bottom: 28px;
    }

    .stat-card {
        background: var(--color-surface);
        border: 1.5px solid var(--color-border);
        border-radius: var(--radius-md);
        padding: 18px 16px;
        display: flex;
        flex-direction: column;
        gap: 4px;
        box-shadow: var(--shadow-card);
        position: relative;
        overflow: hidden;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 24px rgba(51, 17, 108, 0.13);
    }

    .stat-card.active-card {
        border-color: var(--color-primary);
        background: linear-gradient(135deg, var(--color-primary) 0%, #4a1f9e 100%);
        color: white;
    }

    .stat-card.active-card::after {
        content: '';
        position: absolute;
        top: -20px;
        right: -20px;
        width: 80px;
        height: 80px;
        background: rgba(254, 213, 11, 0.18);
        border-radius: 50%;
    }

    .stat-label {
        font-family: var(--font-body);
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        color: var(--color-text-muted);
    }

    .active-card .stat-label {
        color: rgba(255, 255, 255, 0.75);
    }

    .stat-value {
        font-family: var(--font-headline);
        font-size: 44px;
        font-weight: 800;
        line-height: 1;
        color: var(--color-neutral);
        letter-spacing: -0.03em;
    }

    .active-card .stat-value {
        color: var(--color-secondary);
    }

    .stat-unit {
        font-family: var(--font-body);
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: var(--color-text-muted);
        margin-top: 2px;
    }

    .active-card .stat-unit {
        color: rgba(255, 255, 255, 0.7);
    }

    /* ================================================
       NEXT TASK CARD
    ================================================ */
    .section-label {
        font-family: var(--font-body);
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        color: var(--color-text-muted);
        margin-bottom: 12px;
    }

    .next-task-card {
        background: var(--color-neutral);
        border-radius: var(--radius-md);
        padding: 20px;
        margin-bottom: 28px;
        position: relative;
        overflow: hidden;
    }

    .next-task-card::before {
        content: '';
        position: absolute;
        top: -30px;
        right: -30px;
        width: 120px;
        height: 120px;
        background: rgba(254, 213, 11, 0.06);
        border-radius: 50%;
    }

    .task-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        margin-bottom: 14px;
    }

    .task-id {
        font-family: var(--font-body);
        font-size: 10px;
        font-weight: 600;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: var(--color-text-muted);
        color: rgba(255,255,255,0.5);
        margin-bottom: 4px;
    }

    .task-name {
        font-family: var(--font-headline);
        font-size: 18px;
        font-weight: 700;
        color: white;
        line-height: 1.2;
    }

    .task-truck-icon {
        width: 42px;
        height: 42px;
        background: rgba(255,255,255,0.1);
        border-radius: var(--radius-sm);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--color-secondary);
        font-size: 20px;
        flex-shrink: 0;
    }

    .task-meta {
        display: flex;
        flex-direction: column;
        gap: 6px;
        margin-bottom: 18px;
    }

    .task-meta-item {
        display: flex;
        align-items: center;
        gap: 8px;
        font-family: var(--font-body);
        font-size: 12px;
        font-weight: 500;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        color: rgba(255, 255, 255, 0.7);
    }

    .task-meta-item i {
        font-size: 13px;
        color: var(--color-secondary);
        flex-shrink: 0;
    }

    /* Status Badge di Card */
    .task-status-indicator {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 12px;
        border-radius: 100px;
        font-family: var(--font-body);
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        margin-bottom: 12px;
    }

    .task-status-indicator.status-pending {
        background: rgba(254, 213, 11, 0.2);
        color: var(--color-secondary);
    }

    .task-status-indicator.status-confirmed {
        background: rgba(34, 197, 94, 0.2);
        color: #22c55e;
    }

    .task-status-indicator .status-dot-sm {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: currentColor;
    }

    .btn-start-journey {
        display: block;
        width: 100%;
        padding: 14px;
        background: var(--color-secondary);
        color: var(--color-neutral);
        border: none;
        border-radius: var(--radius-sm);
        font-family: var(--font-headline);
        font-size: 13px;
        font-weight: 800;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        text-align: center;
        cursor: pointer;
        transition: background 0.2s, transform 0.15s, box-shadow 0.2s;
        text-decoration: none;
    }

    .btn-start-journey:hover {
        background: var(--color-secondary-dark);
        transform: translateY(-1px);
        box-shadow: 0 4px 16px rgba(254, 213, 11, 0.4);
        color: var(--color-neutral);
    }

    .btn-start-journey:active { transform: translateY(0); }

    /* Action Buttons Group */
    .task-action-buttons {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
    }

    .btn-action {
        padding: 14px;
        background: var(--color-secondary);
        color: var(--color-neutral);
        border: none;
        border-radius: var(--radius-sm);
        font-family: var(--font-headline);
        font-size: 12px;
        font-weight: 800;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        text-align: center;
        cursor: pointer;
        transition: background 0.2s, transform 0.15s, box-shadow 0.2s;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }

    .btn-action:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 16px rgba(254, 213, 11, 0.4);
    }

    .btn-action:active { transform: translateY(0); }

    .btn-confirm {
        background: var(--color-secondary);
        color: var(--color-neutral);
    }

    .btn-confirm:hover {
        background: #e6c200;
    }

    .btn-reject {
        background: var(--color-tertiary);
        color: white;
    }

    .btn-reject:hover {
        background: #dc2626;
    }

    /* No Task State */
    .no-task-card {
        background: var(--color-surface);
        border: 1.5px dashed var(--color-border);
        border-radius: var(--radius-md);
        padding: 32px 20px;
        text-align: center;
        margin-bottom: 28px;
    }

    .no-task-card i {
        font-size: 36px;
        color: var(--color-border);
        display: block;
        margin-bottom: 8px;
    }

    .no-task-card p {
        font-family: var(--font-body);
        font-size: 13px;
        color: var(--color-text-muted);
    }

    /* ================================================
       QUICK MENU
    ================================================ */
    .quick-menu-list {
        background: var(--color-surface);
        border-radius: var(--radius-md);
        overflow: hidden;
        border: 1.5px solid var(--color-border);
        box-shadow: var(--shadow-card);
        margin-bottom: 28px;
    }

    .quick-menu-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 16px 18px;
        font-family: var(--font-body);
        font-size: 13px;
        font-weight: 600;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: var(--color-neutral);
        text-decoration: none;
        border-bottom: 1px solid var(--color-border);
        transition: background 0.2s, padding-left 0.2s;
    }

    .quick-menu-item:last-child { border-bottom: none; }

    .quick-menu-item:hover {
        background: var(--color-primary-pale);
        padding-left: 22px;
        color: var(--color-primary);
    }

    .quick-menu-left {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .quick-menu-left i {
        font-size: 18px;
        color: var(--color-primary);
        width: 20px;
        text-align: center;
    }

    .quick-menu-item .arrow {
        font-size: 16px;
        color: var(--color-text-muted);
        transition: transform 0.2s;
    }

    .quick-menu-item:hover .arrow {
        transform: translateX(4px);
        color: var(--color-primary);
    }

    /* ================================================
       STATUS BAR
    ================================================ */
    .status-bar {
        background: var(--color-surface);
        border: 1.5px solid var(--color-border);
        border-radius: var(--radius-sm);
        padding: 10px 16px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 8px;
    }

    .status-online {
        display: flex;
        align-items: center;
        gap: 8px;
        font-family: var(--font-body);
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: var(--color-neutral);
    }

    .status-dot {
        width: 8px;
        height: 8px;
        background: #22c55e;
        border-radius: 50%;
        animation: pulse-dot 1.8s ease-in-out infinite;
    }

    @keyframes pulse-dot {
        0%, 100% { opacity: 1; transform: scale(1); }
        50%       { opacity: 0.5; transform: scale(0.8); }
    }

    .status-version {
        font-family: var(--font-body);
        font-size: 10px;
        font-weight: 500;
        color: var(--color-text-muted);
        letter-spacing: 0.06em;
    }

    /* ================================================
       ENTRY ANIMATION
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

    /* ================================================
       SWAL CUSTOM
    ================================================ */
    .swal2-popup {
        font-family: var(--font-body) !important;
        border-radius: var(--radius-md) !important;
    }
    .swal2-title {
        font-family: var(--font-headline) !important;
    }
</style>
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

    <div class="task-status-indicator status-confirmed">
        <span class="status-dot-sm"></span>
        Dikonfirmasi
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
