@extends('super-admin.layouts.app')
@section('title', 'Semua Notifikasi | Super Admin Borma')
@section('page_title', 'Semua Notifikasi')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 dark:text-white flex items-center gap-2">
                <i class="fa-solid fa-bell text-borma-purple dark:text-borma-yellow"></i> 
                Semua Notifikasi
            </h2>
            <p class="text-slate-500 dark:text-white/60 text-sm mt-1">Pantau semua aktivitas administratif dan log sistem platform.</p>
        </div>
        <div>
            <button onclick="markAllAsRead()" class="flex items-center gap-2 px-4 py-2 border border-slate-200 dark:border-white/10 rounded-xl hover:bg-slate-50 dark:hover:bg-white/5 text-slate-600 dark:text-white/70 hover:text-borma-purple dark:hover:text-white font-bold transition-all shadow-sm">
                <i class="fa-solid fa-check-double"></i> Tandai Semua Dibaca
            </button>
        </div>
    </div>

    <div class="bg-white dark:bg-white/5 dark:backdrop-blur-xl border border-slate-200 dark:border-white/10 shadow-sm dark:shadow-none rounded-3xl overflow-hidden divide-y divide-slate-100 dark:divide-white/5">
        
        {{-- Item 1 --}}
        <div class="p-6 flex items-start gap-4 hover:bg-slate-50 dark:hover:bg-white/5 transition-all notif-page-item notif-unread">
            <div class="w-12 h-12 rounded-full bg-amber-100 dark:bg-borma-yellow/10 text-amber-600 dark:text-borma-yellow flex items-center justify-center flex-shrink-0 text-lg shadow-sm">
                <i class="fa-solid fa-store"></i>
            </div>
            <div class="flex-grow min-w-0">
                <h6 class="font-bold text-slate-800 dark:text-white text-base">Cabang Baru Terdaftar</h6>
                <p class="text-sm text-slate-500 dark:text-white/60 mt-1 leading-relaxed">Cabang Borma Dago telah resmi ditambahkan ke sistem dan siap beroperasi.</p>
                <div class="text-xs text-slate-400 dark:text-white/40 mt-2 flex items-center gap-1 font-semibold">
                    <i class="fa-regular fa-clock"></i> 5 menit yang lalu
                </div>
            </div>
            <div>
                <a href="{{ route('superadmin.cabang') }}" class="inline-block px-4 py-2 bg-borma-purple hover:bg-purple-800 dark:bg-borma-yellow dark:hover:bg-yellow-500 text-white dark:text-slate-900 text-xs font-bold rounded-xl transition-all shadow-sm">
                    Lihat Cabang
                </a>
            </div>
        </div>

        {{-- Item 2 --}}
        <div class="p-6 flex items-start gap-4 hover:bg-slate-50 dark:hover:bg-white/5 transition-all notif-page-item notif-unread">
            <div class="w-12 h-12 rounded-full bg-green-100 dark:bg-green-500/10 text-green-600 dark:text-green-400 flex items-center justify-center flex-shrink-0 text-lg shadow-sm">
                <i class="fa-solid fa-users"></i>
            </div>
            <div class="flex-grow min-w-0">
                <h6 class="font-bold text-slate-800 dark:text-white text-base">Registrasi Pengemudi Baru</h6>
                <p class="text-sm text-slate-500 dark:text-white/60 mt-1 leading-relaxed">Pengemudi baru Budi Gunawan telah terverifikasi dan ditugaskan di Cabang Gempol.</p>
                <div class="text-xs text-slate-400 dark:text-white/40 mt-2 flex items-center gap-1 font-semibold">
                    <i class="fa-regular fa-clock"></i> 1 jam yang lalu
                </div>
            </div>
            <div>
                <a href="{{ route('superadmin.pengemudi') }}" class="inline-block px-4 py-2 border border-slate-200 dark:border-white/10 hover:bg-slate-50 dark:hover:bg-white/5 text-slate-600 dark:text-white/70 hover:text-borma-purple dark:hover:text-white text-xs font-bold rounded-xl transition-all shadow-sm">
                    Lihat Pengemudi
                </a>
            </div>
        </div>

        {{-- Item 3 --}}
        <div class="p-6 flex items-start gap-4 hover:bg-slate-50 dark:hover:bg-white/5 transition-all notif-page-item notif-unread">
            <div class="w-12 h-12 rounded-full bg-red-100 dark:bg-red-500/10 text-red-600 dark:text-red-400 flex items-center justify-center flex-shrink-0 text-lg shadow-sm">
                <i class="fa-solid fa-ticket"></i>
            </div>
            <div class="flex-grow min-w-0">
                <h6 class="font-bold text-slate-800 dark:text-white text-base">Promo Global Baru Aktif</h6>
                <p class="text-sm text-slate-500 dark:text-white/60 mt-1 leading-relaxed">Promo 'Semarak Lebaran' dengan kode LEBARAN2026 telah aktif untuk semua cabang.</p>
                <div class="text-xs text-slate-400 dark:text-white/40 mt-2 flex items-center gap-1 font-semibold">
                    <i class="fa-regular fa-clock"></i> 2 jam yang lalu
                </div>
            </div>
            <div>
                <a href="{{ route('superadmin.promo') }}" class="inline-block px-4 py-2 border border-slate-200 dark:border-white/10 hover:bg-slate-50 dark:hover:bg-white/5 text-slate-600 dark:text-white/70 hover:text-borma-purple dark:hover:text-white text-xs font-bold rounded-xl transition-all shadow-sm">
                    Lihat Promo
                </a>
            </div>
        </div>

        {{-- Item 4 --}}
        <div class="p-6 flex items-start gap-4 hover:bg-slate-50 dark:hover:bg-white/5 transition-all notif-page-item">
            <div class="w-12 h-12 rounded-full bg-blue-100 dark:bg-blue-500/10 text-blue-600 dark:text-blue-400 flex items-center justify-center flex-shrink-0 text-lg shadow-sm">
                <i class="fa-solid fa-shield-halved"></i>
            </div>
            <div class="flex-grow min-w-0">
                <h6 class="font-bold text-slate-800 dark:text-white text-base">Perubahan Hak Akses (RBAC)</h6>
                <p class="text-sm text-slate-500 dark:text-white/60 mt-1 leading-relaxed">Hak akses menu untuk pengguna 'Admin Cabang Gempol' telah diperbarui oleh Admin Super.</p>
                <div class="text-xs text-slate-400 dark:text-white/40 mt-2 flex items-center gap-1 font-semibold">
                    <i class="fa-regular fa-clock"></i> Kemarin, 09:15
                </div>
            </div>
            <div>
                <a href="{{ route('superadmin.hak_akses') }}" class="inline-block px-4 py-2 border border-slate-200 dark:border-white/10 hover:bg-slate-50 dark:hover:bg-white/5 text-slate-600 dark:text-white/70 hover:text-borma-purple dark:hover:text-white text-xs font-bold rounded-xl transition-all shadow-sm">
                    Kelola RBAC
                </a>
            </div>
        </div>
    </div>
</div>

<script>
function markAllAsRead() {
    markAllAsReadFromTopbar();
}
</script>
@endsection
