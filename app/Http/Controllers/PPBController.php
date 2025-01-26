<?php

namespace App\Http\Controllers;

use App\Events\DaftarHadirBalita;
use App\Events\DaftarHadirBalitaRemove;
use App\Models\PesertaPosyanduBalita;
use App\Models\DataKesehatanBalita;
use App\Models\PesertaJadwalBalita; // Tambahkan ini
use App\Models\User; // Tambahkan ini
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

    public function register(Request $request)
{
    // Validasi input
    $request->validate([
        'nama_peserta_balita' => 'required|max:255',
            'TempatLahir_balita' => 'required|max:255',
            'TanggalLahir_balita' => 'required|date',
            'NIK_balita' => 'required|max:255',
            'nama_orangtua_balita' => 'required|max:255',
            'NIK_orangtua_balita' => 'required|max:255',
            'alamat_balita' => 'required|max:255',
            'wa_balita' => 'required|max:255',
    ]);

    // Buat record baru di tabel user
    $user = User::create([
        'name' => $request->nama_peserta_balita,
        'id_user' => $request->NIK_balita,
        'password' => bcrypt($request->NIK_balita),
        'role' => 'pesertabalita',
    ]);
    
    // Reload user dari database untuk memastikan ID-nya tersedia
    $user = User::find($user->id);
    

    // Buat record baru di tabel pesertaposyandubalita
    PesertaPosyanduBalita::create([
        'nama_peserta_balita' => $request->nama_peserta_balita,
        'NIK_balita' => $request->NIK_balita,
        'TempatLahir_balita' => $request->TempatLahir_balita,
        'TanggalLahir_balita' => $request->TanggalLahir_balita,
        'user_id' => $user->id, // Pastikan ID user diambil dari instansi User
        'nama_orangtua_balita' => $request->nama_orangtua_balita,
        'NIK_orangtua_balita' => $request->NIK_orangtua_balita,
        'alamat_balita' => $request->alamat_balita,
        'wa_balita' => $request->wa_balita,
    ]);


    return redirect()->back()->with('success', 'Peserta berhasil ditambahkan.');
}


    // Mengupdate data peserta balita
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_peserta_balita' => 'nullable|max:255',
            'TempatLahir_balita' => 'nullable|max:255',
            'TanggalLahir_balita' => 'nullable|date',
            'NIK_balita' => 'nullable|max:255',
            'nama_orangtua_balita' => 'nullable|max:255',
            'NIK_orangtua_balita' => 'nullable|max:255',
            'alamat_balita' => 'nullable|max:255',
            'wa_balita' => 'nullable|max:255',
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

    // Mengambil data kesehatan secara keseluruhan
    $data = DB::table('DataKesehatanBalita')
        ->where('peserta_id', $id)
        ->select('created_at', 'obat_cacing', 'susu', 'imunisasi', 'bulan_ke', 'tinggi_balita', 'berat_balita', 'lingkar_kepala_balita')
        ->get();

    // Mengambil data tertinggi dan terbaru untuk tinggi badan dan berat badan
    $latestData = DB::table('DataKesehatanBalita')
        ->where('peserta_id', $id)
        ->orderBy('created_at', 'desc')
        ->first(['tinggi_balita', 'berat_balita']);

    // Filter dan map untuk obat cacing
    $obatCacingData = $data->filter(function ($item) {
        return $item->obat_cacing === 'iya'; // Memastikan hanya data yang 'iya' yang diteruskan
    })->map(function ($item) {
        return [
            'tanggal' => Carbon::parse($item->created_at)->format('d-m-Y'),
            'keterangan_obat_cacing' => $item->obat_cacing === 'iya' ? 'Sudah Diberikan' : 'Belum Diberikan',
        ];
    });

    // Filter dan map untuk susu
    $susuData = $data->filter(function ($item) {
        return $item->susu === 'iya'; // Memastikan hanya data yang 'iya' yang diteruskan
    })->map(function ($item) {
        return [
            'tanggal' => Carbon::parse($item->created_at)->format('d-m-Y'),
            'keterangan_susu' => 'Sudah Diberikan', // Karena hanya yang 'iya' yang dikirim
        ];
    });
    
    // Filter dan map untuk imunisasi
    $imunisasiData = $data->filter(function ($item) {
        return !is_null($item->imunisasi);
    })->map(function ($item) {
        return [
            'tanggal' => Carbon::parse($item->created_at)->format('d-m-Y'),
            'jenis_imunisasi' => $item->imunisasi,
        ];
    });

    // Ambil data terbaru untuk tinggi badan dan berat badan
    $latestData = $data->sortByDesc('created_at')->first(); // Ambil data terbaru berdasarkan tanggal
    $latestTinggi = $latestData->tinggi_balita;
    $latestBerat = $latestData->berat_balita;

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

    return view('admin.databalita', compact('PesertaPosyanduBalita', 'obatCacingData', 'susuData', 'imunisasiData', 'data', 'latestTinggi', 'latestBerat', 'bmi', 'category'));
}


    public function getChartDataByPeserta($peserta_id)
{
    try {
        // Validate peserta_id
        if (!$peserta_id || !is_numeric($peserta_id)) {
            return response()->json([
                'error' => 'Invalid peserta ID provided'
            ], 400);
        }

        // Check if peserta exists
        $peserta = PesertaPosyanduBalita::find($peserta_id);
        if (!$peserta) {
            return response()->json([
                'error' => 'Peserta not found'
            ], 404);
        }

        // Get health data ordered by month
        $data = DataKesehatanBalita::where('peserta_id', $peserta_id)
            ->orderBy('bulan_ke')
            ->get();

        // If no data found
        if ($data->isEmpty()) {
            return response()->json([
                'error' => 'No health data found for this peserta'
            ], 404);
        }

        // Process and normalize the data using a loop
        $monthsRange = range(1, $data->max('bulan_ke'));
        $processedData = [];

        for ($i = 1; $i <= count($monthsRange); $i++) {
            $monthData = $data->firstWhere('bulan_ke', $i);
            $growthData = [
                'tinggi_balita' => $monthData ? (float) $monthData->tinggi_balita : null,
                'berat_balita' => $monthData ? (float) $monthData->berat_balita : null,
                'lingkar_kepala_balita' => $monthData ? (float) $monthData->lingkar_kepala_balita : null,
            ];

            foreach ($growthData as $key => $value) {
                if (is_null($value)) {
                    // Cari nilai sebelumnya
                    $previous = $data->where('bulan_ke', '<', $i)->sortByDesc('bulan_ke')->first();
                    $next = $data->where('bulan_ke', '>', $i)->sortBy('bulan_ke')->first();

                    if ($previous && $next) {
                        $x1 = $previous->bulan_ke;
                        $y1 = $previous->$key;
                        $x2 = $next->bulan_ke;
                        $y2 = $next->$key;

                        // Hitung nilai dengan persamaan garis lurus
                        $growthData[$key] = $y1 + (($y2 - $y1) / ($x2 - $x1)) * ($i - $x1);
                    }
                }

                // Bulatkan nilai float ke dua angka di belakang koma
                $growthData[$key] = isset($growthData[$key]) ? round($growthData[$key], 2) : null;
            }

            $processedData[] = $growthData;
        }

        // Prepare chart data structure
        $chartData = [
            'tinggiBadan' => [
                'label' => 'Tinggi Badan (cm)',
                'data' => array_map(fn($value) => round($value, 2), array_column($processedData, 'tinggi_balita')),
                'min' => round($data->min('tinggi_balita'), 2),
                'max' => round($data->max('tinggi_balita'), 2),
            ],
            'beratBadan' => [
                'label' => 'Berat Badan (kg)',
                'data' => array_map(fn($value) => round($value, 2), array_column($processedData, 'berat_balita')),
                'min' => round($data->min('berat_balita'), 2),
                'max' => round($data->max('berat_balita'), 2),
            ],
            'lingkarKepala' => [
                'label' => 'Lingkar Kepala (cm)',
                'data' => array_map(fn($value) => round($value, 2), array_column($processedData, 'lingkar_kepala_balita')),
                'min' => round($data->min('lingkar_kepala_balita'), 2),
                'max' => round($data->max('lingkar_kepala_balita'), 2),
            ],
            'metadata' => [
                'totalMonths' => count($monthsRange),
                'lastUpdated' => $data->max('updated_at'),
            ]
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
        $peserta = PesertaPosyanduBalita::select('id', 'nama_peserta_balita')->get();

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
            $peserta = PesertaPosyanduBalita::findOrFail($validatedData['peserta_id']);
    
            // Hitung jumlah bulan antara TanggalLahir_balita dan bulan saat ini
            $tanggalLahir = Carbon::parse($peserta->TanggalLahir_balita);
            $jumlahBulan = $tanggalLahir->diffInMonths(Carbon::now());
    
            // Simpan ke tabel datakesehatanbalita dengan bulan_ke
            Datakesehatanbalita::create([
                'jadwal_id' => $validatedData['jadwal_id'],
                'peserta_id' => $validatedData['peserta_id'],
                'bulan_ke' => $jumlahBulan,  // Menyimpan jumlah bulan
            ]);
    
            // Simpan ke tabel pesertajadwalbalita
            PesertaJadwalBalita::create([
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
            // Hapus dari tabel datakesehatanbalita
            Datakesehatanbalita::where('jadwal_id', $validatedData['jadwal_id'])
                ->where('peserta_id', $validatedData['peserta_id'])
                ->delete();

            // Hapus dari tabel pesertajadwalbalita
            PesertaJadwalBalita::where('jadwal_id', $validatedData['jadwal_id'])
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

        $userId = request()->segment(3);

        // Mengambil data peserta balita berdasarkan jadwal
        $peserta = PesertaPosyanduBalita::with('dataKesehatan')
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
        return $this->showpesertajadwal('petugas.posyandubalita.fitur_pendaftaran');
    }

    public function pengukuran()
    {
        return $this->showpesertajadwal('petugas.posyandubalita.fitur_pengukuran');
    }

    public function penimbangan()
    {
        return $this->showpesertajadwal('petugas.posyandubalita.fitur_penimbangan');
    }

    public function susu()
    {
        return $this->showpesertajadwal('petugas.posyandubalita.fitur_susu');
    }

    public function obatcacing()
    {
        return $this->showpesertajadwal('petugas.posyandubalita.fitur_obatcacing');
    }

    public function imunisasi()
    {
        return $this->showpesertajadwal('petugas.posyandubalita.fitur_imunisasi');
    }

    public function getPesertaByJadwal($jadwalId)
{
    // Mengambil data peserta balita berdasarkan jadwal
    $peserta = PesertaPosyanduBalita::with('dataKesehatan')
        ->whereHas('dataKesehatan', function ($query) use ($jadwalId) {
            $query->where('jadwal_id', $jadwalId);
        })->get();

    // Return data peserta dalam bentuk JSON
    return response()->json($peserta);
}


    public function updatepengukuran(Request $request, $id)
{
    $validated = $request->validate([
        'tinggi_balita' => 'nullable|numeric|min:0',
        'lingkar_kepala_balita' => 'nullable|numeric|min:0',
    ]);

    // Ambil data kesehatan berdasarkan ID
    $dataKesehatan = DataKesehatanBalita::findOrFail($id);

    // Update data kesehatan
    $dataKesehatan->tinggi_balita = $validated['tinggi_balita'];
    $dataKesehatan->lingkar_kepala_balita = $validated['lingkar_kepala_balita'];

    $dataKesehatan->save();

    return redirect()->back()->with('success', 'Data kesehatan berhasil diperbarui.');
}

public function updatepenimbangan(Request $request, $id)
{
    $validated = $request->validate([
        'berat_balita' => 'nullable|numeric|min:0',
    ]);

    // Ambil data kesehatan berdasarkan ID
    $dataKesehatan = DataKesehatanBalita::findOrFail($id);

    // Update data kesehatan
    $dataKesehatan->berat_balita = $validated['berat_balita'];

    $dataKesehatan->save();

    return redirect()->back()->with('success', 'Data kesehatan berhasil diperbarui.');
}

public function updatesusu(Request $request, $id)
{
    $validated = $request->validate([
        'susu' => 'nullable|in:tidak,iya',
    ]);

    // Ambil data kesehatan berdasarkan ID
    $dataKesehatan = DataKesehatanBalita::findOrFail($id);

    // Update data kesehatan
    $dataKesehatan->susu = $validated['susu'];

    $dataKesehatan->save();

    return redirect()->back()->with('success', 'Data kesehatan berhasil diperbarui.');
}

public function updateobatcacing(Request $request, $id)
{
    $validated = $request->validate([
        'obat_cacing' => 'nullable|in:tidak,iya',
    ]);

    // Ambil data kesehatan berdasarkan ID
    $dataKesehatan = DataKesehatanBalita::findOrFail($id);

    // Update data kesehatan
    $dataKesehatan->obat_cacing = $validated['obat_cacing'];

    $dataKesehatan->save();

    return redirect()->back()->with('success', 'Data kesehatan berhasil diperbarui.');
}

public function updateimunisasi(Request $request, $id)
{
    $validated = $request->validate([
        'imunisasi' => 'nullable|string',
    ]);

    // Ambil data kesehatan berdasarkan ID
    $dataKesehatan = DataKesehatanBalita::findOrFail($id);

    // Update data kesehatan
    $dataKesehatan->imunisasi = $validated['imunisasi'];

    $dataKesehatan->save();

    return redirect()->back()->with('success', 'Data kesehatan berhasil diperbarui.');
}


    

    
}
