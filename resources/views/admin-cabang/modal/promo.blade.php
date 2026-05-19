{{-- ====== MODAL TAMBAH PROMO ====== --}}
<div class="modal fade" id="tambahPromoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content" style="border-radius:20px;border:none;overflow:hidden;">
            <div class="modal-header" style="background:var(--borma-primary);border:none;padding:24px 32px;">
                <h5 class="modal-title fw-800" style="color:var(--borma-secondary);font-family:var(--font-heading);">
                    <i class="bi bi-plus-circle-fill me-2"></i> Buat Promo Baru
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin-cabang.promo.store') }}" method="POST">
                @csrf
                <div class="modal-body" style="padding:32px;">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="modal-label">Nama Promo <span class="text-danger">*</span></label>
                            <input type="text" name="nama_voucher" class="modal-input" placeholder="Contoh: Diskon Akhir Pekan" required>
                        </div>
                        <div class="col-md-6">
                            <label class="modal-label">Kode Voucher <small class="text-muted text-lowercase">(opsional, otomatis huruf kapital)</small></label>
                            <input type="text" name="kode_voucher" class="modal-input" placeholder="Contoh: BORMA10">
                        </div>
                        <div class="col-md-6">
                            <label class="modal-label">Produk Pemicu <span class="text-danger">*</span></label>
                            <select name="id_produk_pemicu" class="modal-input" required>
                                <option value="">-- Pilih produk --</option>
                                @foreach($produkList as $pc)
                                    <option value="{{ $pc->produk->id_produk }}">{{ $pc->produk->nama_produk }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="modal-label">Min. Beli Pemicu (pcs) <span class="text-danger">*</span></label>
                            <input type="number" name="kuantitas_pemicu" class="modal-input" value="1" min="1" required>
                        </div>
                        <div class="col-md-3">
                            <label class="modal-label">Kuota Promo <span class="text-danger">*</span></label>
                            <input type="number" name="kuota_promo" class="modal-input" placeholder="100" min="1" required>
                        </div>
                        <div class="col-md-6">
                            <label class="modal-label">Produk Hadiah <small class="text-muted text-lowercase">(opsional)</small></label>
                            <select name="id_produk_hadiah" class="modal-input">
                                <option value="">-- Tanpa hadiah produk --</option>
                                @foreach($produkList as $pc)
                                    <option value="{{ $pc->produk->id_produk }}">{{ $pc->produk->nama_produk }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="modal-label">Kuantitas Hadiah (pcs)</label>
                            <input type="number" name="kuantitas_hadiah" class="modal-input" value="0" min="0">
                        </div>
                        <div class="col-md-4">
                            <label class="modal-label">Potongan Harga (Rp)</label>
                            <input type="number" name="potongan_harga" class="modal-input" placeholder="0" min="0">
                        </div>
                        <div class="col-md-4">
                            <label class="modal-label">Min. Transaksi (Rp)</label>
                            <input type="number" name="min_transaksi" class="modal-input" placeholder="0" min="0">
                        </div>
                        <div class="col-md-4">
                            <label class="modal-label">Maks. Potongan (Rp)</label>
                            <input type="number" name="max_promo" class="modal-input" placeholder="0" min="0">
                        </div>
                        <div class="col-md-6">
                            <label class="modal-label">Tanggal Mulai <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_mulai" class="modal-input" required>
                        </div>
                        <div class="col-md-6">
                            <label class="modal-label">Tanggal Berakhir <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_berakhir" class="modal-input" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="border:none;padding:16px 32px 32px;gap:12px;">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" style="border-radius:10px;font-weight:700;padding:10px 24px;">Batal</button>
                    <button type="submit" class="btn-primary-custom" style="padding:10px 28px;"><i class="bi bi-check-lg me-1"></i> Simpan Promo</button>
                </div>
            </form>
        </div>
    </div>
</div>


{{-- ====== MODAL EDIT PROMO ====== --}}
<div class="modal fade" id="editPromoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content" style="border-radius:20px;border:none;overflow:hidden;">
            <div class="modal-header" style="background:var(--borma-primary);border:none;padding:24px 32px;">
                <h5 class="modal-title fw-800" style="color:var(--borma-secondary);font-family:var(--font-heading);">
                    <i class="bi bi-pencil-square me-2"></i> Edit Promo
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="editPromoForm" action="" method="POST">
                @csrf @method('PUT')
                <div class="modal-body" style="padding:32px;">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="modal-label">Nama Promo <span class="text-danger">*</span></label>
                            <input type="text" name="nama_voucher" id="eNama" class="modal-input" required>
                        </div>
                        <div class="col-md-6">
                            <label class="modal-label">Kode Voucher</label>
                            <input type="text" name="kode_voucher" id="eKode" class="modal-input">
                        </div>
                        <div class="col-md-6">
                            <label class="modal-label">Produk Pemicu <span class="text-danger">*</span></label>
                            <select name="id_produk_pemicu" id="ePemicu" class="modal-input" required>
                                <option value="">-- Pilih produk --</option>
                                @foreach($produkList as $pc)
                                    <option value="{{ $pc->produk->id_produk }}">{{ $pc->produk->nama_produk }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="modal-label">Min. Beli Pemicu (pcs) <span class="text-danger">*</span></label>
                            <input type="number" name="kuantitas_pemicu" id="eQtyPemicu" class="modal-input" min="1" required>
                        </div>
                        <div class="col-md-3">
                            <label class="modal-label">Kuota Promo <span class="text-danger">*</span></label>
                            <input type="number" name="kuota_promo" id="eKuota" class="modal-input" min="1" required>
                        </div>
                        <div class="col-md-6">
                            <label class="modal-label">Produk Hadiah</label>
                            <select name="id_produk_hadiah" id="eHadiah" class="modal-input">
                                <option value="">-- Tanpa hadiah produk --</option>
                                @foreach($produkList as $pc)
                                    <option value="{{ $pc->produk->id_produk }}">{{ $pc->produk->nama_produk }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="modal-label">Kuantitas Hadiah (pcs)</label>
                            <input type="number" name="kuantitas_hadiah" id="eQtyHadiah" class="modal-input" min="0">
                        </div>
                        <div class="col-md-4">
                            <label class="modal-label">Potongan Harga (Rp)</label>
                            <input type="number" name="potongan_harga" id="ePotongan" class="modal-input" min="0">
                        </div>
                        <div class="col-md-4">
                            <label class="modal-label">Min. Transaksi (Rp)</label>
                            <input type="number" name="min_transaksi" id="eMin" class="modal-input" min="0">
                        </div>
                        <div class="col-md-4">
                            <label class="modal-label">Maks. Potongan (Rp)</label>
                            <input type="number" name="max_promo" id="eMax" class="modal-input" min="0">
                        </div>
                        <div class="col-md-6">
                            <label class="modal-label">Tanggal Mulai <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_mulai" id="eMulai" class="modal-input" required>
                        </div>
                        <div class="col-md-6">
                            <label class="modal-label">Tanggal Berakhir <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_berakhir" id="eBerakhir" class="modal-input" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="border:none;padding:16px 32px 32px;gap:12px;">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" style="border-radius:10px;font-weight:700;padding:10px 24px;">Batal</button>
                    <button type="submit" class="btn-primary-custom" style="padding:10px 28px;"><i class="bi bi-check-lg me-1"></i> Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
