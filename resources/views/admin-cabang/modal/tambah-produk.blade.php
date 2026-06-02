<div class="modal fade" id="tambahProdukModal" tabindex="-1" aria-labelledby="tambahProdukModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content" style="border-radius: 20px; border: none; overflow: hidden; box-shadow: 0 10px 40px rgba(0,0,0,0.15);">
      <form action="{{ route('admin-cabang.produk.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-header" style="background: var(--borma-primary); border: none; padding: 24px 32px;">
          <h5 class="modal-title fw-800" id="tambahProdukModalLabel" style="color: var(--borma-secondary); font-family: var(--font-heading);">
            <i class="bi bi-plus-circle-fill me-2"></i> Tambah Produk Baru
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" style="padding: 32px;">
            <div class="row g-3">
                <div class="col-md-8">
                    <label class="modal-label">Nama Produk <span class="text-danger">*</span></label>
                    <input type="text" class="modal-input" name="nama_produk" required placeholder="Contoh: Indomie Goreng">
                </div>
                <div class="col-md-4">
                    <label class="modal-label">Kategori <span class="text-danger">*</span></label>
                    <select class="modal-input form-select" name="kategori" required style="cursor: pointer;">
                        <option value="Kebutuhan Pokok">Kebutuhan Pokok</option>
                        <option value="Minuman">Minuman</option>
                        <option value="Snack">Snack</option>
                        <option value="Kebersihan">Kebersihan</option>
                        <option value="Lain-lain">Lain-lain</option>
                    </select>
                </div>
                <div class="col-12">
                    <label class="modal-label">Deskripsi Produk</label>
                    <textarea class="modal-input" name="deskripsi" rows="2" placeholder="Masukkan deskripsi singkat produk..."></textarea>
                </div>
                <div class="col-12">
                    <label class="modal-label">Gambar Produk <span class="text-muted">(Opsional)</span></label>
                    <input type="file" class="modal-input" name="gambar_produk" accept="image/*" style="padding: 8px 16px;">
                    <div class="form-text mt-1" style="font-size: 0.75rem;">Format: JPG, PNG, WebP. Maks. 2MB.</div>
                </div>
                <div class="col-md-4">
                    <label class="modal-label">Harga Reguler <span class="text-danger">*</span></label>
                    <input type="number" class="modal-input" name="harga_reguler" required placeholder="0" id="tambahHargaReguler">
                </div>
                <div class="col-md-4">
                    <label class="modal-label">Harga Member</label>
                    <input type="number" class="modal-input" name="harga_member" placeholder="Otomatis" id="tambahHargaMember">
                    <div class="form-text mt-1" style="font-size: 0.75rem;">Kosongkan = otomatis dipotong 2% (&lt;50rb) atau Rp 2.000 (&ge;50rb)</div>
                </div>
                <div class="col-md-4">
                    <label class="modal-label">Jumlah Stok <span class="text-danger">*</span></label>
                    <input type="number" class="modal-input" name="jumlah_stok" required placeholder="0">
                </div>
            </div>
        </div>
        <div class="modal-footer" style="border: none; padding: 16px 32px 32px; gap: 12px;">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" style="border-radius: 10px; font-weight: 700; padding: 10px 24px;">Batal</button>
          <button type="submit" class="btn-primary-custom" style="padding: 10px 28px;">
            <i class="bi bi-check-lg me-1"></i> Simpan Produk
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
