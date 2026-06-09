@extends('layouts.pelanggan')

@section('title', 'Beranda')

@section('content')
<div class="space-y-10 pb-10">
    
    @php
        $selectedCabang = null;
        if (session()->has('selected_cabang_id')) {
            $selectedCabang = \App\Models\Cabang::find(session('selected_cabang_id'));
        }
    @endphp

    @if($selectedCabang)
    <!-- Active Branch Banner -->
    <div class="bg-linear-to-r from-primary-800 via-primary-700 to-primary-900 rounded-3xl p-6 text-white shadow-xl relative overflow-hidden border border-primary-600 flex flex-col md:flex-row items-center justify-between gap-6">
        <!-- Decorative blobs -->
        <div class="absolute -right-10 -top-10 w-40 h-40 bg-secondary-400/10 rounded-full blur-2xl pointer-events-none"></div>
        <div class="absolute left-10 -bottom-10 w-32 h-32 bg-white/5 rounded-full blur-xl pointer-events-none"></div>
        
        <div class="flex items-center gap-4 relative z-10">
            <div class="w-14 h-14 bg-secondary-400 text-primary-900 rounded-2xl flex items-center justify-center shadow-lg shrink-0">
                <svg class="w-7 h-7 text-primary-900" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349M3.75 21V9.349m0 0a3.001 3.001 0 0 0 3.75-.615A2.993 2.993 0 0 0 9.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 0 0 2.25 1.016c.896 0 1.7-.393 2.25-1.016A3.001 3.001 0 0 0 20.25 9.35m-16.5 0a3.004 3.004 0 0 1-.621-4.72l1.189-1.19A1.5 1.5 0 0 1 5.378 3h13.243a1.5 1.5 0 0 1 1.06.44l1.19 1.189a3 3 0 0 1-.621 4.72"/></svg>
            </div>
            <div>
                <p class="text-xs text-secondary-400 font-extrabold uppercase tracking-widest">Cabang Belanja Anda</p>
                <h3 class="font-heading font-extrabold text-xl sm:text-2xl mt-0.5 text-white">{{ $selectedCabang->nama_cabang }}</h3>
                <p class="text-xs text-primary-100 mt-1 font-medium leading-relaxed max-w-xl">
                    <span class="opacity-80">{{ $selectedCabang->alamat_cabang }}</span>
                </p>
            </div>
        </div>
        
        <div class="relative z-10 shrink-0 w-full md:w-auto">
            <button onclick="openBranchSelectorModal()" class="w-full md:w-auto bg-secondary-400 hover:bg-secondary-300 text-primary-800 font-extrabold text-sm px-6 py-3 rounded-xl transition-all shadow-md hover:shadow-lg active:scale-95 duration-200 cursor-pointer border-none">
                Ganti Cabang
            </button>
        </div>
    </div>
    @else
    <!-- No Active Branch Banner -->
    <div class="bg-linear-to-r from-neutral-800 via-neutral-700 to-neutral-900 rounded-3xl p-6 text-white shadow-xl relative overflow-hidden flex flex-col md:flex-row items-center justify-between gap-6 border border-neutral-700">
        <div class="flex items-center gap-4 relative z-10">
            <div class="w-14 h-14 bg-neutral-700 text-neutral-300 rounded-2xl flex items-center justify-center shadow-lg shrink-0">
                <svg class="w-7 h-7 text-neutral-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
            <div>
                <p class="text-xs text-neutral-400 font-extrabold uppercase tracking-widest">Pilih Cabang Belanja</p>
                <h3 class="font-heading font-extrabold text-xl sm:text-2xl mt-0.5">Belum Memilih Cabang</h3>
                <p class="text-xs text-neutral-300 mt-1 font-medium">Pilih cabang untuk melihat ketersediaan produk dan mulai belanja.</p>
            </div>
        </div>
        <div class="relative z-10 shrink-0 w-full md:w-auto">
            <button onclick="openBranchSelectorModal()" class="w-full md:w-auto bg-primary-700 hover:bg-primary-600 text-white font-extrabold text-sm px-6 py-3 rounded-xl transition-all shadow-md hover:shadow-lg active:scale-95 duration-200 cursor-pointer">
                Pilih Cabang Sekarang
            </button>
        </div>
    </div>
    @endif

    <!-- Hero Carousel -->
    <div id="hero-carousel" class="relative rounded-3xl overflow-hidden shadow-lg hero-carousel-container">
        <!-- Slides Container -->
        <div id="carousel-track" class="flex transition-transform duration-700 ease-in-out carousel-track-container">
            <!-- Slide 1: Belanja Bulanan -->
            <div class="carousel-slide carousel-slide-1">
                <!-- Decorative blobs -->
                <div class="absolute top-0 right-0 -mr-16 -mt-16 w-80 h-80 rounded-full blur-3xl pointer-events-none blob-yellow-light-1"></div>
                <div class="absolute bottom-0 left-1/3 w-48 h-48 rounded-full blur-2xl pointer-events-none blob-white-light-1"></div>
                <div class="absolute -bottom-8 -right-8 w-64 h-64 rounded-full blur-3xl pointer-events-none blob-yellow-light-2"></div>
                <!-- Product image on the right -->
                <img src="{{ asset('assets/banners/products-sembako.png') }}" alt="" class="carousel-slide-img carousel-slide-img-1" aria-hidden="true">
                <!-- Text content on the left -->
                <div class="carousel-slide-content">
                    <div class="max-w-md">
                        <div class="inline-flex px-3 py-1 bg-secondary-400 text-primary-800 text-[10px] sm:text-xs font-bold rounded-full mb-4 shadow-sm uppercase tracking-wide">Member Spesial</div>
                        <h2 class="font-heading font-extrabold text-3xl sm:text-4xl mb-3 leading-tight uppercase tracking-tight carousel-title">BELANJA BULANAN <br/><span class="carousel-title-accent">LEBIH HEMAT</span></h2>
                        <p class="text-sm sm:text-base mb-6 font-medium max-w-sm leading-relaxed carousel-desc">Temukan promo menarik khusus member digital Borma Toserba minggu ini.</p>
                        <a href="{{ route('pelanggan.katalog') }}" class="inline-flex items-center justify-center bg-secondary-400 text-primary-800 font-bold text-sm px-6 py-3 rounded-xl hover:bg-secondary-300 transition-colors shadow-md hover:shadow-lg">Lihat Promo</a>
                    </div>
                </div>
            </div>
            <!-- Slide 2: Penawaran Terbatas -->
            <div class="carousel-slide carousel-slide-2">
                <!-- Decorative blobs -->
                <div class="absolute -right-10 -top-10 w-48 h-48 rounded-full blur-2xl pointer-events-none blob-orange-light"></div>
                <div class="absolute right-1/4 -bottom-10 w-40 h-40 rounded-full blur-xl pointer-events-none blob-yellow-light-1"></div>
                <div class="absolute top-1/3 left-0 w-32 h-32 rounded-full blur-2xl pointer-events-none blob-white-light-2"></div>
                <!-- Product image on the right -->
                <img src="{{ asset('assets/banners/products-fresh.png') }}" alt="" class="carousel-slide-img carousel-slide-img-2" aria-hidden="true">
                <!-- Text content on the left -->
                <div class="carousel-slide-content">
                    <div class="max-w-md">
                        <div class="inline-flex px-3 py-1 bg-secondary-400 text-primary-800 text-[10px] sm:text-xs font-bold rounded-full mb-4 shadow-sm uppercase tracking-wide">Flash Sale</div>
                        <h2 class="font-heading font-extrabold text-3xl sm:text-4xl mb-3 leading-tight uppercase tracking-tight carousel-title">PENAWARAN <br/><span class="carousel-title-accent">TERBATAS</span></h2>
                        <p class="text-sm sm:text-base mb-6 font-medium max-w-sm leading-relaxed carousel-desc">Dapatkan potongan harga spesial hingga 50% untuk produk terpilih hanya hari ini.</p>
                        <a href="{{ route('pelanggan.katalog') }}" class="inline-flex items-center justify-center bg-secondary-400 text-primary-800 font-bold text-sm px-6 py-3 rounded-xl hover:bg-secondary-300 transition-colors shadow-md hover:shadow-lg">Cek Sekarang</a>
                    </div>
                </div>
            </div>
            <!-- Slide 3: Gratis Ongkir -->
            <div class="carousel-slide carousel-slide-3">
                <!-- Decorative blobs -->
                <div class="absolute top-0 left-1/4 w-60 h-60 rounded-full blur-3xl pointer-events-none blob-yellow-light-3"></div>
                <div class="absolute -bottom-10 -right-10 w-56 h-56 rounded-full blur-2xl pointer-events-none blob-white-light-1"></div>
                <div class="absolute top-1/2 right-1/3 w-32 h-32 rounded-full blur-xl pointer-events-none blob-yellow-light-4"></div>
                <!-- Product image on the right -->
                <img src="{{ asset('assets/banners/products-household.png') }}" alt="" class="carousel-slide-img carousel-slide-img-3" aria-hidden="true">
                <!-- Text content on the left -->
                <div class="carousel-slide-content">
                    <div class="max-w-md">
                        <div class="inline-flex px-3 py-1 bg-secondary-400 text-primary-800 text-[10px] sm:text-xs font-bold rounded-full mb-4 shadow-sm uppercase tracking-wide">Gratis Ongkir</div>
                        <h2 class="font-heading font-extrabold text-3xl sm:text-4xl mb-3 leading-tight uppercase tracking-tight carousel-title">BELANJA ONLINE <br/><span class="carousel-title-accent">TANPA ONGKIR</span></h2>
                        <p class="text-sm sm:text-base mb-6 font-medium max-w-sm leading-relaxed carousel-desc">Nikmati gratis ongkir untuk setiap pembelanjaan minimal Rp 100.000 ke semua cabang Borma.</p>
                        <a href="{{ route('pelanggan.katalog') }}" class="inline-flex items-center justify-center bg-secondary-400 text-primary-800 font-bold text-sm px-6 py-3 rounded-xl hover:bg-secondary-300 transition-colors shadow-md hover:shadow-lg">Belanja Sekarang</a>
                    </div>
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
                    <svg class="w-6 h-6 animate-pulse-slow" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <path d="m17 11-5-6-5 6" />
                        <path d="M2 11h20" />
                        <path d="m3.5 11 1.6 7.4a2 2 0 0 0 2 1.6h9.8a2 2 0 0 0 2-1.6l1.7-7.4" />
                        <path d="m9 11 1 9" />
                        <path d="m15 11-1 9" />
                    </svg>
                </div>
                <span class="text-[11px] font-bold text-neutral-700 text-center leading-tight">Sembako</span>
            </a>
            <a href="{{ route('pelanggan.katalog', ['kategori' => 'sayur-buah']) }}" class="flex flex-col items-center justify-center p-4 bg-white rounded-2xl border border-neutral-200 shadow-sm hover:shadow-md hover:border-primary-300 transition-all group">
                <div class="w-12 h-12 mb-2 rounded-full bg-green-50 text-green-600 flex items-center justify-center group-hover:bg-green-600 group-hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 3.5 1 9.2a7 7 0 0 1-9 8.8Z" />
                        <path d="M19 2c-2.26 4.33-5.27 7.14-8 10" />
                    </svg>
                </div>
                <span class="text-[11px] font-bold text-neutral-700 text-center leading-tight">Sayur & Buah</span>
            </a>
            <a href="{{ route('pelanggan.katalog', ['kategori' => 'daging-ikan']) }}" class="flex flex-col items-center justify-center p-4 bg-white rounded-2xl border border-neutral-200 shadow-sm hover:shadow-md hover:border-primary-300 transition-all group">
                <div class="w-12 h-12 mb-2 rounded-full bg-red-50 text-red-500 flex items-center justify-center group-hover:bg-red-500 group-hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <path d="M12 3c-1.2 0-2.4.2-3.6.7L4.3 5.4c-1.2.5-2 1.7-2 3v6.4c0 1.3.8 2.5 2 3l4.1 1.7c1.2.5 2.4.7 3.6.7 5 0 9-4 9-9s-4-9-9-9Z" />
                        <path d="M15.2 9.2a3 3 0 1 1-4.4 4.4" />
                        <path d="M16 16c.5.5.5 1.5 0 2-.5.5-1.5.5-2 0" />
                    </svg>
                </div>
                <span class="text-[11px] font-bold text-neutral-700 text-center leading-tight">Daging & Ikan</span>
            </a>
            <a href="{{ route('pelanggan.katalog', ['kategori' => 'susu-olahan']) }}" class="flex flex-col items-center justify-center p-4 bg-white rounded-2xl border border-neutral-200 shadow-sm hover:shadow-md hover:border-primary-300 transition-all group">
                <div class="w-12 h-12 mb-2 rounded-full bg-blue-50 text-blue-500 flex items-center justify-center group-hover:bg-blue-500 group-hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <path d="M8 2h8" />
                        <path d="M9 2v2.789a4 4 0 0 1-.672 2.204l-2.016 3.024A4 4 0 0 0 5.64 12.22V20a2 2 0 0 0 2 2h8.72a2 2 0 0 0 2-2v-7.78a4 4 0 0 0-.672-2.204l-2.016-3.024A4 4 0 0 1 15 4.79V2" />
                        <path d="M6 12h12" />
                    </svg>
                </div>
                <span class="text-[11px] font-bold text-neutral-700 text-center leading-tight">Susu & Olahan</span>
            </a>
            <a href="{{ route('pelanggan.katalog', ['kategori' => 'minuman']) }}" class="flex flex-col items-center justify-center p-4 bg-white rounded-2xl border border-neutral-200 shadow-sm hover:shadow-md hover:border-primary-300 transition-all group">
                <div class="w-12 h-12 mb-2 rounded-full bg-cyan-50 text-cyan-600 flex items-center justify-center group-hover:bg-cyan-600 group-hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <path d="m6 8 1.75 12.28a2 2 0 0 0 2 1.72h4.54a2 2 0 0 0 2-1.72L18 8" />
                        <path d="M5 8h14" />
                        <path d="M18 8a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2" />
                        <path d="m9 2 3 6" />
                    </svg>
                </div>
                <span class="text-[11px] font-bold text-neutral-700 text-center leading-tight">Minuman</span>
            </a>
            <a href="{{ route('pelanggan.katalog', ['kategori' => 'snack-camilan']) }}" class="flex flex-col items-center justify-center p-4 bg-white rounded-2xl border border-neutral-200 shadow-sm hover:shadow-md hover:border-primary-300 transition-all group">
                <div class="w-12 h-12 mb-2 rounded-full bg-amber-50 text-amber-500 flex items-center justify-center group-hover:bg-amber-500 group-hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <path d="M12 2a10 10 0 1 0 10 10 4 4 0 0 1-5-5 4 4 0 0 1-5-5" />
                        <path d="M8.5 8.5v.01" />
                        <path d="M16 15.5v.01" />
                        <path d="M12 12v.01" />
                        <path d="M11 17v.01" />
                        <path d="M7 14v.01" />
                    </svg>
                </div>
                <span class="text-[11px] font-bold text-neutral-700 text-center leading-tight">Snack</span>
            </a>
            <a href="{{ route('pelanggan.katalog', ['kategori' => 'kebutuhan-rumah']) }}" class="flex flex-col items-center justify-center p-4 bg-white rounded-2xl border border-neutral-200 shadow-sm hover:shadow-md hover:border-primary-300 transition-all group">
                <div class="w-12 h-12 mb-2 rounded-full bg-violet-50 text-violet-500 flex items-center justify-center group-hover:bg-violet-500 group-hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                        <polyline points="9 22 9 12 15 12 15 22" />
                    </svg>
                </div>
                <span class="text-[11px] font-bold text-neutral-700 text-center leading-tight">Keb. Rumah</span>
            </a>
            <a href="{{ route('pelanggan.katalog', ['kategori' => 'perawatan-diri']) }}" class="flex flex-col items-center justify-center p-4 bg-white rounded-2xl border border-neutral-200 shadow-sm hover:shadow-md hover:border-primary-300 transition-all group">
                <div class="w-12 h-12 mb-2 rounded-full bg-pink-50 text-pink-500 flex items-center justify-center group-hover:bg-pink-500 group-hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <path d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275L12 3Z" />
                        <path d="m5 3 1 2.5L8.5 6 6 7 5 9.5 4 7 1.5 6 4 5.5z" />
                        <path d="m19 17 1 2.5 2.5.5-2.5 1-1 2.5-1-2.5-2.5-1 2.5-1z" />
                    </svg>
                </div>
                <span class="text-[11px] font-bold text-neutral-700 text-center leading-tight">Perawatan</span>
            </a>
        </div>
    </div>

    <!-- Produk Unggulan -->
    @php
        $branchSessionId = session('selected_cabang_id', 1);
        $filteredUnggulan = \App\Models\ProdukCabang::with('produk')
            ->where('id_cabang', $branchSessionId)
            ->whereHas('produk')
            ->where('jumlah_stok', '>', 0)
            ->orderByDesc('jumlah_terjual')
            ->get()
            ->take(4);
    @endphp

    <div>
        <div class="flex items-center justify-between mb-5">
            <div>
                <h3 class="font-heading font-extrabold text-xl text-neutral-800">Produk Unggulan</h3>
                @if($selectedCabang)
                <p class="text-xs text-neutral-500 font-semibold mt-1">Menampilkan stok produk unggulan di cabang <strong class="text-primary-700">{{ $selectedCabang->nama_cabang }}</strong></p>
                @endif
            </div>
            <a href="{{ route('pelanggan.katalog') }}" class="text-primary-600 font-bold text-sm hover:text-primary-800 transition-colors flex items-center gap-1">
                Lihat semua 
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </a>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            @foreach($filteredUnggulan as $productCabang)
            @php
                $product = $productCabang->produk;
                $sale = $product->harga_member < $product->harga_reguler ? $product->harga_member : 0;
            @endphp
            <a href="{{ route('pelanggan.produk.detail', ['slug' => Str::slug($product->nama_produk)]) }}" class="product-card bg-white rounded-2xl border border-neutral-200 shadow-sm hover:shadow-md hover:border-primary-300 transition-all duration-300 group flex flex-col overflow-hidden no-underline" data-name="{{ strtolower($product->nama_produk) }}">
                <div class="relative bg-neutral-50 flex items-center justify-center border-b border-neutral-100 overflow-hidden" style="aspect-ratio:1/1;">
                    @if($sale > 0)
                    <div class="absolute top-3 right-3 z-10">
                        <span class="bg-tertiary-400 text-white text-[10px] font-bold px-2 py-1 rounded shadow-sm tracking-wider">HEMAT {{ round((($product->harga_reguler - $sale) / $product->harga_reguler) * 100) }}%</span>
                    </div>
                    @endif
                    @if($product->gambar_produk)
                    <img src="{{ asset('assets/products/'.$product->gambar_produk) }}" alt="{{ $product->nama_produk }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                    @else
                    <!-- SVG Fallback Placeholder -->
                    <div class="w-full h-full flex flex-col items-center justify-center bg-neutral-100 text-neutral-400 p-4">
                        <svg class="w-12 h-12 mb-2 stroke-current opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span class="text-[10px] font-semibold uppercase tracking-wider">No Image</span>
                    </div>
                    @endif
                </div>
                <div class="p-4 flex flex-col flex-1">
                    <p class="text-[10px] font-bold text-neutral-400 uppercase tracking-wider mb-1">{{ $product->kategori }}</p>
                    <h4 class="font-bold text-sm text-neutral-800 mb-2 leading-tight group-hover:text-primary-700 transition-colors line-clamp-2">{{ $product->nama_produk }}</h4>
                    <div class="mt-auto space-y-2">
                        @if($sale > 0)
                        <div class="flex items-center gap-2">
                            <span class="text-xs text-neutral-400 line-through">Rp {{ number_format($product->harga_reguler,0,',','.') }}</span>
                        </div>
                        <div class="flex items-end justify-between">
                            <span class="font-extrabold text-lg text-primary-700">Rp {{ number_format($sale,0,',','.') }}</span>
                            <button class="btn-add-cart w-8 h-8 bg-primary-50 hover:bg-primary-700 rounded-lg flex items-center justify-center text-primary-700 hover:text-white transition-colors" data-product="{{ $product->nama_produk }}"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"></path></svg></button>
                        </div>
                        @else
                        <div class="flex items-end justify-between">
                            <span class="font-extrabold text-lg text-neutral-800">Rp {{ number_format($product->harga_reguler,0,',','.') }}</span>
                            <button class="btn-add-cart w-8 h-8 bg-primary-50 hover:bg-primary-700 rounded-lg flex items-center justify-center text-primary-700 hover:text-white transition-colors" data-product="{{ $product->nama_produk }}"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"></path></svg></button>
                        </div>
                        @endif
                    </div>
                </div>
            </a>
            @endforeach
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
        if (track) {
            track.style.transform = `translateX(-${current * 100}%)`;
        }
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

// Add to cart AJAX
document.addEventListener('DOMContentLoaded', function() {
    const csrfToken = '{{ csrf_token() }}';

    function showToast(message, isError) {
        const existing = document.getElementById('cart-toast');
        if (existing) existing.remove();
        const toast = document.createElement('div');
        toast.id = 'cart-toast';
        toast.className = 'fixed bottom-6 right-6 z-[9999] px-5 py-3 rounded-xl shadow-2xl text-sm font-bold text-white transition-all duration-300 flex items-center gap-2';
        toast.style.cssText = isError ? 'background:#ef4444;' : 'background:linear-gradient(135deg,#1a5632,#22c55e);';
        toast.innerHTML = (isError ? '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>' : '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>') + '<span>' + message + '</span>';
        document.body.appendChild(toast);
        setTimeout(() => { toast.style.opacity = '0'; setTimeout(() => toast.remove(), 300); }, 2500);
    }

    function updateCartBadge(count) {
        let badge = document.getElementById('cart-badge');
        if (badge) {
            badge.style.display = count > 0 ? 'block' : 'none';
        }
    }

    document.querySelectorAll('.btn-add-cart').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const productName = this.dataset.product;
            const btnEl = this;
            btnEl.disabled = true;
            btnEl.classList.add('pointer-events-none', 'opacity-50');

            fetch('{{ route("cart.add") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
                body: JSON.stringify({ product_name: productName })
            })
            .then(r => r.json())
            .then(data => {
                btnEl.disabled = false;
                btnEl.classList.remove('pointer-events-none', 'opacity-50');
                if (data.success) {
                    showToast(data.message, false);
                    updateCartBadge(data.cart_count);
                    btnEl.style.transform = 'scale(1.2)';
                    setTimeout(() => btnEl.style.transform = '', 200);
                } else {
                    showToast(data.message || 'Gagal menambahkan produk', true);
                }
            })
            .catch(() => {
                btnEl.disabled = false;
                btnEl.classList.remove('pointer-events-none', 'opacity-50');
                showToast('Terjadi kesalahan jaringan', true);
            });
        });
    });
});
</script>
@endpush
