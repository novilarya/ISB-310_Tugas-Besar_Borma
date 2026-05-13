@extends('super-admin.layouts.app')
@section('title', 'Manajemen Pesanan | Super Admin Borma')
@section('page_title', 'Manajemen Pesanan')

@section('content')
<div class="bg-white dark:bg-white/5 dark:backdrop-blur-xl border border-slate-200 dark:border-white/10 shadow-sm dark:shadow-none rounded-3xl p-6">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
        <h4 class="text-lg font-bold text-slate-800 dark:text-white">Daftar Seluruh Pesanan</h4>
        
        <!-- Filter Form (Mock) -->
        <form class="flex items-center gap-2 w-full md:w-auto">
            <div class="flex items-center gap-2 bg-slate-50 dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-xl px-3 py-2 flex-1 md:flex-none">
                <i class="fa-regular fa-calendar text-slate-400 dark:text-white/40"></i>
                <input type="date" class="bg-transparent border-none focus:ring-0 text-sm text-slate-600 dark:text-white/70 w-full" value="{{ date('Y-m-d') }}">
                <span class="text-slate-400 dark:text-white/40 text-sm">-</span>
                <input type="date" class="bg-transparent border-none focus:ring-0 text-sm text-slate-600 dark:text-white/70 w-full" value="{{ date('Y-m-d') }}">
            </div>
            <button type="button" class="bg-borma-purple dark:bg-borma-yellow hover:bg-opacity-90 text-white dark:text-borma-purple font-bold py-2 px-4 rounded-xl transition-all shadow-md">
                Filter
            </button>
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-slate-200 dark:border-white/10 text-slate-500 dark:text-white/50 text-sm">
                    <th class="pb-4 font-medium px-4">ID Pesanan</th>
                    <th class="pb-4 font-medium px-4">Tanggal</th>
                    <th class="pb-4 font-medium px-4">Pelanggan</th>
                    <th class="pb-4 font-medium px-4">Cabang</th>
                    <th class="pb-4 font-medium px-4">Total</th>
                    <th class="pb-4 font-medium px-4">Status</th>
                    <th class="pb-4 font-medium px-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-sm">
                @forelse($pesanan as $item)
                <tr class="border-b border-slate-100 dark:border-white/5 hover:bg-slate-50 dark:hover:bg-white/5 transition-colors">
                    <td class="py-4 px-4 font-bold text-slate-800 dark:text-white">{{ $item->id }}</td>
                    <td class="py-4 px-4 text-slate-600 dark:text-white/80">{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y H:i') }}</td>
                    <td class="py-4 px-4 text-slate-600 dark:text-white/80">{{ $item->pelanggan }}</td>
                    <td class="py-4 px-4 text-slate-600 dark:text-white/80">{{ $item->cabang }}</td>
                    <td class="py-4 px-4 font-bold text-borma-purple dark:text-borma-yellow">Rp {{ number_format($item->total, 0, ',', '.') }}</td>
                    <td class="py-4 px-4">
                        @php
                            $statusClasses = [
                                'Selesai' => 'bg-green-100 dark:bg-green-500/20 text-green-700 dark:text-green-400 border-green-200 dark:border-green-500/20',
                                'Dikirim' => 'bg-yellow-100 dark:bg-borma-yellow/20 text-yellow-700 dark:text-borma-yellow border-yellow-200 dark:border-borma-yellow/20',
                                'Menunggu' => 'bg-red-100 dark:bg-red-500/20 text-red-700 dark:text-red-400 border-red-200 dark:border-red-500/20',
                                'Dikemas' => 'bg-blue-100 dark:bg-blue-500/20 text-blue-700 dark:text-blue-400 border-blue-200 dark:border-blue-500/20',
                            ];
                            $classes = $statusClasses[$item->status] ?? 'bg-slate-100 dark:bg-gray-500/20 text-slate-700 dark:text-gray-400 border-slate-200 dark:border-gray-500/20';
                        @endphp
                        <span class="px-3 py-1 rounded-full text-xs font-bold border {{ $classes }}">
                            {{ $item->status }}
                        </span>
                    </td>
                    <td class="py-4 px-4 text-right">
                        <button class="text-borma-purple dark:text-borma-yellow hover:text-purple-700 dark:hover:text-yellow-300 font-bold text-sm bg-slate-100 dark:bg-white/10 px-3 py-1.5 rounded-lg transition-colors">
                            Detail
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="py-8 text-center text-slate-500 dark:text-white/50">Belum ada data pesanan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
