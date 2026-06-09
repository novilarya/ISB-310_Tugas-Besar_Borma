<!-- Interactive Map Selection Modal -->
<div id="branchMapModal" class="z-[99999] fixed inset-0 hidden flex items-center justify-center p-4">
    <!-- Backdrop -->
    <div class="absolute inset-0 bg-slate-900/65 backdrop-blur-[12px] z-[1]" onclick="closeBranchSelectorModal()"></div>
    <!-- Card -->
    <div class="relative z-[2] w-[90%] max-w-[950px] h-[80vh] max-h-[600px] bg-white rounded-3xl relative shadow-2xl border border-neutral-100 overflow-hidden flex flex-col md:flex-row transform scale-95 opacity-0 transition-all duration-300 animate-fade-in-modal">
        <!-- Left Panel: Map -->
        <div class="w-full md:w-[65%] h-[250px] md:h-full relative">
            <div id="modal-selector-map" class="w-full h-full z-[1]"></div>
        </div>
        <!-- Right Panel: Sidebar -->
        <div class="w-full md:w-[35%] flex flex-col h-full bg-neutral-50 border-t md:border-t-0 md:border-l border-neutral-200">
            <!-- Header -->
            <div class="p-5 border-b border-neutral-200 bg-white">
                <div class="flex justify-between items-start mb-2">
                    <div>
                        <h4 class="font-heading font-extrabold text-base text-neutral-800">Pilih Cabang Belanja</h4>
                        <p class="text-[11px] text-neutral-500 font-medium mt-0.5">Pilih cabang toko untuk melihat stok dan belanja.</p>
                    </div>
                    <button onclick="closeBranchSelectorModal()" class="text-neutral-400 hover:text-neutral-600 transition-colors p-1 bg-neutral-100 hover:bg-neutral-200 rounded-lg cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                <div class="mt-2.5">
                    <button id="modal-detect-location-btn" onclick="detectLocationInModal()" class="w-full bg-gradient-to-r from-primary-800 to-primary-700 hover:from-primary-750 hover:to-primary-650 text-white font-extrabold text-xs py-2.5 px-3 rounded-xl flex items-center justify-center gap-1.5 transition-colors shadow-sm cursor-pointer border-none">
                        <svg class="w-3.5 h-3.5 text-secondary-400 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span>Deteksi Lokasi Terdekat</span>
                    </button>
                </div>
            </div>
            <!-- List -->
            <div id="modal-branches-list" class="flex-1 overflow-y-auto p-4 space-y-3">
                <div class="flex flex-col items-center justify-center text-center py-12">
                    <div class="w-8 h-8 border-3 border-primary-200 border-t-primary-700 rounded-full animate-spin mb-3"></div>
                    <p class="text-xs text-neutral-500 font-bold">Membuka cabang...</p>
                </div>
            </div>
        </div>
    </div>
</div>
