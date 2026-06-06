@extends('layouts.pelanggan')

@section('title', 'Profil Saya')

@section('content')
<div class="pb-10">

    <!-- Header Section -->
    <div class="mb-8 relative">
        <h2 class="font-heading font-extrabold text-3xl text-neutral-800 uppercase tracking-tight">Profil Saya</h2>
        <div class="w-16 h-1.5 bg-secondary-400 mt-3 rounded-full"></div>
    </div>

    <!-- Top Section: Profile Info & Buttons -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-10">
        
        <!-- Profile Info Card -->
        <div class="lg:col-span-2 bg-white rounded-3xl border border-neutral-200 p-6 sm:p-8 shadow-sm flex flex-col sm:flex-row items-center sm:items-start gap-6 sm:gap-8 relative overflow-hidden group">
            <!-- Decorative background element -->
            <div class="absolute -right-16 -top-16 w-64 h-64 bg-primary-50 rounded-full opacity-50 pointer-events-none group-hover:scale-110 transition-transform duration-700"></div>
            
            <!-- Avatar -->
            <div class="w-28 h-28 sm:w-32 sm:h-32 bg-primary-100 rounded-2xl border-4 border-white shadow-md flex items-center justify-center shrink-0 relative z-10 text-primary-700">
                <span class="font-heading font-extrabold text-5xl">{{ strtoupper(substr($user->nama, 0, 1)) }}</span>
            </div>
            
            <!-- User Data -->
            <div class="flex-1 flex flex-col justify-center text-center sm:text-left relative z-10 w-full">
                <h3 class="font-heading font-extrabold text-2xl text-neutral-800 uppercase tracking-tight">{{ $user->nama }}</h3>
                
                <div class="flex flex-col gap-1.5 mt-3 mb-6 items-center sm:items-start">
                    <p class="text-neutral-500 text-sm font-medium flex items-center gap-2">
                        <svg class="w-4 h-4 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        {{ $user->email ?? 'Belum ada email' }}
                    </p>
                    <p class="text-neutral-500 text-sm font-medium flex items-center gap-2">
                        <svg class="w-4 h-4 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        {{ $user->no_telepon ?? 'Belum ada nomor telepon' }}
                    </p>
                </div>
                
                <!-- Status & ID -->
                <div class="grid grid-cols-2 gap-3 sm:gap-4 w-full mt-auto">
                    <div class="bg-primary-50 rounded-xl p-3 sm:p-4 text-center border border-primary-100 hover:bg-primary-100 transition-colors">
                        <p class="text-[10px] text-primary-600 font-bold uppercase tracking-wider mb-1">Status Member</p>
                        <p class="font-heading font-extrabold text-sm sm:text-base text-primary-800 uppercase">
                            {{ $pelanggan->status_member ? 'PLUS' : 'REGULER' }}
                        </p>
                    </div>
                    <div class="bg-primary-700 rounded-xl p-3 sm:p-4 text-center shadow-inner relative overflow-hidden group/id">
                        <div class="absolute inset-0 bg-gradient-to-br from-white/10 to-transparent"></div>
                        <p class="text-[10px] text-primary-200 font-bold uppercase tracking-wider mb-1 relative z-10">ID Digital</p>
                        <p class="font-heading font-extrabold text-sm sm:text-[15px] text-white tracking-widest relative z-10 group-hover/id:scale-105 transition-transform">
                            {{ $memberId }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Quick Actions (Compact) -->
        <div class="bg-white rounded-3xl border border-neutral-200 p-5 shadow-sm flex flex-col justify-between h-full">
            <h4 class="text-[11px] font-bold text-neutral-400 uppercase tracking-widest mb-4">Pengaturan Akun</h4>
            <div class="space-y-2.5 flex-1">
                <a href="#" class="flex items-center gap-3 px-3 py-3 rounded-xl hover:bg-primary-50 transition-colors group">
                    <div class="w-9 h-9 bg-primary-50 rounded-lg flex items-center justify-center text-primary-600 group-hover:bg-primary-600 group-hover:text-white transition-colors shrink-0">
                        <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-neutral-700 group-hover:text-primary-700 transition-colors">Edit Profil</p>
                        <p class="text-[10px] text-neutral-400">Ubah nama, email, foto</p>
                    </div>
                    <svg class="w-4 h-4 text-neutral-300 group-hover:text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>
                <a href="#" class="flex items-center gap-3 px-3 py-3 rounded-xl hover:bg-primary-50 transition-colors group">
                    <div class="w-9 h-9 bg-primary-50 rounded-lg flex items-center justify-center text-primary-600 group-hover:bg-primary-600 group-hover:text-white transition-colors shrink-0">
                        <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-neutral-700 group-hover:text-primary-700 transition-colors">Ubah Password</p>
                        <p class="text-[10px] text-neutral-400">Ganti kata sandi</p>
                    </div>
                    <svg class="w-4 h-4 text-neutral-300 group-hover:text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>
                <a href="#" class="flex items-center gap-3 px-3 py-3 rounded-xl hover:bg-primary-50 transition-colors group">
                    <div class="w-9 h-9 bg-primary-50 rounded-lg flex items-center justify-center text-primary-600 group-hover:bg-primary-600 group-hover:text-white transition-colors shrink-0">
                        <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-neutral-700 group-hover:text-primary-700 transition-colors">Kelola Alamat</p>
                        <p class="text-[10px] text-neutral-400">Atur alamat pengiriman</p>
                    </div>
                    <svg class="w-4 h-4 text-neutral-300 group-hover:text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>
            </div>
        </div>
    </div>

    <!-- Kartu Member Digital -->
    <div class="mb-10">
        <div class="flex items-center justify-between mb-5">
            <h3 class="font-heading font-extrabold text-xl text-neutral-800">Kartu Member Digital</h3>
        </div>

        <div class="bg-gradient-to-br from-neutral-900 via-neutral-800 to-primary-900 rounded-3xl p-8 sm:p-10 relative overflow-hidden shadow-xl w-full" style="min-height: 280px;">
            <div class="absolute top-0 right-0 w-56 h-56 bg-primary-700/30 rounded-full -mr-20 -mt-20 blur-2xl"></div>
            <div class="absolute bottom-0 left-0 w-40 h-40 bg-secondary-400/10 rounded-full -ml-12 -mb-12 blur-xl"></div>
            <div class="absolute top-8 right-8 z-10">
                <div class="w-12 h-12 border-2 border-white/30 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-white/60" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/></svg>
                </div>
            </div>
            <div class="relative z-10">
                <div class="flex items-center gap-4 mb-8">
                    <div class="w-12 h-12 bg-secondary-400 rounded-xl flex items-center justify-center shadow-md">
                        <span class="font-heading font-extrabold text-primary-800 text-xl">B</span>
                    </div>
                    <div>
                        <p class="font-heading font-extrabold text-base text-white tracking-wider uppercase">Member Borma</p>
                        <p class="text-xs text-neutral-400 font-bold uppercase tracking-widest">Toserba Digital Card</p>
                    </div>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-xl px-6 py-4 mb-8 inline-flex items-center gap-4">
                    <div class="flex gap-[3px]">
                        @for($i = 0; $i < 16; $i++)
                        <div class="w-[3px] bg-white/90 rounded-full" style="height:{{ rand(18, 36) }}px"></div>
                        @endfor
                    </div>
                    <p class="text-sm text-white/70 font-mono tracking-wider">{{ $memberId }}</p>
                </div>
                <div class="flex items-end justify-between">
                    <div>
                        <p class="text-xs text-neutral-400 uppercase tracking-wider mb-1">Nama Pemegang</p>
                        <p class="font-bold text-lg text-white uppercase tracking-wide">{{ $user->nama }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-xs text-neutral-400 uppercase tracking-wider mb-1">ID Member</p>
                        <p class="font-mono font-bold text-base text-secondary-400 tracking-widest">{{ $memberId }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-xs text-neutral-400 uppercase tracking-wider mb-1">Status</p>
                        <span class="inline-flex items-center gap-1.5 text-sm font-bold {{ $pelanggan->status_member ? 'text-green-400' : 'text-neutral-400' }}">
                            <span class="w-2.5 h-2.5 rounded-full {{ $pelanggan->status_member ? 'bg-green-400 animate-pulse' : 'bg-neutral-500' }}"></span>
                            {{ $pelanggan->status_member ? 'PLUS' : 'REGULER' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Borma Plus Membership -->
    @if(!$pelanggan->status_member)
    <div class="mb-10">
        <div class="flex items-center justify-between mb-5">
            <div>
                <h3 class="font-heading font-extrabold text-xl text-neutral-800">Borma Plus</h3>
                <p class="text-sm text-neutral-500 mt-1">Upgrade ke member premium untuk keuntungan eksklusif</p>
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4" style="grid-template-columns: repeat(3, minmax(0, 1fr));">
            <!-- 1 Bulan -->
            <div class="bg-white rounded-2xl border border-neutral-200 p-5 shadow-sm hover:shadow-md hover:border-primary-300 transition-all group relative overflow-hidden">
                <div class="absolute top-0 right-0 w-20 h-20 bg-primary-50 rounded-bl-full opacity-60"></div>
                <div class="relative z-10">
                    <p class="text-[10px] font-bold text-primary-500 uppercase tracking-widest mb-1">Paket</p>
                    <h4 class="font-heading font-extrabold text-lg text-neutral-800 mb-1">1 Bulan</h4>
                    <p class="text-neutral-400 text-xs mb-4">Coba dulu benefit premium</p>
                    <p class="font-heading font-extrabold text-2xl text-primary-700 mb-1">Rp 29.900</p>
                    <p class="text-[10px] text-neutral-400 mb-4">/bulan</p>
                    <ul class="space-y-2 text-xs text-neutral-600 mb-5">
                        <li class="flex items-center gap-2"><svg class="w-3.5 h-3.5 text-green-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>Diskon 5% semua produk</li>
                        <li class="flex items-center gap-2"><svg class="w-3.5 h-3.5 text-green-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>Gratis ongkir 2x/bulan</li>
                        <li class="flex items-center gap-2"><svg class="w-3.5 h-3.5 text-green-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>Poin reward 2x lipat</li>
                    </ul>
                    <button onclick="activateMember('1_bulan', 29900)" class="w-full bg-primary-700 text-white text-sm font-bold py-2.5 rounded-xl hover:bg-primary-600 transition-colors">Pilih Paket</button>
                </div>
            </div>
            <!-- 2 Bulan -->
            <div class="bg-white rounded-2xl border-2 border-primary-500 p-5 shadow-lg hover:shadow-xl transition-all group relative overflow-hidden">
                <div class="absolute top-0 right-0 bg-secondary-400 text-primary-900 text-[9px] font-extrabold px-3 py-1 rounded-bl-xl uppercase tracking-wider">Populer</div>
                <div class="absolute top-0 right-0 w-20 h-20 bg-primary-50 rounded-bl-full opacity-60"></div>
                <div class="relative z-10">
                    <p class="text-[10px] font-bold text-primary-500 uppercase tracking-widest mb-1">Paket</p>
                    <h4 class="font-heading font-extrabold text-lg text-neutral-800 mb-1">2 Bulan</h4>
                    <p class="text-neutral-400 text-xs mb-4">Hemat lebih banyak</p>
                    <div class="flex items-baseline gap-2 mb-1">
                        <p class="font-heading font-extrabold text-2xl text-primary-700">Rp 49.900</p>
                        <span class="text-xs text-neutral-400 line-through">Rp 59.800</span>
                    </div>
                    <p class="text-[10px] text-neutral-400 mb-4">/2 bulan · Hemat 17%</p>
                    <ul class="space-y-2 text-xs text-neutral-600 mb-5">
                        <li class="flex items-center gap-2"><svg class="w-3.5 h-3.5 text-green-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>Diskon 8% semua produk</li>
                        <li class="flex items-center gap-2"><svg class="w-3.5 h-3.5 text-green-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>Gratis ongkir 5x/bulan</li>
                        <li class="flex items-center gap-2"><svg class="w-3.5 h-3.5 text-green-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>Poin reward 3x lipat</li>
                    </ul>
                    <button onclick="activateMember('2_bulan', 49900)" class="w-full bg-primary-700 text-white text-sm font-bold py-2.5 rounded-xl hover:bg-primary-600 transition-colors shadow-md">Pilih Paket</button>
                </div>
            </div>
            <!-- 3 Bulan -->
            <div class="bg-white rounded-2xl border border-neutral-200 p-5 shadow-sm hover:shadow-md hover:border-primary-300 transition-all group relative overflow-hidden">
                <div class="absolute top-0 right-0 w-20 h-20 bg-primary-50 rounded-bl-full opacity-60"></div>
                <div class="relative z-10">
                    <p class="text-[10px] font-bold text-primary-500 uppercase tracking-widest mb-1">Paket</p>
                    <h4 class="font-heading font-extrabold text-lg text-neutral-800 mb-1">3 Bulan</h4>
                    <p class="text-neutral-400 text-xs mb-4">Terbaik & terhemat</p>
                    <div class="flex items-baseline gap-2 mb-1">
                        <p class="font-heading font-extrabold text-2xl text-primary-700">Rp 69.900</p>
                        <span class="text-xs text-neutral-400 line-through">Rp 89.700</span>
                    </div>
                    <p class="text-[10px] text-neutral-400 mb-4">/3 bulan · Hemat 22%</p>
                    <ul class="space-y-2 text-xs text-neutral-600 mb-5">
                        <li class="flex items-center gap-2"><svg class="w-3.5 h-3.5 text-green-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>Diskon 10% semua produk</li>
                        <li class="flex items-center gap-2"><svg class="w-3.5 h-3.5 text-green-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>Gratis ongkir unlimited</li>
                        <li class="flex items-center gap-2"><svg class="w-3.5 h-3.5 text-green-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>Poin reward 5x lipat</li>
                    </ul>
                    <button onclick="activateMember('3_bulan', 69900)" class="w-full bg-primary-700 text-white text-sm font-bold py-2.5 rounded-xl hover:bg-primary-600 transition-colors">Pilih Paket</button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Riwayat Pesanan Section -->
    <div class="bg-white rounded-3xl border border-neutral-200 p-6 sm:p-10 shadow-sm relative overflow-hidden">
        <!-- Decoration -->
        <div class="absolute right-0 top-0 w-40 h-40 bg-secondary-400/10 rounded-bl-full pointer-events-none"></div>

        <!-- Section Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end mb-8 gap-4 relative z-10">
            <div>
                <h3 class="font-heading font-extrabold text-2xl text-neutral-800 uppercase tracking-tight mb-1">Riwayat Pesanan</h3>
                <p class="text-sm font-medium text-neutral-500 uppercase tracking-widest text-[11px]">{{ count($pesanans) }} Transaksi Terakhir</p>
            </div>
            <a href="#" class="inline-flex items-center gap-1 font-bold text-sm text-primary-600 hover:text-primary-800 transition-colors group border-b-2 border-transparent hover:border-primary-600 pb-0.5 uppercase tracking-wide">
                Lihat Semua 
                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
            </a>
        </div>
        
        <!-- Orders List -->
        <div class="space-y-4 relative z-10">
            @forelse($pesanans as $pesanan)
            @php
                $statusMap = [
                    'mencari_driver' => ['label' => 'Diproses', 'class' => 'bg-neutral-900 text-white'],
                    'diterima_driver' => ['label' => 'Driver Ditemukan', 'class' => 'bg-primary-100 text-primary-700'],
                    'diambil' => ['label' => 'Diambil Dari Gudang', 'class' => 'bg-primary-100 text-primary-700'],
                    'dalam_pengiriman' => ['label' => 'Dalam Pengiriman', 'class' => 'bg-primary-100 text-primary-700'],
                    'diterima' => ['label' => 'Diterima (Kurir Tiba)', 'class' => 'bg-amber-100 text-amber-800'],
                    'selesai' => ['label' => 'Selesai', 'class' => 'bg-green-100 text-green-800'],
                    'gagal' => ['label' => 'Gagal Kirim', 'class' => 'bg-red-100 text-red-700'],
                    'ditolak_driver' => ['label' => 'Ditolak', 'class' => 'bg-red-100 text-red-700'],
                ];
                $statusInfo = $statusMap[$pesanan->status_pesanan] ?? ['label' => $pesanan->status_pesanan, 'class' => 'bg-neutral-900 text-white'];
            @endphp
            <div onclick='showOrderDetail(@json($pesanan))' class="group bg-neutral-50 rounded-2xl p-4 sm:p-5 border border-neutral-200 hover:border-primary-300 hover:bg-white hover:shadow-md transition-all duration-300 flex flex-col sm:flex-row gap-4 sm:gap-6 items-start sm:items-center cursor-pointer">
                
                <!-- Order Icon -->
                <div class="w-14 h-14 bg-white rounded-xl shadow-sm flex items-center justify-center shrink-0 border border-neutral-100 group-hover:bg-primary-50 group-hover:border-primary-200 transition-colors text-primary-400 group-hover:text-primary-700">
                    @if($pesanan->status_pesanan === 'selesai')
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    @elseif(in_array($pesanan->status_pesanan, ['diterima', 'dalam_pengiriman', 'diambil', 'diterima_driver']))
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                    @else
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    @endif
                </div>
                
                <!-- Order Details -->
                <div class="flex-1 min-w-0 w-full">
                    <div class="flex justify-between items-start mb-1">
                        @php
                            $productNames = $pesanan->details->map(function($detail) {
                                return $detail->produk ? $detail->produk->nama_produk : 'Produk Borma';
                            })->toArray();
                            $displayTitle = count($productNames) > 0 ? implode(', ', array_slice($productNames, 0, 2)) : 'Pesanan Borma';
                            if (count($productNames) > 2) {
                                $displayTitle .= ' & ' . (count($productNames) - 2) . ' produk lainnya';
                            }
                        @endphp
                        <h4 class="font-bold text-neutral-800 text-base truncate group-hover:text-primary-700 transition-colors">{{ $displayTitle }}</h4>
                        
                        <!-- Status Badge (Mobile) -->
                        <span class="sm:hidden px-2.5 py-1 rounded-md text-[10px] font-bold uppercase {{ $statusInfo['class'] }} whitespace-nowrap ml-2 shadow-sm">
                            {{ $statusInfo['label'] }}
                        </span>
                    </div>
                    
                    <p class="text-xs font-medium text-neutral-500 flex items-center gap-2 mt-1">
                        <span>{{ \Carbon\Carbon::parse($pesanan->tanggal_pemesanan)->translatedFormat('d M Y') }}</span>
                        <span class="w-1 h-1 bg-neutral-300 rounded-full"></span>
                        <span>{{ $pesanan->details_count ?? 1 }} Item</span>
                    </p>
                    
                    <!-- Price (Mobile) -->
                    <p class="sm:hidden font-extrabold text-primary-700 mt-3 text-lg">Rp {{ number_format($pesanan->total_tagihan, 0, ',', '.') }}</p>
                </div>
                
                <!-- Price and Status (Desktop) -->
                <div class="hidden sm:flex flex-col items-end gap-3 shrink-0">
                    <span class="px-3 py-1.5 rounded-md text-[11px] font-bold uppercase {{ $statusInfo['class'] }} shadow-sm">
                        {{ $statusInfo['label'] }}
                    </span>
                    <p class="font-extrabold text-xl text-primary-700">Rp {{ number_format($pesanan->total_tagihan, 0, ',', '.') }}</p>
                </div>
            </div>
            @empty
            
            <!-- Empty State -->
            <div class="py-12 flex flex-col items-center justify-center text-center bg-neutral-50 rounded-2xl border border-dashed border-neutral-300">
                <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center text-neutral-300 mb-4 shadow-sm">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                </div>
                <h4 class="font-bold text-neutral-800 mb-1">Belum Ada Transaksi</h4>
                <p class="text-sm text-neutral-500 max-w-xs">Anda belum pernah melakukan pemesanan. Yuk, mulai belanja sekarang!</p>
                <a href="{{ route('pelanggan.katalog') }}" class="mt-5 bg-primary-700 text-white px-6 py-2.5 rounded-xl font-bold text-sm hover:bg-primary-600 transition-colors shadow-sm">Mulai Belanja</a>
            </div>
            @endforelse
        </div>
    </div>

    <!-- Logout Button -->
    <div class="mt-8 flex justify-start">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="inline-flex items-center gap-2 text-red-600 hover:text-red-700 hover:bg-red-50 px-5 py-3 rounded-xl transition-all font-bold text-sm uppercase tracking-wider group border border-transparent hover:border-red-100">
                <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                Keluar Dari Akun
            </button>
        </form>
    </div>

    <!-- Modal Detail Pesanan -->
    <div id="orderDetailModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <!-- Backdrop -->
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-neutral-900/60 backdrop-blur-sm transition-opacity" aria-hidden="true" onclick="closeOrderDetailModal()"></div>

            <!-- Modal Content -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full border border-neutral-200 relative z-10">
                <!-- Modal Header -->
                <div class="bg-gradient-to-r from-primary-800 to-primary-700 px-6 py-4 flex justify-between items-center text-white">
                    <div>
                        <h3 class="font-heading font-extrabold text-lg uppercase tracking-wider" id="modal-title">Detail Pesanan</h3>
                        <p class="text-xs text-primary-200 mt-0.5" id="modalOrderDate">Tanggal Pemesanan: -</p>
                    </div>
                    <button onclick="closeOrderDetailModal()" class="text-white/85 hover:text-white transition-colors bg-white/10 hover:bg-white/20 p-2 rounded-xl">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="px-6 py-6 space-y-6 max-h-[70vh] overflow-y-auto">
                    <!-- Status & ID -->
                    <div class="grid grid-cols-2 gap-4 bg-neutral-50 rounded-2xl p-4 border border-neutral-200">
                        <div>
                            <p class="text-[10px] text-neutral-400 font-bold uppercase tracking-wider mb-1">ID Pesanan</p>
                            <p class="text-sm font-bold text-neutral-800" id="modalOrderId">-</p>
                        </div>
                        <div>
                            <p class="text-[10px] text-neutral-400 font-bold uppercase tracking-wider mb-1">Status Pesanan</p>
                            <span class="inline-flex px-2.5 py-1 rounded-md text-[10px] font-bold uppercase text-white shadow-sm" id="modalOrderStatusBadge">
                                -
                            </span>
                        </div>
                    </div>

                    <!-- Payment & Address -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-[10px] text-neutral-400 font-bold uppercase tracking-wider mb-1">Metode Pembayaran</p>
                            <p class="text-sm font-bold text-neutral-700" id="modalOrderPayment">-</p>
                        </div>
                        <div>
                            <p class="text-[10px] text-neutral-400 font-bold uppercase tracking-wider mb-1">Alamat Pengiriman</p>
                            <p class="text-sm text-neutral-600 leading-relaxed font-medium" id="modalOrderAddress">-</p>
                        </div>
                    </div>

                    <!-- Live Tracking Map Section -->
                    <div id="modalOrderMapSection" class="hidden border border-neutral-200 rounded-2xl p-4 bg-neutral-50/50 space-y-2">
                        <p class="text-[10px] text-neutral-400 font-bold uppercase tracking-wider">Live Tracking Lokasi Kurir</p>
                        <div id="modalOrderMap" style="height: 240px; border-radius: 12px; border: 1.5px solid #E4E0EE; overflow: hidden; z-index: 1;"></div>
                        <div class="flex gap-4 mt-2 px-1 text-[10px] font-bold text-neutral-500 uppercase tracking-wide">
                            <div class="flex items-center gap-1.5">
                                <span style="background: #33116C; width: 8px; height: 8px; border-radius: 50%; display: inline-block;"></span>
                                Gudang/Cabang
                            </div>
                            <div class="flex items-center gap-1.5">
                                <span style="background: #EB3B02; width: 8px; height: 8px; border-radius: 50%; display: inline-block;"></span>
                                Lokasi Anda
                            </div>
                        </div>
                    </div>

                    <!-- Bukti Pengiriman Section -->
                    <div id="modalOrderProofSection" class="hidden bg-green-50/50 rounded-2xl p-4 border border-green-100 space-y-4">
                        <p class="text-[10px] text-green-700 font-bold uppercase tracking-wider">Bukti Pengiriman Selesai</p>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="w-full h-40 bg-neutral-100 rounded-xl overflow-hidden border border-neutral-200 flex items-center justify-center">
                                <img id="modalOrderProofImg" src="" alt="Bukti Pengiriman" class="w-full h-full object-cover">
                            </div>
                            <div class="flex flex-col justify-center space-y-3">
                                <div>
                                    <p class="text-[10px] text-neutral-400 font-bold uppercase tracking-wider mb-0.5">Nama Penerima</p>
                                    <p class="text-sm font-bold text-neutral-800" id="modalOrderProofReceiver">-</p>
                                </div>
                                <div>
                                    <p class="text-[10px] text-neutral-400 font-bold uppercase tracking-wider mb-0.5">Catatan Driver</p>
                                    <p class="text-xs italic text-neutral-600 font-medium" id="modalOrderProofNote">-</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="border-neutral-200">

                    <!-- Product Items -->
                    <div>
                        <p class="text-[10px] text-neutral-400 font-bold uppercase tracking-wider mb-3">Item Belanja</p>
                        <div class="space-y-3" id="modalOrderItemsContainer">
                            <!-- Items will be injected here -->
                        </div>
                    </div>

                    <hr class="border-neutral-200">

                    <!-- Financial Summary -->
                    <div class="space-y-2 bg-neutral-50 rounded-2xl p-4 border border-neutral-200 text-sm">
                        <div class="flex justify-between text-neutral-600 font-medium">
                            <span>Subtotal Belanja</span>
                            <span id="modalOrderSubtotal">Rp -</span>
                        </div>
                        <div class="flex justify-between text-neutral-600 font-medium">
                            <span>Ongkos Kirim</span>
                            <span id="modalOrderShipping">Rp -</span>
                        </div>
                        <div class="flex justify-between text-neutral-600 font-medium">
                            <span>Diskon Voucher</span>
                            <span id="modalOrderDiscount">Rp -</span>
                        </div>
                        <div class="flex justify-between text-neutral-800 font-extrabold border-t border-neutral-200 pt-2 text-base">
                            <span>Total Tagihan</span>
                            <span class="text-primary-700" id="modalOrderTotal">Rp -</span>
                        </div>
                    </div>

                    <!-- Customer Confirmation Action Button -->
                    <div id="modalOrderConfirmActionSection" class="hidden mt-6">
                        <button type="button" onclick="confirmOrderReceived()" class="w-full bg-gradient-to-r from-emerald-600 to-green-500 hover:from-emerald-700 hover:to-green-600 text-white font-heading font-extrabold py-4 px-6 rounded-2xl shadow-md hover:shadow-lg hover:-translate-y-0.5 active:translate-y-0 active:shadow-md transition-all duration-200 flex items-center justify-center gap-3 text-sm uppercase tracking-wider border border-emerald-500/20">
                            <svg class="w-5 h-5 text-emerald-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>Konfirmasi Pesanan Selesai</span>
                        </button>
                    </div>
                </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
let trackingMapInstance = null;
let currentPesananId = null;

function activateMember(paket, harga) {
    const paketNames = {
        '1_bulan': 'Borma Plus - 1 Bulan',
        '2_bulan': 'Borma Plus - 2 Bulan',
        '3_bulan': 'Borma Plus - 3 Bulan'
    };

    if (!confirm('Aktivasi ' + paketNames[paket] + ' senilai Rp ' + harga.toLocaleString('id-ID') + '?')) return;

    fetch('{{ route("payment.create") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            payment_method: 'qris',
            total: harga,
            customer_name: '{{ $user->nama }}',
            customer_email: '{{ $user->email ?? "" }}',
            customer_phone: '{{ $user->no_telepon ?? "" }}',
            items: [{
                id: 'MEMBER-' + paket.toUpperCase(),
                price: harga,
                quantity: 1,
                name: paketNames[paket]
            }]
        })
    })
    .then(res => res.json())
    .then(data => {
        if (data.snap_token) {
            window.snap.pay(data.snap_token, {
                onSuccess: function(result) {
                    alert('Pembayaran berhasil! Member Borma Plus Anda telah aktif.');
                    window.location.href = '/payment/finish?order_id=' + (result.order_id || data.order_id);
                },
                onPending: function(result) {
                    alert('Pembayaran pending. Silakan selesaikan pembayaran Anda.');
                },
                onError: function(result) {
                    alert('Pembayaran gagal. Silakan coba lagi.');
                },
                onClose: function() {
                    console.log('Payment popup closed');
                }
            });
        } else if (data.message) {
            alert(data.message);
        }
    })
    .catch(err => {
        console.error(err);
        alert('Terjadi kesalahan. Silakan coba lagi.');
    });
}

function showOrderDetail(pesanan) {
    currentPesananId = pesanan.id_pesanan;
    document.getElementById('modalOrderId').textContent = pesanan.id_pesanan;
    
    const date = new Date(pesanan.tanggal_pemesanan);
    const options = { day: 'numeric', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit' };
    document.getElementById('modalOrderDate').textContent = 'Tanggal Pemesanan: ' + date.toLocaleDateString('id-ID', options);
    
    document.getElementById('modalOrderPayment').textContent = pesanan.metode_pembayaran;
    document.getElementById('modalOrderAddress').textContent = pesanan.alamat_pengiriman;
    
    const status = pesanan.status_pesanan;
    const badge = document.getElementById('modalOrderStatusBadge');
    
    const statusMap = {
        'mencari_driver': { label: 'DIPROSES', class: ['bg-neutral-900', 'text-white'] },
        'diterima_driver': { label: 'DRIVER DITEMUKAN', class: ['bg-primary-100', 'text-primary-700'] },
        'diambil': { label: 'DIAMBIL DARI GUDANG', class: ['bg-primary-100', 'text-primary-700'] },
        'dalam_pengiriman': { label: 'DALAM PENGIRIMAN', class: ['bg-primary-100', 'text-primary-700'] },
        'diterima': { label: 'DITERIMA (KURIR TIBA)', class: ['bg-amber-100', 'text-amber-800'] },
        'selesai': { label: 'SELESAI', class: ['bg-green-100', 'text-green-800'] },
        'gagal': { label: 'GAGAL KIRIM', class: ['bg-red-100', 'text-red-700'] },
        'ditolak_driver': { label: 'DITOLAK', class: ['bg-red-100', 'text-red-700'] },
    };
    
    const info = statusMap[status] || { label: status.toUpperCase(), class: ['bg-neutral-900', 'text-white'] };
    badge.textContent = info.label;
    badge.className = "inline-flex px-2.5 py-1 rounded-md text-[10px] font-bold uppercase shadow-sm " + info.class.join(' ');
    
    const container = document.getElementById('modalOrderItemsContainer');
    container.innerHTML = '';
    
    if (pesanan.details && pesanan.details.length > 0) {
        pesanan.details.forEach(detail => {
            const prodName = detail.produk ? detail.produk.nama_produk : 'Produk Borma';
            const prodImg = detail.produk ? detail.produk.gambar_produk : 'default.jpg';
            const qty = detail.jumlah;
            const price = parseFloat(detail.harga_satuan);
            const sub = parseFloat(detail.subtotal);
            
            const itemHtml = `
                <div class="flex items-center gap-4 py-2.5 border-b border-neutral-100 last:border-0">
                    <div class="w-12 h-12 bg-neutral-100 rounded-lg shrink-0 overflow-hidden border border-neutral-200 flex items-center justify-center">
                        <img src="/assets/products/${prodImg}" alt="${prodName}" class="w-full h-full object-cover" onerror="this.src='/assets/products/default.jpg'">
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-neutral-800 truncate">${prodName}</p>
                        <p class="text-xs text-neutral-500 font-medium">${qty} x Rp ${price.toLocaleString('id-ID')}</p>
                    </div>
                    <p class="text-sm font-extrabold text-neutral-800">Rp ${sub.toLocaleString('id-ID')}</p>
                </div>
            `;
            container.innerHTML += itemHtml;
        });
    } else {
        container.innerHTML = '<p class="text-xs text-neutral-400 italic">Tidak ada item belanja.</p>';
    }
    
    const subtotal = parseFloat(pesanan.total_belanja);
    const shipping = parseFloat(pesanan.biaya_pengiriman);
    const discount = parseFloat(pesanan.diskon_voucher || 0);
    const total = parseFloat(pesanan.total_tagihan);
    
    document.getElementById('modalOrderSubtotal').textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
    document.getElementById('modalOrderShipping').textContent = 'Rp ' + shipping.toLocaleString('id-ID');
    document.getElementById('modalOrderDiscount').textContent = 'Rp ' + discount.toLocaleString('id-ID');
    document.getElementById('modalOrderTotal').textContent = 'Rp ' + total.toLocaleString('id-ID');
    
    // Reset Sections
    const mapSection = document.getElementById('modalOrderMapSection');
    const proofSection = document.getElementById('modalOrderProofSection');
    mapSection.classList.add('hidden');
    proofSection.classList.add('hidden');
    
    if (trackingMapInstance) {
        trackingMapInstance.remove();
        trackingMapInstance = null;
    }
    
    // Live Map if status is dalam_pengiriman
    if (status === 'dalam_pengiriman') {
        mapSection.classList.remove('hidden');
        
        let cabangLat = -6.9147;
        let cabangLng = 107.6542;
        let cabangName = 'Gudang Borma';
        if (pesanan.cabang) {
            cabangName = pesanan.cabang.nama_cabang || 'Gudang Borma';
            if (pesanan.cabang.koordinat_gps) {
                const coords = pesanan.cabang.koordinat_gps.split(',');
                if (coords.length === 2) {
                    cabangLat = parseFloat(coords[0].trim());
                    cabangLng = parseFloat(coords[1].trim());
                }
            }
        }
        
        let custLat = pesanan.latitude ? parseFloat(pesanan.latitude) : -6.9215;
        let custLng = pesanan.longitude ? parseFloat(pesanan.longitude) : 107.6310;
        
        const centerLat = (cabangLat + custLat) / 2;
        const centerLng = (cabangLng + custLng) / 2;
        
        // Initialize Map inside modal
        trackingMapInstance = L.map('modalOrderMap', {
            zoomControl: true,
            attributionControl: false
        }).setView([centerLat, centerLng], 13);
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
        }).addTo(trackingMapInstance);
        
        const gudangIcon = L.divIcon({
            className: 'custom-marker',
            html: `<div style="background: #33116C; width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 6px rgba(51,17,108,0.4); border: 2.5px solid white;">
                    <svg width="12" height="12" fill="white" viewBox="0 0 16 16"><path d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5l2.404.961L10.404 2l-2.218-.887zm3.564 1.426L5.596 5 8 5.961 14.154 3.5l-2.404-.961zm3.25 1.7-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923l6.5 2.6zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464L7.443.184z"/></svg>
                   </div>`,
            iconSize: [28, 28],
            iconAnchor: [14, 14]
        });

        const customerIcon = L.divIcon({
            className: 'custom-marker',
            html: `<div style="background: #EB3B02; width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 6px rgba(235,59,2,0.4); border: 2.5px solid white;">
                    <svg width="12" height="12" fill="white" viewBox="0 0 16 16"><path d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A31.493 31.493 0 0 1 8 14.58a31.481 31.481 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94zM8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10z"/><path d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/></svg>
                   </div>`,
            iconSize: [28, 28],
            iconAnchor: [14, 28]
        });
        
        L.marker([cabangLat, cabangLng], { icon: gudangIcon }).addTo(trackingMapInstance)
            .bindPopup('<b>Gudang ' + cabangName + '</b>');

        L.marker([custLat, custLng], { icon: customerIcon }).addTo(trackingMapInstance)
            .bindPopup('<b>Lokasi Anda</b><br>' + pesanan.alamat_pengiriman);
            
        L.polyline([
            [cabangLat, cabangLng],
            [custLat, custLng]
        ], {
            color: '#33116C',
            weight: 3,
            opacity: 0.7,
            dashArray: '6, 6',
            lineCap: 'round'
        }).addTo(trackingMapInstance);
        
        const bounds = L.latLngBounds([
            [cabangLat, cabangLng],
            [custLat, custLng]
        ]);
        trackingMapInstance.fitBounds(bounds, { padding: [20, 20] });
        
        // Invalidate map size after modal animation completes
        setTimeout(() => {
            if (trackingMapInstance) {
                trackingMapInstance.invalidateSize();
            }
        }, 400);
    }
    
    // Hide confirm action section by default
    const confirmActionSection = document.getElementById('modalOrderConfirmActionSection');
    if (confirmActionSection) {
        confirmActionSection.classList.add('hidden');
    }
    
    // Proof of Delivery if status is diterima or selesai
    if (status === 'diterima' || status === 'selesai') {
        proofSection.classList.remove('hidden');
        const img = document.getElementById('modalOrderProofImg');
        if (pesanan.bukti_pengiriman) {
            img.src = '/storage/' + pesanan.bukti_pengiriman;
            img.style.display = 'block';
        } else {
            img.src = '/assets/products/default.jpg';
        }
        document.getElementById('modalOrderProofReceiver').textContent = pesanan.nama_penerima || 'Penerima tidak dicatat';
        document.getElementById('modalOrderProofNote').textContent = pesanan.catatan_driver ? '"' + pesanan.catatan_driver + '"' : 'Tidak ada catatan driver';
    }

    // Customer confirmation action button
    if (status === 'diterima' && confirmActionSection) {
        confirmActionSection.classList.remove('hidden');
    }
    
    document.getElementById('orderDetailModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeOrderDetailModal() {
    document.getElementById('orderDetailModal').classList.add('hidden');
    document.body.style.overflow = '';
    if (trackingMapInstance) {
        trackingMapInstance.remove();
        trackingMapInstance = null;
    }
}

function confirmOrderReceived() {
    if (!currentPesananId) return;
    if (!confirm('Apakah Anda yakin ingin mengkonfirmasi bahwa pesanan ini telah selesai diterima?')) return;
    
    const url = `/pelanggan/pesanan/${currentPesananId}/confirm-received`;
    
    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            window.location.reload();
        } else {
            alert(data.message || 'Gagal mengkonfirmasi pesanan.');
        }
    })
    .catch(err => {
        console.error(err);
        alert('Terjadi kesalahan. Silakan coba lagi.');
    });
}
</script>
@endpush
