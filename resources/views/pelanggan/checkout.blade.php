@extends('layouts.checkout')

@section('title', 'Checkout')

@section('content')
<div class="space-y-10 pb-10">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-end justify-between border-b border-neutral-200 pb-5 gap-4">
        <div>
            <h2 class="font-heading font-extrabold text-3xl sm:text-4xl text-neutral-800 mb-2 tracking-tight">Checkout</h2>
            <p class="text-neutral-500 font-medium text-sm">Lengkapi informasi di bawah untuk menyelesaikan pesanan Anda</p>
        </div>
        <a href="{{ route('pelanggan.keranjang') }}" class="text-primary-600 font-bold text-sm hover:text-primary-800 transition-colors flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            Kembali ke keranjang
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <!-- Left Column (2/3) -->
        <div class="lg:col-span-2 space-y-6">

            <!-- Alamat Pengiriman -->
            <div class="bg-white rounded-2xl border border-neutral-200 shadow-sm p-6">
                <h3 class="font-heading font-extrabold text-lg text-neutral-800 mb-1">Alamat Pengiriman</h3>
                <p class="text-neutral-500 font-medium text-sm mb-5">Tentukan lokasi pengiriman barang belanjaan Anda.</p>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                    <!-- Alamat Utama Card -->
                    <div id="card-alamat-utama" onclick="selectAddress('utama')" class="border-2 border-primary-700 bg-primary-50 rounded-2xl p-5 relative cursor-pointer transition-all duration-200">
                        <div id="checkmark-utama" class="absolute top-4 right-4 text-white bg-primary-700 rounded-full p-0.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <p class="text-[10px] font-bold text-primary-600 uppercase tracking-wider mb-2">Alamat Utama</p>
                        <p class="font-bold text-sm text-neutral-800 mb-1">Rumah ({{ auth()->user()->nama ?? 'Pelanggan' }})</p>
                        <p class="text-xs text-neutral-600 leading-relaxed" id="address-text-utama">
                            @if(auth()->check() && auth()->user()->pelanggan)
                                {{ auth()->user()->pelanggan->alamat }}, Kec. {{ auth()->user()->pelanggan->kecamatan }}, {{ auth()->user()->pelanggan->kota_kabupaten }}, {{ auth()->user()->pelanggan->provinsi }}
                            @else
                                Jl. Antapani No. 123, Kota Bandung, 40291
                            @endif
                        </p>
                    </div>

                    <!-- Additional Addresses dynamically rendered -->
                    <div id="additional-addresses-container" class="contents"></div>

                    <!-- Add New Card (dashed) -->
                    <div id="card-add-new" onclick="showAddressForm('add')" class="border border-dashed border-neutral-300 rounded-2xl p-5 flex flex-col items-center justify-center cursor-pointer hover:border-primary-400 hover:bg-primary-50 transition-all text-neutral-400 hover:text-primary-700 group min-h-[140px]">
                        <div class="w-10 h-10 rounded-full bg-neutral-100 group-hover:bg-primary-100 flex items-center justify-center mb-2 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        </div>
                        <p class="text-xs font-bold">Tambah Alamat Baru</p>
                    </div>
                </div>

                <!-- Form Detail Alamat -->
                <div id="form-alamat-container" class="hidden bg-neutral-50 rounded-xl p-5 border border-neutral-100 mb-6">
                    <div class="flex items-center justify-between mb-4">
                        <h4 id="form-alamat-title" class="text-[10px] font-bold text-neutral-400 uppercase tracking-wider">Form Alamat Tambahan</h4>
                        <button onclick="hideAddressForm()" class="text-xs font-bold text-neutral-400 hover:text-neutral-600 transition-colors">Batal</button>
                    </div>
                    <div class="space-y-4">
                        {{-- Label Alamat --}}
                        <div>
                            <label for="label_alamat" class="block text-xs font-bold text-neutral-500 mb-1.5">Label Alamat (Contoh: Kantor, Rumah Kedua)</label>
                            <input type="text" id="label_alamat" placeholder="Masukkan label alamat (default: Alamat Tambahan)" class="w-full bg-white border border-neutral-200 rounded-xl py-3 px-4 text-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-100 outline-none transition-all">
                        </div>

                        {{-- Provinsi & Kota --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="provinsi" class="block text-xs font-bold text-neutral-500 mb-1.5">Provinsi</label>
                                <div class="relative">
                                    <select id="provinsi" class="w-full bg-white border border-neutral-200 rounded-xl py-3 px-4 text-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-100 outline-none transition-all appearance-none cursor-pointer">
                                        <option value="">Pilih Provinsi</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-neutral-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label for="kota_kabupaten" class="block text-xs font-bold text-neutral-500 mb-1.5">Kota/Kabupaten</label>
                                <div class="relative">
                                    <select id="kota_kabupaten" disabled class="w-full bg-white border border-neutral-200 rounded-xl py-3 px-4 text-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-100 outline-none transition-all appearance-none cursor-pointer">
                                        <option value="">Pilih Kota/Kabupaten</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-neutral-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Kecamatan & Alamat --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="kecamatan" class="block text-xs font-bold text-neutral-500 mb-1.5">Kecamatan</label>
                                <div class="relative">
                                    <select id="kecamatan" disabled class="w-full bg-white border border-neutral-200 rounded-xl py-3 px-4 text-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-100 outline-none transition-all appearance-none cursor-pointer">
                                        <option value="">Pilih Kecamatan</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-neutral-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label for="jalan" class="block text-xs font-bold text-neutral-500 mb-1.5">Jalan / Alamat</label>
                                <input type="text" id="jalan" placeholder="Masukkan nama jalan dan nomor rumah" class="w-full bg-white border border-neutral-200 rounded-xl py-3 px-4 text-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-100 outline-none transition-all">
                            </div>
                        </div>

                        <div class="flex justify-end gap-3 pt-2">
                            <button onclick="hideAddressForm()" class="px-5 py-2.5 rounded-xl border border-neutral-200 text-neutral-600 text-xs font-bold hover:bg-neutral-100 transition-colors">Batal</button>
                            <button onclick="saveAddress()" class="bg-primary-700 hover:bg-primary-600 text-white text-xs font-bold px-6 py-2.5 rounded-xl transition-colors shadow-sm">Simpan Alamat</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cabang Borma Pengirim -->
            <div class="bg-white rounded-2xl border border-neutral-200 shadow-sm p-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-5">
                    <div>
                        <h3 class="font-heading font-extrabold text-lg text-neutral-800 mb-1">Cabang Borma Pengirim</h3>
                        <p class="text-neutral-500 font-medium text-sm">Pesanan Anda akan dikirim dari cabang Borma terpilih berdasarkan jarak terdekat.</p>
                    </div>
                </div>

                @if($selectedCabang)
                    <div class="border border-neutral-200 bg-white rounded-2xl p-5 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                        <div class="flex items-center gap-4 min-w-0">
                            <div class="w-12 h-12 bg-primary-50 border border-primary-100 text-primary-700 rounded-xl flex items-center justify-center shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            </div>
                            <div class="min-w-0">
                                <h4 class="font-bold text-sm text-neutral-800 mb-0.5 truncate">{{ $selectedCabang->nama_cabang }}</h4>
                                <p class="text-xs text-neutral-500 mb-1 truncate">{{ $selectedCabang->alamat_cabang }}</p>
                                <div class="flex items-center gap-2">
                                    <span class="inline-flex items-center text-[10px] font-bold text-primary-700 bg-primary-50 border border-primary-200/50 px-2 py-0.5 rounded-full shrink-0">
                                        Jarak: {{ $distance > 0 ? number_format($distance, 1, ',', '.') . ' km' : 'Mendeteksi...' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="border border-dashed border-red-200 bg-red-50/50 rounded-2xl p-6 text-center flex flex-col items-center justify-center gap-4">
                        <div class="w-12 h-12 bg-red-100 text-red-700 rounded-full flex items-center justify-center shadow-inner">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-sm text-red-800 mb-1">Lokasi & Cabang Borma Belum Ditentukan</h4>
                            <p class="text-xs text-red-600 max-w-md mx-auto">Untuk menentukan ongkos kirim secara akurat, Anda harus mendeteksi lokasi dan memilih cabang Borma pengirim terlebih dahulu.</p>
                        </div>
                        <button onclick="openBranchSelectorModal()" class="bg-primary-700 hover:bg-primary-600 text-white text-xs font-bold px-5 py-3 rounded-xl transition-all shadow-md hover:shadow-lg active:scale-95 duration-200 cursor-pointer flex items-center gap-1.5 mx-auto">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            Deteksi Lokasi & Pilih Cabang
                        </button>
                    </div>
                @endif
            </div>

            <!-- Metode Pengiriman -->
            <div class="bg-white rounded-2xl border border-neutral-200 shadow-sm p-6">
                <h3 class="font-heading font-extrabold text-lg text-neutral-800 mb-5">Metode Pengiriman</h3>
                @if($selectedCabang)
                    <div class="border-2 border-primary-700 bg-primary-50 rounded-2xl p-5 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-primary-700 text-white rounded-xl flex items-center justify-center shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-sm text-neutral-800 mb-0.5">Delivery Internal Borma</h4>
                                <p class="text-xs text-neutral-500">
                                    Estimasi tiba dalam 45 Menit (Khusus Area Bandung)
                                    @if($distance > 0)
                                        &bull; Jarak: {{ number_format($distance, 1, ',', '.') }} km
                                    @endif
                                </p>
                            </div>
                        </div>
                        <span class="font-extrabold text-base text-primary-700 shrink-0">Rp {{ number_format($shippingCost, 0, ',', '.') }}</span>
                    </div>
                @else
                    <div class="border border-neutral-200 rounded-2xl p-5 text-center text-neutral-400 py-8">
                        <p class="text-sm font-medium">Metode pengiriman akan aktif setelah Anda mendeteksi lokasi dan memilih cabang Borma.</p>
                    </div>
                @endif
            </div>

            <!-- Voucher Promo -->
            <div class="bg-white rounded-2xl border border-neutral-200 shadow-sm p-6">
                <div class="mb-4">
                    <h3 class="font-heading font-extrabold text-lg text-neutral-800 mb-1">Voucher Promo Borma</h3>
                    <p class="text-neutral-500 font-medium text-xs">Gunakan voucher belanja Borma untuk mendapatkan potongan harga spesial.</p>
                </div>
                <!-- Voucher Dropdown Selection -->
                <div class="relative">
                    <div id="voucherToggle" class="w-full flex items-center justify-between bg-neutral-50 border border-neutral-200 rounded-xl py-3.5 px-4 cursor-pointer hover:border-primary-400 hover:bg-primary-50 transition-all group" onclick="toggleVoucherDropdown()">
                        <div class="flex items-center gap-3">
                            <div id="voucherIcon" class="w-8 h-8 rounded-lg bg-neutral-200 flex items-center justify-center shrink-0 transition-colors">
                                <svg class="w-4 h-4 text-neutral-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-neutral-400 uppercase tracking-wider">Voucher Borma</p>
                                <p id="selectedVoucherLabel" class="text-sm font-bold text-neutral-800">Gunakan Voucher</p>
                            </div>
                        </div>
                        <svg id="voucherChevron" class="w-5 h-5 text-neutral-400 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>

                    <!-- Dropdown Options -->
                    <div id="voucherDropdown" class="hidden relative w-full mt-2 bg-white border border-neutral-200 rounded-xl shadow-lg overflow-hidden z-50 max-h-60 overflow-y-auto">
                        <!-- Option: No Voucher -->
                        <div class="voucher-option flex items-center gap-3 px-4 py-3 cursor-pointer hover:bg-primary-50 transition-all border-b border-neutral-100" onclick="selectVoucher(null)">
                            <div class="flex-1">
                                <p class="text-sm font-bold text-neutral-700">Tidak Menggunakan Voucher</p>
                            </div>
                            <div id="check-voucher-none" class="w-5 h-5 bg-primary-700 rounded-full flex items-center justify-center">
                                <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                        </div>

                        @foreach($vouchers as $voucher)
                        @php
                            // Check if this voucher should be visible based on trigger product in the cart
                            if ($voucher->id_produk_pemicu) {
                                $cartItem = collect($cart)->first(function($item) use ($voucher) {
                                    return isset($item['id_produk']) && $item['id_produk'] == $voucher->id_produk_pemicu;
                                });
                                if (!$cartItem || $cartItem['quantity'] < $voucher->kuantitas_pemicu) {
                                    continue; // Hide voucher if trigger product requirements are not met
                                }
                            }

                            $triggerText = '';
                            if ($voucher->id_produk_pemicu) {
                                $pemicu = $voucher->produkPemicu;
                                if ($pemicu) {
                                    $triggerText = "Syarat: Beli Min. " . $voucher->kuantitas_pemicu . " " . $pemicu->nama_produk;
                                }
                            }
                            $minTrxText = $voucher->id_produk_pemicu ? '' : "Min. Belanja Rp " . number_format($voucher->min_transaksi, 0, ',', '.');
                        @endphp
                        <div class="voucher-option flex items-center gap-3 px-4 py-3 cursor-pointer hover:bg-primary-50 transition-all border-b border-neutral-100" 
                             data-voucher-id="{{ $voucher->id_promo }}" 
                             onclick="selectVoucher({{ json_encode($voucher) }})">
                            <div class="w-10 h-10 rounded-xl bg-primary-50 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5 text-primary-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-bold text-neutral-800">{{ $voucher->nama_voucher }}</p>
                                <p class="text-[10px] font-semibold text-primary-700 mt-0.5 uppercase tracking-wide bg-primary-50 border border-primary-200 px-1.5 py-0.5 rounded inline-block">{{ $voucher->kode_voucher }}</p>
                                <p class="text-[10px] text-neutral-400 mt-1">
                                    @if($minTrxText)
                                        {{ $minTrxText }}
                                    @endif
                                    @if($minTrxText && $triggerText)
                                        &bull;
                                    @endif
                                    @if($triggerText)
                                        {{ $triggerText }}
                                    @endif
                                </p>
                            </div>
                            <div id="check-voucher-{{ $voucher->id_promo }}" class="hidden w-5 h-5 bg-primary-700 rounded-full flex items-center justify-center">
                                <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>

        <!-- Right Column (1/3) - Order Summary -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl border border-neutral-200 shadow-sm p-6 sticky top-28">
                <h3 class="font-heading font-extrabold text-lg text-neutral-800 mb-5">Ringkasan Pesanan</h3>

                <div class="space-y-3 mb-5">
                    @foreach($cart as $key => $item)
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-neutral-500 truncate pr-2">{{ $item['name'] }} <span class="text-neutral-400">x{{ $item['quantity'] }}</span></span>
                        <span class="font-semibold text-sm text-neutral-800 whitespace-nowrap">Rp {{ number_format($item['price'] * $item['quantity'],0,',','.') }}</span>
                    </div>
                    @endforeach
                    <div class="border-t border-neutral-100 pt-2">
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-medium text-neutral-500">Subtotal ({{ $totalItems }} Barang)</span>
                            <span class="font-bold text-sm text-neutral-800">Rp {{ number_format($subtotal,0,',','.') }}</span>
                        </div>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-medium text-neutral-500">Ongkos Kirim</span>
                        <span class="font-bold text-sm text-neutral-800">
                            @if($selectedCabang)
                                Rp {{ number_format($shippingCost, 0, ',', '.') }}
                            @else
                                —
                            @endif
                        </span>
                    </div>
                    <div id="voucher-discount-row" class="hidden flex justify-between items-center text-green-700">
                        <span class="text-sm font-medium">Diskon Voucher</span>
                        <span class="font-bold text-sm" id="voucher-discount-amount">-Rp 0</span>
                    </div>
                </div>



                <!-- Metode Pembayaran -->
                <div class="mb-5">
                    <div id="paymentMethodToggle" class="w-full flex items-center justify-between bg-neutral-50 border border-neutral-200 rounded-xl py-3 px-4 cursor-pointer hover:border-primary-400 hover:bg-primary-50 transition-all group" onclick="togglePaymentDropdown()">
                        <div class="flex items-center gap-3">
                            <div id="paymentIcon" class="w-8 h-8 rounded-lg bg-neutral-200 flex items-center justify-center shrink-0 transition-colors">
                                <svg class="w-4 h-4 text-neutral-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-neutral-400 uppercase tracking-wider">Metode Pembayaran</p>
                                <p id="selectedPaymentLabel" class="text-sm font-bold text-neutral-800">Pilih Metode</p>
                            </div>
                        </div>
                        <svg id="paymentChevron" class="w-5 h-5 text-neutral-400 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>

                    <!-- Dropdown -->
                    <div id="paymentDropdown" class="hidden mt-2 bg-white border border-neutral-200 rounded-xl shadow-lg overflow-hidden z-50 relative">
                        <!-- Transfer / Pembayaran Online -->
                        <div class="payment-option flex items-center gap-3 px-4 py-3.5 cursor-pointer hover:bg-primary-50 transition-all" data-method="transfer" onclick="selectPayment('transfer')">
                            <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-bold text-neutral-800">Transfer / Pembayaran Online</p>
                                <p class="text-[11px] text-neutral-400">Transfer Bank, QRIS, e-Wallet, dll.</p>
                            </div>
                            <div id="check-transfer" class="hidden w-5 h-5 bg-primary-700 rounded-full flex items-center justify-center">
                                <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="border-t border-neutral-200 pt-5 mb-6">
                    <div class="flex justify-between items-end">
                        <span class="text-sm font-bold text-neutral-800">Total Bayar</span>
                        <span id="total-payment-amount" class="font-heading font-extrabold text-2xl text-primary-700 font-sans">
                            @if($selectedCabang)
                                Rp {{ number_format($subtotal + $shippingCost,0,',','.') }}
                            @else
                                Rp {{ number_format($subtotal,0,',','.') }}
                            @endif
                        </span>
                    </div>
                </div>

                @if($selectedCabang)
                    <button id="btnBayar" onclick="processPayment()" disabled class="w-full py-3.5 bg-neutral-300 text-neutral-500 text-sm font-bold rounded-xl transition-all shadow-md mb-3 cursor-not-allowed">
                        Pilih Metode Pembayaran
                    </button>
                @else
                    <button id="btnBayar" disabled class="w-full py-3.5 bg-neutral-300 text-neutral-500 text-sm font-bold rounded-xl transition-all shadow-md mb-3 cursor-not-allowed">
                        Pilih Cabang Pengirim
                    </button>
                @endif
                <p class="text-center text-[10px] text-neutral-400">*Harga sudah termasuk PPN 11%</p>

                <!-- Loading overlay -->
                <div id="paymentLoading" class="hidden absolute inset-0 bg-white/80 backdrop-blur-sm rounded-2xl flex items-center justify-center z-50">
                    <div class="text-center">
                        <div class="w-10 h-10 border-4 border-primary-200 border-t-primary-700 rounded-full animate-spin mx-auto mb-3"></div>
                        <p class="text-sm font-bold text-neutral-700">Memproses pembayaran...</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
    let selectedPaymentMethod = null;
    let selectedVoucherId = null;
    let appliedDiscount = 0;
    let selectedAddressType = 'utama'; // default selection
    let addressMode = 'add'; // 'add' or 'edit'
    let additionalAddresses = [];
    let selectedAddressId = null;
    let selectedAddressString = '';
    let currentEditAddressId = null;

    const provinsiSelect = document.getElementById('provinsi');
    const kotaSelect = document.getElementById('kota_kabupaten');
    const kecamatanSelect = document.getElementById('kecamatan');
    const jalanInput = document.getElementById('jalan');

    function escapeHtml(str) {
        if (!str) return '';
        return str.replace(/&/g, '&amp;')
                  .replace(/</g, '&lt;')
                  .replace(/>/g, '&gt;')
                  .replace(/"/g, '&quot;')
                  .replace(/'/g, '&#039;');
    }

    document.addEventListener('DOMContentLoaded', function() {
        loadAdditionalAddresses();
        initRegionDropdowns();
        const selectedCabangId = '{{ session('selected_cabang_id', '') }}';
        if (selectedCabangId) {
            selectPayment('transfer');
        }
    });

    function loadAdditionalAddresses(selectIdAfterLoad = null) {
        fetch('{{ route("pelanggan.alamat.index") }}')
            .then(res => res.json())
            .then(resData => {
                additionalAddresses = resData.data || [];
                const container = document.getElementById('additional-addresses-container');
                container.innerHTML = '';

                additionalAddresses.forEach(addr => {
                    const card = document.createElement('div');
                    card.id = `card-alamat-${addr.id_alamat}`;
                    card.className = 'border border-neutral-200 bg-white rounded-2xl p-5 relative cursor-pointer hover:border-primary-300 transition-all duration-200';
                    card.onclick = () => selectAddress('tambahan', addr.id_alamat, `${addr.alamat}, Kec. ${addr.kecamatan}, ${addr.kota_kabupaten}, ${addr.provinsi}`);
                    
                    card.innerHTML = `
                        <!-- Checkmark -->
                        <div id="checkmark-${addr.id_alamat}" class="hidden absolute top-4 right-4 text-white bg-primary-700 rounded-full p-0.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <!-- Actions -->
                        <div class="absolute bottom-4 right-4 flex gap-2">
                            <button onclick="editAddress(event, ${addr.id_alamat})" class="text-neutral-400 hover:text-primary-700 bg-neutral-50 hover:bg-primary-50 border border-neutral-200 rounded-lg p-1.5 transition-all shadow-sm active:scale-95 duration-200" title="Edit Alamat">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                            </button>
                            <button onclick="deleteAddress(event, ${addr.id_alamat})" class="text-neutral-400 hover:text-red-600 bg-neutral-50 hover:bg-red-50 border border-neutral-200 rounded-lg p-1.5 transition-all shadow-sm active:scale-95 duration-200" title="Hapus Alamat">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </div>
                        <p class="text-[10px] font-bold text-neutral-400 uppercase tracking-wider mb-2">${escapeHtml(addr.label || 'Alamat Tambahan')}</p>
                        <p class="font-bold text-sm text-neutral-800 mb-1">${escapeHtml(addr.label || 'Alamat Tambahan')}</p>
                        <p class="text-xs text-neutral-600 leading-relaxed pr-16">${escapeHtml(addr.alamat)}, Kec. ${escapeHtml(addr.kecamatan)}, ${escapeHtml(addr.kota_kabupaten)}, ${escapeHtml(addr.provinsi)}</p>
                    `;
                    container.appendChild(card);
                });

                // Set selection
                if (selectIdAfterLoad !== null) {
                    const selectedAddr = additionalAddresses.find(a => a.id_alamat === selectIdAfterLoad);
                    if (selectedAddr) {
                        selectAddress('tambahan', selectedAddr.id_alamat, `${selectedAddr.alamat}, Kec. ${selectedAddr.kecamatan}, ${selectedAddr.kota_kabupaten}, ${selectedAddr.provinsi}`);
                    } else {
                        selectAddress('utama');
                    }
                } else if (selectedAddressType === 'tambahan' && selectedAddressId !== null) {
                    const exists = additionalAddresses.some(a => a.id_alamat === selectedAddressId);
                    if (exists) {
                        const addr = additionalAddresses.find(a => a.id_alamat === selectedAddressId);
                        selectAddress('tambahan', selectedAddressId, `${addr.alamat}, Kec. ${addr.kecamatan}, ${addr.kota_kabupaten}, ${addr.provinsi}`);
                    } else {
                        selectAddress('utama');
                    }
                } else {
                    selectAddress('utama');
                }
            })
            .catch(err => console.error('Error loading addresses:', err));
    }

    function selectAddress(type, id = null, addressString = '') {
        selectedAddressType = type;
        selectedAddressId = id;
        selectedAddressString = addressString;

        const cardUtama = document.getElementById('card-alamat-utama');
        const checkmarkUtama = document.getElementById('checkmark-utama');

        // Reset Alamat Utama
        cardUtama.classList.remove('border-primary-700', 'bg-primary-50');
        cardUtama.classList.add('border-neutral-200', 'bg-white');
        checkmarkUtama.classList.add('hidden');

        // Reset all additional address cards
        additionalAddresses.forEach(addr => {
            const card = document.getElementById(`card-alamat-${addr.id_alamat}`);
            const checkmark = document.getElementById(`checkmark-${addr.id_alamat}`);
            if (card && checkmark) {
                card.classList.remove('border-primary-700', 'bg-primary-50');
                card.classList.add('border-neutral-200', 'bg-white');
                checkmark.classList.add('hidden');
            }
        });

        if (type === 'utama') {
            cardUtama.classList.add('border-primary-700', 'bg-primary-50');
            cardUtama.classList.remove('border-neutral-200', 'bg-white');
            checkmarkUtama.classList.remove('hidden');
        } else if (type === 'tambahan' && id !== null) {
            const card = document.getElementById(`card-alamat-${id}`);
            const checkmark = document.getElementById(`checkmark-${id}`);
            if (card && checkmark) {
                card.classList.add('border-primary-700', 'bg-primary-50');
                card.classList.remove('border-neutral-200', 'bg-white');
                checkmark.classList.remove('hidden');
            }
        }
    }

    function showAddressForm(mode) {
        addressMode = mode;
        const container = document.getElementById('form-alamat-container');
        const title = document.getElementById('form-alamat-title');
        container.classList.remove('hidden');
        container.scrollIntoView({ behavior: 'smooth', block: 'nearest' });

        if (mode === 'add') {
            title.textContent = 'Tambah Alamat Baru';
            jalanInput.value = '';
            document.getElementById('label_alamat').value = '';
            provinsiSelect.value = '';
            provinsiSelect.dispatchEvent(new Event('change'));
        } else if (mode === 'edit') {
            title.textContent = 'Edit Alamat Tambahan';
            const addr = additionalAddresses.find(a => a.id_alamat === currentEditAddressId);
            if (addr) {
                jalanInput.value = addr.alamat || '';
                document.getElementById('label_alamat').value = addr.label || '';
                
                setDropdownValue(provinsiSelect, addr.provinsi, () => {
                    setDropdownValue(kotaSelect, addr.kota_kabupaten, () => {
                        setDropdownValue(kecamatanSelect, addr.kecamatan);
                    });
                });
            }
        }
    }

    function hideAddressForm() {
        document.getElementById('form-alamat-container').classList.add('hidden');
    }

    function editAddress(event, id) {
        event.stopPropagation(); // Prevent card selection click trigger
        currentEditAddressId = id;
        showAddressForm('edit');
    }

    function deleteAddress(event, id) {
        event.stopPropagation();
        if (!confirm('Apakah Anda yakin ingin menghapus alamat ini?')) return;

        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        fetch(`/pelanggan/alamat/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            }
        })
        .then(res => res.json())
        .then(data => {
            loadAdditionalAddresses();
        })
        .catch(err => {
            console.error(err);
            alert('Terjadi kesalahan saat menghapus alamat.');
        });
    }

    function setDropdownLoading(selectEl, isLoading) {
        const wrapper = selectEl.closest('.relative');
        if (isLoading) {
            selectEl.disabled = true;
            wrapper.classList.add('dropdown-loading');
        } else {
            selectEl.disabled = false;
            wrapper.classList.remove('dropdown-loading');
        }
    }

    function setDropdownValue(selectEl, valueText, callback) {
        let attempts = 0;
        const checkExist = setInterval(() => {
            const options = Array.from(selectEl.options);
            const found = options.find(opt => opt.value === valueText);
            if (found) {
                clearInterval(checkExist);
                selectEl.value = valueText;
                selectEl.dispatchEvent(new Event('change'));
                if (callback) callback();
            } else {
                attempts++;
                if (attempts > 30) { // Timeout after 3s
                    clearInterval(checkExist);
                    if (callback) callback();
                }
            }
        }, 100);
    }

    // Fetch provinces
    function initRegionDropdowns() {
        setDropdownLoading(provinsiSelect, true);
        fetch('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json')
            .then(r => r.json())
            .then(data => {
                data.sort((a, b) => a.name.localeCompare(b.name));
                
                provinsiSelect.innerHTML = '<option value="">Pilih Provinsi</option>';
                data.forEach(prov => {
                    const opt = document.createElement('option');
                    opt.value = prov.name;
                    opt.textContent = prov.name;
                    opt.dataset.id = prov.id;
                    provinsiSelect.appendChild(opt);
                });
                setDropdownLoading(provinsiSelect, false);
            })
            .catch(err => {
                console.error('Failed to fetch provinces:', err);
                setDropdownLoading(provinsiSelect, false);
            });

        provinsiSelect.addEventListener('change', function() {
            const selectedOpt = this.options[this.selectedIndex];
            const provId = selectedOpt ? selectedOpt.dataset.id : null;

            kotaSelect.innerHTML = '<option value="">Pilih Kota/Kabupaten</option>';
            kecamatanSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
            kotaSelect.disabled = true;
            kecamatanSelect.disabled = true;

            if (!provId) return;

            setDropdownLoading(kotaSelect, true);
            fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${provId}.json`)
                .then(r => r.json())
                .then(data => {
                    data.sort((a, b) => a.name.localeCompare(b.name));
                    data.forEach(city => {
                        const opt = document.createElement('option');
                        opt.value = city.name;
                        opt.textContent = city.name;
                        opt.dataset.id = city.id;
                        kotaSelect.appendChild(opt);
                    });
                    setDropdownLoading(kotaSelect, false);
                })
                .catch(err => {
                    console.error(err);
                    setDropdownLoading(kotaSelect, false);
                });
        });

        kotaSelect.addEventListener('change', function() {
            const selectedOpt = this.options[this.selectedIndex];
            const cityId = selectedOpt ? selectedOpt.dataset.id : null;

            kecamatanSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
            kecamatanSelect.disabled = true;

            if (!cityId) return;

            setDropdownLoading(kecamatanSelect, true);
            fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/districts/${cityId}.json`)
                .then(r => r.json())
                .then(data => {
                    data.sort((a, b) => a.name.localeCompare(b.name));
                    data.forEach(dist => {
                        const opt = document.createElement('option');
                        opt.value = dist.name;
                        opt.textContent = dist.name;
                        opt.dataset.id = dist.id;
                        kecamatanSelect.appendChild(opt);
                    });
                    setDropdownLoading(kecamatanSelect, false);
                })
                .catch(err => {
                    console.error(err);
                    setDropdownLoading(kecamatanSelect, false);
                });
        });
    }

    function saveAddress() {
        const prov = provinsiSelect.value;
        const kota = kotaSelect.value;
        const kec = kecamatanSelect.value;
        const jalan = jalanInput.value.trim();
        const label = document.getElementById('label_alamat').value.trim();

        if (!prov || !kota || !kec || !jalan) {
            alert('Semua field alamat harus diisi!');
            return;
        }

        const payload = {
            provinsi: prov,
            kota_kabupaten: kota,
            kecamatan: kec,
            alamat: jalan,
            label: label || 'Alamat Tambahan'
        };

        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const url = addressMode === 'add' ? '{{ route("pelanggan.alamat.store") }}' : `/pelanggan/alamat/${currentEditAddressId}`;
        const method = addressMode === 'add' ? 'POST' : 'PUT';

        fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
            body: JSON.stringify(payload)
        })
        .then(res => res.json())
        .then(data => {
            if (data.errors) {
                const errMsg = Object.values(data.errors).flat().join('\n');
                alert('Gagal menyimpan alamat:\n' + errMsg);
                return;
            }
            hideAddressForm();
            loadAdditionalAddresses(data.data ? data.data.id_alamat : null);
        })
        .catch(err => {
            console.error(err);
            alert('Terjadi kesalahan saat menyimpan alamat.');
        });
    }

    function getSelectedAddressString() {
        if (selectedAddressType === 'utama') {
            const el = document.getElementById('address-text-utama');
            return el ? el.textContent.trim().replace(/\s+/g, ' ') : '';
        } else {
            return selectedAddressString;
        }
    }

    function togglePaymentDropdown() {
        const selectedCabangId = '{{ session('selected_cabang_id', '') }}';
        if (!selectedCabangId) {
            alert('Silakan pilih cabang Borma pengirim terlebih dahulu dengan mendeteksi lokasi Anda.');
            return;
        }
        const dropdown = document.getElementById('paymentDropdown');
        const chevron = document.getElementById('paymentChevron');
        dropdown.classList.toggle('hidden');
        chevron.style.transform = dropdown.classList.contains('hidden') ? '' : 'rotate(180deg)';
    }

    function selectPayment(method) {
        const selectedCabangId = '{{ session('selected_cabang_id', '') }}';
        if (!selectedCabangId) {
            alert('Silakan pilih cabang Borma pengirim terlebih dahulu dengan mendeteksi lokasi Anda.');
            return;
        }
        selectedPaymentMethod = method;
        const labels = { cod: 'COD (Bayar di Tempat)', transfer: 'Transfer / Pembayaran Online' };

        document.getElementById('selectedPaymentLabel').textContent = labels[method];

        // Update checkmarks
        document.querySelectorAll('[id^="check-"]').forEach(el => {
            if (!el.id.startsWith('check-voucher')) {
                el.classList.add('hidden');
            }
        });
        const checkEl = document.getElementById('check-' + method);
        if (checkEl) checkEl.classList.remove('hidden');

        // Update button
        const btn = document.getElementById('btnBayar');
        btn.disabled = false;
        btn.className = 'w-full py-3.5 bg-primary-700 hover:bg-primary-600 text-white text-sm font-bold rounded-xl transition-all shadow-md hover:shadow-lg mb-3 cursor-pointer';
        btn.textContent = 'Bayar Sekarang';

        // Close dropdown
        document.getElementById('paymentDropdown').classList.add('hidden');
        document.getElementById('paymentChevron').style.transform = '';

        // Highlight toggle
        const toggle = document.getElementById('paymentMethodToggle');
        toggle.classList.remove('bg-neutral-50', 'border-neutral-200');
        toggle.classList.add('bg-primary-50', 'border-primary-400');
    }

    function toggleVoucherDropdown() {
        const selectedCabangId = '{{ session('selected_cabang_id', '') }}';
        if (!selectedCabangId) {
            alert('Silakan pilih cabang Borma pengirim terlebih dahulu dengan mendeteksi lokasi Anda.');
            return;
        }
        const dropdown = document.getElementById('voucherDropdown');
        const chevron = document.getElementById('voucherChevron');
        dropdown.classList.toggle('hidden');
        chevron.style.transform = dropdown.classList.contains('hidden') ? '' : 'rotate(180deg)';
    }

    function selectVoucher(voucher) {
        const subtotal = {{ $subtotal }};
        const cart = @json(array_values($cart));

        if (voucher === null) {
            selectedVoucherId = null;
            appliedDiscount = 0;
            document.getElementById('selectedVoucherLabel').textContent = 'Gunakan Voucher';
            document.getElementById('voucher-discount-row').classList.add('hidden');
            
            document.querySelectorAll('[id^="check-voucher-"]').forEach(el => el.classList.add('hidden'));
            document.getElementById('check-voucher-none').classList.remove('hidden');

            document.getElementById('voucherDropdown').classList.add('hidden');
            document.getElementById('voucherChevron').style.transform = '';
            
            const toggle = document.getElementById('voucherToggle');
            toggle.classList.remove('bg-primary-50', 'border-primary-400');
            toggle.classList.add('bg-neutral-50', 'border-neutral-200');

            updateTotalDisplay();
            return;
        }

        if (!voucher.id_produk_pemicu && subtotal < voucher.min_transaksi) {
            alert(`Minimal transaksi untuk menggunakan voucher ini adalah Rp ${voucher.min_transaksi.toLocaleString('id-ID')}`);
            selectVoucher(null);
            return;
        }

        if (voucher.id_produk_pemicu) {
            const triggerProduct = cart.find(item => item.id_produk == voucher.id_produk_pemicu);
            if (!triggerProduct || triggerProduct.quantity < voucher.kuantitas_pemicu) {
                alert(`Voucher ini memerlukan pembelian minimal ${voucher.kuantitas_pemicu} pcs produk pemicu.`);
                selectVoucher(null);
                return;
            }
        }

        selectedVoucherId = voucher.id_promo;
        appliedDiscount = parseInt(voucher.potongan_harga) || 0;
        
        document.getElementById('selectedVoucherLabel').textContent = voucher.nama_voucher;
        
        if (appliedDiscount > 0) {
            document.getElementById('voucher-discount-row').classList.remove('hidden');
            document.getElementById('voucher-discount-amount').textContent = `-Rp ${appliedDiscount.toLocaleString('id-ID')}`;
        } else {
            document.getElementById('voucher-discount-row').classList.add('hidden');
        }

        document.querySelectorAll('[id^="check-voucher-"]').forEach(el => el.classList.add('hidden'));
        const checkEl = document.getElementById('check-voucher-' + voucher.id_promo);
        if (checkEl) checkEl.classList.remove('hidden');
        document.getElementById('check-voucher-none').classList.add('hidden');

        document.getElementById('voucherDropdown').classList.add('hidden');
        document.getElementById('voucherChevron').style.transform = '';

        const toggle = document.getElementById('voucherToggle');
        toggle.classList.remove('bg-neutral-50', 'border-neutral-200');
        toggle.classList.add('bg-primary-50', 'border-primary-400');

        updateTotalDisplay();
    }

    function updateTotalDisplay() {
        const subtotal = {{ $subtotal }};
        const shipping = {{ $shippingCost }};
        const netTotal = subtotal + shipping - appliedDiscount;
        document.getElementById('total-payment-amount').textContent = `Rp ${netTotal.toLocaleString('id-ID')}`;
    }

    function processPayment() {
        const selectedCabangId = '{{ session('selected_cabang_id', '') }}';
        if (!selectedCabangId) {
            alert('Silakan pilih cabang Borma pengirim terlebih dahulu dengan mendeteksi lokasi Anda.');
            return;
        }
        if (!selectedPaymentMethod) {
            alert('Silakan pilih metode pembayaran terlebih dahulu.');
            return;
        }

        const loading = document.getElementById('paymentLoading');
        loading.classList.remove('hidden');

        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch('{{ route("payment.create") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
            body: JSON.stringify({
                payment_method: selectedPaymentMethod,
                total: {{ $subtotal }} + {{ $shippingCost }} - appliedDiscount,
                customer_name: '{{ auth()->user()->nama ?? "Guest" }}',
                customer_email: '{{ auth()->user()->email ?? "guest@borma.com" }}',
                customer_phone: '{{ auth()->user()->no_telepon ?? "0000000000" }}',
                shipping_address: getSelectedAddressString(),
                id_promo: selectedVoucherId,
                diskon_voucher: appliedDiscount
            }),
        })
        .then(res => res.json())
        .then(data => {
            loading.classList.add('hidden');

            if (data.status === 'error') {
                showAlert('error', data.message || 'Terjadi kesalahan.');
                return;
            }

            if (data.payment_method === 'cod') {
                showAlert('success', data.message);
                setTimeout(() => {
                    window.location.href = '{{ route("pelanggan.dashboard") }}';
                }, 2000);
                return;
            }

            // Open Midtrans Snap popup
            window.snap.pay(data.snap_token, {
                onSuccess: function(result) {
                    showAlert('success', 'Pembayaran berhasil! Terima kasih.');
                    setTimeout(() => {
                        window.location.href = '/payment/finish?order_id=' + (result.order_id || data.order_id);
                    }, 1500);
                },
                onPending: function(result) {
                    showAlert('info', 'Menunggu pembayaran Anda. Silakan selesaikan pembayaran.');
                },
                onError: function(result) {
                    showAlert('error', 'Pembayaran gagal. Silakan coba lagi.');
                },
                onClose: function() {
                    console.log('Snap popup ditutup.');
                }
            });
        })
        .catch(err => {
            loading.classList.add('hidden');
            showAlert('error', 'Terjadi kesalahan jaringan. Silakan coba lagi.');
            console.error(err);
        });
    }

    function showAlert(type, message) {
        // Remove existing alerts
        document.querySelectorAll('.payment-alert').forEach(el => el.remove());

        const colors = {
            success: 'bg-green-50 border-green-300 text-green-800',
            error: 'bg-red-50 border-red-300 text-red-800',
            info: 'bg-blue-50 border-blue-300 text-blue-800',
        };

        const icons = {
            success: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>',
            error: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>',
            info: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>',
        };

        const alert = document.createElement('div');
        alert.className = `payment-alert flex items-center gap-3 px-4 py-3 rounded-xl border text-sm font-medium mb-4 ${colors[type]} animate-pulse`;
        alert.innerHTML = `<svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">${icons[type]}</svg><span>${message}</span>`;

        const btn = document.getElementById('btnBayar');
        btn.parentNode.insertBefore(alert, btn);

        if (type !== 'info') {
            setTimeout(() => alert.remove(), 5000);
        }
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        const toggle = document.getElementById('paymentMethodToggle');
        const dropdown = document.getElementById('paymentDropdown');
        if (toggle && dropdown && !toggle.contains(e.target) && !dropdown.contains(e.target)) {
            dropdown.classList.add('hidden');
            document.getElementById('paymentChevron').style.transform = '';
        }

        const vToggle = document.getElementById('voucherToggle');
        const vDropdown = document.getElementById('voucherDropdown');
        if (vToggle && vDropdown && !vToggle.contains(e.target) && !vDropdown.contains(e.target)) {
            vDropdown.classList.add('hidden');
            document.getElementById('voucherChevron').style.transform = '';
        }
    });
</script>
@endpush
