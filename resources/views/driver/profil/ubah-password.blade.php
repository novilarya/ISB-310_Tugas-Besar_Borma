@extends('driver.layouts.app')

@section('title', 'Ubah Password')
@section('header_sub', 'Ubah Password')

@push('styles')
<style>
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

    .form-container {
        background: var(--color-surface);
        border: 1.5px solid var(--color-border);
        border-radius: var(--radius-md);
        padding: 20px;
        box-shadow: var(--shadow-card);
    }
    
    .form-group {
        margin-bottom: 16px;
    }
    
    .form-label {
        display: block;
        font-family: var(--font-body);
        font-size: 12px;
        font-weight: 600;
        margin-bottom: 8px;
        color: var(--color-neutral);
    }
    
    .form-control {
        width: 100%;
        padding: 12px 14px;
        border: 1.5px solid var(--color-border);
        border-radius: var(--radius-sm);
        font-family: var(--font-body);
        font-size: 14px;
        outline: none;
        box-sizing: border-box;
    }
    
    .form-control:focus {
        border-color: var(--color-primary);
    }
    
    .btn-submit {
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
        background: var(--color-primary);
        color: white;
        border: none;
        cursor: pointer;
        margin-top: 24px;
    }

    .btn-submit:hover {
        background: var(--color-primary-dark, #0056b3);
    }
    
    .text-danger {
        color: red;
        font-size: 11px;
        margin-top: 4px;
        display: block;
    }

    .fade-up {
        opacity: 0;
        transform: translateY(20px);
        animation: fadeUp 0.5s ease forwards;
    }

    @keyframes fadeUp {
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endpush

@section('content')
<div class="page-heading fade-up">
    <h1>Ubah Password</h1>
</div>

<div class="fade-up">
    <div class="form-container">
        <form action="{{ route('driver.profil.ubah-password.post') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label class="form-label">Password Lama</label>
                <input type="password" name="password_lama" class="form-control" required>
                @error('password_lama')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label class="form-label">Password Baru</label>
                <input type="password" name="password_baru" class="form-control" required minlength="8">
                @error('password_baru')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label class="form-label">Konfirmasi Password Baru</label>
                <input type="password" name="password_baru_confirmation" class="form-control" required minlength="8">
            </div>
            
            <button type="submit" class="btn-submit">Simpan Password</button>
        </form>
    </div>
</div>
@endsection
