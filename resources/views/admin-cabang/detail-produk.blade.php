@extends('admin-cabang.layouts.admin-cabang')

@section('title', 'Detail Produk - Borma Toserba')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin-cabang.css') }}">
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
@endpush

@section('content')
<!-- Header dengan Tombol Kembali -->
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div class="flex items-center gap-4">
        <a href="{{ route('admin-cabang.produk') }}" class="w-10 h-10 rounded-xl bg-white dark:bg-white/5 border border-slate-200 dark:border-white/10 flex items-center justify-center text-slate-500 dark:text-white/50 hover:bg-slate-50 dark:hover:bg-white/10 hover:text-borma-purple dark:hover:text-borma-yellow transition-all">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="text-2xl font-extrabold text-slate-800 dark:text-white tracking-tight">Detail Produk</h1>
            <p class="text-sm text-slate-500 dark:text-white/50">ID Cabang: {{ $produkCabang->id_produk_cabang }} &bull; {{ $produkCabang->produk->kategori }}</p>
        </div>
    </div>
    
    <div class="flex items-center gap-3">
        <form action="{{ route('admin-cabang.produk.delete', $produkCabang->id_produk_cabang) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus produk ini dari cabang?');" class="m-0 p-0">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-500/20 text-red-600 dark:text-red-400 hover:bg-red-100 dark:hover:bg-red-500/20 px-4 py-2 rounded-xl text-sm font-bold transition-all shadow-sm flex items-center gap-2">
                <i class="fa-solid fa-trash"></i> Hapus Produk
            </button>
        </form>
        <button class="bg-borma-purple hover:bg-purple-800 dark:bg-borma-yellow dark:hover:bg-yellow-500 text-white dark:text-slate-900 px-4 py-2 rounded-xl text-sm font-bold transition-all shadow-md flex items-center gap-2" data-bs-toggle="modal" data-bs-target="#editProdukModal">
            <i class="fa-solid fa-pen-to-square"></i> Edit Informasi
        </button>
    </div>
</div>



<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Kolom Kiri: Informasi Utama & Gambar -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Riwayat Perubahan Harga (Paling atas) -->
        <div class="bg-white dark:bg-white/5 dark:backdrop-blur-xl border border-slate-200 dark:border-white/10 shadow-sm dark:shadow-none rounded-3xl p-6">
            <div class="flex justify-between items-center mb-4 pb-3 border-b border-slate-200 dark:border-white/10">
                <h4 class="font-bold text-slate-800 dark:text-white flex items-center gap-2">
                    <i class="fa-solid fa-clock-rotate-left text-borma-purple dark:text-borma-yellow"></i> Riwayat Perubahan Harga
                </h4>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-200 dark:border-white/10 text-slate-500 dark:text-white/50 text-xs uppercase tracking-wider">
                            <th class="pb-3 font-medium px-2">Waktu</th>
                            <th class="pb-3 font-medium px-2 text-right">Harga Member</th>
                            <th class="pb-3 font-medium px-2 text-right">Harga Member Plus</th>
                            <th class="pb-3 font-medium px-2 text-right">Admin</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        @forelse($riwayatHarga->take(5) as $riwayat)
                        <tr class="border-b border-slate-100 dark:border-white/5">
                            <td class="py-3 px-2 font-semibold text-slate-700 dark:text-slate-300">
                                {{ \Carbon\Carbon::parse($riwayat->created_at)->format('d M Y, H:i') }} WIB
                            </td>
                            <td class="py-3 px-2 text-right font-bold text-slate-800 dark:text-white">
                                Rp {{ number_format($riwayat->harga_member_baru, 0, ',', '.') }}
                            </td>
                            <td class="py-3 px-2 text-right font-bold text-amber-500">
                                Rp {{ number_format($riwayat->harga_member_plus_baru, 0, ',', '.') }}
                            </td>
                            <td class="py-3 px-2 text-right text-slate-500 dark:text-white/60">
                                <span class="inline-flex items-center gap-1.5 justify-end w-full">
                                    <i class="fa-solid fa-circle-user text-xs"></i>
                                    {{ $riwayat->adminCabang->user->nama ?? 'Sistem' }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-slate-400 dark:text-white/40 py-6">
                                Belum ada riwayat perubahan harga.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination UI -->
            <div class="flex justify-between items-center mt-4 pt-4 border-t border-dashed border-slate-200 dark:border-white/10">
                <span class="text-xs text-slate-500 dark:text-white/50">Menampilkan {{ min(5, $riwayatHarga->count()) }} dari {{ $riwayatHarga->count() }} data</span>
                <div class="flex gap-1">
                    <button class="w-8 h-8 rounded-lg border border-slate-200 dark:border-white/10 flex items-center justify-center text-slate-400 dark:text-white/30 cursor-not-allowed" disabled>
                        <i class="fa-solid fa-chevron-left text-xs"></i>
                    </button>
                    <button class="w-8 h-8 rounded-lg bg-borma-purple dark:bg-borma-yellow text-white dark:text-borma-dark flex items-center justify-center font-bold text-xs animate-pulse">
                        1
                    </button>
                    <button class="w-8 h-8 rounded-lg border border-slate-200 dark:border-white/10 flex items-center justify-center text-slate-400 dark:text-white/30 cursor-not-allowed" disabled>
                        <i class="fa-solid fa-chevron-right text-xs"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Informasi Utama & Gambar -->
        <div class="bg-white dark:bg-white/5 dark:backdrop-blur-xl border border-slate-200 dark:border-white/10 shadow-sm dark:shadow-none rounded-3xl p-6">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
                <!-- Gambar Produk -->
                <div class="md:col-span-5">
                    <div class="relative w-full aspect-square bg-slate-50 dark:bg-black/20 rounded-2xl border border-dashed border-slate-200 dark:border-white/10 overflow-hidden flex items-center justify-center">
                        @if($produkCabang->produk->gambar_produk && $produkCabang->produk->gambar_produk !== 'default.jpg')
                            <img src="{{ Storage::url($produkCabang->produk->gambar_produk) }}" alt="{{ $produkCabang->produk->nama_produk }}" class="w-full h-full object-cover">
                        @else
                            <i class="fa-solid fa-image text-slate-300 dark:text-white/20 text-5xl"></i>
                        @endif
                        
                        <div class="absolute top-4 right-4 px-3 py-1.5 rounded-lg text-xs font-bold shadow-sm {{ $produkCabang->jumlah_stok > 0 ? 'bg-green-100 text-green-800 dark:bg-green-500/20 dark:text-green-400' : 'bg-red-100 text-red-800 dark:bg-red-500/20 dark:text-red-400' }}">
                            {{ $produkCabang->jumlah_stok > 0 ? 'TERSEDIA' : 'HABIS' }}
                        </div>
                    </div>
                </div>
                
                <!-- Deskripsi & Info Ringkas -->
                <div class="md:col-span-7 flex flex-col justify-between">
                    <div>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-borma-purple/10 text-borma-purple dark:bg-borma-yellow/10 dark:text-borma-yellow mb-3">
                            {{ $produkCabang->produk->kategori }}
                        </span>
                        <h2 class="text-xl font-extrabold text-slate-800 dark:text-white mb-2 leading-snug">{{ $produkCabang->produk->nama_produk }}</h2>
                        <p class="text-sm text-slate-500 dark:text-white/60 leading-relaxed mb-6">{{ $produkCabang->produk->deskripsi ?? 'Tidak ada deskripsi produk.' }}</p>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-slate-50 dark:bg-white/5 border border-slate-200 dark:border-white/10 p-4 rounded-2xl">
                            <p class="text-xs text-slate-400 dark:text-white/40 font-medium">Harga Member</p>
                            <p class="text-lg font-bold text-slate-700 dark:text-white/80 mt-1">Rp {{ number_format($produkCabang->produk->harga_member, 0, ',', '.') }}</p>
                        </div>
                        <div class="bg-amber-500/5 dark:bg-borma-yellow/5 border border-amber-500/20 dark:border-borma-yellow/20 p-4 rounded-2xl">
                            <p class="text-xs text-amber-600 dark:text-borma-yellow/60 font-medium">Harga Member Plus</p>
                            <p class="text-xl font-black text-amber-500 dark:text-borma-yellow mt-1">Rp {{ number_format($produkCabang->produk->harga_member_plus, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Spesifikasi Detail -->
        <div class="bg-white dark:bg-white/5 dark:backdrop-blur-xl border border-slate-200 dark:border-white/10 shadow-sm dark:shadow-none rounded-3xl p-6">
            <h4 class="font-bold text-slate-800 dark:text-white mb-4 border-b border-slate-200 dark:border-white/10 pb-3 flex items-center gap-2">
                <i class="fa-solid fa-circle-info text-borma-purple dark:text-borma-yellow"></i> Spesifikasi Detail
            </h4>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <tbody class="divide-y divide-slate-100 dark:divide-white/5">
                        <tr>
                            <td class="py-3 font-semibold text-slate-500 dark:text-white/50 w-1/3">Nama Produk</td>
                            <td class="py-3 font-bold text-slate-800 dark:text-white">{{ $produkCabang->produk->nama_produk }}</td>
                        </tr>
                        <tr>
                            <td class="py-3 font-semibold text-slate-500 dark:text-white/50 w-1/3">Kategori</td>
                            <td class="py-3 font-bold text-slate-800 dark:text-white">{{ $produkCabang->produk->kategori }}</td>
                        </tr>
                        <tr>
                            <td class="py-3 font-semibold text-slate-500 dark:text-white/50 w-1/3">Cabang</td>
                            <td class="py-3 font-bold text-slate-800 dark:text-white">{{ $produkCabang->cabang->nama_cabang ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="py-3 font-semibold text-slate-500 dark:text-white/50 w-1/3">ID Produk Master</td>
                            <td class="py-3 font-mono font-bold text-slate-800 dark:text-white">{{ $produkCabang->id_produk }}</td>
                        </tr>
                        <tr>
                            <td class="py-3 font-semibold text-slate-500 dark:text-white/50 w-1/3 border-b-0">Terakhir Diperbarui</td>
                            <td class="py-3 font-bold text-slate-800 dark:text-white border-b-0">{{ $produkCabang->produk->updated_at ? $produkCabang->produk->updated_at->format('d M Y, H:i') : '-' }} WIB</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Kolom Kanan: Status Stok & Analitik -->
    <div class="space-y-6">
        <!-- Kartu Stok -->
        <div class="bg-white dark:bg-white/5 dark:backdrop-blur-xl border border-slate-200 dark:border-white/10 shadow-sm dark:shadow-none rounded-3xl p-6">
            <div class="flex justify-between items-center mb-4 border-b border-slate-200 dark:border-white/10 pb-3">
                <h4 class="font-bold text-slate-800 dark:text-white flex items-center gap-2">
                    <i class="fa-solid fa-box-open text-borma-purple dark:text-borma-yellow"></i> Ketersediaan Stok
                </h4>
                <div class="w-8 h-8 rounded-lg bg-borma-purple/10 dark:bg-borma-yellow/10 flex items-center justify-center text-borma-purple dark:text-borma-yellow">
                    <i class="fa-solid fa-warehouse text-xs"></i>
                </div>
            </div>
            
            <div class="flex items-baseline gap-2 mb-4">
                <h2 class="text-4xl font-extrabold text-slate-800 dark:text-white">{{ $produkCabang->jumlah_stok }}</h2>
                <span class="text-sm text-slate-500 dark:text-white/50 font-semibold">Unit tersisa</span>
            </div>
            
            @php
                $maxStok = 300;
                $stokPercent = min(100, ($produkCabang->jumlah_stok / $maxStok) * 100);
                $stokStatus = $produkCabang->jumlah_stok > 50 ? 'Aman' : ($produkCabang->jumlah_stok > 20 ? 'Perlu Restok' : 'Kritis');
                $stokColor = $produkCabang->jumlah_stok > 50 ? 'text-emerald-600 dark:text-emerald-400' : ($produkCabang->jumlah_stok > 20 ? 'text-amber-500' : 'text-rose-600 dark:text-rose-400');
            @endphp
            
            <div class="w-full bg-slate-100 dark:bg-white/10 h-2 rounded-full overflow-hidden mb-3">
                <div class="bg-borma-purple dark:bg-borma-yellow h-full rounded-full transition-all duration-500" style="width: {{ $stokPercent }}%"></div>
            </div>
            
            <p class="text-xs text-slate-500 dark:text-white/50">
                Status: <strong class="{{ $stokColor }}">{{ $stokStatus }}</strong> &bull; Minimal stok: 20
            </p>
        </div>

        <!-- Kartu Harga -->
        <div class="bg-white dark:bg-white/5 dark:backdrop-blur-xl border border-slate-200 dark:border-white/10 shadow-sm dark:shadow-none rounded-3xl p-6">
            <div class="flex justify-between items-center mb-4 border-b border-slate-200 dark:border-white/10 pb-3">
                <h4 class="font-bold text-slate-800 dark:text-white flex items-center gap-2">
                    <i class="fa-solid fa-tags text-borma-purple dark:text-borma-yellow"></i> Informasi Harga
                </h4>
                <div class="w-8 h-8 rounded-lg bg-borma-purple/10 dark:bg-borma-yellow/10 flex items-center justify-center text-borma-purple dark:text-borma-yellow">
                    <i class="fa-solid fa-rupiah-sign text-xs"></i>
                </div>
            </div>
            
            <div class="space-y-4">
                <div>
                    <span class="text-xs text-slate-400 dark:text-white/40 font-semibold">Harga Member</span>
                    <h3 class="text-xl font-bold text-slate-700 dark:text-white mt-0.5">Rp {{ number_format($produkCabang->produk->harga_member, 0, ',', '.') }}</h3>
                </div>
                <div>
                    <span class="text-xs text-amber-500 font-semibold">Harga Member Plus</span>
                    <h3 class="text-2xl font-black text-amber-500 dark:text-borma-yellow mt-0.5">Rp {{ number_format($produkCabang->produk->harga_member_plus, 0, ',', '.') }}</h3>
                </div>
                
                @php
                    $selisih = $produkCabang->produk->harga_member - $produkCabang->produk->harga_member_plus;
                @endphp
                <div class="pt-3 border-t border-dashed border-slate-200 dark:border-white/10">
                    <p class="text-xs text-slate-500 dark:text-white/50">
                        Hemat Member Plus: <strong class="text-emerald-600 dark:text-emerald-400">Rp {{ number_format($selisih, 0, ',', '.') }}</strong> ({{ round(($selisih / max(1, $produkCabang->produk->harga_member)) * 100, 1) }}% potongan)
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@include('admin-cabang.modal.edit-produk')
@endsection
