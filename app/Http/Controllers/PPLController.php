<?php

namespace App\Http\Controllers;

use App\Models\PesertaPosyanduLansia;
use Illuminate\Http\Request;

class PPLController extends Controller

{
    public function index()
    {
        // Mengambil semua data pengguna dari tabel 'PesertaPosyandulansia'
        $PesertaPosyanduLansias = PesertaPosyanduLansia::all(); // $PesertaPosyanduLansias adalah koleksi data semua peserta lansia

        // Mengirimkan data pengguna ke view 'fitur_datalansia_admin'
        return view('fitur_datalansia_admin', compact('PesertaPosyanduLansias'));
    }
    
    public function register(Request $request)
    {
        // Validasi data input
        $validatedData = $request->validate([
            'nama_peserta_lansia' => 'required|max:255',
            'TTL_lansia' => 'required|max:255',
            'NIK_lansia' => 'required|max:25',
            'alamat_lansia' => 'required|max:255',
            'wa_lansia' => 'required|max:15',
        ]);

       

        // Menyimpan data pengguna ke database
        PesertaPosyanduLansia::create($validatedData);


        // Redirect ke halaman yang diinginkan setelah pendaftaran, misalnya dashboard admin
        return redirect('/fitur_datalansia_admin')->with('success', 'peserta berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_peserta_lansia' => 'nullable|max:255',
            'TTL_lansia' => 'nullable|max:255',
            'NIK_lansia' => 'nullable|max:25',
            'alamat_lansia' => 'nullable|max:255',
            'wa_lansia' => 'nullable|max:15',
        ]);


        $peserta = PesertaPosyandulansia::findOrFail($id);
        
        if ($request->filled('nama_peserta_lansia')) {
            $peserta->nama_peserta_lansia = $validated['nama_peserta_lansia'];
        }
        if ($request->filled('TTL_lansia')) {
            $peserta->TTL_lansia = $validated['TTL_lansia'];
        }
        if ($request->filled('NIK_lansia')) {
            $peserta->NIK_lansia = $validated['NIK_lansia'];
        }
        if ($request->filled('alamat_lansia')) {
            $peserta->alamat_lansia = $validated['alamat_lansia'];
        }
        if ($request->filled('wa_lansia')) {
            $peserta->wa_lansia = $validated['wa_lansia'];
        }

        $peserta->save();

        return redirect()->back()->with('success', 'Peserta berhasil diubah');
    }
}