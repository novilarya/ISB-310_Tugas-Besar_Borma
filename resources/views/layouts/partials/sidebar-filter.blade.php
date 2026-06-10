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
@endphp
<style>
/* Hide scrollbar for Chrome, Safari and Opera */
.sidebar-filter-container::-webkit-scrollbar {
    display: none;
}
/* Hide scrollbar for IE, Edge and Firefox */
.sidebar-filter-container {
    -ms-overflow-style: none;  /* IE and Edge */
    scrollbar-width: none;  /* Firefox */
}
</style>
<aside class="w-64 shrink-0 hidden lg:block">
    <div class="sticky top-24 bg-white p-6 rounded-2xl border border-neutral-200 shadow-sm max-h-[calc(100vh-120px)] overflow-y-auto overscroll-contain sidebar-filter-container">
        <div class="mb-6">
            <h2 class="font-heading font-extrabold text-lg text-primary-700 uppercase tracking-wide">Filter Produk</h2>
            <p class="text-[10px] font-bold text-neutral-400 mt-1 uppercase tracking-wider">Sesuai Pencarian Anda</p>
        </div>

        <!-- Search -->
        <div class="mb-6">
            <div class="relative">
                <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" id="sidebar-search" placeholder="Cari produk..." class="w-full pl-10 pr-4 py-2.5 bg-neutral-50 border border-neutral-200 rounded-xl text-sm text-neutral-700 placeholder-neutral-400 focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-all outline-none">
            </div>
        </div>

        <div class="space-y-6">
            <!-- Kategori Utama -->
            <div>
                <h3 class="text-[11px] font-bold text-neutral-500 uppercase tracking-widest mb-4">Kategori Utama</h3>
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('pelanggan.katalog') }}" class="flex items-center gap-3 text-sm font-semibold {{ $activeCategory === '' ? 'text-primary-700 bg-primary-50 border border-primary-100' : 'text-neutral-600 hover:text-primary-700 hover:bg-neutral-50' }} px-3 py-2.5 rounded-xl transition-colors">
                            <span class="w-2 h-2 rounded-full {{ $activeCategory === '' ? 'bg-secondary-400' : 'bg-neutral-300' }}"></span>
                            SEMUA PRODUK
                        </a>
                    </li>
                    @foreach($categories as $slug => $name)
                    <li>
                        <a href="{{ route('pelanggan.katalog', ['kategori' => $slug]) }}" class="flex items-center gap-3 text-sm font-semibold {{ $activeCategory === $slug ? 'text-primary-700 bg-primary-50 border border-primary-100' : 'text-neutral-600 hover:text-primary-700 hover:bg-neutral-50' }} px-3 py-2.5 rounded-xl transition-colors">
                            @if($activeCategory === $slug)
                            <span class="w-2 h-2 rounded-full bg-secondary-400"></span>
                            @else
                            <svg class="w-4 h-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            @endif
                            {{ strtoupper($name) }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>

            <div class="h-px w-full bg-neutral-200"></div>

            <!-- Harga -->
            <div>
                <h3 class="text-[11px] font-bold text-neutral-500 uppercase tracking-widest mb-3">Harga</h3>
                <div class="space-y-3">
                    <div class="grid grid-cols-2 gap-2">
                        <div class="bg-neutral-50 border border-neutral-200 rounded-xl px-3 py-2.5 transition-all focus-within:border-primary-500 focus-within:ring-2 focus-within:ring-primary-100">
                            <label for="price-min-input" class="block text-[9px] font-bold text-neutral-400 uppercase tracking-wider mb-1">Min (Rp)</label>
                            <input type="number" id="price-min-input" placeholder="0" class="w-full bg-transparent border-0 p-0 text-xs font-extrabold text-neutral-800 focus:ring-0 focus:outline-none [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                        </div>
                        <div class="bg-neutral-50 border border-neutral-200 rounded-xl px-3 py-2.5 transition-all focus-within:border-primary-500 focus-within:ring-2 focus-within:ring-primary-100">
                            <label for="price-max-input" class="block text-[9px] font-bold text-neutral-400 uppercase tracking-wider mb-1">Max (Rp)</label>
                            <input type="number" id="price-max-input" placeholder="5.000.000" class="w-full bg-transparent border-0 p-0 text-xs font-extrabold text-neutral-800 focus:ring-0 focus:outline-none [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                        </div>
                    </div>
                    <p class="text-[9px] text-neutral-400 font-semibold italic text-center">Tekan <span class="font-bold not-italic bg-neutral-200 text-neutral-700 px-1 py-0.5 rounded text-[9px]">Enter</span> untuk memfilter</p>
                </div>
            </div>

            <div class="h-px w-full bg-neutral-200"></div>

            <!-- Urutkan -->
            <div>
                <h3 class="text-[11px] font-bold text-neutral-500 uppercase tracking-widest mb-3">Urutkan</h3>
                <div class="relative group">
                    <select class="w-full bg-white border border-neutral-300 rounded-xl text-sm font-semibold text-neutral-700 py-3 pl-4 pr-10 appearance-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition-colors outline-none cursor-pointer group-hover:border-neutral-400">
                        <option>TERBARU</option>
                        <option>HARGA TERTINGGI</option>
                        <option>HARGA TERENDAH</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-neutral-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
</aside>
