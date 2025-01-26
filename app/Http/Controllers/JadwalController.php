<?php

namespace App\Http\Controllers;
use App\Models\PesertaPosyanduBalita;
use App\Models\PesertaPosyanduLansia;
use App\Models\Jadwal; // Tambahkan ini
use Illuminate\Http\Request;
use Carbon\Carbon;
Carbon::setLocale('id');
use Illuminate\Support\Facades\Log;



class JadwalController extends Controller
{
    
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
            'teskognitif',
            'tesdengar',
            'teslihat',
            'tesmobilisasi',
            'pemeriksaan'
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
                'teskognitif' => $jadwal->teskognitif,
                'tesdengar' => $jadwal->tesdengar,
                'teslihat' => $jadwal->teslihat,
                'tesmobilisasi' => $jadwal->tesmobilisasi,
                'pemeriksaan' => $jadwal->pemeriksaan,
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
            'date' => 'required|date',
            'imunisasi' => 'nullable|boolean',
            'obatcacing' => 'nullable|boolean',
            'susu' => 'nullable|boolean',
            'pemeriksaan' => 'nullable|boolean',
            'teskognitif' => 'nullable|boolean',
            'tesdengar' => 'nullable|boolean',
            'teslihat' => 'nullable|boolean',
            'tesmobilisasi' => 'nullable|boolean',
        ], [
            'name.required' => 'Nama jadwal harus diisi.',
            'name.string' => 'Nama jadwal harus berupa teks.',
            'name.max' => 'Nama jadwal tidak boleh lebih dari 255 karakter.',
            'location.required' => 'Lokasi harus diisi.',
            'location.string' => 'Lokasi harus berupa teks.',
            'location.max' => 'Lokasi tidak boleh lebih dari 255 karakter.',
            'date.required' => 'Tanggal harus diisi.',
            'date.date' => 'Tanggal harus berupa format tanggal yang valid.',
            'date.after' => 'Tanggal harus lebih dari hari ini.',
            'imunisasi.boolean' => 'Imunisasi harus berupa pilihan ya atau tidak.',
            'obatcacing.boolean' => 'Obat cacing harus berupa pilihan ya atau tidak.',
            'susu.boolean' => 'Susu harus berupa pilihan ya atau tidak.',
            'pemeriksaan.boolean' => 'pemeriksaan harus berupa pilihan ya atau tidak.',
            'teskognitif.boolean' => 'Tes kognitif harus berupa pilihan ya atau tidak.',
            'tesdengar.boolean' => 'Tes dengar harus berupa pilihan ya atau tidak.',
            'teslihat.boolean' => 'Tes lihat harus berupa pilihan ya atau tidak.',
            'tesmobilisasi.boolean' => 'Tes mobilisasi harus berupa pilihan ya atau tidak.',
        ]);

        Jadwal::create($validatedData);


        return redirect()->back()->with('success', 'Jadwal berhasil ditambahkan');
    }


    public function update(Request $request, $id)
{
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'location' => 'required|string|max:255',
        'date' => 'required|date',
        'imunisasi' => 'nullable|boolean',
        'obatcacing' => 'nullable|boolean',
        'susu' => 'nullable|boolean',
        'pemeriksaan' => 'nullable|boolean',
        'teskognitif' => 'nullable|boolean',
        'tesdengar' => 'nullable|boolean',
        'teslihat' => 'nullable|boolean',
        'tesmobilisasi' => 'nullable|boolean',
    ]);

    $jadwal = Jadwal::find($id);
    
    if (!$jadwal) {
        Log::error("Jadwal dengan ID {$id} tidak ditemukan.");
        return redirect()->back()->with('error', 'Jadwal tidak ditemukan.');
    }

    // Update data
    $isUpdated = $jadwal->update($validatedData);

    if (!$isUpdated) {
        Log::error("Gagal mengupdate jadwal dengan ID {$id}. Data yang diterima: " . json_encode($validatedData));
        return redirect()->back()->with('error', 'Gagal mengupdate jadwal.');
    }

    Log::info("Jadwal dengan ID {$id} berhasil diubah.");
    return redirect()->back()->with('success', 'Jadwal berhasil diubah.');
}

    

    public function jadwalbalita($id)
    {
        // Mengambil data jadwal berdasarkan ID
        $jadwal = Jadwal::findOrFail($id);

        // Format tanggal
        $jadwal->formatted_date = $jadwal->date 
            ? Carbon::parse($jadwal->date)->isoFormat('dddd, D MMMM YYYY') 
            : null;
        $jadwal->imunisasi_status = $jadwal->imunisasi ? 'Imunisasi' : null;
        $jadwal->obatcacing_status = $jadwal->obatcacing ? 'pemberian obat cacing' : null;
        $jadwal->susu_status = $jadwal->susu ? 'pemberian susu' : null;

        // Mengambil data peserta balita berdasarkan jadwal
        $pesertaBalita = PesertaPosyanduBalita::whereHas('dataKesehatan', function ($query) use ($id) {
            $query->where('jadwal_id', $id);
        })->get();

        // Kirimkan data jadwal dan peserta ke view
        return view('admin.jadwalbalita', [
            'jadwal' => $jadwal,
            'pesertaBalita' => $pesertaBalita,
        ]);
    }

    public function jadwallansia($id)
{
    // Mengambil data jadwal berdasarkan ID
    $jadwal = Jadwal::findOrFail($id);

    // Format tanggal
    $jadwal->formatted_date = $jadwal->date 
        ? Carbon::parse($jadwal->date)->isoFormat('dddd, D MMMM YYYY') 
        : null;
    $jadwal->pemeriksaan_status = $jadwal->pemeriksaan ? 'pemeriksaan kesehatan lansia' : null;
    $jadwal->teskognitif_status = $jadwal->teskognitif ? 'tes kognitif lansia' : null;
    $jadwal->teslihat_status = $jadwal->teslihat ? 'tes lihat lansia' : null;
    $jadwal->tesdengar_status = $jadwal->tesdengar ? 'tes kognitif lansia' : null;

    // Mengambil data peserta lansia berdasarkan jadwal
    $pesertaLansia = PesertaPosyanduLansia::whereHas('dataKesehatan', function ($query) use ($id) {
        $query->where('jadwal_id', $id);
    })->get();

    // Kirimkan data jadwal dan peserta ke view
    return view('admin.jadwallansia', [
        'jadwal' => $jadwal,
        'pesertaLansia' => $pesertaLansia,
    ]);
}

    public function getViewAdmin($userId)
    {
        try {
            Carbon::setLocale('id');
            // Ambil semua data jadwal dari database
            $jadwals = Jadwal::all()->map(function ($jadwal) {
                return [
                    'id' => $jadwal->id,
                    'name' => $jadwal->name,
                    'date' => $jadwal->date,
                    'formatted_date' => Carbon::parse($jadwal->date)->translatedFormat('d F Y'),
                    'location' => $jadwal->location,
                    'imunisasi' => $jadwal->imunisasi,
                    'obatcacing' => $jadwal->obatcacing,
                    'susu' => $jadwal->susu,
                    'teskognitif' => $jadwal->teskognitif,
                    'tesdengar' => $jadwal->tesdengar,
                    'teslihat' => $jadwal->teslihat,
                    'tesmobilisasi' => $jadwal->tesmobilisasi,
                    'pemeriksaan' => $jadwal->pemeriksaan,
                ];
            });

            // Kirim data jadwal ke view 'admin.fitur_penjadwalan', bersama userId
            return view('admin.fitur_penjadwalan', [
                'Jadwals' => $jadwals,
                'userId' => $userId
            ]);
        } catch (\Exception $e) {
            // Redirect jika terjadi error
            return redirect()->back()->with('error', 'Gagal mengambil data jadwal. Silakan coba lagi.');
        }
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

    public function getViewPetugas($userId)
    {
        try {
            Carbon::setLocale('id');
            // Ambil semua data jadwal dari database
            $jadwals = Jadwal::all()->map(function ($jadwal) {
                return [
                    'id' => $jadwal->id,
                    'name' => $jadwal->name,
                    'date' => $jadwal->date,
                    'formatted_date' => Carbon::parse($jadwal->date)->translatedFormat('d F Y'),
                    'location' => $jadwal->location,
                    'imunisasi' => $jadwal->imunisasi,
                    'obatcacing' => $jadwal->obatcacing,
                    'susu' => $jadwal->susu,
                    'teskognitif' => $jadwal->teskognitif,
                    'tesdengar' => $jadwal->tesdengar,
                    'teslihat' => $jadwal->teslihat,
                    'tesmobilisasi' => $jadwal->tesmobilisasi,
                    'pemeriksaan' => $jadwal->pemeriksaan,
                ];
            });

            // Kirim data jadwal ke view 'admin.fitur_penjadwalan', bersama userId
            return view('petugas.fitur_jadwal', [
                'Jadwals' => $jadwals,
                'userId' => $userId
            ]);
        } catch (\Exception $e) {
            // Redirect jika terjadi error
            return redirect()->back()->with('error', 'Gagal mengambil data jadwal. Silakan coba lagi.');
        }
    }

    public function getViewPesertaBalita($userId)
    {
        try {
            Carbon::setLocale('id');
            // Ambil semua data jadwal dari database
            $jadwals = Jadwal::all()->map(function ($jadwal) {
                return [
                    'id' => $jadwal->id,
                    'name' => $jadwal->name,
                    'date' => $jadwal->date,
                    'formatted_date' => Carbon::parse($jadwal->date)->translatedFormat('d F Y'),
                    'location' => $jadwal->location,
                    'imunisasi' => $jadwal->imunisasi,
                    'obatcacing' => $jadwal->obatcacing,
                    'susu' => $jadwal->susu,
                    'teskognitif' => $jadwal->teskognitif,
                    'tesdengar' => $jadwal->tesdengar,
                    'teslihat' => $jadwal->teslihat,
                    'tesmobilisasi' => $jadwal->tesmobilisasi,
                    'pemeriksaan' => $jadwal->pemeriksaan,
                ];
            });

            // Kirim data jadwal ke view 'admin.fitur_penjadwalan', bersama userId
            return view('pesertabalita.fitur_jadwal', [
                'Jadwals' => $jadwals,
                'userId' => $userId
            ]);
        } catch (\Exception $e) {
            // Redirect jika terjadi error
            return redirect()->back()->with('error', 'Gagal mengambil data jadwal. Silakan coba lagi.');
        }
    }

    public function getViewPesertaLansia($userId)
    {
        try {
            Carbon::setLocale('id');
            // Ambil semua data jadwal dari database
            $jadwals = Jadwal::all()->map(function ($jadwal) {
                return [
                    'id' => $jadwal->id,
                    'name' => $jadwal->name,
                    'date' => $jadwal->date,
                    'formatted_date' => Carbon::parse($jadwal->date)->translatedFormat('d F Y'),
                    'location' => $jadwal->location,
                    'imunisasi' => $jadwal->imunisasi,
                    'obatcacing' => $jadwal->obatcacing,
                    'susu' => $jadwal->susu,
                    'teskognitif' => $jadwal->teskognitif,
                    'tesdengar' => $jadwal->tesdengar,
                    'teslihat' => $jadwal->teslihat,
                    'tesmobilisasi' => $jadwal->tesmobilisasi,
                    'pemeriksaan' => $jadwal->pemeriksaan,
                ];
            });

            // Kirim data jadwal ke view 'admin.fitur_penjadwalan', bersama userId
            return view('pesertalansia.fitur_jadwal', [
                'Jadwals' => $jadwals,
                'userId' => $userId
            ]);
        } catch (\Exception $e) {
            // Redirect jika terjadi error
            return redirect()->back()->with('error', 'Gagal mengambil data jadwal. Silakan coba lagi.');
        }
    }


    
}
