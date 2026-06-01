@extends('super-admin.layouts.app')
@section('title', 'Manajemen Member | Super Admin Borma')
@section('page_title', 'Manajemen Member')

@section('content')
<div class="grid grid-cols-1 gap-6">
    <div class="bg-white dark:bg-white/5 dark:backdrop-blur-xl border border-slate-200 dark:border-white/10 shadow-sm dark:shadow-none rounded-3xl p-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
            <h4 class="text-lg font-bold text-slate-800 dark:text-white">Daftar Member (Pelanggan)</h4>
            
            <div class="flex flex-col md:flex-row items-center gap-3 w-full md:w-auto">
                <!-- Removed Tambah Member button as requested -->
            </div>
        </div>

        @if(session('success'))
        <div class="bg-green-100 dark:bg-green-500/20 text-green-700 dark:text-green-400 border border-green-200 dark:border-green-500/20 p-4 rounded-xl mb-6">
            {{ session('success') }}
        </div>
        @endif

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse sortable">
                <thead>
                    <tr class="border-b border-slate-200 dark:border-white/10 text-slate-500 dark:text-white/50 text-sm">
                        <th class="pb-4 font-medium px-4 sort-header">Nama</th>
                        <th class="pb-4 font-medium px-4 sort-header">Email</th>
                        <th class="pb-4 font-medium px-4 sort-header">No Telepon</th>
                        <th class="pb-4 font-medium px-4 sort-header">Alamat</th>
                        <th class="pb-4 font-medium px-4 sort-header">Poin</th>
                        <th class="pb-4 font-medium px-4 sort-header">Status</th>
                        <th class="pb-4 font-medium px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse($members as $item)
                    <tr class="border-b border-slate-100 dark:border-white/5 hover:bg-slate-50 dark:hover:bg-white/5 transition-colors sortable-row">
                        <td class="py-4 px-4 font-bold text-slate-800 dark:text-white">{{ $item->user->nama ?? '-' }}</td>
                        <td class="py-4 px-4 text-slate-600 dark:text-white/80">{{ $item->user->email ?? '-' }}</td>
                        <td class="py-4 px-4 text-slate-600 dark:text-white/80">{{ $item->user->no_telepon ?? '-' }}</td>
                        <td class="py-4 px-4 text-slate-600 dark:text-white/80">
                            @php
                                $alamatParts = array_filter([
                                    $item->alamat,
                                    $item->kecamatan,
                                    $item->kota_kabupaten,
                                    $item->provinsi,
                                ]);
                            @endphp
                            {{ implode(', ', $alamatParts) ?: '-' }}
                        </td>
                        <td class="py-4 px-4 font-bold text-borma-purple dark:text-borma-yellow">{{ number_format($item->poin_member) }}</td>
                        <td class="py-4 px-4">
                            <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider border {{ $item->status_member ? 'bg-green-100 dark:bg-green-500/20 text-green-700 dark:text-green-400 border-green-200 dark:border-green-500/20' : 'bg-red-100 dark:bg-red-500/20 text-red-700 dark:text-red-400 border-red-200 dark:border-red-500/20' }}">
                                {{ $item->status_member ? 'Aktif' : 'Tidak Aktif' }}
                            </span>
                        </td>
                        <td class="py-4 px-4 text-right flex justify-end gap-2">
                            <a href="{{ route('superadmin.member.detail', $item->id_pelanggan) }}" class="text-borma-purple dark:text-borma-yellow hover:text-purple-700 dark:hover:text-yellow-300 font-bold text-sm bg-slate-100 dark:bg-white/10 px-3 py-1.5 rounded-lg transition-colors inline-block text-center">
                                Kelola
                            </a>
                            <form action="{{ route('superadmin.member.destroy', $item->id_pelanggan) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus member ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 font-bold text-sm bg-red-50 dark:bg-red-500/10 px-3 py-1.5 rounded-lg transition-colors">
                                    Hapus
                                </button>
                            </form>


                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-8 text-center text-slate-500 dark:text-white/50">Belum ada data member.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
