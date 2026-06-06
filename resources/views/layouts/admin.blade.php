<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard - Borma')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    @php
        $isAdminCabang = auth()->user() && in_array(strtolower(auth()->user()->role), ['admin cabang', 'admin']);
    @endphp

    @if($isAdminCabang)
        <!-- Bootstrap CSS for Admin Cabang -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    @endif

    <!-- Tailwind CSS CDN & Config -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        borma: {
                            purple: '#33116C',
                            dark: '#110526',
                            yellow: '#FED50B'
                        }
                    }
                }
            }
        }
    </script>

    <!-- Theme Initialization Script -->
    <script>
        if (localStorage.getItem('theme') === 'light' || (!('theme' in localStorage) && !window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.remove('dark')
        } else {
            document.documentElement.classList.add('dark')
        }
    </script>

    <style>
        :root {
            --borma-primary: #33116C;
            --borma-secondary: #FED50B;
            --borma-tertiary: #EB3B02;
            --borma-neutral: #2B2B2B;
            --borma-bg: #F4F6F8;
        }
        .dark {
            --borma-primary: #a78bfa;
            --borma-secondary: #FED50B;
            --borma-tertiary: #FF6B35;
            --borma-neutral: #F8FAFC;
            --borma-bg: #110526;
        }

        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: rgba(156, 163, 175, 0.5); border-radius: 10px; }
        .dark ::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.2); }
        ::-webkit-scrollbar-thumb:hover { background: rgba(156, 163, 175, 0.8); }
        .dark ::-webkit-scrollbar-thumb:hover { background: rgba(255,255,255,0.3); }

        /* Remove Bootstrap default dropdown caret */
        .dropdown-toggle::after {
            display: none !important;
        }

        @if($isAdminCabang)
        /* Bootstrap dynamic light/dark overrides for content area (Admin Cabang only) */
        .dark .glass-card, .dark .card, .dark .bg-white {
            background-color: rgba(255, 255, 255, 0.05) !important;
            backdrop-filter: blur(24px);
            border-color: rgba(255, 255, 255, 0.06) !important;
            color: #f8fafc !important;
        }
        .dark .text-dark, .dark .text-slate-800, .dark .modal-title, .dark h1, .dark h2, .dark h3, .dark h4, .dark h5, .dark h6 {
            color: #ffffff !important;
        }
        .dark .text-muted {
            color: #94a3b8 !important;
        }
        .dark .border, .dark .border-light, .dark .border-bottom, .dark .border-top {
            border-color: rgba(255, 255, 255, 0.06) !important;
        }
        .dark .table, .dark .table-modern {
            color: #f8fafc !important;
        }
        .dark .table td, .dark .table th, .dark .table-modern td, .dark .table-modern th {
            border-bottom-color: rgba(255, 255, 255, 0.06) !important;
            color: #94a3b8 !important;
        }
        .dark .table th, .dark .table-modern th {
            color: #ffffff !important;
        }
        .dark .modal-content {
            background-color: #1c0d38 !important;
            color: #ffffff !important;
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
        }
        .dark .modal-header, .dark .modal-footer {
            border-color: rgba(255, 255, 255, 0.08) !important;
        }
        .dark .form-control, .dark .form-select, .dark .input-group-text {
            background-color: #251448 !important;
            border-color: rgba(255, 255, 255, 0.1) !important;
            color: #f8fafc !important;
        }
        .dark .form-control::placeholder {
            color: rgba(255, 255, 255, 0.3) !important;
        }
        .dark .form-control:focus, .dark .form-select:focus {
            background-color: #251448 !important;
            border-color: #FED50B !important;
            color: #ffffff !important;
            box-shadow: 0 0 0 0.25rem rgba(254, 213, 11, 0.25) !important;
        }
        .dark .dropdown-menu {
            background-color: #1c0d38 !important;
            border-color: rgba(255, 255, 255, 0.08) !important;
            box-shadow: 0 10px 25px rgba(0,0,0,0.5) !important;
        }
        .dark .dropdown-item {
            color: rgba(255, 255, 255, 0.8) !important;
        }
        .dark .dropdown-item:hover {
            background-color: rgba(255, 255, 255, 0.05) !important;
            color: #FED50B !important;
        }
        .dark .dropdown-divider {
            border-color: rgba(255, 255, 255, 0.08) !important;
        }
        .dark .notif-item {
            border-bottom: 1px solid rgba(255, 255, 255, 0.04) !important;
        }
        .dark .notif-item:hover {
            background-color: rgba(255, 255, 255, 0.02) !important;
        }
        .dark .notif-item .text-dark {
            color: #ffffff !important;
        }
        .dark .notif-item .text-muted {
            color: #94a3b8 !important;
        }

        /* Admin Cabang specific dark mode overrides */
        .dark .table-produk {
            background: rgba(255, 255, 255, 0.03) !important;
            border-color: rgba(255, 255, 255, 0.06) !important;
        }
        .dark .table-produk th {
            background: rgba(255, 255, 255, 0.05) !important;
            color: #ffffff !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
        }
        .dark .table-produk td {
            background: transparent !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.04) !important;
            color: #94a3b8 !important;
        }
        .dark .table-produk tr:hover td {
            background: rgba(255, 255, 255, 0.02) !important;
        }
        .dark .table-produk th a {
            color: #ffffff !important;
        }
        .dark .table-produk th i {
            color: #ffffff !important;
        }
        .dark .filter-bar {
            background: rgba(255, 255, 255, 0.05) !important;
            border-color: rgba(255, 255, 255, 0.06) !important;
            color: #f8fafc !important;
        }
        .dark .analysis-card {
            background: rgba(255, 255, 255, 0.05) !important;
            border-color: rgba(255, 255, 255, 0.06) !important;
            color: #f8fafc !important;
        }
        .dark .analysis-card-title {
            color: #ffffff !important;
        }
        .dark .reward-card {
            background: rgba(255, 255, 255, 0.03) !important;
            color: #f8fafc !important;
            border: 1px solid rgba(255, 255, 255, 0.06) !important;
        }
        .dark .mini-chart-container {
            background: rgba(255, 255, 255, 0.05) !important;
            border: 1px solid rgba(255, 255, 255, 0.06) !important;
            color: #f8fafc !important;
        }
        .dark .mini-chart-title {
            color: #ffffff !important;
        }
        .dark .list-item-modern {
            border-bottom-color: rgba(255, 255, 255, 0.04) !important;
        }
        .dark .list-item-modern .info h6 {
            color: #ffffff !important;
        }
        .dark .list-item-modern .info small {
            color: #94a3b8 !important;
        }
        .dark .modal-label {
            color: #94a3b8 !important;
        }
        .dark .modal-input, .dark .modal-input:focus {
            background-color: #251448 !important;
            border-color: rgba(255, 255, 255, 0.1) !important;
            color: #f8fafc !important;
        }
        .dark .search-input input {
            background-color: #251448 !important;
            border-color: rgba(255, 255, 255, 0.1) !important;
            color: #f8fafc !important;
        }
        .dark .page-btn {
            background-color: rgba(255, 255, 255, 0.05) !important;
            border-color: rgba(255, 255, 255, 0.1) !important;
            color: #94a3b8 !important;
        }
        .dark .page-btn.active {
            background-color: var(--borma-primary) !important;
            color: #FED50B !important;
            border-color: var(--borma-primary) !important;
        }
        .dark .pagination-links-styled .page-link {
            background-color: rgba(255, 255, 255, 0.05) !important;
            border-color: rgba(255, 255, 255, 0.1) !important;
            color: #94a3b8 !important;
        }
        .dark .pagination-links-styled .page-item.active .page-link {
            background-color: var(--borma-primary) !important;
            color: #FED50B !important;
            border-color: var(--borma-primary) !important;
        }
        .dark .status-pending { background: rgba(217, 119, 6, 0.1) !important; color: #fbbf24 !important; border-color: rgba(217, 119, 6, 0.2) !important; }
        .dark .status-proses { background: rgba(167, 139, 250, 0.1) !important; color: #a78bfa !important; border-color: rgba(167, 139, 250, 0.2) !important; }
        .dark .status-dikirim { background: rgba(37, 99, 235, 0.1) !important; color: #60a5fa !important; border-color: rgba(37, 99, 235, 0.2) !important; }
        .dark .status-selesai { background: rgba(5, 150, 105, 0.1) !important; color: #34d399 !important; border-color: rgba(5, 150, 105, 0.2) !important; }
        .dark .status-siap { background: rgba(220, 38, 38, 0.1) !important; color: #f87171 !important; border-color: rgba(220, 38, 38, 0.2) !important; }
        .dark .chart-daily-bar {
            background-color: rgba(255, 255, 255, 0.04) !important;
        }
        .dark .chart-daily-bar[style*="var(--borma-primary)"] {
            background-color: var(--borma-primary) !important;
        }
        .dark hr {
            border-color: rgba(255, 255, 255, 0.06) !important;
        }

        /* Additional Admin Cabang Custom Elements Contrast fixes */
        .dark .table-modern td {
            background: rgba(255, 255, 255, 0.03) !important;
            color: #f8fafc !important;
            border-color: rgba(255, 255, 255, 0.06) !important;
        }
        .dark .table-modern td:first-child {
            border-left: 1px solid rgba(255, 255, 255, 0.06) !important;
        }
        .dark .table-modern td:last-child {
            border-right: 1px solid rgba(255, 255, 255, 0.06) !important;
        }
        .dark .btn-action-outline {
            border-color: rgba(255, 255, 255, 0.15) !important;
            color: #f8fafc !important;
        }
        .dark .btn-action-outline:hover {
            background-color: rgba(255, 255, 255, 0.05) !important;
            border-color: #FED50B !important;
            color: #FED50B !important;
        }
        .dark .action-icons i.bi-truck {
            color: #110526 !important;
        }
        .dark .action-icons i.bi-eye {
            background: rgba(255, 255, 255, 0.1) !important;
            color: #ffffff !important;
        }
        .dark .action-icons i.bi-eye:hover {
            background: var(--borma-primary) !important;
            color: #FED50B !important;
        }
        .dark .btn-confirm {
            background-color: var(--borma-primary) !important;
            color: #ffffff !important;
        }
        .dark .btn-confirm:hover {
            background-color: #8b5cf6 !important;
        }
        .dark .btn-dispatch {
            background-color: var(--borma-secondary) !important;
            color: #110526 !important;
        }
        .dark .btn-dispatch:hover {
            background-color: #eab308 !important;
        }
        .dark .btn-cancel {
            background-color: rgba(220, 38, 38, 0.1) !important;
            border-color: rgba(220, 38, 38, 0.2) !important;
            color: #f87171 !important;
        }
        .dark .btn-cancel:hover {
            background-color: rgba(220, 38, 38, 0.2) !important;
        }
        .dark .btn-nota {
            color: #94a3b8 !important;
        }
        .dark .btn-nota:hover {
            background-color: rgba(255, 255, 255, 0.05) !important;
            color: #FED50B !important;
        }
        .dark .driver-searching {
            background-color: rgba(37, 99, 235, 0.1) !important;
            border-color: rgba(37, 99, 235, 0.2) !important;
            color: #60a5fa !important;
        }
        .dark .confirm-item-row {
            border-bottom-color: rgba(255, 255, 255, 0.06) !important;
        }
        .dark .confirm-total {
            color: #FED50B !important;
        }

        /* Global inline style overrides for dark mode */
        .dark [style*="color:#6B7280"], .dark [style*="color: #6B7280"] {
            color: #94a3b8 !important;
        }
        .dark [style*="color:#9CA3AF"], .dark [style*="color: #9CA3AF"] {
            color: #cbd5e1 !important;
        }
        .dark [style*="color:#374151"], .dark [style*="color: #374151"] {
            color: #f8fafc !important;
        }
        .dark [style*="color:#555"], .dark [style*="color: #555"] {
            color: #cbd5e1 !important;
        }
        .dark [style*="color:#444"], .dark [style*="color: #444"] {
            color: #cbd5e1 !important;
        }
        .dark [style*="color:#777"], .dark [style*="color: #777"] {
            color: #94a3b8 !important;
        }
        .dark [style*="color:#059669"], .dark [style*="color: #059669"] {
            color: #34d399 !important;
        }
        .dark [style*="border-color:#F3F4F6"], .dark [style*="border-color: #F3F4F6"], .dark [style*="border-color:#E5E7EB"], .dark [style*="border-color: #E5E7EB"] {
            border-color: rgba(255, 255, 255, 0.08) !important;
        }
        .dark [style*="border: 1px solid #E5E7EB"], .dark [style*="border:1px solid #E5E7EB"] {
            border-color: rgba(255, 255, 255, 0.1) !important;
        }
        .dark [style*="border: 1.5px solid #E5E7EB"], .dark [style*="border:1.5px solid #E5E7EB"] {
            border-color: rgba(255, 255, 255, 0.1) !important;
        }
        .dark [style*="border-bottom:2px solid #E5E7EB"], .dark [style*="border-bottom: 2px solid #E5E7EB"] {
            border-bottom-color: rgba(255, 255, 255, 0.1) !important;
        }

        /* Bootstrap Light background elements in dark mode */
        .dark .bg-light {
            background-color: rgba(255, 255, 255, 0.05) !important;
            color: #f8fafc !important;
        }
        .dark .form-select.bg-light, .dark .form-control.bg-light {
            background-color: #251448 !important;
            color: #f8fafc !important;
        }

        /* Input Group Text override for date input calendar icon */
        .dark .input-group-text.bg-white {
            background-color: #251448 !important;
            color: #f8fafc !important;
            border-color: rgba(255, 255, 255, 0.1) !important;
        }

        /* Pagination custom wrapper background */
        .dark .pagination-custom {
            background-color: rgba(255, 255, 255, 0.05) !important;
            border-top-color: rgba(255, 255, 255, 0.06) !important;
        }

        /* Badges/statuses override in notifikasi and promo-voucher */
        .dark [style*="background:#F3F4F6"], .dark [style*="background: #F3F4F6"] {
            background-color: rgba(255, 255, 255, 0.08) !important;
        }
        .dark [style*="background:#ECFDF5"], .dark [style*="background: #ECFDF5"] {
            background-color: rgba(52, 211, 153, 0.15) !important;
        }
        .dark [style*="background:#FEF2F2"], .dark [style*="background: #FEF2F2"] {
            background-color: rgba(248, 113, 113, 0.15) !important;
        }
        .dark [style*="background:#EFF6FF"], .dark [style*="background: #EFF6FF"] {
            background-color: rgba(96, 165, 250, 0.15) !important;
        }
        
        /* Table modern and table th adjustments */
        .dark .table th a, .dark .table-modern th a, .dark .table-produk th a {
            color: #ffffff !important;
        }

        /* KPI text color alignment overrides */
        .dark .kpi-title {
            color: rgba(255, 255, 255, 0.6) !important;
        }
        .dark .kpi-sub {
            color: rgba(255, 255, 255, 0.6) !important;
        }
        .dark .kpi-sub strong {
            color: #ffffff !important;
        }
        .dark .page-subtitle {
            color: rgba(255, 255, 255, 0.5) !important;
        }
        .dark .chart-daily-bar {
            background: rgba(255, 255, 255, 0.04) !important;
        }
        .dark .chart-daily-bar[style*="var(--borma-primary)"] {
            background: var(--borma-primary) !important;
        }
        @endif
    </style>
    @stack('styles')
</head>
<body class="min-h-screen bg-slate-50 dark:bg-borma-dark text-slate-800 dark:text-white overflow-x-hidden selection:bg-borma-purple selection:text-white dark:selection:bg-borma-yellow dark:selection:text-borma-purple transition-colors duration-300">
    
    <!-- Background Decor (Only visible in dark mode) -->
    <div class="fixed top-[-10%] left-[-10%] w-[40%] h-[40%] rounded-full bg-borma-yellow opacity-0 dark:opacity-5 blur-[120px] pointer-events-none transition-opacity duration-500"></div>
    <div class="fixed bottom-[-10%] right-[-10%] w-[50%] h-[50%] rounded-full bg-purple-800 opacity-0 dark:opacity-10 blur-[150px] pointer-events-none transition-opacity duration-500"></div>

    @include('layouts.partials.sidebar')

    <main class="ml-64 relative min-h-screen flex flex-col">
        @include('layouts.partials.topbar')
        
        <div class="flex-1 p-8">
            <!-- Alert for Success/Error (Admin Cabang style) -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-xl mb-6 p-4 flex items-center justify-between" role="alert" style="background: rgba(16, 185, 129, 0.1); color: #10B981;">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-circle-check"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                    @if($isAdminCabang)
                        <button type="button" class="btn-close shadow-none" data-bs-dismiss="alert" aria-label="Close" style="background: none; border: none; color: #10B981; font-size: 1.1rem;"><i class="fa-solid fa-xmark"></i></button>
                    @endif
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-xl mb-6 p-4 flex items-center justify-between" role="alert" style="background: rgba(239, 68, 68, 0.1); color: #EF4444;">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-circle-xmark"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                    @if($isAdminCabang)
                        <button type="button" class="btn-close shadow-none" data-bs-dismiss="alert" aria-label="Close" style="background: none; border: none; color: #EF4444; font-size: 1.1rem;"><i class="fa-solid fa-xmark"></i></button>
                    @endif
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    @if($isAdminCabang)
        <!-- JS Scripts for Admin Cabang -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @endif

    <!-- Theme Toggle Logic -->
    <script>
        const themeToggleBtn = document.getElementById('theme-toggle');
        const themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
        const themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

        if (document.documentElement.classList.contains('dark')) {
            if (themeToggleLightIcon) themeToggleLightIcon.classList.remove('hidden');
        } else {
            if (themeToggleDarkIcon) themeToggleDarkIcon.classList.remove('hidden');
        }

        if (themeToggleBtn) {
            themeToggleBtn.addEventListener('click', function() {
                if (themeToggleDarkIcon) themeToggleDarkIcon.classList.toggle('hidden');
                if (themeToggleLightIcon) themeToggleLightIcon.classList.toggle('hidden');

                if (localStorage.getItem('theme')) {
                    if (localStorage.getItem('theme') === 'light') {
                        document.documentElement.classList.add('dark');
                        localStorage.setItem('theme', 'dark');
                    } else {
                        document.documentElement.classList.remove('dark');
                        localStorage.setItem('theme', 'light');
                    }
                } else {
                    if (document.documentElement.classList.contains('dark')) {
                        document.documentElement.classList.remove('dark');
                        localStorage.setItem('theme', 'light');
                    } else {
                        document.documentElement.classList.add('dark');
                        localStorage.setItem('theme', 'dark');
                    }
                }
            });
        }
    </script>

    <!-- Table Sorting Logic -->
    <script>
        function setupTableSorting() {
            document.querySelectorAll('table.sortable').forEach(table => {
                const headers = table.querySelectorAll('th.sort-header');
                const tbody = table.querySelector('tbody');
                if (!tbody) return;

                headers.forEach(header => {
                    if(!header.querySelector('.sort-icon')) {
                        header.innerHTML += ' <i class="fa-solid fa-sort sort-icon ml-1 opacity-50 text-[10px]"></i>';
                    }
                    header.classList.add('cursor-pointer', 'hover:text-borma-purple', 'dark:hover:text-borma-yellow', 'transition-colors', 'select-none');

                    header.addEventListener('click', () => {
                        const index = Array.from(header.parentElement.children).indexOf(header);
                        const isAscending = header.classList.contains('asc');
                        
                        headers.forEach(h => {
                            h.classList.remove('asc', 'desc');
                            const icon = h.querySelector('.sort-icon');
                            if(icon) {
                                icon.className = 'fa-solid fa-sort sort-icon ml-1 opacity-50 text-[10px]';
                            }
                        });

                        if (isAscending) {
                            header.classList.add('desc');
                            header.querySelector('.sort-icon').className = 'fa-solid fa-sort-down sort-icon ml-1 text-borma-purple dark:text-borma-yellow text-[10px]';
                        } else {
                            header.classList.add('asc');
                            header.querySelector('.sort-icon').className = 'fa-solid fa-sort-up sort-icon ml-1 text-borma-purple dark:text-borma-yellow text-[10px]';
                        }

                        let rows = Array.from(tbody.querySelectorAll('tr.sortable-row'));
                        
                        rows.sort((a, b) => {
                            let aText = a.children[index].textContent.trim();
                            let bText = b.children[index].textContent.trim();
                            
                            let aNum = parseFloat(aText.replace(/[^0-9,-]+/g,"").replace(",", "."));
                            let bNum = parseFloat(bText.replace(/[^0-9,-]+/g,"").replace(",", "."));
                            
                            if (!isNaN(aNum) && !isNaN(bNum) && aText.match(/\d/) && bText.match(/\d/)) {
                                return isAscending ? bNum - aNum : aNum - bNum;
                            }
                            
                            return isAscending ? bText.localeCompare(aText) : aText.localeCompare(bText);
                        });

                        rows.forEach(row => {
                            tbody.appendChild(row);
                            if(row.hasAttribute('data-detail-id')) {
                                let detailId = row.getAttribute('data-detail-id');
                                let detailRow = document.getElementById(detailId);
                                if(detailRow) tbody.appendChild(detailRow);
                            }
                        });
                    });
                });
            });
        }

        document.addEventListener('DOMContentLoaded', setupTableSorting);
    </script>
    @stack('scripts')
</body>
</html>
