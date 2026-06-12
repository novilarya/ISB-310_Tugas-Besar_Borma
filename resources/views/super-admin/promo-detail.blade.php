@extends('super-admin.layouts.app')
@section('title', 'Detail Promo | Super Admin Borma')
@section('page_title', 'Detail Promo')

@section('content')
<div class="mb-6 flex items-center gap-4">
    <a href="{{ route('superadmin.promo') }}" class="w-10 h-10 rounded-xl bg-white dark:bg-white/5 border border-slate-200 dark:border-white/10 flex items-center justify-center text-slate-500 dark:text-white/50 hover:bg-slate-50 dark:hover:bg-white/10 hover:text-borma-purple dark:hover:text-borma-yellow transition-all">
        <i class="fa-solid fa-arrow-left"></i>
    </a>
    <h4 class="text-lg font-bold text-slate-800 dark:text-white">Detail Promo: {{ $promo->nama_voucher }}</h4>
</div>

@php
    $status = $promo->statusPromo();
    $sisa = $promo->sisaHari();
@endphp

<div class="grid grid-cols-1 xl:grid-cols-3 gap-6 mb-6">
    <!-- Main Info & Status Card -->
    <div class="xl:col-span-2 space-y-6">
        <div class="bg-white dark:bg-white/5 dark:backdrop-blur-xl border border-slate-200 dark:border-white/10 shadow-sm dark:shadow-none rounded-3xl p-6">
            <div class="flex justify-between items-start border-b border-slate-100 dark:border-white/10 pb-4 mb-6">
                <div>
                    <span class="text-xs font-bold text-borma-purple dark:text-borma-yellow uppercase tracking-wider">Informasi Utama</span>
                    <h3 class="text-2xl font-extrabold text-slate-800 dark:text-white mt-1">{{ $promo->nama_voucher }}</h3>
                </div>
                <div>
                    @if($status === 'aktif')
                        <span class="px-3 py-1 bg-green-100 text-green-700 dark:bg-green-500/20 dark:text-green-400 rounded-lg text-xs font-bold uppercase tracking-wider border border-green-200 dark:border-green-500/30">Aktif</span>
                    @elseif($status === 'terjadwal')
                        <span class="px-3 py-1 bg-blue-100 text-blue-700 dark:bg-blue-500/20 dark:text-blue-400 rounded-lg text-xs font-bold uppercase tracking-wider border border-blue-200 dark:border-blue-500/30">Terjadwal</span>
                    @else
                        <span class="px-3 py-1 bg-slate-100 text-slate-600 dark:bg-white/10 dark:text-white/60 rounded-lg text-xs font-bold uppercase tracking-wider border border-slate-200 dark:border-white/20">Berakhir</span>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <div>
                        <span class="text-xs text-slate-400 dark:text-white/50 block">Kode Voucher</span>
                        @if($promo->kode_voucher)
                            <span class="inline-block bg-purple-50 text-borma-purple dark:bg-borma-yellow/20 dark:text-borma-yellow font-mono font-bold px-3 py-1.5 rounded-lg text-sm tracking-widest border border-purple-100 dark:border-borma-yellow/30 mt-1">
                                {{ $promo->kode_voucher }}
                            </span>
                        @else
                            <span class="text-slate-500 dark:text-white/60 font-semibold text-sm block mt-1">— Tanpa Kode (Promo Otomatis) —</span>
                        @endif
                    </div>

                    <div>
                        <span class="text-xs text-slate-400 dark:text-white/50 block">Cabang Berlaku</span>
                        <div class="mt-1 font-bold text-slate-800 dark:text-white text-sm">
                            @if($promo->id_cabang && $promo->cabang)
                                <i class="fa-solid fa-store text-borma-purple dark:text-borma-yellow mr-1.5"></i> {{ $promo->cabang->nama_cabang }}
                            @else
                                <span class="bg-indigo-50 text-indigo-700 dark:bg-indigo-500/20 dark:text-indigo-400 font-bold px-2 py-1 rounded text-xs uppercase tracking-wider border border-indigo-100 dark:border-indigo-500/30">
                                    <i class="fa-solid fa-globe mr-1"></i> Seluruh Cabang (Promo Global)
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="space-y-4">
                    <div>
                        <span class="text-xs text-slate-400 dark:text-white/50 block">Masa Berlaku</span>
                        <div class="mt-1 text-sm font-bold text-slate-800 dark:text-white">
                            <i class="fa-regular fa-calendar text-slate-400 mr-1.5"></i>
                            {{ $promo->tanggal_mulai->format('d F Y') }} — {{ $promo->tanggal_berakhir->format('d F Y') }}
                        </div>
                        @if($status === 'aktif')
                            <div class="text-xs font-bold mt-1.5 flex items-center gap-1.5 {{ $sisa <= 3 ? 'text-red-500' : 'text-slate-500 dark:text-white/50' }}">
                                <i class="fa-regular fa-clock"></i> 
                                <span>{{ $sisa >= 0 ? $sisa . ' hari kalender tersisa' : 'Masa berlaku habis' }}</span>
                            </div>
                        @endif
                    </div>

                    <div>
                        <span class="text-xs text-slate-400 dark:text-white/50 block">Total Kuota Promo</span>
                        <div class="mt-1 text-sm font-extrabold text-slate-800 dark:text-white flex items-center gap-2">
                            <i class="fa-solid fa-chart-pie text-slate-400"></i>
                            <span>{{ number_format($promo->kuota_promo, 0, ',', '.') }} Penggunaan</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Syarat & Ketentuan Card -->
        <div class="bg-white dark:bg-white/5 dark:backdrop-blur-xl border border-slate-200 dark:border-white/10 shadow-sm dark:shadow-none rounded-3xl p-6">
            <h5 class="font-bold text-lg text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                <i class="fa-solid fa-list-check text-borma-purple dark:text-borma-yellow"></i> Syarat & Ketentuan Pemicu
            </h5>
            
            <div class="bg-slate-50 dark:bg-black/30 rounded-2xl p-5 border border-slate-100 dark:border-white/5 space-y-4">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-xl bg-purple-100 dark:bg-white/10 flex items-center justify-center text-borma-purple dark:text-borma-yellow shrink-0">
                        <i class="fa-solid fa-box-open text-xl"></i>
                    </div>
                    <div>
                        <span class="text-xs text-slate-400 dark:text-white/50">Produk Pemicu</span>
                        <h6 class="font-bold text-slate-800 dark:text-white mt-0.5 text-sm">{{ $promo->produkPemicu->nama_produk ?? 'Produk tidak ditemukan' }}</h6>
                        <p class="text-xs text-slate-500 dark:text-white/40 mt-0.5">Kategori: {{ $promo->produkPemicu->kategori ?? '-' }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-3 border-t border-slate-200 dark:border-white/10">
                    <div>
                        <span class="text-xs text-slate-400 dark:text-white/50 block">Minimum Pembelian Produk Pemicu</span>
                        <div class="mt-1 text-sm font-extrabold text-slate-800 dark:text-white">
                            {{ $promo->kuantitas_pemicu }} Pcs / Unit
                        </div>
                    </div>
                    <div>
                        <span class="text-xs text-slate-400 dark:text-white/50 block">Minimum Transaksi Belanja</span>
                        <div class="mt-1 text-sm font-extrabold text-slate-800 dark:text-white">
                            @if($promo->min_transaksi > 0)
                                Rp {{ number_format($promo->min_transaksi, 0, ',', '.') }}
                            @else
                                Rp 0 (Tidak ada batas minimum)
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Side Benefits Info -->
    <div class="space-y-6">
        <div class="bg-white dark:bg-white/5 dark:backdrop-blur-xl border border-slate-200 dark:border-white/10 shadow-sm dark:shadow-none rounded-3xl p-6">
            <h5 class="font-bold text-lg text-slate-800 dark:text-white mb-6 border-b border-slate-100 dark:border-white/10 pb-3">
                Keuntungan & Benefit
            </h5>

            <div class="space-y-5">
                <!-- Potongan Harga -->
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-xl bg-green-50 dark:bg-green-500/10 flex items-center justify-center text-green-600 dark:text-green-400 shrink-0">
                        <i class="fa-solid fa-money-bill-wave"></i>
                    </div>
                    <div>
                        <span class="text-xs text-slate-400 dark:text-white/50">Potongan Harga</span>
                        <h4 class="text-lg font-extrabold text-green-600 dark:text-green-400 mt-0.5">Rp {{ number_format($promo->potongan_harga, 0, ',', '.') }}</h4>
                    </div>
                </div>

                <!-- Produk Hadiah -->
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-xl bg-orange-50 dark:bg-orange-500/10 flex items-center justify-center text-orange-600 dark:text-orange-400 shrink-0 mt-0.5">
                        <i class="fa-solid fa-gift"></i>
                    </div>
                    <div>
                        <span class="text-xs text-slate-400 dark:text-white/50">Produk Hadiah / Kado</span>
                        @if($promo->id_produk_hadiah && $promo->produkHadiah)
                            <h6 class="text-sm font-bold text-slate-800 dark:text-white mt-0.5">{{ $promo->produkHadiah->nama_produk }}</h6>
                            <p class="text-xs text-slate-500 dark:text-white/40 mt-0.5">Jumlah: <span class="font-bold">{{ $promo->kuantitas_hadiah }} unit</span></p>
                        @else
                            <h6 class="text-sm font-bold text-slate-500 dark:text-white/40 mt-0.5">— Tidak Ada Hadiah Barang —</h6>
                        @endif
                    </div>
                </div>

                <!-- Maks. Potongan Promo -->
                <div class="flex items-center gap-4 pt-3 border-t border-slate-100 dark:border-white/10">
                    <div class="w-10 h-10 rounded-xl bg-purple-50 dark:bg-purple-500/10 flex items-center justify-center text-borma-purple dark:text-borma-yellow shrink-0">
                        <i class="fa-solid fa-arrow-up-right-dots"></i>
                    </div>
                    <div>
                        <span class="text-xs text-slate-400 dark:text-white/50">Maks. Potongan Promo</span>
                        <h6 class="text-sm font-bold text-slate-800 dark:text-white mt-0.5">
                            @if($promo->max_promo > 0)
                                {{ number_format($promo->max_promo, 0) }}% Potongan Maksimal
                            @else
                                Tidak Terbatas (Unlimited)
                            @endif
                        </h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
