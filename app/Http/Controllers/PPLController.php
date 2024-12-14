<?php

namespace App\Http\Controllers;

use App\Models\PesertaPosyanduLansia;
use App\Models\DataKesehatanLansia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PPLController extends Controller

{
       
        // Menampilkan data spesifik peserta lansia berdasarkan ID
        public function DataPesertaLansia($id)
        {
            $PesertaPosyanduLansia = PesertaPosyanduLansia::findOrFail($id);
    
            return view('admin.datalansia', [
                'PesertaPosyanduLansia' => $PesertaPosyanduLansia,
            ]);
        }
    
    
    public function register(Request $request)
    {
        // Validasi data input
        $validatedData = $request->validate([
            'nama_peserta_lansia' => 'required|max:255',
            'TempatLahir_lansia' => 'required|max:255',
            'TanggalLahir_lansia' => 'required|date',
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

    // Menampilkan data kesehatan peserta
    public function DataKesehatan($id)
    {
        $PesertaPosyanduLansia = PesertaPosyanduLansia::findOrFail($id);
        $data = DB::table('DataKesehatanLansia')
            ->where('peserta_id', $id)
            ->select('created_at','keluhan_lansia', 'obat_lansia', 'tinggi_lansia', 'berat_lansia', 'lingkar_lengan_lansia', 'lingkar_perut_lansia')
            ->get();

        $keluhanData = $data->map(function ($item) {
            return [
                'tanggal' => Carbon::parse($item->created_at)->format('d-m-Y'),
                'keluhan' => $item->keluhan_lansia,
                'obat' => $item->obat_lansia,
            ];
        });


        return view('admin.datalansia', compact('PesertaPosyanduLansia', 'data'));
    }

    public function getChartDataByPeserta($peserta_id)
    {

        
        // Ambil data berdasarkan peserta_id
        $data = DataKesehatanLansia::where('peserta_id', $peserta_id)
            ->orderBy('created_at', 'asc') 
            ->get();

        
        $chartData = [
            'tinggiBadan' => [
                'label' => 'Tinggi Badan (cm)',
                'data' => $data->pluck('tinggi_lansia')->toArray(),
            ],
            'beratBadan' => [
                'label' => 'Berat Badan (kg)',
                'data' => $data->pluck('berat_lansia')->toArray(),
            ],
            'lingkarKepala' => [
                'label' => 'Lingkar Kepala (cm)',
                'data' => $data->pluck('lingkar_kepala_lansia')->toArray(),
            ],
        ];

               
        return response()->json($chartData);
    }  
}