<!-- Nearest Branch Recommendation Modal -->
<div id="branchRecommendModal" class="z-[99999] fixed inset-0 hidden flex items-center justify-center p-4">
    <!-- Backdrop -->
    <div class="absolute inset-0 bg-slate-900/65 backdrop-blur-[12px] z-[1]"></div>
    <!-- Card -->
    <div class="relative z-[2] bg-white rounded-3xl p-6 sm:p-8 max-w-md w-full relative shadow-2xl border border-neutral-100 flex flex-col items-center text-center transform scale-95 opacity-0 transition-all duration-300 animate-fade-in-modal">
        <div class="w-16 h-16 bg-primary-50 rounded-2xl flex items-center justify-center mb-5 border border-primary-100 shadow-sm relative">
            <svg class="w-8 h-8 text-primary-700 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            <div class="absolute -inset-1 rounded-2xl border-2 border-primary-400 animate-ping opacity-35"></div>
        </div>
        <h3 class="font-heading font-extrabold text-xl text-neutral-800 mb-2">Cabang Terdekat Ditemukan!</h3>
        <p class="text-sm text-neutral-500 mb-6 font-medium leading-relaxed">
            Kami mendeteksi Anda paling dekat dengan <strong id="recommend-branch-name" class="text-primary-800 font-bold">-</strong> (~<span id="recommend-branch-distance">-</span>). Apakah Anda ingin berbelanja di cabang ini agar pengiriman lebih cepat?
        </p>
        <div class="flex flex-col sm:flex-row gap-3 w-full">
            <button id="btn-confirm-recommend" class="flex-1 bg-gradient-to-r from-primary-700 to-primary-600 hover:from-primary-800 hover:to-primary-700 text-white font-extrabold text-sm py-3 px-4 rounded-xl transition-all shadow-md hover:shadow-lg focus:outline-none cursor-pointer">Ya, Terapkan</button>
            <button onclick="rejectRecommendBranch()" class="flex-1 bg-white hover:bg-neutral-50 border border-neutral-200 text-neutral-600 font-bold text-sm py-3 px-4 rounded-xl transition-colors focus:outline-none cursor-pointer">Pilih Cabang Lain</button>
        </div>
    </div>
</div>
