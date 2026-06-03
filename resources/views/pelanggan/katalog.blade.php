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

$allProducts = [
    ['name'=>'Beras Pandan Wangi 5kg','cat'=>'sembako','price'=>78000,'sale'=>72000,'img'=>'photo-1586201375761-83865001e31c'],
    ['name'=>'Minyak Goreng Bimoli 2L','cat'=>'sembako','price'=>45000,'sale'=>32500,'img'=>'photo-1628152417242-b06296fc99ec'],
    ['name'=>'Gulaku Pasir 1kg','cat'=>'sembako','price'=>18000,'sale'=>0,'img'=>'photo-1558618666-fcd25c85f82e'],
    ['name'=>'Tepung Terigu Segitiga Biru 1kg','cat'=>'sembako','price'=>14500,'sale'=>0,'img'=>'photo-1574323347407-f5e1ad6d020b'],
    ['name'=>'Mie Instan Sedap Goreng (5pcs)','cat'=>'sembako','price'=>15000,'sale'=>12500,'img'=>'photo-1612929633738-8fe44f7ec841'],
    ['name'=>'Kecap Manis ABC 130ml','cat'=>'sembako','price'=>22000,'sale'=>0,'img'=>'photo-1590779033100-9f60a05a013d'],
    ['name'=>'Telur Ayam 1kg','cat'=>'sembako','price'=>28000,'sale'=>26000,'img'=>'photo-1582722872445-44dc5f7e3c8f'],
    ['name'=>'Garam Dapur Cap Kapal 500g','cat'=>'sembako','price'=>5000,'sale'=>0,'img'=>'photo-1518110925495-5fe2fda0442c'],
    ['name'=>'Santan Kara 200ml','cat'=>'sembako','price'=>8500,'sale'=>7000,'img'=>'photo-1563822249548-9a72b6353cd1'],
    ['name'=>'Saus Tomat ABC 335ml','cat'=>'sembako','price'=>12000,'sale'=>0,'img'=>'photo-1472476443507-c7a5948772fc'],
    ['name'=>'Apel Fuji Premium 1kg','cat'=>'sayur-buah','price'=>45000,'sale'=>36000,'img'=>'photo-1560806887-1e4cd0b6faa6'],
    ['name'=>'Wortel Lokal Organik 500g','cat'=>'sayur-buah','price'=>12000,'sale'=>0,'img'=>'photo-1598170845058-32b9d6a5da37'],
    ['name'=>'Pisang Cavendish (Sisir)','cat'=>'sayur-buah','price'=>25000,'sale'=>0,'img'=>'photo-1571771894821-ce9b6c11b08e'],
    ['name'=>'Brokoli Segar 250g','cat'=>'sayur-buah','price'=>39000,'sale'=>0,'img'=>'photo-1459411621453-7b03977f4bfc'],
    ['name'=>'Bayam Petik (Ikat)','cat'=>'sayur-buah','price'=>4500,'sale'=>0,'img'=>'photo-1576045057995-568f588f82fb'],
    ['name'=>'Strawberry Korea (Box)','cat'=>'sayur-buah','price'=>85000,'sale'=>75000,'img'=>'photo-1464965911861-746a04b4bca6'],
    ['name'=>'Tomat Merah 500g','cat'=>'sayur-buah','price'=>10000,'sale'=>0,'img'=>'photo-1546470427-0d4db154ceb8'],
    ['name'=>'Jeruk Sunkist 1kg','cat'=>'sayur-buah','price'=>35000,'sale'=>30000,'img'=>'photo-1582979512210-99b6a53386f9'],
    ['name'=>'Kentang Dieng 1kg','cat'=>'sayur-buah','price'=>16000,'sale'=>0,'img'=>'photo-1518977676601-b53f82ber8f2'],
    ['name'=>'Kangkung Segar (Ikat)','cat'=>'sayur-buah','price'=>3500,'sale'=>0,'img'=>'photo-1540420773420-3366772f4999'],
    ['name'=>'Mangga Harum Manis 1kg','cat'=>'sayur-buah','price'=>28000,'sale'=>24000,'img'=>'photo-1553279768-865429fa0078'],
    ['name'=>'Daging Sapi Has Dalam 500g','cat'=>'daging-ikan','price'=>75000,'sale'=>0,'img'=>'photo-1588347818481-073c39c7e612'],
    ['name'=>'Ayam Potong Broiler 1kg','cat'=>'daging-ikan','price'=>38000,'sale'=>34000,'img'=>'photo-1604503468506-a8da13d82e2b'],
    ['name'=>'Ikan Salmon Fillet 200g','cat'=>'daging-ikan','price'=>65000,'sale'=>0,'img'=>'photo-1574781330855-d0db8cc6a79c'],
    ['name'=>'Udang Vaname 500g','cat'=>'daging-ikan','price'=>55000,'sale'=>48000,'img'=>'photo-1565680018434-b513d5e5fd47'],
    ['name'=>'Bakso Sapi Sule Kemasan 500g','cat'=>'daging-ikan','price'=>32000,'sale'=>0,'img'=>'photo-1529692236671-f1f6cf9683ba'],
    ['name'=>'Ikan Tuna Fillet 300g','cat'=>'daging-ikan','price'=>42000,'sale'=>0,'img'=>'photo-1544551763-46a013bb70d5'],
    ['name'=>'Sosis Ayam So Nice 375g','cat'=>'daging-ikan','price'=>25000,'sale'=>22000,'img'=>'photo-1612871689353-ccd2e5dd3f89'],
    ['name'=>'Nugget Fiesta 500g','cat'=>'daging-ikan','price'=>38000,'sale'=>0,'img'=>'photo-1562967914-608f82629710'],
    ['name'=>'Cumi-Cumi Segar 500g','cat'=>'daging-ikan','price'=>45000,'sale'=>0,'img'=>'photo-1565299507177-b0ac66763828'],
    ['name'=>'Daging Giling Sapi 500g','cat'=>'daging-ikan','price'=>60000,'sale'=>55000,'img'=>'photo-1607623814075-e51df1bdc82f'],
    ['name'=>'Susu Ultra Milk Full Cream 1L','cat'=>'susu-olahan','price'=>21000,'sale'=>18500,'img'=>'photo-1559811814-e2c59b6e6e66'],
    ['name'=>'Keju Kraft Cheddar 165g','cat'=>'susu-olahan','price'=>18000,'sale'=>0,'img'=>'photo-1486297678162-eb2a19b0a32d'],
    ['name'=>'Yogurt Cimory 250ml','cat'=>'susu-olahan','price'=>12000,'sale'=>10000,'img'=>'photo-1488477181946-6428a0291777'],
    ['name'=>'Mentega Blue Band 200g','cat'=>'susu-olahan','price'=>15000,'sale'=>0,'img'=>'photo-1589985270826-4b7bb135bc0d'],
    ['name'=>'Susu Kental Manis Frisian Flag 370g','cat'=>'susu-olahan','price'=>14000,'sale'=>0,'img'=>'photo-1550583724-b2692b85b150'],
    ['name'=>'Susu Indomilk Coklat 1L','cat'=>'susu-olahan','price'=>19000,'sale'=>0,'img'=>'photo-1563636619-e9143da7973b'],
    ['name'=>'Keju Mozzarella Greenfields 200g','cat'=>'susu-olahan','price'=>35000,'sale'=>30000,'img'=>'photo-1626957341926-98752fc2ba90'],
    ['name'=>'Cream Cheese Yummy 250g','cat'=>'susu-olahan','price'=>42000,'sale'=>0,'img'=>'photo-1634141510639-d691d86f47be'],
    ['name'=>'Susu Bear Brand Gold 140ml','cat'=>'susu-olahan','price'=>12000,'sale'=>10500,'img'=>'photo-1563636619-e9143da7973b'],
    ['name'=>'Butter Wijsman 200g','cat'=>'susu-olahan','price'=>55000,'sale'=>0,'img'=>'photo-1589985270826-4b7bb135bc0d'],
    ['name'=>'Teh Botol Sosro 450ml','cat'=>'minuman','price'=>5000,'sale'=>0,'img'=>'photo-1556679343-c7306c1976bc'],
    ['name'=>'Coca Cola 1.5L','cat'=>'minuman','price'=>16000,'sale'=>14000,'img'=>'photo-1554866585-cd94860890b7'],
    ['name'=>'Aqua 600ml (6pcs)','cat'=>'minuman','price'=>12000,'sale'=>0,'img'=>'photo-1548839140-29a749e1cf4d'],
    ['name'=>'Kopi Good Day Cappuccino 10s','cat'=>'minuman','price'=>18000,'sale'=>15000,'img'=>'photo-1509042239860-f550ce710b93'],
    ['name'=>'Yakult 5x65ml','cat'=>'minuman','price'=>10000,'sale'=>0,'img'=>'photo-1563636619-e9143da7973b'],
    ['name'=>'Pocari Sweat 500ml','cat'=>'minuman','price'=>8000,'sale'=>0,'img'=>'photo-1632818924360-68d4ef7a19c1'],
    ['name'=>'Sirup Marjan Cocopandan 460ml','cat'=>'minuman','price'=>22000,'sale'=>19000,'img'=>'photo-1558642452-9d2a7deb7f62'],
    ['name'=>'Le Minerale 330ml (6pcs)','cat'=>'minuman','price'=>11000,'sale'=>0,'img'=>'photo-1548839140-29a749e1cf4d'],
    ['name'=>'Fanta Strawberry 1.5L','cat'=>'minuman','price'=>14000,'sale'=>0,'img'=>'photo-1624517452488-04869289c4ca'],
    ['name'=>'Nutrisari Jeruk Peras 10s','cat'=>'minuman','price'=>12000,'sale'=>10000,'img'=>'photo-1534353473418-4cfa6c56fd38'],
    ['name'=>'Chitato Sapi Panggang 68g','cat'=>'snack-camilan','price'=>10000,'sale'=>0,'img'=>'photo-1621447504864-d8686e12698c'],
    ['name'=>'Oreo Vanilla 133g','cat'=>'snack-camilan','price'=>12000,'sale'=>10000,'img'=>'photo-1558961363-fa8fdf82db35'],
    ['name'=>'Pringles Original 110g','cat'=>'snack-camilan','price'=>28000,'sale'=>0,'img'=>'photo-1600952841320-db92ec4047ca'],
    ['name'=>'Pocky Strawberry 45g','cat'=>'snack-camilan','price'=>9000,'sale'=>0,'img'=>'photo-1536826915174-11e013898b9a'],
    ['name'=>'Coklat Silverqueen 65g','cat'=>'snack-camilan','price'=>16000,'sale'=>14000,'img'=>'photo-1575377427642-087cf684f29d'],
    ['name'=>'Tango Wafer Coklat 176g','cat'=>'snack-camilan','price'=>14000,'sale'=>0,'img'=>'photo-1599599810694-b5b37304c041'],
    ['name'=>'Lays Classic 68g','cat'=>'snack-camilan','price'=>10000,'sale'=>0,'img'=>'photo-1621447504864-d8686e12698c'],
    ['name'=>'Biskuit Roma Kelapa 300g','cat'=>'snack-camilan','price'=>8000,'sale'=>6500,'img'=>'photo-1558961363-fa8fdf82db35'],
    ['name'=>'Kacang Garuda 100g','cat'=>'snack-camilan','price'=>12000,'sale'=>0,'img'=>'photo-1536826915174-11e013898b9a'],
    ['name'=>'Nabati Richeese 150g','cat'=>'snack-camilan','price'=>11000,'sale'=>9500,'img'=>'photo-1599599810694-b5b37304c041'],
    ['name'=>'Deterjen Rinso Anti Noda 800g','cat'=>'kebutuhan-rumah','price'=>22000,'sale'=>0,'img'=>'photo-1585421514284-efb74c2b69ba'],
    ['name'=>'Sabun Cuci Piring Sunlight 800ml','cat'=>'kebutuhan-rumah','price'=>16000,'sale'=>14000,'img'=>'photo-1585421514284-efb74c2b69ba'],
    ['name'=>'Pewangi Molto 900ml','cat'=>'kebutuhan-rumah','price'=>24000,'sale'=>0,'img'=>'photo-1563453392212-326f5e854473'],
    ['name'=>'Pembersih Lantai Super Pell 800ml','cat'=>'kebutuhan-rumah','price'=>14000,'sale'=>0,'img'=>'photo-1585421514284-efb74c2b69ba'],
    ['name'=>'Tissue Paseo 250 Sheet','cat'=>'kebutuhan-rumah','price'=>18000,'sale'=>15000,'img'=>'photo-1584556812952-905ffd0c611a'],
    ['name'=>'Sapu Ijuk Premium','cat'=>'kebutuhan-rumah','price'=>25000,'sale'=>0,'img'=>'photo-1563453392212-326f5e854473'],
    ['name'=>'Kain Lap Microfiber 3pcs','cat'=>'kebutuhan-rumah','price'=>20000,'sale'=>0,'img'=>'photo-1563453392212-326f5e854473'],
    ['name'=>'Baygon Aerosol 600ml','cat'=>'kebutuhan-rumah','price'=>35000,'sale'=>30000,'img'=>'photo-1585421514284-efb74c2b69ba'],
    ['name'=>'Ember Plastik 20L','cat'=>'kebutuhan-rumah','price'=>28000,'sale'=>0,'img'=>'photo-1563453392212-326f5e854473'],
    ['name'=>'Trash Bag Roll 45x50 20pcs','cat'=>'kebutuhan-rumah','price'=>12000,'sale'=>0,'img'=>'photo-1584556812952-905ffd0c611a'],
    ['name'=>'Shampo Pantene 400ml','cat'=>'perawatan-diri','price'=>42000,'sale'=>38000,'img'=>'photo-1631729371254-42c2892f0e6e'],
    ['name'=>'Sabun Lifebuoy 100g (4pcs)','cat'=>'perawatan-diri','price'=>18000,'sale'=>0,'img'=>'photo-1600857544200-b2f666a9a2ec'],
    ['name'=>'Pasta Gigi Pepsodent 190g','cat'=>'perawatan-diri','price'=>14000,'sale'=>12000,'img'=>'photo-1559056199-641a0ac8b55e'],
    ['name'=>'Deodoran Rexona 50ml','cat'=>'perawatan-diri','price'=>22000,'sale'=>0,'img'=>'photo-1631729371254-42c2892f0e6e'],
    ['name'=>'Sunscreen Nivea SPF50 100ml','cat'=>'perawatan-diri','price'=>48000,'sale'=>0,'img'=>'photo-1556228578-0d85b1a4d571'],
    ['name'=>'Hand Body Vaseline 200ml','cat'=>'perawatan-diri','price'=>25000,'sale'=>22000,'img'=>'photo-1556228578-0d85b1a4d571'],
    ['name'=>'Sikat Gigi Oral-B 3pcs','cat'=>'perawatan-diri','price'=>28000,'sale'=>0,'img'=>'photo-1559056199-641a0ac8b55e'],
    ['name'=>'Kapas Wajah Selection 50g','cat'=>'perawatan-diri','price'=>8000,'sale'=>0,'img'=>'photo-1556228578-0d85b1a4d571'],
    ['name'=>'Conditioner Dove 320ml','cat'=>'perawatan-diri','price'=>35000,'sale'=>30000,'img'=>'photo-1631729371254-42c2892f0e6e'],
    ['name'=>'Sabun Cair Dettol 300ml','cat'=>'perawatan-diri','price'=>32000,'sale'=>0,'img'=>'photo-1600857544200-b2f666a9a2ec'],
];

$imgMap = [
    'Beras Pandan Wangi 5kg'=>'beras-wangi-5kg.jpg','Minyak Goreng Bimoli 2L'=>'minyak-bimoli-2lt.avif',
    'Gulaku Pasir 1kg'=>'gulaku-pasir-1kg.jpg','Tepung Terigu Segitiga Biru 1kg'=>'tepung-segitigabiru-1kg.jpg',
    'Mie Instan Sedap Goreng (5pcs)'=>'miesedap-isi5.jpg','Kecap Manis ABC 130ml'=>'kecapmaniABC130ml.jpg',
    'Telur Ayam 1kg'=>'telurayam-1kg.jpg','Garam Dapur Cap Kapal 500g'=>'garamdapur-500gr.jpg',
    'Santan Kara 200ml'=>'santankara-200ml.jpg','Saus Tomat ABC 335ml'=>'saustomatABC-335ml.jpg',
    'Apel Fuji Premium 1kg'=>'apelfuji-1kg.jpg','Wortel Lokal Organik 500g'=>'wortel500gr.jpg',
    'Pisang Cavendish (Sisir)'=>'pisang.jpg','Brokoli Segar 250g'=>'brokoli-250gr.jpg',
    'Bayam Petik (Ikat)'=>'bayam.jpg','Strawberry Korea (Box)'=>'strawberrybox.jpg',
    'Tomat Merah 500g'=>'tomatmerah500gr.jpg','Jeruk Sunkist 1kg'=>'jeruksunkist.jpg',
    'Kentang Dieng 1kg'=>'kentang1kg.jpg','Kangkung Segar (Ikat)'=>'kangkung.jpg',
    'Mangga Harum Manis 1kg'=>'manggaharummanis.jpg','Daging Sapi Has Dalam 500g'=>'daginghasdalam.jpg',
    'Ayam Potong Broiler 1kg'=>'ayampotong.jpg','Ikan Salmon Fillet 200g'=>'salmonfillet.jpg',
    'Udang Vaname 500g'=>'udangvaname.jpg','Bakso Sapi Sule Kemasan 500g'=>'baksosapipolos.jpg',
    'Ikan Tuna Fillet 300g'=>'ikantunafillet.jpg','Sosis Ayam So Nice 375g'=>'sosissonice.jpg',
    'Nugget Fiesta 500g'=>'nuggetfiesta.jpg','Cumi-Cumi Segar 500g'=>'cumicumi.jpg',
    'Daging Giling Sapi 500g'=>'daginggiling.jpg','Susu Ultra Milk Full Cream 1L'=>'susuultramilk.jpg',
    'Keju Kraft Cheddar 165g'=>'kejucheddar.jpg','Yogurt Cimory 250ml'=>'yoghurtplain.jpg',
    'Mentega Blue Band 200g'=>'blueband.jpg','Susu Kental Manis Frisian Flag 370g'=>'susukental.jpg',
    'Susu Indomilk Coklat 1L'=>'indomilkcoklat.jpg','Keju Mozzarella Greenfields 200g'=>'kejumozza.jpg',
    'Cream Cheese Yummy 250g'=>'krimkeju.jpg','Susu Bear Brand Gold 140ml'=>'susuberuang.jpg',
    'Butter Wijsman 200g'=>'wisman.jpg','Teh Botol Sosro 450ml'=>'sosro.jpg',
    'Coca Cola 1.5L'=>'coke.jpg','Aqua 600ml (6pcs)'=>'aqua6pcs.jpg',
    'Kopi Good Day Cappuccino 10s'=>'goodday.jpg','Yakult 5x65ml'=>'yakult.jpg',
    'Pocari Sweat 500ml'=>'pocari.jpg','Sirup Marjan Cocopandan 460ml'=>'marjan.jpg',
    'Le Minerale 330ml (6pcs)'=>'leminerale.jpg','Fanta Strawberry 1.5L'=>'fantastrawberry.jpg',
    'Nutrisari Jeruk Peras 10s'=>'nutrisari.jpg','Chitato Sapi Panggang 68g'=>'chitatosapi.jpg',
    'Oreo Vanilla 133g'=>'oreovanilla.jpg','Pringles Original 110g'=>'pringles.jpg',
    'Pocky Strawberry 45g'=>'pockystrawberry.jpg','Coklat Silverqueen 65g'=>'silverqueen.jpg',
    'Tango Wafer Coklat 176g'=>'wafertango.jpg','Lays Classic 68g'=>'lays.jpg',
    'Biskuit Roma Kelapa 300g'=>'biskuit-roma.jpg','Kacang Garuda 100g'=>'kacang-garuda.jpg',
    'Nabati Richeese 150g'=>'nabati.jpg','Deterjen Rinso Anti Noda 800g'=>'rinso.jpg',
    'Sabun Cuci Piring Sunlight 800ml'=>'sunlight.jpg','Pewangi Molto 900ml'=>'molto.jpg',
    'Pembersih Lantai Super Pell 800ml'=>'super-pell.jpg','Tissue Paseo 250 Sheet'=>'tissue.jpg',
    'Sapu Ijuk Premium'=>'sapu.jpg','Kain Lap Microfiber 3pcs'=>'lap-microfiber.jpg',
    'Baygon Aerosol 600ml'=>'baygon.jpg','Ember Plastik 20L'=>'ember.jpg',
    'Trash Bag Roll 45x50 20pcs'=>'trash-bag.jpg','Shampo Pantene 400ml'=>'shampo.jpg',
    'Sabun Lifebuoy 100g (4pcs)'=>'sabun-lifebuoy.jpg','Pasta Gigi Pepsodent 190g'=>'pasta-gigi.jpg',
    'Deodoran Rexona 50ml'=>'deodoran.jpg','Sunscreen Nivea SPF50 100ml'=>'sunscreen.jpg',
    'Hand Body Vaseline 200ml'=>'hand-body.jpg','Sikat Gigi Oral-B 3pcs'=>'sikat-gigi.jpg',
    'Kapas Wajah Selection 50g'=>'kapas.jpg','Conditioner Dove 320ml'=>'conditioner.jpg',
    'Sabun Cair Dettol 300ml'=>'sabun-cair.jpg',
];

$filtered = $activeCategory ? array_filter($allProducts, fn($p) => $p['cat'] === $activeCategory) : $allProducts;
$filtered = array_values($filtered);
$productCount = count($filtered);
@endphp

@section('content')
<div class="pb-10">
    <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-8 border-b border-neutral-200 pb-5 gap-4">
        <div>
            <h2 class="font-heading font-extrabold text-3xl sm:text-4xl text-neutral-800 mb-2 tracking-tight">{{ $categoryLabel }}</h2>
            <p class="text-neutral-500 font-medium text-sm">Menampilkan {{ $productCount }} produk berkualitas untuk Anda</p>
        </div>
    </div>

    <div id="product-grid" class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
        @foreach($filtered as $product)
        <div class="product-card bg-white rounded-2xl border border-neutral-200 shadow-sm hover:shadow-md hover:border-primary-300 transition-all duration-300 group flex flex-col overflow-hidden" data-name="{{ strtolower($product['name']) }}">
            <div class="relative bg-neutral-50 flex items-center justify-center border-b border-neutral-100 overflow-hidden" style="aspect-ratio:1/1;">
                @if($product['sale'] > 0)
                <div class="absolute top-3 right-3 z-10">
                    <span class="bg-tertiary-400 text-white text-[10px] font-bold px-2 py-1 rounded shadow-sm tracking-wider">HEMAT {{ round((($product['price']-$product['sale'])/$product['price'])*100) }}%</span>
                </div>
                @endif
                @php $localImg = $imgMap[$product['name']] ?? null; @endphp
                <img src="{{ $localImg ? asset('assets/products/'.$localImg) : 'https://images.unsplash.com/'.$product['img'].'?auto=format&fit=crop&w=400&h=400&q=80' }}" alt="{{ $product['name'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
            </div>
            <div class="p-4 flex flex-col flex-1">
                <p class="text-[10px] font-bold text-neutral-400 uppercase tracking-wider mb-1">{{ $categories[$product['cat']] ?? $product['cat'] }}</p>
                <h4 class="font-bold text-sm text-neutral-800 mb-2 leading-tight group-hover:text-primary-700 transition-colors line-clamp-2">{{ $product['name'] }}</h4>
                <div class="mt-auto space-y-2">
                    @if($product['sale'] > 0)
                    <div class="flex items-center gap-2">
                        <span class="text-xs text-neutral-400 line-through">Rp {{ number_format($product['price'],0,',','.') }}</span>
                    </div>
                    <div class="flex items-end justify-between">
                        <span class="font-extrabold text-lg text-primary-700">Rp {{ number_format($product['sale'],0,',','.') }}</span>
                        <button class="btn-add-cart w-8 h-8 bg-primary-50 hover:bg-primary-700 rounded-lg flex items-center justify-center text-primary-700 hover:text-white transition-colors" data-product="{{ $product['name'] }}"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"></path></svg></button>
                    </div>
                    @else
                    <div class="flex items-end justify-between">
                        <span class="font-extrabold text-lg text-neutral-800">Rp {{ number_format($product['price'],0,',','.') }}</span>
                        <button class="btn-add-cart w-8 h-8 bg-primary-50 hover:bg-primary-700 rounded-lg flex items-center justify-center text-primary-700 hover:text-white transition-colors" data-product="{{ $product['name'] }}"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"></path></svg></button>
                    </div>
                    @endif
                </div>
            </div>
        </div>
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
    // === Search filter ===
    const searchInput = document.getElementById('sidebar-search');
    const grid = document.getElementById('product-grid');
    const noResults = document.getElementById('no-results');
    if (searchInput && grid) {
        searchInput.addEventListener('input', function() {
            const query = this.value.toLowerCase().trim();
            const cards = grid.querySelectorAll('.product-card');
            let visibleCount = 0;
            cards.forEach(card => {
                const name = card.getAttribute('data-name') || '';
                const match = !query || name.includes(query);
                card.style.display = match ? '' : 'none';
                if (match) visibleCount++;
            });
            if (noResults) {
                if (visibleCount === 0 && query) { noResults.classList.remove('hidden'); grid.appendChild(noResults); }
                else { noResults.classList.add('hidden'); }
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
