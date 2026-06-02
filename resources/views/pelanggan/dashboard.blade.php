@extends('layouts.pelanggan')

@section('title', 'Beranda')

@section('content')
<div class="space-y-10 pb-10">
    
    <!-- Hero Carousel -->
    <div id="hero-carousel" class="relative rounded-3xl overflow-hidden shadow-lg" style="min-height:280px">
        <!-- Slides Container -->
        <div id="carousel-track" class="flex transition-transform duration-700 ease-in-out" style="will-change:transform">
            <!-- Slide 1: Belanja Bulanan -->
            <div class="w-full shrink-0 bg-primary-700 p-8 sm:p-12 relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-primary-700 via-primary-700 to-primary-600"></div>
                <div class="absolute top-0 right-0 -mr-16 -mt-16 w-80 h-80 rounded-full bg-white/5 blur-3xl pointer-events-none"></div>
                <div class="absolute bottom-0 right-1/4 mb-4 w-40 h-40 rounded-full bg-secondary-400/10 blur-2xl pointer-events-none"></div>
                <div class="max-w-xl relative z-10">
                    <div class="inline-flex px-3 py-1 bg-tertiary-400 text-white text-[10px] sm:text-xs font-bold rounded-full mb-4 shadow-sm uppercase tracking-wide">Member Spesial</div>
                    <h2 class="font-heading font-extrabold text-3xl sm:text-4xl mb-3 text-white leading-tight uppercase tracking-tight">BELANJA BULANAN <br/><span class="text-secondary-400">LEBIH HEMAT</span></h2>
                    <p class="text-primary-100 text-sm sm:text-base mb-6 font-medium max-w-sm leading-relaxed">Temukan promo menarik khusus member digital Borma Toserba minggu ini.</p>
                    <a href="#" class="inline-flex items-center justify-center bg-secondary-400 text-primary-800 font-bold text-sm px-6 py-3 rounded-xl hover:bg-secondary-300 transition-colors shadow-md hover:shadow-lg">Lihat Promo</a>
                </div>
            </div>
            <!-- Slide 2: Penawaran Terbatas -->
            <div class="w-full shrink-0 bg-primary-700 p-8 sm:p-12 relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-neutral-900 via-primary-800 to-primary-700"></div>
                <div class="absolute -right-10 -top-10 w-40 h-40 bg-secondary-400/20 rounded-full blur-2xl"></div>
                <div class="absolute right-20 -bottom-10 w-32 h-32 bg-tertiary-400/20 rounded-full blur-xl"></div>
                <div class="max-w-xl relative z-10">
                    <div class="inline-flex px-3 py-1 bg-tertiary-400 text-white text-[10px] sm:text-xs font-bold rounded-full mb-4 shadow-sm uppercase tracking-wide">⚡ Flash Sale</div>
                    <h2 class="font-heading font-extrabold text-3xl sm:text-4xl mb-3 text-white leading-tight uppercase tracking-tight">PENAWARAN <br/><span class="text-secondary-400">TERBATAS</span></h2>
                    <p class="text-primary-100 text-sm sm:text-base mb-6 font-medium max-w-sm leading-relaxed">Dapatkan potongan harga spesial hingga 50% untuk produk terpilih hanya hari ini. Jangan sampai kehabisan!</p>
                    <a href="#" class="inline-flex items-center justify-center bg-white text-primary-700 font-bold text-sm px-6 py-3 rounded-xl hover:bg-neutral-50 transition-colors shadow-md hover:shadow-lg">Cek Sekarang</a>
                </div>
            </div>
            <!-- Slide 3: Gratis Ongkir -->
            <div class="w-full shrink-0 bg-primary-700 p-8 sm:p-12 relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-primary-600 via-primary-700 to-neutral-900"></div>
                <div class="absolute top-0 left-1/3 w-60 h-60 bg-secondary-400/15 rounded-full blur-3xl pointer-events-none"></div>
                <div class="absolute bottom-0 right-0 -mr-10 -mb-10 w-48 h-48 bg-white/5 rounded-full blur-2xl pointer-events-none"></div>
                <div class="max-w-xl relative z-10">
                    <div class="inline-flex px-3 py-1 bg-secondary-400 text-primary-800 text-[10px] sm:text-xs font-bold rounded-full mb-4 shadow-sm uppercase tracking-wide">🚚 Gratis Ongkir</div>
                    <h2 class="font-heading font-extrabold text-3xl sm:text-4xl mb-3 text-white leading-tight uppercase tracking-tight">BELANJA ONLINE <br/><span class="text-secondary-400">TANPA ONGKIR</span></h2>
                    <p class="text-primary-100 text-sm sm:text-base mb-6 font-medium max-w-sm leading-relaxed">Nikmati gratis ongkir untuk setiap pembelanjaan minimal Rp 100.000 ke semua cabang Borma.</p>
                    <a href="#" class="inline-flex items-center justify-center bg-secondary-400 text-primary-800 font-bold text-sm px-6 py-3 rounded-xl hover:bg-secondary-300 transition-colors shadow-md hover:shadow-lg">Belanja Sekarang</a>
                </div>
            </div>
        </div>
        <!-- Carousel Nav Arrows -->
        <button onclick="prevSlide()" class="absolute left-3 top-1/2 -translate-y-1/2 z-20 w-10 h-10 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center text-white hover:bg-white/40 transition-colors shadow-md">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </button>
        <button onclick="nextSlide()" class="absolute right-3 top-1/2 -translate-y-1/2 z-20 w-10 h-10 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center text-white hover:bg-white/40 transition-colors shadow-md">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </button>
        <!-- Dots -->
        <div class="absolute bottom-4 left-1/2 -translate-x-1/2 z-20 flex gap-2">
            <button onclick="goToSlide(0)" class="carousel-dot w-8 h-2 rounded-full bg-white/80 transition-all" data-index="0"></button>
            <button onclick="goToSlide(1)" class="carousel-dot w-2 h-2 rounded-full bg-white/40 transition-all" data-index="1"></button>
            <button onclick="goToSlide(2)" class="carousel-dot w-2 h-2 rounded-full bg-white/40 transition-all" data-index="2"></button>
        </div>
    </div>

    <!-- Kategori Populer -->
    <div>
        <div class="flex items-center justify-between mb-5">
            <h3 class="font-heading font-extrabold text-xl text-neutral-800">Kategori Populer</h3>
            <a href="{{ route('pelanggan.katalog') }}" class="text-primary-600 font-bold text-sm hover:text-primary-800 transition-colors flex items-center gap-1">
                Lihat semua 
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </a>
        </div>
        
        <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-8 gap-4">
            <a href="{{ route('pelanggan.katalog', ['kategori' => 'sembako']) }}" class="flex flex-col items-center justify-center p-4 bg-white rounded-2xl border border-neutral-200 shadow-sm hover:shadow-md hover:border-primary-300 transition-all group">
                <div class="w-12 h-12 mb-2 rounded-full bg-primary-50 text-primary-700 flex items-center justify-center group-hover:bg-primary-700 group-hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                </div>
                <span class="text-[11px] font-bold text-neutral-700 text-center leading-tight">Sembako</span>
            </a>
            <a href="{{ route('pelanggan.katalog', ['kategori' => 'sayur-buah']) }}" class="flex flex-col items-center justify-center p-4 bg-white rounded-2xl border border-neutral-200 shadow-sm hover:shadow-md hover:border-primary-300 transition-all group">
                <div class="w-12 h-12 mb-2 rounded-full bg-green-50 text-green-600 flex items-center justify-center group-hover:bg-green-600 group-hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                </div>
                <span class="text-[11px] font-bold text-neutral-700 text-center leading-tight">Sayur & Buah</span>
            </a>
            <a href="{{ route('pelanggan.katalog', ['kategori' => 'daging-ikan']) }}" class="flex flex-col items-center justify-center p-4 bg-white rounded-2xl border border-neutral-200 shadow-sm hover:shadow-md hover:border-primary-300 transition-all group">
                <div class="w-12 h-12 mb-2 rounded-full bg-red-50 text-red-500 flex items-center justify-center group-hover:bg-red-500 group-hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <span class="text-[11px] font-bold text-neutral-700 text-center leading-tight">Daging & Ikan</span>
            </a>
            <a href="{{ route('pelanggan.katalog', ['kategori' => 'susu-olahan']) }}" class="flex flex-col items-center justify-center p-4 bg-white rounded-2xl border border-neutral-200 shadow-sm hover:shadow-md hover:border-primary-300 transition-all group">
                <div class="w-12 h-12 mb-2 rounded-full bg-blue-50 text-blue-500 flex items-center justify-center group-hover:bg-blue-500 group-hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                </div>
                <span class="text-[11px] font-bold text-neutral-700 text-center leading-tight">Susu & Olahan</span>
            </a>
            <a href="{{ route('pelanggan.katalog', ['kategori' => 'minuman']) }}" class="flex flex-col items-center justify-center p-4 bg-white rounded-2xl border border-neutral-200 shadow-sm hover:shadow-md hover:border-primary-300 transition-all group">
                <div class="w-12 h-12 mb-2 rounded-full bg-cyan-50 text-cyan-600 flex items-center justify-center group-hover:bg-cyan-600 group-hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                </div>
                <span class="text-[11px] font-bold text-neutral-700 text-center leading-tight">Minuman</span>
            </a>
            <a href="{{ route('pelanggan.katalog', ['kategori' => 'snack-camilan']) }}" class="flex flex-col items-center justify-center p-4 bg-white rounded-2xl border border-neutral-200 shadow-sm hover:shadow-md hover:border-primary-300 transition-all group">
                <div class="w-12 h-12 mb-2 rounded-full bg-amber-50 text-amber-500 flex items-center justify-center group-hover:bg-amber-500 group-hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 15.546c-.523 0-1.046.151-1.5.454a2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0A2.701 2.701 0 003 15.546"></path></svg>
                </div>
                <span class="text-[11px] font-bold text-neutral-700 text-center leading-tight">Snack</span>
            </a>
            <a href="{{ route('pelanggan.katalog', ['kategori' => 'kebutuhan-rumah']) }}" class="flex flex-col items-center justify-center p-4 bg-white rounded-2xl border border-neutral-200 shadow-sm hover:shadow-md hover:border-primary-300 transition-all group">
                <div class="w-12 h-12 mb-2 rounded-full bg-violet-50 text-violet-500 flex items-center justify-center group-hover:bg-violet-500 group-hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                </div>
                <span class="text-[11px] font-bold text-neutral-700 text-center leading-tight">Keb. Rumah</span>
            </a>
            <a href="{{ route('pelanggan.katalog', ['kategori' => 'perawatan-diri']) }}" class="flex flex-col items-center justify-center p-4 bg-white rounded-2xl border border-neutral-200 shadow-sm hover:shadow-md hover:border-primary-300 transition-all group">
                <div class="w-12 h-12 mb-2 rounded-full bg-pink-50 text-pink-500 flex items-center justify-center group-hover:bg-pink-500 group-hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                </div>
                <span class="text-[11px] font-bold text-neutral-700 text-center leading-tight">Perawatan</span>
            </a>
        </div>
    </div>

    <!-- Cabang Terdekat (Map) -->
    <div>
        <div class="flex items-center justify-between mb-5">
            <div>
                <h3 class="font-heading font-extrabold text-xl text-neutral-800">Cabang Terdekat</h3>
                <p class="text-neutral-500 text-sm mt-1">Temukan toko Borma terdekat dari lokasi Anda</p>
            </div>
            <button onclick="refreshLocation()" id="refresh-location-btn" class="inline-flex items-center gap-2 bg-primary-700 text-white text-sm font-bold px-4 py-2.5 rounded-xl hover:bg-primary-600 transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                <span>Deteksi Lokasi</span>
            </button>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
            <!-- Map Container -->
            <div class="lg:col-span-2 bg-white rounded-2xl border border-neutral-200 shadow-sm overflow-hidden">
                <div id="borma-map" class="w-full" style="height: 400px; z-index: 1;"></div>
            </div>

            <!-- Nearest Branches Sidebar -->
            <div class="bg-white rounded-2xl border border-neutral-200 shadow-sm p-5 flex flex-col">
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-8 h-8 bg-primary-50 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-primary-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    </div>
                    <h4 class="font-heading font-bold text-sm text-neutral-800">3 Cabang Terdekat</h4>
                </div>

                <!-- Loading state -->
                <div id="branches-loading" class="flex-1 flex flex-col items-center justify-center text-center py-8">
                    <div class="w-10 h-10 border-3 border-primary-200 border-t-primary-700 rounded-full animate-spin mb-3"></div>
                    <p class="text-sm text-neutral-500">Mendeteksi lokasi Anda...</p>
                </div>

                <!-- Location denied state -->
                <div id="branches-denied" class="flex-1 flex-col items-center justify-center text-center py-8 hidden">
                    <div class="w-12 h-12 bg-tertiary-50 rounded-full flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6 text-tertiary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                    </div>
                    <p class="text-sm font-semibold text-neutral-700 mb-1">Akses Lokasi Ditolak</p>
                    <p class="text-xs text-neutral-400">Izinkan akses lokasi untuk menemukan cabang terdekat</p>
                </div>

                <!-- Branch list (populated by JS) -->
                <div id="branches-list" class="flex-1 space-y-3 hidden overflow-y-auto" style="max-height: 320px;"></div>
            </div>
        </div>
    </div>


    <div>
        <div class="flex items-center justify-between mb-5">
            <h3 class="font-heading font-extrabold text-xl text-neutral-800">Produk Unggulan</h3>
            <a href="{{ route('pelanggan.katalog') }}" class="text-primary-600 font-bold text-sm hover:text-primary-800 transition-colors flex items-center gap-1">
                Lihat semua 
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </a>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <!-- Product Card 1 -->
            <div class="bg-white rounded-2xl p-4 border border-neutral-200 shadow-sm hover:shadow-md transition-all duration-300 group flex flex-col h-full relative cursor-pointer">
                <div class="absolute top-4 left-4 z-10">
                    <span class="bg-tertiary-400 text-white text-[10px] font-bold px-2 py-1 rounded shadow-sm">PROMO</span>
                </div>
                <div class="absolute top-4 right-4 z-10">
                    <button class="w-8 h-8 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center text-neutral-400 hover:text-tertiary-400 transition-colors shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                    </button>
                </div>
                <div class="rounded-xl overflow-hidden mb-3 bg-neutral-50" style="aspect-ratio:1/1;">
                    <img src="https://images.unsplash.com/photo-1628152417242-b06296fc99ec?auto=format&fit=crop&w=400&h=400&q=80" alt="Minyak Goreng" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                </div>
                <div class="flex-1 flex flex-col">
                    <p class="text-[10px] font-bold text-neutral-400 uppercase tracking-wider mb-1">Sembako & Bahan Pokok</p>
                    <h4 class="font-bold text-sm text-neutral-800 mb-2 leading-tight group-hover:text-primary-700 transition-colors line-clamp-2">Bimoli Minyak Goreng Pouch 2L</h4>
                    <div class="mt-auto">
                        <div class="flex items-center gap-2 mb-0.5">
                            <span class="text-[11px] text-neutral-400 line-through">Rp 45.000</span>
                        </div>
                        <div class="flex items-end justify-between">
                            <p class="font-extrabold text-lg text-primary-700">Rp 32.500</p>
                            <button class="w-8 h-8 bg-primary-50 hover:bg-primary-700 rounded-lg flex items-center justify-center text-primary-700 hover:text-white transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"></path></svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Card 2 -->
            <div class="bg-white rounded-2xl p-4 border border-neutral-200 shadow-sm hover:shadow-md transition-all duration-300 group flex flex-col h-full relative cursor-pointer">
                <div class="absolute top-4 right-4 z-10">
                    <button class="w-8 h-8 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center text-neutral-400 hover:text-tertiary-400 transition-colors shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                    </button>
                </div>
                <div class="rounded-xl overflow-hidden mb-3 bg-neutral-50" style="aspect-ratio:1/1;">
                    <img src="https://images.unsplash.com/photo-1586201375761-83865001e31c?auto=format&fit=crop&w=400&h=400&q=80" alt="Beras" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                </div>
                <div class="flex-1 flex flex-col">
                    <p class="text-[10px] font-bold text-neutral-400 uppercase tracking-wider mb-1">Sembako & Bahan Pokok</p>
                    <h4 class="font-bold text-sm text-neutral-800 mb-2 leading-tight group-hover:text-primary-700 transition-colors line-clamp-2">Beras Pandan Wangi 5kg</h4>
                    <div class="mt-auto">
                        <div class="flex items-end justify-between mt-3">
                            <p class="font-extrabold text-lg text-primary-700">Rp 78.000</p>
                            <button class="w-8 h-8 bg-primary-50 hover:bg-primary-700 rounded-lg flex items-center justify-center text-primary-700 hover:text-white transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"></path></svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Card 3 -->
            <div class="bg-white rounded-2xl p-4 border border-neutral-200 shadow-sm hover:shadow-md transition-all duration-300 group flex flex-col h-full relative cursor-pointer">
                <div class="absolute top-4 left-4 z-10">
                    <span class="bg-secondary-400 text-primary-800 text-[10px] font-bold px-2 py-1 rounded shadow-sm">PROMO</span>
                </div>
                <div class="absolute top-4 right-4 z-10">
                    <button class="w-8 h-8 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center text-neutral-400 hover:text-tertiary-400 transition-colors shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                    </button>
                </div>
                <div class="rounded-xl overflow-hidden mb-3 bg-neutral-50" style="aspect-ratio:1/1;">
                    <img src="https://images.unsplash.com/photo-1559811814-e2c59b6e6e66?auto=format&fit=crop&w=400&h=400&q=80" alt="Susu UHT" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                </div>
                <div class="flex-1 flex flex-col">
                    <p class="text-[10px] font-bold text-neutral-400 uppercase tracking-wider mb-1">Susu & Olahan</p>
                    <h4 class="font-bold text-sm text-neutral-800 mb-2 leading-tight group-hover:text-primary-700 transition-colors line-clamp-2">Ultra Milk Susu UHT Full Cream 1000ml</h4>
                    <div class="mt-auto">
                        <div class="flex items-center gap-2 mb-0.5">
                            <span class="text-[11px] text-neutral-400 line-through">Rp 21.000</span>
                        </div>
                        <div class="flex items-end justify-between">
                            <p class="font-extrabold text-lg text-primary-700">Rp 18.500</p>
                            <button class="w-8 h-8 bg-primary-50 hover:bg-primary-700 rounded-lg flex items-center justify-center text-primary-700 hover:text-white transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"></path></svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Card 4 -->
            <div class="bg-white rounded-2xl p-4 border border-neutral-200 shadow-sm hover:shadow-md transition-all duration-300 group flex flex-col h-full relative cursor-pointer">
                <div class="absolute top-4 right-4 z-10">
                    <button class="w-8 h-8 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center text-neutral-400 hover:text-tertiary-400 transition-colors shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                    </button>
                </div>
                <div class="rounded-xl overflow-hidden mb-3 bg-neutral-50" style="aspect-ratio:1/1;">
                    <img src="https://images.unsplash.com/photo-1585421514284-efb74c2b69ba?auto=format&fit=crop&w=400&h=400&q=80" alt="Deterjen" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                </div>
                <div class="flex-1 flex flex-col">
                    <p class="text-[10px] font-bold text-neutral-400 uppercase tracking-wider mb-1">Kebutuhan Rumah</p>
                    <h4 class="font-bold text-sm text-neutral-800 mb-2 leading-tight group-hover:text-primary-700 transition-colors line-clamp-2">Deterjen Rinso Anti Noda 800g</h4>
                    <div class="mt-auto">
                        <div class="flex items-end justify-between mt-3">
                            <p class="font-extrabold text-lg text-primary-700">Rp 14.200</p>
                            <button class="w-8 h-8 bg-primary-50 hover:bg-primary-700 rounded-lg flex items-center justify-center text-primary-700 hover:text-white transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"></path></svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
// Hero Carousel
(function() {
    const track = document.getElementById('carousel-track');
    const dots = document.querySelectorAll('.carousel-dot');
    const totalSlides = 3;
    let current = 0;
    let autoTimer = null;

    function updateDots() {
        dots.forEach((d, i) => {
            if (i === current) {
                d.classList.remove('bg-white/40', 'w-2');
                d.classList.add('bg-white/80', 'w-8');
            } else {
                d.classList.remove('bg-white/80', 'w-8');
                d.classList.add('bg-white/40', 'w-2');
            }
        });
    }

    function slideTo(index) {
        current = ((index % totalSlides) + totalSlides) % totalSlides;
        track.style.transform = `translateX(-${current * 100}%)`;
        updateDots();
    }

    window.nextSlide = function() { slideTo(current + 1); resetAuto(); };
    window.prevSlide = function() { slideTo(current - 1); resetAuto(); };
    window.goToSlide = function(i) { slideTo(i); resetAuto(); };

    function resetAuto() {
        clearInterval(autoTimer);
        autoTimer = setInterval(() => slideTo(current + 1), 5000);
    }

    resetAuto();
})();

(function() {
    // Initialize map centered on Bandung
    const defaultLat = -6.917464;
    const defaultLng = 107.619123;
    const map = L.map('borma-map').setView([defaultLat, defaultLng], 12);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors',
        maxZoom: 19
    }).addTo(map);

    // Custom marker icons
    const bormaIcon = L.divIcon({
        className: 'borma-marker',
        html: '<div style="background:#33116C;width:32px;height:32px;border-radius:50%;display:flex;align-items:center;justify-content:center;border:3px solid #FED50B;box-shadow:0 2px 8px rgba(51,17,108,0.4)"><span style="color:#FED50B;font-weight:800;font-size:12px">B</span></div>',
        iconSize: [32, 32],
        iconAnchor: [16, 32],
        popupAnchor: [0, -32]
    });

    const userIcon = L.divIcon({
        className: 'user-marker',
        html: `<div style="position:relative;width:44px;height:44px">
            <div style="position:absolute;top:12px;left:12px;background:#EB3B02;width:20px;height:20px;border-radius:50%;border:3px solid white;box-shadow:0 2px 10px rgba(235,59,2,0.6);z-index:2"></div>
            <div style="position:absolute;top:2px;left:2px;width:40px;height:40px;border-radius:50%;border:2px solid rgba(235,59,2,0.3);animation:userPulse 2s ease-out infinite;z-index:1"></div>
            <div style="position:absolute;top:7px;left:7px;width:30px;height:30px;border-radius:50%;background:rgba(235,59,2,0.12);animation:userPulse 2s ease-out infinite 0.5s;z-index:0"></div>
        </div>`,
        iconSize: [44, 44],
        iconAnchor: [22, 22],
        popupAnchor: [0, -22]
    });

    let userMarker = null;
    let userCircle = null;
    let branchMarkers = [];

    // Haversine formula
    function getDistance(lat1, lon1, lat2, lon2) {
        const R = 6371;
        const dLat = (lat2 - lat1) * Math.PI / 180;
        const dLon = (lon2 - lon1) * Math.PI / 180;
        const a = Math.sin(dLat/2) * Math.sin(dLat/2) + Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) * Math.sin(dLon/2) * Math.sin(dLon/2);
        return R * 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
    }

    function formatDistance(km) {
        if (km < 1) return (km * 1000).toFixed(0) + ' m';
        return km.toFixed(1) + ' km';
    }

    // Fetch branches and render
    async function loadBranches(userLat, userLng, hasRealLocation) {
        try {
            const res = await fetch('/api/cabangs');
            const branches = await res.json();

            // Clear old markers
            branchMarkers.forEach(m => map.removeLayer(m));
            branchMarkers = [];

            // Calculate distances
            branches.forEach(b => {
                b.distance = getDistance(userLat, userLng, parseFloat(b.lat), parseFloat(b.lng));
            });
            branches.sort((a, b) => a.distance - b.distance);

            // Add markers for all branches
            branches.forEach((b, i) => {
                const marker = L.marker([parseFloat(b.lat), parseFloat(b.lng)], { icon: bormaIcon })
                    .addTo(map)
                    .bindPopup(`
                        <div style="font-family:'Plus Jakarta Sans',sans-serif;min-width:180px">
                            <p style="font-weight:800;font-size:14px;margin:0 0 4px;color:#33116C">${b.nama}</p>
                            <p style="font-size:12px;color:#5a5a5a;margin:0 0 6px">${b.alamat}</p>
                            <div style="display:inline-flex;align-items:center;gap:4px;background:#f3eaff;padding:3px 8px;border-radius:6px">
                                <span style="font-size:11px;font-weight:700;color:#5a1fcc">${formatDistance(b.distance)}</span>
                            </div>
                        </div>
                    `);
                branchMarkers.push(marker);
            });

            // Render sidebar list (top 3)
            const listEl = document.getElementById('branches-list');
            const loadingEl = document.getElementById('branches-loading');
            const deniedEl = document.getElementById('branches-denied');
            loadingEl.classList.add('hidden');
            deniedEl.classList.add('hidden');
            listEl.classList.remove('hidden');
            listEl.innerHTML = '';

            // Add user location card at top if we have real location
            if (hasRealLocation) {
                const userCard = document.createElement('div');
                userCard.className = 'p-3 rounded-xl bg-tertiary-50 border border-tertiary-200 mb-1';
                userCard.innerHTML = `
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 bg-tertiary-400 rounded-full flex items-center justify-center shrink-0 relative">
                            <div class="w-3 h-3 bg-white rounded-full"></div>
                            <div class="absolute inset-0 rounded-full border-2 border-tertiary-400 animate-ping opacity-40"></div>
                        </div>
                        <div>
                            <p class="font-bold text-xs text-tertiary-500">Lokasi Anda Terdeteksi</p>
                            <p class="text-[11px] text-neutral-500 mt-0.5">${userLat.toFixed(6)}, ${userLng.toFixed(6)}</p>
                        </div>
                    </div>
                `;
                userCard.style.cursor = 'pointer';
                userCard.addEventListener('click', () => {
                    map.setView([userLat, userLng], 15);
                    if (userMarker) userMarker.openPopup();
                });
                listEl.appendChild(userCard);
            }

            const top3 = branches.slice(0, 3);
            top3.forEach((b, i) => {
                const card = document.createElement('div');
                card.className = 'p-4 rounded-xl border border-neutral-200 hover:border-primary-300 hover:shadow-sm transition-all cursor-pointer group';
                card.innerHTML = `
                    <div class="flex items-start gap-3">
                        <div class="w-9 h-9 bg-primary-700 rounded-lg flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                            <span class="text-secondary-400 font-extrabold text-sm">${i + 1}</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h5 class="font-bold text-sm text-neutral-800 truncate group-hover:text-primary-700 transition-colors">${b.nama}</h5>
                            <p class="text-xs text-neutral-500 mt-0.5 truncate">${b.alamat}</p>
                            <div class="flex items-center gap-1.5 mt-2">
                                <svg class="w-3.5 h-3.5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                <span class="text-xs font-bold text-primary-600">${formatDistance(b.distance)}</span>
                                <span class="text-neutral-300 mx-1">•</span>
                                <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-bold bg-green-50 text-green-600">Buka</span>
                            </div>
                        </div>
                    </div>
                `;
                card.addEventListener('click', () => {
                    map.setView([parseFloat(b.lat), parseFloat(b.lng)], 15);
                    branchMarkers[branches.indexOf(b)]?.openPopup();
                });
                listEl.appendChild(card);
            });

            // Fit map to show user + nearest branches
            const bounds = L.latLngBounds([[userLat, userLng]]);
            top3.forEach(b => bounds.extend([parseFloat(b.lat), parseFloat(b.lng)]));
            map.fitBounds(bounds.pad(0.3));

        } catch (err) {
            console.error('Error loading branches:', err);
        }
    }

    function onLocationFound(lat, lng, accuracy) {
        // Remove old user marker and circle
        if (userMarker) map.removeLayer(userMarker);
        if (userCircle) map.removeLayer(userCircle);

        // Add accuracy circle
        userCircle = L.circle([lat, lng], {
            radius: accuracy || 100,
            color: '#EB3B02',
            fillColor: '#EB3B02',
            fillOpacity: 0.08,
            weight: 1.5,
            opacity: 0.3
        }).addTo(map);

        // Add user marker with popup
        userMarker = L.marker([lat, lng], { icon: userIcon, zIndexOffset: 1000 })
            .addTo(map)
            .bindPopup(`
                <div style="font-family:'Plus Jakarta Sans',sans-serif;text-align:center;min-width:140px">
                    <div style="display:flex;align-items:center;justify-content:center;gap:6px;margin-bottom:4px">
                        <div style="width:8px;height:8px;background:#EB3B02;border-radius:50%;animation:blink 1.5s infinite"></div>
                        <p style="font-weight:800;font-size:14px;margin:0;color:#EB3B02">Lokasi Anda</p>
                    </div>
                    <p style="font-size:11px;color:#757575;margin:0">Akurasi: ~${accuracy ? Math.round(accuracy) + 'm' : 'N/A'}</p>
                </div>
            `)
            .openPopup();

        loadBranches(lat, lng, true);
    }

    function onLocationError() {
        document.getElementById('branches-loading').classList.add('hidden');
        document.getElementById('branches-denied').classList.remove('hidden');
        document.getElementById('branches-denied').classList.add('flex');
        // Still load branches with default Bandung center
        loadBranches(defaultLat, defaultLng, false);
    }

    window.refreshLocation = function() {
        document.getElementById('branches-loading').classList.remove('hidden');
        document.getElementById('branches-list').classList.add('hidden');
        document.getElementById('branches-denied').classList.add('hidden');
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                pos => onLocationFound(pos.coords.latitude, pos.coords.longitude, pos.coords.accuracy),
                () => onLocationError(),
                { enableHighAccuracy: true, timeout: 10000 }
            );
        } else {
            onLocationError();
        }
    };

    // Auto-detect on load
    window.refreshLocation();
})();
</script>
<style>
    @keyframes userPulse {
        0% { transform: scale(0.8); opacity: 0.6; }
        100% { transform: scale(2); opacity: 0; }
    }
    @keyframes blink {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.3; }
    }
    .leaflet-popup-content-wrapper { border-radius: 12px !important; box-shadow: 0 4px 15px rgba(0,0,0,0.12) !important; }
    .leaflet-popup-tip { box-shadow: 0 2px 5px rgba(0,0,0,0.08) !important; }
    .user-marker { z-index: 1000 !important; }
</style>
@endpush
