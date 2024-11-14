<?php

namespace App\Http\Controllers;

use App\Models\PesertaPosyanduBalita;
use Illuminate\Http\Request;

class PPBController extends Controller

{
    public function index()
    {
        // Mengambil semua data pengguna dari tabel 'PesertaPosyanduBalita'
        $PesertaPosyanduBalitas = PesertaPosyanduBalita::all(); // $users adalah koleksi data semua pengguna

        // Mengirimkan data pengguna ke view 'fitur_databalita_admin'
        return view('fitur_databalita_admin', compact('PesertaPosyanduBalitas'));
    }

    public function DataPesertaBalita($id)
    {
        // Mengambil semua data pengguna dari tabel 'PesertaPosyanduBalita'
        $PesertaPosyanduBalita = PesertaPosyanduBalita::find($id); // $users adalah koleksi data semua pengguna

        // Mengirimkan data pengguna ke view 'fitur_databalita_admin'
        return view('DataPesertaPosyanduBalita_admin', [
            'PesertaPosyanduBalita' => $PesertaPosyanduBalita
        ]);
    }
    
    public function register(Request $request)
    {
        // Validasi data input
        $validatedData = $request->validate([
            'nama_peserta_balita' => 'required|max:255',
            'TTL_balita' => 'required|max:255',
            'NIK_balita' => 'required|max:16',
            'nama_orangtua_balita' => 'required|max:225',
            'NIK_orangtua_balita' => 'required|max:16',
            'alamat_balita' => 'required|max:255',
            'wa_balita' => 'required|max:13',
        ]);

       

        // Menyimpan data pengguna ke database
        PesertaPosyanduBalita::create($validatedData);


        // Redirect ke halaman yang diinginkan setelah pendaftaran, misalnya dashboard admin
        return redirect('/fitur_databalita_admin')->with('success', 'peserta berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_peserta_balita' => 'nullable|max:255',
            'TTL_balita' => 'nullable|max:255',
            'NIK_balita' => 'nullable|max:16',
            'nama_orangtua_balita' => 'nullable|max:225',
            'NIK_orangtua_balita' => 'nullable|max:16',
            'alamat_balita' => 'nullable|max:255',
            'wa_balita' => 'nullable|max:13',
        ]);

        $peserta = PesertaPosyanduBalita::findOrFail($id);
       
        if ($request->filled('nama_peserta_balita')) {
            $peserta->nama_peserta_balita = $validated['nama_peserta_balita'];
        }
        if ($request->filled('TTL_balita')) {
            $peserta->TTL_balita = $validated['TTL_balita'];
        }
        if ($request->filled('NIK_balita')) {
            $peserta->NIK_balita = $validated['NIK_balita'];
        }
        if ($request->filled('nama_orangtua_balita')) {
            $peserta->nama_orangtua_balita = $validated['nama_orangtua_balita'];
        }
        if ($request->filled('NIK_orangtua_balita')) {
            $peserta->NIK_orangtua_balita = $validated['NIK_orangtua_balita'];
        }
        if ($request->filled('alamat_balita')) {
            $peserta->alamat_balita = $validated['alamat_balita'];
        }
        if ($request->filled('wa_balita')) {
            $peserta->wa_balita = $validated['wa_balita'];
        }

        $peserta->save();

        return redirect()->back()->with('success', 'Peserta berhasil diubah');
    }
}