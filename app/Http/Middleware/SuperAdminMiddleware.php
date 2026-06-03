<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SuperAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('internal.login');
        }

        $role = strtolower(auth()->user()->role);

        if (in_array($role, ['super admin', 'admin super', 'staf operasional'])) {
            return $next($request);
        }

        if (in_array($role, ['admin cabang', 'admin'])) {
            return redirect()->route('admin-cabang.dashboard')->with('error', 'Anda tidak memiliki hak akses ke halaman Super Admin.');
        }

        if (in_array($role, ['kurir', 'driver'])) {
            return redirect()->route('driver.dashboard')->with('error', 'Anda tidak memiliki hak akses ke halaman Super Admin.');
        }

        abort(403, 'Akses Ditolak. Anda tidak memiliki wewenang untuk mengakses halaman ini.');
    }
}
