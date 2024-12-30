<?php

namespace App\Http\Controllers;

use App\Models\PesertaPosyanduLansia;
use App\Models\PesertaJadwalLansia;
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
        return redirect()->back()->with('success', 'Peserta berhasil ditambahkan.');
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
    
    public function index()
    {
        // Ambil data dari tabel pesertaposyandubalita
        $peserta = PesertaPosyanduLansia::select('id', 'nama_peserta_lansia')->get();

        // Kembalikan data dalam format JSON
        return response()->json($peserta);
    }
    
        public function store(Request $request)
    {
        // Validasi Input
        $validatedData = $request->validate([
            'jadwal_id' => 'required',
            'peserta_id' => 'required',
        ]);

        try {
            // Simpan ke tabel datakesehatanlansia
            Datakesehatanlansia::create([
                'jadwal_id' => $validatedData['jadwal_id'],
                'peserta_id' => $validatedData['peserta_id'],
            ]);

            // Simpan ke tabel pesertajadwallansia
            PesertaJadwalLansia::create([
                'jadwal_id' => $validatedData['jadwal_id'],
                'peserta_id' => $validatedData['peserta_id'],
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil disimpan.'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 422);
        }
    }

    public function destroy(Request $request)
    {
        // Validasi Input
        $validatedData = $request->validate([
            'jadwal_id' => 'required|integer',
            'peserta_id' => 'required|integer',
        ]);

        try {
            // Hapus dari tabel datakesehatanlansia
            Datakesehatanlansia::where('jadwal_id', $validatedData['jadwal_id'])
                ->where('peserta_id', $validatedData['peserta_id'])
                ->delete();

            // Hapus dari tabel pesertajadwallansia
            PesertaJadwalLansia::where('jadwal_id', $validatedData['jadwal_id'])
                ->where('peserta_id', $validatedData['peserta_id'])
                ->delete();

            return response()->json([
                'success' => true,
                'message' => 'Peserta berhasil dihapus.'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 422);
        }
    }

    public function showpesertajadwal($viewName)
    {

        
        // Mengambil jadwal_id dari segmen ke-4 URL
        $jadwalId = request()->segment(4);

        // Mengambil data peserta balita berdasarkan jadwal
        $peserta = PesertaPosyanduLansia::with('dataKesehatan')
        ->whereHas('dataKesehatan', function ($query) use ($jadwalId) {
            $query->where('jadwal_id', $jadwalId);
        })->get();

        // Kirimkan data jadwal dan peserta ke view yang ditentukan
        return view($viewName, [
            'peserta' => $peserta,
            'jadwalId' => $jadwalId,
        ]);
    }

    public function pendaftaran()
    {
        return $this->showpesertajadwal('petugas.posyandulansia.fitur_pendaftaran');
    }

    public function pengukuran()
    {
        return $this->showpesertajadwal('petugas.posyandulansia.fitur_pengukuran');
    }

    public function penimbangan()
    {
        return $this->showpesertajadwal('petugas.posyandulansia.fitur_penimbangan');
    }

    public function pemeriksaan()
    {
        return $this->showpesertajadwal('petugas.posyandulansia.fitur_pemeriksaan');
    }

    public function tesdengar()
    {
        return $this->showpesertajadwal('petugas.posyandulansia.fitur_tesdengar');
    }

    public function teskognitif()
    {
        return $this->showpesertajadwal('petugas.posyandulansia.fitur_teskognitif');
    }

    public function teslihat()
    {
        return $this->showpesertajadwal('petugas.posyandulansia.fitur_teslihat');
    }

    public function tesmobilisasi()
    {
        return $this->showpesertajadwal('petugas.posyandulansia.fitur_tesmobilisasi');
    }

    public function updatepengukuran(Request $request, $id)
{
    $validated = $request->validate([
        'tinggi_lansia' => 'nullable|numeric|min:0',
        'lingkar_lengan_lansia' => 'nullable|numeric|min:0',
        'lingkar_perut_lansia' => 'nullable|numeric|min:0',
    ]);

    // Ambil data kesehatan berdasarkan ID
    $dataKesehatan = DataKesehatanLansia::findOrFail($id);

    // Update data kesehatan
    $dataKesehatan->tinggi_lansia = $validated['tinggi_lansia'];
    $dataKesehatan->lingkar_lengan_lansia = $validated['lingkar_lengan_lansia'];
    $dataKesehatan->lingkar_perut_lansia = $validated['lingkar_perut_lansia'];


    $dataKesehatan->save();

    return redirect()->back()->with('success', 'Data kesehatan berhasil diperbarui.');
}

public function updatepenimbangan(Request $request, $id)
{
    $validated = $request->validate([
        'berat_lansia' => 'nullable|numeric|min:0',
        
    ]);

    // Ambil data kesehatan berdasarkan ID
    $dataKesehatan = DataKesehatanLansia::findOrFail($id);

    // Update data kesehatan
    $dataKesehatan->berat_lansia = $validated['berat_lansia'];

    $dataKesehatan->save();

    return redirect()->back()->with('success', 'Data kesehatan berhasil diperbarui.');
}

public function updatepemeriksaan(Request $request, $id)
{
    $validated = $request->validate([
        'tensi_lansia' => 'nullable|numeric|min:0',
        'guladarah_lansia' => 'nullable|numeric|min:0',
        'kolesterol_lansia' => 'nullable|numeric|min:0',
        'keluhan_lansia' => 'nullable|string',
        'obat_lansia' => 'nullable|string',
    ]);

    // Ambil data kesehatan berdasarkan ID
    $dataKesehatan = DataKesehatanLansia::findOrFail($id);

    // Update data kesehatan
    
    $dataKesehatan->tensi_lansia = $validated['tensi_lansia'] ?? $dataKesehatan->tensi_lansia;
    $dataKesehatan->guladarah_lansia = $validated['guladarah_lansia'] ?? $dataKesehatan->guladarah_lansia;
    $dataKesehatan->kolesterol_lansia = $validated['kolesterol_lansia'] ?? $dataKesehatan->kolesterol_lansia;
    $dataKesehatan->keluhan_lansia = $validated['keluhan_lansia'] ?? $dataKesehatan->keluhan_lansia;
    $dataKesehatan->obat_lansia = $validated['obat_lansia'] ?? $dataKesehatan->obat_lansia;



    $dataKesehatan->save();

    return redirect()->back()->with('success', 'Data kesehatan berhasil diperbarui.');
}

public function showpesertajadwalkuisioner($viewName)
    {

        // Mengambil jadwal_id dari segmen ke-3 URL
        $jadwalId = request()->segment(3);

        // Mengambil jadwal_id dari segmen ke-2 URL
        $Id = request()->segment(2);

        $dataKesehatan = DataKesehatanLansia::findOrFail($Id);


        // Kirimkan data jadwal dan peserta ke view yang ditentukan
        return view($viewName, [
            'dataKesehatan' => $dataKesehatan,
            'jadwalId' => $jadwalId,
            'Id' => $Id,
        ]);
    }

    public function kuisionerkognitif()
    {
        return $this->showpesertajadwalkuisioner('petugas.posyandulansia.kuisionerkognitif');
    }

    public function kuisionerdengar()
    {
        return $this->showpesertajadwalkuisioner('petugas.posyandulansia.kuisionerdengar');
    }

    public function kuisionerlihat()
    {
        return $this->showpesertajadwalkuisioner('petugas.posyandulansia.kuisionerlihat');
    }

    public function kuisionermobilisasi()
    {
        return $this->showpesertajadwalkuisioner('petugas.posyandulansia.kuisionermobilisasi');
    }

   
    public function updatekuisionerkognitif(Request $request, $id)
    {
        $validated = $request->validate([
            'kognitif1' => 'nullable|boolean',
            'kognitif2' => 'nullable|boolean',
            'depresi1' => 'required|boolean',
            'depresi2' => 'required|boolean',
            'jadwalId' => 'required|integer', // Validasi jadwalId
        ]);
    
        // Ambil data kesehatan berdasarkan ID
        $dataKesehatan = DataKesehatanLansia::findOrFail($id);
    
        // Update data kesehatan
        $dataKesehatan->kognitif1 = $validated['kognitif1'] ?? 0;
        $dataKesehatan->kognitif2 = $validated['kognitif2'] ?? 0;
        $dataKesehatan->depresi1 = $validated['depresi1'];
        $dataKesehatan->depresi2 = $validated['depresi2'];
        $dataKesehatan->submitkognitif = true;
    
        $dataKesehatan->save();
    
        return redirect('/teskognitif/fiturposyandulansia/petugas/' . $validated['jadwalId']);

    }

    public function updatekuisionerdengar(Request $request, $id)
    {
        $validated = $request->validate([
            'dengar' => 'nullable|boolean',
            'jadwalId' => 'required|integer', // Validasi jadwalId
        ]);
    
        // Ambil data kesehatan berdasarkan ID
        $dataKesehatan = DataKesehatanLansia::findOrFail($id);
    
        // Update data kesehatan
        $dataKesehatan->dengar = $validated['dengar'] ?? 0;
        $dataKesehatan->submitdengar = true;
    
        $dataKesehatan->save();
    
        return redirect('/tesdengar/fiturposyandulansia/petugas/' . $validated['jadwalId']);

    }

    public function updatekuisionerlihat(Request $request, $id)
    {
        $validated = $request->validate([
            'lihat1' => 'nullable|boolean',
            'lihat2' => 'nullable|boolean',
            'jadwalId' => 'required|integer', // Validasi jadwalId
        ]);
    
        // Ambil data kesehatan berdasarkan ID
        $dataKesehatan = DataKesehatanLansia::findOrFail($id);
    
        // Update data kesehatan
        $dataKesehatan->lihat1 = $validated['lihat1'] ?? 0;
        $dataKesehatan->lihat2 = $validated['lihat2'] ?? 0;
        $dataKesehatan->submitlihat = true;
    
        $dataKesehatan->save();
    
        return redirect('/teslihat/fiturposyandulansia/petugas/' . $validated['jadwalId']);

    }

    public function updatekuisionermobilisasi(Request $request, $id)
    {
        $validated = $request->validate([
            'mobilisasi' => 'nullable|boolean',
            'jadwalId' => 'required|integer', // Validasi jadwalId
        ]);
    
        // Ambil data kesehatan berdasarkan ID
        $dataKesehatan = DataKesehatanLansia::findOrFail($id);
    
        // Update data kesehatan
        $dataKesehatan->mobilisasi = $validated['mobilisasi1'] ?? 0;
        $dataKesehatan->submitmobilisasi = true;
    
        $dataKesehatan->save();
    
        return redirect('/tesmobilisasi/fiturposyandulansia/petugas/' . $validated['jadwalId']);

    }
    


    
}