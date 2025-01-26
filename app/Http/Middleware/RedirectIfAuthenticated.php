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
            // Ambil role dan user ID dari pengguna yang login
            $role = Auth::user()->role;
            $userId = Auth::user()->id;

            // Redirect berdasarkan role dan tambahkan user ID ke dalam URL
            switch ($role) {
                case 'admin':
                    return redirect("/dashboard/admin/{$userId}");
                case 'petugas':
                    return redirect("/dashboard/petugas/{$userId}");
                case 'pesertabalita':
                    return redirect("/dashboard/pesertabalita/{$userId}");
                case 'pesertalansia':
                    return redirect("/dashboard/pesertalansia/{$userId}");
                default:
                    // Jika role tidak valid
                    return redirect('/logout');
            }
        }

        return $next($request);
    }

}
