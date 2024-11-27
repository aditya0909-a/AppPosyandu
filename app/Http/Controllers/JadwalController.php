<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use Illuminate\Http\Request;

class JadwalController extends Controller

{
    public function index()
    {
        // Mengambil semua data pengguna dari tabel 'Jadwal'
        $Jadwals = Jadwal::all(); // $users adalah koleksi data semua pengguna

        // Mengirimkan data pengguna ke view 'fitur_databalita_admin'
        return view('fitur_penjadwalan_admin', compact('Jadwals'));

         // Mengirimkan data pengguna ke view 'fitur_databalita_admin'
         return view('fiturpenjadwalan_petugas', compact('Jadwals'));

         // Mengirimkan data pengguna ke view 'fitur_databalita_admin'
         return view('fiturposyandubalita_petugas', compact('Jadwals'));

         // Mengirimkan data pengguna ke view 'fitur_databalita_admin'
         return view('fiturjadwal_peserta_balita', compact('Jadwals'));

         // Mengirimkan data pengguna ke view 'fitur_databalita_admin'
         return view('fiturjadwal_peserta_balita', compact('Jadwals'));
    }

    public function DataPenjadwalan($id)
    {
        // Mengambil semua data pengguna dari tabel 'Jadwal'
        $Jadwal = Jadwal::find($id); // $users adalah koleksi data semua pengguna

        // Mengirimkan data pengguna ke view 'fitur_penjadwalan_admin'
        return view('DataPenjadwalan_admin', [
            'Jadwal' => $Jadwal
        ]);

    }
    
    public function register(Request $request)
    {
        // Validasi data input
        $validatedData = $request->validate([
            'nama_jadwal' => 'required|max:255',
            'tanggal_jadwal' => 'required|max:255',
            'lokasi_jadwal' => 'required|in:BanjarDesa,BanjarBingin,BanjarDajanPakung',
            'Posyandu' => 'required|in:PosyanduBalita,PosyanduLansia',
            'Imunisasi' => 'required|in:iya,tidak',
            'obat_cacing' => 'required|in:iya,tidak',
            'susu' => 'required|in:iya,tidak',
            'tes_lansia' => 'required|in:iya,tidak',
            'PMT_lansia' => 'required|in:iya,tidak',
        ]);

        
        // Menyimpan data pengguna ke database
        Jadwal::create($validatedData);


        // Redirect ke halaman yang diinginkan setelah pendaftaran, misalnya dashboard admin
        return redirect('/fitur_penjadwalan_admin')->with('success', 'jadwal berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_jadwal' => 'nullable|max:255',
            'tanggal_jadwal' => 'nullable|max:255',
            'lokasi_jadwal' => 'nullable|in:BanjarDesa,BanjarBingin,BanjarDajanPakung',
            'Posyandu' => 'nullable|in:PosyanduBalita,PosyanduLansia',
            'Imunisasi' => 'nullable|in:iya,tidak',
            'obat_cacing' => 'nullable|in:iya,tidak',
            'susu' => 'nullable|in:iya,tidak',
            'tes_lansia' => 'nullable|in:iya,tidak',
            'PMT_lansia' => 'nullable|in:iya,tidak',
        ]);
        

        $Jadwal = Jadwal::findOrFail($id);
       
        if ($request->filled('nama_jadwal')) {
            $Jadwal->nama_jadwal = $validated['nama_jadwal'];
        }
        if ($request->filled('tanggal_jadwal')) {
            $Jadwal->tanggal_jadwal = $validated['tanggal_jadwal'];
        }
        if ($request->filled('lokasi_jadwal')) {
            $Jadwal->lokasi_jadwal = $validated['lokasi_jadwal'];
        }
        if ($request->filled('Posyandu')) {
            $Jadwal->Posyandu = $validated['Posyandu'];
        }
        if ($request->filled('Imunisasi')) {
            $Jadwal->Imunisasi = $validated['Imunisasi'];
        }
        if ($request->filled('obat_cacing')) {
            $Jadwal->obat_cacing = $validated['obat_cacing'];
        }
        if ($request->filled('susu')) {
            $Jadwal->susu = $validated['susu'];
        }
        if ($request->filled('tes_lansia')) {
            $Jadwal->tes_lansia = $validated['tes_lansia'];
        }
        if ($request->filled('PMT_lansia')) {
            $Jadwal->PMT_lansia = $validated['PMT_lansia'];
        }

        $Jadwal->save();

        return redirect()->back()->with('success', 'Jadwal berhasil diubah');
    }
}