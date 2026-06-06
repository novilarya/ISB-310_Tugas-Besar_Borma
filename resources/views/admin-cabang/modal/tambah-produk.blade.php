<div class="modal fade" id="tambahProdukModal" tabindex="-1" aria-labelledby="tambahProdukModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content bg-white dark:bg-slate-900 w-full rounded-3xl shadow-2xl border border-slate-200 dark:border-white/10 overflow-hidden" style="border: none;">
      <form action="{{ route('admin-cabang.produk.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="modal-header bg-slate-50 dark:bg-white/5 border-b border-slate-200 dark:border-white/10 p-6 flex justify-between items-center" style="border: none;">
          <h5 class="modal-title font-bold text-lg text-slate-800 dark:text-white flex items-center gap-2" id="tambahProdukModalLabel">
            <i class="fa-solid fa-circle-plus text-borma-purple dark:text-borma-yellow"></i> Tambah Produk Baru
          </h5>
          <button type="button" class="text-slate-400 hover:text-slate-600 dark:hover:text-white transition-colors border-0 bg-transparent p-0" data-bs-dismiss="modal" aria-label="Close">
            <i class="fa-solid fa-xmark text-xl"></i>
          </button>
        </div>
        
        <div class="modal-body p-6">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                <div class="md:col-span-8">
                    <label class="block text-sm font-medium text-slate-700 dark:text-white/80 mb-2">Nama Produk <span class="text-danger">*</span></label>
                    <input type="text" class="w-full bg-slate-50 dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow text-slate-800 dark:text-white transition-all" name="nama_produk" required placeholder="Contoh: Indomie Goreng">
                </div>
                <div class="md:col-span-4">
                    <label class="block text-sm font-medium text-slate-700 dark:text-white/80 mb-2">Kategori <span class="text-danger">*</span></label>
                    <select class="w-full bg-slate-50 dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow text-slate-800 dark:text-white transition-all" name="kategori" required style="cursor: pointer;">
                        <option value="Kebutuhan Pokok">Kebutuhan Pokok</option>
                        <option value="Minuman">Minuman</option>
                        <option value="Snack">Snack</option>
                        <option value="Kebersihan">Kebersihan</option>
                        <option value="Lain-lain">Lain-lain</option>
                    </select>
                </div>
                <div class="md:col-span-12">
                    <label class="block text-sm font-medium text-slate-700 dark:text-white/80 mb-2">Deskripsi Produk</label>
                    <textarea class="w-full bg-slate-50 dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow text-slate-800 dark:text-white transition-all" name="deskripsi" rows="2" placeholder="Masukkan deskripsi singkat produk..."></textarea>
                </div>
                <div class="md:col-span-12">
                    <label class="block text-sm font-medium text-slate-700 dark:text-white/80 mb-2">Gambar Produk <small class="text-slate-500 dark:text-white/50 text-lowercase">(Opsional)</small></label>
                    <input type="file" class="w-full bg-slate-50 dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow text-slate-800 dark:text-white transition-all" name="gambar_produk" accept="image/*" style="padding: 8px 16px;">
                    <div class="text-xs text-slate-400 dark:text-white/40 mt-1">Format: JPG, PNG, WebP. Maks. 2MB.</div>
                </div>
                <div class="md:col-span-4">
                    <label class="block text-sm font-medium text-slate-700 dark:text-white/80 mb-2">Harga Reguler <span class="text-danger">*</span></label>
                    <input type="number" class="w-full bg-slate-50 dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow text-slate-800 dark:text-white transition-all" name="harga_reguler" required placeholder="0" id="tambahHargaReguler">
                </div>
                <div class="md:col-span-4">
                    <label class="block text-sm font-medium text-slate-700 dark:text-white/80 mb-2">Harga Member</label>
                    <input type="number" class="w-full bg-slate-50 dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow text-slate-800 dark:text-white transition-all" name="harga_member" placeholder="Otomatis" id="tambahHargaMember">
                    <div class="text-xs text-slate-400 dark:text-white/40 mt-1">Kosongkan = otomatis dipotong 2% (<50rb) atau Rp 2.000 (&ge;50rb)</div>
                </div>
                <div class="md:col-span-4">
                    <label class="block text-sm font-medium text-slate-700 dark:text-white/80 mb-2">Jumlah Stok <span class="text-danger">*</span></label>
                    <input type="number" class="w-full bg-slate-50 dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow text-slate-800 dark:text-white transition-all" name="jumlah_stok" required placeholder="0">
                </div>
            </div>
        </div>
        
        <div class="modal-footer p-6 border-t border-slate-200 dark:border-white/10 flex justify-end gap-3 bg-slate-50 dark:bg-white/5" style="border: none;">
          <button type="button" class="px-5 py-2.5 rounded-xl text-sm font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 dark:text-white dark:bg-white/10 dark:hover:bg-white/20 transition-colors border-0" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="px-5 py-2.5 rounded-xl text-sm font-bold text-white bg-borma-purple hover:bg-purple-800 dark:bg-borma-yellow dark:text-slate-900 dark:hover:bg-yellow-500 transition-colors shadow-sm border-0">
            <i class="fa-solid fa-circle-plus mr-1"></i> Simpan Produk
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
