<?php

namespace App\Http\Controllers;

use App\Models\PesertaPosyanduLansia;
use App\Models\PesertaJadwalLansia;
use App\Models\User;
use App\Models\DataKesehatanLansia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Events\DaftarHadir;
use App\Events\DaftarHadirRemove;

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
        // Validasi input
        $request->validate([
                'nama_peserta_lansia' => 'required|max:255',
                'TempatLahir_lansia' => 'required|max:255',
                'TanggalLahir_lansia' => 'required|date',
                'NIK_lansia' => 'required|max:255',
                'alamat_lansia' => 'required|max:255',
                'wa_lansia' => 'required|max:255',
        ]);

        // Buat record baru di tabel user
        $user = User::create([
            'name' => $request->nama_peserta_lansia,
            'id_user' => $request->NIK_lansia,
            'password' => bcrypt($request->NIK_lansia),
            'role' => 'pesertalansia',
        ]);
        
        // Reload user dari database untuk memastikan ID-nya tersedia
        $user = User::find($user->id);
        

        // Buat record baru di tabel pesertaposyandubalita
        PesertaPosyanduLansia::create([
            'nama_peserta_lansia' => $request->nama_peserta_lansia,
            'NIK_lansia' => $request->NIK_lansia,
            'TempatLahir_lansia' => $request->TempatLahir_lansia,
            'TanggalLahir_lansia' => $request->TanggalLahir_lansia,
            'user_id' => $user->id, // Pastikan ID user diambil dari instansi User
            'alamat_lansia' => $request->alamat_lansia,
            'wa_lansia' => $request->wa_lansia,
        ]);


        return redirect()->back()->with('success', 'Peserta berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_peserta_lansia' => 'nullable|max:255',
            'TempatLahir_lansia' => 'nullable|max:255',
            'TanggalLahir_lansia' => 'nullable|max:255',
            'NIK_lansia' => 'nullable|max:255',
            'alamat_lansia' => 'nullable|max:255',
            'wa_lansia' => 'nullable|max:255',
        ]);


        $peserta = PesertaPosyandulansia::findOrFail($id);
        
        if ($request->filled('nama_peserta_lansia')) {
            $peserta->nama_peserta_lansia = $validated['nama_peserta_lansia'];
        }
        if ($request->filled('TempatLahir_lansia')) {
            $peserta->TempatLahir_lansia = $validated['TempatLahir_lansia'];
        }
        if ($request->filled('TanggalLahir_lansia')) {
            $peserta->TanggalLahir_lansia = $validated['TanggalLahir_lansia'];
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
            ->select('created_at','keluhan_lansia', 'obat_lansia', 'mobilisasi', 'dengar', 'depresi1', 'depresi2', 'lihat1', 'lihat2', 'kognitif1', 'malnutrisi1', 'malnutrisi2', 'malnutrisi3', 'kognitif2', 'tinggi_lansia','guladarah_lansia','kolesterol_lansia','asamurat_lansia','tensi_lansia', 'berat_lansia', 'lingkar_lengan_lansia', 'lingkar_perut_lansia')
            ->get();

        $keluhanData = $data->map(function ($item) {
            return [
                'tanggal' => Carbon::parse($item->created_at)->format('d-m-Y'),
                'keluhan' => $item->keluhan_lansia,
                'obat' => $item->obat_lansia,
            ];
        });

        // Filter dan map untuk GCU
        $GCUData = $data->filter(function ($item) {
            // Pastikan kolom yang diperlukan tidak null
            return !is_null($item->guladarah_lansia) && !is_null($item->kolesterol_lansia) 
                && !is_null($item->tensi_lansia) && !is_null($item->asamurat_lansia);
        })->map(function ($item) {
            return [
                'tanggal' => Carbon::parse($item->created_at)->format('d-m-Y'),
                'guladarah' => $item->guladarah_lansia,
                'kolesterol' => $item->kolesterol_lansia,
                'tensi' => $item->tensi_lansia,
                'asamurat' => $item->asamurat_lansia,
            ];
        });

        $KognitifData = $data->map(function ($item) {
            return [
                'tanggal' => Carbon::parse($item->created_at)->format('d-m-Y'),
                // Cek apakah kognitif1 atau kognitif2 bernilai 1, jika ya maka 'Terdapat Penurunan Kognitif'
                'keterangan_kognitif' => $item->kognitif1 === 1 || $item->kognitif2 === 1 
                    ? 'Terdapat Penurunan Kemampuan Kognitif' 
                    : 'Kemampuan Kognitif Baik',
            ];
        });

        $MobilisasiData = $data->map(function ($item) {
            return [
                'tanggal' => Carbon::parse($item->created_at)->format('d-m-Y'),
                // Cek apakah kognitif1 atau kognitif2 bernilai 1, jika ya maka 'Terdapat Penurunan Kognitif'
                'keterangan_mobilisasi' => $item->mobilisasi === 1
                    ? 'Terdapat Penurunan Kemampuan mobilisasi' 
                    : 'Kemampuan mobilisasi Baik',
            ];
        });

        $MalnutrisiData = $data->map(function ($item) {
            return [
                'tanggal' => Carbon::parse($item->created_at)->format('d-m-Y'),
                'keterangan_malnutrisi' => $item->malnutrisi1 === 1 || $item->malnutrisi2 === 1 || $item->malnutrisi3 === 1
                    ? 'Terdapat indikasi' 
                    : 'Tidak ada indikasi malnutrisi',
            ];
        });

        $LihatData = $data->map(function ($item) {
            return [
                'tanggal' => Carbon::parse($item->created_at)->format('d-m-Y'),
                'keterangan_lihat' => $item->lihat1 === 1 || $item->lihat2 === 1
                    ? 'Terdapat penurunan penglihatan' 
                    : 'Penglihatan baik',
            ];
        });

        $DengarData = $data->map(function ($item) {
            return [
                'tanggal' => Carbon::parse($item->created_at)->format('d-m-Y'),
                'keterangan_dengar' => $item->dengar === 1
                    ? 'Terdapat penurunan pendengaran' 
                    : 'Pendengaran baik',
            ];
        });

        $DepresiData = $data->map(function ($item) {
            return [
                'tanggal' => Carbon::parse($item->created_at)->format('d-m-Y'),
                'keterangan_depresi' => $item->depresi1 === 1 || $item->depresi2 === 1
                    ? 'Terdapat indikasi depresi' 
                    : 'Tidak ada indikasi depresi',
            ];
        });
        

        // Ambil data terbaru untuk tinggi badan dan berat badan
    $latestData = $data->sortByDesc('created_at')->first(); // Ambil data terbaru berdasarkan tanggal
    $latestTinggi = $latestData->tinggi_lansia;
    $latestBerat = $latestData->berat_lansia;

    // Hitung BMI
    $bmi = null;
    $category = null;
    if ($latestBerat && $latestTinggi) {
        $bmi = number_format($latestBerat / (($latestTinggi / 100) ** 2), 2); // BMI = berat / (tinggi^2)
        // Tentukan kategori BMI
        if ($bmi < 18.5) {
            $category = 'Kurus';
        } elseif ($bmi < 24.9) {
            $category = 'Normal';
        } elseif ($bmi < 29.9) {
            $category = 'Overweight';
        } else {
            $category = 'Obesitas';
        }
    }


        return view('admin.datalansia', compact('PesertaPosyanduLansia', 'data', 'DepresiData', 'DengarData', 'LihatData', 'MalnutrisiData', 'MobilisasiData', 'KognitifData', 'GCUData', 'latestTinggi', 'latestBerat', 'bmi', 'category'));
    }

    public function getChartDataByPeserta($peserta_id)
{
    try {
        // Validasi peserta_id
        if (!$peserta_id || !is_numeric($peserta_id)) {
            return response()->json([
                'error' => 'Invalid peserta ID provided'
            ], 400);
        }

        // Cek apakah peserta ada
        $peserta = PesertaPosyanduLansia::find($peserta_id);
        if (!$peserta) {
            return response()->json([
                'error' => 'Peserta not found'
            ], 404);
        }

        // Ambil data kesehatan peserta dan urutkan berdasarkan created_at (bulan-tahun)
        $data = DataKesehatanLansia::where('peserta_id', $peserta_id)
            ->orderBy('created_at')
            ->get();

        if ($data->isEmpty()) {
            return response()->json([
                'error' => 'No health data found for this peserta'
            ], 404);
        }

        // Buat rentang bulan penuh berdasarkan data
        $startDate = Carbon::parse($data->first()->created_at)->startOfMonth();
        $endDate = Carbon::parse($data->last()->created_at)->startOfMonth();
        $monthsRange = [];

        while ($startDate <= $endDate) {
            $monthsRange[] = $startDate->format('m-Y');
            $startDate->addMonth();
        }

        // Proses data dengan interpolasi
        $processedData = [];
        foreach ($monthsRange as $monthYear) {
            $monthData = $data->firstWhere(fn($item) => Carbon::parse($item->created_at)->format('m-Y') === $monthYear);

            $growthData = [
                'month_year' => $monthYear,
                'tinggi_lansia' => $monthData ? (float) $monthData->tinggi_lansia : null,
                'berat_lansia' => $monthData ? (float) $monthData->berat_lansia : null,
                'lingkar_lengan_lansia' => $monthData ? (float) $monthData->lingkar_lengan_lansia : null,
                'lingkar_perut_lansia' => $monthData ? (float) $monthData->lingkar_perut_lansia : null,
            ];

            // Interpolasi untuk data null
            foreach ($growthData as $key => $value) {
                if ($key === 'month_year' || !is_null($value)) {
                    continue;
                }

                // Cari nilai sebelumnya dan berikutnya
                $previous = $data->where('created_at', '<', Carbon::createFromFormat('m-Y', $monthYear))->sortByDesc('created_at')->first();
                $next = $data->where('created_at', '>', Carbon::createFromFormat('m-Y', $monthYear))->sortBy('created_at')->first();

                if ($previous && $next) {
                    $x1 = Carbon::parse($previous->created_at)->timestamp;
                    $y1 = $previous->$key;
                    $x2 = Carbon::parse($next->created_at)->timestamp;
                    $y2 = $next->$key;
                    $x = Carbon::createFromFormat('m-Y', $monthYear)->timestamp;

                    // Hitung interpolasi linear
                    $growthData[$key] = $y1 + (($y2 - $y1) / ($x2 - $x1)) * ($x - $x1);
                }
            }

            // Bulatkan hasil
            foreach ($growthData as $key => $value) {
                if ($key !== 'month_year' && !is_null($value)) {
                    $growthData[$key] = round($value, 2);
                }
            }

            $processedData[] = $growthData;
        }

        // Siapkan struktur data untuk chart
        $chartData = [
            'labels' => array_column($processedData, 'month_year'),
            'tinggiBadan' => [
                'label' => 'Tinggi Badan (cm)',
                'data' => array_column($processedData, 'tinggi_lansia'),
            ],
            'beratBadan' => [
                'label' => 'Berat Badan (kg)',
                'data' => array_column($processedData, 'berat_lansia'),
            ],
            'lingkarLengan' => [
                'label' => 'Lingkar Lengan (cm)',
                'data' => array_column($processedData, 'lingkar_lengan_lansia'),
            ],
            'lingkarPerut' => [
                'label' => 'Lingkar Perut (cm)',
                'data' => array_column($processedData, 'lingkar_perut_lansia'),
            ],
        ];

        return response()->json($chartData);
    } catch (\Exception $e) {
        return response()->json([
            'error' => 'An error occurred while processing the chart data'
        ], 500);
    }
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
        // Ambil data peserta berdasarkan peserta_id
        $peserta = PesertaPosyanduLansia::findOrFail($validatedData['peserta_id']);

        // Hitung jumlah bulan antara TanggalLahir_balita dan bulan saat ini
        $tanggalLahir = Carbon::parse($peserta->TanggalLahir_lansia);
        $jumlahBulan = $tanggalLahir->diffInMonths(Carbon::now());

        // Simpan ke tabel datakesehatanbalita dengan bulan_ke
        Datakesehatanlansia::create([
            'jadwal_id' => $validatedData['jadwal_id'],
            'peserta_id' => $validatedData['peserta_id'],
            'bulan_ke' => $jumlahBulan,  // Menyimpan jumlah bulan
        ]);

        // Simpan ke tabel pesertajadwalbalita
        PesertaJadwalLansia::create([
            'jadwal_id' => $validatedData['jadwal_id'],
            'peserta_id' => $validatedData['peserta_id'],
        ]);

        // Trigger event untuk broadcasting
        broadcast(new DaftarHadir($validatedData['peserta_id'], $validatedData['jadwal_id']));

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
        // Hapus dari tabel datakesehatanbalita
        DataKesehatanLansia::where('jadwal_id', $validatedData['jadwal_id'])
            ->where('peserta_id', $validatedData['peserta_id'])
            ->delete();

        // Hapus dari tabel pesertajadwalbalita
        PesertaJadwalLansia::where('jadwal_id', $validatedData['jadwal_id'])
            ->where('peserta_id', $validatedData['peserta_id'])
            ->delete();

            broadcast(new DaftarHadirRemove($validatedData['peserta_id'], $validatedData['jadwal_id']));
        
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

public function getPesertaByJadwal($jadwalId)
{
    // Mengambil data peserta balita berdasarkan jadwal
    $peserta = PesertaPosyanduLansia::with('dataKesehatan')
        ->whereHas('dataKesehatan', function ($query) use ($jadwalId) {
            $query->where('jadwal_id', $jadwalId);
        })->get();

    // Return data peserta dalam bentuk JSON
    return response()->json($peserta);
}

public function showpesertajadwal($viewName)
    {

        
        // Mengambil jadwal_id dari segmen ke-4 URL
        $jadwalId = request()->segment(4);

        $userId = request()->segment(3);

        // Mengambil data peserta balita berdasarkan jadwal
        $peserta = PesertaPosyanduLansia::with('dataKesehatan')
        ->whereHas('dataKesehatan', function ($query) use ($jadwalId) {
            $query->where('jadwal_id', $jadwalId);
        })->get();

        // Kirimkan data jadwal dan peserta ke view yang ditentukan
        return view($viewName, [
            'peserta' => $peserta,
            'jadwalId' => $jadwalId,
            'userId' => $userId,
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

    // Cek apakah lingkar lengan lansia dibawah 21
    if (isset($validated['lingkar_lengan_lansia']) && $validated['lingkar_lengan_lansia'] < 21) {
        // Set nilai malnutrisi3 menjadi true
        $dataKesehatan->malnutrisi3 = true;
    } else {
        // Jika tidak dibawah 21, pastikan malnutrisi3 bernilai false
        $dataKesehatan->malnutrisi3 = false;
    }

    // Simpan perubahan
    $dataKesehatan->save();

    return redirect()->back()->with('success', 'Data kesehatan berhasil diperbarui.');
}

public function updatePenimbangan(Request $request, $id)
{
    $validated = $request->validate([
        'berat_lansia' => 'nullable|numeric|min:0',
        'malnutrisi1' => 'nullable|boolean',  // Validasi checkbox
        'malnutrisi2' => 'nullable|boolean',      // Validasi checkbox
    ]);

    // Ambil data kesehatan lansia berdasarkan ID
    $dataKesehatanLansia = DataKesehatanLansia::findOrFail($id);

    // Update data kesehatan lansia
    $dataKesehatanLansia->berat_lansia = $validated['berat_lansia'];
    $dataKesehatanLansia->malnutrisi1 = $validated['malnutrisi1'] ?? false;
    $dataKesehatanLansia->malnutrisi2 = $validated['malnutrisi2'] ?? false;

    // Simpan perubahan
    $dataKesehatanLansia->save();

    return redirect()->back()->with('success', 'Data kesehatan berhasil diperbarui.');
}


public function updatepemeriksaan(Request $request, $id)
{
    $validated = $request->validate([
        'tensi_lansia' => 'nullable|numeric|min:0',
        'guladarah_lansia' => 'nullable|numeric|min:0',
        'kolesterol_lansia' => 'nullable|numeric|min:0',
        'asamurat_lansia' => 'nullable|numeric|min:0',
        'keluhan_lansia' => 'nullable|string',
        'obat_lansia' => 'nullable|string',
    ]);

    // Ambil data kesehatan berdasarkan ID
    $dataKesehatan = DataKesehatanLansia::findOrFail($id);

    // Update data kesehatan
    
    $dataKesehatan->tensi_lansia = $validated['tensi_lansia'] ?? $dataKesehatan->tensi_lansia;
    $dataKesehatan->guladarah_lansia = $validated['guladarah_lansia'] ?? $dataKesehatan->guladarah_lansia;
    $dataKesehatan->kolesterol_lansia = $validated['kolesterol_lansia'] ?? $dataKesehatan->kolesterol_lansia;
    $dataKesehatan->asamurat_lansia = $validated['asamurat_lansia'] ?? $dataKesehatan->asamurat_lansia;
    $dataKesehatan->keluhan_lansia = $validated['keluhan_lansia'] ?? $dataKesehatan->keluhan_lansia;
    $dataKesehatan->obat_lansia = $validated['obat_lansia'] ?? $dataKesehatan->obat_lansia;



    $dataKesehatan->save();

    return redirect()->back()->with('success', 'Data kesehatan berhasil diperbarui.');
}

public function showpesertajadwalkuisioner($viewName)
    {

        $userId = request()->segment(4);

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
            'userId' => $userId,
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
            'depresi1' => 'nullable|boolean',
            'depresi2' => 'nullable|boolean',
            'jadwalId' => 'required|integer', // Validasi jadwalId
        ]);
    
        // Ambil data kesehatan berdasarkan ID
        $dataKesehatan = DataKesehatanLansia::findOrFail($id);
    
        // Update data kesehatan
        $dataKesehatan->kognitif1 = $validated['kognitif1'] ?? 0;
        $dataKesehatan->kognitif2 = $validated['kognitif2'] ?? 0;
        $dataKesehatan->depresi1 = $validated['depresi1'] ?? 0;
        $dataKesehatan->depresi2 = $validated['depresi2'] ?? 0;
        $dataKesehatan->submitkognitif = true;
    
        $dataKesehatan->save();
    
        return redirect()->route('teskognitif.fiturposyandulansia', [
            'userId' => $request->user()->id, // Ambil dari user autentikasi
            'jadwalId' => $validated['jadwalId'], // Ambil dari input validasi
        ]);

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
    
        return redirect()->route('tesdengar.fiturposyandulansia', [
            'userId' => $request->user()->id, // Ambil dari user autentikasi
            'jadwalId' => $validated['jadwalId'], // Ambil dari input validasi
        ]);

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
    
        return redirect()->route('teslihat.fiturposyandulansia', [
            'userId' => $request->user()->id, // Ambil dari user autentikasi
            'jadwalId' => $validated['jadwalId'], // Ambil dari input validasi
        ]);

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
        $dataKesehatan->mobilisasi = $validated['mobilisasi'] ?? 0;
        $dataKesehatan->submitmobilisasi = true;
    
        $dataKesehatan->save();
    
        return redirect()->route('tesmobilisasi.fiturposyandulansia', [
            'userId' => $request->user()->id, // Ambil dari user autentikasi
            'jadwalId' => $validated['jadwalId'], // Ambil dari input validasi
        ]);

    }
    


    
}