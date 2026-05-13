@extends('super-admin.layouts.app')
@section('title', 'Manajemen Member | Super Admin Borma')
@section('page_title', 'Manajemen Member')

@section('content')
<div class="grid grid-cols-1 gap-6">
    <div class="bg-white dark:bg-white/5 dark:backdrop-blur-xl border border-slate-200 dark:border-white/10 shadow-sm dark:shadow-none rounded-3xl p-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
            <h4 class="text-lg font-bold text-slate-800 dark:text-white">Daftar Member (Pelanggan)</h4>
            
            <div class="flex flex-col md:flex-row items-center gap-3 w-full md:w-auto">
                <!-- Removed Tambah Member button as requested -->
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
                        <th class="pb-4 font-medium px-4">Alamat</th>
                        <th class="pb-4 font-medium px-4">Poin</th>
                        <th class="pb-4 font-medium px-4">Status</th>
                        <th class="pb-4 font-medium px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse($members as $item)
                    <tr class="border-b border-slate-100 dark:border-white/5 hover:bg-slate-50 dark:hover:bg-white/5 transition-colors">
                        <td class="py-4 px-4 font-bold text-slate-800 dark:text-white">{{ $item->user->nama ?? '-' }}</td>
                        <td class="py-4 px-4 text-slate-600 dark:text-white/80">{{ $item->user->email ?? '-' }}</td>
                        <td class="py-4 px-4 text-slate-600 dark:text-white/80">{{ $item->user->no_telepon ?? '-' }}</td>
                        <td class="py-4 px-4 text-slate-600 dark:text-white/80">{{ $item->alamat }}</td>
                        <td class="py-4 px-4 font-bold text-borma-purple dark:text-borma-yellow">{{ number_format($item->poin_member) }}</td>
                        <td class="py-4 px-4">
                            <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider border {{ $item->status_member ? 'bg-green-100 dark:bg-green-500/20 text-green-700 dark:text-green-400 border-green-200 dark:border-green-500/20' : 'bg-red-100 dark:bg-red-500/20 text-red-700 dark:text-red-400 border-red-200 dark:border-red-500/20' }}">
                                {{ $item->status_member ? 'Aktif' : 'Tidak Aktif' }}
                            </span>
                        </td>
                        <td class="py-4 px-4 text-right flex justify-end gap-2">
                            <button onclick="openEditModal('{{ $item->id_pelanggan }}', '{{ addslashes($item->user->nama ?? '') }}', '{{ addslashes($item->user->email ?? '') }}', '{{ addslashes($item->user->no_telepon ?? '') }}', '{{ addslashes($item->alamat) }}', '{{ $item->poin_member }}', '{{ $item->status_member ? 1 : 0 }}')" class="text-borma-purple dark:text-borma-yellow hover:text-purple-700 dark:hover:text-yellow-300 font-bold text-sm bg-slate-100 dark:bg-white/10 px-3 py-1.5 rounded-lg transition-colors">
                                Kelola
                            </button>
                            <form action="{{ route('superadmin.member.destroy', $item->id_pelanggan) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus member ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 font-bold text-sm bg-red-50 dark:bg-red-500/10 px-3 py-1.5 rounded-lg transition-colors">
                                    Hapus
                                </button>
                            </form>

                            <!-- Hidden Template for Order History -->
                            <template id="history-{{ $item->id_pelanggan }}">
                                @if($item->riwayatPesanan->isEmpty())
                                    <div class="p-4 text-center text-slate-500 dark:text-white/50 bg-slate-50 dark:bg-white/5 rounded-xl border border-slate-200 dark:border-white/10">
                                        <i class="fa-solid fa-box-open text-3xl mb-2 opacity-50"></i>
                                        <p class="text-sm">Belum ada riwayat pembelian.</p>
                                    </div>
                                @else
                                    <div class="space-y-4">
                                        @foreach($item->riwayatPesanan as $pesanan)
                                        <div class="bg-slate-50 dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-xl p-4">
                                            <div class="flex justify-between items-start mb-3 border-b border-slate-200 dark:border-white/10 pb-2">
                                                <div>
                                                    <span class="text-xs font-bold text-borma-purple dark:text-borma-yellow">ORD-{{ str_pad($pesanan->id_pesanan, 4, '0', STR_PAD_LEFT) }}</span>
                                                    <p class="text-xs text-slate-500 dark:text-white/50">{{ \Carbon\Carbon::parse($pesanan->tanggal_pemesanan)->format('d M Y, H:i') }}</p>
                                                </div>
                                                <div class="text-right">
                                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-slate-200 dark:bg-white/10 text-slate-700 dark:text-white/80">
                                                        {{ $pesanan->status_pesanan }}
                                                    </span>
                                                    <p class="text-sm font-bold text-green-600 dark:text-green-400 mt-1">Rp {{ number_format($pesanan->total_tagihan, 0, ',', '.') }}</p>
                                                </div>
                                            </div>
                                            <div class="space-y-2">
                                                @foreach($pesanan->details as $detail)
                                                <div class="flex justify-between items-center text-sm">
                                                    <div class="flex items-center gap-2">
                                                        <span class="text-xs font-bold bg-slate-200 dark:bg-white/10 px-1.5 py-0.5 rounded text-slate-600 dark:text-white/70">{{ $detail->jumlah }}x</span>
                                                        <span class="text-slate-700 dark:text-white/80 line-clamp-1" title="{{ $detail->produk->nama_produk ?? 'Produk tidak ditemukan' }}">{{ $detail->produk->nama_produk ?? 'Produk dihapus' }}</span>
                                                    </div>
                                                    <span class="text-slate-500 dark:text-white/60 text-xs">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</span>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                @endif
                            </template>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-8 text-center text-slate-500 dark:text-white/50">Belum ada data member.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Edit Member -->
<div id="editMemberModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-slate-900/50 backdrop-blur-sm transition-opacity duration-300 opacity-0">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
        <div class="relative w-full max-w-lg p-6 mx-auto bg-white rounded-3xl shadow-xl dark:bg-borma-dark border border-slate-200 dark:border-white/10 text-left transform transition-all scale-95 opacity-0 duration-300" id="editMemberModalContent">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-xl font-bold text-slate-800 dark:text-white">Kelola Member</h3>
                <button type="button" onclick="closeModal('editMemberModal')" class="text-slate-400 hover:text-slate-500 dark:hover:text-white transition-colors">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>
            
            <form id="editMemberForm" method="POST">
                @csrf
                @method('PUT')
                <div class="space-y-4 max-h-[60vh] overflow-y-auto pr-2">
                    <div>
                        <label for="edit_nama" class="block text-sm font-medium text-slate-700 dark:text-white/70 mb-1">Nama Lengkap</label>
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
                    <div>
                        <label for="edit_alamat" class="block text-sm font-medium text-slate-700 dark:text-white/70 mb-1">Alamat</label>
                        <textarea name="alamat" id="edit_alamat" rows="3" required class="w-full px-4 py-2 bg-transparent border border-slate-200 dark:border-white/10 rounded-xl focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow focus:border-transparent outline-none transition-all text-slate-800 dark:text-white"></textarea>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="edit_poin_member" class="block text-sm font-medium text-slate-700 dark:text-white/70 mb-1">Poin Member</label>
                            <input type="number" name="poin_member" id="edit_poin_member" min="0" required class="w-full px-4 py-2 bg-transparent border border-slate-200 dark:border-white/10 rounded-xl focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow focus:border-transparent outline-none transition-all text-slate-800 dark:text-white">
                        </div>
                        <div>
                            <label for="edit_status_member" class="block text-sm font-medium text-slate-700 dark:text-white/70 mb-1">Status</label>
                            <select name="status_member" id="edit_status_member" required class="w-full px-4 py-2 bg-white dark:bg-borma-dark border border-slate-200 dark:border-white/10 rounded-xl focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow focus:border-transparent outline-none transition-all text-slate-800 dark:text-white">
                                <option value="1">Aktif</option>
                                <option value="0">Tidak Aktif</option>
                            </select>
                        </div>
                    </div>

                    <!-- Riwayat Pembelian Section -->
                    <div class="pt-4 border-t border-slate-200 dark:border-white/10">
                        <h4 class="text-sm font-bold text-slate-800 dark:text-white mb-3 flex items-center gap-2">
                            <i class="fa-solid fa-receipt text-borma-purple dark:text-borma-yellow"></i> Riwayat Pembelian
                        </h4>
                        <div id="historyContainer" class="max-h-60 overflow-y-auto pr-2 custom-scrollbar">
                            <!-- Injected by JS -->
                        </div>
                    </div>
                </div>
                
                <div class="mt-6 flex justify-end gap-3 pt-4 border-t border-slate-200 dark:border-white/10">
                    <button type="button" onclick="closeModal('editMemberModal')" class="px-5 py-2 text-sm font-medium text-slate-600 bg-slate-100 hover:bg-slate-200 dark:text-white/70 dark:bg-white/10 dark:hover:bg-white/20 rounded-xl transition-colors">
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

    function openEditModal(id, nama, email, telepon, alamat, poin, status) {
        document.getElementById('edit_nama').value = nama;
        document.getElementById('edit_email').value = email;
        document.getElementById('edit_password').value = '';
        document.getElementById('edit_no_telepon').value = telepon;
        document.getElementById('edit_alamat').value = alamat;
        document.getElementById('edit_poin_member').value = poin;
        document.getElementById('edit_status_member').value = status;
        
        // Inject history
        const template = document.getElementById('history-' + id);
        if(template) {
            document.getElementById('historyContainer').innerHTML = template.innerHTML;
        } else {
            document.getElementById('historyContainer').innerHTML = '<p class="text-sm text-slate-500">Data tidak ditemukan.</p>';
        }

        // Set action form url
        const form = document.getElementById('editMemberForm');
        form.action = `/superadmin/member/${id}`;
        
        openModal('editMemberModal');
    }
</script>
@endsection
