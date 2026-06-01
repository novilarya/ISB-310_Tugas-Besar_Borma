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
        $menus = \App\Models\MenuPermission::superAdminMenus();
        
        return view('super-admin.hak-akses', compact('users', 'menus'));
    }

    public function updateHakAkses(Request $request, $userId)
    {
        $user = \App\Models\User::findOrFail($userId);
        
        $menus = \App\Models\MenuPermission::superAdminMenus();
        
        foreach ($menus as $key => $label) {
            $isEnabled = $request->has("permissions.{$key}");
            
            \App\Models\MenuPermission::updateOrCreate(
                ['id_user' => $user->id_user, 'menu_key' => $key],
                ['is_enabled' => $isEnabled]
            );
        }
        
        return redirect()->route('superadmin.hak_akses')->with('success', 'Hak akses berhasil diperbarui.');
    }
}
