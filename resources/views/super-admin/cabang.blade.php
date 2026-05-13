@extends('super-admin.layouts.app')
@section('title', 'Manajemen Cabang | Super Admin Borma')
@section('page_title', 'Manajemen Cabang')

@section('content')
<div class="grid grid-cols-1 gap-6">
    <!-- Ringkasan Cabang -->
    <div class="bg-white dark:bg-white/5 dark:backdrop-blur-xl border border-slate-200 dark:border-white/10 shadow-sm dark:shadow-none rounded-3xl p-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
            <h4 class="text-lg font-bold text-slate-800 dark:text-white">Performa Semua Cabang</h4>
            
            <div class="flex flex-col md:flex-row items-center gap-3 w-full md:w-auto">
                <!-- Filter Form -->
                <form class="flex items-center gap-2 w-full md:w-auto">
                    <div class="flex items-center gap-2 bg-slate-50 dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-xl px-3 py-2 flex-1 md:flex-none">
                        <i class="fa-regular fa-calendar text-slate-400 dark:text-white/40"></i>
                        <input type="date" name="start_date" class="bg-transparent border-none focus:ring-0 text-sm text-slate-600 dark:text-white/70 w-full" value="{{ request('start_date', \Carbon\Carbon::now()->startOfMonth()->format('Y-m-d')) }}">
                        <span class="text-slate-400 dark:text-white/40 text-sm">-</span>
                        <input type="date" name="end_date" class="bg-transparent border-none focus:ring-0 text-sm text-slate-600 dark:text-white/70 w-full" value="{{ request('end_date', \Carbon\Carbon::now()->format('Y-m-d')) }}">
                    </div>
                    <div class="flex items-center gap-2 bg-slate-50 dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-xl px-3 py-2">
                        <i class="fa-solid fa-arrow-down-a-z text-slate-400 dark:text-white/40"></i>
                        <select name="sort" class="bg-transparent border-none focus:ring-0 text-sm text-slate-600 dark:text-white/70 w-full appearance-none cursor-pointer p-0">
                            <option value="nama_asc" {{ request('sort') == 'nama_asc' ? 'selected' : '' }}>Nama Cabang (A-Z)</option>
                            <option value="nama_desc" {{ request('sort') == 'nama_desc' ? 'selected' : '' }}>Nama Cabang (Z-A)</option>
                            <option value="pendapatan_desc" {{ request('sort') == 'pendapatan_desc' ? 'selected' : '' }}>Pendapatan Terbesar</option>
                            <option value="pendapatan_asc" {{ request('sort') == 'pendapatan_asc' ? 'selected' : '' }}>Pendapatan Terkecil</option>
                            <option value="pesanan_desc" {{ request('sort') == 'pesanan_desc' ? 'selected' : '' }}>Pesanan Terbanyak</option>
                            <option value="pesanan_asc" {{ request('sort') == 'pesanan_asc' ? 'selected' : '' }}>Pesanan Sedikit</option>
                            <option value="status_asc" {{ request('sort') == 'status_asc' ? 'selected' : '' }}>Status</option>
                        </select>
                    </div>
                    <button type="submit" class="bg-white dark:bg-white/10 border border-slate-200 dark:border-white/10 hover:bg-slate-50 dark:hover:bg-white/20 text-slate-700 dark:text-white font-bold py-2 px-4 rounded-xl transition-all shadow-sm">
                        Filter
                    </button>
                </form>

                <button onclick="openModal('addCabangModal')" class="bg-borma-purple dark:bg-borma-yellow hover:bg-opacity-90 text-white dark:text-borma-purple font-bold py-2 px-4 rounded-xl transition-all shadow-md flex items-center justify-center gap-2 w-full md:w-auto">
                    <i class="fa-solid fa-plus"></i> Tambah Cabang
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div class="bg-slate-50 dark:bg-white/5 p-4 rounded-2xl border border-slate-100 dark:border-white/5">
                <p class="text-sm text-slate-500 dark:text-white/50 mb-1">Total Cabang Aktif</p>
                <h3 class="text-2xl font-bold text-slate-800 dark:text-white">{{ $cabang->where('status', 'Aktif')->count() }}</h3>
            </div>
            <div class="bg-slate-50 dark:bg-white/5 p-4 rounded-2xl border border-slate-100 dark:border-white/5">
                <p class="text-sm text-slate-500 dark:text-white/50 mb-1">Total Pendapatan (Bulan Ini)</p>
                <h3 class="text-2xl font-bold text-green-600 dark:text-green-400">Rp {{ number_format($cabang->sum('pendapatan'), 0, ',', '.') }}</h3>
            </div>
            <div class="bg-slate-50 dark:bg-white/5 p-4 rounded-2xl border border-slate-100 dark:border-white/5">
                <p class="text-sm text-slate-500 dark:text-white/50 mb-1">Total Pesanan</p>
                <h3 class="text-2xl font-bold text-borma-purple dark:text-borma-yellow">{{ number_format($cabang->sum('total_pesanan'), 0, ',', '.') }}</h3>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-200 dark:border-white/10 text-slate-500 dark:text-white/50 text-sm">
                        <th class="pb-4 font-medium px-4">Nama Cabang</th>
                        <th class="pb-4 font-medium px-4">Pendapatan</th>
                        <th class="pb-4 font-medium px-4">Total Pesanan</th>
                        <th class="pb-4 font-medium px-4">Produk Terlaris</th>
                        <th class="pb-4 font-medium px-4">Status</th>
                        <th class="pb-4 font-medium px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse($cabang as $item)
                    <tr class="border-b border-slate-100 dark:border-white/5 hover:bg-slate-50 dark:hover:bg-white/5 transition-colors">
                        <td class="py-4 px-4">
                            <div class="font-bold text-slate-800 dark:text-white">{{ $item->nama_cabang }}</div>
                        </td>
                        <td class="py-4 px-4 font-bold text-green-600 dark:text-green-400">Rp {{ number_format($item->pendapatan, 0, ',', '.') }}</td>
                        <td class="py-4 px-4 font-bold text-borma-purple dark:text-borma-yellow">{{ number_format($item->total_pesanan, 0, ',', '.') }}</td>
                        <td class="py-4 px-4 text-slate-600 dark:text-white/80 text-xs">{{ $item->produk_terlaris }}</td>
                        <td class="py-4 px-4">
                            <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider border {{ $item->status == 'Aktif' ? 'bg-green-100 dark:bg-green-500/20 text-green-700 dark:text-green-400 border-green-200 dark:border-green-500/20' : 'bg-red-100 dark:bg-red-500/20 text-red-700 dark:text-red-400 border-red-200 dark:border-red-500/20' }}">
                                {{ $item->status }}
                            </span>
                        </td>
                        <td class="py-4 px-4 text-right">
                            <button onclick="openEditModal('{{ $item->id }}', '{{ addslashes($item->nama_cabang) }}', '{{ addslashes($item->alamat_cabang) }}', '{{ addslashes($item->koordinat_gps) }}', '{{ $item->status }}')" class="text-borma-purple dark:text-borma-yellow hover:text-purple-700 dark:hover:text-yellow-300 font-bold text-sm bg-slate-100 dark:bg-white/10 px-3 py-1.5 rounded-lg transition-colors">
                                Kelola
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-8 text-center text-slate-500 dark:text-white/50">Belum ada data cabang.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah Cabang -->
<div id="addCabangModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-slate-900/50 backdrop-blur-sm transition-opacity duration-300 opacity-0">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
        <div class="relative w-full max-w-lg p-6 mx-auto bg-white rounded-3xl shadow-xl dark:bg-borma-dark border border-slate-200 dark:border-white/10 text-left transform transition-all scale-95 opacity-0 duration-300" id="addCabangModalContent">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-xl font-bold text-slate-800 dark:text-white">Tambah Cabang Baru</h3>
                <button type="button" onclick="closeModal('addCabangModal')" class="text-slate-400 hover:text-slate-500 dark:hover:text-white transition-colors">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>
            
            <form action="{{ route('superadmin.cabang.store') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-white/70 mb-1">ID Cabang</label>
                        <input type="text" disabled placeholder="Otomatis" class="w-full px-4 py-2 bg-slate-50 dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-xl text-slate-500 cursor-not-allowed">
                    </div>
                    <div>
                        <label for="nama_cabang" class="block text-sm font-medium text-slate-700 dark:text-white/70 mb-1">Nama Cabang</label>
                        <input type="text" name="nama_cabang" id="nama_cabang" required class="w-full px-4 py-2 bg-transparent border border-slate-200 dark:border-white/10 rounded-xl focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow focus:border-transparent outline-none transition-all text-slate-800 dark:text-white">
                    </div>
                    <div>
                        <label for="alamat_cabang" class="block text-sm font-medium text-slate-700 dark:text-white/70 mb-1">Alamat Cabang</label>
                        <textarea name="alamat_cabang" id="alamat_cabang" rows="3" required class="w-full px-4 py-2 bg-transparent border border-slate-200 dark:border-white/10 rounded-xl focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow focus:border-transparent outline-none transition-all text-slate-800 dark:text-white"></textarea>
                    </div>
                    <div>
                        <label for="koordinat_gps" class="block text-sm font-medium text-slate-700 dark:text-white/70 mb-1">Koordinat GPS</label>
                        <input type="text" name="koordinat_gps" id="koordinat_gps" placeholder="-6.914744, 107.609810" required class="w-full px-4 py-2 bg-transparent border border-slate-200 dark:border-white/10 rounded-xl focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow focus:border-transparent outline-none transition-all text-slate-800 dark:text-white">
                    </div>
                    <div>
                        <label for="status" class="block text-sm font-medium text-slate-700 dark:text-white/70 mb-1">Status</label>
                        <select name="status" id="status" required class="w-full px-4 py-2 bg-white dark:bg-borma-dark border border-slate-200 dark:border-white/10 rounded-xl focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow focus:border-transparent outline-none transition-all text-slate-800 dark:text-white">
                            <option value="Aktif">Aktif</option>
                            <option value="Tidak Aktif">Tidak Aktif</option>
                        </select>
                    </div>
                </div>
                
                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" onclick="closeModal('addCabangModal')" class="px-5 py-2 text-sm font-medium text-slate-600 bg-slate-100 hover:bg-slate-200 dark:text-white/70 dark:bg-white/10 dark:hover:bg-white/20 rounded-xl transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2 text-sm font-bold text-white bg-borma-purple hover:bg-purple-800 dark:text-borma-purple dark:bg-borma-yellow dark:hover:bg-yellow-400 rounded-xl transition-colors shadow-md">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Kelola/Edit Cabang -->
<div id="editCabangModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-slate-900/50 backdrop-blur-sm transition-opacity duration-300 opacity-0">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
        <div class="relative w-full max-w-lg p-6 mx-auto bg-white rounded-3xl shadow-xl dark:bg-borma-dark border border-slate-200 dark:border-white/10 text-left transform transition-all scale-95 opacity-0 duration-300" id="editCabangModalContent">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-xl font-bold text-slate-800 dark:text-white">Kelola Cabang</h3>
                <button type="button" onclick="closeModal('editCabangModal')" class="text-slate-400 hover:text-slate-500 dark:hover:text-white transition-colors">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>
            
            <form id="editCabangForm" method="POST">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-white/70 mb-1">ID Cabang</label>
                        <input type="text" id="edit_id_cabang" disabled class="w-full px-4 py-2 bg-slate-50 dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-xl text-slate-500 cursor-not-allowed">
                    </div>
                    <div>
                        <label for="edit_nama_cabang" class="block text-sm font-medium text-slate-700 dark:text-white/70 mb-1">Nama Cabang</label>
                        <input type="text" name="nama_cabang" id="edit_nama_cabang" required class="w-full px-4 py-2 bg-transparent border border-slate-200 dark:border-white/10 rounded-xl focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow focus:border-transparent outline-none transition-all text-slate-800 dark:text-white">
                    </div>
                    <div>
                        <label for="edit_alamat_cabang" class="block text-sm font-medium text-slate-700 dark:text-white/70 mb-1">Alamat Cabang</label>
                        <textarea name="alamat_cabang" id="edit_alamat_cabang" rows="3" required class="w-full px-4 py-2 bg-transparent border border-slate-200 dark:border-white/10 rounded-xl focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow focus:border-transparent outline-none transition-all text-slate-800 dark:text-white"></textarea>
                    </div>
                    <div>
                        <label for="edit_koordinat_gps" class="block text-sm font-medium text-slate-700 dark:text-white/70 mb-1">Koordinat GPS</label>
                        <input type="text" name="koordinat_gps" id="edit_koordinat_gps" required class="w-full px-4 py-2 bg-transparent border border-slate-200 dark:border-white/10 rounded-xl focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow focus:border-transparent outline-none transition-all text-slate-800 dark:text-white">
                    </div>
                    <div>
                        <label for="edit_status" class="block text-sm font-medium text-slate-700 dark:text-white/70 mb-1">Status</label>
                        <select name="status" id="edit_status" required class="w-full px-4 py-2 bg-white dark:bg-borma-dark border border-slate-200 dark:border-white/10 rounded-xl focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow focus:border-transparent outline-none transition-all text-slate-800 dark:text-white">
                            <option value="Aktif">Aktif</option>
                            <option value="Tidak Aktif">Tidak Aktif</option>
                        </select>
                    </div>
                </div>
                
                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" onclick="closeModal('editCabangModal')" class="px-5 py-2 text-sm font-medium text-slate-600 bg-slate-100 hover:bg-slate-200 dark:text-white/70 dark:bg-white/10 dark:hover:bg-white/20 rounded-xl transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2 text-sm font-bold text-white bg-borma-purple hover:bg-purple-800 dark:text-borma-purple dark:bg-borma-yellow dark:hover:bg-yellow-400 rounded-xl transition-colors shadow-md">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openModal(modalId) {
        const modal = document.getElementById(modalId);
        const content = document.getElementById(modalId + 'Content');
        
        modal.classList.remove('hidden');
        
        // Trigger reflow
        void modal.offsetWidth;
        
        modal.classList.remove('opacity-0');
        content.classList.remove('scale-95', 'opacity-0');
        content.classList.add('scale-100', 'opacity-100');
    }

    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        const content = document.getElementById(modalId + 'Content');
        
        modal.classList.add('opacity-0');
        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');
        
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }

    function openEditModal(id, nama, alamat, koordinat, status) {
        document.getElementById('edit_id_cabang').value = id;
        document.getElementById('edit_nama_cabang').value = nama;
        document.getElementById('edit_alamat_cabang').value = alamat;
        document.getElementById('edit_koordinat_gps').value = koordinat;
        document.getElementById('edit_status').value = status;
        
        // Set action form url
        const form = document.getElementById('editCabangForm');
        form.action = `/superadmin/cabang/${id}`;
        
        openModal('editCabangModal');
    }
</script>
@endsection
