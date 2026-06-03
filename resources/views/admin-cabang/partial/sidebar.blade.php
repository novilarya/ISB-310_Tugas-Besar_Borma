<aside class="w-64 fixed inset-y-0 left-0 bg-white dark:bg-borma-purple/90 dark:backdrop-blur-xl border-r border-slate-200 dark:border-white/10 flex flex-col z-20 transition-colors duration-300 shadow-sm dark:shadow-none">
    <div class="p-6 text-center border-b border-slate-200 dark:border-white/10">
        <h1 class="text-2xl font-bold text-borma-purple dark:text-borma-yellow flex items-center justify-center gap-2">
            <i class="fa-solid fa-cart-shopping"></i> BORMA
        </h1>
        <p class="text-slate-500 dark:text-white/50 text-xs mt-1 uppercase tracking-wider font-semibold">Admin Cabang Portal</p>
    </div>
    
    <nav class="flex-1 overflow-y-auto py-6 px-4 space-y-2">
        @if(auth()->user()->canAccessMenu('admincabang_dashboard'))
        <a href="{{ route('admin-cabang.dashboard') }}" class="{{ request()->routeIs('admin-cabang.dashboard') ? 'flex items-center gap-3 px-4 py-3 rounded-xl bg-slate-100 dark:bg-white/10 text-borma-purple dark:text-borma-yellow border border-slate-200 dark:border-white/10 font-bold transition-all' : 'flex items-center gap-3 px-4 py-3 rounded-xl text-slate-600 dark:text-white/70 hover:bg-slate-50 dark:hover:bg-white/5 hover:text-borma-purple dark:hover:text-white font-medium transition-all' }}">
            <i class="fa-solid fa-chart-line w-5"></i> Dashboard
        </a>
        @endif
        
        @if(auth()->user()->canAccessMenu('admincabang_produk'))
        <a href="{{ route('admin-cabang.produk') }}" class="{{ request()->routeIs('admin-cabang.produk*') ? 'flex items-center gap-3 px-4 py-3 rounded-xl bg-slate-100 dark:bg-white/10 text-borma-purple dark:text-borma-yellow border border-slate-200 dark:border-white/10 font-bold transition-all' : 'flex items-center gap-3 px-4 py-3 rounded-xl text-slate-600 dark:text-white/70 hover:bg-slate-50 dark:hover:bg-white/5 hover:text-borma-purple dark:hover:text-white font-medium transition-all' }}">
            <i class="fa-solid fa-box w-5"></i> Manajemen Produk
        </a>
        @endif
        
        @if(auth()->user()->canAccessMenu('admincabang_pesanan'))
        <a href="{{ route('admin-cabang.pesanan') }}" class="{{ request()->routeIs('admin-cabang.pesanan*') ? 'flex items-center gap-3 px-4 py-3 rounded-xl bg-slate-100 dark:bg-white/10 text-borma-purple dark:text-borma-yellow border border-slate-200 dark:border-white/10 font-bold transition-all' : 'flex items-center gap-3 px-4 py-3 rounded-xl text-slate-600 dark:text-white/70 hover:bg-slate-50 dark:hover:bg-white/5 hover:text-borma-purple dark:hover:text-white font-medium transition-all' }}">
            <i class="fa-solid fa-cart-shopping w-5"></i> Daftar Pesanan
        </a>
        @endif

        @if(auth()->user()->canAccessMenu('admincabang_member'))
        <a href="{{ route('admin-cabang.member') }}" class="{{ request()->routeIs('admin-cabang.member*') ? 'flex items-center gap-3 px-4 py-3 rounded-xl bg-slate-100 dark:bg-white/10 text-borma-purple dark:text-borma-yellow border border-slate-200 dark:border-white/10 font-bold transition-all' : 'flex items-center gap-3 px-4 py-3 rounded-xl text-slate-600 dark:text-white/70 hover:bg-slate-50 dark:hover:bg-white/5 hover:text-borma-purple dark:hover:text-white font-medium transition-all' }}">
            <i class="fa-solid fa-users w-5"></i> Manajemen Member
        </a>
        @endif
        
        @if(auth()->user()->canAccessMenu('admincabang_promo'))
        <a href="{{ route('admin-cabang.promo') }}" class="{{ request()->routeIs('admin-cabang.promo*') ? 'flex items-center gap-3 px-4 py-3 rounded-xl bg-slate-100 dark:bg-white/10 text-borma-purple dark:text-borma-yellow border border-slate-200 dark:border-white/10 font-bold transition-all' : 'flex items-center gap-3 px-4 py-3 rounded-xl text-slate-600 dark:text-white/70 hover:bg-slate-50 dark:hover:bg-white/5 hover:text-borma-purple dark:hover:text-white font-medium transition-all' }}">
            <i class="fa-solid fa-ticket w-5"></i> Promo & Voucher
        </a>
        @endif
        
        @if(auth()->user()->canAccessMenu('admincabang_laporan'))
        <a href="{{ route('admin-cabang.laporan') }}" class="{{ request()->routeIs('admin-cabang.laporan*') ? 'flex items-center gap-3 px-4 py-3 rounded-xl bg-slate-100 dark:bg-white/10 text-borma-purple dark:text-borma-yellow border border-slate-200 dark:border-white/10 font-bold transition-all' : 'flex items-center gap-3 px-4 py-3 rounded-xl text-slate-600 dark:text-white/70 hover:bg-slate-50 dark:hover:bg-white/5 hover:text-borma-purple dark:hover:text-white font-medium transition-all' }}">
            <i class="fa-solid fa-chart-bar w-5"></i> Laporan Cabang
        </a>
        @endif

        @if(auth()->user()->canAccessMenu('admincabang_pengaturan'))
        <a href="{{ route('admin-cabang.pengaturan') }}" class="{{ request()->routeIs('admin-cabang.pengaturan*') ? 'flex items-center gap-3 px-4 py-3 rounded-xl bg-slate-100 dark:bg-white/10 text-borma-purple dark:text-borma-yellow border border-slate-200 dark:border-white/10 font-bold transition-all' : 'flex items-center gap-3 px-4 py-3 rounded-xl text-slate-600 dark:text-white/70 hover:bg-slate-50 dark:hover:bg-white/5 hover:text-borma-purple dark:hover:text-white font-medium transition-all' }}">
            <i class="fa-solid fa-gear w-5"></i> Pengaturan
        </a>
        @endif
    </nav>

    <div class="p-4 border-t border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-black/20">
        <div class="flex items-center gap-3 bg-white dark:bg-white/5 p-3 rounded-xl border border-slate-200 dark:border-white/10 shadow-sm dark:shadow-none">
            <div class="w-10 h-10 rounded-full bg-slate-100 dark:bg-borma-yellow/20 flex items-center justify-center font-bold text-borma-purple dark:text-borma-yellow text-sm">
                {{ strtoupper(substr(auth()->user()->nama ?? 'AC', 0, 2)) }}
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-bold text-slate-800 dark:text-white truncate">{{ auth()->user()->nama ?? 'Admin Cabang' }}</p>
                <p class="text-xs text-slate-500 dark:text-white/60 truncate">{{ auth()->user()->settings['jabatan'] ?? auth()->user()->role ?? 'Admin Cabang' }}</p>
            </div>
            <form action="{{ route('internal.logout') }}" method="POST" class="m-0 p-0 flex items-center">
                @csrf
                <button type="submit" class="text-red-500 hover:text-red-600 dark:text-red-400 dark:hover:text-red-300 transition-colors p-2" title="Logout">
                    <i class="fa-solid fa-right-from-bracket"></i>
                </button>
            </form>
        </div>
    </div>
</aside>
