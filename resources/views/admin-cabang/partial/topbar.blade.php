<header class="h-20 flex items-center justify-between px-8 bg-white/80 dark:bg-borma-dark/80 backdrop-blur-xl border-b border-slate-200 dark:border-white/10 sticky top-0 z-10 transition-colors duration-300">
    <div class="flex items-center gap-4">
        <h2 class="text-xl font-bold text-slate-800 dark:text-white">@yield('page_title', 'Dashboard')</h2>
        
        <!-- Active Branch Pill -->
        <div class="hidden md:flex items-center gap-2 bg-slate-100 dark:bg-white/5 px-3 py-1.5 rounded-xl border border-slate-200 dark:border-white/10 shadow-sm dark:shadow-none">
            <span class="text-[10px] font-bold text-borma-purple dark:text-borma-yellow bg-borma-purple/10 dark:bg-borma-yellow/10 px-2 py-0.5 rounded-lg uppercase tracking-wider">Cabang Aktif</span>
            <span class="text-xs font-bold text-slate-700 dark:text-white/90">{{ auth()->user()?->adminCabang?->cabang?->nama_cabang ?? 'Borma Gempol' }}</span>
        </div>
    </div>
    
    <div class="flex items-center gap-4">
        <!-- Theme Toggle Button -->
        <button id="theme-toggle" type="button" class="w-10 h-10 rounded-full bg-slate-100 dark:bg-white/5 border border-slate-200 dark:border-white/10 text-slate-600 dark:text-white/70 hover:text-borma-purple dark:hover:text-white hover:bg-slate-200 dark:hover:bg-white/10 transition-all flex items-center justify-center focus:outline-none">
            <i id="theme-toggle-dark-icon" class="fa-solid fa-moon hidden text-slate-700"></i>
            <i id="theme-toggle-light-icon" class="fa-solid fa-sun hidden text-borma-yellow"></i>
        </button>

        <!-- Notifications Dropdown -->
        <div class="relative dropdown">
            <button class="w-10 h-10 rounded-full bg-slate-100 dark:bg-white/5 border border-slate-200 dark:border-white/10 text-slate-600 dark:text-white/70 hover:text-borma-purple dark:hover:text-white hover:bg-slate-200 dark:hover:bg-white/10 transition-all flex items-center justify-center relative dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa-solid fa-bell"></i>
                <span class="absolute top-2 right-2 w-2 h-2 bg-red-500 dark:bg-borma-yellow rounded-full badge-notif"></span>
            </button>
            <div class="dropdown-menu dropdown-menu-end p-0 border border-slate-200 dark:border-white/10 bg-white dark:bg-borma-dark shadow-xl rounded-2xl overflow-hidden" style="width: 320px; margin-top: 12px;">
                <div class="p-4 border-b border-slate-200 dark:border-white/10 flex justify-between items-center bg-slate-50 dark:bg-black/20">
                    <h6 class="m-0 font-bold text-slate-800 dark:text-white text-sm">Notifikasi</h6>
                    <div class="flex items-center gap-2">
                        <span class="badge bg-red-500 text-white rounded-full badge-count-text text-[10px] px-2 py-0.5">3 Baru</span>
                        <a href="#" onclick="markAllAsReadFromTopbar(event)" class="text-slate-400 hover:text-borma-purple dark:hover:text-borma-yellow transition-colors" title="Tandai semua dibaca">
                            <i class="fa-solid fa-check-double text-xs"></i>
                        </a>
                    </div>
                </div>
                <div class="max-h-[300px] overflow-y-auto divide-y divide-slate-100 dark:divide-white/5">
                    <a href="{{ route('admin-cabang.pesanan') }}" class="flex items-start gap-3 p-4 hover:bg-slate-50 dark:hover:bg-white/5 transition-colors notif-item">
                        <div class="w-8 h-8 rounded-full bg-amber-100 dark:bg-amber-500/20 text-amber-600 dark:text-amber-400 flex items-center justify-center flex-shrink-0 text-xs">
                            <i class="fa-solid fa-cart-shopping"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-bold text-slate-800 dark:text-white truncate">Pesanan Baru #BRM-9021</p>
                            <p class="text-[11px] text-slate-500 dark:text-white/60 truncate">Budi Santoso - 3 Item</p>
                            <p class="text-[10px] text-slate-400 dark:text-white/40 mt-1 flex items-center gap-1"><i class="fa-regular fa-clock"></i> 2 menit lalu</p>
                        </div>
                    </a>
                    <a href="{{ route('admin-cabang.pesanan') }}" class="flex items-start gap-3 p-4 hover:bg-slate-50 dark:hover:bg-white/5 transition-colors notif-item">
                        <div class="w-8 h-8 rounded-full bg-green-100 dark:bg-green-500/20 text-green-600 dark:text-green-400 flex items-center justify-center flex-shrink-0 text-xs">
                            <i class="fa-solid fa-truck"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-bold text-slate-800 dark:text-white truncate">Pesanan #BRM-9018 Selesai</p>
                            <p class="text-[11px] text-slate-500 dark:text-white/60 truncate">Kurir: Asep telah mengonfirmasi.</p>
                            <p class="text-[10px] text-slate-400 dark:text-white/40 mt-1 flex items-center gap-1"><i class="fa-regular fa-clock"></i> 1 jam lalu</p>
                        </div>
                    </a>
                    <a href="{{ route('admin-cabang.produk') }}" class="flex items-start gap-3 p-4 hover:bg-slate-50 dark:hover:bg-white/5 transition-colors notif-item">
                        <div class="w-8 h-8 rounded-full bg-red-100 dark:bg-red-500/20 text-red-600 dark:text-red-400 flex items-center justify-center flex-shrink-0 text-xs">
                            <i class="fa-solid fa-triangle-exclamation"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-bold text-slate-800 dark:text-white truncate">Stok Menipis</p>
                            <p class="text-[11px] text-slate-500 dark:text-white/60 truncate">Minyak Goreng 2L tersisa 5 unit.</p>
                            <p class="text-[10px] text-slate-400 dark:text-white/40 mt-1 flex items-center gap-1"><i class="fa-regular fa-clock"></i> 2 jam lalu</p>
                        </div>
                    </a>
                </div>
                <div class="p-3 border-t border-slate-200 dark:border-white/10 text-center bg-slate-50 dark:bg-black/20">
                    <a href="{{ route('admin-cabang.notifikasi') }}" class="text-xs font-bold text-borma-purple dark:text-borma-yellow hover:underline transition-all">Lihat Semua</a>
                </div>
            </div>
        </div>
        
        <!-- Settings Button -->
        <a href="{{ route('admin-cabang.pengaturan') }}" class="w-10 h-10 rounded-full bg-slate-100 dark:bg-white/5 border border-slate-200 dark:border-white/10 text-slate-600 dark:text-white/70 hover:text-borma-purple dark:hover:text-white hover:bg-slate-200 dark:hover:bg-white/10 transition-all flex items-center justify-center">
            <i class="fa-solid fa-gear"></i>
        </a>

        <div class="w-[1px] h-8 bg-slate-200 dark:bg-white/10 mx-1"></div>
        
        <!-- User Profile Dropdown -->
        <div class="relative dropdown">
            <div class="flex items-center gap-3 bg-slate-100 dark:bg-white/5 p-1.5 pr-4 rounded-xl border border-slate-200 dark:border-white/10 shadow-sm dark:shadow-none cursor-pointer dropdown-toggle hover:bg-slate-200 dark:hover:bg-white/10 transition-all" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="w-8 h-8 rounded-lg bg-borma-purple dark:bg-borma-yellow flex items-center justify-center font-bold text-white dark:text-borma-purple text-xs shadow-md">
                    {{ strtoupper(substr(auth()->user()->nama ?? 'A', 0, 1)) }}
                </div>
                <div class="hidden sm:block text-left">
                    <p class="text-xs font-bold text-slate-800 dark:text-white leading-tight">{{ auth()->user()->nama ?? 'Admin' }}</p>
                    <p class="text-[10px] text-slate-500 dark:text-white/60 leading-none">{{ auth()->user()->settings['jabatan'] ?? auth()->user()->role ?? 'Admin Cabang' }}</p>
                </div>
                <i class="fa-solid fa-chevron-down text-[10px] text-slate-400 dark:text-white/40 ml-1"></i>
            </div>
            <ul class="dropdown-menu dropdown-menu-end p-2 border border-slate-200 dark:border-white/10 bg-white dark:bg-borma-dark shadow-xl rounded-2xl overflow-hidden" style="width: 220px; margin-top: 12px;">
                <div class="px-3 py-2 border-b border-slate-100 dark:divide-white/5 mb-2">
                    <p class="text-[9px] text-slate-400 dark:text-white/40 uppercase tracking-wider font-bold">Login Sebagai</p>
                    <p class="text-xs font-bold text-slate-700 dark:text-white truncate">{{ auth()->user()->email ?? 'admin@borma.co.id' }}</p>
                </div>
                <li>
                    <a class="dropdown-item flex items-center gap-2 px-3 py-2.5 rounded-lg text-xs font-medium text-slate-700 dark:text-white/80 hover:bg-slate-50 dark:hover:bg-white/5" href="{{ route('admin-cabang.pengaturan') }}">
                        <i class="fa-solid fa-user-gear text-slate-400"></i> Profil Saya
                    </a>
                </li>
                <li><hr class="dropdown-divider border-slate-100 dark:border-white/5 my-1"></li>
                <li>
                    <form action="{{ route('internal.logout') }}" method="POST" class="m-0 p-0">
                        @csrf
                        <button type="submit" class="dropdown-item flex items-center gap-2 w-full px-3 py-2.5 rounded-lg text-xs font-bold text-red-500 hover:text-red-600 dark:hover:text-red-400 hover:bg-red-50/50 dark:hover:bg-red-500/10 border-0 bg-transparent text-left">
                            <i class="fa-solid fa-right-from-bracket"></i> Log Out
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</header>

<script>
document.addEventListener('DOMContentLoaded', function() {
    if (localStorage.getItem('all_notifs_read') === 'true') {
        const badge = document.querySelector('.badge-notif');
        if (badge) badge.style.display = 'none';

        const countText = document.querySelector('.badge-count-text');
        if (countText) countText.innerText = '0 Baru';

        const unreadItems = document.querySelectorAll('.notif-unread');
        unreadItems.forEach(item => {
            item.classList.remove('notif-unread');
        });
    }
});

function markAllAsReadFromTopbar(e) {
    if (e) e.preventDefault();
    localStorage.setItem('all_notifs_read', 'true');

    const badge = document.querySelector('.badge-notif');
    if (badge) badge.style.display = 'none';

    const countText = document.querySelector('.badge-count-text');
    if (countText) countText.innerText = '0 Baru';

    const unreadItems = document.querySelectorAll('.notif-unread');
    unreadItems.forEach(item => {
        item.classList.remove('notif-unread');
    });
}
</script>
