<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Borma Internal — Driver Dashboard">
    <title>@yield('title', 'Driver') — Borma Internal</title>

    {{-- Google Fonts: Manrope + Plus Jakarta Sans --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.min.css') }}">

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        /* ================================================
           DESIGN TOKENS — Borma Color Palette
        ================================================ */
        :root {
            --color-primary:        #33116C;
            --color-primary-light:  #4a1f9e;
            --color-primary-pale:   #ede8f7;
            --color-secondary:      #FED50B;
            --color-secondary-dark: #e0b800;
            --color-tertiary:       #EB3B02;
            --color-neutral:        #2B2B2B;
            --color-neutral-soft:   #4a4a4a;
            --color-bg:             #F5F4F8;
            --color-surface:        #FFFFFF;
            --color-border:         #E4E0EE;
            --color-text:           #1a1a2e;
            --color-text-muted:     #7a7a9a;

            --font-headline:        'Manrope', sans-serif;
            --font-body:            'Plus Jakarta Sans', sans-serif;

            --radius-sm:   8px;
            --radius-md:   14px;
            --radius-lg:   20px;
            --shadow-card: 0 2px 16px rgba(51, 17, 108, 0.08);
            --shadow-nav:  0 -4px 24px rgba(51, 17, 108, 0.10);

            --nav-height:  72px;
        }

        /* ================================================
           RESET & BASE
        ================================================ */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        html, body {
            height: 100%;
            background-color: var(--color-bg);
            font-family: var(--font-body);
            color: var(--color-text);
            -webkit-font-smoothing: antialiased;
        }

        a { text-decoration: none; color: inherit; }

        /* ================================================
           LAYOUT WRAPPER
        ================================================ */
        .driver-wrapper {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            max-width: 540px;
            margin: 0 auto;
            background: var(--color-bg);
            position: relative;
        }

        /* ================================================
           TOP HEADER
        ================================================ */
        .driver-header {
            position: sticky;
            top: 0;
            z-index: 100;
            background: var(--color-surface);
            border-bottom: 1px solid var(--color-border);
            padding: 14px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .driver-header .brand {
            display: flex;
            flex-direction: column;
        }

        .driver-header .brand-name {
            font-family: var(--font-headline);
            font-size: 16px;
            font-weight: 800;
            letter-spacing: 0.06em;
            color: var(--color-primary);
            line-height: 1;
        }

        .driver-header .brand-sub {
            font-family: var(--font-body);
            font-size: 10px;
            font-weight: 500;
            letter-spacing: 0.12em;
            color: var(--color-text-muted);
            text-transform: uppercase;
            margin-top: 2px;
        }

        .driver-header .header-back {
            display: flex;
            align-items: center;
            gap: 8px;
            font-family: var(--font-headline);
            font-size: 16px;
            font-weight: 700;
            color: var(--color-primary);
            cursor: pointer;
        }

        .btn-notif {
            position: relative;
            width: 40px;
            height: 40px;
            border: none;
            background: var(--color-primary-pale);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: var(--color-primary);
            font-size: 18px;
            transition: background 0.2s;
        }
        .btn-notif:hover { background: var(--color-border); }

        .notif-badge {
            position: absolute;
            top: 6px;
            right: 6px;
            width: 8px;
            height: 8px;
            background: var(--color-tertiary);
            border-radius: 50%;
            border: 2px solid var(--color-surface);
        }

        /* ================================================
           MAIN CONTENT
        ================================================ */
        .driver-main {
            flex: 1;
            padding: 24px 20px;
            padding-bottom: calc(var(--nav-height) + 24px);
            overflow-y: auto;
        }

        /* ================================================
           BOTTOM NAVIGATION
        ================================================ */
        .driver-bottom-nav {
            position: fixed;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100%;
            max-width: 540px;
            height: var(--nav-height);
            background: var(--color-surface);
            box-shadow: var(--shadow-nav);
            display: flex;
            align-items: stretch;
            z-index: 200;
            border-top: 1px solid var(--color-border);
        }

        .nav-item {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 4px;
            font-family: var(--font-body);
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 0.08em;
            color: var(--color-text-muted);
            text-transform: uppercase;
            cursor: pointer;
            transition: color 0.2s, background 0.2s;
            border: none;
            background: transparent;
            text-decoration: none;
        }
        .nav-item i { font-size: 22px; }

        .nav-item.active {
            background: var(--color-primary);
            color: var(--color-surface);
        }

        .nav-item:not(.active):hover {
            color: var(--color-primary);
            background: var(--color-primary-pale);
        }
    </style>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    @stack('styles')
</head>
<body>

<div class="driver-wrapper">

    {{-- ===== TOP HEADER ===== --}}
    <header class="driver-header" id="driver-header">
        @hasSection('header_back')
            <div class="header-back" onclick="history.back()">
                <i class="bi bi-arrow-left"></i>
                <span class="brand-name">BORMA INTERNAL</span>
            </div>
        @else
            <div class="brand">
                <span class="brand-name">BORMA INTERNAL</span>
                <span class="brand-sub">@yield('header_sub', 'Driver Panel')</span>
            </div>
        @endif

        <button class="btn-notif" id="btn-notif" title="Notifikasi">
            <i class="bi bi-bell"></i>
            <span class="notif-badge"></span>
        </button>
    </header>

    {{-- ===== MAIN CONTENT ===== --}}
    <main class="driver-main">
        @yield('content')
    </main>

    {{-- ===== BOTTOM NAVIGATION ===== --}}
    <nav class="driver-bottom-nav" role="navigation" aria-label="Menu Driver">
        <a href="{{ route('driver.dashboard') }}"
           class="nav-item {{ request()->routeIs('driver.dashboard') ? 'active' : '' }}"
           id="nav-dashboard">
            <i class="bi bi-speedometer2"></i>
            <span>Dashboard</span>
        </a>
        <a href="{{ route('driver.riwayat.index') }}"
           class="nav-item {{ request()->routeIs('driver.riwayat.*') ? 'active' : '' }}"
           id="nav-riwayat">
            <i class="bi bi-clock-history"></i>
            <span>Riwayat</span>
        </a>
        <a href="{{ route('driver.profil.index') }}"
           class="nav-item {{ request()->routeIs('driver.profil.*') ? 'active' : '' }}"
           id="nav-profil">
            <i class="bi bi-person-circle"></i>
            <span>Profil</span>
        </a>
    </nav>

</div>

@stack('scripts')
</body>
</html>
