<?php

namespace App\Http\Controllers;
use App\Models\PesertaPosyanduBalita;
use App\Models\PesertaPosyanduLansia;
use App\Models\Jadwal; // Tambahkan ini
use Illuminate\Http\Request;
use Carbon\Carbon;
Carbon::setLocale('id');


class JadwalController extends Controller
{
    
    public function index()
    {
        $jadwals = Jadwal::latest('date')->get()->map(function ($jadwal) {
            return [
                'id' => $jadwal->id,
                'name' => $jadwal->name,
                'date' => $jadwal->date,
                'location' => $jadwal->location,
                'formatted_date' => $jadwal->date ? Carbon::parse($jadwal->date)->isoFormat('dddd, D MMMM YYYY') : null,
                'imunisasi' => $jadwal->imunisasi,       // Menambahkan properti boolean
                'obatcacing' => $jadwal->obatcacing,    // Menambahkan properti boolean
                'susu' => $jadwal->susu,                // Menambahkan properti boolean
                'teskognitif' => $jadwal->teskognitif,  // Menambahkan properti boolean
                'tesdengar' => $jadwal->tesdengar,      // Menambahkan properti boolean
                'teslihat' => $jadwal->teslihat,        // Menambahkan properti boolean
                'tesmobilisasi' => $jadwal->tesmobilisasi, // Menambahkan properti boolean
                'pemeriksaan' => $jadwal->pemeriksaan,          // Menambahkan properti boolean
            ];
        });


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
            'vitamin',
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
                'vitamin' => $jadwal->vitamin,
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
            'date' => 'required|date|after:today',
            'imunisasi' => 'nullable|boolean',
            'obatcacing' => 'nullable|boolean',
            'susu' => 'nullable|boolean',
            'vitamin' => 'nullable|boolean',
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
            'vitamin.boolean' => 'Vitamin harus berupa pilihan ya atau tidak.',
            'pemeriksaan.boolean' => 'pemeriksaan harus berupa pilihan ya atau tidak.',
            'teskognitif.boolean' => 'Tes kognitif harus berupa pilihan ya atau tidak.',
            'tesdengar.boolean' => 'Tes dengar harus berupa pilihan ya atau tidak.',
            'teslihat.boolean' => 'Tes lihat harus berupa pilihan ya atau tidak.',
            'tesmobilisasi.boolean' => 'Tes mobilisasi harus berupa pilihan ya atau tidak.',
        ]);

        Jadwal::create($validatedData);


        return redirect('/fiturpenjadwalan/admin')->with('success', 'Jadwal berhasil ditambahkan');
    }


    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'date' => 'required|date|after:today',
            'imunisasi' => 'nullable|boolean',
            'obatcacing' => 'nullable|boolean',
            'susu' => 'nullable|boolean',
            'vitamin' => 'nullable|boolean',
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
            'vitamin.boolean' => 'Vitamin harus berupa pilihan ya atau tidak.',
            'pemeriksaan.boolean' => 'pemeriksaan harus berupa pilihan ya atau tidak.',
            'teskognitif.boolean' => 'Tes kognitif harus berupa pilihan ya atau tidak.',
            'tesdengar.boolean' => 'Tes dengar harus berupa pilihan ya atau tidak.',
            'teslihat.boolean' => 'Tes lihat harus berupa pilihan ya atau tidak.',
            'tesmobilisasi.boolean' => 'Tes mobilisasi harus berupa pilihan ya atau tidak.',
        ]);

        $jadwal = Jadwal::findOrFail($id);
        $jadwal->update($validatedData);

        return redirect('/fiturpenjadwalan/admin')->with('success', 'Jadwal berhasil diubah.');
    }

    

public function showJadwalWithPeserta($id)
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
    $jadwal->pemeriksaan_status = $jadwal->pemeriksaan ? 'pemeriksaan kesehatan lansia' : null;
    $jadwal->teskognitif_status = $jadwal->teskognitif ? 'tes kognitif lansia' : null;
    $jadwal->teslihat_status = $jadwal->teslihat ? 'tes lihat lansia' : null;
    $jadwal->tesdengar_status = $jadwal->tesdengar ? 'tes kognitif lansia' : null;

    // Mengambil data peserta balita berdasarkan jadwal
    $pesertaBalita = PesertaPosyanduBalita::whereHas('dataKesehatan', function ($query) use ($id) {
        $query->where('jadwal_id', $id);
    })->get();

    // Mengambil data peserta lansia berdasarkan jadwal
    $pesertaLansia = PesertaPosyanduLansia::whereHas('dataKesehatan', function ($query) use ($id) {
        $query->where('jadwal_id', $id);
    })->get();

    // Menggabungkan kedua data peserta (balita dan lansia)
    $peserta = $pesertaBalita->merge($pesertaLansia);

    // Kirimkan data jadwal dan peserta ke view
    return view('admin.jadwal', [
        'jadwal' => $jadwal,
        'peserta' => $peserta,
    ]);
}

    public function jadwalPetugas()
    {
        return $this->getJadwalView('petugas.fitur_jadwal');
    }

    // Menampilkan jadwal untuk peserta balita
    public function jadwalPesertaBalita()
    {
        return $this->getJadwalView('pesertabalita.fitur_jadwal');
    }

    // Menampilkan jadwal untuk peserta lansia
    public function jadwalPesertaLansia()
    {
        return $this->getJadwalView('pesertalansia.fitur_jadwal');
    }

    // Fungsi untuk mengambil jadwal dan mengirimkannya ke view
    private function getJadwalView($viewName)
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
                ];
            });

            // Kirim data jadwal ke view yang sesuai
            return view($viewName, ['Jadwals' => $jadwals]);
        } catch (\Exception $e) {
            // Redirect jika terjadi error
            return redirect()->back()->with('error', 'Gagal mengambil data jadwal. Silakan coba lagi.');
        }
    }
    
}
