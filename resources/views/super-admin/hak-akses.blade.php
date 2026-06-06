@extends('super-admin.layouts.app')

@section('title', 'Hak Akses (RBAC) - Super Admin Borma')

@section('header')
<div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
    <div>
        <h2 class="text-2xl font-bold text-slate-800 dark:text-white flex items-center gap-2">
            <i class="fa-solid fa-shield-halved text-borma-purple dark:text-borma-yellow"></i> 
            Hak Akses (RBAC)
        </h2>
        <p class="text-slate-500 dark:text-white/60 text-sm mt-1">Kelola visibilitas menu sidebar untuk setiap akun admin dan super admin.</p>
    </div>
</div>
@endsection

@section('content')
<div class="space-y-6">


    <div class="bg-white dark:bg-white/5 rounded-2xl shadow-sm border border-slate-200 dark:border-white/10 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600 dark:text-white/70">
                <thead class="bg-slate-50 dark:bg-white/5 border-b border-slate-200 dark:border-white/10 text-slate-800 dark:text-white/90">
                    <tr>
                        <th class="py-4 px-6 font-semibold">Pengguna</th>
                        <th class="py-4 px-6 font-semibold">Role</th>
                        <th class="py-4 px-6 font-semibold">Hak Akses Menu</th>
                        <th class="py-4 px-6 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-white/10">
                    @foreach($users as $user)
                    <tr class="hover:bg-slate-50 dark:hover:bg-white/5 transition-colors">
                        <td class="py-4 px-6">
                            <div class="font-bold text-slate-800 dark:text-white">{{ $user->nama }}</div>
                            <div class="text-xs text-slate-500 dark:text-white/50">{{ $user->email }}</div>
                        </td>
                        <td class="py-4 px-6">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold
                                {{ $user->role === 'Admin Super' ? 'bg-purple-100 text-purple-700 dark:bg-purple-500/20 dark:text-purple-300' : 'bg-blue-100 text-blue-700 dark:bg-blue-500/20 dark:text-blue-300' }}">
                                {{ $user->role }}
                            </span>
                        </td>
                        <td class="py-4 px-6">
                            <div class="flex flex-wrap gap-2">
                                @php
                                    $userMenus = $user->role === 'Admin Cabang' ? $adminCabangMenus : $superAdminMenus;
                                @endphp
                                @foreach($userMenus as $key => $label)
                                    @if($user->canAccessMenu($key))
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md bg-green-100 text-green-700 dark:bg-green-500/20 dark:text-green-300 text-xs font-medium">
                                        <i class="fa-solid fa-check text-[10px]"></i> {{ $label }}
                                    </span>
                                    @endif
                                @endforeach
                            </div>
                        </td>
                        <td class="py-4 px-6 text-right">
                            <button onclick="openRbacModal('{{ $user->id_pengguna }}', '{{ $user->nama }}')" class="px-4 py-2 bg-borma-purple hover:bg-purple-700 dark:bg-borma-yellow dark:hover:bg-yellow-500 dark:text-slate-900 text-white text-sm font-semibold rounded-xl transition-all shadow-sm">
                                <i class="fa-solid fa-sliders"></i> Atur
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- RBAC Modal -->
<div id="rbacModal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-slate-900/60 dark:bg-black/80 backdrop-blur-sm"></div>
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
        <div class="relative bg-white dark:bg-slate-900 rounded-2xl shadow-xl w-full max-w-lg text-left overflow-hidden border border-slate-200 dark:border-white/10 transition-all transform scale-95 opacity-0" id="rbacModalContent">
            
            <div class="px-6 py-4 border-b border-slate-200 dark:border-white/10 flex justify-between items-center bg-slate-50 dark:bg-white/5">
                <h3 class="text-lg font-bold text-slate-800 dark:text-white flex items-center gap-2">
                    <i class="fa-solid fa-shield-halved text-borma-purple dark:text-borma-yellow"></i>
                    Atur Hak Akses: <span id="rbacModalUserName" class="text-borma-purple dark:text-borma-yellow"></span>
                </h3>
                <button onclick="closeRbacModal()" class="text-slate-400 hover:text-slate-600 dark:hover:text-white transition-colors">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>

            <form id="rbacForm" method="POST" action="">
                @csrf
                <div class="p-6 space-y-4 max-h-[60vh] overflow-y-auto">
                    <p class="text-sm text-slate-500 dark:text-white/60 mb-4">Pilih menu apa saja yang dapat diakses oleh pengguna ini pada sidebar.</p>
                    
                    <div class="space-y-3" id="rbacCheckboxesContainer">
                        <!-- JavaScript akan mengisi checkbox di sini berdasarkan role -->
                    </div>
                </div>

                <div class="px-6 py-4 border-t border-slate-200 dark:border-white/10 flex justify-end gap-3 bg-slate-50 dark:bg-white/5">
                    <button type="button" onclick="closeRbacModal()" class="px-5 py-2.5 text-sm font-semibold text-slate-600 dark:text-white/70 hover:bg-slate-200 dark:hover:bg-white/10 rounded-xl transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2.5 text-sm font-semibold text-white dark:text-slate-900 bg-borma-purple hover:bg-purple-700 dark:bg-borma-yellow dark:hover:bg-yellow-500 rounded-xl transition-all shadow-sm">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const superAdminMenus = @json($superAdminMenus);
    const adminCabangMenus = @json($adminCabangMenus);

    const userPermissions = {
        @foreach($users as $user)
        '{{ $user->id_pengguna }}': {
            role: '{{ $user->role }}',
            permissions: {
                @php
                    $uMenus = $user->role === 'Admin Cabang' ? $adminCabangMenus : $superAdminMenus;
                @endphp
                @foreach($uMenus as $key => $label)
                '{{ $key }}': {{ $user->canAccessMenu($key) ? 'true' : 'false' }},
                @endforeach
            }
        },
        @endforeach
    };

    function openRbacModal(userId, userName) {
        document.getElementById('rbacModal').classList.remove('hidden');
        document.getElementById('rbacModalUserName').innerText = userName;
        
        const form = document.getElementById('rbacForm');
        form.action = `/superadmin/hak-akses/${userId}`;
        
        const userData = userPermissions[userId];
        const menus = userData.role === 'Admin Cabang' ? adminCabangMenus : superAdminMenus;
        
        const container = document.getElementById('rbacCheckboxesContainer');
        container.innerHTML = '';
        
        for (const [key, label] of Object.entries(menus)) {
            const isEnabled = userData.permissions[key] === true;
            const checkedAttr = isEnabled ? 'checked' : '';
            
            const html = `
                <label class="flex items-center p-3 rounded-xl border border-slate-200 dark:border-white/10 hover:bg-slate-50 dark:hover:bg-white/5 cursor-pointer transition-colors group">
                    <input type="checkbox" name="permissions[${key}]" id="perm_${key}" value="1" ${checkedAttr} class="w-5 h-5 rounded border-slate-300 text-borma-purple focus:ring-borma-purple dark:border-white/20 dark:bg-slate-800 dark:checked:bg-borma-yellow">
                    <span class="ml-3 font-medium text-slate-700 dark:text-white/90 group-hover:text-borma-purple dark:group-hover:text-borma-yellow transition-colors">${label}</span>
                </label>
            `;
            container.insertAdjacentHTML('beforeend', html);
        }
        
        setTimeout(() => {
            const content = document.getElementById('rbacModalContent');
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    function closeRbacModal() {
        const content = document.getElementById('rbacModalContent');
        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            document.getElementById('rbacModal').classList.add('hidden');
        }, 200);
    }
</script>
@endsection
