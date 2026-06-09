@extends('layouts.pelanggan')

@section('title', 'Edit Profil')

@section('content')
<div class="max-w-3xl mx-auto space-y-8 pb-10">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-end justify-between border-b border-neutral-200 pb-5 gap-4">
        <div>
            <h2 class="font-heading font-extrabold text-3xl text-neutral-800 uppercase tracking-tight">Edit Profil</h2>
            <div class="w-16 h-1.5 bg-secondary-400 mt-3 rounded-full"></div>
        </div>
        <a href="{{ route('pelanggan.profil') }}" class="text-primary-600 font-bold text-sm hover:text-primary-800 transition-colors flex items-center gap-1.5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            Kembali ke Profil
        </a>
    </div>

    <!-- Alert Error Validation -->
    @if ($errors->any())
    <div class="bg-amber-50 border border-amber-200 rounded-xl p-4">
        <div class="flex items-start gap-2">
            <svg class="w-5 h-5 text-amber-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <ul class="text-amber-700 text-sm font-medium space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif

    <!-- Form Container -->
    <div class="bg-white rounded-3xl border border-neutral-200 p-6 sm:p-8 shadow-sm">
        <form method="POST" action="{{ route('pelanggan.profil.update') }}" class="space-y-6" id="edit-profile-form" autocomplete="off">
            @csrf

            <!-- Section Info Profil -->
            <div>
                <h3 class="font-heading font-extrabold text-lg text-neutral-800 mb-4 pb-2 border-b border-neutral-100">Informasi Pribadi</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    
                    {{-- Nama --}}
                    <div>
                        <label for="nama" class="block text-xs font-bold text-neutral-500 uppercase tracking-wider mb-1.5">Nama Lengkap</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            </div>
                            <input type="text" name="nama" id="nama" value="{{ old('nama', $user->nama) }}" required placeholder="Nama lengkap Anda" class="w-full pl-12 pr-4 py-3 border-2 border-neutral-200 rounded-xl text-sm text-neutral-800 placeholder-neutral-400 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition-all outline-none bg-neutral-50 hover:bg-white focus:bg-white" autocomplete="off">
                        </div>
                    </div>

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-xs font-bold text-neutral-500 uppercase tracking-wider mb-1.5">Email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </div>
                            <input type="email" id="email" value="{{ $user->email }}" disabled class="w-full pl-12 pr-4 py-3 border-2 border-neutral-100 bg-neutral-50 rounded-xl text-sm text-neutral-400 cursor-not-allowed outline-none">
                        </div>
                        <p class="text-[10px] text-neutral-400 mt-1">Email utama tidak dapat diubah.</p>
                    </div>

                    {{-- Nomor Telepon --}}
                    <div class="md:col-span-2">
                        <label for="no_telepon" class="block text-xs font-bold text-neutral-500 uppercase tracking-wider mb-1.5">Nomor Telepon</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            </div>
                            <input type="text" name="no_telepon" id="no_telepon" value="{{ old('no_telepon', $user->no_telepon === '-' ? '' : $user->no_telepon) }}" required placeholder="08xxxxxxxxxx" class="w-full pl-12 pr-4 py-3 border-2 border-neutral-200 rounded-xl text-sm text-neutral-800 placeholder-neutral-400 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition-all outline-none bg-neutral-50 hover:bg-white focus:bg-white" autocomplete="off">
                        </div>
                        <p class="warning-text text-xs text-red-500 mt-1 hidden" id="phone-warning">Nomor telepon hanya boleh angka, minimal 10 digit</p>
                    </div>

                </div>
            </div>

            <!-- Section Alamat -->
            <div class="pt-4">
                <h3 class="font-heading font-extrabold text-lg text-neutral-800 mb-4 pb-2 border-b border-neutral-100">Alamat Pengiriman</h3>
                <div class="space-y-5">
                    
                    {{-- Provinsi & Kota --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label for="provinsi" class="block text-xs font-bold text-neutral-500 uppercase tracking-wider mb-1.5">Provinsi</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                                <select name="provinsi" id="provinsi" required class="w-full pl-12 pr-10 py-3 border-2 border-neutral-200 rounded-xl text-sm text-neutral-800 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition-all outline-none bg-neutral-50 hover:bg-white focus:bg-white appearance-none cursor-pointer">
                                    <option value="">Pilih Provinsi</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-neutral-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                </div>
                            </div>
                        </div>
                        <div>
                            <label for="kota_kabupaten" class="block text-xs font-bold text-neutral-500 uppercase tracking-wider mb-1.5">Kota / Kabupaten</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                </div>
                                <select name="kota_kabupaten" id="kota_kabupaten" required disabled class="w-full pl-12 pr-10 py-3 border-2 border-neutral-200 rounded-xl text-sm text-neutral-800 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition-all outline-none bg-neutral-50 hover:bg-white focus:bg-white appearance-none cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed">
                                    <option value="">Pilih Kota/Kabupaten</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-neutral-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Kecamatan --}}
                    <div>
                        <label for="kecamatan" class="block text-xs font-bold text-neutral-500 uppercase tracking-wider mb-1.5">Kecamatan</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <select name="kecamatan" id="kecamatan" required disabled class="w-full pl-12 pr-10 py-3 border-2 border-neutral-200 rounded-xl text-sm text-neutral-800 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition-all outline-none bg-neutral-50 hover:bg-white focus:bg-white appearance-none cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed">
                                <option value="">Pilih Kecamatan</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-neutral-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </div>
                        </div>
                    </div>

                    {{-- Detail Alamat --}}
                    <div>
                        <label for="alamat" class="block text-xs font-bold text-neutral-500 uppercase tracking-wider mb-1.5">Detail Alamat</label>
                        <div class="relative">
                            <textarea name="alamat" id="alamat" rows="4" required placeholder="Contoh: Jl. Dago No. 123 RT 01 RW 02" class="w-full px-4 py-3 border-2 border-neutral-200 rounded-xl text-sm text-neutral-800 placeholder-neutral-400 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition-all outline-none bg-neutral-50 hover:bg-white focus:bg-white resize-none">{{ old('alamat', $pelanggan->alamat === '-' ? '' : $pelanggan->alamat) }}</textarea>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Section Ubah Password (Opsional) -->
            <div class="pt-4">
                <h3 class="font-heading font-extrabold text-lg text-neutral-800 mb-1 pb-2 border-b border-neutral-100">Ubah Password <span class="text-xs font-normal text-neutral-400">(Opsional)</span></h3>
                <p class="text-neutral-400 text-xs mb-4">Kosongkan jika Anda tidak ingin mengubah password akun Anda.</p>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    
                    {{-- Password Baru --}}
                    <div>
                        <label for="password" class="block text-xs font-bold text-neutral-500 uppercase tracking-wider mb-1.5">Password Baru</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            </div>
                            <input type="password" name="password" id="password" placeholder="Password baru" class="w-full pl-12 pr-12 py-3 border-2 border-neutral-200 rounded-xl text-sm text-neutral-800 placeholder-neutral-400 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition-all outline-none bg-neutral-50 hover:bg-white focus:bg-white" autocomplete="new-password">
                            <button type="button" id="toggle-password" class="absolute inset-y-0 right-0 pr-4 flex items-center text-neutral-400 hover:text-primary-700 transition-colors" aria-label="Tampilkan password">
                                <svg id="eye-icon-password" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                <svg id="eye-off-icon-password" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- Konfirmasi Password --}}
                    <div>
                        <label for="password_confirmation" class="block text-xs font-bold text-neutral-500 uppercase tracking-wider mb-1.5">Konfirmasi Password Baru</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            </div>
                            <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Ulangi password baru" class="w-full pl-12 pr-12 py-3 border-2 border-neutral-200 rounded-xl text-sm text-neutral-800 placeholder-neutral-400 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition-all outline-none bg-neutral-50 hover:bg-white focus:bg-white" autocomplete="new-password">
                            <button type="button" id="toggle-password-confirm" class="absolute inset-y-0 right-0 pr-4 flex items-center text-neutral-400 hover:text-primary-700 transition-colors" aria-label="Tampilkan password">
                                <svg id="eye-icon-confirm" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                <svg id="eye-off-icon-confirm" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="pt-6 border-t border-neutral-100 flex flex-col sm:flex-row items-center justify-end gap-3">
                <a href="{{ route('pelanggan.profil') }}" class="w-full sm:w-auto px-6 py-3 border-2 border-neutral-200 text-neutral-500 hover:text-neutral-800 hover:border-neutral-300 font-heading font-extrabold text-sm rounded-2xl transition-all duration-200 text-center uppercase tracking-wider">
                    Batal
                </a>
                <button type="submit" class="w-full sm:w-auto bg-primary-700 text-white font-heading font-extrabold py-3.5 px-8 rounded-2xl shadow-md hover:shadow-lg hover:-translate-y-0.5 active:translate-y-0 active:shadow-md transition-all duration-200 flex items-center justify-center gap-2 text-sm uppercase tracking-wider cursor-pointer">
                    <span>Simpan Perubahan</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </button>
            </div>

        </form>
    </div>

</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const provinsiSelect = document.getElementById('provinsi');
    const kotaSelect = document.getElementById('kota_kabupaten');
    const kecamatanSelect = document.getElementById('kecamatan');

    const initialProv = '{{ old("provinsi", $pelanggan->provinsi) }}';
    const initialKota = '{{ old("kota_kabupaten", $pelanggan->kota_kabupaten) }}';
    const initialKec = '{{ old("kecamatan", $pelanggan->kecamatan) }}';

    function setDropdownLoading(selectEl, isLoading) {
        if (isLoading) {
            selectEl.classList.add('dropdown-loading');
        } else {
            selectEl.classList.remove('dropdown-loading');
        }
    }

    // Load Provinces
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
                if (initialProv === prov.name && prov.name !== '-') {
                    opt.selected = true;
                }
                provinsiSelect.appendChild(opt);
            });
            setDropdownLoading(provinsiSelect, false);
            provinsiSelect.disabled = false;

            if (provinsiSelect.value) {
                provinsiSelect.dispatchEvent(new Event('change'));
            }
        })
        .catch(() => {
            setDropdownLoading(provinsiSelect, false);
            fallbackToTextInput(provinsiSelect, 'provinsi');
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
                    if (initialKota === kota.name && kota.name !== '-') {
                        opt.selected = true;
                    }
                    kotaSelect.appendChild(opt);
                });
                setDropdownLoading(kotaSelect, false);
                kotaSelect.disabled = false;

                if (kotaSelect.value) {
                    kotaSelect.dispatchEvent(new Event('change'));
                }
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
                    if (initialKec === kec.name && kec.name !== '-') {
                        opt.selected = true;
                    }
                    kecamatanSelect.appendChild(opt);
                });
                setDropdownLoading(kecamatanSelect, false);
                kecamatanSelect.disabled = false;
            })
            .catch(() => setDropdownLoading(kecamatanSelect, false));
    });

    function fallbackToTextInput(selectEl, name) {
        const wrapper = selectEl.parentNode;
        const input = document.createElement('input');
        input.type = 'text'; input.name = name; input.id = name;
        input.required = true;
        input.className = selectEl.className;
        input.value = selectEl.value || '';
        wrapper.replaceChild(input, selectEl);
    }

    // ====== PHONE NUMBER VALIDATION ======
    const phoneInput = document.getElementById('no_telepon');
    const phoneWarning = document.getElementById('phone-warning');
    const formEl = document.getElementById('edit-profile-form');

    function validatePhone() {
        phoneInput.value = phoneInput.value.replace(/[^0-9]/g, '');
        const val = phoneInput.value;
        if (val.length > 0 && val.length < 10) {
            phoneInput.classList.add('border-red-500');
            phoneInput.classList.remove('border-neutral-200');
            phoneWarning.classList.remove('hidden');
            return false;
        } else if (val.length >= 10) {
            phoneInput.classList.remove('border-red-500');
            phoneInput.classList.add('border-neutral-200');
            phoneWarning.classList.add('hidden');
            return true;
        } else {
            phoneInput.classList.remove('border-red-500');
            phoneInput.classList.add('border-neutral-200');
            phoneWarning.classList.add('hidden');
            return false;
        }
    }
    phoneInput.addEventListener('input', validatePhone);
    phoneInput.addEventListener('blur', validatePhone);
    phoneInput.addEventListener('paste', function(e) {
        e.preventDefault();
        const paste = (e.clipboardData || window.clipboardData).getData('text');
        this.value = (this.value + paste).replace(/[^0-9]/g, '');
        validatePhone();
    });
    phoneInput.addEventListener('keypress', function(e) {
        if (!/[0-9]/.test(e.key)) e.preventDefault();
    });

    formEl.addEventListener('submit', function(e) {
        const phoneOk = validatePhone();
        if (!phoneOk) {
            e.preventDefault();
            phoneInput.focus();
            return false;
        }
    });

    // ====== PASSWORD VISIBILITY TOGGLE ======
    function setupPasswordToggle(toggleId, inputId, eyeIconId, eyeOffIconId) {
        const toggleBtn = document.getElementById(toggleId);
        const input = document.getElementById(inputId);
        const eyeIcon = document.getElementById(eyeIconId);
        const eyeOffIcon = document.getElementById(eyeOffIconId);
        if (toggleBtn && input) {
            toggleBtn.addEventListener('click', function() {
                const isPassword = input.type === 'password';
                input.type = isPassword ? 'text' : 'password';
                eyeIcon.style.display = isPassword ? 'none' : 'block';
                eyeOffIcon.style.display = isPassword ? 'block' : 'none';
                this.setAttribute('aria-label', isPassword ? 'Sembunyikan password' : 'Tampilkan password');
            });
        }
    }
    setupPasswordToggle('toggle-password', 'password', 'eye-icon-password', 'eye-off-icon-password');
    setupPasswordToggle('toggle-password-confirm', 'password_confirmation', 'eye-icon-confirm', 'eye-off-icon-confirm');
});
</script>
@endpush
