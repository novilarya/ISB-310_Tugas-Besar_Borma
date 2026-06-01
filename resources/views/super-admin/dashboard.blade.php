@extends('super-admin.layouts.app')
@section('title', 'Dashboard | Super Admin Borma')
@section('page_title', 'Overview Dashboard')

@section('content')
<!-- Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-5 gap-6 mb-8">
    
    <!-- Stat Card 1 -->
    <div class="bg-white dark:bg-white/5 dark:backdrop-blur-xl border border-slate-200 dark:border-white/10 shadow-sm dark:shadow-none rounded-2xl p-6 transition-all hover:-translate-y-1 hover:shadow-md duration-300">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-slate-500 dark:text-white/50 text-sm font-medium mb-1">Total Pesanan</p>
                <h3 class="text-3xl font-bold text-borma-purple dark:text-borma-yellow">{{ number_format($totalPesanan, 0, ',', '.') }}</h3>
            </div>
            <div class="w-10 h-10 rounded-xl bg-slate-100 dark:bg-borma-yellow/10 flex items-center justify-center text-borma-purple dark:text-borma-yellow">
                <i class="fa-solid fa-cart-shopping"></i>
            </div>
        </div>
    </div>

    <!-- Stat Card 2 -->
    <div class="bg-white dark:bg-white/5 dark:backdrop-blur-xl border border-slate-200 dark:border-white/10 shadow-sm dark:shadow-none rounded-2xl p-6 transition-all hover:-translate-y-1 hover:shadow-md duration-300">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-slate-500 dark:text-white/50 text-sm font-medium mb-1">Pengiriman Aktif</p>
                <h3 class="text-3xl font-bold text-slate-800 dark:text-white">{{ $pengirimanAktif }} <span class="text-sm font-normal text-slate-500 dark:text-white/50">Kurir</span></h3>
            </div>
            <div class="w-10 h-10 rounded-xl bg-blue-50 dark:bg-blue-500/10 flex items-center justify-center text-blue-600 dark:text-blue-400">
                <i class="fa-solid fa-motorcycle"></i>
            </div>
        </div>
    </div>

    <!-- Stat Card 3 -->
    <div class="bg-white dark:bg-white/5 dark:backdrop-blur-xl border border-slate-200 dark:border-white/10 shadow-sm dark:shadow-none rounded-2xl p-6 transition-all hover:-translate-y-1 hover:shadow-md duration-300">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-slate-500 dark:text-white/50 text-sm font-medium mb-1">Total Cabang</p>
                <h3 class="text-3xl font-bold text-slate-800 dark:text-white">{{ number_format($totalCabang, 0, ',', '.') }} <span class="text-sm font-normal text-slate-500 dark:text-white/50">Lokasi</span></h3>
            </div>
            <div class="w-10 h-10 rounded-xl bg-purple-50 dark:bg-purple-500/10 flex items-center justify-center text-purple-600 dark:text-purple-400">
                <i class="fa-solid fa-store"></i>
            </div>
        </div>
    </div>

    <!-- Stat Card 4 -->
    <div class="bg-white dark:bg-white/5 dark:backdrop-blur-xl border border-slate-200 dark:border-white/10 shadow-sm dark:shadow-none rounded-2xl p-6 transition-all hover:-translate-y-1 hover:shadow-md duration-300">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-slate-500 dark:text-white/50 text-sm font-medium mb-1">Promo Aktif</p>
                <h3 class="text-3xl font-bold text-borma-purple dark:text-borma-yellow">{{ $promoAktif }} <span class="text-sm font-normal text-slate-500 dark:text-white/50">Campaign</span></h3>
            </div>
            <div class="w-10 h-10 rounded-xl bg-slate-100 dark:bg-borma-yellow/10 flex items-center justify-center text-borma-purple dark:text-borma-yellow">
                <i class="fa-solid fa-ticket"></i>
            </div>
        </div>
    </div>

    <!-- Stat Card 5 -->
    <div class="bg-white dark:bg-white/5 dark:backdrop-blur-xl border border-slate-200 dark:border-white/10 shadow-sm dark:shadow-none rounded-2xl p-6 transition-all hover:-translate-y-1 hover:shadow-md duration-300">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-slate-500 dark:text-white/50 text-sm font-medium mb-1">Klaim Voucher</p>
                <h3 class="text-3xl font-bold text-slate-800 dark:text-white">{{ number_format($penggunaanVoucher, 0, ',', '.') }}</h3>
            </div>
            <div class="w-10 h-10 rounded-xl bg-green-50 dark:bg-green-500/10 flex items-center justify-center text-green-600 dark:text-green-400">
                <i class="fa-solid fa-gift"></i>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    <!-- Pesanan Terbaru -->
    <div class="lg:col-span-2 bg-white dark:bg-white/5 dark:backdrop-blur-xl border border-slate-200 dark:border-white/10 shadow-sm dark:shadow-none rounded-3xl p-6">
        <div class="flex justify-between items-center mb-6">
            <h4 class="text-lg font-bold text-slate-800 dark:text-white">Pesanan Terbaru</h4>
            <a href="{{ route('superadmin.pesanan') }}" class="text-sm text-borma-purple dark:text-borma-yellow hover:underline transition-colors flex items-center gap-2 font-medium">
                Lihat Semua <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-200 dark:border-white/10 text-slate-500 dark:text-white/50 text-sm">
                        <th class="pb-4 font-medium">ID Pesanan</th>
                        <th class="pb-4 font-medium">Pelanggan</th>
                        <th class="pb-4 font-medium">Total</th>
                        <th class="pb-4 font-medium">Status</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @foreach($pesananTerbaru as $pesanan)
                    <tr class="border-b border-slate-100 dark:border-white/5 hover:bg-slate-50 dark:hover:bg-white/5 transition-colors">
                        <td class="py-4 font-bold text-slate-800 dark:text-white">{{ $pesanan->id }}</td>
                        <td class="py-4 text-slate-600 dark:text-white/80">{{ $pesanan->pelanggan }}</td>
                        <td class="py-4 font-bold text-borma-purple dark:text-borma-yellow">Rp {{ number_format($pesanan->total, 0, ',', '.') }}</td>
                        <td class="py-4">
                            @php
                                $statusClasses = [
                                    'Selesai' => 'bg-green-100 dark:bg-green-500/20 text-green-700 dark:text-green-400 border-green-200 dark:border-green-500/20',
                                    'Dikirim' => 'bg-yellow-100 dark:bg-borma-yellow/20 text-yellow-700 dark:text-borma-yellow border-yellow-200 dark:border-borma-yellow/20',
                                    'Menunggu' => 'bg-red-100 dark:bg-red-500/20 text-red-700 dark:text-red-400 border-red-200 dark:border-red-500/20',
                                ];
                                $classes = $statusClasses[$pesanan->status] ?? 'bg-slate-100 dark:bg-gray-500/20 text-slate-700 dark:text-gray-400 border-slate-200 dark:border-gray-500/20';
                            @endphp
                            <span class="px-3 py-1 rounded-full text-xs font-bold border {{ $classes }}">
                                {{ $pesanan->status }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Quick Actions & Logistics -->
    <div class="flex flex-col gap-6">
        <!-- Aksi Cepat -->
        <div class="bg-gradient-to-br from-slate-100 dark:from-borma-purple/50 to-transparent dark:backdrop-blur-xl border border-slate-200 dark:border-white/10 rounded-3xl p-6">
            <h4 class="text-lg font-bold text-slate-800 dark:text-white mb-4">Aksi Cepat</h4>
            <div class="grid grid-cols-2 gap-3">
                <a href="{{ route('superadmin.cabang') }}" class="bg-white dark:bg-white/5 hover:bg-slate-50 dark:hover:bg-white/10 border border-slate-200 dark:border-white/10 rounded-xl p-4 text-left transition-all group shadow-sm dark:shadow-none">
                    <div class="w-10 h-10 rounded-full bg-slate-100 dark:bg-borma-yellow/20 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-store text-borma-purple dark:text-borma-yellow"></i>
                    </div>
                    <span class="text-sm font-bold text-slate-700 dark:text-white block">Manajemen Cabang</span>
                </a>
                <a href="{{ route('superadmin.promo') }}" class="bg-white dark:bg-white/5 hover:bg-slate-50 dark:hover:bg-white/10 border border-slate-200 dark:border-white/10 rounded-xl p-4 text-left transition-all group shadow-sm dark:shadow-none">
                    <div class="w-10 h-10 rounded-full bg-purple-50 dark:bg-purple-500/20 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-ticket text-purple-600 dark:text-purple-400"></i>
                    </div>
                    <span class="text-sm font-bold text-slate-700 dark:text-white block">Voucher & Promo</span>
                </a>
            </div>
        </div>

        <!-- Logistik Internal -->
        <div class="bg-white dark:bg-white/5 dark:backdrop-blur-xl border border-slate-200 dark:border-white/10 shadow-sm dark:shadow-none rounded-3xl p-6 flex-1">
            <h4 class="text-lg font-bold text-slate-800 dark:text-white mb-6">Logistik Internal</h4>
            
            <div class="flex justify-between items-center mb-4 pb-4 border-b border-slate-100 dark:border-white/10">
                <span class="text-slate-600 dark:text-white/70 flex items-center gap-2"><i class="fa-solid fa-motorcycle text-slate-400 dark:text-white/40"></i> Armada Aktif</span>
                <span class="font-bold text-lg text-slate-800 dark:text-white">{{ $armadaAktif }} <span class="text-sm text-slate-400 dark:text-white/40 font-normal">/ {{ $totalKurir }}</span></span>
            </div>
            
            <div class="flex justify-between items-center mb-6">
                <span class="text-slate-600 dark:text-white/70 flex items-center gap-2"><i class="fa-solid fa-box text-slate-400 dark:text-white/40"></i> Menunggu Pickup</span>
                <span class="font-bold text-lg {{ $menungguPickup > 0 ? 'text-red-500 dark:text-red-400' : 'text-slate-800 dark:text-white' }}">{{ $menungguPickup }}</span>
            </div>
            
            <a href="{{ route('superadmin.pengemudi') }}" class="w-full py-3 px-4 bg-borma-purple dark:bg-borma-yellow hover:bg-opacity-90 dark:hover:bg-[#F2C900] text-white dark:text-borma-purple font-bold rounded-xl transition-all flex items-center justify-center gap-2 shadow-md dark:shadow-[0_4px_14px_0_rgba(254,213,11,0.39)] hover:-translate-y-0.5">
                Pantau Logistik <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Performa Cabang -->
    <div class="lg:col-span-2 bg-white dark:bg-white/5 dark:backdrop-blur-xl border border-slate-200 dark:border-white/10 shadow-sm dark:shadow-none rounded-3xl p-6">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h4 class="text-lg font-bold text-slate-800 dark:text-white">Performa Per Cabang</h4>
                <p class="text-xs text-slate-500 dark:text-white/50 mt-1">Periode: {{ \Carbon\Carbon::now()->startOfMonth()->format('d M') }} - {{ \Carbon\Carbon::now()->format('d M Y') }}</p>
            </div>
            <a href="{{ route('superadmin.cabang') }}" class="text-sm text-borma-purple dark:text-borma-yellow hover:underline transition-colors flex items-center gap-2 font-medium">
                Lihat Detail <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-200 dark:border-white/10 text-slate-500 dark:text-white/50 text-sm">
                        <th class="pb-4 font-medium">Nama Cabang</th>
                        <th class="pb-4 font-medium">Total Pendapatan</th>
                        <th class="pb-4 font-medium text-right">Trend</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse($overviewCabang as $cabang)
                    <tr class="border-b border-slate-100 dark:border-white/5 hover:bg-slate-50 dark:hover:bg-white/5 transition-colors">
                        <td class="py-4 font-bold text-slate-800 dark:text-white">{{ $cabang->nama_cabang }}</td>
                        <td class="py-4 font-bold text-green-600 dark:text-green-400">Rp {{ number_format($cabang->pesanan_sum_total_tagihan ?? 0, 0, ',', '.') }}</td>
                        <td class="py-4 text-right">
                            <span class="text-green-700 dark:text-green-400 bg-green-100 dark:bg-green-400/10 px-2 py-1 rounded text-xs font-bold"><i class="fa-solid fa-arrow-trend-up mr-1"></i> Naik</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="py-8 text-center text-slate-500 dark:text-white/50">Belum ada data cabang.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Produk Terlaris -->
    <div class="bg-white dark:bg-white/5 dark:backdrop-blur-xl border border-slate-200 dark:border-white/10 shadow-sm dark:shadow-none rounded-3xl p-6">
        <h4 class="text-lg font-bold text-slate-800 dark:text-white mb-6">Produk Terlaris</h4>
        <div class="space-y-4">
            @forelse($produkPopuler as $item)
            <div class="flex items-center justify-between p-4 rounded-xl bg-slate-50 dark:bg-white/5 border border-slate-100 dark:border-white/5 hover:bg-slate-100 dark:hover:bg-white/10 transition-colors">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-slate-200 dark:bg-white/10 flex items-center justify-center text-slate-500 dark:text-white/50">
                        <i class="fa-solid fa-image"></i>
                    </div>
                    <div>
                        <p class="font-bold text-slate-800 dark:text-white text-sm">{{ $item->produk->nama_produk ?? 'Produk Tidak Ditemukan' }}</p>
                        <p class="text-xs text-slate-500 dark:text-white/50">Kategori</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="font-bold text-borma-purple dark:text-borma-yellow">{{ $item->total_terjual }}</p>
                    <p class="text-[10px] text-slate-400 dark:text-white/40 uppercase tracking-wide font-bold">Terjual</p>
                </div>
            </div>
            @empty
            <div class="text-center py-8 text-slate-500 dark:text-white/50 text-sm">
                Belum ada data penjualan produk.
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
