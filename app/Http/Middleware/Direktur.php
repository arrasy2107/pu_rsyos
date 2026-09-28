<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Illuminate\Http\Request;

class Direktur
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect('login');
        }

        $user = Auth::user();

        // Role 0 (super_admin), 1 (direktur), 3 (keperawatan) boleh akses
        if (in_array((int) $user->id_role, [0, 1, 3])) {
            return $next($request);
        }

        // Role 2 (pengawas) diarahkan ke laporan
        if ((int) $user->id_role === 2) {
            return redirect('laporan');
        }

        // Fallback untuk role yang tidak dikenal
        return redirect('login');
    }
}
