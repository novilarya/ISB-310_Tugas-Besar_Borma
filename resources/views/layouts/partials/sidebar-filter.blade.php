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
<aside class="w-64 shrink-0 hidden lg:block">
    <div class="sticky top-24 bg-white p-6 rounded-2xl border border-neutral-200 shadow-sm">
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
                <div class="space-y-4">
                    <div class="flex items-center justify-between text-xs font-semibold text-neutral-600">
                        <span id="price-min-label">Rp 0</span>
                        <span id="price-max-label">Rp 5.000.000</span>
                    </div>
                    <div class="price-slider-container relative h-2">
                        <div class="absolute inset-0 bg-neutral-200 rounded-full"></div>
                        <div id="price-track" class="absolute top-0 h-full bg-primary-500 rounded-full" style="left: 0%; width: 100%;"></div>
                        <input type="range" id="price-range-min" min="0" max="5000000" step="50000" value="0" class="price-slider absolute w-full h-2 top-0 appearance-none bg-transparent pointer-events-none [&::-webkit-slider-thumb]:pointer-events-auto [&::-webkit-slider-thumb]:appearance-none [&::-webkit-slider-thumb]:w-5 [&::-webkit-slider-thumb]:h-5 [&::-webkit-slider-thumb]:rounded-full [&::-webkit-slider-thumb]:bg-white [&::-webkit-slider-thumb]:border-3 [&::-webkit-slider-thumb]:border-primary-600 [&::-webkit-slider-thumb]:shadow-md [&::-webkit-slider-thumb]:cursor-pointer [&::-webkit-slider-thumb]:transition-transform [&::-webkit-slider-thumb]:hover:scale-110 [&::-moz-range-thumb]:pointer-events-auto [&::-moz-range-thumb]:appearance-none [&::-moz-range-thumb]:w-5 [&::-moz-range-thumb]:h-5 [&::-moz-range-thumb]:rounded-full [&::-moz-range-thumb]:bg-white [&::-moz-range-thumb]:border-3 [&::-moz-range-thumb]:border-primary-600 [&::-moz-range-thumb]:shadow-md [&::-moz-range-thumb]:cursor-pointer">
                        <input type="range" id="price-range-max" min="0" max="5000000" step="50000" value="5000000" class="price-slider absolute w-full h-2 top-0 appearance-none bg-transparent pointer-events-none [&::-webkit-slider-thumb]:pointer-events-auto [&::-webkit-slider-thumb]:appearance-none [&::-webkit-slider-thumb]:w-5 [&::-webkit-slider-thumb]:h-5 [&::-webkit-slider-thumb]:rounded-full [&::-webkit-slider-thumb]:bg-white [&::-webkit-slider-thumb]:border-3 [&::-webkit-slider-thumb]:border-primary-600 [&::-webkit-slider-thumb]:shadow-md [&::-webkit-slider-thumb]:cursor-pointer [&::-webkit-slider-thumb]:transition-transform [&::-webkit-slider-thumb]:hover:scale-110 [&::-moz-range-thumb]:pointer-events-auto [&::-moz-range-thumb]:appearance-none [&::-moz-range-thumb]:w-5 [&::-moz-range-thumb]:h-5 [&::-moz-range-thumb]:rounded-full [&::-moz-range-thumb]:bg-white [&::-moz-range-thumb]:border-3 [&::-moz-range-thumb]:border-primary-600 [&::-moz-range-thumb]:shadow-md [&::-moz-range-thumb]:cursor-pointer">
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <div class="bg-neutral-50 border border-neutral-200 rounded-lg px-3 py-2 text-center">
                            <p class="text-[9px] font-bold text-neutral-400 uppercase tracking-wider mb-0.5">Min</p>
                            <p id="price-min-value" class="text-xs font-bold text-neutral-700">Rp 0</p>
                        </div>
                        <div class="bg-neutral-50 border border-neutral-200 rounded-lg px-3 py-2 text-center">
                            <p class="text-[9px] font-bold text-neutral-400 uppercase tracking-wider mb-0.5">Max</p>
                            <p id="price-max-value" class="text-xs font-bold text-neutral-700">Rp 5.000.000</p>
                        </div>
                    </div>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const minSlider = document.getElementById('price-range-min');
    const maxSlider = document.getElementById('price-range-max');
    const track = document.getElementById('price-track');
    const minLabel = document.getElementById('price-min-label');
    const maxLabel = document.getElementById('price-max-label');
    const minValue = document.getElementById('price-min-value');
    const maxValue = document.getElementById('price-max-value');

    if (!minSlider || !maxSlider) return;

    function formatRupiah(value) {
        return 'Rp ' + parseInt(value).toLocaleString('id-ID');
    }

    function updateSlider() {
        let min = parseInt(minSlider.value);
        let max = parseInt(maxSlider.value);

        if (min > max) {
            [minSlider.value, maxSlider.value] = [max, min];
            min = parseInt(minSlider.value);
            max = parseInt(maxSlider.value);
        }

        const total = 5000000;
        const leftPercent = (min / total) * 100;
        const rightPercent = ((total - max) / total) * 100;

        track.style.left = leftPercent + '%';
        track.style.width = (100 - leftPercent - rightPercent) + '%';

        minLabel.textContent = formatRupiah(min);
        maxLabel.textContent = formatRupiah(max);
        minValue.textContent = formatRupiah(min);
        maxValue.textContent = formatRupiah(max);
    }

    minSlider.addEventListener('input', updateSlider);
    maxSlider.addEventListener('input', updateSlider);
    updateSlider();
});
</script>
