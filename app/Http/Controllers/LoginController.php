<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        // dd($request);
        $credentials = $request->validate([
            'id_user' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if ($user->role == 'pesertabalita') {
                $request->session()->regenerate();
                return Redirect::intended('/dashboard/pesertaBalita');
            }
            if ($user->role == 'pesertalansia') {
                $request->session()->regenerate();
                return Redirect::intended('/dashboard/pesertaLansia');
            }
            if ($user->role == 'petugas') {

                $request->session()->regenerate();
                return Redirect::intended('/dashboard/petugas');
            }
            if ($user->role == 'admin') {

                $request->session()->regenerate();
                return Redirect::intended('/dashboard/admin');
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
