<div class="modal fade" id="tambahMemberModal" tabindex="-1" aria-labelledby="tambahMemberLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content bg-white dark:bg-slate-900 w-full rounded-3xl shadow-2xl border border-slate-200 dark:border-white/10 overflow-hidden" style="border: none;">
            <div class="modal-header bg-slate-50 dark:bg-white/5 border-b border-slate-200 dark:border-white/10 p-6 flex justify-between items-center" style="border: none;">
                <h5 class="modal-title font-bold text-lg text-slate-800 dark:text-white flex items-center gap-2" id="tambahMemberLabel">
                    <i class="fa-solid fa-user-plus text-borma-purple dark:text-borma-yellow"></i> Tambah Member Baru
                </h5>
                <button type="button" class="text-slate-400 hover:text-slate-600 dark:hover:text-white transition-colors border-0 bg-transparent p-0" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>
            
            <form action="{{ route('admin-cabang.member.store') }}" method="POST">
                @csrf
                <div class="modal-body p-6">
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                        <div class="md:col-span-6">
                            <label class="block text-sm font-medium text-slate-700 dark:text-white/80 mb-2">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="nama" class="w-full bg-slate-50 dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow text-slate-800 dark:text-white transition-all @error('nama') border-red-500 @enderror" placeholder="Masukkan nama lengkap" value="{{ old('nama') }}" required>
                            @error('nama') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
                        </div>
                        <div class="md:col-span-6">
                            <label class="block text-sm font-medium text-slate-700 dark:text-white/80 mb-2">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="w-full bg-slate-50 dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow text-slate-800 dark:text-white transition-all @error('email') border-red-500 @enderror" placeholder="contoh@email.com" value="{{ old('email') }}" required>
                            @error('email') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
                        </div>
                        <div class="md:col-span-6">
                            <label class="block text-sm font-medium text-slate-700 dark:text-white/80 mb-2">No. Telepon <span class="text-danger">*</span></label>
                            <input type="text" name="no_telepon" class="w-full bg-slate-50 dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow text-slate-800 dark:text-white transition-all" placeholder="08xxxxxxxxxx" value="{{ old('no_telepon') }}" required>
                        </div>
                        <div class="md:col-span-6">
                            <label class="block text-sm font-medium text-slate-700 dark:text-white/80 mb-2">Password <span class="text-danger">*</span></label>
                            <input type="password" name="password" class="w-full bg-slate-50 dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow text-slate-800 dark:text-white transition-all @error('password') border-red-500 @enderror" placeholder="Min. 6 karakter" required>
                            @error('password') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
                        </div>
                        <div class="md:col-span-12">
                            <label class="block text-sm font-medium text-slate-700 dark:text-white/80 mb-2">Alamat <span class="text-danger">*</span></label>
                            <textarea name="alamat" rows="2" class="w-full bg-slate-50 dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow text-slate-800 dark:text-white transition-all" placeholder="Alamat lengkap pelanggan" required>{{ old('alamat') }}</textarea>
                        </div>
                        <div class="md:col-span-6">
                            <label class="block text-sm font-medium text-slate-700 dark:text-white/80 mb-2">Poin Awal</label>
                            <input type="number" name="poin_member" class="w-full bg-slate-50 dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow text-slate-800 dark:text-white transition-all" placeholder="0" value="{{ old('poin_member', 0) }}" min="0">
                        </div>
                        <div class="md:col-span-6 flex items-end">
                            <div class="flex items-center gap-3 py-2 w-full">
                                <div class="form-check form-switch mb-0 flex items-center gap-2">
                                    <input class="form-check-input h-5 w-10 cursor-pointer" type="checkbox" name="status_member" id="statusMemberTambah" value="1" {{ old('status_member') ? 'checked' : '' }} style="cursor: pointer;">
                                    <label class="form-check-label text-sm font-medium text-slate-700 dark:text-white/80 mb-0 cursor-pointer" for="statusMemberTambah">Aktifkan sebagai Member</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer p-6 border-t border-slate-200 dark:border-white/10 flex justify-end gap-3 bg-slate-50 dark:bg-white/5" style="border: none;">
                    <button type="button" class="px-5 py-2.5 rounded-xl text-sm font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 dark:text-white dark:bg-white/10 dark:hover:bg-white/20 transition-colors border-0" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="px-5 py-2.5 rounded-xl text-sm font-bold text-white bg-borma-purple hover:bg-purple-800 dark:bg-borma-yellow dark:text-slate-900 dark:hover:bg-yellow-500 transition-colors shadow-sm border-0">
                        <i class="fa-solid fa-circle-check mr-1"></i> Simpan Member
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
