@extends('super-admin.layouts.app')
@section('title', 'Detail Member | Super Admin Borma')
@section('page_title', 'Detail Member')

@section('content')
<div class="mb-6 flex items-center gap-4">
    <a href="{{ route('superadmin.member') }}" class="w-10 h-10 rounded-xl bg-white dark:bg-white/5 border border-slate-200 dark:border-white/10 flex items-center justify-center text-slate-500 dark:text-white/50 hover:bg-slate-50 dark:hover:bg-white/10 hover:text-borma-purple dark:hover:text-borma-yellow transition-all">
        <i class="fa-solid fa-arrow-left"></i>
    </a>
    <h4 class="text-lg font-bold text-slate-800 dark:text-white">Detail Member: {{ $member->user->nama ?? '-' }}</h4>
</div>



@if($errors->any())
<div class="bg-red-100 dark:bg-red-500/20 text-red-700 dark:text-red-400 border border-red-200 dark:border-red-500/20 p-4 rounded-xl mb-6">
    <ul class="list-disc pl-5">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="grid grid-cols-1 xl:grid-cols-3 gap-6 mb-6">
    <!-- Form Update -->
    <div class="xl:col-span-1 bg-white dark:bg-white/5 dark:backdrop-blur-xl border border-slate-200 dark:border-white/10 shadow-sm dark:shadow-none rounded-3xl p-6 h-fit">
        <h5 class="font-bold text-lg text-slate-800 dark:text-white mb-6 border-b border-slate-200 dark:border-white/10 pb-4">Profil Member</h5>
        
        <div class="mb-4 bg-slate-50 dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-xl p-3 flex items-center justify-between">
            <div>
                <span class="text-xs text-slate-400 dark:text-white/40 font-semibold block">ID Member</span>
                <span class="font-mono font-bold text-slate-800 dark:text-white text-sm block mt-0.5">{{ $member->member_id ?? '-' }}</span>
            </div>
            @if($member->member_id)
            <button type="button" onclick="navigator.clipboard.writeText('{{ $member->member_id }}'); alert('ID Member berhasil disalin!');" class="text-xs text-borma-purple dark:text-borma-yellow hover:underline font-semibold flex items-center gap-1">
                <i class="fa-regular fa-copy"></i> Salin
            </button>
            @endif
        </div>
        
        <form action="{{ route('superadmin.member.update', $member->id_pelanggan) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-white/80 mb-2">Nama Lengkap</label>
                    <input type="text" value="{{ $member->user->nama ?? '' }}" disabled class="w-full bg-slate-100 dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm text-slate-500 dark:text-white/50 cursor-not-allowed">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-white/80 mb-2">Email</label>
                    <input type="email" value="{{ $member->user->email ?? '' }}" disabled class="w-full bg-slate-100 dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm text-slate-500 dark:text-white/50 cursor-not-allowed">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-white/80 mb-2">Password</label>
                    <div class="relative">
                        <input type="password" disabled class="w-full bg-slate-100 dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 pr-10 text-sm text-slate-500 dark:text-white/50 cursor-not-allowed" value="********">
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-white/80 mb-2">Nomor Telepon</label>
                    <input type="text" value="{{ $member->user->no_telepon ?? '' }}" disabled class="w-full bg-slate-100 dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm text-slate-500 dark:text-white/50 cursor-not-allowed">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-white/80 mb-2">Provinsi</label>
                    <input type="text" value="{{ $member->provinsi }}" disabled class="w-full bg-slate-100 dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm text-slate-500 dark:text-white/50 cursor-not-allowed">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-white/80 mb-2">Kota / Kabupaten</label>
                    <input type="text" value="{{ $member->kota_kabupaten }}" disabled class="w-full bg-slate-100 dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm text-slate-500 dark:text-white/50 cursor-not-allowed">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-white/80 mb-2">Kecamatan</label>
                    <input type="text" value="{{ $member->kecamatan }}" disabled class="w-full bg-slate-100 dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm text-slate-500 dark:text-white/50 cursor-not-allowed">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-white/80 mb-2">Alamat Detail</label>
                    <textarea rows="3" disabled class="w-full bg-slate-100 dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm text-slate-500 dark:text-white/50 cursor-not-allowed">{{ $member->alamat }}</textarea>
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-white/80 mb-2">Poin Member</label>
                        <input type="number" name="poin_member" value="{{ old('poin_member', $member->poin_member) }}" min="0" required class="w-full bg-slate-50 dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow text-slate-800 dark:text-white transition-all font-bold text-borma-purple dark:text-borma-yellow">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-white/80 mb-2">Status Member</label>
                        <select name="status_member_plus" required class="w-full bg-slate-50 dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow text-slate-800 dark:text-white transition-all">
                            <option value="1" {{ old('status_member_plus', $member->status_member_plus) ? 'selected' : '' }}>Member Plus</option>
                            <option value="0" {{ !old('status_member_plus', $member->status_member_plus) ? 'selected' : '' }}>Member</option>
                        </select>
                    </div>
                </div>
                
                @if($member->tanggal_berakhir_member_plus)
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-white/80 mb-2">Masa Berlaku Member Plus</label>
                    <div class="w-full bg-purple-50 dark:bg-white/5 border border-purple-100 dark:border-white/10 rounded-xl px-4 py-3 text-sm text-borma-purple dark:text-borma-yellow font-medium">
                        {{ \Carbon\Carbon::parse($member->tanggal_berakhir_member_plus)->translatedFormat('d F Y') }}
                        @if(\Carbon\Carbon::parse($member->tanggal_berakhir_member_plus)->isPast())
                            <span class="ml-2 text-xs bg-red-100 text-red-600 px-2 py-0.5 rounded-full">(Kedaluwarsa)</span>
                        @endif
                    </div>
                </div>
                @endif
            </div>
            
            <div class="mt-8 pt-6 border-t border-slate-200 dark:border-white/10">
                <button type="submit" class="w-full bg-borma-purple hover:bg-purple-800 dark:bg-borma-yellow dark:hover:bg-yellow-500 text-white dark:text-slate-900 px-4 py-3 rounded-xl text-sm font-bold transition-all shadow-md flex justify-center items-center gap-2">
                    <i class="fa-solid fa-save"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

    <!-- Riwayat Pembelian -->
    <div class="xl:col-span-2 flex flex-col gap-6">
        <div class="bg-white dark:bg-white/5 dark:backdrop-blur-xl border border-slate-200 dark:border-white/10 shadow-sm dark:shadow-none rounded-3xl p-6 flex-1">
            <h5 class="font-bold text-lg text-slate-800 dark:text-white mb-6 border-b border-slate-200 dark:border-white/10 pb-4">
                <i class="fa-solid fa-receipt text-borma-purple dark:text-borma-yellow mr-2"></i> Riwayat Pembelian
            </h5>
            
            @if($member->riwayatPesanan->isEmpty())
                <div class="flex flex-col items-center justify-center p-12 text-slate-500 dark:text-white/50 bg-slate-50 dark:bg-white/5 rounded-2xl border border-dashed border-slate-200 dark:border-white/10">
                    <div class="w-16 h-16 rounded-full bg-slate-200 dark:bg-white/10 flex items-center justify-center text-3xl mb-4">
                        <i class="fa-solid fa-box-open opacity-50"></i>
                    </div>
                    <p class="font-medium text-lg text-slate-600 dark:text-white/70">Belum Ada Transaksi</p>
                    <p class="text-sm mt-1">Member ini belum pernah melakukan pembelian.</p>
                </div>
            @else
                <div class="space-y-4">
                    @foreach($member->riwayatPesanan as $pesanan)
                    <div class="bg-white dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-2xl p-5 hover:border-borma-purple/30 dark:hover:border-borma-yellow/30 transition-all shadow-sm">
                        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-4 pb-4 border-b border-slate-100 dark:border-white/10 gap-3">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl bg-purple-50 dark:bg-white/10 flex items-center justify-center text-borma-purple dark:text-borma-yellow">
                                    <i class="fa-solid fa-shopping-bag"></i>
                                </div>
                                <div>
                                    <span class="text-sm font-bold text-slate-800 dark:text-white">ORD-{{ str_pad($pesanan->id_pesanan, 4, '0', STR_PAD_LEFT) }}</span>
                                    <p class="text-xs text-slate-500 dark:text-white/50">{{ \Carbon\Carbon::parse($pesanan->tanggal_pemesanan)->format('d M Y, H:i') }}</p>
                                </div>
                            </div>
                            <div class="flex flex-col md:items-end w-full md:w-auto">
                                <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-slate-100 dark:bg-white/10 text-slate-700 dark:text-white/80 self-start md:self-end">
                                    {{ $pesanan->status_pesanan }}
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

</script>
@endsection
