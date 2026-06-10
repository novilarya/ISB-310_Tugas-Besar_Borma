@extends('layouts.pelanggan')

@section('title', 'Aktivasi Member Digital')

@section('content')
<div class="pb-10">

    {{-- Success Alert --}}
    @if(session('success'))
    <div id="success-alert" class="mb-8 bg-green-50 border border-green-200 rounded-2xl p-5 flex items-start gap-4 animate-fade-in-up">
        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center shrink-0">
            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        </div>
        <div>
            <p class="font-bold text-green-800 text-sm">{{ session('success') }}</p>
            <p class="text-green-600 text-xs mt-1">Kartu member digital Anda sudah aktif dan siap digunakan.</p>
        </div>
    </div>
    @endif

    {{-- Error Alert --}}
    @if($errors->any())
    <div class="mb-8 bg-tertiary-50 border border-tertiary-200 rounded-2xl p-5">
        <p class="font-bold text-tertiary-500 text-sm mb-2">Terjadi kesalahan:</p>
        <ul class="list-disc list-inside text-xs text-tertiary-400 space-y-1">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- Already a member --}}
    @if($pelanggan && $pelanggan->status_member_plus)
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">
        {{-- Left: Member Info --}}
        <div class="lg:col-span-2 bg-primary-700 rounded-3xl p-8 sm:p-10 relative overflow-hidden text-white">
            <div class="absolute inset-0 bg-gradient-to-br from-primary-700 via-primary-700 to-primary-600"></div>
            <div class="absolute top-0 right-0 -mr-16 -mt-16 w-80 h-80 rounded-full bg-white/5 blur-3xl pointer-events-none"></div>
            <div class="absolute bottom-0 left-0 -ml-10 -mb-10 w-60 h-60 rounded-full bg-secondary-400/10 blur-2xl pointer-events-none"></div>
            <div class="relative z-10">
                <div class="inline-flex px-3 py-1 bg-green-500 text-white text-[10px] font-bold rounded-full mb-6 uppercase tracking-wide">Member Aktif</div>
                <h2 class="font-heading font-extrabold text-3xl sm:text-4xl mb-3 leading-tight uppercase tracking-tight">MEMBER<br><span class="text-secondary-400">DIGITAL</span></h2>
                <p class="text-primary-100 text-sm mb-8 leading-relaxed max-w-sm">Selamat! Anda sudah terdaftar sebagai member Borma Toserba. Nikmati berbagai keuntungan member.</p>

                {{-- Benefits --}}
                <div class="space-y-5 mb-8">
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 bg-secondary-400/20 rounded-xl flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                        </div>
                        <div>
                            <p class="font-bold text-sm text-white">Poin Reward</p>
                            <p class="text-xs text-primary-200 mt-0.5">Total poin Anda: <span class="text-secondary-400 font-bold">{{ $pelanggan->poin_member ?? 0 }}</span></p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 bg-secondary-400/20 rounded-xl flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                        </div>
                        <div>
                            <p class="font-bold text-sm text-white">Harga Spesial</p>
                            <p class="text-xs text-primary-200 mt-0.5">Akses harga eksklusif khusus member.</p>
                        </div>
                    </div>
                </div>

                {{-- Member Card --}}
                <div class="bg-neutral-900 rounded-2xl p-5 relative overflow-hidden shadow-xl">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-primary-700/30 rounded-full -mr-10 -mt-10 blur-xl"></div>
                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-4">
                            <p class="font-heading font-extrabold text-sm text-white tracking-wider">MEMBER BORMA</p>
                            <div class="flex gap-1"><div class="w-4 h-4 bg-secondary-400 rounded-full opacity-80"></div><div class="w-4 h-4 bg-secondary-400 rounded-full opacity-40 -ml-2"></div></div>
                        </div>
                        <div class="bg-white/10 rounded-lg px-4 py-2 mb-4 inline-flex items-center gap-2">
                            <div class="flex gap-0.5">@for($i=0;$i<8;$i++)<div class="w-1 bg-white rounded-full" style="height:{{ rand(12,24) }}px"></div>@endfor</div>
                        </div>
                        <div class="flex items-end justify-between">
                            <div>
                                <p class="text-[10px] text-neutral-400 uppercase tracking-wider mb-1">Nama Pemegang</p>
                                <p class="font-bold text-sm text-white uppercase">{{ $user->nama ?? 'MEMBER' }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-[10px] text-neutral-400 uppercase tracking-wider">ID</p>
                                <p class="text-xs text-neutral-300 font-mono">{{ str_pad($pelanggan->id_pelanggan ?? 0, 12, '0', STR_PAD_LEFT) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right: Member Details --}}
        <div class="lg:col-span-3">
            <div class="bg-white rounded-3xl border border-neutral-200 shadow-sm p-8 sm:p-10">
                <p class="text-[11px] font-bold text-primary-500 uppercase tracking-widest mb-2">Informasi Member</p>
                <h3 class="font-heading font-extrabold text-2xl text-neutral-800 mb-8">DATA KEANGGOTAAN</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div><p class="text-[11px] font-bold text-neutral-400 uppercase tracking-wider mb-1">Nama Lengkap</p><p class="font-semibold text-sm text-neutral-800">{{ $user->nama }}</p></div>
                    <div><p class="text-[11px] font-bold text-neutral-400 uppercase tracking-wider mb-1">No. WhatsApp</p><p class="font-semibold text-sm text-neutral-800">{{ $user->no_telepon }}</p></div>
                    <div><p class="text-[11px] font-bold text-neutral-400 uppercase tracking-wider mb-1">Email</p><p class="font-semibold text-sm text-neutral-800">{{ $user->email }}</p></div>
                    <div><p class="text-[11px] font-bold text-neutral-400 uppercase tracking-wider mb-1">Status</p><p class="inline-flex items-center gap-1.5 text-sm font-bold text-green-600"><span class="w-2 h-2 bg-green-500 rounded-full"></span>Aktif</p></div>
                    <div class="sm:col-span-2"><p class="text-[11px] font-bold text-neutral-400 uppercase tracking-wider mb-1">Alamat</p><p class="font-semibold text-sm text-neutral-800">{{ $pelanggan->alamat ?? '-' }}, Kec. {{ $pelanggan->kecamatan ?? '-' }}, {{ $pelanggan->kota_kabupaten ?? '-' }}, {{ $pelanggan->provinsi ?? '-' }}</p></div>
                </div>
                <div class="mt-8 pt-6 border-t border-neutral-100">
                    <div class="flex items-center gap-3 p-4 bg-primary-50 rounded-xl">
                        <div class="w-10 h-10 bg-primary-100 rounded-full flex items-center justify-center"><svg class="w-5 h-5 text-primary-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
                        <p class="text-xs text-primary-700">Member sejak <span class="font-bold">{{ $pelanggan->created_at->format('d M Y') }}</span>. Gunakan kartu member digital Anda saat berbelanja di seluruh cabang Borma.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @else
    {{-- Not a member yet: Registration Form --}}
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">
        {{-- Left Hero --}}
        <div class="lg:col-span-2 bg-primary-700 rounded-3xl p-8 sm:p-10 relative overflow-hidden text-white">
            <div class="absolute inset-0 bg-gradient-to-br from-primary-700 via-primary-700 to-primary-600"></div>
            <div class="absolute top-0 right-0 -mr-16 -mt-16 w-80 h-80 rounded-full bg-white/5 blur-3xl pointer-events-none"></div>
            <div class="absolute bottom-0 left-0 -ml-10 -mb-10 w-60 h-60 rounded-full bg-secondary-400/10 blur-2xl pointer-events-none"></div>
            <div class="relative z-10">
                <h2 class="font-heading font-extrabold text-3xl sm:text-4xl mb-3 leading-tight uppercase tracking-tight">AKTIVASI<br><span class="text-secondary-400">MEMBER DIGITAL</span></h2>
                <p class="text-primary-100 text-sm mb-8 leading-relaxed max-w-sm">Nikmati kemudahan berbelanja dengan identitas digital. Kumpulkan poin di setiap transaksi dan dapatkan harga khusus member di seluruh cabang Borma Toserba.</p>

                {{-- Benefits --}}
                <div class="space-y-5 mb-8">
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 bg-secondary-400/20 rounded-xl flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                        </div>
                        <div><p class="font-bold text-sm text-white">Poin Reward</p><p class="text-xs text-primary-200 mt-0.5">Kumpulkan poin untuk setiap pembelanjaan minimal Rp 10.000.</p></div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 bg-secondary-400/20 rounded-xl flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                        </div>
                        <div><p class="font-bold text-sm text-white">Harga Spesial</p><p class="text-xs text-primary-200 mt-0.5">Akses langsung ke harga promosi eksklusif hanya untuk member.</p></div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 bg-secondary-400/20 rounded-xl flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div><p class="font-bold text-sm text-white">Riwayat Digital</p><p class="text-xs text-primary-200 mt-0.5">Pantau struk dan total belanja Anda secara real-time.</p></div>
                    </div>
                </div>

                {{-- Preview Card --}}
                <div class="bg-neutral-900 rounded-2xl p-5 relative overflow-hidden shadow-xl">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-primary-700/30 rounded-full -mr-10 -mt-10 blur-xl"></div>
                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-4">
                            <p class="font-heading font-extrabold text-sm text-white tracking-wider">MEMBER BORMA</p>
                            <div class="flex gap-1"><div class="w-4 h-4 bg-secondary-400 rounded-full opacity-80"></div><div class="w-4 h-4 bg-secondary-400 rounded-full opacity-40 -ml-2"></div></div>
                        </div>
                        <div class="bg-white/10 rounded-lg px-4 py-2 mb-4 inline-flex items-center gap-2">
                            <div class="flex gap-0.5">@for($i=0;$i<8;$i++)<div class="w-1 bg-white rounded-full" style="height:{{ rand(12,24) }}px"></div>@endfor</div>
                        </div>
                        <div class="flex items-end justify-between">
                            <div><p class="text-[10px] text-neutral-400 uppercase tracking-wider mb-1">Nama Pemegang</p><p class="font-bold text-sm text-white uppercase" id="card-name">[NAMA LENGKAP ANDA]</p></div>
                            <div class="text-right"><p class="text-[10px] text-neutral-400 uppercase">ID</p><p class="text-xs text-neutral-300 font-mono">0000 0000 0000</p></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Form --}}
        <div class="lg:col-span-3">
            <div class="bg-white rounded-3xl border border-neutral-200 shadow-sm p-8 sm:p-10">
                <p class="text-[11px] font-bold text-primary-500 uppercase tracking-widest mb-2">Langkah 01</p>
                <h3 class="font-heading font-extrabold text-2xl text-neutral-800 mb-8">DATA DIRI ANDA</h3>

                @auth
                <form method="POST" action="{{ route('pelanggan.member.activate') }}" id="member-form">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-[11px] font-bold text-neutral-400 uppercase tracking-wider mb-2">Nama Lengkap Sesuai KTP</label>
                            <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $user->nama) }}" placeholder="Contoh: Budi Santoso" required class="w-full px-4 py-3 bg-neutral-50 border border-neutral-200 rounded-xl text-sm text-neutral-800 placeholder-neutral-400 focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-all outline-none" id="input-nama">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-neutral-400 uppercase tracking-wider mb-2">Nomor WhatsApp Aktif</label>
                            <input type="text" name="no_whatsapp" value="{{ old('no_whatsapp', $user->no_telepon) }}" placeholder="0812 XXXX XXXX" required class="w-full px-4 py-3 bg-neutral-50 border border-neutral-200 rounded-xl text-sm text-neutral-800 placeholder-neutral-400 focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-all outline-none">
                        </div>
                    </div>
                    <div class="mb-6">
                        <label class="block text-[11px] font-bold text-neutral-400 uppercase tracking-wider mb-2">Alamat Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" placeholder="alamat@email.com" required class="w-full px-4 py-3 bg-neutral-50 border border-neutral-200 rounded-xl text-sm text-neutral-800 placeholder-neutral-400 focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-all outline-none">
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-[11px] font-bold text-neutral-400 uppercase tracking-wider mb-2">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required class="w-full px-4 py-3 bg-neutral-50 border border-neutral-200 rounded-xl text-sm text-neutral-800 focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-all outline-none">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-neutral-400 uppercase tracking-wider mb-2">Jenis Kelamin</label>
                            <select name="jenis_kelamin" required class="w-full px-4 py-3 bg-neutral-50 border border-neutral-200 rounded-xl text-sm text-neutral-800 focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-all outline-none appearance-none">
                                <option value="" disabled {{ old('jenis_kelamin') ? '' : 'selected' }}>Pilih</option>
                                <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-[11px] font-bold text-neutral-400 uppercase tracking-wider mb-2">Provinsi</label>
                            <input type="text" name="provinsi" value="{{ old('provinsi', $pelanggan->provinsi ?? '') }}" placeholder="Contoh: Jawa Barat" required class="w-full px-4 py-3 bg-neutral-50 border border-neutral-200 rounded-xl text-sm text-neutral-800 placeholder-neutral-400 focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-all outline-none">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-neutral-400 uppercase tracking-wider mb-2">Kota / Kabupaten</label>
                            <input type="text" name="kota_kabupaten" value="{{ old('kota_kabupaten', $pelanggan->kota_kabupaten ?? '') }}" placeholder="Contoh: Kota Bandung" required class="w-full px-4 py-3 bg-neutral-50 border border-neutral-200 rounded-xl text-sm text-neutral-800 placeholder-neutral-400 focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-all outline-none">
                        </div>
                    </div>
                    <div class="mb-6">
                        <label class="block text-[11px] font-bold text-neutral-400 uppercase tracking-wider mb-2">Kecamatan</label>
                        <input type="text" name="kecamatan" value="{{ old('kecamatan', $pelanggan->kecamatan ?? '') }}" placeholder="Contoh: Coblong" required class="w-full px-4 py-3 bg-neutral-50 border border-neutral-200 rounded-xl text-sm text-neutral-800 placeholder-neutral-400 focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-all outline-none">
                    </div>
                    <div class="mb-8">
                        <label class="block text-[11px] font-bold text-neutral-400 uppercase tracking-wider mb-2">Detail Alamat</label>
                        <textarea name="alamat" rows="3" placeholder="Contoh: Perumahan Cemara Jl. Merdeka No.10 RT/RW 001/005" required class="w-full px-4 py-3 bg-neutral-50 border border-neutral-200 rounded-xl text-sm text-neutral-800 placeholder-neutral-400 focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-all outline-none resize-none">{{ old('alamat', $pelanggan->alamat ?? '') }}</textarea>
                    </div>

                    {{-- Checkboxes --}}
                    <div class="space-y-4 mb-8">
                        <label class="flex items-start gap-3 cursor-pointer group">
                            <input type="checkbox" name="agree_terms" value="1" required class="mt-0.5 w-5 h-5 rounded border-neutral-300 text-primary-700 focus:ring-primary-500">
                            <span class="text-xs text-neutral-600 leading-relaxed">Saya setuju dengan <a href="#" class="font-bold text-primary-600 underline hover:text-primary-800">Syarat & Ketentuan</a> keanggotaan Borma Toserba dan memberikan izin pengolahan data untuk keperluan layanan pelanggan.</span>
                        </label>
                        <label class="flex items-start gap-3 cursor-pointer group">
                            <input type="checkbox" name="agree_promo" value="1" class="mt-0.5 w-5 h-5 rounded border-neutral-300 text-primary-700 focus:ring-primary-500">
                            <span class="text-xs text-neutral-600 leading-relaxed">Kirimkan info promo dan diskon khusus melalui WhatsApp atau Email.</span>
                        </label>
                    </div>

                    <button type="submit" class="w-full bg-neutral-900 text-white font-bold text-sm py-4 px-6 rounded-xl hover:bg-primary-700 transition-all duration-300 flex items-center justify-between group shadow-md hover:shadow-lg">
                        <span class="uppercase tracking-wider">Aktifkan Membership</span>
                        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </button>
                </form>
                <p class="text-center text-[11px] text-neutral-400 mt-4 uppercase tracking-wider">Proses aktivasi memerlukan waktu kurang dari 1 menit.</p>
                @else
                {{-- Not logged in --}}
                <div class="text-center py-12">
                    <div class="w-16 h-16 bg-primary-50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    </div>
                    <h4 class="font-heading font-bold text-lg text-neutral-800 mb-2">Login Diperlukan</h4>
                    <p class="text-sm text-neutral-500 mb-6 max-w-sm mx-auto">Silakan masuk ke akun Anda terlebih dahulu untuk mengaktifkan membership digital Borma.</p>
                    <div class="flex items-center justify-center gap-3">
                        <a href="{{ route('login') }}" class="bg-primary-700 text-white font-bold text-sm px-6 py-3 rounded-xl hover:bg-primary-600 transition-colors shadow-sm">Masuk</a>
                        <a href="{{ route('register') }}" class="bg-neutral-100 text-neutral-700 font-bold text-sm px-6 py-3 rounded-xl hover:bg-neutral-200 transition-colors">Daftar</a>
                    </div>
                </div>
                @endauth
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const nameInput = document.getElementById('input-nama');
    const cardName = document.getElementById('card-name');
    if (nameInput && cardName) {
        nameInput.addEventListener('input', function() {
            cardName.textContent = this.value ? this.value.toUpperCase() : '[NAMA LENGKAP ANDA]';
        });
        if (nameInput.value) cardName.textContent = nameInput.value.toUpperCase();
    }
});
</script>
@endpush
