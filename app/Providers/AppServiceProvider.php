<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\MenuPermission;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $user = Auth::user();
                // Load semua menu permissions user ini (eager load sudah di-cache oleh relasi)
                $permissions = $user->menuPermissions()->get()->keyBy('menu_key');

                $allMenuKeys = array_keys(MenuPermission::superAdminMenus());
                $resolved = [];
                foreach ($allMenuKeys as $key) {
                    $resolved[$key] = isset($permissions[$key])
                        ? (bool) $permissions[$key]->is_enabled
                        : true; // default aktif
                }

                $view->with('userMenuPermissions', $resolved);
            } else {
                $view->with('userMenuPermissions', []);
            }
        });
    }
}
