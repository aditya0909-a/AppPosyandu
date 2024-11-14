<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        // Validasi data input
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'id_user' => 'required|unique:users,id_user', // Pastikan id_user unik di tabel users
            'password' => 'required|min:5|max:255',
            'role' => 'required|in:admin,petugas,pesertabalita,pesertalansia' // Validasi untuk role dengan pilihan terbatas
        ]);

        // Hash password menggunakan metode Hash::make
        $validatedData['password'] = Hash::make($validatedData['password']);

        // Menyimpan data pengguna ke database
        User::create($validatedData);


        // Redirect ke halaman yang diinginkan setelah pendaftaran, misalnya dashboard admin
        return redirect('/fitur_kelolaakun_admin')->with('success', 'Akun berhasil dibuat.');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'id_user' => 'nullable|string|unique:users,id_user,' . $id,
            'role' => 'nullable|in:admin,petugas,pesertabalita,pesertalansia',
            'password' => 'nullable|min:6'
        ]);

        $user = User::findOrFail($id);

        if ($request->filled('name')) {
            $user->name = $validated['name'];
        }
        if ($request->filled('id_user')) {
            $user->id_user = $validated['id_user'];
        }
        if ($request->filled('role')) {
            $user->role = $validated['role'];
        }
        if ($request->filled('password')) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->back()->with('success', 'Akun berhasil diubah');
    }
}
