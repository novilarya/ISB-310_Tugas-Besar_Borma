<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminCabangMiddleware
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

        $role = auth()->user()->role;

        if (in_array($role, ['Admin Cabang', 'Admin'])) {
            return $next($request);
        }

        if (in_array($role, ['Super Admin', 'Admin Super', 'Staf Operasional'])) {
            return redirect()->route('superadmin.dashboard')->with('error', 'Anda tidak memiliki hak akses ke halaman Admin Cabang.');
        }

        if (in_array($role, ['Kurir', 'Driver'])) {
            return redirect()->route('kurir.dashboard')->with('error', 'Anda tidak memiliki hak akses ke halaman Admin Cabang.');
        }

        abort(403, 'Akses Ditolak. Anda tidak memiliki wewenang untuk mengakses halaman ini.');
    }
}
