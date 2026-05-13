<aside class="w-64 fixed inset-y-0 left-0 bg-white dark:bg-borma-purple/90 dark:backdrop-blur-xl border-r border-slate-200 dark:border-white/10 flex flex-col z-20 transition-colors duration-300 shadow-sm dark:shadow-none">
    <div class="p-6 text-center border-b border-slate-200 dark:border-white/10">
        <h1 class="text-2xl font-bold text-borma-purple dark:text-borma-yellow flex items-center justify-center gap-2">
            <i class="fa-solid fa-cart-shopping"></i> BORMA
        </h1>
        <p class="text-slate-500 dark:text-white/50 text-xs mt-1 uppercase tracking-wider font-semibold">Super Admin Portal</p>
    </div>
    
    <nav class="flex-1 overflow-y-auto py-6 px-4 space-y-2">
        <a href="{{ route('superadmin.dashboard') }}" class="{{ request()->routeIs('superadmin.dashboard') ? 'flex items-center gap-3 px-4 py-3 rounded-xl bg-slate-100 dark:bg-white/10 text-borma-purple dark:text-borma-yellow border border-slate-200 dark:border-white/10 font-bold transition-all' : 'flex items-center gap-3 px-4 py-3 rounded-xl text-slate-600 dark:text-white/70 hover:bg-slate-50 dark:hover:bg-white/5 hover:text-borma-purple dark:hover:text-white font-medium transition-all' }}">
            <i class="fa-solid fa-chart-line w-5"></i> Dashboard
        </a>
        <a href="{{ route('superadmin.pesanan') }}" class="{{ request()->routeIs('superadmin.pesanan') ? 'flex items-center gap-3 px-4 py-3 rounded-xl bg-slate-100 dark:bg-white/10 text-borma-purple dark:text-borma-yellow border border-slate-200 dark:border-white/10 font-bold transition-all' : 'flex items-center gap-3 px-4 py-3 rounded-xl text-slate-600 dark:text-white/70 hover:bg-slate-50 dark:hover:bg-white/5 hover:text-borma-purple dark:hover:text-white font-medium transition-all' }}">
            <i class="fa-solid fa-cart-flatbed w-5"></i> Manajemen Pesanan
        </a>
        <a href="{{ route('superadmin.cabang') }}" class="{{ request()->routeIs('superadmin.cabang') ? 'flex items-center gap-3 px-4 py-3 rounded-xl bg-slate-100 dark:bg-white/10 text-borma-purple dark:text-borma-yellow border border-slate-200 dark:border-white/10 font-bold transition-all' : 'flex items-center gap-3 px-4 py-3 rounded-xl text-slate-600 dark:text-white/70 hover:bg-slate-50 dark:hover:bg-white/5 hover:text-borma-purple dark:hover:text-white font-medium transition-all' }}">
            <i class="fa-solid fa-store w-5"></i> Manajemen Cabang
        </a>
        <a href="{{ route('superadmin.admin_cabang') }}" class="{{ request()->routeIs('superadmin.admin_cabang') ? 'flex items-center gap-3 px-4 py-3 rounded-xl bg-slate-100 dark:bg-white/10 text-borma-purple dark:text-borma-yellow border border-slate-200 dark:border-white/10 font-bold transition-all' : 'flex items-center gap-3 px-4 py-3 rounded-xl text-slate-600 dark:text-white/70 hover:bg-slate-50 dark:hover:bg-white/5 hover:text-borma-purple dark:hover:text-white font-medium transition-all' }}">
            <i class="fa-solid fa-user-tie w-5"></i> Admin Cabang
        </a>
        <a href="{{ route('superadmin.member') }}" class="{{ request()->routeIs('superadmin.member') ? 'flex items-center gap-3 px-4 py-3 rounded-xl bg-slate-100 dark:bg-white/10 text-borma-purple dark:text-borma-yellow border border-slate-200 dark:border-white/10 font-bold transition-all' : 'flex items-center gap-3 px-4 py-3 rounded-xl text-slate-600 dark:text-white/70 hover:bg-slate-50 dark:hover:bg-white/5 hover:text-borma-purple dark:hover:text-white font-medium transition-all' }}">
            <i class="fa-solid fa-address-card w-5"></i> Manajemen Member
        </a>
        <a href="{{ route('superadmin.pengemudi') }}" class="{{ request()->routeIs('superadmin.pengemudi') ? 'flex items-center gap-3 px-4 py-3 rounded-xl bg-slate-100 dark:bg-white/10 text-borma-purple dark:text-borma-yellow border border-slate-200 dark:border-white/10 font-bold transition-all' : 'flex items-center gap-3 px-4 py-3 rounded-xl text-slate-600 dark:text-white/70 hover:bg-slate-50 dark:hover:bg-white/5 hover:text-borma-purple dark:hover:text-white font-medium transition-all' }}">
            <i class="fa-solid fa-users w-5"></i> Manajemen Pengemudi
        </a>
        <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-600 dark:text-white/70 hover:bg-slate-50 dark:hover:bg-white/5 hover:text-borma-purple dark:hover:text-white font-medium transition-all">
            <i class="fa-solid fa-ticket w-5"></i> Voucher & Promo
        </a>
    </nav>

    <div class="p-4 border-t border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-black/20">
        <div class="flex items-center gap-3 bg-white dark:bg-white/5 p-3 rounded-xl border border-slate-200 dark:border-white/10 shadow-sm dark:shadow-none">
            <i class="fa-solid fa-circle-user text-3xl text-slate-400 dark:text-borma-yellow"></i>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-bold text-slate-800 dark:text-white truncate">{{ Auth::user()->nama ?? 'Super Admin' }}</p>
                <p class="text-xs text-slate-500 dark:text-white/60 truncate">{{ Auth::user()->role ?? 'Super Admin' }}</p>
            </div>
            <form action="{{ route('internal.logout') }}" method="POST">
                @csrf
                <button type="submit" class="text-red-500 hover:text-red-600 dark:text-red-400 dark:hover:text-red-300 transition-colors p-2" title="Logout">
                    <i class="fa-solid fa-right-from-bracket"></i>
                </button>
            </form>
        </div>
    </div>
</aside>
