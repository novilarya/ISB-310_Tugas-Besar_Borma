@extends('admin-cabang.layouts.admin-cabang')

@section('title', 'Detail Member - Borma Toserba')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin-cabang.css') }}">
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
@endpush

@section('content')
<!-- Header dengan Tombol Kembali -->
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div class="flex items-center gap-4">
        <a href="{{ route('admin-cabang.member') }}" class="w-10 h-10 rounded-xl bg-white dark:bg-white/5 border border-slate-200 dark:border-white/10 flex items-center justify-center text-slate-500 dark:text-white/50 hover:bg-slate-50 dark:hover:bg-white/10 hover:text-borma-purple dark:hover:text-borma-yellow transition-all">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="text-2xl font-extrabold text-slate-800 dark:text-white tracking-tight">Detail Member</h1>
            <p class="text-sm text-slate-500 dark:text-white/50 mt-1">Profil dan riwayat pembelian member: {{ $member->user->nama ?? '-' }}</p>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Profil Member (Read Only) -->
    <div class="lg:col-span-1">
        <div class="bg-white dark:bg-white/5 dark:backdrop-blur-xl border border-slate-200 dark:border-white/10 shadow-sm dark:shadow-none rounded-3xl p-6">
            <h4 class="font-bold text-slate-800 dark:text-white mb-4 border-b border-slate-200 dark:border-white/10 pb-3 flex items-center gap-2">
                <i class="fa-solid fa-user text-borma-purple dark:text-borma-yellow"></i> Profil Member
            </h4>
            
            <div class="space-y-4">
                <div>
                    <span class="text-xs text-slate-400 dark:text-white/40 font-semibold block">Nama Lengkap</span>
                    <span class="font-bold text-slate-800 dark:text-white text-sm block mt-0.5">{{ $member->user->nama ?? '-' }}</span>
                </div>
                
                <div>
                    <span class="text-xs text-slate-400 dark:text-white/40 font-semibold block">Email</span>
                    <span class="font-bold text-slate-800 dark:text-white text-sm block mt-0.5">{{ $member->user->email ?? '-' }}</span>
                </div>
                
                <div>
                    <span class="text-xs text-slate-400 dark:text-white/40 font-semibold block">Nomor Telepon</span>
                    <span class="font-bold text-slate-800 dark:text-white text-sm block mt-0.5">{{ $member->user->no_telepon ?? '-' }}</span>
                </div>

                <div>
                    <span class="text-xs text-slate-400 dark:text-white/40 font-semibold block">Status Member</span>
                    <div class="mt-1">
                        @if($member->status_member_plus)
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700 dark:bg-green-500/20 dark:text-green-400 border border-green-200 dark:border-green-500/30">
                                <i class="fa-solid fa-star text-[10px]"></i> Member Plus
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-600 dark:bg-white/10 dark:text-white/60 border border-slate-200 dark:border-white/20">
                                Member
                            </span>
                        @endif
                    </div>
                </div>

                <div>
                    <span class="text-xs text-slate-400 dark:text-white/40 font-semibold block">Poin Member</span>
                    <span class="font-extrabold text-borma-purple dark:text-borma-yellow text-lg block mt-0.5" style="color: var(--borma-primary) !important;">{{ number_format($member->poin_member, 0, ',', '.') }} Poin</span>
                </div>

                <div class="pt-3 border-t border-dashed border-slate-200 dark:border-white/10">
                    <span class="text-xs text-slate-400 dark:text-white/40 font-semibold block">Provinsi</span>
                    <span class="font-bold text-slate-800 dark:text-white text-sm block mt-0.5">{{ $member->provinsi ?? '-' }}</span>
                </div>

                <div>
                    <span class="text-xs text-slate-400 dark:text-white/40 font-semibold block">Kota / Kabupaten</span>
                    <span class="font-bold text-slate-800 dark:text-white text-sm block mt-0.5">{{ $member->kota_kabupaten ?? '-' }}</span>
                </div>

                <div>
                    <span class="text-xs text-slate-400 dark:text-white/40 font-semibold block">Kecamatan</span>
                    <span class="font-bold text-slate-800 dark:text-white text-sm block mt-0.5">{{ $member->kecamatan ?? '-' }}</span>
                </div>

                <div>
                    <span class="text-xs text-slate-400 dark:text-white/40 font-semibold block">Alamat Detail</span>
                    <span class="font-medium text-slate-700 dark:text-white/80 text-sm block mt-0.5 leading-relaxed">{{ $member->alamat ?? '-' }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Riwayat Pembelian -->
    <div class="lg:col-span-2">
        <div class="bg-white dark:bg-white/5 dark:backdrop-blur-xl border border-slate-200 dark:border-white/10 shadow-sm dark:shadow-none rounded-3xl p-6 flex flex-col h-100">
            <h4 class="font-bold text-slate-800 dark:text-white mb-4 border-b border-slate-200 dark:border-white/10 pb-3 flex items-center gap-2">
                <i class="fa-solid fa-receipt text-borma-purple dark:text-borma-yellow"></i> Riwayat Pembelian
            </h4>
            
            @if($member->riwayatPesanan->isEmpty())
                <div class="flex flex-col items-center justify-center p-12 text-slate-500 dark:text-white/50 bg-slate-50 dark:bg-white/5 rounded-2xl border border-dashed border-slate-200 dark:border-white/10 flex-grow-1">
                    <div class="w-16 h-16 rounded-full bg-slate-200 dark:bg-white/10 flex items-center justify-center text-3xl mb-4">
                        <i class="fa-solid fa-box-open opacity-50"></i>
                    </div>
                    <p class="font-medium text-lg text-slate-600 dark:text-white/70">Belum Ada Transaksi</p>
                    <p class="text-sm mt-1">Member ini belum pernah melakukan pembelian.</p>
                </div>
            @else
                <div class="space-y-4 max-h-[750px] overflow-y-auto pr-1">
                    @foreach($member->riwayatPesanan as $pesanan)
                    <div class="bg-white dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-2xl p-5 hover:border-borma-purple/30 dark:hover:border-borma-yellow/30 transition-all shadow-sm">
                        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-4 pb-4 border-b border-slate-100 dark:border-white/10 gap-3">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl bg-purple-50 dark:bg-white/10 flex items-center justify-center text-borma-purple dark:text-borma-yellow">
                                    <i class="fa-solid fa-shopping-bag"></i>
                                </div>
                                <div>
                                    <span class="text-sm font-bold text-slate-800 dark:text-white">ORD-{{ str_pad($pesanan->id_pesanan, 4, '0', STR_PAD_LEFT) }}</span>
                                    <p class="text-xs text-slate-500 dark:text-white/50">{{ \Carbon\Carbon::parse($pesanan->tanggal_pemesanan)->format('d M Y, H:i') }} WIB</p>
                                </div>
                            </div>
                            <div class="flex flex-col md:items-end w-full md:w-auto">
                                @php
                                    $statusMap = [
                                        'Menunggu'         => ['class'=>'status-pending',     'label'=>'Menunggu Konfirmasi'],
                                        'Disiapkan'        => ['class'=>'status-siap',        'label'=>'Disiapkan'],
                                        'mencari_driver'   => ['class'=>'status-cari-driver', 'label'=>'Mencari Kurir'],
                                        'diterima_driver'  => ['class'=>'status-siap',        'label'=>'Diterima Driver'],
                                        'diambil'          => ['class'=>'status-siap',        'label'=>'Diambil Driver'],
                                        'dalam_pengiriman' => ['class'=>'status-dikirim',     'label'=>'Dikirim'],
                                        'diterima'         => ['class'=>'status-pending',     'label'=>'Pesanan Tiba'],
                                        'selesai'          => ['class'=>'status-selesai',     'label'=>'Selesai'],
                                        'gagal'            => ['class'=>'status-pending',     'label'=>'Gagal Kirim'],
                                        'ditolak_driver'   => ['class'=>'status-pending',     'label'=>'Ditolak Driver'],
                                    ];
                                    $st = $statusMap[$pesanan->status_pesanan] ?? ['class'=>'status-pending', 'label'=>$pesanan->status_pesanan];
                                @endphp
                                <span class="status-badge-modern {{ $st['class'] }}">
                                    {{ $st['label'] }}
                                </span>
                                <p class="text-sm font-bold text-green-600 dark:text-green-400 mt-2">Total: Rp {{ number_format($pesanan->total_tagihan, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        
                        <!-- Rincian Produk -->
                        <div class="bg-slate-50 dark:bg-white/5 rounded-xl p-4">
                            <h6 class="text-xs font-bold text-slate-600 dark:text-white/60 mb-3 uppercase tracking-wider">Detail Produk</h6>
                            <div class="space-y-3">
                                @foreach($pesanan->details as $detail)
                                <div class="flex justify-between items-center text-sm">
                                    <div class="flex items-center gap-3">
                                        <span class="w-7 h-7 flex items-center justify-center text-xs font-bold bg-white dark:bg-black/30 border border-slate-200 dark:border-white/10 rounded-lg text-slate-600 dark:text-white/70">{{ $detail->jumlah }}x</span>
                                        <span class="text-slate-700 dark:text-white/80 font-medium line-clamp-1" title="{{ $detail->produk->nama_produk ?? 'Produk tidak ditemukan' }}">{{ $detail->produk->nama_produk ?? 'Produk dihapus' }}</span>
                                    </div>
                                    <span class="text-slate-600 dark:text-white/60 font-medium whitespace-nowrap">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        
                        <div class="mt-4 pt-3 border-t border-dashed border-slate-200 dark:border-white/10 flex justify-between items-center text-xs text-slate-500 dark:text-white/50">
                            <span>Metode: <strong class="text-slate-700 dark:text-white/80 font-semibold">{{ $pesanan->metode_pembayaran ?? '-' }}</strong></span>
                            <span>Cabang: <strong class="text-slate-700 dark:text-white/80 font-semibold">{{ $pesanan->cabang->nama_cabang ?? '-' }}</strong></span>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
