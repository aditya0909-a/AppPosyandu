<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use Illuminate\Http\Request;
use Carbon\Carbon;
Carbon::setLocale('id');


class JadwalController extends Controller
{
    
public function index()
{
    $jadwals = Jadwal::all()->map(function ($jadwal) {
        return [
            'id' => $jadwal->id,
            'name' => $jadwal->name,
            'date' => $jadwal->date,
            'location' => $jadwal->location,
            'formatted_date' => $jadwal->date ? Carbon::parse($jadwal->date)->isoFormat('dddd, D MMMM YYYY') : null,
        ];
    });

    //dd($jadwals); // Debug hasil map sebelum dikirim ke view

    return view('admin.fitur_penjadwalan', ['Jadwals' => $jadwals]);
}
   
public function getJadwalOptions(Request $request)
{
    // Mendapatkan tanggal hari ini dalam format 'Y-m-d'
    $today = now()->toDateString();

    // Mendapatkan parameter opsional untuk filter tanggal (jika diperlukan)
    $dateFilter = $request->input('date', $today);

    // Mengambil data dari database sesuai dengan tanggal yang diberikan
    $jadwalOptions = Jadwal::whereDate('date', $dateFilter)
        ->select(
            'id',
            'name',
            'location',
            'date',
            'imunisasi',
            'obatcacing',
            'susu',
            'kuisioner',
            'teskognitif',
            'tesdengar',
            'teslihat',
            'tesmobilisasi',
            'keluhan'
        )
        ->get()
        ->map(function ($jadwal) {
            return [
                'id' => $jadwal->id,
                'name' => $jadwal->name,
                'location' => $jadwal->location,
                'date' => $jadwal->date,
                'formatted_date' => $jadwal->date ? Carbon::parse($jadwal->date)->isoFormat('dddd, D MMMM YYYY') : null,
                'imunisasi' => $jadwal->imunisasi,
                'obatcacing' => $jadwal->obatcacing,
                'susu' => $jadwal->susu,
                'kuisioner' => $jadwal->kuisioner,
                'teskognitif' => $jadwal->teskognitif,
                'tesdengar' => $jadwal->tesdengar,
                'teslihat' => $jadwal->teslihat,
                'tesmobilisasi' => $jadwal->tesmobilisasi,
                'keluhan' => $jadwal->keluhan,
            ];
        });

    // Mengembalikan response JSON
    return response()->json(['jadwalOptions' => $jadwalOptions]);
}
public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'date' => 'required|date|after:today', // Validasi tanggal agar setelah hari ini
            'imunisasi' => 'nullable|boolean',
            'obatcacing' => 'nullable|boolean',
            'susu' => 'nullable|boolean',
            'kuisioner' => 'nullable|boolean',
            'keluhan' => 'nullable|boolean',
            'teskognitif' => 'nullable|boolean',
            'tesdengar' => 'nullable|boolean',
            'teslihat' => 'nullable|boolean',
            'tesmobilisasi' => 'nullable|boolean',
        ]);

        Jadwal::create($validatedData);

        return redirect('/admin.fitur_penjadwalan')->with('success', 'Peserta berhasil ditambahkan.');
    }


public function getJadwalForEdit($id)
    {
        // Ambil data jadwal dari database
        $jadwal = Jadwal::findOrFail($id);

        // Return data jadwal dalam format JSON
        return response()->json($jadwal);
    }
}
