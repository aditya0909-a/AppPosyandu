<?php

namespace App\Http\Controllers;

use App\Models\PesertaPosyanduBalita;
use App\Models\DataKesehatanBalita; // Tambahkan ini
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PPBController extends Controller
{
        // Menampilkan data spesifik peserta balita berdasarkan ID
    public function DataPesertaBalita($id)
    {
        $PesertaPosyanduBalita = PesertaPosyanduBalita::findOrFail($id);

        return view('admin.databalita', [
            'PesertaPosyanduBalita' => $PesertaPosyanduBalita,
        ]);
    }

    // Menambahkan data peserta balita baru
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'nama_peserta_balita' => 'required|max:255',
            'TempatLahir_balita' => 'required|max:255',
            'TanggalLahir_balita' => 'required|date',
            'NIK_balita' => 'required|max:16',
            'nama_orangtua_balita' => 'required|max:255',
            'NIK_orangtua_balita' => 'required|max:16',
            'alamat_balita' => 'required|max:255',
            'wa_balita' => 'required|max:13',
        ]);

        PesertaPosyanduBalita::create($validatedData);

        return redirect('/admin.fitur_databalita')->with('success', 'Peserta berhasil ditambahkan.');
    }

    // Mengupdate data peserta balita
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_peserta_balita' => 'nullable|max:255',
            'TempatLahir_balita' => 'nullable|max:255',
            'TanggalLahir_balita' => 'nullable|date',
            'NIK_balita' => 'nullable|max:16',
            'nama_orangtua_balita' => 'nullable|max:255',
            'NIK_orangtua_balita' => 'nullable|max:16',
            'alamat_balita' => 'nullable|max:255',
            'wa_balita' => 'nullable|max:13',
        ]);

        $peserta = PesertaPosyanduBalita::findOrFail($id);

        // Mengupdate atribut hanya jika field tersebut diisi
        if ($request->filled('nama_peserta_balita')) {
            $peserta->nama_peserta_balita = $validated['nama_peserta_balita'];
        }
        if ($request->filled('TempatLahir_balita')) {
            $peserta->TempatLahir_balita = $validated['TempatLahir_balita'];
        }
        if ($request->filled('TanggalLahir_balita')) {
            $peserta->TanggalLahir_balita = $validated['TanggalLahir_balita'];
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

        return redirect()->back()->with('success', 'Peserta berhasil diubah.');
    }


    // Menampilkan data kesehatan peserta
    public function DataKesehatan($id)
    {
        $PesertaPosyanduBalita = PesertaPosyanduBalita::findOrFail($id);
        $data = DB::table('DataKesehatanBalita')
            ->where('peserta_id', $id)
            ->select('created_at', 'obat_cacing', 'susu', 'imunisasi', 'keluhan_balita', 'penanganan_balita', 'bulan_ke', 'tinggi_balita', 'berat_balita', 'lingkar_kepala_balita')
            ->get();

        $obatCacingData = $data->map(function ($item) {
            return [
                'tanggal' => Carbon::parse($item->created_at)->format('d-m-Y'),
                'keterangan_obat_cacing' => $item->obat_cacing === 'iya' ? 'Sudah Diberikan' : 'Belum Diberikan',
            ];
        });

        $susuData = $data->map(function ($item) {
            return [
                'tanggal' => Carbon::parse($item->created_at)->format('d-m-Y'),
                'keterangan_susu' => $item->susu === 'iya' ? 'Sudah Diberikan' : 'Belum Diberikan',
            ];
        });

        $imunisasiData = $data->map(function ($item) {
            return [
                'tanggal' => Carbon::parse($item->created_at)->format('d-m-Y'),
                'jenis_imunisasi' => $item->imunisasi,
                'keterangan_imunisasi' => $item->imunisasi === 'iya' ? 'Sudah Diberikan' : 'Belum Diberikan',
            ];
        });

        $keluhanData = $data->map(function ($item) {
            return [
                'tanggal' => Carbon::parse($item->created_at)->format('d-m-Y'),
                'keluhan' => $item->keluhan_balita,
                'penanganan' => $item->penanganan_balita,
            ];
        });


        return view('admin.databalita', compact('PesertaPosyanduBalita', 'obatCacingData', 'susuData', 'imunisasiData', 'keluhanData', 'data'));
    }

    public function getChartDataByPeserta($peserta_id)
    {

        
        // Ambil data berdasarkan peserta_id
        $data = DataKesehatanBalita::where('peserta_id', $peserta_id)
            ->orderBy('bulan_ke') 
            ->get();

        
        $chartData = [
            'tinggiBadan' => [
                'label' => 'Tinggi Badan (cm)',
                'data' => $data->pluck('tinggi_balita')->toArray(),
            ],
            'beratBadan' => [
                'label' => 'Berat Badan (kg)',
                'data' => $data->pluck('berat_balita')->toArray(),
            ],
            'lingkarKepala' => [
                'label' => 'Lingkar Kepala (cm)',
                'data' => $data->pluck('lingkar_kepala_balita')->toArray(),
            ],
        ];

               
        return response()->json($chartData);
    }  
    
}
