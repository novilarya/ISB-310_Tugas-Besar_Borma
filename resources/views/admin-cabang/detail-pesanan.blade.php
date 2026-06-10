@extends('admin-cabang.layouts.admin-cabang')
@section('title', 'Detail Pesanan | Admin Cabang Borma')
@section('page_title', 'Detail Pesanan')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div class="flex items-center gap-4">
        <a href="{{ route('admin-cabang.pesanan') }}" class="w-10 h-10 rounded-xl bg-white dark:bg-white/5 border border-slate-200 dark:border-white/10 flex items-center justify-center text-slate-500 dark:text-white/50 hover:bg-slate-50 dark:hover:bg-white/10 hover:text-borma-purple dark:hover:text-borma-yellow transition-all">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <div>
            <div class="flex items-center gap-3">
                <h1 class="text-2xl font-extrabold text-slate-800 dark:text-white tracking-tight">Detail Pesanan</h1>
                @php
                    $statusClasses = [
                        'Diterima' => 'bg-green-100 dark:bg-green-500/20 text-green-700 dark:text-green-400 border-green-200 dark:border-green-500/20',
                        'Sedang Dikirim' => 'bg-yellow-100 dark:bg-borma-yellow/20 text-yellow-700 dark:text-borma-yellow border-yellow-200 dark:border-borma-yellow/20',
                        'Menunggu' => 'bg-red-100 dark:bg-red-500/20 text-red-700 dark:text-red-400 border-red-200 dark:border-red-500/20',
                        'Disiapkan' => 'bg-blue-100 dark:bg-blue-500/20 text-blue-700 dark:text-blue-400 border-blue-200 dark:border-blue-500/20',
                        'dalam_pengiriman' => 'bg-amber-100 dark:bg-amber-500/20 text-amber-700 dark:text-amber-400 border-amber-200 dark:border-amber-500/20',
                        'selesai' => 'bg-emerald-100 dark:bg-emerald-500/20 text-emerald-700 dark:text-emerald-400 border-emerald-200 dark:border-emerald-500/20',
                    ];
                    $classes = $statusClasses[$pesanan->status_pesanan] ?? 'bg-slate-100 dark:bg-gray-500/20 text-slate-700 dark:text-gray-400 border-slate-200 dark:border-gray-500/20';
                @endphp
                <span class="px-2.5 py-1 rounded-lg text-xs font-bold border {{ $classes }}">
                    {{ $pesanan->status_pesanan }}
                </span>
            </div>
            <p class="text-sm text-slate-500 dark:text-white/50 mt-1">ORD-{{ str_pad($pesanan->id_pesanan, 4, '0', STR_PAD_LEFT) }} &bull; {{ \Carbon\Carbon::parse($pesanan->tanggal_pemesanan)->format('d M Y, H:i') }} WIB</p>
        </div>
    </div>
    
    <div class="flex items-center gap-3">
        @if($pesanan->status_pesanan === 'Menunggu')
        <form action="{{ route('admin-cabang.pesanan.confirm', $pesanan->id_pesanan) }}" method="POST" class="m-0 p-0">
            @csrf
            <button type="submit" class="bg-borma-purple hover:bg-purple-800 dark:bg-borma-yellow dark:hover:bg-yellow-500 text-white dark:text-slate-900 px-4 py-2 rounded-xl text-sm font-bold transition-all shadow-md flex items-center gap-2">
                <i class="fa-solid fa-circle-check"></i> Konfirmasi & Siapkan
            </button>
        </form>
        @elseif($pesanan->status_pesanan === 'Disiapkan')
        <form action="{{ route('admin-cabang.pesanan.dispatch', $pesanan->id_pesanan) }}" method="POST" class="m-0 p-0">
            @csrf
            <button type="submit" class="bg-borma-purple hover:bg-purple-800 dark:bg-borma-yellow dark:hover:bg-yellow-500 text-white dark:text-slate-900 px-4 py-2 rounded-xl text-sm font-bold transition-all shadow-md flex items-center gap-2">
                <i class="fa-solid fa-truck-ramp-box"></i> Kirim Pesanan
            </button>
        </form>
        @elseif(in_array($pesanan->status_pesanan, ['dalam_pengiriman', 'diterima', 'diterima_driver', 'diambil']))
        <form action="{{ route('admin-cabang.pesanan.complete', $pesanan->id_pesanan) }}" method="POST" class="m-0 p-0" onsubmit="return confirm('Selesaikan pesanan ini secara manual?');">
            @csrf
            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-xl text-sm font-bold transition-all shadow-md flex items-center gap-2">
                <i class="fa-solid fa-circle-check"></i> Selesaikan Pesanan
            </button>
        </form>
        @endif
        
        <a href="{{ route('admin-cabang.pesanan.nota', $pesanan->id_pesanan) }}" target="_blank" class="px-4 py-2 border border-slate-200 dark:border-white/10 rounded-xl hover:bg-slate-50 dark:hover:bg-white/5 text-slate-600 dark:text-white/70 hover:text-borma-purple dark:hover:text-white font-bold transition-all shadow-sm flex items-center gap-2">
            <i class="fa-solid fa-print"></i> Cetak Nota
        </a>
    </div>
</div>



<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Kolom Kiri: Detail Produk & Ringkasan -->
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white dark:bg-white/5 dark:backdrop-blur-xl border border-slate-200 dark:border-white/10 shadow-sm dark:shadow-none rounded-3xl p-6">


            <h4 class="font-bold text-slate-800 dark:text-white mb-4">Daftar Produk</h4>
            
            <div class="overflow-x-auto mb-6">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-200 dark:border-white/10 text-slate-500 dark:text-white/50 text-xs uppercase tracking-wider">
                            <th class="pb-3 font-medium px-2">Produk</th>
                            <th class="pb-3 font-medium px-2 text-right">Harga</th>
                            <th class="pb-3 font-medium px-2 text-center">Qty</th>
                            <th class="pb-3 font-medium px-2 text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        @foreach($pesanan->details as $item)
                        <tr class="border-b border-slate-100 dark:border-white/5">
                            <td class="py-4 px-2">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 bg-slate-100 dark:bg-white/10 rounded-xl overflow-hidden flex items-center justify-center">
                                        @if($item->produk && $item->produk->gambar_produk && $item->produk->gambar_produk !== 'default.jpg')
                                            <img src="{{ asset('storage/' . $item->produk->gambar_produk) }}" alt="Product" class="w-full h-full object-cover">
                                        @else
                                            <i class="fa-solid fa-box text-slate-400 dark:text-white/40"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-800 dark:text-white">{{ $item->produk->nama_produk ?? 'Produk Dihapus' }}</p>
                                        @if($item->catatan_produk)
                                            <p class="text-xs text-amber-500 mt-1 italic flex items-center gap-1">
                                                <i class="fa-solid fa-comment-dots"></i> Catatan: {{ $item->catatan_produk }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-2 text-right text-slate-600 dark:text-white/80">Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                            <td class="py-4 px-2 text-center font-bold text-slate-700 dark:text-white/90">{{ $item->jumlah }}</td>
                            <td class="py-4 px-2 text-right font-bold text-borma-purple dark:text-borma-yellow">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Ringkasan Biaya -->
            <div class="bg-slate-50 dark:bg-white/5 rounded-2xl p-5 border border-slate-200 dark:border-white/10">
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between text-slate-600 dark:text-white/70">
                        <span>Subtotal Belanja</span>
                        <span class="font-bold text-slate-800 dark:text-white">Rp {{ number_format($pesanan->total_belanja, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-slate-600 dark:text-white/70">
                        <span>Biaya Pengiriman</span>
                        <span class="font-bold text-slate-800 dark:text-white">Rp {{ number_format($pesanan->biaya_pengiriman, 0, ',', '.') }}</span>
                    </div>
                    @if($pesanan->diskon_voucher > 0)
                    <div class="flex justify-between text-green-600 dark:text-green-400">
                        <span>Diskon Voucher</span>
                        <span class="font-bold">- Rp {{ number_format($pesanan->diskon_voucher, 0, ',', '.') }}</span>
                    </div>
                    @endif
                    <div class="pt-3 border-t border-slate-200 dark:border-white/10 flex justify-between">
                        <span class="font-bold text-slate-800 dark:text-white text-base">Total Tagihan</span>
                        <span class="font-bold text-borma-purple dark:text-borma-yellow text-lg">Rp {{ number_format($pesanan->total_tagihan, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Promo / Voucher (jika ada) --}}
        @if($pesanan->promo)
        <div class="bg-white dark:bg-white/5 dark:backdrop-blur-xl border border-slate-200 dark:border-white/10 shadow-sm dark:shadow-none rounded-3xl p-6">
            <h4 class="font-bold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                <i class="fa-solid fa-ticket text-green-600 dark:text-green-400"></i> Promo Diterapkan
            </h4>
            <div class="flex items-center gap-3 bg-slate-50 dark:bg-white/5 p-4 rounded-2xl border border-slate-200 dark:border-white/10">
                <div class="w-10 h-10 rounded-xl bg-green-100 dark:bg-green-500/10 text-green-600 dark:text-green-400 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-gift"></i>
                </div>
                <div>
                    <div class="font-bold text-slate-800 dark:text-white text-sm">{{ $pesanan->promo->nama_voucher }}</div>
                    <div class="text-xs text-slate-500 dark:text-white/60">Kode: <strong class="font-bold text-slate-700 dark:text-white">{{ $pesanan->promo->kode_voucher }}</strong></div>
                </div>
                <span class="ms-auto inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700 dark:bg-green-500/20 dark:text-green-300">
                    Aktif
                </span>
            </div>
        </div>
        @endif
    </div>

    <!-- Kolom Kanan: Status & Info -->
    <div class="space-y-6">
        
        <!-- Status Timeline -->
        <div class="bg-white dark:bg-white/5 dark:backdrop-blur-xl border border-slate-200 dark:border-white/10 shadow-sm dark:shadow-none rounded-3xl p-6">
            <h4 class="font-bold text-slate-800 dark:text-white mb-4 border-b border-slate-200 dark:border-white/10 pb-3 flex items-center gap-2">
                <i class="fa-solid fa-bars-progress text-borma-purple dark:text-borma-yellow"></i> Status Pesanan
            </h4>
            @php
                $steps = ['Menunggu', 'Disiapkan', 'dalam_pengiriman', 'diterima', 'selesai'];
                $currentIdx = 0;
                if ($pesanan->status_pesanan === 'Disiapkan') $currentIdx = 1;
                elseif (in_array($pesanan->status_pesanan, ['mencari_driver', 'diterima_driver', 'diambil'])) $currentIdx = 1;
                elseif ($pesanan->status_pesanan === 'dalam_pengiriman') $currentIdx = 2;
                elseif ($pesanan->status_pesanan === 'diterima') $currentIdx = 3;
                elseif ($pesanan->status_pesanan === 'selesai') $currentIdx = 4;
            @endphp
            <div class="relative pl-6 border-l border-slate-200 dark:border-white/10 space-y-6 ml-3 py-1">
                @foreach($steps as $idx => $step)
                @php
                    $isDone   = $idx < $currentIdx;
                    $isActive = $idx === $currentIdx;
                @endphp
                <div class="relative">
                    <!-- Dot Indicator -->
                    <div class="absolute -left-[31px] top-1 w-4 h-4 rounded-full border-2 flex items-center justify-center text-[8px] transition-colors
                        {{ $isDone ? 'bg-borma-purple border-borma-purple text-white dark:bg-borma-yellow dark:border-borma-yellow dark:text-borma-dark' : ($isActive ? 'bg-amber-400 border-amber-400 text-white animate-pulse' : 'bg-white border-slate-300 dark:bg-borma-dark dark:border-white/15') }}">
                        @if($isDone) <i class="fa-solid fa-check"></i>
                        @endif
                    </div>
                    <div class="font-bold text-sm {{ $isActive ? 'text-borma-purple dark:text-borma-yellow' : ($isDone ? 'text-slate-600 dark:text-white/70' : 'text-slate-400 dark:text-white/40') }}">
                        {{ $step === 'Menunggu' ? 'Menunggu Konfirmasi' : ($step === 'diterima' ? 'Pesanan Tiba' : ($step === 'selesai' ? 'Selesai' : ($step === 'dalam_pengiriman' ? 'Sedang Dikirim' : $step))) }}
                    </div>
                    <div class="text-xs text-slate-500 dark:text-white/50 mt-0.5">
                        @if($isDone) <span class="text-green-600 dark:text-green-400"><i class="fa-solid fa-circle-check mr-1"></i>Selesai</span>
                        @elseif($isActive) <span class="text-amber-500"><i class="fa-solid fa-circle-dot mr-1"></i>Status saat ini</span>
                        @else <span class="text-slate-400 dark:text-white/30">Menunggu antrean...</span>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Info Pelanggan -->
        <div class="bg-white dark:bg-white/5 dark:backdrop-blur-xl border border-slate-200 dark:border-white/10 shadow-sm dark:shadow-none rounded-3xl p-6">
            <h4 class="font-bold text-slate-800 dark:text-white mb-4 border-b border-slate-200 dark:border-white/10 pb-3 flex items-center gap-2">
                <i class="fa-solid fa-user text-borma-purple dark:text-borma-yellow"></i> Informasi Pelanggan
            </h4>
            <div class="space-y-4">
                <div>
                    <p class="text-xs text-slate-500 dark:text-white/50 mb-1">Nama Pelanggan</p>
                    <p class="font-bold text-slate-800 dark:text-white">{{ $pesanan->pelanggan->user->nama ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-500 dark:text-white/50 mb-1">Nomor Telepon</p>
                    <p class="font-bold text-slate-800 dark:text-white">{{ $pesanan->pelanggan->user->no_telepon ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-500 dark:text-white/50 mb-1">Status Member</p>
                    <div class="mt-1">
                        @if($pesanan->pelanggan->status_member_plus)
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700 dark:bg-green-500/20 dark:text-green-300">
                                <i class="fa-solid fa-star text-[10px]"></i> Member Aktif
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-600 dark:bg-white/10 dark:text-white/60">
                                Non-Member
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Info Pengiriman -->
        <div class="bg-white dark:bg-white/5 dark:backdrop-blur-xl border border-slate-200 dark:border-white/10 shadow-sm dark:shadow-none rounded-3xl p-6">
            <h4 class="font-bold text-slate-800 dark:text-white mb-4 border-b border-slate-200 dark:border-white/10 pb-3 flex items-center gap-2">
                <i class="fa-solid fa-truck text-borma-purple dark:text-borma-yellow"></i> Informasi Pengiriman
            </h4>
            <div class="space-y-4">
                <div>
                    <p class="text-xs text-slate-500 dark:text-white/50 mb-1">Alamat Pengiriman</p>
                    <p class="font-medium text-slate-800 dark:text-white text-sm leading-relaxed">{{ $pesanan->alamat_pengiriman }}</p>
                </div>
                
                @if($pesanan->kurir)
                <div>
                    <p class="text-xs text-slate-500 dark:text-white/50 mb-1">Kurir Pengantar</p>
                    <div class="flex items-center gap-2 mt-1">
                        <div class="w-8 h-8 rounded-full bg-slate-100 dark:bg-white/10 flex items-center justify-center text-slate-500 dark:text-white/50">
                            <i class="fa-solid fa-motorcycle text-xs"></i>
                        </div>
                        <div>
                            <p class="font-bold text-slate-800 dark:text-white text-sm">{{ $pesanan->kurir->user->nama ?? '-' }}</p>
                            <p class="text-xs text-slate-500 dark:text-white/50">{{ $pesanan->kurir->kendaraan }} ({{ $pesanan->kurir->plat_nomor }})</p>
                        </div>
                    </div>
                </div>
                @endif
                
                <div>
                    <p class="text-xs text-slate-500 dark:text-white/50 mb-1">Metode Pembayaran</p>
                    <p class="font-bold text-slate-800 dark:text-white">{{ $pesanan->metode_pembayaran }}</p>
                </div>
            </div>
        </div>

        <!-- Bukti Pengiriman -->
        <div class="bg-white dark:bg-white/5 dark:backdrop-blur-xl border border-slate-200 dark:border-white/10 shadow-sm dark:shadow-none rounded-3xl p-6">
            <h4 class="font-bold text-slate-800 dark:text-white mb-4 border-b border-slate-200 dark:border-white/10 pb-3 flex items-center gap-2">
                <i class="fa-solid fa-camera text-borma-purple dark:text-borma-yellow"></i> Bukti Pengiriman
            </h4>
            
            <div class="mt-4">
                @if($pesanan->bukti_pengiriman)
                    <div class="w-full h-48 rounded-2xl overflow-hidden border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-black/20 group relative cursor-pointer">
                        <div class="absolute inset-0 flex items-center justify-center text-slate-400 dark:text-white/40 group-hover:bg-black/10 dark:group-hover:bg-black/30 transition-colors">
                            <div class="text-center">
                                <i class="fa-solid fa-image text-4xl mb-2"></i>
                                <p class="text-sm font-medium">{{ $pesanan->bukti_pengiriman }}</p>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="w-full h-32 rounded-2xl border-2 border-dashed border-slate-200 dark:border-white/10 flex items-center justify-center bg-slate-50 dark:bg-white/5">
                        <div class="text-center text-slate-400 dark:text-white/40">
                            <i class="fa-solid fa-clock-rotate-left text-2xl mb-2"></i>
                            <p class="text-sm font-medium">Belum ada foto</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection
