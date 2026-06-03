<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class KurirMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('internal.login');
        }

        $role = auth()->user()->role;

        // Normalisasi: cocokkan baik 'kurir' maupun 'Kurir'/'Driver'
        if (in_array(strtolower($role), ['kurir', 'driver'])) {
            return $next($request);
        }

        if (in_array(strtolower($role), ['super admin', 'admin super', 'staf operasional'])) {
            return redirect()->route('superadmin.dashboard')
                ->with('error', 'Anda tidak memiliki hak akses ke halaman Driver.');
        }

        if (in_array(strtolower($role), ['admin cabang', 'admin'])) {
            return redirect()->route('admin-cabang.dashboard')
                ->with('error', 'Anda tidak memiliki hak akses ke halaman Driver.');
        }

        abort(403, 'Akses Ditolak. Anda tidak memiliki wewenang untuk mengakses halaman ini.');
    }
}
