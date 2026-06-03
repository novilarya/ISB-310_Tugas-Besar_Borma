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
                    <!-- Selected Address -->
                    <div class="border-2 border-primary-700 bg-primary-50 rounded-2xl p-5 relative cursor-pointer">
                        <div class="absolute top-4 right-4 text-white bg-primary-700 rounded-full p-0.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <p class="text-[10px] font-bold text-primary-600 uppercase tracking-wider mb-2">Alamat Utama</p>
                        <p class="font-bold text-sm text-neutral-800 mb-1">Rumah ({{ auth()->user()->nama ?? 'Pelanggan' }})</p>
                        <p class="text-xs text-neutral-600 leading-relaxed">
                            @if(auth()->check() && auth()->user()->pelanggan)
                                {{ auth()->user()->pelanggan->alamat }}, Kec. {{ auth()->user()->pelanggan->kecamatan }}, {{ auth()->user()->pelanggan->kota_kabupaten }}, {{ auth()->user()->pelanggan->provinsi }}
                            @else
                                Jl. Antapani No. 123, Kota Bandung, 40291
                            @endif
                        </p>
                    </div>
                    <!-- Add New -->
                    <div class="border border-dashed border-neutral-300 rounded-2xl p-5 flex flex-col items-center justify-center cursor-pointer hover:border-primary-400 hover:bg-primary-50 transition-all text-neutral-400 hover:text-primary-700 group">
                        <div class="w-10 h-10 rounded-full bg-neutral-100 group-hover:bg-primary-100 flex items-center justify-center mb-2 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        </div>
                        <p class="text-xs font-bold">Tambah Alamat Baru</p>
                    </div>
                </div>

                <!-- Form -->
                <div class="bg-neutral-50 rounded-xl p-5 border border-neutral-100">
                    <h4 class="text-[10px] font-bold text-neutral-400 uppercase tracking-wider mb-4">Form Detail Alamat</h4>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-neutral-500 mb-1.5">Jalan</label>
                            <input type="text" placeholder="Masukkan nama jalan dan nomor rumah" class="w-full bg-white border border-neutral-200 rounded-xl py-3 px-4 text-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-100 outline-none transition-all">
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-neutral-500 mb-1.5">Kota</label>
                                <input type="text" placeholder="Contoh: Bandung" class="w-full bg-white border border-neutral-200 rounded-xl py-3 px-4 text-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-100 outline-none transition-all">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-neutral-500 mb-1.5">Kode Pos</label>
                                <input type="text" placeholder="5 Digit" class="w-full bg-white border border-neutral-200 rounded-xl py-3 px-4 text-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-100 outline-none transition-all">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Metode Pengiriman -->
            <div class="bg-white rounded-2xl border border-neutral-200 shadow-sm p-6">
                <h3 class="font-heading font-extrabold text-lg text-neutral-800 mb-5">Metode Pengiriman</h3>
                <div class="border-2 border-primary-700 bg-primary-50 rounded-2xl p-5 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-primary-700 text-white rounded-xl flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-sm text-neutral-800 mb-0.5">Delivery Internal Borma</h4>
                            <p class="text-xs text-neutral-500">Estimasi tiba dalam 2-4 jam (Khusus Area Bandung)</p>
                        </div>
                    </div>
                    <span class="font-extrabold text-base text-primary-700 shrink-0">Rp 15.000</span>
                </div>
            </div>

            <!-- Voucher -->
            <div class="bg-white rounded-2xl border border-neutral-200 shadow-sm p-6">
                <h3 class="font-heading font-extrabold text-lg text-neutral-800 mb-5">Punya Voucher?</h3>
                <div class="flex items-center gap-3">
                    <input type="text" placeholder="Masukkan kode voucher" class="flex-1 bg-neutral-50 border border-neutral-200 rounded-xl py-3 px-4 text-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-100 outline-none transition-all">
                    <button class="bg-neutral-900 hover:bg-neutral-800 text-white text-xs font-bold px-6 py-3 rounded-xl transition-colors shadow-sm uppercase tracking-wide shrink-0">
                        Gunakan
                    </button>
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
                        <span class="font-bold text-sm text-neutral-800">Rp 15.000</span>
                    </div>
                </div>

                <!-- Gift -->
                <div class="bg-secondary-50 rounded-xl p-4 mb-5 border border-secondary-100">
                    <div class="flex items-center gap-2 mb-3">
                        <svg class="w-4 h-4 text-secondary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path></svg>
                        <span class="text-[10px] font-bold text-neutral-800 uppercase tracking-wider">Hadiah Gratis</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-white rounded-lg border border-neutral-200 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        </div>
                        <div>
                            <p class="font-bold text-xs text-neutral-800">Borma Eco Tote Bag</p>
                            <p class="text-[10px] text-neutral-400">Edisi Terbatas</p>
                        </div>
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
                        <!-- COD -->
                        <div class="payment-option flex items-center gap-3 px-4 py-3.5 cursor-pointer hover:bg-primary-50 transition-all border-b border-neutral-100" data-method="cod" onclick="selectPayment('cod')">
                            <div class="w-10 h-10 rounded-xl bg-green-100 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-bold text-neutral-800">COD (Bayar di Tempat)</p>
                                <p class="text-[11px] text-neutral-400">Bayar saat barang diterima</p>
                            </div>
                            <div id="check-cod" class="hidden w-5 h-5 bg-primary-700 rounded-full flex items-center justify-center">
                                <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                        </div>
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
                        <span class="font-heading font-extrabold text-2xl text-primary-700">Rp {{ number_format($subtotal + 15000,0,',','.') }}</span>
                    </div>
                </div>

                <button id="btnBayar" onclick="processPayment()" disabled class="w-full py-3.5 bg-neutral-300 text-neutral-500 text-sm font-bold rounded-xl transition-all shadow-md mb-3 cursor-not-allowed">
                    Pilih Metode Pembayaran
                </button>
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

    function togglePaymentDropdown() {
        const dropdown = document.getElementById('paymentDropdown');
        const chevron = document.getElementById('paymentChevron');
        dropdown.classList.toggle('hidden');
        chevron.style.transform = dropdown.classList.contains('hidden') ? '' : 'rotate(180deg)';
    }

    function selectPayment(method) {
        selectedPaymentMethod = method;
        const labels = { cod: 'COD (Bayar di Tempat)', transfer: 'Transfer / Pembayaran Online' };

        document.getElementById('selectedPaymentLabel').textContent = labels[method];

        // Update checkmarks
        document.querySelectorAll('[id^="check-"]').forEach(el => el.classList.add('hidden'));
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

    function processPayment() {
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
                total: {{ $subtotal + 15000 }},
                customer_name: '{{ auth()->user()->nama ?? "Guest" }}',
                customer_email: '{{ auth()->user()->email ?? "guest@borma.com" }}',
                customer_phone: '{{ auth()->user()->no_telepon ?? "0000000000" }}',
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
    });
</script>
@endpush
