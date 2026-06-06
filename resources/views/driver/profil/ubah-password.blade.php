@extends('driver.layouts.app')

@section('title', 'Ubah Password')
@section('header_sub', 'Ubah Password')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/driver/ubah-password.css') }}">
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
