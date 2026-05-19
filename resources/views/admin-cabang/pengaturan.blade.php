@extends('admin-cabang.layouts.admin-cabang')
@section('title', 'Pengaturan - Borma Toserba')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin-cabang.css') }}">
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<style>
/* ===== SETTINGS PAGE ===== */
.settings-nav-link {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 16px;
    border-radius: 10px;
    text-decoration: none;
    color: #6B7280;
    font-weight: 700;
    font-size: 0.88rem;
    transition: all 0.2s ease;
    border: 1.5px solid transparent;
}
.settings-nav-link:hover {
    background: rgba(51,17,108,0.05);
    color: var(--borma-primary);
}
.settings-nav-link.active {
    background: rgba(51,17,108,0.08);
    color: var(--borma-primary);
    border-color: rgba(51,17,108,0.15);
}
.settings-nav-link i {
    font-size: 1.1rem;
    width: 20px;
    text-align: center;
}
.settings-nav-badge {
    margin-left: auto;
    background: var(--borma-tertiary);
    color: white;
    font-size: 0.65rem;
    font-weight: 800;
    padding: 2px 7px;
    border-radius: 20px;
}
.settings-panel { display: none; }
.settings-panel.active { display: block; }

.settings-section-title {
    font-size: 1.15rem;
    font-weight: 800;
    color: var(--borma-neutral);
    margin-bottom: 4px;
}
.settings-section-sub {
    font-size: 0.82rem;
    color: #9CA3AF;
    margin-bottom: 24px;
}
.settings-divider {
    border: none;
    border-top: 1px solid #F3F4F6;
    margin: 28px 0;
}
.setting-field-label {
    font-size: 0.78rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #374151;
    margin-bottom: 6px;
    display: block;
}
.setting-input {
    width: 100%;
    padding: 10px 14px;
    border: 1.5px solid #E5E7EB;
    border-radius: 10px;
    font-size: 0.88rem;
    font-weight: 600;
    outline: none;
    transition: all 0.2s ease;
    font-family: var(--font-body);
    background: #fff;
    color: var(--borma-neutral);
}
.setting-input:focus {
    border-color: var(--borma-primary);
    box-shadow: 0 0 0 4px rgba(51,17,108,0.08);
}
.setting-input:disabled {
    background: #F9FAFB;
    color: #9CA3AF;
    cursor: not-allowed;
}
.setting-input-hint {
    font-size: 0.75rem;
    color: #9CA3AF;
    margin-top: 5px;
}

/* Avatar Upload */
.avatar-upload-wrap {
    display: flex;
    align-items: center;
    gap: 24px;
    padding: 20px;
    background: #F9FAFB;
    border-radius: 12px;
    border: 1.5px dashed #E5E7EB;
    margin-bottom: 24px;
}
.avatar-circle {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--borma-primary), #6B21A8);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    color: white;
    font-weight: 800;
    flex-shrink: 0;
    font-family: var(--font-heading);
}
.avatar-info h6 {
    font-weight: 800;
    margin-bottom: 4px;
    font-size: 0.9rem;
}
.avatar-info p {
    font-size: 0.78rem;
    color: #9CA3AF;
    margin-bottom: 10px;
}

/* Cabang Info Card */
.branch-info-card {
    background: linear-gradient(135deg, var(--borma-primary) 0%, #1c093d 100%);
    border-radius: 14px;
    padding: 24px;
    color: white;
    margin-bottom: 24px;
    position: relative;
    overflow: hidden;
}
.branch-info-card::after {
    content: '';
    position: absolute;
    right: -40px; top: -40px;
    width: 180px; height: 180px;
    background: rgba(254,213,11,0.07);
    border-radius: 50%;
}
.branch-info-card .branch-name {
    font-family: var(--font-heading);
    font-size: 1.4rem;
    font-weight: 800;
    color: var(--borma-secondary);
    margin-bottom: 6px;
}
.branch-info-card .branch-code {
    font-size: 0.75rem;
    background: rgba(255,255,255,0.1);
    display: inline-block;
    padding: 3px 10px;
    border-radius: 20px;
    font-weight: 700;
    margin-bottom: 12px;
}
.branch-info-card .branch-address {
    font-size: 0.85rem;
    color: rgba(255,255,255,0.75);
    line-height: 1.5;
}

/* Keamanan */
.security-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 18px 0;
    border-bottom: 1px solid #F3F4F6;
}
.security-item:last-child { border-bottom: none; }
.security-item-info h6 {
    font-weight: 800;
    font-size: 0.9rem;
    margin-bottom: 3px;
    color: var(--borma-neutral);
}
.security-item-info p {
    font-size: 0.78rem;
    color: #9CA3AF;
    margin: 0;
}
.security-status {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 0.78rem;
    font-weight: 700;
}
.security-status.ok { color: #059669; }
.security-status.warn { color: #D97706; }

/* Toggle Switch */
.toggle-wrap {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 0;
    border-bottom: 1px solid #F3F4F6;
}
.toggle-wrap:last-child { border-bottom: none; }
.toggle-info h6 {
    font-weight: 800;
    font-size: 0.88rem;
    margin-bottom: 3px;
    color: var(--borma-neutral);
}
.toggle-info p {
    font-size: 0.77rem;
    color: #9CA3AF;
    margin: 0;
}
.toggle-switch {
    position: relative;
    width: 44px;
    height: 24px;
    flex-shrink: 0;
}
.toggle-switch input { opacity: 0; width: 0; height: 0; }
.toggle-slider {
    position: absolute;
    inset: 0;
    background: #E5E7EB;
    border-radius: 24px;
    cursor: pointer;
    transition: 0.25s;
}
.toggle-slider::before {
    content: '';
    position: absolute;
    width: 18px; height: 18px;
    left: 3px; top: 3px;
    background: white;
    border-radius: 50%;
    transition: 0.25s;
    box-shadow: 0 1px 4px rgba(0,0,0,0.15);
}
.toggle-switch input:checked + .toggle-slider { background: var(--borma-primary); }
.toggle-switch input:checked + .toggle-slider::before { transform: translateX(20px); }

/* Save bar */
.settings-save-bar {
    display: flex;
    justify-content: flex-end;
    gap: 12px;
    padding-top: 24px;
    margin-top: 8px;
    border-top: 1px solid #F3F4F6;
}
</style>
@endpush

@section('content')
<div class="d-flex justify-content-between align-items-end mb-4">
    <div>
        <h1 class="page-title mb-1">Pengaturan</h1>
        <p class="page-subtitle">Konfigurasi akun, operasional cabang, dan preferensi aplikasi.</p>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show mb-4" role="alert" style="border-radius: 12px; border: none; font-weight: 600;">
    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show mb-4" role="alert" style="border-radius: 12px; border: none; font-weight: 600;">
    <i class="bi bi-x-circle-fill me-2"></i> {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif


<div class="row g-4">
    {{-- Sidebar Nav --}}
    <div class="col-md-3">
        <div class="glass-card p-3">
            <p class="kpi-title mb-3">Menu Pengaturan</p>
            <nav class="d-flex flex-column gap-1">
                <a href="#" class="settings-nav-link active" data-tab="profil">
                    <i class="bi bi-person-circle"></i> Profil Akun
                </a>
                <a href="#" class="settings-nav-link" data-tab="cabang">
                    <i class="bi bi-shop"></i> Info Cabang
                </a>
                <a href="#" class="settings-nav-link" data-tab="keamanan">
                    <i class="bi bi-shield-lock"></i> Keamanan
                </a>
                <a href="#" class="settings-nav-link" data-tab="notifikasi">
                    <i class="bi bi-bell"></i> Notifikasi
                    <span class="settings-nav-badge">3</span>
                </a>
            </nav>
        </div>
    </div>

    {{-- Main Panel --}}
    <div class="col-md-9">

        {{-- === PROFIL AKUN === --}}
        <div id="tab-profil" class="settings-panel active">
            <div class="glass-card">
                <p class="settings-section-title">Profil Akun</p>
                <p class="settings-section-sub">Kelola informasi pribadi dan tampilan profil Anda.</p>

                <div class="avatar-upload-wrap">
                    <div class="avatar-circle">AA</div>
                    <div class="avatar-info">
                        <h6>Foto Profil</h6>
                        <p>JPG, PNG maks. 2MB. Dimensi min. 200×200px.</p>
                        <button class="btn-action btn-action-outline btn-action-sm">
                            <i class="bi bi-upload me-1"></i> Unggah Foto
                        </button>
                    </div>
                </div>

                <form action="{{ route('admin-cabang.pengaturan.profil') }}" method="POST">
                    @csrf
                    <div class="row g-3 mb-2">
                        <div class="col-md-6">
                            <label class="setting-field-label">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" class="setting-input" value="{{ $admin->nama ?? '' }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="setting-field-label">Nama Tampilan</label>
                            <input type="text" name="nama_tampilan" class="setting-input" value="{{ $admin->settings['nama_tampilan'] ?? '' }}">
                        </div>
                        <div class="col-md-6">
                            <label class="setting-field-label">Alamat Email</label>
                            <input type="email" name="email" class="setting-input" value="{{ $admin->email ?? '' }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="setting-field-label">Nomor Telepon</label>
                            <input type="text" name="telepon" class="setting-input" value="{{ $admin->no_telepon ?? '' }}">
                        </div>
                        <div class="col-md-6">
                            <label class="setting-field-label">Role Akses</label>
                            <input type="text" class="setting-input" value="{{ $admin->role ?? 'Manager Cabang' }}" disabled>
                            <p class="setting-input-hint">Role ditentukan oleh administrator pusat.</p>
                        </div>
                        <div class="col-md-6">
                            <label class="setting-field-label">Jabatan</label>
                            <input type="text" name="jabatan" class="setting-input" value="{{ $admin->settings['jabatan'] ?? '' }}">
                        </div>
                        <div class="col-12">
                            <label class="setting-field-label">Bio Singkat</label>
                            <textarea name="bio" class="setting-input" rows="3" placeholder="Tuliskan bio singkat...">{{ $admin->settings['bio'] ?? '' }}</textarea>
                        </div>
                    </div>
                    <div class="settings-save-bar">
                        <button type="reset" class="btn-action btn-action-outline">Reset</button>
                        <button type="submit" class="btn-action btn-action-primary">
                            <i class="bi bi-save me-2"></i> Simpan Profil
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- === INFO CABANG === --}}
        <div id="tab-cabang" class="settings-panel">
            <div class="glass-card">
                <p class="settings-section-title">Info Cabang</p>
                <p class="settings-section-sub">Informasi identitas dan operasional cabang Anda.</p>

                <div class="branch-info-card">
                    <div class="branch-code">CBR-00{{ $cabang->id_cabang ?? '1' }}</div>
                    <div class="branch-name">{{ $cabang->nama_cabang ?? 'Nama Cabang' }}</div>
                    <div class="branch-address">
                        <i class="bi bi-geo-alt-fill me-1"></i>
                        {{ $cabang->alamat_cabang ?? 'Alamat Cabang' }}
                    </div>
                </div>

                <form action="{{ route('admin-cabang.pengaturan.cabang') }}" method="POST">
                    @csrf
                    <div class="row g-3 mb-2">
                        <div class="col-md-6">
                            <label class="setting-field-label">Nama Cabang</label>
                            <input type="text" name="nama_cabang" class="setting-input" value="{{ $cabang->nama_cabang ?? '' }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="setting-field-label">Kode Cabang</label>
                            <input type="text" class="setting-input" value="CBR-00{{ $cabang->id_cabang ?? '1' }}" disabled>
                            <p class="setting-input-hint">Kode cabang diatur oleh sistem pusat.</p>
                        </div>
                        <div class="col-12">
                            <label class="setting-field-label">Alamat Lengkap</label>
                            <textarea name="alamat" class="setting-input" rows="2" required>{{ $cabang->alamat_cabang ?? '' }}</textarea>
                        </div>
                        <div class="col-md-4">
                            <label class="setting-field-label">Kota</label>
                            <input type="text" name="kota" class="setting-input" value="{{ $cabang->settings['kota'] ?? '' }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="setting-field-label">Provinsi</label>
                            <input type="text" name="provinsi" class="setting-input" value="{{ $cabang->settings['provinsi'] ?? '' }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="setting-field-label">Kode Pos</label>
                            <input type="text" name="kode_pos" class="setting-input" value="{{ $cabang->settings['kode_pos'] ?? '' }}">
                        </div>
                        <div class="col-md-6">
                            <label class="setting-field-label">Nomor Telepon Cabang</label>
                            <input type="text" name="telepon" class="setting-input" value="{{ $cabang->settings['telepon'] ?? '' }}">
                        </div>
                        <div class="col-md-6">
                            <label class="setting-field-label">Email Cabang</label>
                            <input type="email" name="email_cabang" class="setting-input" value="{{ $cabang->settings['email_cabang'] ?? '' }}">
                        </div>
                        <div class="col-md-6">
                            <label class="setting-field-label">Jam Buka</label>
                            <input type="time" name="jam_buka" class="setting-input" value="{{ $cabang->settings['jam_buka'] ?? '' }}">
                        </div>
                        <div class="col-md-6">
                            <label class="setting-field-label">Jam Tutup</label>
                            <input type="time" name="jam_tutup" class="setting-input" value="{{ $cabang->settings['jam_tutup'] ?? '' }}">
                        </div>
                        <div class="col-12">
                            <label class="setting-field-label">Deskripsi Cabang</label>
                            <textarea name="deskripsi" class="setting-input" rows="2" placeholder="Deskripsi singkat cabang...">{{ $cabang->settings['deskripsi'] ?? '' }}</textarea>
                        </div>
                    </div>
                    <div class="settings-save-bar">
                        <button type="reset" class="btn-action btn-action-outline">Reset</button>
                        <button type="submit" class="btn-action btn-action-primary">
                            <i class="bi bi-save me-2"></i> Simpan Info Cabang
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- === KEAMANAN === --}}
        <div id="tab-keamanan" class="settings-panel">
            <div class="glass-card mb-4">
                <p class="settings-section-title">Ubah Password</p>
                <p class="settings-section-sub">Pastikan akun Anda menggunakan password yang kuat dan unik.</p>
                <form action="{{ route('admin-cabang.pengaturan.password') }}" method="POST">
                    @csrf
                    <div class="row g-3 mb-2">
                        <div class="col-12">
                            <label class="setting-field-label">Password Saat Ini</label>
                            <input type="password" name="password_lama" class="setting-input" placeholder="Masukkan password saat ini" required>
                        </div>
                        <div class="col-md-6">
                            <label class="setting-field-label">Password Baru</label>
                            <input type="password" name="password_baru" class="setting-input" placeholder="Min. 8 karakter" required>
                        </div>
                        <div class="col-md-6">
                            <label class="setting-field-label">Konfirmasi Password Baru</label>
                            <input type="password" name="password_baru_confirmation" class="setting-input" placeholder="Ulangi password baru" required>
                        </div>
                    </div>
                    <div class="settings-save-bar">
                        <button type="submit" class="btn-action btn-action-primary">
                            <i class="bi bi-lock me-2"></i> Perbarui Password
                        </button>
                    </div>
                </form>
            </div>

            <div class="glass-card">
                <p class="settings-section-title">Status Keamanan Akun</p>
                <p class="settings-section-sub">Pantau dan kelola keamanan akun Anda.</p>

                <div class="security-item">
                    <div class="security-item-info">
                        <h6>Autentikasi Dua Faktor (2FA)</h6>
                        <p>Tambah lapisan keamanan ekstra lewat aplikasi authenticator.</p>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <span class="security-status warn"><i class="bi bi-exclamation-circle-fill"></i> Belum Aktif</span>
                        <button class="btn-action btn-action-outline btn-action-sm">Aktifkan</button>
                    </div>
                </div>

                <div class="security-item">
                    <div class="security-item-info">
                        <h6>Sesi Login Aktif</h6>
                        <p>Terakhir login: Bandung, ID — Chrome / MacOS</p>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <span class="security-status ok"><i class="bi bi-check-circle-fill"></i> Aktif</span>
                        <button class="btn-action btn-action-outline btn-action-sm">Kelola Sesi</button>
                    </div>
                </div>

                <div class="security-item">
                    <div class="security-item-info">
                        <h6>Log Aktivitas Akun</h6>
                        <p>Riwayat login dan perubahan akun selama 30 hari terakhir.</p>
                    </div>
                    <div>
                        <button class="btn-action btn-action-outline btn-action-sm">Lihat Log</button>
                    </div>
                </div>

                <div class="security-item">
                    <div class="security-item-info">
                        <h6>Kekuatan Password</h6>
                        <p>Password terakhir diubah 30 hari yang lalu.</p>
                    </div>
                    <span class="security-status ok"><i class="bi bi-shield-fill-check"></i> Kuat</span>
                </div>
            </div>
        </div>

        {{-- === NOTIFIKASI === --}}
        <div id="tab-notifikasi" class="settings-panel">
            @php $nPrefs = $admin->settings['notifikasi'] ?? []; @endphp
            <form action="{{ route('admin-cabang.pengaturan.notifikasi') }}" method="POST">
                @csrf
                <div class="glass-card mb-4">
                    <p class="settings-section-title">Notifikasi Pesanan</p>
                    <p class="settings-section-sub">Atur kapan Anda menerima notifikasi terkait pesanan.</p>

                    <div class="toggle-wrap">
                        <div class="toggle-info">
                            <h6>Pesanan Masuk</h6>
                            <p>Notifikasi saat ada pesanan baru yang masuk.</p>
                        </div>
                        <label class="toggle-switch">
                            <input type="checkbox" name="notif_pesanan_masuk" value="1" {{ isset($nPrefs['notif_pesanan_masuk']) || empty($nPrefs) ? 'checked' : '' }}>
                            <span class="toggle-slider"></span>
                        </label>
                    </div>
                    <div class="toggle-wrap">
                        <div class="toggle-info">
                            <h6>Perubahan Status Pesanan</h6>
                            <p>Notifikasi saat status pesanan diperbarui pelanggan.</p>
                        </div>
                        <label class="toggle-switch">
                            <input type="checkbox" name="notif_status_pesanan" value="1" {{ isset($nPrefs['notif_status_pesanan']) || empty($nPrefs) ? 'checked' : '' }}>
                            <span class="toggle-slider"></span>
                        </label>
                    </div>
                    <div class="toggle-wrap">
                        <div class="toggle-info">
                            <h6>Pesanan Dibatalkan</h6>
                            <p>Notifikasi saat pelanggan membatalkan pesanan.</p>
                        </div>
                        <label class="toggle-switch">
                            <input type="checkbox" name="notif_pesanan_batal" value="1" {{ isset($nPrefs['notif_pesanan_batal']) || empty($nPrefs) ? 'checked' : '' }}>
                            <span class="toggle-slider"></span>
                        </label>
                    </div>
                </div>

                <div class="glass-card mb-4">
                    <p class="settings-section-title">Notifikasi Stok & Produk</p>
                    <p class="settings-section-sub">Atur peringatan terkait stok dan produk.</p>

                    <div class="toggle-wrap">
                        <div class="toggle-info">
                            <h6>Peringatan Stok Menipis</h6>
                            <p>Notifikasi saat stok produk di bawah ambang batas.</p>
                        </div>
                        <label class="toggle-switch">
                            <input type="checkbox" name="notif_stok_menipis" value="1" {{ isset($nPrefs['notif_stok_menipis']) || empty($nPrefs) ? 'checked' : '' }}>
                            <span class="toggle-slider"></span>
                        </label>
                    </div>
                    <div class="toggle-wrap">
                        <div class="toggle-info">
                            <h6>Produk Baru Ditambahkan</h6>
                            <p>Notifikasi saat produk baru ditambahkan ke katalog cabang.</p>
                        </div>
                        <label class="toggle-switch">
                            <input type="checkbox" name="notif_produk_baru" value="1" {{ isset($nPrefs['notif_produk_baru']) ? 'checked' : '' }}>
                            <span class="toggle-slider"></span>
                        </label>
                    </div>
                </div>

                <div class="glass-card mb-4">
                    <p class="settings-section-title">Notifikasi Promosi & Voucher</p>
                    <p class="settings-section-sub">Kelola notifikasi terkait promo yang aktif.</p>

                    <div class="toggle-wrap">
                        <div class="toggle-info">
                            <h6>Promo Akan Berakhir</h6>
                            <p>Ingatkan 1 hari sebelum periode promo berakhir.</p>
                        </div>
                        <label class="toggle-switch">
                            <input type="checkbox" name="notif_promo_berakhir" value="1" {{ isset($nPrefs['notif_promo_berakhir']) || empty($nPrefs) ? 'checked' : '' }}>
                            <span class="toggle-slider"></span>
                        </label>
                    </div>
                    <div class="toggle-wrap">
                        <div class="toggle-info">
                            <h6>Voucher Habis Diklaim</h6>
                            <p>Notifikasi saat kuota voucher sudah habis terklaim.</p>
                        </div>
                        <label class="toggle-switch">
                            <input type="checkbox" name="notif_voucher_habis" value="1" {{ isset($nPrefs['notif_voucher_habis']) ? 'checked' : '' }}>
                            <span class="toggle-slider"></span>
                        </label>
                    </div>
                </div>

                <div class="glass-card">
                    <p class="settings-section-title">Saluran Notifikasi</p>
                    <p class="settings-section-sub">Pilih bagaimana Anda ingin menerima notifikasi.</p>

                    <div class="toggle-wrap">
                        <div class="toggle-info">
                            <h6><i class="bi bi-bell-fill me-2 text-primary-custom"></i>Notifikasi Dalam Aplikasi</h6>
                            <p>Tampilkan notifikasi langsung di dashboard.</p>
                        </div>
                        <label class="toggle-switch">
                            <input type="checkbox" name="channel_app" value="1" {{ isset($nPrefs['channel_app']) || empty($nPrefs) ? 'checked' : '' }}>
                            <span class="toggle-slider"></span>
                        </label>
                    </div>
                    <div class="toggle-wrap">
                        <div class="toggle-info">
                            <h6><i class="bi bi-envelope-fill me-2 text-primary-custom"></i>Email</h6>
                            <p>Kirim ringkasan notifikasi ke email cabang.</p>
                        </div>
                        <label class="toggle-switch">
                            <input type="checkbox" name="channel_email" value="1" {{ isset($nPrefs['channel_email']) || empty($nPrefs) ? 'checked' : '' }}>
                            <span class="toggle-slider"></span>
                        </label>
                    </div>
                    <div class="toggle-wrap">
                        <div class="toggle-info">
                            <h6><i class="bi bi-phone-fill me-2 text-primary-custom"></i>SMS / WhatsApp</h6>
                            <p>Kirim notifikasi penting ke nomor telepon terdaftar.</p>
                        </div>
                        <label class="toggle-switch">
                            <input type="checkbox" name="channel_sms" value="1" {{ isset($nPrefs['channel_sms']) ? 'checked' : '' }}>
                            <span class="toggle-slider"></span>
                        </label>
                    </div>
                    <div class="settings-save-bar">
                        <button type="submit" class="btn-action btn-action-primary">
                            <i class="bi bi-save me-2"></i> Simpan Preferensi
                        </button>
                    </div>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/admin-cabang.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const navLinks = document.querySelectorAll('.settings-nav-link');
    const panels   = document.querySelectorAll('.settings-panel');

    navLinks.forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            const tab = this.dataset.tab;

            navLinks.forEach(l => l.classList.remove('active'));
            panels.forEach(p => p.classList.remove('active'));

            this.classList.add('active');
            document.getElementById('tab-' + tab).classList.add('active');
        });
    });
});
</script>
@endpush
