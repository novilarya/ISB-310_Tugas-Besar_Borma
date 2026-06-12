@extends('super-admin.layouts.app')
@section('title', 'Detail Pengemudi | Super Admin Borma')
@section('page_title', 'Detail Pengemudi')

@section('content')
<div class="mb-6 flex items-center gap-4">
    <a href="{{ route('superadmin.pengemudi') }}" class="w-10 h-10 rounded-xl bg-white dark:bg-white/5 border border-slate-200 dark:border-white/10 flex items-center justify-center text-slate-500 dark:text-white/50 hover:bg-slate-50 dark:hover:bg-white/10 hover:text-borma-purple dark:hover:text-borma-yellow transition-all">
        <i class="fa-solid fa-arrow-left"></i>
    </a>
    <h4 class="text-lg font-bold text-slate-800 dark:text-white">Detail Pengemudi: {{ $kurir->user->nama ?? '-' }}</h4>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    <!-- Profil Pengemudi -->
    <div class="lg:col-span-1 bg-white dark:bg-white/5 dark:backdrop-blur-xl border border-slate-200 dark:border-white/10 shadow-sm dark:shadow-none rounded-3xl p-6">
        <div class="flex flex-col items-center text-center mb-6">
            <div class="w-24 h-24 rounded-full bg-slate-200 dark:bg-white/10 flex items-center justify-center text-slate-500 dark:text-white/50 text-3xl mb-4">
                <i class="fa-solid fa-user"></i>
            </div>
            <h5 class="font-bold text-xl text-slate-800 dark:text-white">{{ $kurir->user->nama ?? '-' }}</h5>
            <span class="text-sm text-slate-500 dark:text-white/50 mt-1">Pengemudi / Kurir</span>
        </div>

        <div class="space-y-4">
            <div class="flex flex-col">
                <span class="text-xs text-slate-500 dark:text-white/50 uppercase tracking-wider font-semibold mb-1">Email</span>
                <span class="text-sm font-medium text-slate-800 dark:text-white">{{ $kurir->user->email ?? '-' }}</span>
            </div>
            <div class="flex flex-col">
                <span class="text-xs text-slate-500 dark:text-white/50 uppercase tracking-wider font-semibold mb-1">No. Telepon</span>
                <span class="text-sm font-medium text-slate-800 dark:text-white">{{ $kurir->user->no_telepon ?? '-' }}</span>
            </div>
            <div class="flex flex-col">
                <span class="text-xs text-slate-500 dark:text-white/50 uppercase tracking-wider font-semibold mb-1">Kendaraan</span>
                <span class="text-sm font-medium text-slate-800 dark:text-white">{{ $kurir->kendaraan ?? '-' }} ({{ $kurir->warna_kendaraan ?? '-' }})</span>
            </div>
            <div class="flex flex-col">
                <span class="text-xs text-slate-500 dark:text-white/50 uppercase tracking-wider font-semibold mb-1">Plat Nomor</span>
                <span class="text-sm font-medium text-slate-800 dark:text-white">{{ $kurir->plat_nomor ?? '-' }}</span>
            </div>
        </div>

        <div class="mt-8 pt-6 border-t border-slate-200 dark:border-white/10 flex items-center justify-between gap-3">
            <button onclick="openEditModal('{{ $kurir->id_kurir }}', '{{ addslashes($kurir->user->nama ?? '') }}', '{{ addslashes($kurir->user->email ?? '') }}', '{{ addslashes($kurir->user->no_telepon ?? '') }}', '{{ $kurir->id_cabang }}', '{{ addslashes($kurir->kendaraan ?? '') }}', '{{ addslashes($kurir->warna_kendaraan ?? '') }}', '{{ addslashes($kurir->plat_nomor ?? '') }}')" class="w-full bg-slate-100 hover:bg-slate-200 text-borma-purple dark:bg-white/5 dark:hover:bg-white/10 dark:text-borma-yellow px-4 py-2.5 rounded-xl text-sm font-bold transition-all flex justify-center items-center gap-2">
                <i class="fa-solid fa-pen-to-square"></i> Kelola
            </button>
            <button onclick="openDeleteModal('{{ $kurir->id_kurir }}')" class="w-full bg-red-50 hover:bg-red-100 text-red-600 dark:bg-red-500/10 dark:hover:bg-red-500/20 dark:text-red-400 px-4 py-2.5 rounded-xl text-sm font-bold transition-all flex justify-center items-center gap-2">
                <i class="fa-solid fa-trash"></i> Hapus
            </button>
        </div>
    </div>

    <!-- Statistik -->
    <div class="lg:col-span-2 flex flex-col gap-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-gradient-to-br from-borma-purple to-purple-900 dark:from-borma-purple/40 dark:to-transparent border border-transparent dark:border-white/10 rounded-3xl p-6 text-white shadow-md">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 rounded-2xl bg-white/20 flex items-center justify-center text-xl">
                        <i class="fa-solid fa-box"></i>
                    </div>
                    <div>
                        <p class="text-white/70 text-sm font-medium">Total Pesanan Dikirim</p>
                        <h4 class="text-2xl font-bold">{{ $kurir->penugasan->count() }}</h4>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-green-500 to-green-700 dark:from-green-500/40 dark:to-transparent border border-transparent dark:border-white/10 rounded-3xl p-6 text-white shadow-md">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 rounded-2xl bg-white/20 flex items-center justify-center text-xl">
                        <i class="fa-solid fa-wallet"></i>
                    </div>
                    <div>
                        <p class="text-white/70 text-sm font-medium">Total Ongkir Didapat</p>
                        <h4 class="text-2xl font-bold">Rp {{ number_format($kurir->penugasan->sum('biaya_pengiriman'), 0, ',', '.') }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Riwayat Pengiriman -->
        <div class="bg-white dark:bg-white/5 dark:backdrop-blur-xl border border-slate-200 dark:border-white/10 shadow-sm dark:shadow-none rounded-3xl p-6 flex-1">
            <h5 class="font-bold text-lg text-slate-800 dark:text-white mb-4">Seluruh Riwayat Pengiriman</h5>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse sortable">
                    <thead>
                        <tr class="border-b border-slate-200 dark:border-white/10 text-slate-500 dark:text-white/50 text-sm">
                            <th class="pb-4 font-medium px-4 sort-header">ID Pesanan</th>
                            <th class="pb-4 font-medium px-4 sort-header">Waktu</th>
                            <th class="pb-4 font-medium px-4 sort-header">Status</th>
                            <th class="pb-4 font-medium px-4 text-right sort-header">Ongkir</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        @forelse($kurir->penugasan as $riwayat)
                        <tr class="border-b border-slate-100 dark:border-white/5 hover:bg-slate-50 dark:hover:bg-white/5 transition-colors">
                            <td class="py-4 px-4 font-bold text-slate-800 dark:text-white">
                                ORD-{{ str_pad($riwayat->id_pesanan, 4, '0', STR_PAD_LEFT) }}
                            </td>
                            <td class="py-4 px-4 text-slate-600 dark:text-white/80">
                                {{ \Carbon\Carbon::parse($riwayat->tanggal_pemesanan)->format('d M Y H:i') }}
                            </td>
                            <td class="py-4 px-4">
                                <span class="px-2 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider {{ $riwayat->status_pesanan == 'Selesai' ? 'bg-green-100 dark:bg-green-500/20 text-green-700 dark:text-green-400' : 'bg-yellow-100 dark:bg-borma-yellow/20 text-yellow-700 dark:text-borma-yellow' }}">
                                    {{ $riwayat->status_pesanan }}
                                </span>
                            </td>
                            <td class="py-4 px-4 text-right font-bold text-borma-purple dark:text-borma-yellow">
                                Rp {{ number_format($riwayat->biaya_pengiriman, 0, ',', '.') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="py-8 text-center text-slate-500 dark:text-white/50">Belum ada riwayat pengiriman.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Pengemudi -->
<div id="modal-edit-pengemudi" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black/50 backdrop-blur-sm transition-opacity">
    <div class="bg-white dark:bg-slate-900 w-full max-w-lg rounded-3xl shadow-2xl border border-slate-200 dark:border-white/10 overflow-hidden transform scale-95 opacity-0 transition-all duration-300">
        <div class="p-6 border-b border-slate-200 dark:border-white/10 flex justify-between items-center bg-slate-50 dark:bg-white/5">
            <h3 class="font-bold text-lg text-slate-800 dark:text-white">Kelola Pengemudi</h3>
            <button onclick="closeModal('modal-edit-pengemudi')" class="text-slate-400 hover:text-slate-600 dark:hover:text-white transition-colors">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>
        <form id="form-edit-pengemudi" method="POST" class="p-6">
            @csrf
            @method('PUT')
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-white/80 mb-2">Nama Lengkap</label>
                    <input type="text" name="nama" id="edit_nama" required class="w-full bg-white dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow text-slate-800 dark:text-white">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-white/80 mb-2">Email</label>
                    <input type="email" name="email" id="edit_email" required class="w-full bg-white dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow text-slate-800 dark:text-white">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-white/80 mb-2">Password (Kosongkan jika tidak diubah)</label>
                    <div class="relative">
                        <input type="password" name="password" id="edit_password" class="w-full bg-white dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 pr-10 text-sm focus:outline-none focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow text-slate-800 dark:text-white" placeholder="Min. 8 karakter (kombinasi huruf & angka/simbol)">
                        <button type="button" onclick="togglePasswordVisibility('edit_password', 'edit_password_icon')" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600">
                            <i class="fa-solid fa-eye" id="edit_password_icon"></i>
                        </button>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-white/80 mb-2">Nomor Telepon</label>
                    <input type="text" name="no_telepon" id="edit_no_telepon" required class="w-full bg-white dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow text-slate-800 dark:text-white">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-white/80 mb-2">Cabang</label>
                    <select name="id_cabang" id="edit_id_cabang" required class="w-full bg-white dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow text-slate-800 dark:text-white">
                        <option value="">Pilih Cabang</option>
                        @foreach($cabangs as $cabang)
                            <option value="{{ $cabang->id_cabang }}">{{ $cabang->nama_cabang }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-white/80 mb-2">Kendaraan</label>
                        <input type="text" name="kendaraan" id="edit_kendaraan" required class="w-full bg-white dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow text-slate-800 dark:text-white">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-white/80 mb-2">Warna Kendaraan</label>
                        <input type="text" name="warna_kendaraan" id="edit_warna_kendaraan" required class="w-full bg-white dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow text-slate-800 dark:text-white">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-white/80 mb-2">Plat Nomor</label>
                    <input type="text" name="plat_nomor" id="edit_plat_nomor" required class="w-full bg-white dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow text-slate-800 dark:text-white">
                </div>
            </div>
            <div class="mt-8 flex gap-3 justify-end">
                <button type="button" onclick="closeModal('modal-edit-pengemudi')" class="px-5 py-2.5 rounded-xl text-sm font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 dark:text-white dark:bg-white/10 dark:hover:bg-white/20 transition-colors">Batal</button>
                <button type="submit" class="px-5 py-2.5 rounded-xl text-sm font-bold text-white bg-borma-purple hover:bg-purple-800 dark:bg-borma-yellow dark:text-slate-900 dark:hover:bg-yellow-500 transition-colors shadow-sm">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Konfirmasi Hapus -->
<div id="modal-delete-pengemudi" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black/50 backdrop-blur-sm transition-opacity">
    <div class="bg-white dark:bg-slate-900 w-full max-w-md rounded-3xl shadow-2xl border border-slate-200 dark:border-white/10 overflow-hidden transform scale-95 opacity-0 transition-all duration-300">
        <div class="p-6 border-b border-slate-200 dark:border-white/10 flex justify-between items-center bg-slate-50 dark:bg-white/5">
            <h3 class="font-bold text-lg text-red-600 dark:text-red-400">Konfirmasi Hapus</h3>
            <button onclick="closeModal('modal-delete-pengemudi')" class="text-slate-400 hover:text-slate-600 dark:hover:text-white transition-colors">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>
        <div class="p-6 text-center">
            <div class="w-16 h-16 rounded-full bg-red-100 dark:bg-red-500/20 text-red-600 dark:text-red-400 flex items-center justify-center text-2xl mx-auto mb-4">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
            <p class="text-slate-600 dark:text-white/80 mb-6">Apakah Anda yakin ingin menghapus data pengemudi ini? Aksi ini tidak dapat dibatalkan.</p>
            <form id="form-delete-pengemudi" method="POST" class="flex gap-3 justify-center">
                @csrf
                @method('DELETE')
                <button type="button" onclick="closeModal('modal-delete-pengemudi')" class="px-5 py-2.5 rounded-xl text-sm font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 dark:text-white dark:bg-white/10 dark:hover:bg-white/20 transition-colors">Batal</button>
                <button type="submit" class="px-5 py-2.5 rounded-xl text-sm font-bold text-white bg-red-500 hover:bg-red-600 transition-colors shadow-sm">Ya, Hapus</button>
            </form>
        </div>
    </div>
</div>

<script>
    function closeModal(id) {
        const modal = document.getElementById(id);
        modal.querySelector('div').classList.remove('scale-100', 'opacity-100');
        modal.querySelector('div').classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }

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

    function openEditModal(id, nama, email, telepon, id_cabang, kendaraan, warna, plat) {
        document.getElementById('edit_nama').value = nama;
        document.getElementById('edit_email').value = email;
        document.getElementById('edit_password').value = '';
        document.getElementById('edit_no_telepon').value = telepon;
        document.getElementById('edit_id_cabang').value = id_cabang;
        document.getElementById('edit_kendaraan').value = kendaraan;
        document.getElementById('edit_warna_kendaraan').value = warna;
        document.getElementById('edit_plat_nomor').value = plat;

        document.getElementById('form-edit-pengemudi').action = `/superadmin/pengemudi/${id}`;

        const modal = document.getElementById('modal-edit-pengemudi');
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.querySelector('div').classList.remove('scale-95', 'opacity-0');
            modal.querySelector('div').classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    function openDeleteModal(id) {
        document.getElementById('form-delete-pengemudi').action = `/superadmin/pengemudi/${id}`;
        
        const modal = document.getElementById('modal-delete-pengemudi');
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.querySelector('div').classList.remove('scale-95', 'opacity-0');
            modal.querySelector('div').classList.add('scale-100', 'opacity-100');
        }, 10);
    }
</script>
@endsection
