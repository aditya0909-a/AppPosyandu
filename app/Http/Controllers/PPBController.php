<?php

namespace App\Http\Controllers;

use App\Models\PesertaPosyanduBalita;
use App\Models\DataKesehatanBalita;
use App\Models\PesertaJadwalBalita; // Tambahkan ini
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

        return redirect()->back()->with('success', 'Peserta berhasil ditambahkan.');
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
            ->select('created_at', 'obat_cacing', 'susu', 'imunisasi', 'vitamin', 'bulan_ke', 'tinggi_balita', 'berat_balita', 'lingkar_kepala_balita')
            ->get();

        $obatCacingData = $data->filter(function ($item) {
            return $item->obat_cacing === 'iya'; // Memastikan hanya data yang 'iya' yang diteruskan
        })->map(function ($item) {
            return [
                'tanggal' => Carbon::parse($item->created_at)->format('d-m-Y'),
                'keterangan_obat_cacing' => $item->obat_cacing === 'iya' ? 'Sudah Diberikan' : 'Belum Diberikan',
            ];
        });

        $vitaminData = $data->filter(function ($item) {
            return $item->vitamin === 'iya'; // Memastikan hanya data yang 'iya' yang diteruskan
        })->map(function ($item) {
            return [
                'tanggal' => Carbon::parse($item->created_at)->format('d-m-Y'),
                'keterangan_vitamin' => $item->vitamin === 'iya' ? 'Sudah Diberikan' : 'Belum Diberikan',
            ];
        });

        $susuData = $data->filter(function ($item) {
            return $item->susu === 'iya'; // Memastikan hanya data yang 'iya' yang diteruskan
        })->map(function ($item) {
            return [
                'tanggal' => Carbon::parse($item->created_at)->format('d-m-Y'),
                'keterangan_susu' => 'Sudah Diberikan', // Karena hanya yang 'iya' yang dikirim
            ];
        });
        

        $imunisasiData = $data->filter(function ($item) {
            return !is_null($item->imunisasi);
        })->map(function ($item) {
            return [
                'tanggal' => Carbon::parse($item->created_at)->format('d-m-Y'),
                'jenis_imunisasi' => $item->imunisasi,
            ];
        });
        
        return view('admin.databalita', compact('PesertaPosyanduBalita', 'obatCacingData', 'susuData', 'vitaminData', 'imunisasiData', 'data'));
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

            // Process and normalize the data
            $monthsRange = range(1, $data->max('bulan_ke'));

            $processedData = collect($monthsRange)->map(function ($month) use ($data) {
                $monthData = $data->firstWhere('bulan_ke', $month);
                return [
                    'tinggi_balita' => $monthData ? (float) $monthData->tinggi_balita : null,
                    'berat_balita' => $monthData ? (float) $monthData->berat_balita : null,
                    'lingkar_kepala_balita' => $monthData ? (float) $monthData->lingkar_kepala_balita : null,
                ];
            });

            // Prepare chart data structure
            $chartData = [
                'tinggiBadan' => [
                    'label' => 'Tinggi Badan (cm)',
                    'data' => $processedData->pluck('tinggi_balita')->values()->all(),
                    'min' => $data->min('tinggi_balita'),
                    'max' => $data->max('tinggi_balita'),
                ],
                'beratBadan' => [
                    'label' => 'Berat Badan (kg)',
                    'data' => $processedData->pluck('berat_balita')->values()->all(),
                    'min' => $data->min('berat_balita'),
                    'max' => $data->max('berat_balita'),
                ],
                'lingkarKepala' => [
                    'label' => 'Lingkar Kepala (cm)',
                    'data' => $processedData->pluck('lingkar_kepala_balita')->values()->all(),
                    'min' => $data->min('lingkar_kepala_balita'),
                    'max' => $data->max('lingkar_kepala_balita'),
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
            // Simpan ke tabel datakesehatanbalita
            Datakesehatanbalita::create([
                'jadwal_id' => $validatedData['jadwal_id'],
                'peserta_id' => $validatedData['peserta_id'],
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

        // Mengambil data peserta balita berdasarkan jadwal
        $peserta = PesertaPosyanduBalita::with('dataKesehatan')
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

    public function vitamin()
    {
        return $this->showpesertajadwal('petugas.posyandubalita.fitur_vitamin');
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

    // Kembalikan data dalam format JSON
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

public function updatevitamin(Request $request, $id)
{
    $validated = $request->validate([
        'vitamin' => 'nullable|in:tidak,iya',
    ]);

    // Ambil data kesehatan berdasarkan ID
    $dataKesehatan = DataKesehatanBalita::findOrFail($id);

    // Update data kesehatan
    $dataKesehatan->vitamin = $validated['vitamin'];

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
