<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
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
        if (Auth::check()) {
            // Redirect based on user's role attribute
            $role = Auth::user()->role;

            switch ($role) {
                case 'admin':
                    return redirect('/dashboard/admin');
                case 'petugas':
                    return redirect('/dashboard/petugas');
                case 'pesertabalita':
                    return redirect('/dashboard/pesertabalita');
                case 'pesertalansia':
                    return redirect('/dashboard/pesertalansia');
                default:
                    // Jika role tidak sesuai, bisa diarahkan ke halaman tertentu atau logout
                    return redirect('/logout');
            }
        }

        return $next($request);
    }
}
