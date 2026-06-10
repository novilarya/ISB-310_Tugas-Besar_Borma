@extends('layouts.pelanggan')
@section('title', 'Katalog Produk')

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
$activeCategory = request('kategori', '');
$categoryLabel = $activeCategory ? ($categories[$activeCategory] ?? 'Semua Produk') : 'Semua Produk';

$selectedCabang = null;
if (session()->has('selected_cabang_id')) {
    $selectedCabang = \App\Models\Cabang::find(session('selected_cabang_id'));
}
$branchId = session('selected_cabang_id', 1);

$query = \App\Models\ProdukCabang::with('produk')
    ->where('id_cabang', $branchId)
    ->whereHas('produk')
    ->where('jumlah_stok', '>', 0);

if ($activeCategory && isset($categories[$activeCategory])) {
    $dbCategory = $categories[$activeCategory];
    $query->whereHas('produk', function($q) use ($dbCategory) {
        $q->where('kategori', $dbCategory);
    });
}

$filtered = $query->get();
$productCount = $filtered->count();
@endphp

@section('content')
<div class="pb-10">
    @if($selectedCabang)
    <!-- Compact Active Branch Card -->
    <div class="mb-6 bg-white border border-neutral-200 shadow-sm rounded-2xl p-4 flex items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 bg-primary-50 rounded-xl flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-primary-700" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349M3.75 21V9.349m0 0a3.001 3.001 0 0 0 3.75-.615A2.993 2.993 0 0 0 9.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 0 0 2.25 1.016c.896 0 1.7-.393 2.25-1.016A3.001 3.001 0 0 0 20.25 9.35m-16.5 0a3.004 3.004 0 0 1-.621-4.72l1.189-1.19A1.5 1.5 0 0 1 5.378 3h13.243a1.5 1.5 0 0 1 1.06.44l1.19 1.189a3 3 0 0 1-.621 4.72"/></svg>
            </div>
            <div>
                <p class="text-[10px] text-neutral-400 font-extrabold uppercase tracking-wide">Cabang Belanja Dipilih</p>
                <h4 class="font-bold text-sm text-neutral-800">{{ $selectedCabang->nama_cabang }}</h4>
            </div>
        </div>
        <button onclick="openBranchSelectorModal()" class="text-xs font-bold text-primary-700 hover:text-primary-950 bg-primary-50 hover:bg-primary-100 border border-primary-200 px-3 py-1.5 rounded-lg transition-colors cursor-pointer shrink-0">
            Ganti Cabang
        </button>
    </div>
    @endif

    <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-8 border-b border-neutral-200 pb-5 gap-4">
        <div>
            <h2 class="font-heading font-extrabold text-3xl sm:text-4xl text-neutral-800 mb-2 tracking-tight">{{ $categoryLabel }}</h2>
            <p class="text-neutral-500 font-medium text-sm">Menampilkan {{ $productCount }} produk berkualitas untuk Anda</p>
        </div>
    </div>

    <div id="product-grid" class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
        @foreach($filtered as $productCabang)
        @php
            $product = $productCabang->produk;
            $sale = $product->harga_member < $product->harga_reguler ? $product->harga_member : 0;
        @endphp
        <a href="{{ route('pelanggan.produk.detail', ['slug' => Str::slug($product->nama_produk)]) }}" class="product-card bg-white rounded-2xl border border-neutral-200 shadow-sm hover:shadow-md hover:border-primary-300 transition-all duration-300 group flex flex-col overflow-hidden no-underline" data-name="{{ strtolower($product->nama_produk) }}" data-price="{{ $sale > 0 ? $sale : $product->harga_reguler }}">
            <div class="relative bg-neutral-50 flex items-center justify-center border-b border-neutral-100 overflow-hidden aspect-square">
                @if($sale > 0)
                <div class="absolute top-3 right-3 z-10">
                    <span class="bg-tertiary-400 text-white text-[10px] font-bold px-2 py-1 rounded shadow-sm tracking-wider">HEMAT {{ round((($product->harga_reguler - $sale) / $product->harga_reguler) * 100) }}%</span>
                </div>
                @endif
                @if($product->gambar_produk)
                <img src="{{ asset('assets/products/'.$product->gambar_produk) }}" alt="{{ $product->nama_produk }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                @else
                <!-- SVG Fallback Placeholder -->
                <div class="w-full h-full flex flex-col items-center justify-center bg-neutral-100 text-neutral-400 p-4">
                    <svg class="w-12 h-12 mb-2 stroke-current opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span class="text-[10px] font-semibold uppercase tracking-wider">No Image</span>
                </div>
                @endif
            </div>
            <div class="p-4 flex flex-col flex-1">
                <p class="text-[10px] font-bold text-neutral-400 uppercase tracking-wider mb-1">{{ $product->kategori }}</p>
                <h4 class="font-bold text-sm text-neutral-800 mb-2 leading-tight group-hover:text-primary-700 transition-colors line-clamp-2">{{ $product->nama_produk }}</h4>
                <div class="mt-auto space-y-2">
                    @if($sale > 0)
                    <div class="flex items-center gap-2">
                        <span class="text-xs text-neutral-400 line-through">Rp {{ number_format($product->harga_reguler,0,',','.') }}</span>
                    </div>
                    <div class="flex items-end justify-between">
                        <span class="font-extrabold text-lg text-primary-700">Rp {{ number_format($sale,0,',','.') }}</span>
                        <button class="btn-add-cart w-8 h-8 bg-primary-50 hover:bg-primary-700 rounded-lg flex items-center justify-center text-primary-700 hover:text-white transition-colors" data-product="{{ $product->nama_produk }}"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"></path></svg></button>
                    </div>
                    @else
                    <div class="flex items-end justify-between">
                        <span class="font-extrabold text-lg text-neutral-800">Rp {{ number_format($product->harga_reguler,0,',','.') }}</span>
                        <button class="btn-add-cart w-8 h-8 bg-primary-50 hover:bg-primary-700 rounded-lg flex items-center justify-center text-primary-700 hover:text-white transition-colors" data-product="{{ $product->nama_produk }}"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"></path></svg></button>
                    </div>
                    @endif
                </div>
            </div>
        </a>
        @endforeach
    </div>
</div>

<!-- No results message -->
<div id="no-results" class="hidden col-span-full text-center py-16">
    <div class="w-16 h-16 bg-neutral-100 rounded-full flex items-center justify-center mx-auto mb-4">
        <svg class="w-8 h-8 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
    </div>
    <p class="font-bold text-neutral-700 mb-1">Produk tidak ditemukan</p>
    <p class="text-sm text-neutral-400">Coba kata kunci lain</p>
</div>
@endsection

@push('scripts')
<meta name="csrf-token" content="{{ csrf_token() }}">
<script>
document.addEventListener('DOMContentLoaded', function() {
    // === Filtering System (Search & Price) ===
    const searchInput = document.getElementById('sidebar-search');
    const minPriceInput = document.getElementById('price-min-input');
    const maxPriceInput = document.getElementById('price-max-input');
    const grid = document.getElementById('product-grid');
    const noResults = document.getElementById('no-results');

    function applyFilters() {
        if (!grid) return;
        const query = searchInput ? searchInput.value.toLowerCase().trim() : '';
        const minVal = minPriceInput ? minPriceInput.value.trim() : '';
        const maxVal = maxPriceInput ? maxPriceInput.value.trim() : '';

        const minPrice = minVal !== '' ? parseFloat(minVal) : null;
        const maxPrice = maxVal !== '' ? parseFloat(maxVal) : null;

        const cards = grid.querySelectorAll('.product-card');
        let visibleCount = 0;

        cards.forEach(card => {
            const name = card.getAttribute('data-name') || '';
            const price = parseFloat(card.getAttribute('data-price') || '0');

            const matchSearch = !query || name.includes(query);
            const matchMin = minPrice === null || isNaN(minPrice) || price >= minPrice;
            const matchMax = maxPrice === null || isNaN(maxPrice) || price <= maxPrice;

            const match = matchSearch && matchMin && matchMax;
            card.style.display = match ? '' : 'none';
            if (match) visibleCount++;
        });

        if (noResults) {
            if (visibleCount === 0) {
                noResults.classList.remove('hidden');
                if (!noResults.parentNode || noResults.parentNode !== grid) {
                    grid.appendChild(noResults);
                }
            } else {
                noResults.classList.add('hidden');
            }
        }
    }

    if (searchInput) {
        searchInput.addEventListener('input', applyFilters);
    }
    if (minPriceInput) {
        minPriceInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                applyFilters();
            }
        });
    }
    if (maxPriceInput) {
        maxPriceInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                applyFilters();
            }
        });
    }

    // === Add to cart AJAX ===
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    function showToast(message, isError) {
        const existing = document.getElementById('cart-toast');
        if (existing) existing.remove();
        const toast = document.createElement('div');
        toast.id = 'cart-toast';
        toast.className = 'fixed bottom-6 right-6 z-[9999] px-5 py-3 rounded-xl shadow-2xl text-sm font-bold text-white transition-all duration-300 flex items-center gap-2';
        toast.style.cssText = isError ? 'background:#ef4444;' : 'background:linear-gradient(135deg,#1a5632,#22c55e);';
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

    document.querySelectorAll('.btn-add-cart').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const productName = this.dataset.product;
            const btnEl = this;
            btnEl.disabled = true;
            btnEl.classList.add('pointer-events-none', 'opacity-50');

            fetch('{{ route("cart.add") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
                body: JSON.stringify({ product_name: productName })
            })
            .then(r => r.json())
            .then(data => {
                btnEl.disabled = false;
                btnEl.classList.remove('pointer-events-none', 'opacity-50');
                if (data.success) {
                    showToast(data.message, false);
                    updateCartBadge(data.cart_count);
                    // Quick scale animation
                    btnEl.style.transform = 'scale(1.3)';
                    setTimeout(() => btnEl.style.transform = '', 200);
                } else {
                    showToast(data.message || 'Gagal menambahkan produk', true);
                }
            })
            .catch(() => {
                btnEl.disabled = false;
                btnEl.classList.remove('pointer-events-none', 'opacity-50');
                showToast('Terjadi kesalahan jaringan', true);
            });
        });
    });

    // Load initial cart count
    fetch('{{ route("cart.count") }}')
        .then(r => r.json())
        .then(data => updateCartBadge(data.cart_count))
        .catch(() => {});
});
</script>
@endpush
