@extends('super-admin.layouts.app')
@section('title', 'Manajemen Pengemudi | Super Admin Borma')
@section('page_title', 'Manajemen Pengemudi')

@section('content')
<div class="bg-white dark:bg-white/5 dark:backdrop-blur-xl border border-slate-200 dark:border-white/10 shadow-sm dark:shadow-none rounded-3xl p-6">
    <div class="flex justify-between items-center mb-6">
        <h4 class="text-lg font-bold text-slate-800 dark:text-white">Daftar Pengemudi / Kurir</h4>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-slate-200 dark:border-white/10 text-slate-500 dark:text-white/50 text-sm">
                    <th class="pb-4 font-medium px-4">Nama Pengemudi</th>
                    <th class="pb-4 font-medium px-4">Cabang</th>
                    <th class="pb-4 font-medium px-4">Kirim Hari Ini</th>
                    <th class="pb-4 font-medium px-4">Total Jarak</th>
                    <th class="pb-4 font-medium px-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-sm">
                @php
                    function hitungGaji($jarak) {
                        if ($jarak <= 2.5) return 10000;
                        $sisaJarak = $jarak - 2.5;
                        $multiplier = ceil($sisaJarak / 3.0);
                        return 10000 + ($multiplier * 15000);
                    }
                @endphp
                
                @forelse($pengemudi as $driver)
                <!-- Baris Utama Pengemudi -->
                <tr class="border-b border-slate-100 dark:border-white/5 hover:bg-slate-50 dark:hover:bg-white/5 transition-colors cursor-pointer" onclick="toggleDetails({{ $driver->id }})">
                    <td class="py-4 px-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-slate-200 dark:bg-white/10 flex items-center justify-center text-slate-500 dark:text-white/50">
                                <i class="fa-solid fa-user"></i>
                            </div>
                            <span class="font-bold text-slate-800 dark:text-white">{{ $driver->nama }}</span>
                        </div>
                    </td>
                    <td class="py-4 px-4 text-slate-600 dark:text-white/80 font-medium">{{ $driver->cabang }}</td>
                    <td class="py-4 px-4 font-bold text-borma-purple dark:text-borma-yellow">{{ $driver->pengiriman_hari_ini }} Pesanan</td>
                    <td class="py-4 px-4 text-slate-600 dark:text-white/80">{{ $driver->total_jarak }} km</td>
                    <td class="py-4 px-4 text-right">
                        <button class="text-slate-500 hover:text-borma-purple dark:text-white/50 dark:hover:text-borma-yellow transition-colors">
                            <i class="fa-solid fa-chevron-down" id="icon-{{ $driver->id }}"></i>
                        </button>
                    </td>
                </tr>

                <!-- Baris Detail (Riwayat & Gaji) -->
                <tr id="detail-{{ $driver->id }}" class="hidden bg-slate-50 dark:bg-white/[0.02] border-b border-slate-200 dark:border-white/10">
                    <td colspan="5" class="p-6">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Riwayat Pengiriman -->
                            <div>
                                <h5 class="font-bold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                                    <i class="fa-solid fa-clock-rotate-left text-borma-purple dark:text-borma-yellow"></i> Riwayat Hari Ini
                                </h5>
                                <div class="space-y-3">
                                    @php
                                        $totalGajiHariIni = 0;
                                    @endphp

                                    @if(isset($riwayatPengiriman[$driver->id]) && count($riwayatPengiriman[$driver->id]) > 0)
                                        @foreach($riwayatPengiriman[$driver->id] as $riwayat)
                                            @php
                                                $gajiPesanan = hitungGaji($riwayat->jarak);
                                                $totalGajiHariIni += $gajiPesanan;
                                            @endphp
                                            <div class="flex justify-between items-center bg-white dark:bg-white/5 p-3 rounded-xl border border-slate-200 dark:border-white/10 shadow-sm dark:shadow-none">
                                                <div>
                                                    <p class="font-bold text-sm text-slate-800 dark:text-white">{{ $riwayat->pesanan_id }} <span class="text-xs font-normal text-slate-500 dark:text-white/50 ml-2"><i class="fa-regular fa-clock"></i> {{ $riwayat->waktu }}</span></p>
                                                    <p class="text-xs text-slate-500 dark:text-white/60 mt-1">Jarak: <span class="font-semibold">{{ $riwayat->jarak }} km</span></p>
                                                </div>
                                                <div class="text-right">
                                                    <span class="px-2 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider {{ $riwayat->status == 'Selesai' ? 'bg-green-100 dark:bg-green-500/20 text-green-700 dark:text-green-400' : 'bg-yellow-100 dark:bg-borma-yellow/20 text-yellow-700 dark:text-borma-yellow' }}">
                                                        {{ $riwayat->status }}
                                                    </span>
                                                    <p class="font-bold text-sm text-borma-purple dark:text-borma-yellow mt-1">+Rp {{ number_format($gajiPesanan, 0, ',', '.') }}</p>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="text-center py-4 text-slate-500 dark:text-white/50 text-sm italic">
                                            Belum ada pengiriman hari ini.
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Kalkulasi Benefit -->
                            <div>
                                <h5 class="font-bold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                                    <i class="fa-solid fa-wallet text-green-500"></i> Benefit & Gaji
                                </h5>
                                <div class="bg-gradient-to-br from-borma-purple to-purple-900 dark:from-borma-purple/40 dark:to-transparent rounded-2xl p-5 text-white shadow-md">
                                    <p class="text-white/70 text-sm mb-1">Total Pendapatan Hari Ini</p>
                                    <h3 class="text-3xl font-bold mb-4">Rp {{ number_format($totalGajiHariIni, 0, ',', '.') }}</h3>
                                    
                                    <div class="border-t border-white/20 pt-4 mt-4">
                                        <p class="text-xs text-white/80 font-medium mb-2 uppercase tracking-wider">Formula Perhitungan:</p>
                                        <ul class="text-sm text-white/70 space-y-2">
                                            <li class="flex justify-between">
                                                <span>Jarak &le; 2.5 km</span>
                                                <span class="font-bold text-white">Rp 10.000</span>
                                            </li>
                                            <li class="flex justify-between">
                                                <span>Lebih dari 2.5 km (per 3 km)</span>
                                                <span class="font-bold text-white">+ Rp 15.000</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-8 text-center text-slate-500 dark:text-white/50">Belum ada data pengemudi.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
    function toggleDetails(id) {
        const detailRow = document.getElementById('detail-' + id);
        const icon = document.getElementById('icon-' + id);
        
        if (detailRow.classList.contains('hidden')) {
            detailRow.classList.remove('hidden');
            icon.classList.remove('fa-chevron-down');
            icon.classList.add('fa-chevron-up');
        } else {
            detailRow.classList.add('hidden');
            icon.classList.remove('fa-chevron-up');
            icon.classList.add('fa-chevron-down');
        }
    }
</script>
@endsection
