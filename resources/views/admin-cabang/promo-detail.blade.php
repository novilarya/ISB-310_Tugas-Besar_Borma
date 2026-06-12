@extends('admin-cabang.layouts.admin-cabang')

@section('title', 'Detail Promo - Borma Toserba')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin-cabang.css') }}">
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
@endpush

@section('content')
<!-- Header dengan Tombol Kembali -->
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div class="flex items-center gap-4">
        <a href="{{ route('admin-cabang.promo') }}" class="w-10 h-10 rounded-xl bg-white dark:bg-white/5 border border-slate-200 dark:border-white/10 flex items-center justify-center text-slate-500 dark:text-white/50 hover:bg-slate-50 dark:hover:bg-white/10 hover:text-borma-purple dark:hover:text-borma-yellow transition-all">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="text-2xl font-extrabold text-slate-800 dark:text-white tracking-tight">Detail Promo & Voucher</h1>
            <p class="text-sm text-slate-500 dark:text-white/50 mt-1">ID Promo: {{ $promo->id_promo }} &bull; {{ $promo->cabang->nama_cabang ?? 'Promo Global' }}</p>
        </div>
    </div>
    
    <div class="flex items-center gap-3">
        <form action="{{ route('admin-cabang.promo.delete', $promo->id_promo) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus promo ini?');" class="m-0 p-0">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-500/20 text-red-600 dark:text-red-400 hover:bg-red-100 dark:hover:bg-red-500/20 px-4 py-2 rounded-xl text-sm font-bold transition-all shadow-sm flex items-center gap-2">
                <i class="fa-solid fa-trash"></i> Hapus Promo
            </button>
        </form>
        <button class="bg-borma-purple hover:bg-purple-800 dark:bg-borma-yellow dark:hover:bg-yellow-500 text-white dark:text-slate-900 px-4 py-2 rounded-xl text-sm font-bold transition-all shadow-md flex items-center gap-2" 
            data-bs-toggle="modal" 
            data-bs-target="#editPromoModal">
            <i class="fa-solid fa-pen-to-square"></i> Edit Informasi
        </button>
    </div>
</div>

@php
    $status = $promo->statusPromo();
    $sisa = $promo->sisaHari();
@endphp

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Informasi Utama & Pemicu -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Card 1: Informasi Utama -->
        <div class="bg-white dark:bg-white/5 dark:backdrop-blur-xl border border-slate-200 dark:border-white/10 shadow-sm dark:shadow-none rounded-3xl p-6">
            <div class="d-flex justify-content-between align-items-start border-bottom pb-4 mb-6" style="border-color: rgba(0,0,0,0.06) !important;">
                <div>
                    <span class="text-xs font-bold text-uppercase tracking-wider" style="color: var(--borma-primary); font-size: 0.72rem; font-weight: 700;">Informasi Utama</span>
                    <h3 class="text-2xl font-extrabold text-slate-800 dark:text-white mt-1 mb-0">{{ $promo->nama_voucher }}</h3>
                </div>
                <div>
                    @if($status === 'aktif')
                        <span class="status-badge-modern status-selesai">Aktif</span>
                    @elseif($status === 'terjadwal')
                        <span class="status-badge-modern status-pending">Terjadwal</span>
                    @else
                        <span class="status-badge-modern status-disabled" style="background:#F3F4F6;color:#6B7280;border:1px solid #E5E7EB;">Berakhir</span>
                    @endif
                </div>
            </div>

            <div class="row g-4">
                <div class="col-md-6 space-y-4">
                    <div>
                        <span class="text-xs text-slate-400 dark:text-white/40 font-semibold block">Kode Voucher</span>
                        @if($promo->kode_voucher)
                            <span class="inline-block font-mono font-bold px-3 py-1.5 rounded-lg mt-1 border" style="font-family: monospace; font-size: 0.85rem; letter-spacing: 1px; background: rgba(51,17,108,.05); color: var(--borma-primary); border-color: rgba(51,17,108,.1) !important;">
                                {{ $promo->kode_voucher }}
                            </span>
                        @else
                            <span class="text-slate-500 dark:text-white/60 font-semibold text-sm block mt-1">— Tanpa Kode (Promo Otomatis) —</span>
                        @endif
                    </div>

                    <div>
                        <span class="text-xs text-slate-400 dark:text-white/40 font-semibold block">Cabang Berlaku</span>
                        <div class="mt-1 font-bold text-slate-800 dark:text-white text-sm">
                            @if($promo->id_cabang && $promo->cabang)
                                <i class="text-borma-purple dark:text-borma-yellow mr-1.5" style="color: var(--borma-primary) !important;"></i> {{ $promo->cabang->nama_cabang }}
                            @else
                                <span class="bg-light text-primary font-bold px-2.5 py-1 rounded text-xs uppercase border" style="border-radius: 6px;">
                                    <i class="fa-solid fa-globe mr-1"></i> Seluruh Cabang (Promo Global)
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-md-6 space-y-4">
                    <div>
                        <span class="text-xs text-slate-400 dark:text-white/40 font-semibold block">Masa Berlaku</span>
                        <div class="mt-1 text-sm font-bold text-slate-800 dark:text-white">
                            <i class="text-slate-400 "></i>
                            {{ $promo->tanggal_mulai->format('d F Y') }} — {{ $promo->tanggal_berakhir->format('d F Y') }}
                        </div>
                        @if($status === 'aktif')
                            <div class="text-xs font-bold mt-1.5 flex items-center gap-1.5 {{ $sisa <= 3 ? 'text-danger' : 'text-muted' }}" style="font-size: 0.75rem;">
                                <i class="bi bi-clock"></i> 
                                <span>{{ $sisa >= 0 ? $sisa . ' hari kalender tersisa' : 'Masa berlaku habis' }}</span>
                            </div>
                        @endif
                    </div>

                    <div>
                        <span class="text-xs text-slate-400 dark:text-white/40 font-semibold block">Total Kuota Promo</span>
                        <div class="mt-1 text-sm font-extrabold text-slate-800 dark:text-white flex items-center">
                            <i class="text-slate-400"></i>
                            <span>{{ number_format($promo->kuota_promo, 0, ',', '.') }} Penggunaan</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 2: Syarat & Ketentuan Pemicu -->
        <div class="bg-white dark:bg-white/5 dark:backdrop-blur-xl border border-slate-200 dark:border-white/10 shadow-sm dark:shadow-none rounded-3xl p-6">
            <h4 class="font-bold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                <i class="fa-solid fa-list-check text-borma-purple dark:text-borma-yellow" style="color: var(--borma-primary) !important;"></i> Syarat & Ketentuan Pemicu
            </h4>
            
            <div class="bg-slate-50 dark:bg-black/30 rounded-2xl p-4 border border-slate-100 dark:border-white/5 space-y-4">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-xl bg-purple-100 dark:bg-white/10 flex items-center justify-center text-borma-purple dark:text-borma-yellow shrink-0" style="color: var(--borma-primary) !important;">
                        <i class="fa-solid fa-box-open text-xl"></i>
                    </div>
                    <div>
                        <span class="text-xs text-slate-400 dark:text-white/40 block">Produk Pemicu</span>
                        <h6 class="font-bold text-slate-800 dark:text-white mt-0.5 text-sm">{{ $promo->produkPemicu->nama_produk ?? 'Produk tidak ditemukan' }}</h6>
                        <p class="text-xs text-slate-500 dark:text-white/40 mt-0.5">Kategori: {{ $promo->produkPemicu->kategori ?? '-' }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-3 border-t border-slate-200 dark:border-white/10" style="border-color: rgba(0,0,0,0.06) !important;">
                    <div>
                        <span class="text-xs text-slate-400 dark:text-white/40 block">Minimum Pembelian Produk Pemicu</span>
                        <div class="mt-1 text-sm font-extrabold text-slate-800 dark:text-white">
                            {{ $promo->kuantitas_pemicu }} Pcs / Unit
                        </div>
                    </div>
                    <div>
                        <span class="text-xs text-slate-400 dark:text-white/40 block">Minimum Transaksi Belanja</span>
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

    <!-- Kolom Kanan: Keuntungan & Benefit -->
    <div class="lg:col-span-1 space-y-6">
        <div class="bg-white dark:bg-white/5 dark:backdrop-blur-xl border border-slate-200 dark:border-white/10 shadow-sm dark:shadow-none rounded-3xl p-6">
            <h4 class="font-bold text-slate-800 dark:text-white mb-6 border-b border-slate-100 dark:border-white/10 pb-3" style="border-color: rgba(0,0,0,0.06) !important;">
                Keuntungan & Benefit
            </h4>

            <div class="space-y-5">
                <!-- Potongan Harga -->
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-xl bg-green-50 dark:bg-green-500/10 flex items-center justify-center text-green-600 dark:text-green-400 shrink-0">
                        <i class="fa-solid fa-money-bill-wave text-lg"></i>
                    </div>
                    <div>
                        <span class="text-xs text-slate-400 dark:text-white/40 block">Potongan Harga</span>
                        <h4 class="text-lg font-extrabold text-green-600 dark:text-green-400 mt-0.5">Rp {{ number_format($promo->potongan_harga, 0, ',', '.') }}</h4>
                    </div>
                </div>

                <!-- Produk Hadiah -->
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-xl bg-orange-50 dark:bg-orange-500/10 flex items-center justify-center text-orange-600 dark:text-orange-400 shrink-0 mt-0.5">
                        <i class="fa-solid fa-gift text-lg"></i>
                    </div>
                    <div>
                        <span class="text-xs text-slate-400 dark:text-white/40 block">Produk Hadiah / Kado</span>
                        @if($promo->id_produk_hadiah && $promo->produkHadiah)
                            <h6 class="text-sm font-bold text-slate-800 dark:text-white mt-0.5">{{ $promo->produkHadiah->nama_produk }}</h6>
                            <p class="text-xs text-slate-500 dark:text-white/40 mt-0.5">Jumlah: <span class="font-bold">{{ $promo->kuantitas_hadiah }} unit</span></p>
                        @else
                            <h6 class="text-sm font-bold text-slate-500 dark:text-white/40 mt-0.5" style="opacity: 0.6;">Tidak Ada Hadiah Barang</h6>
                        @endif
                    </div>
                </div>

                <!-- Maks. Potongan Promo -->
                <div class="flex items-center gap-4 pt-3 border-t border-slate-100 dark:border-white/10" style="border-color: rgba(0,0,0,0.06) !important;">
                    <div class="w-10 h-10 rounded-xl bg-purple-50 dark:bg-purple-500/10 flex items-center justify-center text-borma-purple dark:text-borma-yellow shrink-0" style="color: var(--borma-primary) !important;">
                        <i class="fa-solid fa-ticket text-lg"></i>
                    </div>
                    <div>
                        <span class="text-xs text-slate-400 dark:text-white/40 block">Maks. Potongan Promo</span>
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
@include('admin-cabang.modal.edit-promo')
@endsection
