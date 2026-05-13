<header class="h-20 flex items-center justify-between px-8 bg-white/80 dark:bg-borma-dark/80 backdrop-blur-xl border-b border-slate-200 dark:border-white/10 sticky top-0 z-10 transition-colors duration-300">
    <div>
        <h2 class="text-xl font-bold text-slate-800 dark:text-white">@yield('page_title', 'Dashboard')</h2>
    </div>
    <div class="flex items-center gap-4">
        <!-- Theme Toggle Button -->
        <button id="theme-toggle" type="button" class="w-10 h-10 rounded-full bg-slate-100 dark:bg-white/5 border border-slate-200 dark:border-white/10 text-slate-600 dark:text-white/70 hover:text-borma-purple dark:hover:text-white hover:bg-slate-200 dark:hover:bg-white/10 transition-all flex items-center justify-center focus:outline-none">
            <i id="theme-toggle-dark-icon" class="fa-solid fa-moon hidden text-slate-700"></i>
            <i id="theme-toggle-light-icon" class="fa-solid fa-sun hidden text-borma-yellow"></i>
        </button>

        <button class="w-10 h-10 rounded-full bg-slate-100 dark:bg-white/5 border border-slate-200 dark:border-white/10 text-slate-600 dark:text-white/70 hover:text-borma-purple dark:hover:text-white hover:bg-slate-200 dark:hover:bg-white/10 transition-all flex items-center justify-center relative">
            <i class="fa-solid fa-bell"></i>
            <span class="absolute top-2 right-2 w-2 h-2 bg-red-500 dark:bg-borma-yellow rounded-full"></span>
        </button>
        <button class="w-10 h-10 rounded-full bg-slate-100 dark:bg-white/5 border border-slate-200 dark:border-white/10 text-slate-600 dark:text-white/70 hover:text-borma-purple dark:hover:text-white hover:bg-slate-200 dark:hover:bg-white/10 transition-all flex items-center justify-center">
            <i class="fa-solid fa-gear"></i>
        </button>
    </div>
</header>
