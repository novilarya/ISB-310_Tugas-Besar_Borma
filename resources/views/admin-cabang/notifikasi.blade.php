@extends('admin-cabang.layouts.admin-cabang')
@section('title', 'Notifikasi - Borma Toserba')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin-cabang.css') }}">
<style>
.notif-page-item {
    padding: 20px;
    border-bottom: 1px solid #F3F4F6;
    display: flex;
    gap: 16px;
    align-items: start;
    transition: all 0.2s;
}
.notif-page-item:hover {
    background: #F9FAFB;
}
.notif-page-item:last-child {
    border-bottom: none;
}
.notif-page-icon {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    font-size: 1.2rem;
}
.notif-page-content h6 {
    font-weight: 800;
    font-size: 1rem;
    margin-bottom: 4px;
    color: var(--borma-neutral);
}
.notif-page-content p {
    font-size: 0.85rem;
    color: #6B7280;
    margin-bottom: 8px;
    line-height: 1.5;
}
.notif-page-time {
    font-size: 0.75rem;
    font-weight: 700;
    color: #9CA3AF;
}
.notif-unread {
    background: rgba(51, 17, 108, 0.03);
}
.notif-unread::before {
    content: '';
    display: block;
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: var(--borma-primary);
    margin-top: 20px;
}
</style>
@endpush

@section('content')
<div class="d-flex justify-content-between align-items-end mb-4">
    <div>
        <h1 class="page-title mb-1">Semua Notifikasi</h1>
        <p class="page-subtitle">Pantau semua aktivitas dan peringatan terkait cabang Anda.</p>
    </div>
    <div>
        <button class="btn-action btn-action-outline" onclick="markAllAsRead()">
            <i class="bi bi-check2-all me-1"></i> Tandai Semua Dibaca
        </button>
    </div>
</div>

<div class="glass-card p-0 overflow-hidden">
    {{-- Item 1 --}}
    <div class="notif-page-item notif-unread">
        <div class="notif-page-icon" style="background: rgba(254, 213, 11, 0.2); color: #D97706;">
            <i class="bi bi-cart-fill"></i>
        </div>
        <div class="notif-page-content flex-grow-1">
            <h6>Pesanan Baru #BRM-9021</h6>
            <p>Budi Santoso telah membuat pesanan baru sebanyak 3 item dengan total tagihan Rp 150.000. Mohon segera siapkan pesanan.</p>
            <div class="notif-page-time"><i class="bi bi-clock me-1"></i> 2 menit yang lalu</div>
        </div>
        <div>
            <a href="{{ route('admin-cabang.pesanan') }}" class="btn-action btn-action-primary btn-action-sm">Lihat Pesanan</a>
        </div>
    </div>

    {{-- Item 2 --}}
    <div class="notif-page-item notif-unread">
        <div class="notif-page-icon" style="background: #ECFDF5; color: #059669;">
            <i class="bi bi-truck"></i>
        </div>
        <div class="notif-page-content flex-grow-1">
            <h6>Pesanan #BRM-9018 Selesai</h6>
            <p>Kurir Asep telah mengonfirmasi bahwa pesanan #BRM-9018 telah diterima oleh pelanggan.</p>
            <div class="notif-page-time"><i class="bi bi-clock me-1"></i> 1 jam yang lalu</div>
        </div>
    </div>

    {{-- Item 3 --}}
    <div class="notif-page-item notif-unread">
        <div class="notif-page-icon" style="background: #FEF2F2; color: #DC2626;">
            <i class="bi bi-exclamation-triangle-fill"></i>
        </div>
        <div class="notif-page-content flex-grow-1">
            <h6>Peringatan Stok Menipis</h6>
            <p>Stok produk <strong>Minyak Goreng 2L</strong> tersisa 5 unit di cabang Anda. Segera lakukan restock.</p>
            <div class="notif-page-time"><i class="bi bi-clock me-1"></i> 2 jam yang lalu</div>
        </div>
        <div>
            <a href="{{ route('admin-cabang.produk') }}" class="btn-action btn-action-outline btn-action-sm">Lihat Produk</a>
        </div>
    </div>

    {{-- Item 4 --}}
    <div class="notif-page-item">
        <div class="notif-page-icon" style="background: #EFF6FF; color: #2563EB;">
            <i class="bi bi-tags-fill"></i>
        </div>
        <div class="notif-page-content flex-grow-1">
            <h6>Promo Berakhir Besok</h6>
            <p>Promo "Diskon Weekend" akan berakhir pada tanggal 13 Mei. Pastikan semua materi promosi dicabut setelah periode selesai.</p>
            <div class="notif-page-time"><i class="bi bi-clock me-1"></i> Kemarin, 14:30</div>
        </div>
        <div>
            <a href="{{ route('admin-cabang.promo') }}" class="btn-action btn-action-outline btn-action-sm">Lihat Promo</a>
        </div>
    </div>
</div>

<script>
function markAllAsRead() {
    markAllAsReadFromTopbar();
}
</script>
@endsection
