@extends('layouts.pelanggan')
@section('title', 'Detail Produk')

@php
$categories = [
    'sembako' => 'Sembako & Bahan Pokok',
    'sayur-buah' => 'Sayur & Buah',
    'daging-ikan' => 'Daging & Ikan',
    'susu-olahan' => 'Susu & Olahan',
    'minuman' => 'Minuman',
    'snack-camilan' => 'Snack & Camilan',
    'kebutuhan-rumah' => 'Kebutuhan Rumah',
    'perawatan-diri' => 'Perawatan Diri',
];

$product = \App\Models\Produk::all()->first(fn($p) => \Illuminate\Support\Str::slug($p->nama_produk) === $slug);

// Fallback if not found
if (!$product) {
    $product = \App\Models\Produk::first();
}

$categoryName = $product->kategori;
$categorySlug = array_search($categoryName, $categories) ?: 'sembako';

$branchId = session('selected_cabang_id', 1);
$productCabang = \App\Models\ProdukCabang::where('id_produk', $product->id_produk)
    ->where('id_cabang', $branchId)
    ->first();

$stok = $productCabang ? $productCabang->jumlah_stok : 0;
$terjual = $productCabang ? $productCabang->jumlah_terjual : 0;

$user = auth()->user();
$isMemberPlus = $user && $user->pelanggan && $user->pelanggan->status_member_plus;
$hasMemberPlusPrice = $product->harga_member_plus > 0 && $product->harga_member_plus < $product->harga_member;
$activePrice = ($isMemberPlus && $hasMemberPlusPrice) ? $product->harga_member_plus : $product->harga_member;

// Weight helper
$weight = '500g';
if (str_contains($product->nama_produk, '5kg')) $weight = '5 kg';
elseif (str_contains($product->nama_produk, '2L')) $weight = '2 kg';
elseif (str_contains($product->nama_produk, '1kg')) $weight = '1 kg';
elseif (str_contains($product->nama_produk, '500g')) $weight = '500 g';
elseif (str_contains($product->nama_produk, '250g')) $weight = '250 g';
elseif (str_contains($product->nama_produk, '130ml')) $weight = '150 g';
elseif (str_contains($product->nama_produk, '335ml')) $weight = '400 g';
elseif (str_contains($product->nama_produk, '1L')) $weight = '1 kg';
elseif (str_contains($product->nama_produk, '150g')) $weight = '150 g';
elseif (str_contains($product->nama_produk, '800g')) $weight = '800 g';
elseif (str_contains($product->nama_produk, '800ml')) $weight = '800 g';
elseif (str_contains($product->nama_produk, '400ml')) $weight = '400 g';
elseif (str_contains($product->nama_produk, '300ml')) $weight = '300 g';

$desc = $product->deskripsi ?: ("Dapatkan " . $product->nama_produk . " berkualitas terbaik hanya di Borma Toserba. Produk diproses dan dikemas secara higienis untuk menjaga kesegaran dan mutunya sampai di tangan Anda. Sangat cocok untuk kebutuhan sehari-hari keluarga Anda dengan harga yang terjangkau dan hemat.");
$imgUrl = $product->gambar_produk ? asset('assets/products/'.$product->gambar_produk) : '';
@endphp

@section('content')
<div class="bg-white rounded-3xl border border-neutral-200 shadow-sm p-6 lg:p-8">
    <!-- Breadcrumb -->
    <nav class="flex text-sm font-semibold text-neutral-400 mb-6 gap-2 items-center">
        <a href="{{ route('pelanggan.dashboard') }}" class="hover:text-primary-700 transition-colors">Home</a>
        <svg class="w-4 h-4 text-neutral-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <a href="{{ route('pelanggan.katalog', ['kategori' => $categorySlug]) }}" class="hover:text-primary-700 transition-colors">{{ $categoryName }}</a>
        <svg class="w-4 h-4 text-neutral-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <span class="text-neutral-600 truncate max-w-50 sm:max-w-xs">{{ $product->nama_produk }}</span>
    </nav>

    <!-- Main Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Left Column: Image Gallery (4 cols) -->
        <div class="lg:col-span-4 space-y-4">
            <!-- Large Image Box -->
            <div class="relative bg-neutral-50 border border-neutral-200 rounded-2xl overflow-hidden aspect-square flex items-center justify-center shadow-sm">
                @if($hasMemberPlusPrice)
                <div class="absolute top-4 right-4 z-10">
                    @php
                        $percentSaved = round((($product->harga_member - $product->harga_member_plus)/$product->harga_member)*100);
                    @endphp
                    @if($isMemberPlus)
                        <span class="bg-green-500 text-white text-[10px] font-extrabold px-2.5 py-1 rounded shadow-sm tracking-wider uppercase">Member Plus Hemat {{ $percentSaved }}%</span>
                    @else
                        <span class="bg-amber-500 text-white text-[10px] font-extrabold px-2.5 py-1 rounded shadow-sm tracking-wider uppercase">Hemat {{ $percentSaved }}% Via Member Plus</span>
                    @endif
                </div>
                @endif
                @if($product->gambar_produk)
                <img src="{{ $imgUrl }}" alt="{{ $product->nama_produk }}" class="w-full h-full object-cover transition-transform duration-300 hover:scale-105" id="main-product-img">
                @else
                <!-- SVG Fallback Placeholder -->
                <div class="w-full h-full flex flex-col items-center justify-center bg-neutral-100 text-neutral-400 p-6">
                    <svg class="w-20 h-20 mb-3 stroke-current opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span class="text-xs font-semibold uppercase tracking-wider">Gambar Tidak Tersedia</span>
                </div>
                @endif
            </div>
            
            <!-- Thumbnail Gallery -->
            @if($product->gambar_produk)
            <div class="flex gap-3 justify-center">
                <div class="w-16 h-16 rounded-xl border-2 border-primary-700 overflow-hidden cursor-pointer bg-neutral-50 hover:border-primary-700 transition-all shadow-sm" id="thumb-1" onclick="changeImage('{{ $imgUrl }}', this)">
                    <img src="{{ $imgUrl }}" class="w-full h-full object-cover">
                </div>
                <div class="w-16 h-16 rounded-xl border-2 border-neutral-200 overflow-hidden cursor-pointer bg-neutral-50 hover:border-primary-700 transition-all shadow-sm opacity-60 hover:opacity-100" id="thumb-2" onclick="changeImage('{{ $imgUrl }}', this)">
                    <img src="{{ $imgUrl }}" class="w-full h-full object-cover filter brightness-95">
                </div>
                <div class="w-16 h-16 rounded-xl border-2 border-neutral-200 overflow-hidden cursor-pointer bg-neutral-50 hover:border-primary-700 transition-all shadow-sm opacity-60 hover:opacity-100" id="thumb-3" onclick="changeImage('{{ $imgUrl }}', this)">
                    <img src="{{ $imgUrl }}" class="w-full h-full object-cover filter contrast-125">
                </div>
            </div>
            @endif
        </div>

        <!-- Middle Column: Product Details (5 cols) -->
        <div class="lg:col-span-5 space-y-6">
            <div>
                <span class="text-xs font-bold text-neutral-400 uppercase tracking-widest">{{ $categoryName }}</span>
                <h2 class="font-heading font-extrabold text-2xl lg:text-3xl text-neutral-800 mt-1 mb-2 leading-tight">{{ $product->nama_produk }}</h2>
                
                <!-- Rating and Sold count -->
                <div class="flex items-center gap-2 text-sm text-neutral-500 font-medium">
                    <span class="flex items-center text-amber-500 gap-0.5">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <span class="font-bold text-neutral-700">4.9</span>
                    </span>
                    <span>•</span>
                    <span>Terjual {{ $terjual }}+</span>
                </div>
            </div>

            <!-- Price Section -->
            <div class="py-5 border-y border-neutral-100 grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Harga Member (Standard) -->
                <div class="p-4 rounded-2xl border transition-all duration-200 {{ !$isMemberPlus ? 'border-primary-200 bg-primary-50/40' : 'border-neutral-200 bg-neutral-50/50' }}">
                    <div class="flex items-center justify-between mb-1.5">
                        <span class="text-xs font-bold text-neutral-500 uppercase tracking-wide">Harga Member</span>
                        @if(!$isMemberPlus)
                            <span class="inline-flex items-center gap-1 text-[10px] font-extrabold uppercase bg-primary-100 text-primary-700 px-2 py-0.5 rounded-md">
                                <span class="w-1.5 h-1.5 rounded-full bg-primary-500 animate-pulse"></span>
                                Aktif
                            </span>
                        @endif
                    </div>
                    <p class="font-heading font-extrabold text-2xl text-neutral-800">
                        Rp {{ number_format($product->harga_member, 0, ',', '.') }}
                    </p>
                </div>

                <!-- Harga Member Plus (Premium) -->
                <div class="p-4 rounded-2xl border transition-all duration-200 relative overflow-hidden {{ $isMemberPlus ? 'border-amber-300 bg-amber-50/30' : 'border-neutral-200 bg-neutral-50/50' }}">
                    @if($hasMemberPlusPrice)
                        <div class="absolute -right-8 -top-8 w-16 h-16 bg-amber-400/10 rounded-full blur-xl"></div>
                    @endif
                    <div class="flex items-center justify-between mb-1.5 relative z-10">
                        <span class="text-xs font-bold text-neutral-500 uppercase tracking-wide">Harga Member Plus</span>
                        @if($isMemberPlus)
                            <span class="inline-flex items-center gap-1 text-[10px] font-extrabold uppercase bg-amber-100 text-amber-800 px-2 py-0.5 rounded-md">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                Aktif
                            </span>
                        @elseif($hasMemberPlusPrice)
                            @php
                                $percentSaved = round((($product->harga_member - $product->harga_member_plus) / $product->harga_member) * 100);
                            @endphp
                            <span class="text-[10px] font-extrabold bg-amber-100 text-amber-800 px-2 py-0.5 rounded-md">
                                Hemat {{ $percentSaved }}%
                            </span>
                        @endif
                    </div>
                    <p class="font-heading font-extrabold text-2xl {{ $isMemberPlus ? 'text-amber-800' : 'text-neutral-800' }} relative z-10">
                        Rp {{ number_format($product->harga_member_plus > 0 ? $product->harga_member_plus : $product->harga_member, 0, ',', '.') }}
                    </p>
                    @if(!$isMemberPlus && $hasMemberPlusPrice)
                        <a href="{{ route('pelanggan.member') }}#borma-plus-membership" class="text-[10px] text-amber-700 hover:text-amber-900 font-bold block mt-1 transition-colors relative z-10 hover:underline">
                            Upgrade ke Member Plus untuk harga hemat &rarr;
                        </a>
                    @endif
                </div>
            </div>

            <!-- Tabs Navigation -->
            <div class="border-b border-neutral-200">
                <div class="flex gap-6 font-bold text-sm">
                    <button class="pb-3 text-primary-700 border-b-2 border-primary-700 outline-none transition-colors" id="btn-tab-detail">Detail Produk</button>
                    <button class="pb-3 text-neutral-400 hover:text-neutral-600 outline-none transition-colors" id="btn-tab-spec">Spesifikasi</button>
                </div>
            </div>

            <!-- Tab Contents -->
            <div class="space-y-4 text-sm leading-relaxed text-neutral-600">
                <!-- Detail Tab Content -->
                <div id="content-detail" class="space-y-3">
                    <p>{{ $desc }}</p>
                    <div class="pt-4 grid grid-cols-2 gap-y-3 gap-x-4 border-t border-neutral-100 text-xs font-semibold">
                        <div>
                            <span class="text-neutral-400 block font-normal">Kondisi</span>
                            <span class="text-neutral-700">Baru</span>
                        </div>
                        <div>
                            <span class="text-neutral-400 block font-normal">Min. Pemesanan</span>
                            <span class="text-neutral-700">1 Buah</span>
                        </div>
                        <div>
                            <span class="text-neutral-400 block font-normal">Kategori</span>
                            <span class="text-primary-700 hover:underline cursor-pointer">{{ $categoryName }}</span>
                        </div>
                        <div>
                            <span class="text-neutral-400 block font-normal">Berat Satuan</span>
                            <span class="text-neutral-700">{{ $weight }}</span>
                        </div>
                    </div>
                </div>

                <!-- Spec Tab Content -->
                <div id="content-spec" class="hidden space-y-2">
                    <table class="w-full text-left border-collapse">
                        <tbody>
                            <tr class="border-b border-neutral-100"><td class="py-2.5 font-bold text-neutral-400 w-1/3">Kategori</td><td class="py-2.5 text-neutral-700 font-semibold">{{ $categoryName }}</td></tr>
                            <tr class="border-b border-neutral-100"><td class="py-2.5 font-bold text-neutral-400">Berat</td><td class="py-2.5 text-neutral-700 font-semibold">{{ $weight }}</td></tr>
                            <tr class="border-b border-neutral-100"><td class="py-2.5 font-bold text-neutral-400">Masa Penyimpanan</td><td class="py-2.5 text-neutral-700 font-semibold">Tergantung kemasan</td></tr>
                            <tr class="border-b border-neutral-100"><td class="py-2.5 font-bold text-neutral-400">Penyimpanan</td><td class="py-2.5 text-neutral-700 font-semibold">Suhu Ruangan / Dingin</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Right Column: Cart Action Card (3 cols) -->
        <div class="lg:col-span-3">
            <div class="border border-neutral-200 rounded-2xl p-5 shadow-sm space-y-5 sticky top-24 bg-white">
                <h4 class="font-heading font-extrabold text-sm text-neutral-800">Atur jumlah dan catatan</h4>
                
                <!-- Variant Label -->
                <div class="flex items-center gap-2">
                    <span class="inline-flex px-2.5 py-1 bg-neutral-100 text-neutral-600 font-bold text-xs rounded-lg">{{ $weight }}</span>
                </div>

                <!-- Quantity Selector -->
                <div class="flex items-center gap-3">
                    <div class="flex items-center border-2 border-neutral-200 rounded-xl overflow-hidden shrink-0">
                        <button class="w-10 h-10 bg-neutral-50 hover:bg-neutral-100 flex items-center justify-center font-bold text-lg text-neutral-600 transition-colors outline-none select-none" onclick="changeQty(-1)">-</button>
                        <input type="text" value="1" class="w-12 h-10 text-center font-bold text-sm text-neutral-800 outline-none border-x border-neutral-200 bg-white" id="qty-input" readonly>
                        <button class="w-10 h-10 bg-neutral-50 hover:bg-neutral-100 flex items-center justify-center font-bold text-lg text-neutral-600 transition-colors outline-none select-none" onclick="changeQty(1)">+</button>
                    </div>
                    <span class="text-xs font-bold text-neutral-400">
                        @if($stok > 0)
                        Stok: <span class="text-neutral-700">{{ $stok }}</span>
                        @else
                        Stok: <span class="text-red-600 font-bold">Habis</span>
                        @endif
                    </span>
                </div>

                <!-- Subtotal -->
                <div class="flex items-center justify-between pt-3 border-t border-neutral-100">
                    <span class="text-xs font-bold text-neutral-400">Subtotal</span>
                    <span class="font-extrabold text-lg text-neutral-800" id="subtotal-price">Rp 0</span>
                </div>

                <!-- Action Buttons -->
                <div class="space-y-2.5 pt-1">
                    <button class="w-full bg-primary-700 hover:bg-primary-600 active:bg-primary-800 text-white font-bold py-3 rounded-xl transition-all duration-200 shadow-md shadow-primary-700/10 hover:shadow-lg flex items-center justify-center gap-2 {{ $stok <= 0 ? 'opacity-50 pointer-events-none' : '' }}" id="btn-add-to-cart" {{ $stok <= 0 ? 'disabled' : '' }}>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                        <span>+ Keranjang</span>
                    </button>
                    <button class="w-full bg-white hover:bg-neutral-50 active:bg-neutral-100 text-primary-700 border-2 border-primary-700 font-bold py-2.5 rounded-xl transition-all {{ $stok <= 0 ? 'opacity-50 pointer-events-none' : '' }}" id="btn-buy-now" {{ $stok <= 0 ? 'disabled' : '' }}>
                        Beli Langsung
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<meta name="csrf-token" content="{{ csrf_token() }}">
<script>
    const unitPrice = {{ $activePrice }};
    const maxStok = {{ $stok }};
    const qtyInput = document.getElementById('qty-input');
    const subtotalPrice = document.getElementById('subtotal-price');
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    function formatRupiah(num) {
        return 'Rp ' + new Intl.NumberFormat('id-ID').format(num);
    }

    function updateSubtotal() {
        const qty = parseInt(qtyInput.value) || 1;
        subtotalPrice.textContent = formatRupiah(unitPrice * qty);
    }

    window.changeQty = function(amount) {
        if (maxStok <= 0) return;
        let qty = parseInt(qtyInput.value) || 1;
        qty += amount;
        if (qty < 1) qty = 1;
        if (qty > maxStok) qty = maxStok;
        qtyInput.value = qty;
        updateSubtotal();
    }

    // Tab switcher
    const btnTabDetail = document.getElementById('btn-tab-detail');
    const btnTabSpec = document.getElementById('btn-tab-spec');
    const contentDetail = document.getElementById('content-detail');
    const contentSpec = document.getElementById('content-spec');

    if (btnTabDetail && btnTabSpec) {
        btnTabDetail.addEventListener('click', function() {
            btnTabDetail.className = 'pb-3 text-primary-700 border-b-2 border-primary-700 outline-none transition-colors';
            btnTabSpec.className = 'pb-3 text-neutral-400 hover:text-neutral-600 outline-none transition-colors';
            contentDetail.classList.remove('hidden');
            contentSpec.classList.add('hidden');
        });

        btnTabSpec.addEventListener('click', function() {
            btnTabSpec.className = 'pb-3 text-primary-700 border-b-2 border-primary-700 outline-none transition-colors';
            btnTabDetail.className = 'pb-3 text-neutral-400 hover:text-neutral-600 outline-none transition-colors';
            contentSpec.classList.remove('hidden');
            contentDetail.classList.add('hidden');
        });
    }

    // Thumbnail gallery selector
    window.changeImage = function(url, el) {
        const mainImg = document.getElementById('main-product-img');
        if (mainImg) mainImg.src = url;
        const thumbnails = [document.getElementById('thumb-1'), document.getElementById('thumb-2'), document.getElementById('thumb-3')];
        thumbnails.forEach(t => {
            if (t) {
                t.className = 'w-16 h-16 rounded-xl border-2 border-neutral-200 overflow-hidden cursor-pointer bg-neutral-50 hover:border-primary-700 transition-all shadow-sm opacity-60 hover:opacity-100';
            }
        });
        if (el) el.className = 'w-16 h-16 rounded-xl border-2 border-primary-700 overflow-hidden cursor-pointer bg-neutral-50 hover:border-primary-700 transition-all shadow-sm';
    }

    function showToast(message, isError) {
        const existing = document.getElementById('cart-toast');
        if (existing) existing.remove();
        const toast = document.createElement('div');
        toast.id = 'cart-toast';
        toast.className = 'fixed bottom-6 right-6 z-[9999] px-5 py-3 rounded-xl shadow-2xl text-sm font-bold text-white transition-all duration-300 flex items-center gap-2';
        toast.style.cssText = isError ? 'background:#ef4444;' : 'background:linear-gradient(135deg,#33116C,#7733e6);';
        toast.innerHTML = (isError ? '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>' : '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>') + '<span>' + message + '</span>';
        document.body.appendChild(toast);
        setTimeout(() => { toast.style.opacity = '0'; setTimeout(() => toast.remove(), 300); }, 2500);
    }

    function updateCartBadge(count) {
        let badge = document.getElementById('cart-badge');
        if (badge) {
            badge.style.display = count > 0 ? 'block' : 'none';
        }
    }

    function addToCart(qty, redirect = false) {
        if (maxStok <= 0) return;
        const btn = redirect ? document.getElementById('btn-buy-now') : document.getElementById('btn-add-to-cart');
        btn.disabled = true;
        btn.classList.add('opacity-50', 'pointer-events-none');

        fetch('{{ route("cart.add") }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
            body: JSON.stringify({ product_name: '{{ $product->nama_produk }}', quantity: qty })
        })
        .then(r => r.json())
        .then(data => {
            btn.disabled = false;
            btn.classList.remove('opacity-50', 'pointer-events-none');
            if (data.success) {
                updateCartBadge(data.cart_count);
                if (redirect) {
                    window.location.href = '{{ route("pelanggan.keranjang") }}';
                } else {
                    showToast(data.message, false);
                }
            } else {
                showToast(data.message || 'Gagal menambahkan ke keranjang', true);
            }
        })
        .catch(() => {
            btn.disabled = false;
            btn.classList.remove('opacity-50', 'pointer-events-none');
            showToast('Terjadi kesalahan jaringan', true);
        });
    }

    if (document.getElementById('btn-add-to-cart')) {
        document.getElementById('btn-add-to-cart').addEventListener('click', function() {
            const qty = parseInt(qtyInput.value) || 1;
            addToCart(qty, false);
        });
    }

    if (document.getElementById('btn-buy-now')) {
        document.getElementById('btn-buy-now').addEventListener('click', function() {
            const qty = parseInt(qtyInput.value) || 1;
            addToCart(qty, true);
        });
    }

    // Initialize subtotal
    updateSubtotal();
</script>
@endpush
