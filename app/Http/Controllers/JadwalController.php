<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function getJadwalOptions()
    {
        // Mengambil data dari database
        $jadwalOptions = Jadwal::select(
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
        'keluhan' )->get();
       

        // Mengembalikan response JSON
        return response()->json(['jadwalOptions' => $jadwalOptions]);
    }
    
   
}
