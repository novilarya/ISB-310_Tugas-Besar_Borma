<header class="sticky top-0 z-50 bg-white text-neutral-800 shadow-sm border-b border-neutral-200">
    <div class="w-full max-w-[1280px] mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 gap-6">
            <!-- Logo -->
            <a href="{{ route('pelanggan.dashboard') }}" class="flex items-center gap-3 group shrink-0">
                <div class="w-10 h-10 sm:w-11 sm:h-11 bg-primary-700 rounded-xl flex items-center justify-center shadow-md group-hover:scale-105 transition-transform duration-300">
                    <span class="text-white font-heading font-extrabold text-lg">B</span>
                </div>
                <div class="hidden sm:block">
                    <h1 class="font-heading font-bold text-xl tracking-tight text-primary-700 leading-none">BORMA</h1>
                    <p class="text-neutral-400 text-xs font-medium mt-0.5">Toserba Digital</p>
                </div>
            </a>

            <!-- Navigation Links -->
            <nav class="hidden lg:flex items-center gap-8 font-semibold text-sm">
                <a href="{{ route('pelanggan.dashboard') }}" class="{{ request()->routeIs('pelanggan.dashboard') ? 'text-primary-700 border-b-2 border-primary-700 pb-1 -mb-[2px]' : 'text-neutral-600 hover:text-primary-700 transition-colors' }}">Home</a>
                <a href="{{ route('pelanggan.katalog') }}" class="{{ request()->routeIs('pelanggan.katalog') ? 'text-primary-700 border-b-2 border-primary-700 pb-1 -mb-[2px]' : 'text-neutral-600 hover:text-primary-700 transition-colors' }}">Katalog</a>
                <a href="#" class="text-neutral-600 hover:text-primary-700 transition-colors">Promo</a>
            </nav>

            <!-- Right Actions -->
            <div class="flex items-center gap-3 shrink-0">
                <a href="{{ route('pelanggan.keranjang') }}" class="relative p-2 {{ request()->routeIs('pelanggan.keranjang') || request()->routeIs('pelanggan.checkout') ? 'text-primary-700 bg-primary-50' : 'text-neutral-500 hover:text-primary-700 hover:bg-primary-50' }} rounded-xl transition-colors" id="navbar-cart-link">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                    <span id="cart-badge" class="absolute top-1 right-1 w-2.5 h-2.5 bg-tertiary-400 rounded-full border-2 border-white" style="display:none;"></span>
                </a>

                <div class="h-6 w-px bg-neutral-200 mx-1 hidden sm:block"></div>

                @auth
                <div class="flex items-center gap-3">
                    <a href="{{ route('pelanggan.profil') }}" class="hidden sm:flex items-center gap-2 group cursor-pointer">
                        <div class="w-8 h-8 {{ request()->routeIs('pelanggan.profil') ? 'bg-primary-700 ring-2 ring-primary-300' : 'bg-primary-100 group-hover:bg-primary-700' }} rounded-lg flex items-center justify-center transition-all">
                            <span class="{{ request()->routeIs('pelanggan.profil') ? 'text-white' : 'text-primary-700 group-hover:text-white' }} font-bold text-sm transition-colors">{{ strtoupper(substr(Auth::user()->nama, 0, 1)) }}</span>
                        </div>
                        <span class="text-sm font-semibold {{ request()->routeIs('pelanggan.profil') ? 'text-primary-700' : 'text-neutral-700 group-hover:text-primary-700' }} transition-colors">{{ Auth::user()->nama }}</span>
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-sm font-bold text-neutral-400 hover:text-tertiary-400 transition-colors">Keluar</button>
                    </form>
                </div>
                @else
                <div class="flex items-center gap-3">
                    <a href="{{ route('login') }}" id="navbar-login-btn" class="hidden sm:block text-sm font-bold text-neutral-700 hover:text-primary-700 transition-colors">Masuk</a>
                    <a href="{{ route('register') }}" id="navbar-register-btn" class="bg-primary-700 text-white text-sm font-bold px-5 py-2.5 rounded-xl hover:bg-primary-600 transition-colors shadow-sm">Daftar</a>
                </div>
                @endauth
            </div>
        </div>
    </div>
</header>
