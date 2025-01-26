<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class LoginController extends Controller
{
    public function login(Request $request)
{
    $credentials = $request->validate([
        'id_user' => 'required',
        'password' => 'required'
    ]);

    if (Auth::attempt($credentials)) {
        $user = Auth::user();
        $userId = $user->id;  // Ambil user ID

        // Regenerasi session setelah login berhasil
        $request->session()->regenerate();

        // Redirect berdasarkan role dan tambahkan user ID ke URL
        switch ($user->role) {
            case 'pesertabalita':
                return redirect("/dashboard/pesertabalita/{$userId}");
            case 'pesertalansia':
                return redirect("/dashboard/pesertalansia/{$userId}");
            case 'petugas':
                return redirect("/dashboard/petugas/{$userId}");
            case 'admin':
                return redirect("/dashboard/admin/{$userId}");
            default:
                return back()->with('loginError', 'Role pengguna tidak dikenali.');
        }
    }

    return back()->with('loginError', 'Id Pengguna atau Password salah.');
}


    
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
    
}
