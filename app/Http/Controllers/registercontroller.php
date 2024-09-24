<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class registercontroller extends Controller
{
    public function register(request $request){
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'id_user' => 'required',
            'password' => 'required|min:5|max:255'
        ]);

        $validatedData['password'] = bcrypt($validatedData['password']); //cara enskrpisi password dengan metode bcrypt
        // $validatedData['passowrd'] = Hash::make($validatedData['password']); //cara enkrpsi password dengan metode Hash
        $validatedData['role'] = 'peserta';
        User::create($validatedData);

        $request = session();
        $request->flash('success', 'Registration successfull! Please login');

        return redirect('/login');
    }
}
