@extends('super-admin.layouts.app')
@section('title', 'Detail Pesanan | Super Admin Borma')
@section('page_title', 'Detail Pesanan')

@section('content')
<div class="mb-6 flex items-center justify-between">
    <a href="{{ route('superadmin.pesanan') }}" class="flex items-center gap-2 text-slate-500 hover:text-borma-purple dark:text-white/50 dark:hover:text-borma-yellow transition-colors font-medium">
        <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Pesanan
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Kolom Kiri: Detail Produk & Ringkasan -->
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white dark:bg-white/5 dark:backdrop-blur-xl border border-slate-200 dark:border-white/10 shadow-sm dark:shadow-none rounded-3xl p-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center border-b border-slate-200 dark:border-white/10 pb-5 mb-5">
                <div>
                    <h3 class="text-xl font-bold text-slate-800 dark:text-white">Pesanan <span class="text-borma-purple dark:text-borma-yellow">ORD-{{ str_pad($pesanan->id_pesanan, 4, '0', STR_PAD_LEFT) }}</span></h3>
                    <p class="text-sm text-slate-500 dark:text-white/50 mt-1"><i class="fa-regular fa-calendar mr-1"></i> {{ \Carbon\Carbon::parse($pesanan->tanggal_pemesanan)->format('d M Y, H:i') }}</p>
                </div>
                <div class="mt-4 md:mt-0">
                    @php
                        $statusClasses = [
                            'Diterima' => 'bg-green-100 dark:bg-green-500/20 text-green-700 dark:text-green-400 border-green-200 dark:border-green-500/20',
                            'Sedang Dikirim' => 'bg-yellow-100 dark:bg-borma-yellow/20 text-yellow-700 dark:text-borma-yellow border-yellow-200 dark:border-borma-yellow/20',
                            'Menunggu' => 'bg-red-100 dark:bg-red-500/20 text-red-700 dark:text-red-400 border-red-200 dark:border-red-500/20',
                            'Disiapkan' => 'bg-blue-100 dark:bg-blue-500/20 text-blue-700 dark:text-blue-400 border-blue-200 dark:border-blue-500/20',
                        ];
                        $classes = $statusClasses[$pesanan->status_pesanan] ?? 'bg-slate-100 dark:bg-gray-500/20 text-slate-700 dark:text-gray-400 border-slate-200 dark:border-gray-500/20';
                    @endphp
                    <span class="px-4 py-2 rounded-xl text-sm font-bold border {{ $classes }}">
                        {{ $pesanan->status_pesanan }}
                    </span>
                </div>
            </div>

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
                        @foreach($pesanan->details as $detail)
                        <tr class="border-b border-slate-100 dark:border-white/5">
                            <td class="py-4 px-2">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 bg-slate-100 dark:bg-white/10 rounded-xl overflow-hidden flex items-center justify-center">
                                        @if($detail->produk && $detail->produk->gambar_produk)
                                            <img src="{{ asset('storage/' . $detail->produk->gambar_produk) }}" alt="Product" class="w-full h-full object-cover">
                                        @else
                                            <i class="fa-solid fa-box text-slate-400 dark:text-white/40"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-800 dark:text-white">{{ $detail->produk->nama_produk ?? 'Produk Dihapus' }}</p>
                                        @if($detail->catatan_produk)
                                            <p class="text-xs text-slate-500 dark:text-white/50 mt-1 italic">Catatan: {{ $detail->catatan_produk }}</p>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-2 text-right text-slate-600 dark:text-white/80">Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                            <td class="py-4 px-2 text-center font-bold text-slate-700 dark:text-white/90">{{ $detail->jumlah }}</td>
                            <td class="py-4 px-2 text-right font-bold text-borma-purple dark:text-borma-yellow">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Ringkasan Biaya -->
            <div class="bg-slate-50 dark:bg-white/5 rounded-2xl p-5 border border-slate-200 dark:border-white/10">
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between text-slate-600 dark:text-white/70">
                        <span>Total Belanja</span>
                        <span class="font-bold text-slate-800 dark:text-white">Rp {{ number_format($pesanan->total_belanja, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-slate-600 dark:text-white/70">
                        <span>Biaya Pengiriman</span>
                        <span class="font-bold text-slate-800 dark:text-white">Rp {{ number_format($pesanan->biaya_pengiriman, 0, ',', '.') }}</span>
                    </div>
                    @if($pesanan->diskon_voucher > 0)
                    <div class="flex justify-between text-green-600 dark:text-green-400">
                        <span>Diskon</span>
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
    </div>

    <!-- Kolom Kanan: Informasi Tambahan -->
    <div class="space-y-6">
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
                    <p class="text-xs text-slate-500 dark:text-white/50 mb-1">Cabang Borma</p>
                    <p class="font-bold text-slate-800 dark:text-white">{{ $pesanan->cabang->nama_cabang ?? '-' }}</p>
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
                    @php
                        $pelanggan = $pesanan->pelanggan;
                        $alamatParts = array_filter([
                            $pelanggan->alamat ?? null,
                            $pelanggan->kecamatan ?? null,
                            $pelanggan->kota_kabupaten ?? null,
                            $pelanggan->provinsi ?? null,
                        ]);
                        $alamatLengkap = count($alamatParts)
                            ? implode(', ', $alamatParts)
                            : ($pesanan->alamat_pengiriman ?? '-');
                    @endphp
                    <p class="font-medium text-slate-800 dark:text-white text-sm leading-relaxed">{{ $alamatLengkap }}</p>
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
                        <!-- Normally this would point to actual storage path -->
                        <!-- <img src="{{ asset('storage/' . $pesanan->bukti_pengiriman) }}" alt="Bukti Pengiriman" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"> -->
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
