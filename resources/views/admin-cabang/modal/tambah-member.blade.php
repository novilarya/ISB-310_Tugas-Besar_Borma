<div class="modal fade" id="tambahMemberModal" tabindex="-1" aria-labelledby="tambahMemberLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="border-radius:20px; border:none; overflow:hidden;">
            <div class="modal-header" style="background: var(--borma-primary); border:none; padding:24px 32px;">
                <h5 class="modal-title fw-800" id="tambahMemberLabel" style="color: var(--borma-secondary); font-family: var(--font-heading);">
                    <i class="bi bi-person-plus-fill me-2"></i> Tambah Member Baru
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin-cabang.member.store') }}" method="POST">
                @csrf
                <div class="modal-body" style="padding:32px;">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="modal-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="nama" class="modal-input @error('nama') is-invalid @enderror" placeholder="Masukkan nama lengkap" value="{{ old('nama') }}" required>
                            @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="modal-label">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="modal-input @error('email') is-invalid @enderror" placeholder="contoh@email.com" value="{{ old('email') }}" required>
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="modal-label">No. Telepon <span class="text-danger">*</span></label>
                            <input type="text" name="no_telepon" class="modal-input" placeholder="08xxxxxxxxxx" value="{{ old('no_telepon') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="modal-label">Password <span class="text-danger">*</span></label>
                            <input type="password" name="password" class="modal-input @error('password') is-invalid @enderror" placeholder="Min. 6 karakter" required>
                            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-12">
                            <label class="modal-label">Alamat <span class="text-danger">*</span></label>
                            <textarea name="alamat" rows="2" class="modal-input" placeholder="Alamat lengkap pelanggan" required>{{ old('alamat') }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="modal-label">Poin Awal</label>
                            <input type="number" name="poin_member" class="modal-input" placeholder="0" value="{{ old('poin_member', 0) }}" min="0">
                        </div>
                        <div class="col-md-6 d-flex align-items-end">
                            <div class="d-flex align-items-center gap-3 py-2">
                                <div class="form-check form-switch mb-0">
                                    <input class="form-check-input" type="checkbox" name="status_member" id="statusMemberTambah" value="1" {{ old('status_member') ? 'checked' : '' }}>
                                    <label class="form-check-label modal-label mb-0" for="statusMemberTambah">Aktifkan sebagai Member</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="border:none; padding:16px 32px 32px; gap:12px;">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" style="border-radius:10px; font-weight:700; padding:10px 24px;">Batal</button>
                    <button type="submit" class="btn-primary-custom" style="padding:10px 28px;">
                        <i class="bi bi-check-lg me-1"></i> Simpan Member
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
