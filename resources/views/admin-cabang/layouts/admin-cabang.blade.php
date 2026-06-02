@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin-cabang.css') }}">
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<style>
    /* Dropdown overrides for topbar */
    .topbar-dropdown .dropdown-menu {
        border: none;
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        padding: 8px 0;
        margin-top: 10px !important;
    }
    .topbar-dropdown .dropdown-item {
        padding: 10px 20px;
        font-size: 0.85rem;
        font-weight: 600;
        color: #4B5563;
        display: flex;
        align-items: center;
        gap: 12px;
        transition: all 0.2s;
    }
    .topbar-dropdown .dropdown-item:hover {
        background: rgba(51, 17, 108, 0.05);
        color: var(--borma-primary);
    }
    .notif-item {
        padding: 12px 20px;
        border-bottom: 1px solid #F3F4F6;
        display: flex;
        gap: 12px;
        align-items: start;
        text-decoration: none;
        transition: background 0.2s;
    }
    .notif-item:hover { background: #F9FAFB; }
    .notif-item:last-child { border-bottom: none; }
    .notif-icon {
        width: 36px; height: 36px;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .dropdown-toggle::after { display: none; } /* Hide bootstrap caret */
</style>
@endpush

@section('sidebar')
    @include('admin-cabang.partial.sidebar')
@endsection

@section('topbar')
    @include('admin-cabang.partial.topbar')
@endsection
