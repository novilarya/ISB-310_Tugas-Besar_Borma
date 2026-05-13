@extends('super-admin.layouts.app')
@section('title', 'Manajemen Admin Cabang | Super Admin Borma')
@section('page_title', 'Manajemen Admin Cabang')

@section('content')
<div class="grid grid-cols-1 gap-6">
    <div class="bg-white dark:bg-white/5 dark:backdrop-blur-xl border border-slate-200 dark:border-white/10 shadow-sm dark:shadow-none rounded-3xl p-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
            <h4 class="text-lg font-bold text-slate-800 dark:text-white">Daftar Admin Cabang</h4>
            
            <div class="flex flex-col md:flex-row items-center gap-3 w-full md:w-auto">
                <button onclick="openModal('addAdminModal')" class="bg-borma-purple dark:bg-borma-yellow hover:bg-opacity-90 text-white dark:text-borma-purple font-bold py-2 px-4 rounded-xl transition-all shadow-md flex items-center justify-center gap-2 w-full md:w-auto">
                    <i class="fa-solid fa-plus"></i> Tambah Admin
                </button>
            </div>
        </div>

        @if(session('success'))
        <div class="bg-green-100 dark:bg-green-500/20 text-green-700 dark:text-green-400 border border-green-200 dark:border-green-500/20 p-4 rounded-xl mb-6">
            {{ session('success') }}
        </div>
        @endif

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-200 dark:border-white/10 text-slate-500 dark:text-white/50 text-sm">
                        <th class="pb-4 font-medium px-4">Nama</th>
                        <th class="pb-4 font-medium px-4">Email</th>
                        <th class="pb-4 font-medium px-4">No Telepon</th>
                        <th class="pb-4 font-medium px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse($adminCabangs as $item)
                    <tr class="border-b border-slate-100 dark:border-white/5 hover:bg-slate-50 dark:hover:bg-white/5 transition-colors">
                        <td class="py-4 px-4 font-bold text-slate-800 dark:text-white">{{ $item->nama }}</td>
                        <td class="py-4 px-4 text-slate-600 dark:text-white/80">{{ $item->email }}</td>
                        <td class="py-4 px-4 text-slate-600 dark:text-white/80">{{ $item->no_telepon }}</td>
                        <td class="py-4 px-4 text-right flex justify-end gap-2">
                            <button onclick="openEditModal('{{ $item->id_user }}', '{{ addslashes($item->nama) }}', '{{ addslashes($item->email) }}', '{{ addslashes($item->no_telepon) }}')" class="text-borma-purple dark:text-borma-yellow hover:text-purple-700 dark:hover:text-yellow-300 font-bold text-sm bg-slate-100 dark:bg-white/10 px-3 py-1.5 rounded-lg transition-colors">
                                Kelola
                            </button>
                            <form action="{{ route('superadmin.admin_cabang.destroy', $item->id_user) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus admin ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 font-bold text-sm bg-red-50 dark:bg-red-500/10 px-3 py-1.5 rounded-lg transition-colors">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="py-8 text-center text-slate-500 dark:text-white/50">Belum ada data admin cabang.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah Admin -->
<div id="addAdminModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-slate-900/50 backdrop-blur-sm transition-opacity duration-300 opacity-0">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
        <div class="relative w-full max-w-lg p-6 mx-auto bg-white rounded-3xl shadow-xl dark:bg-borma-dark border border-slate-200 dark:border-white/10 text-left transform transition-all scale-95 opacity-0 duration-300" id="addAdminModalContent">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-xl font-bold text-slate-800 dark:text-white">Tambah Admin</h3>
                <button type="button" onclick="closeModal('addAdminModal')" class="text-slate-400 hover:text-slate-500 dark:hover:text-white transition-colors">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>
            
            <form action="{{ route('superadmin.admin_cabang.store') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="nama" class="block text-sm font-medium text-slate-700 dark:text-white/70 mb-1">Nama</label>
                        <input type="text" name="nama" id="nama" required class="w-full px-4 py-2 bg-transparent border border-slate-200 dark:border-white/10 rounded-xl focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow focus:border-transparent outline-none transition-all text-slate-800 dark:text-white">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-700 dark:text-white/70 mb-1">Email</label>
                        <input type="email" name="email" id="email" required class="w-full px-4 py-2 bg-transparent border border-slate-200 dark:border-white/10 rounded-xl focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow focus:border-transparent outline-none transition-all text-slate-800 dark:text-white">
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-medium text-slate-700 dark:text-white/70 mb-1">Password</label>
                        <input type="password" name="password" id="password" required class="w-full px-4 py-2 bg-transparent border border-slate-200 dark:border-white/10 rounded-xl focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow focus:border-transparent outline-none transition-all text-slate-800 dark:text-white">
                    </div>
                    <div>
                        <label for="no_telepon" class="block text-sm font-medium text-slate-700 dark:text-white/70 mb-1">No Telepon</label>
                        <input type="text" name="no_telepon" id="no_telepon" required class="w-full px-4 py-2 bg-transparent border border-slate-200 dark:border-white/10 rounded-xl focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow focus:border-transparent outline-none transition-all text-slate-800 dark:text-white">
                    </div>
                </div>
                
                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" onclick="closeModal('addAdminModal')" class="px-5 py-2 text-sm font-medium text-slate-600 bg-slate-100 hover:bg-slate-200 dark:text-white/70 dark:bg-white/10 dark:hover:bg-white/20 rounded-xl transition-colors">
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

<!-- Modal Edit Admin -->
<div id="editAdminModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-slate-900/50 backdrop-blur-sm transition-opacity duration-300 opacity-0">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
        <div class="relative w-full max-w-lg p-6 mx-auto bg-white rounded-3xl shadow-xl dark:bg-borma-dark border border-slate-200 dark:border-white/10 text-left transform transition-all scale-95 opacity-0 duration-300" id="editAdminModalContent">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-xl font-bold text-slate-800 dark:text-white">Kelola Admin</h3>
                <button type="button" onclick="closeModal('editAdminModal')" class="text-slate-400 hover:text-slate-500 dark:hover:text-white transition-colors">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>
            
            <form id="editAdminForm" method="POST">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <div>
                        <label for="edit_nama" class="block text-sm font-medium text-slate-700 dark:text-white/70 mb-1">Nama</label>
                        <input type="text" name="nama" id="edit_nama" required class="w-full px-4 py-2 bg-transparent border border-slate-200 dark:border-white/10 rounded-xl focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow focus:border-transparent outline-none transition-all text-slate-800 dark:text-white">
                    </div>
                    <div>
                        <label for="edit_email" class="block text-sm font-medium text-slate-700 dark:text-white/70 mb-1">Email</label>
                        <input type="email" name="email" id="edit_email" required class="w-full px-4 py-2 bg-transparent border border-slate-200 dark:border-white/10 rounded-xl focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow focus:border-transparent outline-none transition-all text-slate-800 dark:text-white">
                    </div>
                    <div>
                        <label for="edit_password" class="block text-sm font-medium text-slate-700 dark:text-white/70 mb-1">Password (Kosongkan jika tidak diubah)</label>
                        <input type="password" name="password" id="edit_password" class="w-full px-4 py-2 bg-transparent border border-slate-200 dark:border-white/10 rounded-xl focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow focus:border-transparent outline-none transition-all text-slate-800 dark:text-white">
                    </div>
                    <div>
                        <label for="edit_no_telepon" class="block text-sm font-medium text-slate-700 dark:text-white/70 mb-1">No Telepon</label>
                        <input type="text" name="no_telepon" id="edit_no_telepon" required class="w-full px-4 py-2 bg-transparent border border-slate-200 dark:border-white/10 rounded-xl focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow focus:border-transparent outline-none transition-all text-slate-800 dark:text-white">
                    </div>
                </div>
                
                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" onclick="closeModal('editAdminModal')" class="px-5 py-2 text-sm font-medium text-slate-600 bg-slate-100 hover:bg-slate-200 dark:text-white/70 dark:bg-white/10 dark:hover:bg-white/20 rounded-xl transition-colors">
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

    function openEditModal(id, nama, email, telepon) {
        document.getElementById('edit_nama').value = nama;
        document.getElementById('edit_email').value = email;
        document.getElementById('edit_password').value = '';
        document.getElementById('edit_no_telepon').value = telepon;
        
        // Set action form url
        const form = document.getElementById('editAdminForm');
        form.action = `/superadmin/admin-cabang/${id}`;
        
        openModal('editAdminModal');
    }
</script>
@endsection
