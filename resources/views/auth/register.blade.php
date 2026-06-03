<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Daftar akun Borma Toserba untuk belanja online yang mudah dan hemat.">
    <title>Daftar - Borma Toserba</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .field-warning { border-color: #ef4444 !important; }
        .warning-text { color: #ef4444; font-size: 11px; font-weight: 600; margin-top: 4px; display: none; }
        .warning-text.show { display: block; }
        .field-valid { border-color: #22c55e !important; }
        .pwd-requirements { margin-top: 6px; display: none; }
        .pwd-requirements.show { display: block; }
        .pwd-req-item { font-size: 11px; font-weight: 500; display: flex; align-items: center; gap: 4px; margin-bottom: 2px; color: #a3a3a3; transition: color 0.2s; }
        .pwd-req-item.met { color: #22c55e; }
        .pwd-req-item.unmet { color: #ef4444; }
        .pwd-req-item svg { width: 12px; height: 12px; flex-shrink: 0; }
        .confirm-warning { color: #ef4444; font-size: 11px; font-weight: 600; margin-top: 4px; display: none; }
        .confirm-warning.show { display: block; }
        .dropdown-loading { position: relative; }
        .dropdown-loading::after { content: 'Memuat...'; position: absolute; right: 12px; top: 50%; transform: translateY(-50%); font-size: 11px; color: #a3a3a3; pointer-events: none; }
    </style>
</head>
<body class="min-h-screen bg-primary-800 font-sans antialiased">
    <div class="fixed inset-0 z-0">
        <div class="absolute inset-0 bg-gradient-to-br from-primary-900 via-primary-800 to-primary-700"></div>
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-secondary-400/10 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-tertiary-400/10 rounded-full blur-3xl"></div>
    </div>

    <div class="relative z-10 flex min-h-screen items-center justify-center px-4 py-12">
        <div class="w-full max-w-lg animate-fade-in-up">
            <a href="{{ route('pelanggan.dashboard') }}" class="flex items-center justify-center gap-3 mb-10 group">
                <div class="w-12 h-12 bg-secondary-400 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                    <span class="text-primary-700 font-heading font-extrabold text-xl">B</span>
                </div>
                <div>
                    <h1 class="font-heading font-bold text-2xl tracking-tight text-white leading-none">BORMA</h1>
                    <p class="text-primary-300 text-xs font-medium mt-0.5">Toserba Digital</p>
                </div>
            </a>

            <div class="bg-white rounded-2xl shadow-2xl p-8 sm:p-10">
                <div class="text-center mb-8">
                    <h2 class="font-heading font-bold text-2xl text-neutral-800">Buat Akun Baru</h2>
                    <p class="text-neutral-500 text-sm mt-2">Daftar untuk mulai belanja di Borma</p>
                </div>

                @if ($errors->any())
                <div class="mb-6 bg-tertiary-50 border border-tertiary-200 rounded-xl p-4">
                    <div class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-tertiary-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <ul class="text-tertiary-500 text-sm font-medium space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endif

                <form method="POST" action="{{ route('register.submit') }}" class="space-y-5" id="register-form">
                    @csrf

                    {{-- Nama --}}
                    <div>
                        <label for="nama" class="block text-sm font-semibold text-neutral-700 mb-1.5">Nama Lengkap</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            </div>
                            <input type="text" name="nama" id="nama" value="{{ old('nama') }}" required placeholder="Nama lengkap Anda" class="w-full pl-12 pr-4 py-3 border-2 border-neutral-200 rounded-xl text-sm text-neutral-800 placeholder-neutral-400 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition-all outline-none bg-neutral-50 hover:bg-white focus:bg-white">
                        </div>
                    </div>

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-sm font-semibold text-neutral-700 mb-1.5">Email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </div>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" required placeholder="contoh@gmail.com" class="w-full pl-12 pr-4 py-3 border-2 border-neutral-200 rounded-xl text-sm text-neutral-800 placeholder-neutral-400 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition-all outline-none bg-neutral-50 hover:bg-white focus:bg-white">
                        </div>
                        <p class="warning-text" id="email-warning">Email harus menggunakan @gmail.com (contoh: nama@gmail.com)</p>
                    </div>

                    {{-- Nomor Telepon --}}
                    <div>
                        <label for="no_telepon" class="block text-sm font-semibold text-neutral-700 mb-1.5">Nomor Telepon</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            </div>
                            <input type="text" name="no_telepon" id="no_telepon" value="{{ old('no_telepon') }}" required placeholder="08xxxxxxxxxx" class="w-full pl-12 pr-4 py-3 border-2 border-neutral-200 rounded-xl text-sm text-neutral-800 placeholder-neutral-400 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition-all outline-none bg-neutral-50 hover:bg-white focus:bg-white">
                        </div>
                        <p class="warning-text" id="phone-warning">Nomor telepon hanya boleh angka, minimal 10 digit</p>
                    </div>

                    {{-- Provinsi & Kota --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="provinsi" class="block text-sm font-semibold text-neutral-700 mb-1.5">Provinsi</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                                <select name="provinsi" id="provinsi" required class="w-full pl-12 pr-4 py-3 border-2 border-neutral-200 rounded-xl text-sm text-neutral-800 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition-all outline-none bg-neutral-50 hover:bg-white focus:bg-white appearance-none cursor-pointer">
                                    <option value="">Pilih Provinsi</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label for="kota_kabupaten" class="block text-sm font-semibold text-neutral-700 mb-1.5">Kota / Kabupaten</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                </div>
                                <select name="kota_kabupaten" id="kota_kabupaten" required disabled class="w-full pl-12 pr-4 py-3 border-2 border-neutral-200 rounded-xl text-sm text-neutral-800 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition-all outline-none bg-neutral-50 hover:bg-white focus:bg-white appearance-none cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed">
                                    <option value="">Pilih Kota/Kabupaten</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- Kecamatan --}}
                    <div>
                        <label for="kecamatan" class="block text-sm font-semibold text-neutral-700 mb-1.5">Kecamatan</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <select name="kecamatan" id="kecamatan" required disabled class="w-full pl-12 pr-4 py-3 border-2 border-neutral-200 rounded-xl text-sm text-neutral-800 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition-all outline-none bg-neutral-50 hover:bg-white focus:bg-white appearance-none cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed">
                                <option value="">Pilih Kecamatan</option>
                            </select>
                        </div>
                    </div>

                    {{-- Detail Alamat --}}
                    <div>
                        <label for="alamat" class="block text-sm font-semibold text-neutral-700 mb-1.5">Detail Alamat</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 pt-3 pointer-events-none">
                                <svg class="w-5 h-5 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            </div>
                            <textarea name="alamat" id="alamat" rows="2" required placeholder="Contoh: Perumahan Cemara Jl. Merdeka No.10 RT/RW 001/005" class="w-full pl-12 pr-4 py-3 border-2 border-neutral-200 rounded-xl text-sm text-neutral-800 placeholder-neutral-400 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition-all outline-none bg-neutral-50 hover:bg-white focus:bg-white resize-none">{{ old('alamat') }}</textarea>
                        </div>
                    </div>

                    {{-- Password --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="password" class="block text-sm font-semibold text-neutral-700 mb-1.5">Password</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                </div>
                                <input type="password" name="password" id="password" required placeholder="Min. 8 karakter" class="w-full pl-12 pr-4 py-3 border-2 border-neutral-200 rounded-xl text-sm text-neutral-800 placeholder-neutral-400 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition-all outline-none bg-neutral-50 hover:bg-white focus:bg-white">
                            </div>
                            <div class="pwd-requirements" id="pwd-requirements">
                                <div class="pwd-req-item" id="req-length"><svg viewBox="0 0 20 20" fill="currentColor"><circle cx="10" cy="10" r="4"/></svg> Minimal 8 karakter</div>
                                <div class="pwd-req-item" id="req-upper"><svg viewBox="0 0 20 20" fill="currentColor"><circle cx="10" cy="10" r="4"/></svg> Minimal 1 huruf besar (A-Z)</div>
                                <div class="pwd-req-item" id="req-digit"><svg viewBox="0 0 20 20" fill="currentColor"><circle cx="10" cy="10" r="4"/></svg> Minimal 1 angka (0-9)</div>
                            </div>
                        </div>
                        <div>
                            <label for="password_confirmation" class="block text-sm font-semibold text-neutral-700 mb-1.5">Konfirmasi Password</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                                <input type="password" name="password_confirmation" id="password_confirmation" required placeholder="Ulangi password" class="w-full pl-12 pr-4 py-3 border-2 border-neutral-200 rounded-xl text-sm text-neutral-800 placeholder-neutral-400 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition-all outline-none bg-neutral-50 hover:bg-white focus:bg-white">
                            </div>
                            <p class="confirm-warning" id="confirm-warning">Password konfirmasi tidak cocok</p>
                        </div>
                    </div>

                    <button type="submit" id="register-submit-btn" class="w-full bg-primary-700 text-white font-bold py-3.5 rounded-xl hover:bg-primary-600 active:bg-primary-800 transition-all duration-200 shadow-lg shadow-primary-700/30 hover:shadow-xl hover:-translate-y-0.5 flex items-center justify-center gap-2 mt-2">
                        <span>Daftar Sekarang</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                    </button>
                </form>

                <div class="relative my-8">
                    <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-neutral-200"></div></div>
                    <div class="relative flex justify-center"><span class="px-4 bg-white text-sm text-neutral-400">atau</span></div>
                </div>

                <p class="text-center text-sm text-neutral-500">
                    Sudah memiliki akun?
                    <a href="{{ route('login') }}" class="font-bold text-primary-600 hover:text-primary-700 transition-colors ml-1" id="login-link">Masuk</a>
                </p>
            </div>

            <p class="text-center mt-6">
                <a href="{{ route('pelanggan.dashboard') }}" class="text-sm text-primary-300 hover:text-white transition-colors inline-flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Kembali ke Beranda
                </a>
            </p>
        </div>
    </div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // ====== CLIENT-SIDE VALIDATION ======
    const form = document.getElementById('register-form');
    const submitBtn = document.getElementById('register-submit-btn');
    const emailInput = document.getElementById('email');
    const emailWarning = document.getElementById('email-warning');
    const phoneInput = document.getElementById('no_telepon');
    const phoneWarning = document.getElementById('phone-warning');
    const passwordInput = document.getElementById('password');
    const confirmInput = document.getElementById('password_confirmation');
    const confirmWarning = document.getElementById('confirm-warning');
    const pwdReqs = document.getElementById('pwd-requirements');
    const reqLength = document.getElementById('req-length');
    const reqUpper = document.getElementById('req-upper');
    const reqDigit = document.getElementById('req-digit');

    // --- Email: must end with @gmail.com ---
    function validateEmail() {
        const val = emailInput.value.trim();
        if (val.length > 0 && !val.match(/^[a-zA-Z0-9._%+\-]+@gmail\.com$/)) {
            emailInput.classList.add('field-warning');
            emailInput.classList.remove('field-valid');
            emailWarning.classList.add('show');
            return false;
        } else if (val.length > 0) {
            emailInput.classList.remove('field-warning');
            emailInput.classList.add('field-valid');
            emailWarning.classList.remove('show');
            return true;
        } else {
            emailInput.classList.remove('field-warning', 'field-valid');
            emailWarning.classList.remove('show');
            return false;
        }
    }
    emailInput.addEventListener('input', validateEmail);
    emailInput.addEventListener('blur', validateEmail);

    // --- Phone: digits only, min 10 ---
    function validatePhone() {
        phoneInput.value = phoneInput.value.replace(/[^0-9]/g, '');
        const val = phoneInput.value;
        if (val.length > 0 && val.length < 10) {
            phoneInput.classList.add('field-warning');
            phoneInput.classList.remove('field-valid');
            phoneWarning.classList.add('show');
            return false;
        } else if (val.length >= 10) {
            phoneInput.classList.remove('field-warning');
            phoneInput.classList.add('field-valid');
            phoneWarning.classList.remove('show');
            return true;
        } else {
            phoneInput.classList.remove('field-warning', 'field-valid');
            phoneWarning.classList.remove('show');
            return false;
        }
    }
    phoneInput.addEventListener('input', validatePhone);
    phoneInput.addEventListener('blur', validatePhone);
    // Block paste of non-numeric characters
    phoneInput.addEventListener('paste', function(e) {
        e.preventDefault();
        const paste = (e.clipboardData || window.clipboardData).getData('text');
        this.value = (this.value + paste).replace(/[^0-9]/g, '');
        validatePhone();
    });
    // Block non-numeric keypress
    phoneInput.addEventListener('keypress', function(e) {
        if (!/[0-9]/.test(e.key)) e.preventDefault();
    });

    // --- Password: min 8, 1 uppercase, 1 digit ---
    function validatePassword() {
        const val = passwordInput.value;
        const hasUpper = /[A-Z]/.test(val);
        const hasDigit = /[0-9]/.test(val);
        const hasMinLen = val.length >= 8;

        if (val.length > 0) {
            pwdReqs.classList.add('show');
            // Update requirement indicators
            reqLength.className = 'pwd-req-item ' + (hasMinLen ? 'met' : 'unmet');
            reqUpper.className = 'pwd-req-item ' + (hasUpper ? 'met' : 'unmet');
            reqDigit.className = 'pwd-req-item ' + (hasDigit ? 'met' : 'unmet');

            if (hasUpper && hasDigit && hasMinLen) {
                passwordInput.classList.remove('field-warning');
                passwordInput.classList.add('field-valid');
            } else {
                passwordInput.classList.add('field-warning');
                passwordInput.classList.remove('field-valid');
            }
        } else {
            pwdReqs.classList.remove('show');
            passwordInput.classList.remove('field-warning', 'field-valid');
        }
        // Also revalidate confirm field
        validateConfirm();
        return val.length > 0 && hasUpper && hasDigit && hasMinLen;
    }
    passwordInput.addEventListener('input', validatePassword);
    passwordInput.addEventListener('focus', function() {
        if (this.value.length > 0) pwdReqs.classList.add('show');
    });

    // --- Password confirmation match ---
    function validateConfirm() {
        const val = confirmInput.value;
        const pwd = passwordInput.value;
        if (val.length > 0 && val !== pwd) {
            confirmInput.classList.add('field-warning');
            confirmInput.classList.remove('field-valid');
            confirmWarning.classList.add('show');
            return false;
        } else if (val.length > 0 && val === pwd) {
            confirmInput.classList.remove('field-warning');
            confirmInput.classList.add('field-valid');
            confirmWarning.classList.remove('show');
            return true;
        } else {
            confirmInput.classList.remove('field-warning', 'field-valid');
            confirmWarning.classList.remove('show');
            return false;
        }
    }
    confirmInput.addEventListener('input', validateConfirm);

    // ====== FORM SUBMISSION GUARD ======
    form.addEventListener('submit', function(e) {
        const emailOk = validateEmail();
        const phoneOk = validatePhone();
        const pwdOk = validatePassword();
        const confirmOk = validateConfirm();

        if (!emailOk || !phoneOk || !pwdOk || !confirmOk) {
            e.preventDefault();
            // Scroll to the first invalid field
            const firstInvalid = form.querySelector('.field-warning');
            if (firstInvalid) {
                firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
                firstInvalid.focus();
            }
            // Shake the submit button to indicate error
            submitBtn.style.animation = 'shake 0.4s ease';
            setTimeout(() => submitBtn.style.animation = '', 400);
            return false;
        }
    });

    // ====== CASCADING DROPDOWNS ======
    const provinsiSelect = document.getElementById('provinsi');
    const kotaSelect = document.getElementById('kota_kabupaten');
    const kecamatanSelect = document.getElementById('kecamatan');

    // Loading helper
    function setDropdownLoading(select, loading) {
        const wrapper = select.parentNode;
        if (loading) {
            wrapper.classList.add('dropdown-loading');
            select.disabled = true;
        } else {
            wrapper.classList.remove('dropdown-loading');
        }
    }

    // Fetch provinces from API
    setDropdownLoading(provinsiSelect, true);
    fetch('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json')
        .then(r => r.json())
        .then(data => {
            data.sort((a, b) => a.name.localeCompare(b.name));
            data.forEach(prov => {
                const opt = document.createElement('option');
                opt.value = prov.name;
                opt.textContent = prov.name;
                opt.dataset.id = prov.id;
                if ('{{ old("provinsi") }}' === prov.name) opt.selected = true;
                provinsiSelect.appendChild(opt);
            });
            setDropdownLoading(provinsiSelect, false);
            provinsiSelect.disabled = false;
            // Trigger old value cascade
            if ('{{ old("provinsi") }}') provinsiSelect.dispatchEvent(new Event('change'));
        })
        .catch(() => {
            setDropdownLoading(provinsiSelect, false);
            // Fallback: allow text input if API fails
            const wrapper = provinsiSelect.parentNode;
            const input = document.createElement('input');
            input.type = 'text'; input.name = 'provinsi'; input.id = 'provinsi';
            input.required = true; input.placeholder = 'Ketik provinsi';
            input.className = provinsiSelect.className;
            wrapper.replaceChild(input, provinsiSelect);
        });

    provinsiSelect.addEventListener('change', function() {
        const selected = this.options[this.selectedIndex];
        const provId = selected ? selected.dataset.id : null;
        kotaSelect.innerHTML = '<option value="">Pilih Kota/Kabupaten</option>';
        kecamatanSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
        kotaSelect.disabled = true;
        kecamatanSelect.disabled = true;
        if (!provId) return;

        setDropdownLoading(kotaSelect, true);
        fetch('https://www.emsifa.com/api-wilayah-indonesia/api/regencies/' + provId + '.json')
            .then(r => r.json())
            .then(data => {
                data.sort((a, b) => a.name.localeCompare(b.name));
                data.forEach(kota => {
                    const opt = document.createElement('option');
                    opt.value = kota.name;
                    opt.textContent = kota.name;
                    opt.dataset.id = kota.id;
                    if ('{{ old("kota_kabupaten") }}' === kota.name) opt.selected = true;
                    kotaSelect.appendChild(opt);
                });
                setDropdownLoading(kotaSelect, false);
                kotaSelect.disabled = false;
                if ('{{ old("kota_kabupaten") }}') kotaSelect.dispatchEvent(new Event('change'));
            })
            .catch(() => setDropdownLoading(kotaSelect, false));
    });

    kotaSelect.addEventListener('change', function() {
        const selected = this.options[this.selectedIndex];
        const kotaId = selected ? selected.dataset.id : null;
        kecamatanSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
        kecamatanSelect.disabled = true;
        if (!kotaId) return;

        setDropdownLoading(kecamatanSelect, true);
        fetch('https://www.emsifa.com/api-wilayah-indonesia/api/districts/' + kotaId + '.json')
            .then(r => r.json())
            .then(data => {
                data.sort((a, b) => a.name.localeCompare(b.name));
                data.forEach(kec => {
                    const opt = document.createElement('option');
                    opt.value = kec.name;
                    opt.textContent = kec.name;
                    if ('{{ old("kecamatan") }}' === kec.name) opt.selected = true;
                    kecamatanSelect.appendChild(opt);
                });
                setDropdownLoading(kecamatanSelect, false);
                kecamatanSelect.disabled = false;
            })
            .catch(() => setDropdownLoading(kecamatanSelect, false));
    });
});
</script>

<style>
@keyframes shake {
    0%, 100% { transform: translateX(0); }
    20%, 60% { transform: translateX(-6px); }
    40%, 80% { transform: translateX(6px); }
}
</style>
</body>
</html>
