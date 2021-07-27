<?php

namespace App\Http\Middleware;

use Closure;
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
        if (!Auth::check()) // I included this check because you have it, but it really should be part of your 'auth' middleware, most likely added as part of a route group.
        return redirect('login');

        $user = Auth::user();

        if($user->id_role == 2)
        return $next($request);
        
    
            if($user->id_role == 1)
            {
                return redirect('dashboarddirektur');
            }
            else if($user->id_role == 2){
                return redirect('dashboardpengawas');
            }
    }
}
