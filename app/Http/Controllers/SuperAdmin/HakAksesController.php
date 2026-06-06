<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HakAksesController extends Controller
{
    public function hakAkses()
    {
        $users = \App\Models\User::whereIn('role', ['Admin Super', 'Admin Cabang'])
            ->with('menuPermissions')
            ->get();
        
        $superAdminMenus = \App\Models\MenuPermission::superAdminMenus();
        $adminCabangMenus = \App\Models\MenuPermission::adminCabangMenus();
        
        return view('super-admin.hak-akses', compact('users', 'superAdminMenus', 'adminCabangMenus'));
    }

    public function updateHakAkses(Request $request, $userId)
    {
        $user = \App\Models\User::findOrFail($userId);
        
        $menus = $user->role === 'Admin Cabang' 
            ? \App\Models\MenuPermission::adminCabangMenus() 
            : \App\Models\MenuPermission::superAdminMenus();
        
        foreach ($menus as $key => $label) {
            $isEnabled = $request->has("permissions.{$key}");
            
            \App\Models\MenuPermission::updateOrCreate(
                ['id_pengguna' => $user->id_pengguna, 'menu_key' => $key],
                ['akses' => $isEnabled]
            );
        }
        
        return redirect()->route('superadmin.hak_akses')->with('success', 'Hak akses berhasil diperbarui.');
    }
}
