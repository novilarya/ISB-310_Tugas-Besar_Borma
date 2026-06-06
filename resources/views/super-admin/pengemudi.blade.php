@extends('super-admin.layouts.app')
@section('title', 'Manajemen Pengemudi | Super Admin Borma')
@section('page_title', 'Manajemen Pengemudi')

@section('content')
<div class="bg-white dark:bg-white/5 dark:backdrop-blur-xl border border-slate-200 dark:border-white/10 shadow-sm dark:shadow-none rounded-3xl p-6">
    <div class="flex justify-between items-center mb-6">
        <h4 class="text-lg font-bold text-slate-800 dark:text-white">Daftar Pengemudi / Kurir</h4>
        <button onclick="document.getElementById('modal-tambah-pengemudi').classList.remove('hidden')" class="bg-borma-purple hover:bg-purple-800 text-white px-4 py-2 rounded-xl text-sm font-bold transition-all shadow-sm">
            <i class="fa-solid fa-plus mr-2"></i> Tambah Pengemudi
        </button>
    </div>

    
    @if($errors->any())
    <div class="bg-red-100 dark:bg-red-500/20 text-red-700 dark:text-red-400 border border-red-200 dark:border-red-500/20 p-4 rounded-xl mb-6">
        <ul class="list-disc list-inside">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse sortable">
            <thead>
                <tr class="border-b border-slate-200 dark:border-white/10 text-slate-500 dark:text-white/50 text-sm">
                    <th class="pb-4 font-medium px-4 sort-header">Nama Pengemudi</th>
                    <th class="pb-4 font-medium px-4 sort-header">Cabang</th>
                    <th class="pb-4 font-medium px-4 sort-header">Kirim Hari Ini</th>
                    <th class="pb-4 font-medium px-4 sort-header">Total Ongkir</th>
                    <th class="pb-4 font-medium px-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-sm">
                
                @forelse($pengemudi as $driver)
                <!-- Baris Utama Pengemudi -->
                <tr data-detail-id="detail-{{ $driver->id_kurir }}" class="border-b border-slate-100 dark:border-white/5 hover:bg-slate-50 dark:hover:bg-white/5 transition-colors cursor-pointer sortable-row" onclick="toggleDetails({{ $driver->id_kurir }})">
                    <td class="py-4 px-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-slate-200 dark:bg-white/10 flex items-center justify-center text-slate-500 dark:text-white/50">
                                <i class="fa-solid fa-user"></i>
                            </div>
                            <span class="font-bold text-slate-800 dark:text-white">{{ $driver->user->nama ?? '-' }}</span>
                        </div>
                    </td>
                    <td class="py-4 px-4 text-slate-600 dark:text-white/80 font-medium">-</td>
                    <td class="py-4 px-4 font-bold text-borma-purple dark:text-borma-yellow">{{ $driver->penugasan->count() }} Pesanan</td>
                    <td class="py-4 px-4 text-slate-600 dark:text-white/80">Rp {{ number_format($driver->penugasan->sum('biaya_pengiriman'), 0, ',', '.') }}</td>
                    <td class="py-4 px-4 text-right">
                        <button class="text-slate-500 hover:text-borma-purple dark:text-white/50 dark:hover:text-borma-yellow transition-colors" onclick="toggleDetails({{ $driver->id_kurir }}); event.stopPropagation();">
                            <i class="fa-solid fa-chevron-down" id="icon-{{ $driver->id_kurir }}"></i>
                        </button>
                    </td>
                </tr>

                <!-- Baris Detail (Riwayat & Gaji) -->
                <tr id="detail-{{ $driver->id_kurir }}" class="hidden bg-slate-50 dark:bg-white/[0.02] border-b border-slate-200 dark:border-white/10">
                    <td colspan="5" class="p-6">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Riwayat Pengiriman -->
                            <div>
                                <h5 class="font-bold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                                    <i class="fa-solid fa-clock-rotate-left text-borma-purple dark:text-borma-yellow"></i> 3 Pesanan Terakhir
                                </h5>
                                <div class="space-y-3">
                                    @php
                                        $totalGajiHariIni = $driver->penugasan->sum('biaya_pengiriman');
                                    @endphp

                                    @forelse($driver->penugasan->take(3) as $riwayat)
                                        <div class="flex justify-between items-center bg-white dark:bg-white/5 p-3 rounded-xl border border-slate-200 dark:border-white/10 shadow-sm dark:shadow-none">
                                            <div>
                                                <p class="font-bold text-sm text-slate-800 dark:text-white">ORD-{{ str_pad($riwayat->id_pesanan, 4, '0', STR_PAD_LEFT) }} <span class="text-xs font-normal text-slate-500 dark:text-white/50 ml-2"><i class="fa-regular fa-clock"></i> {{ \Carbon\Carbon::parse($riwayat->tanggal_pemesanan)->format('d M Y H:i') }}</span></p>
                                            </div>
                                            <div class="text-right">
                                                <span class="px-2 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider {{ $riwayat->status_pesanan == 'Selesai' ? 'bg-green-100 dark:bg-green-500/20 text-green-700 dark:text-green-400' : 'bg-yellow-100 dark:bg-borma-yellow/20 text-yellow-700 dark:text-borma-yellow' }}">
                                                    {{ $riwayat->status_pesanan }}
                                                </span>
                                                <p class="font-bold text-sm text-borma-purple dark:text-borma-yellow mt-1">+Rp {{ number_format($riwayat->biaya_pengiriman, 0, ',', '.') }}</p>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="text-center py-4 text-slate-500 dark:text-white/50 text-sm italic">
                                            Belum ada pengiriman.
                                        </div>
                                    @endforelse
                                </div>
                            </div>

                            <!-- Kalkulasi Benefit -->
                            <div>
                                <h5 class="font-bold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                                    <i class="fa-solid fa-wallet text-green-500"></i> Total Benefit & Gaji
                                </h5>
                                <div class="bg-gradient-to-br from-borma-purple to-purple-900 dark:from-borma-purple/40 dark:to-transparent rounded-2xl p-5 text-white shadow-md mb-4">
                                    <p class="text-white/70 text-sm mb-1">Total Pendapatan Ongkir</p>
                                    <h3 class="text-3xl font-bold mb-4">Rp {{ number_format($totalGajiHariIni, 0, ',', '.') }}</h3>
                                    
                                </div>

                                <a href="{{ route('superadmin.pengemudi.detail', $driver->id_kurir) }}" class="block w-full text-center bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 dark:bg-white/5 dark:border-white/10 dark:hover:bg-white/10 dark:text-white px-4 py-3 rounded-xl text-sm font-bold transition-all shadow-sm">
                                    Lihat Seluruh Pengiriman
                                </a>
                            </div>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-8 text-center text-slate-500 dark:text-white/50">Belum ada data pengemudi.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Tambah Pengemudi -->
<div id="modal-tambah-pengemudi" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black/50 backdrop-blur-sm transition-opacity">
    <div class="bg-white dark:bg-slate-900 w-full max-w-lg rounded-3xl shadow-2xl border border-slate-200 dark:border-white/10 overflow-hidden transform scale-95 opacity-0 transition-all duration-300">
        <div class="p-6 border-b border-slate-200 dark:border-white/10 flex justify-between items-center bg-slate-50 dark:bg-white/5">
            <h3 class="font-bold text-lg text-slate-800 dark:text-white">Tambah Pengemudi Baru</h3>
            <button onclick="closeModal('modal-tambah-pengemudi')" class="text-slate-400 hover:text-slate-600 dark:hover:text-white transition-colors">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>
        <form action="{{ route('superadmin.pengemudi.store') }}" method="POST" class="p-6">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-white/80 mb-2">Nama Lengkap</label>
                    <input type="text" name="nama" required class="w-full bg-white dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow text-slate-800 dark:text-white" placeholder="Masukkan nama lengkap">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-white/80 mb-2">Email</label>
                    <input type="email" name="email" required class="w-full bg-white dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow text-slate-800 dark:text-white" placeholder="Masukkan alamat email">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-white/80 mb-2">Password</label>
                    <div class="relative">
                        <input type="password" name="password" id="add_password" required class="w-full bg-white dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 pr-10 text-sm focus:outline-none focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow text-slate-800 dark:text-white" placeholder="Min. 8 karakter (kombinasi huruf & angka/simbol)">
                        <button type="button" onclick="togglePasswordVisibility('add_password', 'add_password_icon')" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600">
                            <i class="fa-solid fa-eye" id="add_password_icon"></i>
                        </button>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-white/80 mb-2">Nomor Telepon</label>
                    <input type="text" name="no_telepon" required class="w-full bg-white dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow text-slate-800 dark:text-white" placeholder="Masukkan nomor telepon">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-white/80 mb-2">Cabang</label>
                    <select name="id_cabang" required class="w-full bg-white dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow text-slate-800 dark:text-white">
                        <option value="">Pilih Cabang</option>
                        @foreach($cabangs as $cabang)
                            <option value="{{ $cabang->id_cabang }}">{{ $cabang->nama_cabang }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-white/80 mb-2">Kendaraan</label>
                        <input type="text" name="kendaraan" required class="w-full bg-white dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow text-slate-800 dark:text-white" placeholder="Contoh: Honda Beat">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-white/80 mb-2">Warna Kendaraan</label>
                        <input type="text" name="warna_kendaraan" required class="w-full bg-white dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow text-slate-800 dark:text-white" placeholder="Contoh: Hitam">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-white/80 mb-2">Plat Nomor</label>
                    <input type="text" name="plat_nomor" required class="w-full bg-white dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow text-slate-800 dark:text-white" placeholder="Contoh: D 1234 ABC">
                </div>
            </div>
            <div class="mt-8 flex gap-3 justify-end">
                <button type="button" onclick="closeModal('modal-tambah-pengemudi')" class="px-5 py-2.5 rounded-xl text-sm font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 dark:text-white dark:bg-white/10 dark:hover:bg-white/20 transition-colors">Batal</button>
                <button type="submit" class="px-5 py-2.5 rounded-xl text-sm font-bold text-white bg-borma-purple hover:bg-purple-800 dark:bg-borma-yellow dark:text-slate-900 dark:hover:bg-yellow-500 transition-colors shadow-sm">Simpan</button>
            </div>
        </form>
        </form>
    </div>
</div>

<script>
    function toggleDetails(id) {
        const detailRow = document.getElementById('detail-' + id);
        const icon = document.getElementById('icon-' + id);
        
        if (detailRow.classList.contains('hidden')) {
            detailRow.classList.remove('hidden');
            icon.classList.remove('fa-chevron-down');
            icon.classList.add('fa-chevron-up');
        } else {
            detailRow.classList.add('hidden');
            icon.classList.remove('fa-chevron-up');
            icon.classList.add('fa-chevron-down');
        }
    }

    function closeModal(id) {
        const modal = document.getElementById(id);
        modal.querySelector('div').classList.remove('scale-100', 'opacity-100');
        modal.querySelector('div').classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }

    // Modal show animation listener
    document.querySelectorAll('[onclick^="document.getElementById"]').forEach(btn => {
        btn.addEventListener('click', function() {
            const match = this.getAttribute('onclick').match(/'([^']+)'/);
            if(match) {
                const modalId = match[1];
                const modal = document.getElementById(modalId);
                setTimeout(() => {
                    modal.querySelector('div').classList.remove('scale-95', 'opacity-0');
                    modal.querySelector('div').classList.add('scale-100', 'opacity-100');
                }, 10);
            }
        });
    });

    function togglePasswordVisibility(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
</script>
@endsection
