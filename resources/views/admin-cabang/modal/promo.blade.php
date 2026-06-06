{{-- ====== MODAL TAMBAH PROMO ====== --}}
<div class="modal fade" id="tambahPromoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content bg-white dark:bg-slate-900 w-full rounded-3xl shadow-2xl border border-slate-200 dark:border-white/10 overflow-hidden" style="border: none;">
            <div class="modal-header bg-slate-50 dark:bg-white/5 border-b border-slate-200 dark:border-white/10 p-6 flex justify-between items-center" style="border: none;">
                <h5 class="modal-title font-bold text-lg text-slate-800 dark:text-white flex items-center gap-2">
                    <i class="fa-solid fa-circle-plus text-borma-purple dark:text-borma-yellow"></i> Buat Promo Baru
                </h5>
                <button type="button" class="text-slate-400 hover:text-slate-600 dark:hover:text-white transition-colors border-0 bg-transparent p-0" data-bs-dismiss="modal">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>
            
            <form action="{{ route('admin-cabang.promo.store') }}" method="POST">
                @csrf
                <div class="modal-body p-6">
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                        <div class="md:col-span-6">
                            <label class="block text-sm font-medium text-slate-700 dark:text-white/80 mb-2">Nama Promo <span class="text-danger">*</span></label>
                            <input type="text" name="nama_voucher" class="w-full bg-slate-50 dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow text-slate-800 dark:text-white transition-all" placeholder="Contoh: Diskon Akhir Pekan" required>
                        </div>
                        <div class="md:col-span-6">
                            <label class="block text-sm font-medium text-slate-700 dark:text-white/80 mb-2">Kode Voucher <small class="text-slate-500 dark:text-white/50 text-lowercase">(opsional, otomatis huruf kapital)</small></label>
                            <input type="text" name="kode_voucher" class="w-full bg-slate-50 dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow text-slate-800 dark:text-white transition-all" placeholder="Contoh: BORMA10">
                        </div>
                        <div class="md:col-span-6">
                            <label class="block text-sm font-medium text-slate-700 dark:text-white/80 mb-2">Produk Pemicu <span class="text-danger">*</span></label>
                            <select name="id_produk_pemicu" class="w-full bg-slate-50 dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow text-slate-800 dark:text-white transition-all" required style="cursor: pointer;">
                                <option value="">-- Pilih produk --</option>
                                @foreach($produkList as $pc)
                                    <option value="{{ $pc->produk->id_produk }}">{{ $pc->produk->nama_produk }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="md:col-span-3">
                            <label class="block text-sm font-medium text-slate-700 dark:text-white/80 mb-2">Min. Beli Pemicu (pcs) <span class="text-danger">*</span></label>
                            <input type="number" name="kuantitas_pemicu" class="w-full bg-slate-50 dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow text-slate-800 dark:text-white transition-all" value="1" min="1" required>
                        </div>
                        <div class="md:col-span-3">
                            <label class="block text-sm font-medium text-slate-700 dark:text-white/80 mb-2">Kuota Promo <span class="text-danger">*</span></label>
                            <input type="number" name="kuota_promo" class="w-full bg-slate-50 dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow text-slate-800 dark:text-white transition-all" placeholder="100" min="1" required>
                        </div>
                        <div class="md:col-span-6">
                            <label class="block text-sm font-medium text-slate-700 dark:text-white/80 mb-2">Produk Hadiah <small class="text-slate-500 dark:text-white/50 text-lowercase">(opsional)</small></label>
                            <select name="id_produk_hadiah" class="w-full bg-slate-50 dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow text-slate-800 dark:text-white transition-all" style="cursor: pointer;">
                                <option value="">-- Tanpa hadiah produk --</option>
                                @foreach($produkList as $pc)
                                    <option value="{{ $pc->produk->id_produk }}">{{ $pc->produk->nama_produk }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="md:col-span-6">
                            <label class="block text-sm font-medium text-slate-700 dark:text-white/80 mb-2">Kuantitas Hadiah (pcs)</label>
                            <input type="number" name="kuantitas_hadiah" class="w-full bg-slate-50 dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow text-slate-800 dark:text-white transition-all" value="0" min="0">
                        </div>
                        <div class="md:col-span-4">
                            <label class="block text-sm font-medium text-slate-700 dark:text-white/80 mb-2">Potongan Harga (Rp)</label>
                            <input type="number" name="potongan_harga" class="w-full bg-slate-50 dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow text-slate-800 dark:text-white transition-all" placeholder="0" min="0">
                        </div>
                        <div class="md:col-span-4">
                            <label class="block text-sm font-medium text-slate-700 dark:text-white/80 mb-2">Min. Transaksi (Rp)</label>
                            <input type="number" name="min_transaksi" class="w-full bg-slate-50 dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow text-slate-800 dark:text-white transition-all" placeholder="0" min="0">
                        </div>
                        <div class="md:col-span-4">
                            <label class="block text-sm font-medium text-slate-700 dark:text-white/80 mb-2">Maks. Potongan (Rp)</label>
                            <input type="number" name="max_promo" class="w-full bg-slate-50 dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow text-slate-800 dark:text-white transition-all" placeholder="0" min="0">
                        </div>
                        <div class="md:col-span-6">
                            <label class="block text-sm font-medium text-slate-700 dark:text-white/80 mb-2">Tanggal Mulai <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_mulai" class="w-full bg-slate-50 dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow text-slate-800 dark:text-white transition-all" required>
                        </div>
                        <div class="md:col-span-6">
                            <label class="block text-sm font-medium text-slate-700 dark:text-white/80 mb-2">Tanggal Berakhir <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_berakhir" class="w-full bg-slate-50 dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow text-slate-800 dark:text-white transition-all" required>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer p-6 border-t border-slate-200 dark:border-white/10 flex justify-end gap-3 bg-slate-50 dark:bg-white/5" style="border: none;">
                    <button type="button" class="px-5 py-2.5 rounded-xl text-sm font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 dark:text-white dark:bg-white/10 dark:hover:bg-white/20 transition-colors border-0" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="px-5 py-2.5 rounded-xl text-sm font-bold text-white bg-borma-purple hover:bg-purple-800 dark:bg-borma-yellow dark:text-slate-900 dark:hover:bg-yellow-500 transition-colors shadow-sm border-0">
                        <i class="fa-solid fa-circle-plus mr-1"></i> Simpan Promo
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


{{-- ====== MODAL EDIT PROMO ====== --}}
<div class="modal fade" id="editPromoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content bg-white dark:bg-slate-900 w-full rounded-3xl shadow-2xl border border-slate-200 dark:border-white/10 overflow-hidden" style="border: none;">
            <div class="modal-header bg-slate-50 dark:bg-white/5 border-b border-slate-200 dark:border-white/10 p-6 flex justify-between items-center" style="border: none;">
                <h5 class="modal-title font-bold text-lg text-slate-800 dark:text-white flex items-center gap-2">
                    <i class="fa-solid fa-pen-to-square text-borma-purple dark:text-borma-yellow"></i> Edit Promo
                </h5>
                <button type="button" class="text-slate-400 hover:text-slate-600 dark:hover:text-white transition-colors border-0 bg-transparent p-0" data-bs-dismiss="modal">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>
            
            <form id="editPromoForm" action="" method="POST">
                @csrf @method('PUT')
                <div class="modal-body p-6">
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                        <div class="md:col-span-6">
                            <label class="block text-sm font-medium text-slate-700 dark:text-white/80 mb-2">Nama Promo <span class="text-danger">*</span></label>
                            <input type="text" name="nama_voucher" id="eNama" class="w-full bg-slate-50 dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow text-slate-800 dark:text-white transition-all" required>
                        </div>
                        <div class="md:col-span-6">
                            <label class="block text-sm font-medium text-slate-700 dark:text-white/80 mb-2">Kode Voucher <small class="text-slate-500 dark:text-white/50 text-lowercase">(opsional, otomatis huruf kapital)</small></label>
                            <input type="text" name="kode_voucher" id="eKode" class="w-full bg-slate-50 dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow text-slate-800 dark:text-white transition-all">
                        </div>
                        <div class="md:col-span-6">
                            <label class="block text-sm font-medium text-slate-700 dark:text-white/80 mb-2">Produk Pemicu <span class="text-danger">*</span></label>
                            <select name="id_produk_pemicu" id="ePemicu" class="w-full bg-slate-50 dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow text-slate-800 dark:text-white transition-all" required style="cursor: pointer;">
                                <option value="">-- Pilih produk --</option>
                                @foreach($produkList as $pc)
                                    <option value="{{ $pc->produk->id_produk }}">{{ $pc->produk->nama_produk }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="md:col-span-3">
                            <label class="block text-sm font-medium text-slate-700 dark:text-white/80 mb-2">Min. Beli Pemicu (pcs) <span class="text-danger">*</span></label>
                            <input type="number" name="kuantitas_pemicu" id="eQtyPemicu" class="w-full bg-slate-50 dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow text-slate-800 dark:text-white transition-all" min="1" required>
                        </div>
                        <div class="md:col-span-3">
                            <label class="block text-sm font-medium text-slate-700 dark:text-white/80 mb-2">Kuota Promo <span class="text-danger">*</span></label>
                            <input type="number" name="kuota_promo" id="eKuota" class="w-full bg-slate-50 dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow text-slate-800 dark:text-white transition-all" min="1" required>
                        </div>
                        <div class="md:col-span-6">
                            <label class="block text-sm font-medium text-slate-700 dark:text-white/80 mb-2">Produk Hadiah <small class="text-slate-500 dark:text-white/50 text-lowercase">(opsional)</small></label>
                            <select name="id_produk_hadiah" id="eHadiah" class="w-full bg-slate-50 dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow text-slate-800 dark:text-white transition-all" style="cursor: pointer;">
                                <option value="">-- Tanpa hadiah produk --</option>
                                @foreach($produkList as $pc)
                                    <option value="{{ $pc->produk->id_produk }}">{{ $pc->produk->nama_produk }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="md:col-span-6">
                            <label class="block text-sm font-medium text-slate-700 dark:text-white/80 mb-2">Kuantitas Hadiah (pcs)</label>
                            <input type="number" name="kuantitas_hadiah" id="eQtyHadiah" class="w-full bg-slate-50 dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow text-slate-800 dark:text-white transition-all" min="0">
                        </div>
                        <div class="md:col-span-4">
                            <label class="block text-sm font-medium text-slate-700 dark:text-white/80 mb-2">Potongan Harga (Rp)</label>
                            <input type="number" name="potongan_harga" id="ePotongan" class="w-full bg-slate-50 dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow text-slate-800 dark:text-white transition-all" min="0">
                        </div>
                        <div class="md:col-span-4">
                            <label class="block text-sm font-medium text-slate-700 dark:text-white/80 mb-2">Min. Transaksi (Rp)</label>
                            <input type="number" name="min_transaksi" id="eMin" class="w-full bg-slate-50 dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow text-slate-800 dark:text-white transition-all" min="0">
                        </div>
                        <div class="md:col-span-4">
                            <label class="block text-sm font-medium text-slate-700 dark:text-white/80 mb-2">Maks. Potongan (Rp)</label>
                            <input type="number" name="max_promo" id="eMax" class="w-full bg-slate-50 dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow text-slate-800 dark:text-white transition-all" min="0">
                        </div>
                        <div class="md:col-span-6">
                            <label class="block text-sm font-medium text-slate-700 dark:text-white/80 mb-2">Tanggal Mulai <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_mulai" id="eMulai" class="w-full bg-slate-50 dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow text-slate-800 dark:text-white transition-all" required>
                        </div>
                        <div class="md:col-span-6">
                            <label class="block text-sm font-medium text-slate-700 dark:text-white/80 mb-2">Tanggal Berakhir <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_berakhir" id="eBerakhir" class="w-full bg-slate-50 dark:bg-black/20 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-borma-purple dark:focus:ring-borma-yellow text-slate-800 dark:text-white transition-all" required>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer p-6 border-t border-slate-200 dark:border-white/10 flex justify-end gap-3 bg-slate-50 dark:bg-white/5" style="border: none;">
                    <button type="button" class="px-5 py-2.5 rounded-xl text-sm font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 dark:text-white dark:bg-white/10 dark:hover:bg-white/20 transition-colors border-0" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="px-5 py-2.5 rounded-xl text-sm font-bold text-white bg-borma-purple hover:bg-purple-800 dark:bg-borma-yellow dark:text-slate-900 dark:hover:bg-yellow-500 transition-colors shadow-sm border-0">
                        <i class="fa-solid fa-circle-check mr-1"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
