@extends('super-admin.layouts.app')
@section('title', 'Pengaturan Profil | Super Admin Borma')
@section('page_title', 'Pengaturan Profil')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    {{-- Profil Data Form --}}
    <div class="bg-white dark:bg-white/5 dark:backdrop-blur-xl border border-slate-200 dark:border-white/10 shadow-sm dark:shadow-none rounded-3xl p-6">
        <div class="mb-5 border-b border-slate-200 dark:border-white/10 pb-4">
            <h4 class="text-lg font-bold text-slate-800 dark:text-white flex items-center gap-2">
                <i class="fa-solid fa-user-gear text-borma-purple dark:text-borma-yellow"></i>
                Data Profil
            </h4>
            <p class="text-xs text-slate-500 dark:text-white/40 mt-1">Perbarui informasi profil dan kontak Anda.</p>
        </div>

        <form action="{{ route('superadmin.pengaturan.update') }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-700 dark:text-white/80 mb-2">Nama Lengkap</label>
                <input type="text" name="nama" value="{{ old('nama', $user->nama) }}" required class="w-full bg-slate-50 dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow text-slate-800 dark:text-white transition-all @error('nama') border-red-500 @enderror">
                @error('nama')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-700 dark:text-white/80 mb-2">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full bg-slate-50 dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow text-slate-800 dark:text-white transition-all @error('email') border-red-500 @enderror">
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-slate-700 dark:text-white/80 mb-2">Nomor Telepon</label>
                <input type="text" name="no_telepon" value="{{ old('no_telepon', $user->no_telepon) }}" required class="w-full bg-slate-50 dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow text-slate-800 dark:text-white transition-all @error('no_telepon') border-red-500 @enderror">
                @error('no_telepon')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-borma-purple hover:bg-purple-800 dark:bg-borma-yellow dark:hover:bg-yellow-500 text-white dark:text-slate-900 px-6 py-2.5 rounded-xl text-sm font-bold transition-all shadow-md flex items-center gap-2">
                    <i class="fa-solid fa-save"></i> Simpan Profil
                </button>
            </div>
        </form>
    </div>

    {{-- Ubah Password Form --}}
    <div class="bg-white dark:bg-white/5 dark:backdrop-blur-xl border border-slate-200 dark:border-white/10 shadow-sm dark:shadow-none rounded-3xl p-6">
        <div class="mb-5 border-b border-slate-200 dark:border-white/10 pb-4">
            <h4 class="text-lg font-bold text-slate-800 dark:text-white flex items-center gap-2">
                <i class="fa-solid fa-shield-halved text-borma-purple dark:text-borma-yellow"></i>
                Keamanan Akun
            </h4>
            <p class="text-xs text-slate-500 dark:text-white/40 mt-1">Ubah kata sandi Anda secara berkala.</p>
        </div>

        <form action="{{ route('superadmin.pengaturan.update') }}" method="POST">
            @csrf
            @method('PUT')
            
            <input type="hidden" name="nama" value="{{ $user->nama }}">
            <input type="hidden" name="email" value="{{ $user->email }}">
            <input type="hidden" name="no_telepon" value="{{ $user->no_telepon }}">

            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-700 dark:text-white/80 mb-2">Kata Sandi Saat Ini</label>
                <div class="relative">
                    <input type="password" name="password_lama" id="password_lama" class="w-full bg-slate-50 dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow text-slate-800 dark:text-white transition-all @error('password_lama') border-red-500 @enderror">
                    <button type="button" onclick="togglePassword('password_lama')" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 dark:hover:text-white">
                        <i class="fa-regular fa-eye" id="icon-password_lama"></i>
                    </button>
                </div>
                @error('password_lama')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-700 dark:text-white/80 mb-2">Kata Sandi Baru</label>
                <div class="relative">
                    <input type="password" name="password_baru" id="password_baru" class="w-full bg-slate-50 dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow text-slate-800 dark:text-white transition-all @error('password_baru') border-red-500 @enderror">
                    <button type="button" onclick="togglePassword('password_baru')" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 dark:hover:text-white">
                        <i class="fa-regular fa-eye" id="icon-password_baru"></i>
                    </button>
                </div>
                @error('password_baru')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-slate-700 dark:text-white/80 mb-2">Konfirmasi Kata Sandi Baru</label>
                <div class="relative">
                    <input type="password" name="password_baru_confirmation" id="password_baru_confirmation" class="w-full bg-slate-50 dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow text-slate-800 dark:text-white transition-all">
                    <button type="button" onclick="togglePassword('password_baru_confirmation')" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 dark:hover:text-white">
                        <i class="fa-regular fa-eye" id="icon-password_baru_confirmation"></i>
                    </button>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-borma-purple hover:bg-purple-800 dark:bg-borma-yellow dark:hover:bg-yellow-500 text-white dark:text-slate-900 px-6 py-2.5 rounded-xl text-sm font-bold transition-all shadow-md flex items-center gap-2">
                    <i class="fa-solid fa-key"></i> Perbarui Sandi
                </button>
            </div>
        </form>
    </div>

</div>

<script>
    function togglePassword(inputId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById('icon-' + inputId);
        
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
</script>
@endsection
