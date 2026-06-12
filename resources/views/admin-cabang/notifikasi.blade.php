@extends('admin-cabang.layouts.admin-cabang')
@section('title', 'Notifikasi - Borma Toserba')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin-cabang.css') }}">
<link rel="stylesheet" href="{{ asset('css/admin-cabang/notifikasi.css') }}">
@endpush

@section('content')
<div class="d-flex justify-content-between align-items-end mb-4">
    <div class="page-header-text">
        <h1 class="page-title mb-2">Semua Notifikasi</h1>
        <p class="page-subtitle text-muted m-0">Pantau semua aktivitas dan peringatan terkait cabang Anda.</p>
    </div>
    <div>
        <button class="btn-action btn-action-outline" onclick="markAllAsReadFromTopbar(event)">
            <i class="bi bi-check2-all me-1"></i> Tandai Semua Dibaca
        </button>
    </div>
</div>

<div class="glass-card p-0 overflow-hidden">
    @forelse($notifications as $n)
    <div class="notif-page-item {{ $n['unread'] ? 'notif-unread' : '' }}" data-id="{{ $n['id'] }}">
        <div class="notif-page-icon {{ $n['icon_bg'] }}" style="border-radius:12px; width:44px; height:44px; display:flex; align-items:center; justify-content:center; font-size:1.2rem; flex-shrink: 0;">
            <i class="fa-solid {{ $n['icon'] }}"></i>
        </div>
        <div class="notif-page-content flex-grow-1 ms-3">
            <h6 class="font-bold text-slate-800 dark:text-white">{{ $n['title'] }}</h6>
            <p class="text-sm text-slate-600 dark:text-white/70 mt-1">{{ $n['message'] }}</p>
            <div class="notif-page-time text-xs text-slate-400 dark:text-white/40 mt-1">
                <i class="fa-regular fa-clock me-1"></i> {{ $n['time'] }}
            </div>
        </div>
        <div class="ms-3">
            <a href="{{ $n['url'] }}" class="btn-action btn-action-outline btn-action-sm">Lihat</a>
        </div>
    </div>
    @empty
    <div class="text-center py-5 text-muted">
        <i class="bi bi-bell-slash" style="font-size:3rem;opacity:.2;"></i>
        <p class="mt-3 mb-0" style="font-weight:600;">Tidak ada notifikasi saat ini.</p>
    </div>
    @endforelse
</div>


@endsection
