<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Borma Toserba - Belanja mudah, hemat, dan nyaman. Temukan promo terbaik dan produk berkualitas di Borma terdekat Anda.">
    <title>@yield('title', 'Beranda') - Borma Toserba</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-neutral-50 font-sans text-neutral-800 antialiased min-h-screen flex flex-col">

    <!-- Top Navbar -->
    @include('layouts.partials.navbar')

    <!-- Main Content Area -->
    <div class="flex-1 w-full max-w-[1280px] mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <main class="w-full">
            @yield('content')
        </main>
    </div>

    <!-- Footer -->
    @include('layouts.partials.footer')

    @stack('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    fetch('{{ route("cart.count") }}')
        .then(r => r.json())
        .then(data => {
            const badge = document.getElementById('cart-badge');
            if (badge) {
                badge.style.display = data.cart_count > 0 ? 'block' : 'none';
            }
        })
        .catch(() => {});
});
</script>
</body>
</html>
