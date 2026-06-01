@extends('super-admin.layouts.app')
@section('title', 'Detail Cabang | Super Admin Borma')
@section('page_title', 'Detail Cabang')

@section('content')
<div class="mb-6 flex items-center gap-4">
    <a href="{{ route('superadmin.cabang') }}" class="w-10 h-10 rounded-xl bg-white dark:bg-white/5 border border-slate-200 dark:border-white/10 flex items-center justify-center text-slate-500 dark:text-white/50 hover:bg-slate-50 dark:hover:bg-white/10 hover:text-borma-purple dark:hover:text-borma-yellow transition-all">
        <i class="fa-solid fa-arrow-left"></i>
    </a>
    <h4 class="text-lg font-bold text-slate-800 dark:text-white">Detail Cabang: <span class="text-borma-purple dark:text-borma-yellow">{{ $cabang->nama_cabang }}</span></h4>
</div>

@if(session('success'))
<div class="bg-green-100 dark:bg-green-500/20 text-green-700 dark:text-green-400 border border-green-200 dark:border-green-500/20 p-4 rounded-xl mb-6">
    {{ session('success') }}
</div>
@endif

@if($errors->any())
<div class="bg-red-100 dark:bg-red-500/20 text-red-700 dark:text-red-400 border border-red-200 dark:border-red-500/20 p-4 rounded-xl mb-6">
    <ul class="list-disc pl-5">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
    <!-- Kolom Kiri: Info & Edit Cabang -->
    <div class="xl:col-span-1">
        <div class="bg-white dark:bg-white/5 dark:backdrop-blur-xl border border-slate-200 dark:border-white/10 shadow-sm dark:shadow-none rounded-3xl p-6 h-fit">
            <h5 class="font-bold text-lg text-slate-800 dark:text-white mb-6 border-b border-slate-200 dark:border-white/10 pb-4 flex items-center gap-2">
                <i class="fa-solid fa-store text-borma-purple dark:text-borma-yellow"></i> Info Cabang
            </h5>

            <form action="{{ route('superadmin.cabang.update', $cabang->id_cabang) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-white/80 mb-2">Nama Cabang</label>
                        <input type="text" name="nama_cabang" value="{{ old('nama_cabang', $cabang->nama_cabang) }}" required
                            class="w-full bg-slate-50 dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow text-slate-800 dark:text-white transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-white/80 mb-2">Alamat Cabang</label>
                        <textarea name="alamat_cabang" rows="3" required
                            class="w-full bg-slate-50 dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow text-slate-800 dark:text-white transition-all">{{ old('alamat_cabang', $cabang->alamat_cabang) }}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-white/80 mb-2">Koordinat GPS</label>
                        <input type="text" name="koordinat_gps" value="{{ old('koordinat_gps', $cabang->koordinat_gps) }}" required
                            placeholder="-6.914744, 107.609810"
                            class="w-full bg-slate-50 dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow text-slate-800 dark:text-white transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-white/80 mb-2">Status</label>
                        <select name="status" required
                            class="w-full bg-slate-50 dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow text-slate-800 dark:text-white transition-all">
                            <option value="Aktif" {{ $cabang->status == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="Tidak Aktif" {{ $cabang->status == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                    </div>
                </div>

                <div class="mt-8 pt-6 border-t border-slate-200 dark:border-white/10 flex flex-col gap-3">
                    <button type="submit" class="w-full bg-borma-purple hover:bg-purple-800 dark:bg-borma-yellow dark:hover:bg-yellow-500 text-white dark:text-slate-900 px-4 py-3 rounded-xl text-sm font-bold transition-all shadow-md flex justify-center items-center gap-2">
                        <i class="fa-solid fa-save"></i> Simpan Perubahan
                    </button>
                </div>
            </form>

            <form action="{{ route('superadmin.cabang.destroy', $cabang->id_cabang) }}" method="POST" class="mt-3"
                onsubmit="return confirm('Hapus cabang ini? Semua data terkait mungkin ikut terhapus.');">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-full bg-red-50 dark:bg-red-500/10 hover:bg-red-100 dark:hover:bg-red-500/20 text-red-600 dark:text-red-400 border border-red-200 dark:border-red-500/20 px-4 py-3 rounded-xl text-sm font-bold transition-all flex justify-center items-center gap-2">
                    <i class="fa-solid fa-trash"></i> Hapus Cabang
                </button>
            </form>
        </div>
    </div>

    <!-- Kolom Kanan: Daftar Admin Cabang -->
    <div class="xl:col-span-2">
        <div class="bg-white dark:bg-white/5 dark:backdrop-blur-xl border border-slate-200 dark:border-white/10 shadow-sm dark:shadow-none rounded-3xl p-6">
            <div class="flex justify-between items-center mb-6 border-b border-slate-200 dark:border-white/10 pb-4">
                <h5 class="font-bold text-lg text-slate-800 dark:text-white flex items-center gap-2">
                    <i class="fa-solid fa-user-tie text-borma-purple dark:text-borma-yellow"></i> Admin Cabang Ini
                </h5>
                <button onclick="openModal('addAdminModal')" class="bg-borma-purple dark:bg-borma-yellow hover:bg-opacity-90 text-white dark:text-slate-900 font-bold py-2 px-4 rounded-xl transition-all shadow-md flex items-center gap-2 text-sm">
                    <i class="fa-solid fa-plus"></i> Tambah Admin
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-200 dark:border-white/10 text-slate-500 dark:text-white/50 text-xs uppercase tracking-wider">
                            <th class="pb-3 font-medium px-3">Nama</th>
                            <th class="pb-3 font-medium px-3">Email</th>
                            <th class="pb-3 font-medium px-3">No. Telp</th>
                            <th class="pb-3 font-medium px-3">Tgl Masuk</th>
                            <th class="pb-3 font-medium px-3">Status</th>
                            <th class="pb-3 font-medium px-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        @forelse($cabang->adminCabangs as $admin)
                        <tr class="border-b border-slate-100 dark:border-white/5 hover:bg-slate-50 dark:hover:bg-white/5 transition-colors">
                            <td class="py-4 px-3 font-bold text-slate-800 dark:text-white">{{ $admin->user->nama ?? '-' }}</td>
                            <td class="py-4 px-3 text-slate-600 dark:text-white/70 text-xs">{{ $admin->user->email ?? '-' }}</td>
                            <td class="py-4 px-3 text-slate-600 dark:text-white/70">{{ $admin->user->no_telepon ?? '-' }}</td>
                            <td class="py-4 px-3 text-slate-600 dark:text-white/70">{{ \Carbon\Carbon::parse($admin->tanggal_masuk)->format('d M Y') }}</td>
                            <td class="py-4 px-3">
                                <span class="px-2 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider border
                                    {{ $admin->status_karyawan == 'Aktif'
                                        ? 'bg-green-100 dark:bg-green-500/20 text-green-700 dark:text-green-400 border-green-200 dark:border-green-500/20'
                                        : 'bg-red-100 dark:bg-red-500/20 text-red-700 dark:text-red-400 border-red-200 dark:border-red-500/20' }}">
                                    {{ $admin->status_karyawan }}
                                </span>
                            </td>
                            <td class="py-4 px-3 text-right">
                                <div class="flex justify-end gap-2">
                                    <button onclick="openEditAdminModal(
                                        '{{ $admin->id_admin_cabang }}',
                                        '{{ addslashes($admin->user->nama ?? '') }}',
                                        '{{ addslashes($admin->user->email ?? '') }}',
                                        '{{ addslashes($admin->user->no_telepon ?? '') }}',
                                        '{{ $cabang->id_cabang }}',
                                        '{{ $admin->tanggal_masuk }}',
                                        '{{ $admin->status_karyawan }}'
                                    )" class="text-borma-purple dark:text-borma-yellow font-bold text-xs bg-slate-100 dark:bg-white/10 px-3 py-1.5 rounded-lg transition-colors hover:bg-slate-200 dark:hover:bg-white/20">
                                        Kelola
                                    </button>
                                    <form action="{{ route('superadmin.admin_cabang.destroy', $admin->id_admin_cabang) }}" method="POST"
                                        onsubmit="return confirm('Hapus admin {{ $admin->user->nama ?? '' }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 font-bold text-xs bg-red-50 dark:bg-red-500/10 px-3 py-1.5 rounded-lg transition-colors hover:bg-red-100">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="py-10 text-center text-slate-500 dark:text-white/50">
                                <i class="fa-solid fa-user-slash text-2xl mb-2 block opacity-30"></i>
                                Belum ada admin untuk cabang ini.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Admin -->
<div id="addAdminModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-slate-900/50 backdrop-blur-sm transition-opacity duration-300 opacity-0">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
        <div class="relative w-full max-w-lg p-6 mx-auto bg-white rounded-3xl shadow-xl dark:bg-borma-dark border border-slate-200 dark:border-white/10 text-left transform transition-all scale-95 opacity-0 duration-300" id="addAdminModalContent">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-xl font-bold text-slate-800 dark:text-white">Tambah Admin Cabang</h3>
                <button type="button" onclick="closeModal('addAdminModal')" class="text-slate-400 hover:text-slate-500 dark:hover:text-white transition-colors">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>

            <form action="{{ route('superadmin.admin_cabang.store') }}" method="POST">
                @csrf
                <input type="hidden" name="from_cabang_id" value="{{ $cabang->id_cabang }}">
                <input type="hidden" name="id_cabang" value="{{ $cabang->id_cabang }}">
                <div class="space-y-4">
                    <div>
                        <label for="add_nama" class="block text-sm font-medium text-slate-700 dark:text-white/70 mb-1">Nama</label>
                        <input type="text" name="nama" id="add_nama" required class="w-full px-4 py-2 bg-transparent border border-slate-200 dark:border-white/10 rounded-xl focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow focus:border-transparent outline-none transition-all text-slate-800 dark:text-white">
                    </div>
                    <div>
                        <label for="add_email" class="block text-sm font-medium text-slate-700 dark:text-white/70 mb-1">Email</label>
                        <input type="email" name="email" id="add_email" required class="w-full px-4 py-2 bg-transparent border border-slate-200 dark:border-white/10 rounded-xl focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow focus:border-transparent outline-none transition-all text-slate-800 dark:text-white">
                    </div>
                    <div>
                        <label for="add_password" class="block text-sm font-medium text-slate-700 dark:text-white/70 mb-1">Password</label>
                        <div class="relative">
                            <input type="password" name="password" id="add_password" required placeholder="Min. 8 karakter (huruf & angka/simbol)"
                                class="w-full px-4 py-2 pr-10 bg-transparent border border-slate-200 dark:border-white/10 rounded-xl focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow focus:border-transparent outline-none transition-all text-slate-800 dark:text-white">
                            <button type="button" onclick="togglePwd('add_password','add_pwd_icon')" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600">
                                <i class="fa-solid fa-eye" id="add_pwd_icon"></i>
                            </button>
                        </div>
                    </div>
                    <div>
                        <label for="add_no_telepon" class="block text-sm font-medium text-slate-700 dark:text-white/70 mb-1">No Telepon</label>
                        <input type="text" name="no_telepon" id="add_no_telepon" required class="w-full px-4 py-2 bg-transparent border border-slate-200 dark:border-white/10 rounded-xl focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow focus:border-transparent outline-none transition-all text-slate-800 dark:text-white">
                    </div>
                    <div>
                        <label for="add_tanggal_masuk" class="block text-sm font-medium text-slate-700 dark:text-white/70 mb-1">Tanggal Masuk</label>
                        <input type="date" name="tanggal_masuk" id="add_tanggal_masuk" required class="w-full px-4 py-2 bg-transparent border border-slate-200 dark:border-white/10 rounded-xl focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow focus:border-transparent outline-none transition-all text-slate-800 dark:text-white">
                    </div>
                    <div>
                        <label for="add_status_karyawan" class="block text-sm font-medium text-slate-700 dark:text-white/70 mb-1">Status Karyawan</label>
                        <select name="status_karyawan" id="add_status_karyawan" required class="w-full px-4 py-2 bg-white dark:bg-borma-dark border border-slate-200 dark:border-white/10 rounded-xl focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow outline-none transition-all text-slate-800 dark:text-white">
                            <option value="Aktif">Aktif</option>
                            <option value="Tidak Aktif">Tidak Aktif</option>
                        </select>
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
                <input type="hidden" name="from_cabang_id" value="{{ $cabang->id_cabang }}">
                <input type="hidden" name="id_cabang" id="edit_id_cabang_hidden" value="{{ $cabang->id_cabang }}">
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
                        <label for="edit_password" class="block text-sm font-medium text-slate-700 dark:text-white/70 mb-1">Password <span class="text-xs text-slate-400 font-normal">(Kosongkan jika tidak diubah)</span></label>
                        <div class="relative">
                            <input type="password" name="password" id="edit_password" placeholder="Min. 8 karakter"
                                class="w-full px-4 py-2 pr-10 bg-transparent border border-slate-200 dark:border-white/10 rounded-xl focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow focus:border-transparent outline-none transition-all text-slate-800 dark:text-white">
                            <button type="button" onclick="togglePwd('edit_password','edit_pwd_icon')" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600">
                                <i class="fa-solid fa-eye" id="edit_pwd_icon"></i>
                            </button>
                        </div>
                    </div>
                    <div>
                        <label for="edit_no_telepon" class="block text-sm font-medium text-slate-700 dark:text-white/70 mb-1">No Telepon</label>
                        <input type="text" name="no_telepon" id="edit_no_telepon" required class="w-full px-4 py-2 bg-transparent border border-slate-200 dark:border-white/10 rounded-xl focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow focus:border-transparent outline-none transition-all text-slate-800 dark:text-white">
                    </div>
                    <div>
                        <label for="edit_tanggal_masuk" class="block text-sm font-medium text-slate-700 dark:text-white/70 mb-1">Tanggal Masuk</label>
                        <input type="date" name="tanggal_masuk" id="edit_tanggal_masuk" required class="w-full px-4 py-2 bg-transparent border border-slate-200 dark:border-white/10 rounded-xl focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow focus:border-transparent outline-none transition-all text-slate-800 dark:text-white">
                    </div>
                    <div>
                        <label for="edit_status_karyawan" class="block text-sm font-medium text-slate-700 dark:text-white/70 mb-1">Status Karyawan</label>
                        <select name="status_karyawan" id="edit_status_karyawan" required class="w-full px-4 py-2 bg-white dark:bg-borma-dark border border-slate-200 dark:border-white/10 rounded-xl focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow outline-none transition-all text-slate-800 dark:text-white">
                            <option value="Aktif">Aktif</option>
                            <option value="Tidak Aktif">Tidak Aktif</option>
                        </select>
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
        setTimeout(() => { modal.classList.add('hidden'); }, 300);
    }

    function openEditAdminModal(id, nama, email, telepon, idCabang, tanggalMasuk, statusKaryawan) {
        document.getElementById('edit_nama').value = nama;
        document.getElementById('edit_email').value = email;
        document.getElementById('edit_password').value = '';
        document.getElementById('edit_no_telepon').value = telepon;
        document.getElementById('edit_id_cabang_hidden').value = idCabang;
        document.getElementById('edit_tanggal_masuk').value = tanggalMasuk;
        document.getElementById('edit_status_karyawan').value = statusKaryawan;
        document.getElementById('editAdminForm').action = `/superadmin/admin-cabang/${id}`;
        openModal('editAdminModal');
    }

    function togglePwd(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    }
</script>
@endsection
