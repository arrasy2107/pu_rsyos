<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Illuminate\Http\Request;

class Pengawas
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

        // Hanya role 2 (pengawas) yang boleh akses
        if ((int) $user->id_role === 2) {
            return $next($request);
        }

        // Role lain diarahkan ke halaman sesuai role mereka
        if (in_array((int) $user->id_role, [0, 1, 3])) {
            return redirect('dashboard');
        }

        // Fallback untuk role yang tidak dikenal
        return redirect('login');
    }
}
