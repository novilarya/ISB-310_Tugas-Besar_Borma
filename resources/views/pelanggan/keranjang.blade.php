@extends('layouts.checkout')

@section('title', 'Keranjang Belanja')

@section('content')
<div class="pb-10">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-end justify-between border-b border-neutral-200 pb-5 mb-6 gap-3">
        <div>
            <h2 class="font-heading font-extrabold text-2xl sm:text-3xl text-neutral-800 tracking-tight">Keranjang Belanja</h2>
            <p class="text-neutral-400 font-medium text-sm mt-1">Anda memiliki <span class="text-primary-700 font-bold" id="header-count">{{ collect($cart)->sum('quantity') }} produk</span> di keranjang</p>
        </div>
        <a href="{{ route('pelanggan.katalog') }}" class="text-primary-600 font-bold text-sm hover:text-primary-800 transition-colors flex items-center gap-1 shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            Lanjut Belanja
        </a>
    </div>

    @if(count($cart) > 0)
    <!-- Two Column Layout -->
    <div class="flex flex-col lg:flex-row gap-6 lg:gap-8 items-start">

        <!-- Left: Product List -->
        <div class="flex-1 min-w-0 w-full">
            <!-- Table Header (Desktop) -->
            <div class="hidden md:grid grid-cols-12 gap-4 text-[10px] font-bold text-neutral-400 uppercase tracking-wider px-5 pb-3">
                <div class="col-span-5">Produk</div>
                <div class="col-span-2 text-center">Harga Satuan</div>
                <div class="col-span-2 text-center">Jumlah</div>
                <div class="col-span-2 text-right">Subtotal</div>
                <div class="col-span-1"></div>
            </div>

            <!-- Cart Items -->
            <div class="space-y-3" id="cart-items">
                @foreach($cart as $key => $item)
                <div class="cart-item bg-white rounded-2xl border border-neutral-200 shadow-sm hover:shadow-md hover:border-primary-200 transition-all duration-300 px-5 py-4" data-key="{{ $key }}">
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                        <!-- Product Info -->
                        <div class="col-span-5 flex items-center gap-4">
                            <div class="w-16 h-16 bg-neutral-50 rounded-xl border border-neutral-100 flex items-center justify-center p-1.5 shrink-0 overflow-hidden">
                                @if(!empty($item['img']))
                                <img src="{{ asset('images/products/'.$item['img']) }}" alt="{{ $item['name'] }}" class="max-w-full max-h-full object-contain rounded-lg" onerror="this.style.display='none';this.nextElementSibling.style.display='block';">
                                <svg class="w-8 h-8 text-neutral-300" style="display:none;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                @else
                                <svg class="w-8 h-8 text-neutral-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                @endif
                            </div>
                            <div class="min-w-0">
                                <p class="text-[10px] font-bold text-neutral-400 uppercase tracking-wider mb-0.5">{{ $categories[$item['category']] ?? $item['category'] }}</p>
                                <h4 class="font-bold text-sm text-neutral-800 leading-tight truncate">{{ $item['name'] }}</h4>
                            </div>
                        </div>
                        <!-- Unit Price -->
                        <div class="col-span-2 text-center">
                            @if(isset($item['original_price']) && $item['original_price'] > $item['price'])
                            <p class="text-xs text-neutral-400 line-through">Rp {{ number_format($item['original_price'],0,',','.') }}</p>
                            @endif
                            <p class="font-semibold text-sm text-neutral-600">Rp {{ number_format($item['price'],0,',','.') }}</p>
                        </div>
                        <!-- Quantity -->
                        <div class="col-span-2 flex justify-center">
                            <div class="inline-flex items-center bg-neutral-50 rounded-xl border border-neutral-200 h-9">
                                <button class="btn-qty-dec w-8 h-full flex items-center justify-center text-neutral-400 hover:text-primary-700 hover:bg-primary-50 rounded-l-xl transition-colors" data-key="{{ $key }}">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 12H4"></path></svg>
                                </button>
                                <span class="item-qty w-9 text-center font-bold text-sm text-neutral-800 border-x border-neutral-200 leading-9">{{ $item['quantity'] }}</span>
                                <button class="btn-qty-inc w-8 h-full flex items-center justify-center text-neutral-400 hover:text-primary-700 hover:bg-primary-50 rounded-r-xl transition-colors" data-key="{{ $key }}">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                                </button>
                            </div>
                        </div>
                        <!-- Subtotal -->
                        <div class="col-span-2 text-right">
                            <p class="item-subtotal font-extrabold text-sm text-primary-700">Rp {{ number_format($item['price'] * $item['quantity'],0,',','.') }}</p>
                        </div>
                        <!-- Delete -->
                        <div class="col-span-1 flex justify-end">
                            <button class="btn-remove w-8 h-8 bg-tertiary-50 hover:bg-tertiary-100 rounded-lg flex items-center justify-center text-tertiary-400 hover:text-tertiary-500 transition-colors" data-key="{{ $key }}" title="Hapus produk">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Right: Order Summary Sidebar (Sticky) -->
        <div class="w-full lg:w-[340px] xl:w-[360px] shrink-0">
            <div class="lg:sticky lg:top-28">
                <div class="bg-white rounded-2xl border border-neutral-200 shadow-sm p-6">
                    <h3 class="font-heading font-extrabold text-base text-neutral-800 mb-5 pb-3 border-b border-neutral-100">Ringkasan Belanja</h3>

                    <div class="space-y-3 mb-5">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-neutral-500">Total Harga (<span id="summary-qty">{{ collect($cart)->sum('quantity') }}</span> barang)</span>
                            <span class="font-semibold text-sm text-neutral-800" id="summary-subtotal">Rp {{ number_format(collect($cart)->sum(fn($i) => $i['price'] * $i['quantity']),0,',','.') }}</span>
                        </div>
                    </div>

                    <!-- Total -->
                    <div class="border-t border-neutral-200 pt-4 mb-5">
                        <div class="flex justify-between items-end">
                            <span class="text-sm font-bold text-neutral-800">Total Bayar</span>
                            <span class="font-heading font-extrabold text-xl text-primary-700" id="summary-total">Rp {{ number_format(collect($cart)->sum(fn($i) => $i['price'] * $i['quantity']),0,',','.') }}</span>
                        </div>
                    </div>

                    <!-- Checkout Button -->
                    <a href="{{ route('pelanggan.checkout') }}" id="btn-checkout" class="w-full flex items-center justify-center gap-2 py-3.5 bg-primary-700 hover:bg-primary-600 text-white text-sm font-bold rounded-xl transition-all duration-200 shadow-md hover:shadow-lg active:scale-[0.98]">
                        <span>Lanjut ke Pembayaran</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                </div>
            </div>
        </div>

    </div>
    @else
    <!-- Empty Cart -->
    <div class="flex flex-col items-center justify-center min-h-[65vh]">
        <h3 class="font-heading font-extrabold text-xl text-neutral-700 mb-2">Keranjang Kosong</h3>
        <p class="text-neutral-400 text-sm mb-6">Belum ada produk di keranjang Anda. Yuk mulai belanja!</p>
        <a href="{{ route('pelanggan.katalog') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-primary-700 hover:bg-primary-600 text-white text-sm font-bold rounded-xl transition-all shadow-md hover:shadow-lg">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
            Mulai Belanja
        </a>
    </div>
    @endif

</div>
@endsection

@push('scripts')
<meta name="csrf-token" content="{{ csrf_token() }}">
<script>
document.addEventListener('DOMContentLoaded', function() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    function formatRp(n) {
        return 'Rp ' + n.toLocaleString('id-ID');
    }

    function recalcSummary(cartData) {
        let totalQty = 0, totalPrice = 0;
        for (const key in cartData) {
            totalQty += cartData[key].quantity;
            totalPrice += cartData[key].price * cartData[key].quantity;
        }
        const summaryQty = document.getElementById('summary-qty');
        const summarySubtotal = document.getElementById('summary-subtotal');
        const summaryTotal = document.getElementById('summary-total');
        const headerCount = document.getElementById('header-count');
        if (summaryQty) summaryQty.textContent = totalQty;
        if (summarySubtotal) summarySubtotal.textContent = formatRp(totalPrice);
        if (summaryTotal) summaryTotal.textContent = formatRp(totalPrice);
        if (headerCount) headerCount.textContent = totalQty + ' produk';

        // If cart is empty, reload to show empty state
        if (totalQty === 0) {
            setTimeout(() => window.location.reload(), 300);
        }
    }

    function cartAction(key, action) {
        const url = action === 'remove' ? '{{ route("cart.remove") }}' : '{{ route("cart.update") }}';
        const body = action === 'remove' ? { key: key } : { key: key, action: action };

        return fetch(url, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
            body: JSON.stringify(body)
        }).then(r => r.json());
    }

    // Increment
    document.querySelectorAll('.btn-qty-inc').forEach(btn => {
        btn.addEventListener('click', function() {
            const key = this.dataset.key;
            const row = document.querySelector(`.cart-item[data-key="${key}"]`);
            cartAction(key, 'increment').then(data => {
                if (data.success && data.cart[key]) {
                    const item = data.cart[key];
                    row.querySelector('.item-qty').textContent = item.quantity;
                    row.querySelector('.item-subtotal').textContent = formatRp(item.price * item.quantity);
                    recalcSummary(data.cart);
                }
            });
        });
    });

    // Decrement
    document.querySelectorAll('.btn-qty-dec').forEach(btn => {
        btn.addEventListener('click', function() {
            const key = this.dataset.key;
            const row = document.querySelector(`.cart-item[data-key="${key}"]`);
            cartAction(key, 'decrement').then(data => {
                if (data.success) {
                    if (!data.cart[key]) {
                        // Item removed (qty was 1)
                        row.style.transition = 'all 0.3s ease';
                        row.style.opacity = '0';
                        row.style.transform = 'translateX(20px)';
                        setTimeout(() => row.remove(), 300);
                    } else {
                        const item = data.cart[key];
                        row.querySelector('.item-qty').textContent = item.quantity;
                        row.querySelector('.item-subtotal').textContent = formatRp(item.price * item.quantity);
                    }
                    recalcSummary(data.cart);
                }
            });
        });
    });

    // Remove
    document.querySelectorAll('.btn-remove').forEach(btn => {
        btn.addEventListener('click', function() {
            const key = this.dataset.key;
            const row = document.querySelector(`.cart-item[data-key="${key}"]`);
            if (!confirm('Hapus produk ini dari keranjang?')) return;
            cartAction(key, 'remove').then(data => {
                if (data.success) {
                    row.style.transition = 'all 0.3s ease';
                    row.style.opacity = '0';
                    row.style.transform = 'translateX(20px)';
                    setTimeout(() => row.remove(), 300);
                    recalcSummary(data.cart);
                }
            });
        });
    });
});
</script>
@endpush
