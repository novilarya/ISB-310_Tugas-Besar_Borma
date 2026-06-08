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

$product = null;
foreach ($allProducts as $p) {
    if (Str::slug($p['name']) === $slug) {
        $product = $p;
        break;
    }
}

// Fallback if not found
if (!$product) {
    $product = [
        'name' => str_replace('-', ' ', $slug),
        'cat' => 'sembako',
        'price' => 20000,
        'sale' => 0,
        'img' => 'photo-1586201375761-83865001e31c'
    ];
}

$categoryName = $categories[$product['cat']] ?? 'Lain-lain';
$localImg = $imgMap[$product['name']] ?? null;
$imgUrl = $localImg ? asset('assets/products/'.$localImg) : 'https://images.unsplash.com/'.$product['img'].'?auto=format&fit=crop&w=600&h=600&q=80';

// Weight helper
$weight = '500g';
if (str_contains($product['name'], '5kg')) $weight = '5 kg';
elseif (str_contains($product['name'], '2L')) $weight = '2 kg';
elseif (str_contains($product['name'], '1kg')) $weight = '1 kg';
elseif (str_contains($product['name'], '500g')) $weight = '500 g';
elseif (str_contains($product['name'], '250g')) $weight = '250 g';
elseif (str_contains($product['name'], '130ml')) $weight = '150 g';
elseif (str_contains($product['name'], '335ml')) $weight = '400 g';
elseif (str_contains($product['name'], '1L')) $weight = '1 kg';
elseif (str_contains($product['name'], '150g')) $weight = '150 g';
elseif (str_contains($product['name'], '800g')) $weight = '800 g';
elseif (str_contains($product['name'], '800ml')) $weight = '800 g';
elseif (str_contains($product['name'], '400ml')) $weight = '400 g';
elseif (str_contains($product['name'], '300ml')) $weight = '300 g';

$desc = "Dapatkan " . $product['name'] . " berkualitas terbaik hanya di Borma Toserba. Produk diproses dan dikemas secara higienis untuk menjaga kesegaran dan mutunya sampai di tangan Anda. Sangat cocok untuk kebutuhan sehari-hari keluarga Anda dengan harga yang terjangkau dan hemat.";
@endphp

@section('content')
<div class="bg-white rounded-3xl border border-neutral-200 shadow-sm p-6 lg:p-8">
    <!-- Breadcrumb -->
    <nav class="flex text-sm font-semibold text-neutral-400 mb-6 gap-2 items-center">
        <a href="{{ route('pelanggan.dashboard') }}" class="hover:text-primary-700 transition-colors">Home</a>
        <svg class="w-4 h-4 text-neutral-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <a href="{{ route('pelanggan.katalog', ['kategori' => $product['cat']]) }}" class="hover:text-primary-700 transition-colors">{{ $categoryName }}</a>
        <svg class="w-4 h-4 text-neutral-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <span class="text-neutral-600 truncate max-w-[200px] sm:max-w-xs">{{ $product['name'] }}</span>
    </nav>

    <!-- Main Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Left Column: Image Gallery (4 cols) -->
        <div class="lg:col-span-4 space-y-4">
            <!-- Large Image Box -->
            <div class="relative bg-neutral-50 border border-neutral-200 rounded-2xl overflow-hidden aspect-square flex items-center justify-center shadow-sm">
                @if($product['sale'] > 0)
                <div class="absolute top-4 right-4 z-10">
                    <span class="bg-tertiary-400 text-white text-[10px] font-extrabold px-2.5 py-1 rounded shadow-sm tracking-wider uppercase">Hemat {{ round((($product['price']-$product['sale'])/$product['price'])*100) }}%</span>
                </div>
                @endif
                <img src="{{ $imgUrl }}" alt="{{ $product['name'] }}" class="w-full h-full object-cover transition-transform duration-300 hover:scale-105" id="main-product-img">
            </div>
            
            <!-- Thumbnail Gallery -->
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
        </div>

        <!-- Middle Column: Product Details (5 cols) -->
        <div class="lg:col-span-5 space-y-6">
            <div>
                <span class="text-xs font-bold text-neutral-400 uppercase tracking-widest">{{ $categoryName }}</span>
                <h2 class="font-heading font-extrabold text-2xl lg:text-3xl text-neutral-800 mt-1 mb-2 leading-tight">{{ $product['name'] }}</h2>
                
                <!-- Rating and Sold count -->
                <div class="flex items-center gap-2 text-sm text-neutral-500 font-medium">
                    <span class="flex items-center text-amber-500 gap-0.5">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <span class="font-bold text-neutral-700">4.9</span>
                    </span>
                    <span>•</span>
                    <span>Terjual 100+</span>
                </div>
            </div>

            <!-- Price Section -->
            <div class="py-4 border-y border-neutral-100">
                @if($product['sale'] > 0)
                <div class="flex items-center gap-2 mb-1">
                    <span class="text-sm text-neutral-400 line-through">Rp {{ number_format($product['price'],0,',','.') }}</span>
                </div>
                <h3 class="font-heading font-extrabold text-3xl text-primary-700">Rp {{ number_format($product['sale'],0,',','.') }}</h3>
                @else
                <h3 class="font-heading font-extrabold text-3xl text-neutral-800">Rp {{ number_format($product['price'],0,',','.') }}</h3>
                @endif
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
                            <span class="text-neutral-700 text-primary-700 hover:underline cursor-pointer">{{ $categoryName }}</span>
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
                    <span class="text-xs font-bold text-neutral-400">Stok: <span class="text-neutral-700">Tersedia</span></span>
                </div>

                <!-- Subtotal -->
                <div class="flex items-center justify-between pt-3 border-t border-neutral-100">
                    <span class="text-xs font-bold text-neutral-400">Subtotal</span>
                    <span class="font-extrabold text-lg text-neutral-800" id="subtotal-price">Rp 0</span>
                </div>

                <!-- Action Buttons -->
                <div class="space-y-2.5 pt-1">
                    <button class="w-full bg-primary-700 hover:bg-primary-600 active:bg-primary-800 text-white font-bold py-3 rounded-xl transition-all duration-200 shadow-md shadow-primary-700/10 hover:shadow-lg flex items-center justify-center gap-2" id="btn-add-to-cart">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                        <span>+ Keranjang</span>
                    </button>
                    <button class="w-full bg-white hover:bg-neutral-50 active:bg-neutral-100 text-primary-700 border-2 border-primary-700 font-bold py-2.5 rounded-xl transition-all" id="btn-buy-now">
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
    const unitPrice = {{ $product['sale'] > 0 ? $product['sale'] : $product['price'] }};
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
        let qty = parseInt(qtyInput.value) || 1;
        qty += amount;
        if (qty < 1) qty = 1;
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
        document.getElementById('main-product-img').src = url;
        const thumbnails = [document.getElementById('thumb-1'), document.getElementById('thumb-2'), document.getElementById('thumb-3')];
        thumbnails.forEach(t => {
            if (t) {
                t.className = 'w-16 h-16 rounded-xl border-2 border-neutral-200 overflow-hidden cursor-pointer bg-neutral-50 hover:border-primary-700 transition-all shadow-sm opacity-60 hover:opacity-100';
            }
        });
        el.className = 'w-16 h-16 rounded-xl border-2 border-primary-700 overflow-hidden cursor-pointer bg-neutral-50 hover:border-primary-700 transition-all shadow-sm';
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
        const btn = redirect ? document.getElementById('btn-buy-now') : document.getElementById('btn-add-to-cart');
        btn.disabled = true;
        btn.classList.add('opacity-50', 'pointer-events-none');

        fetch('{{ route("cart.add") }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
            body: JSON.stringify({ product_name: '{{ $product['name'] }}', quantity: qty })
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

    document.getElementById('btn-add-to-cart').addEventListener('click', function() {
        const qty = parseInt(qtyInput.value) || 1;
        addToCart(qty, false);
    });

    document.getElementById('btn-buy-now').addEventListener('click', function() {
        const qty = parseInt(qtyInput.value) || 1;
        addToCart(qty, true);
    });

    // Initialize subtotal
    updateSubtotal();
</script>
@endpush
