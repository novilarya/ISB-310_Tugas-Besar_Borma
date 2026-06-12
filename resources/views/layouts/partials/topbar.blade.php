<header class="h-20 flex items-center justify-between px-8 bg-white/80 dark:bg-borma-dark/80 backdrop-blur-xl border-b border-slate-200 dark:border-white/10 sticky top-0 z-10 transition-colors duration-300">
    <div class="flex items-center gap-4">
        <h2 class="text-xl font-bold text-slate-800 dark:text-white">@yield('page_title', 'Dashboard')</h2>
        
        @if(auth()->user() && in_array(strtolower(auth()->user()->role), ['admin cabang', 'admin']))
        <!-- Active Branch Pill -->
        <div class="hidden md:flex items-center gap-2 bg-slate-100 dark:bg-white/5 px-3 py-1.5 rounded-xl border border-slate-200 dark:border-white/10 shadow-sm dark:shadow-none">
            <span class="text-[10px] font-bold text-borma-purple dark:text-borma-yellow bg-borma-purple/10 dark:bg-borma-yellow/10 px-2 py-0.5 rounded-lg uppercase tracking-wider">Cabang Aktif</span>
            <span class="text-xs font-bold text-slate-700 dark:text-white/90">{{ auth()->user()?->adminCabang?->cabang?->nama_cabang ?? 'Borma Gempol' }}</span>
        </div>
        @endif
    </div>
    
    <div class="flex items-center gap-4">
        <!-- Theme Toggle Button -->
        <button id="theme-toggle" type="button" class="w-10 h-10 rounded-full bg-slate-100 dark:bg-white/5 border border-slate-200 dark:border-white/10 text-slate-600 dark:text-white/70 hover:text-borma-purple dark:hover:text-white hover:bg-slate-200 dark:hover:bg-white/10 transition-all flex items-center justify-center focus:outline-none">
            <i id="theme-toggle-dark-icon" class="fa-solid fa-moon hidden text-slate-700"></i>
            <i id="theme-toggle-light-icon" class="fa-solid fa-sun hidden text-borma-yellow"></i>
        </button>

        @php
            $isSuperAdmin = auth()->user() && in_array(strtolower(auth()->user()->role), ['super admin', 'admin super', 'staf operasional']);
            $isAdminCabang = auth()->user() && in_array(strtolower(auth()->user()->role), ['admin cabang', 'admin']);
        @endphp

        @if($isAdminCabang)
        @php
            $cabang = auth()->user()?->adminCabang?->cabang;
            $topbarNotifications = $cabang ? $cabang->getNotifications() : [];
            $unreadCount = count(array_filter($topbarNotifications, fn($n) => $n['unread'] ?? false));
        @endphp
        <!-- Notifications Dropdown -->
        <div class="relative inline-block text-left" id="notif-dropdown-container">
            <button id="notif-dropdown-btn" type="button" class="w-10 h-10 rounded-full bg-slate-100 dark:bg-white/5 border border-slate-200 dark:border-white/10 text-slate-600 dark:text-white/70 hover:text-borma-purple dark:hover:text-white hover:bg-slate-200 dark:hover:bg-white/10 transition-all flex items-center justify-center relative focus:outline-none">
                <i class="fa-solid fa-bell"></i>
                <span class="absolute top-2 right-2 w-2 h-2 bg-red-500 dark:bg-borma-yellow rounded-full badge-notif {{ $unreadCount > 0 ? '' : 'hidden' }}"></span>
            </button>
            <div id="notif-dropdown-menu" class="hidden absolute right-0 p-0 border border-slate-200 dark:border-white/10 bg-white dark:bg-borma-dark shadow-xl rounded-2xl overflow-hidden z-50 w-[320px] mt-3">
                <div class="p-4 border-b border-slate-200 dark:border-white/10 flex justify-between items-center bg-slate-50 dark:bg-black/20">
                    <h6 class="m-0 font-bold text-slate-800 dark:text-white text-sm">Notifikasi</h6>
                    <div class="flex items-center gap-2">
                        <span class="badge bg-red-500 text-white rounded-full badge-count-text text-[10px] px-2 py-0.5">{{ $unreadCount }} Baru</span>
                        <a href="#" onclick="markAllAsReadFromTopbar(event)" class="text-slate-400 hover:text-borma-purple dark:hover:text-borma-yellow transition-colors" title="Tandai semua dibaca">
                            <i class="fa-solid fa-check-double text-xs"></i>
                        </a>
                    </div>
                </div>
                <div class="max-h-[300px] overflow-y-auto divide-y divide-slate-100 dark:divide-white/5">
                    @forelse($topbarNotifications as $n)
                    <a href="{{ $n['url'] }}" data-id="{{ $n['id'] }}" class="flex items-start gap-3 p-4 hover:bg-slate-50 dark:hover:bg-white/5 transition-colors notif-item {{ $n['unread'] ? 'notif-unread animate-pulse' : '' }}">
                        <div class="w-8 h-8 rounded-full {{ $n['icon_bg'] }} flex items-center justify-center flex-shrink-0 text-xs">
                            <i class="fa-solid {{ $n['icon'] }}"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-bold text-slate-800 dark:text-white truncate">{{ $n['title'] }}</p>
                            <p class="text-[11px] text-slate-500 dark:text-white/60 truncate">{{ $n['message'] }}</p>
                            <p class="text-[10px] text-slate-400 dark:text-white/40 mt-1 flex items-center gap-1"><i class="fa-regular fa-clock"></i> {{ $n['time'] }}</p>
                        </div>
                    </a>
                    @empty
                    <div class="p-4 text-center text-slate-400 dark:text-white/40">
                        <p class="text-xs">Tidak ada notifikasi saat ini.</p>
                    </div>
                    @endforelse
                </div>
                <div class="p-3 border-t border-slate-200 dark:border-white/10 text-center bg-slate-50 dark:bg-black/20">
                    <a href="{{ route('admin-cabang.notifikasi') }}" class="text-xs font-bold text-borma-purple dark:text-borma-yellow hover:underline transition-all">Lihat Semua</a>
                </div>
            </div>
        </div>
        @endif
        
        @if(auth()->user() && in_array(strtolower(auth()->user()->role), ['super admin', 'admin super', 'staf operasional']))
        <!-- Settings Gear -->
        <a href="{{ route('superadmin.pengaturan') }}" class="w-10 h-10 rounded-full bg-slate-100 dark:bg-white/5 border border-slate-200 dark:border-white/10 text-slate-600 dark:text-white/70 hover:text-borma-purple dark:hover:text-white hover:bg-slate-200 dark:hover:bg-white/10 transition-all flex items-center justify-center" title="Pengaturan Profil">
            <i class="fa-solid fa-gear"></i>
        </a>
        @endif

        @if(auth()->user() && in_array(strtolower(auth()->user()->role), ['admin cabang', 'admin']))
        <div class="w-[1px] h-8 bg-slate-200 dark:bg-white/10 mx-1"></div>
        
        <!-- Profile Dropdown (Admin Cabang Only) -->
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
            <ul class="dropdown-menu dropdown-menu-end p-2 border border-slate-200 dark:border-white/10 bg-white dark:bg-borma-dark shadow-xl rounded-2xl overflow-hidden w-[220px] mt-3">
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
        @endif
    </div>
</header>

@if($isAdminCabang)
<script src="{{ asset('js/admin-cabang/topbar.js') }}"></script>
@endif
