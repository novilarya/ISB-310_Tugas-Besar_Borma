<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Borma Toserba - Belanja mudah, hemat, dan nyaman. Temukan promo terbaik dan produk berkualitas di Borma terdekat Anda.">
    <meta name="selected-cabang-id" content="{{ session('selected_cabang_id', '') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Beranda') - Borma Toserba</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Leaflet.js Map -->
    <link class="leaflet-css" rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/branch-selector.js'])
</head>
<body class="bg-neutral-100 font-sans text-neutral-800 antialiased min-h-screen flex flex-col">

    <!-- Top Navbar -->
    @include('layouts.partials.navbar')

    <!-- Main Content Area -->
    <div class="flex-1 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if(request()->routeIs('pelanggan.katalog'))
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Left Sidebar Filter (only on Katalog) -->
            @include('layouts.partials.sidebar-filter')

            <!-- Main Content (Right) -->
            <main class="flex-1 min-w-0">
                @yield('content')
            </main>
        </div>
        @else
        <main class="w-full">
            @yield('content')
        </main>
        @endif
    </div>

    <!-- Footer -->
    @include('layouts.partials.footer')

    <!-- MODALS FOR BRANCH SELECTION -->
    @include('layouts.partials.branch-recommend-modal')
    @include('layouts.partials.branch-map-modal')

    @stack('scripts')
</body>
</html>
