@extends('super-admin.layouts.app')
@section('title', 'Promo & Voucher | Super Admin Borma')
@section('page_title', 'Promo & Voucher')

@section('content')
<div class="grid grid-cols-1 gap-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h4 class="text-lg font-bold text-slate-800 dark:text-white">Promo & Voucher</h4>
            <p class="text-sm text-slate-500 dark:text-white/60">Kelola kampanye diskon dan kode voucher untuk seluruh atau cabang tertentu.</p>
        </div>
        <button onclick="openModal('tambahPromoModal')" class="bg-borma-purple hover:bg-purple-800 dark:bg-borma-yellow dark:hover:bg-yellow-500 text-white dark:text-slate-900 px-4 py-2 rounded-xl text-sm font-bold transition-all shadow-md flex items-center gap-2">
            <i class="fa-solid fa-plus"></i> Buat Promo Baru
        </button>
    </div>

    @if(session('success'))
    <div class="bg-green-100 dark:bg-green-500/20 text-green-700 dark:text-green-400 border border-green-200 dark:border-green-500/20 p-4 rounded-xl">
        {{ session('success') }}
    </div>
    @endif
    
    @if($errors->any())
    <div class="bg-red-100 dark:bg-red-500/20 text-red-700 dark:text-red-400 border border-red-200 dark:border-red-500/20 p-4 rounded-xl">
        {{ $errors->first() }}
    </div>
    @endif

    <!-- KPI Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white dark:bg-white/5 dark:backdrop-blur-xl border border-slate-200 dark:border-white/10 shadow-sm dark:shadow-none rounded-3xl p-6">
            <div class="flex justify-between items-start mb-4">
                <h5 class="text-slate-500 dark:text-white/60 font-medium">Promo Aktif</h5>
                <div class="w-10 h-10 rounded-xl bg-green-50 dark:bg-green-500/10 flex items-center justify-center text-green-600 dark:text-green-400">
                    <i class="fa-solid fa-ticket"></i>
                </div>
            </div>
            <h3 class="text-3xl font-bold text-slate-800 dark:text-white mb-1">{{ $totalAktif }}</h3>
            <p class="text-xs text-green-600 dark:text-green-400 font-medium">Sedang berjalan</p>
        </div>

        <div class="bg-white dark:bg-white/5 dark:backdrop-blur-xl border border-slate-200 dark:border-white/10 shadow-sm dark:shadow-none rounded-3xl p-6">
            <div class="flex justify-between items-start mb-4">
                <h5 class="text-slate-500 dark:text-white/60 font-medium">Terjadwal</h5>
                <div class="w-10 h-10 rounded-xl bg-blue-50 dark:bg-blue-500/10 flex items-center justify-center text-blue-600 dark:text-blue-400">
                    <i class="fa-solid fa-calendar-days"></i>
                </div>
            </div>
            <h3 class="text-3xl font-bold text-slate-800 dark:text-white mb-1">{{ $totalTerjadwal }}</h3>
            <p class="text-xs text-blue-600 dark:text-blue-400 font-medium">Akan datang</p>
        </div>

        <div class="bg-white dark:bg-white/5 dark:backdrop-blur-xl border border-slate-200 dark:border-white/10 shadow-sm dark:shadow-none rounded-3xl p-6">
            <div class="flex justify-between items-start mb-4">
                <h5 class="text-slate-500 dark:text-white/60 font-medium">Berakhir</h5>
                <div class="w-10 h-10 rounded-xl bg-slate-100 dark:bg-white/10 flex items-center justify-center text-slate-600 dark:text-white/60">
                    <i class="fa-solid fa-box-archive"></i>
                </div>
            </div>
            <h3 class="text-3xl font-bold text-slate-800 dark:text-white mb-1">{{ $totalBerakhir }}</h3>
            <p class="text-xs text-slate-500 dark:text-white/50 font-medium">Sudah habis masa berlaku</p>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="bg-white dark:bg-white/5 dark:backdrop-blur-xl border border-slate-200 dark:border-white/10 shadow-sm dark:shadow-none rounded-3xl p-4 md:p-6">
        <form action="{{ route('superadmin.promo') }}" method="GET" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1 relative">
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama promo atau kode voucher..." class="w-full pl-10 pr-4 py-2.5 bg-slate-50 dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow text-slate-800 dark:text-white transition-all">
            </div>
            <div class="md:w-48">
                <select name="status" class="w-full px-4 py-2.5 bg-slate-50 dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow text-slate-800 dark:text-white transition-all" onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    <option value="aktif" {{ request('status')=='aktif'?'selected':'' }}>Aktif</option>
                    <option value="terjadwal" {{ request('status')=='terjadwal'?'selected':'' }}>Terjadwal</option>
                    <option value="berakhir" {{ request('status')=='berakhir'?'selected':'' }}>Berakhir</option>
                </select>
            </div>
            <div class="md:w-48">
                <select name="id_cabang" class="w-full px-4 py-2.5 bg-slate-50 dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow text-slate-800 dark:text-white transition-all" onchange="this.form.submit()">
                    <option value="">Semua Cabang</option>
                    <option value="global" {{ request('id_cabang')=='global'?'selected':'' }}>Promo Global</option>
                    @foreach($cabangList as $c)
                    <option value="{{ $c->id_cabang }}" {{ request('id_cabang')==$c->id_cabang?'selected':'' }}>{{ $c->nama_cabang }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="bg-borma-purple hover:bg-purple-800 dark:bg-borma-yellow dark:hover:bg-yellow-500 text-white dark:text-slate-900 px-6 py-2.5 rounded-xl text-sm font-bold transition-all shadow-md">
                Filter
            </button>
            @if(request('search') || request('status') || request('id_cabang'))
            <a href="{{ route('superadmin.promo') }}" class="bg-slate-100 hover:bg-slate-200 dark:bg-white/10 dark:hover:bg-white/20 text-slate-600 dark:text-white px-6 py-2.5 rounded-xl text-sm font-bold transition-all text-center flex items-center justify-center">
                Reset
            </a>
            @endif
        </form>
    </div>

    <!-- Table -->
    <div class="bg-white dark:bg-white/5 dark:backdrop-blur-xl border border-slate-200 dark:border-white/10 shadow-sm dark:shadow-none rounded-3xl p-6">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-200 dark:border-white/10 text-slate-500 dark:text-white/50 text-sm">
                        <th class="pb-4 font-medium px-4">Nama Promo</th>
                        <th class="pb-4 font-medium px-4">Cabang</th>
                        <th class="pb-4 font-medium px-4">Kode Voucher</th>
                        <th class="pb-4 font-medium px-4">Pemicu Produk</th>
                        <th class="pb-4 font-medium px-4">Potongan</th>
                        <th class="pb-4 font-medium px-4">Periode</th>
                        <th class="pb-4 font-medium px-4">Kuota</th>
                        <th class="pb-4 font-medium px-4">Status</th>
                        <th class="pb-4 font-medium px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse($promos as $promo)
                    @php
                        $st = $promo->statusPromo();
                        $sisa = $promo->sisaHari();
                    @endphp
                    <tr class="border-b border-slate-100 dark:border-white/5 hover:bg-slate-50 dark:hover:bg-white/5 transition-colors">
                        <td class="py-4 px-4">
                            <div class="font-bold text-slate-800 dark:text-white">{{ $promo->nama_voucher }}</div>
                            @if($promo->id_produk_hadiah)
                                <div class="text-xs text-green-600 dark:text-green-400 mt-1 flex items-center gap-1">
                                    <i class="fa-solid fa-gift"></i> Hadiah: {{ $promo->produkHadiah->nama_produk ?? '-' }}
                                </div>
                            @endif
                        </td>
                        <td class="py-4 px-4">
                            @if($promo->id_cabang && $promo->cabang)
                                <div class="font-medium text-slate-700 dark:text-white/80 text-sm">{{ $promo->cabang->nama_cabang }}</div>
                            @else
                                <span class="bg-indigo-50 text-indigo-700 dark:bg-indigo-500/20 dark:text-indigo-400 font-bold px-2 py-1 rounded text-[10px] uppercase tracking-wider border border-indigo-100 dark:border-indigo-500/30">Seluruh Cabang</span>
                            @endif
                        </td>
                        <td class="py-4 px-4">
                            @if($promo->kode_voucher)
                                <span class="bg-purple-50 text-borma-purple dark:bg-borma-yellow/20 dark:text-borma-yellow font-mono font-bold px-2 py-1 rounded text-xs tracking-wider border border-purple-100 dark:border-borma-yellow/30">
                                    {{ $promo->kode_voucher }}
                                </span>
                            @else
                                <span class="text-slate-400 dark:text-white/40 text-xs">— Tanpa kode —</span>
                            @endif
                        </td>
                        <td class="py-4 px-4">
                            <div class="font-semibold text-slate-700 dark:text-white/80 line-clamp-1">{{ $promo->produkPemicu->nama_produk ?? '-' }}</div>
                            <div class="text-xs text-slate-500 dark:text-white/50 mt-1">Min. beli {{ $promo->kuantitas_pemicu }} pcs</div>
                        </td>
                        <td class="py-4 px-4">
                            <div class="font-bold text-borma-purple dark:text-borma-yellow">Rp {{ number_format($promo->potongan_harga, 0, ',', '.') }}</div>
                            @if($promo->min_transaksi > 0)
                                <div class="text-xs text-slate-500 dark:text-white/50 mt-1">Min. transaksi Rp {{ number_format($promo->min_transaksi, 0, ',', '.') }}</div>
                            @endif
                        </td>
                        <td class="py-4 px-4">
                            <div class="font-medium text-slate-700 dark:text-white/80">{{ $promo->tanggal_mulai->format('d M Y') }}</div>
                            <div class="text-xs text-slate-500 dark:text-white/50">s/d {{ $promo->tanggal_berakhir->format('d M Y') }}</div>
                            @if($st === 'aktif')
                                <div class="text-xs font-bold mt-1 {{ $sisa <= 3 ? 'text-red-500' : 'text-slate-500 dark:text-white/50' }}">
                                    <i class="fa-regular fa-clock"></i> {{ $sisa >= 0 ? $sisa . ' hari lagi' : 'Habis' }}
                                </div>
                            @endif
                        </td>
                        <td class="py-4 px-4">
                            <div class="font-bold text-slate-800 dark:text-white">{{ number_format($promo->kuota_promo, 0, ',', '.') }}</div>
                        </td>
                        <td class="py-4 px-4">
                            @if($st === 'aktif')
                                <span class="px-2 py-1 bg-green-100 text-green-700 dark:bg-green-500/20 dark:text-green-400 rounded-md text-[10px] font-bold uppercase tracking-wider">Aktif</span>
                            @elseif($st === 'terjadwal')
                                <span class="px-2 py-1 bg-blue-100 text-blue-700 dark:bg-blue-500/20 dark:text-blue-400 rounded-md text-[10px] font-bold uppercase tracking-wider">Terjadwal</span>
                            @else
                                <span class="px-2 py-1 bg-slate-100 text-slate-600 dark:bg-white/10 dark:text-white/60 rounded-md text-[10px] font-bold uppercase tracking-wider">Berakhir</span>
                            @endif
                        </td>
                        <td class="py-4 px-4 text-right">
                            <div class="flex justify-end gap-2">
                                <button onclick="openEditModal('{{ $promo->id_promo }}', '{{ addslashes($promo->nama_voucher) }}', '{{ addslashes($promo->kode_voucher ?? '') }}', '{{ $promo->id_produk_pemicu }}', '{{ $promo->id_produk_hadiah ?? '' }}', '{{ $promo->kuantitas_pemicu }}', '{{ $promo->kuantitas_hadiah }}', '{{ $promo->potongan_harga }}', '{{ $promo->min_transaksi }}', '{{ $promo->max_promo }}', '{{ $promo->kuota_promo }}', '{{ $promo->tanggal_mulai->format('Y-m-d') }}', '{{ $promo->tanggal_berakhir->format('Y-m-d') }}', '{{ $promo->id_cabang ?? '' }}')" class="w-8 h-8 rounded-lg bg-slate-100 hover:bg-slate-200 text-borma-purple dark:bg-white/10 dark:hover:bg-white/20 dark:text-borma-yellow flex items-center justify-center transition-colors">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                <form action="{{ route('superadmin.promo.delete', $promo->id_promo) }}" method="POST" onsubmit="return confirm('Hapus promo \'{{ addslashes($promo->nama_voucher) }}\'?');" class="inline">
                                    @csrf 
                                    @method('DELETE')
                                    <button type="submit" class="w-8 h-8 rounded-lg bg-red-50 hover:bg-red-100 text-red-600 dark:bg-red-500/10 dark:hover:bg-red-500/20 dark:text-red-400 flex items-center justify-center transition-colors">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="py-12 text-center text-slate-500 dark:text-white/50">
                            <i class="fa-solid fa-tags text-4xl mb-3 opacity-30"></i>
                            <p class="font-medium">Belum ada data promo.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-6 flex justify-between items-center text-sm text-slate-500 dark:text-white/50">
            <div>
                Menampilkan {{ $promos->firstItem() ?? 0 }} – {{ $promos->lastItem() ?? 0 }} dari {{ $promos->total() }} promo
            </div>
            <div>
                {{ $promos->links('pagination::tailwind') }}
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Promo -->
<div id="tambahPromoModal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black/50 backdrop-blur-sm transition-opacity">
    <div class="bg-white dark:bg-slate-900 w-full max-w-2xl max-h-[90vh] flex flex-col rounded-3xl shadow-2xl border border-slate-200 dark:border-white/10 transform scale-95 opacity-0 transition-all duration-300">
        <div class="p-6 border-b border-slate-200 dark:border-white/10 flex justify-between items-center bg-slate-50 dark:bg-white/5 shrink-0 rounded-t-3xl">
            <h3 class="font-bold text-lg text-slate-800 dark:text-white">Buat Promo Baru</h3>
            <button type="button" onclick="closeModal('tambahPromoModal')" class="text-slate-400 hover:text-slate-600 dark:hover:text-white transition-colors">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>
        
        <form action="{{ route('superadmin.promo.store') }}" method="POST" class="flex flex-col h-full overflow-hidden">
            @csrf
            <div class="p-6 overflow-y-auto flex-1 custom-scrollbar space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-slate-700 dark:text-white/80 mb-2">Cabang <span class="text-red-500">*</span></label>
                        <select name="id_cabang" class="w-full bg-white dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow text-slate-800 dark:text-white">
                            <option value="">Seluruh Cabang</option>
                            @foreach($cabangList as $c)
                                <option value="{{ $c->id_cabang }}">{{ $c->nama_cabang }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-white/80 mb-2">Nama Promo <span class="text-red-500">*</span></label>
                        <input type="text" name="nama_voucher" required class="w-full bg-white dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow text-slate-800 dark:text-white">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-white/80 mb-2">Kode Voucher</label>
                        <input type="text" name="kode_voucher" placeholder="Opsional" class="w-full bg-white dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow text-slate-800 dark:text-white uppercase font-mono">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-white/80 mb-2">Produk Pemicu <span class="text-red-500">*</span></label>
                        <select name="id_produk_pemicu" required class="w-full bg-white dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow text-slate-800 dark:text-white">
                            <option value="">Pilih Produk</option>
                            @foreach($produkList as $pc)
                                <option value="{{ $pc->id_produk }}">{{ $pc->nama_produk }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-white/80 mb-2">Min. Kuantitas Pemicu <span class="text-red-500">*</span></label>
                        <input type="number" name="kuantitas_pemicu" required min="1" value="1" class="w-full bg-white dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow text-slate-800 dark:text-white">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 border-t border-slate-200 dark:border-white/10 pt-4 mt-2">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-white/80 mb-2">Produk Hadiah (Opsional)</label>
                        <select name="id_produk_hadiah" class="w-full bg-white dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow text-slate-800 dark:text-white">
                            <option value="">Tidak ada hadiah</option>
                            @foreach($produkList as $pc)
                                <option value="{{ $pc->id_produk }}">{{ $pc->nama_produk }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-white/80 mb-2">Kuantitas Hadiah</label>
                        <input type="number" name="kuantitas_hadiah" min="0" value="0" class="w-full bg-white dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow text-slate-800 dark:text-white">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 border-t border-slate-200 dark:border-white/10 pt-4 mt-2">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-white/80 mb-2">Potongan Harga (Rp)</label>
                        <input type="number" name="potongan_harga" min="0" value="0" class="w-full bg-white dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow text-slate-800 dark:text-white">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-white/80 mb-2">Min. Transaksi (Rp)</label>
                        <input type="number" name="min_transaksi" min="0" value="0" class="w-full bg-white dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow text-slate-800 dark:text-white">
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-white/80 mb-2">Maks. Promo/Pengguna (0=Unlimited)</label>
                        <input type="number" name="max_promo" min="0" value="0" class="w-full bg-white dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow text-slate-800 dark:text-white">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-white/80 mb-2">Total Kuota Promo <span class="text-red-500">*</span></label>
                        <input type="number" name="kuota_promo" required min="1" class="w-full bg-white dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow text-slate-800 dark:text-white">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 border-t border-slate-200 dark:border-white/10 pt-4 mt-2">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-white/80 mb-2">Tanggal Mulai <span class="text-red-500">*</span></label>
                        <input type="date" name="tanggal_mulai" required class="w-full bg-white dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow text-slate-800 dark:text-white">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-white/80 mb-2">Tanggal Berakhir <span class="text-red-500">*</span></label>
                        <input type="date" name="tanggal_berakhir" required class="w-full bg-white dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow text-slate-800 dark:text-white">
                    </div>
                </div>
            </div>
            <div class="p-6 border-t border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-white/5 shrink-0 rounded-b-3xl flex justify-end gap-3">
                <button type="button" onclick="closeModal('tambahPromoModal')" class="px-5 py-2.5 rounded-xl text-sm font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 dark:text-white dark:bg-white/10 dark:hover:bg-white/20 transition-colors">Batal</button>
                <button type="submit" class="px-5 py-2.5 rounded-xl text-sm font-bold text-white bg-borma-purple hover:bg-purple-800 dark:bg-borma-yellow dark:text-slate-900 dark:hover:bg-yellow-500 transition-colors shadow-sm">Simpan Promo</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Promo -->
<div id="editPromoModal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black/50 backdrop-blur-sm transition-opacity">
    <div class="bg-white dark:bg-slate-900 w-full max-w-2xl max-h-[90vh] flex flex-col rounded-3xl shadow-2xl border border-slate-200 dark:border-white/10 transform scale-95 opacity-0 transition-all duration-300">
        <div class="p-6 border-b border-slate-200 dark:border-white/10 flex justify-between items-center bg-slate-50 dark:bg-white/5 shrink-0 rounded-t-3xl">
            <h3 class="font-bold text-lg text-slate-800 dark:text-white">Kelola Promo</h3>
            <button type="button" onclick="closeModal('editPromoModal')" class="text-slate-400 hover:text-slate-600 dark:hover:text-white transition-colors">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>
        
        <form id="editPromoForm" method="POST" class="flex flex-col h-full overflow-hidden">
            @csrf
            @method('PUT')
            <div class="p-6 overflow-y-auto flex-1 custom-scrollbar space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-slate-700 dark:text-white/80 mb-2">Cabang <span class="text-red-500">*</span></label>
                        <select name="id_cabang" id="eCabang" class="w-full bg-white dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow text-slate-800 dark:text-white">
                            <option value="">Seluruh Cabang</option>
                            @foreach($cabangList as $c)
                                <option value="{{ $c->id_cabang }}">{{ $c->nama_cabang }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-white/80 mb-2">Nama Promo <span class="text-red-500">*</span></label>
                        <input type="text" name="nama_voucher" id="eNama" required class="w-full bg-white dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow text-slate-800 dark:text-white">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-white/80 mb-2">Kode Voucher</label>
                        <input type="text" name="kode_voucher" id="eKode" placeholder="Opsional" class="w-full bg-white dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow text-slate-800 dark:text-white uppercase font-mono">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-white/80 mb-2">Produk Pemicu <span class="text-red-500">*</span></label>
                        <select name="id_produk_pemicu" id="ePemicu" required class="w-full bg-white dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow text-slate-800 dark:text-white">
                            <option value="">Pilih Produk</option>
                            @foreach($produkList as $pc)
                                <option value="{{ $pc->id_produk }}">{{ $pc->nama_produk }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-white/80 mb-2">Min. Kuantitas Pemicu <span class="text-red-500">*</span></label>
                        <input type="number" name="kuantitas_pemicu" id="eQtyPemicu" required min="1" class="w-full bg-white dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow text-slate-800 dark:text-white">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 border-t border-slate-200 dark:border-white/10 pt-4 mt-2">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-white/80 mb-2">Produk Hadiah (Opsional)</label>
                        <select name="id_produk_hadiah" id="eHadiah" class="w-full bg-white dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow text-slate-800 dark:text-white">
                            <option value="">Tidak ada hadiah</option>
                            @foreach($produkList as $pc)
                                <option value="{{ $pc->id_produk }}">{{ $pc->nama_produk }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-white/80 mb-2">Kuantitas Hadiah</label>
                        <input type="number" name="kuantitas_hadiah" id="eQtyHadiah" min="0" class="w-full bg-white dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow text-slate-800 dark:text-white">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 border-t border-slate-200 dark:border-white/10 pt-4 mt-2">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-white/80 mb-2">Potongan Harga (Rp)</label>
                        <input type="number" name="potongan_harga" id="ePotongan" min="0" class="w-full bg-white dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow text-slate-800 dark:text-white">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-white/80 mb-2">Min. Transaksi (Rp)</label>
                        <input type="number" name="min_transaksi" id="eMin" min="0" class="w-full bg-white dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow text-slate-800 dark:text-white">
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-white/80 mb-2">Maks. Promo/Pengguna</label>
                        <input type="number" name="max_promo" id="eMax" min="0" class="w-full bg-white dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow text-slate-800 dark:text-white">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-white/80 mb-2">Total Kuota Promo <span class="text-red-500">*</span></label>
                        <input type="number" name="kuota_promo" id="eKuota" required min="1" class="w-full bg-white dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow text-slate-800 dark:text-white">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 border-t border-slate-200 dark:border-white/10 pt-4 mt-2">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-white/80 mb-2">Tanggal Mulai <span class="text-red-500">*</span></label>
                        <input type="date" name="tanggal_mulai" id="eMulai" required class="w-full bg-white dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow text-slate-800 dark:text-white">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-white/80 mb-2">Tanggal Berakhir <span class="text-red-500">*</span></label>
                        <input type="date" name="tanggal_berakhir" id="eBerakhir" required class="w-full bg-white dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow text-slate-800 dark:text-white">
                    </div>
                </div>
            </div>
            <div class="p-6 border-t border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-white/5 shrink-0 rounded-b-3xl flex justify-end gap-3">
                <button type="button" onclick="closeModal('editPromoModal')" class="px-5 py-2.5 rounded-xl text-sm font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 dark:text-white dark:bg-white/10 dark:hover:bg-white/20 transition-colors">Batal</button>
                <button type="submit" class="px-5 py-2.5 rounded-xl text-sm font-bold text-white bg-borma-purple hover:bg-purple-800 dark:bg-borma-yellow dark:text-slate-900 dark:hover:bg-yellow-500 transition-colors shadow-sm">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal(id) {
        const modal = document.getElementById(id);
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.querySelector('div').classList.remove('scale-95', 'opacity-0');
            modal.querySelector('div').classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    function closeModal(id) {
        const modal = document.getElementById(id);
        modal.querySelector('div').classList.remove('scale-100', 'opacity-100');
        modal.querySelector('div').classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }

    function openEditModal(id, nama, kode, pemicu, hadiah, qtyPemicu, qtyHadiah, potongan, min, max, kuota, mulai, berakhir, cabang) {
        document.getElementById('eNama').value = nama;
        document.getElementById('eKode').value = kode;
        document.getElementById('ePemicu').value = pemicu;
        document.getElementById('eHadiah').value = hadiah;
        document.getElementById('eQtyPemicu').value = qtyPemicu;
        document.getElementById('eQtyHadiah').value = qtyHadiah;
        document.getElementById('ePotongan').value = potongan;
        document.getElementById('eMin').value = min;
        document.getElementById('eMax').value = max;
        document.getElementById('eKuota').value = kuota;
        document.getElementById('eMulai').value = mulai;
        document.getElementById('eBerakhir').value = berakhir;
        document.getElementById('eCabang').value = cabang;

        document.getElementById('editPromoForm').action = `/superadmin/promo/update/${id}`;
        openModal('editPromoModal');
    }
</script>
@endsection
