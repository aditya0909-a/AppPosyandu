<?php

namespace App\Http\Controllers;

use App\Models\PesertaPosyanduBalita;
use App\Models\PesertaPosyanduLansia;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Jadwal; // Tambahkan ini
use App\Exports\DaftarPesertaBalita;
use App\Exports\DatapengukuranBalita;
use App\Exports\DataImunisasiBalita;
use App\Exports\DataObatcacingBalita;
use App\Exports\DataSusuBalita;
use App\Exports\DaftarPesertaLansia;
use App\Exports\DatapengukuranLansia;
use App\Exports\DataPemeriksaanLansia;
use App\Exports\SKILAS;
use Carbon\Carbon;

class ExportController extends Controller
{
    // Export ke PDF
    public function exportdaftarbalitaPdf($id)
    {

        $jadwal = Jadwal::findOrFail($id);

        $jadwal->formatted_date = $jadwal->date 
        ? Carbon::parse($jadwal->date)->format('d-m-Y')
        : null;
       
        $data = PesertaPosyanduBalita::whereHas('jadwals', function ($query) use ($id) {
            $query->where('jadwal_id', $id);
        })->get();

        $pdf = Pdf::loadView('exports.DaftarPesertaBalita', compact('data', 'jadwal')) // Sesuaikan view
        ->setPaper('a4', 'landscape');
        $fileName = "Daftar Peserta {$jadwal->name} {$jadwal->location} {$jadwal->formatted_date}.pdf";

        return $pdf->download($fileName);
    }

    public function exportdaftarbalitaExcel($id)
    {

        $jadwal = Jadwal::findOrFail($id);

        $jadwal->formatted_date = $jadwal->date 
        ? Carbon::parse($jadwal->date)->format('d-m-Y')
        : null;
    
        $fileName = "Daftar Peserta {$jadwal->name} {$jadwal->location} {$jadwal->formatted_date}.xlsx";
    
        return Excel::download(new DaftarPesertaBalita($id), $fileName);
    }

    public function exportpengukuranbalitaPdf($id)
    {
        $jadwal = Jadwal::findOrFail($id);

        $jadwal->formatted_date = $jadwal->date 
            ? Carbon::parse($jadwal->date)->format('d-m-Y')
            : null;
    
        $data = PesertaPosyanduBalita::whereHas('jadwals', function ($query) use ($id) {
            $query->where('jadwal_id', $id);
        })->with('dataKesehatan') // Menyertakan data kesehatan untuk setiap peserta
        ->get();

        $pdf = Pdf::loadView('exports.PengukuranBalita', compact('data', 'jadwal')) // Sesuaikan view
            ->setPaper('a4', 'landscape');
    
        $fileName = "Data Pengukuran {$jadwal->name} {$jadwal->location} {$jadwal->formatted_date}.pdf";

        return $pdf->download($fileName);
    }

    public function exportpengukuranbalitaExcel($id)
    {

        $jadwal = Jadwal::findOrFail($id);

        $jadwal->formatted_date = $jadwal->date 
        ? Carbon::parse($jadwal->date)->format('d-m-Y')
        : null;
    
        $fileName = "Data Pengukuran {$jadwal->name} {$jadwal->location} {$jadwal->formatted_date}.xlsx";
    
        return Excel::download(new DatapengukuranBalita($id), $fileName);
    }

    public function exportimunisasibalitaPdf($id)
    {
        $jadwal = Jadwal::findOrFail($id);

        $jadwal->formatted_date = $jadwal->date 
            ? Carbon::parse($jadwal->date)->format('d-m-Y')
            : null;
    
        $data = PesertaPosyanduBalita::whereHas('jadwals', function ($query) use ($id) {
            $query->where('jadwal_id', $id);
        })->with('dataKesehatan') // Menyertakan data kesehatan untuk setiap peserta
        ->get();

        $pdf = Pdf::loadView('exports.ImunisasiBalita', compact('data', 'jadwal')) // Sesuaikan view
            ->setPaper('a4', 'potrait');
    
        $fileName = "Data Imunisasi {$jadwal->name} {$jadwal->location} {$jadwal->formatted_date}.pdf";

        return $pdf->download($fileName);
    }

    public function exportimunisasibalitaExcel($id)
    {

        $jadwal = Jadwal::findOrFail($id);

        $jadwal->formatted_date = $jadwal->date 
        ? Carbon::parse($jadwal->date)->format('d-m-Y')
        : null;
    
        $fileName = "Data Imunisasi {$jadwal->name} {$jadwal->location} {$jadwal->formatted_date}.xlsx";
    
        return Excel::download(new DataImunisasiBalita($id), $fileName);
    }

    public function exportobatcacingbalitaPdf($id)
    {
        $jadwal = Jadwal::findOrFail($id);

        $jadwal->formatted_date = $jadwal->date 
            ? Carbon::parse($jadwal->date)->format('d-m-Y')
            : null;
    
        $data = PesertaPosyanduBalita::whereHas('jadwals', function ($query) use ($id) {
            $query->where('jadwal_id', $id);
        })->with('dataKesehatan') // Menyertakan data kesehatan untuk setiap peserta
        ->get();

        $pdf = Pdf::loadView('exports.ObatcacingBalita', compact('data', 'jadwal')) // Sesuaikan view
            ->setPaper('a4', 'potrait');
    
        $fileName = "Data Pemberian Obat Cacing {$jadwal->name} {$jadwal->location} {$jadwal->formatted_date}.pdf";

        return $pdf->download($fileName);
    }

    public function exportobatcacingbalitaExcel($id)
    {

        $jadwal = Jadwal::findOrFail($id);

        $jadwal->formatted_date = $jadwal->date 
        ? Carbon::parse($jadwal->date)->format('d-m-Y')
        : null;
    
        $fileName = "Data Pemberian Obat Cacing {$jadwal->name} {$jadwal->location} {$jadwal->formatted_date}.xlsx";
    
        return Excel::download(new DataObatcacingBalita($id), $fileName);
    }

    public function exportsusubalitaPdf($id)
    {

        $jadwal = Jadwal::findOrFail($id);
    
        $jadwal->formatted_date = $jadwal->date 
            ? Carbon::parse($jadwal->date)->format('d-m-Y')
            : null;
       
        $data = PesertaPosyanduBalita::whereHas('jadwals', function ($query) use ($id) {
            $query->where('jadwal_id', $id);
        })->with('dataKesehatan') // Menyertakan data kesehatan untuk setiap peserta
        ->get();
    
        $pdf = Pdf::loadView('exports.SusuBalita', compact('data', 'jadwal')) // Sesuaikan view
            ->setPaper('a4', 'potrait');
    
        $fileName = "Data Pemberian Susu {$jadwal->name} {$jadwal->location} {$jadwal->formatted_date}.pdf";
    
        return $pdf->download($fileName);
    }
    
    public function exportsusubalitaExcel($id)
        {
    
            $jadwal = Jadwal::findOrFail($id);
    

            $jadwal->formatted_date = $jadwal->date 
            ? Carbon::parse($jadwal->date)->format('d-m-Y')
            : null;
        

            $fileName = "Data Pemberian Susu {$jadwal->name} {$jadwal->location} {$jadwal->formatted_date}.xlsx";
        
            return Excel::download(new DataSusuBalita($id), $fileName);
        }

        public function exportdaftarlansiaPdf($id)
    {

        $jadwal = Jadwal::findOrFail($id);

        $jadwal->formatted_date = $jadwal->date 
        ? Carbon::parse($jadwal->date)->format('d-m-Y')
        : null;
       
        $data = PesertaPosyanduLansia::whereHas('jadwals', function ($query) use ($id) {
            $query->where('jadwal_id', $id);
        })->get();

        $pdf = Pdf::loadView('exports.DaftarPesertaLansia', compact('data', 'jadwal')) // Sesuaikan view
        ->setPaper('a4', 'landscape');
        $fileName = "Daftar Peserta {$jadwal->name} {$jadwal->location} {$jadwal->formatted_date}.pdf";

        return $pdf->download($fileName);
    }

    public function exportdaftarlansiaExcel($id)
    {

        $jadwal = Jadwal::findOrFail($id);

        $jadwal->formatted_date = $jadwal->date 
        ? Carbon::parse($jadwal->date)->format('d-m-Y')
        : null;
    
        $fileName = "Daftar Peserta {$jadwal->name} {$jadwal->location} {$jadwal->formatted_date}.xlsx";
    
        return Excel::download(new DaftarPesertaLansia($id), $fileName);
    }

    public function exportpengukuranlansiaPdf($id)
    {

        $jadwal = Jadwal::findOrFail($id);

        $jadwal->formatted_date = $jadwal->date 
        ? Carbon::parse($jadwal->date)->format('d-m-Y')
        : null;
       
        $data = PesertaPosyanduLansia::whereHas('jadwals', function ($query) use ($id) {
            $query->where('jadwal_id', $id);
        })->get();

        $pdf = Pdf::loadView('exports.PengukuranLansia', compact('data', 'jadwal')) // Sesuaikan view
        ->setPaper('a4', 'landscape');
        $fileName = "Data Pengukuran {$jadwal->name} {$jadwal->location} {$jadwal->formatted_date}.pdf";

        return $pdf->download($fileName);
    }

    public function exportpengukuranlansiaExcel($id)
    {

        $jadwal = Jadwal::findOrFail($id);

        $jadwal->formatted_date = $jadwal->date 
        ? Carbon::parse($jadwal->date)->format('d-m-Y')
        : null;
    
        $fileName = "Data Pengukuran {$jadwal->name} {$jadwal->location} {$jadwal->formatted_date}.xlsx";
    
        return Excel::download(new DataPengukuranLansia($id), $fileName);
    }

    public function exportpemeriksaanlansiaPdf($id)
    {

        $jadwal = Jadwal::findOrFail($id);

        $jadwal->formatted_date = $jadwal->date 
        ? Carbon::parse($jadwal->date)->format('d-m-Y')
        : null;
       
        $data = PesertaPosyanduLansia::whereHas('jadwals', function ($query) use ($id) {
            $query->where('jadwal_id', $id);
        })->get();

        $pdf = Pdf::loadView('exports.PemeriksaanLansia', compact('data', 'jadwal')) // Sesuaikan view
        ->setPaper('a4', 'landscape');
        $fileName = "Data Pemeriksaan {$jadwal->name} {$jadwal->location} {$jadwal->formatted_date}.pdf";

        return $pdf->download($fileName);
    }

    public function exportpemeriksaanlansiaExcel($id)
    {

        $jadwal = Jadwal::findOrFail($id);

        $jadwal->formatted_date = $jadwal->date 
        ? Carbon::parse($jadwal->date)->format('d-m-Y')
        : null;
    
        $fileName = "Data Pemeriksaan {$jadwal->name} {$jadwal->location} {$jadwal->formatted_date}.xlsx";
    
        return Excel::download(new DataPemeriksaanLansia($id), $fileName);
    }

    public function exportSKILASPdf($id) 
{
    $jadwal = Jadwal::findOrFail($id);
    $jadwal->formatted_date = $jadwal->date 
        ? Carbon::parse($jadwal->date)->format('d-m-Y')
        : null;
   
    $data = PesertaPosyanduLansia::with('datakesehatan') // Include relasi datakesehatan
        ->whereHas('jadwals', function ($query) use ($id) {
            $query->where('jadwal_id', $id);
        })->get();

    $pdf = Pdf::loadView('exports.SKILAS', compact('data', 'jadwal'))
        ->setPaper('a4', 'landscape'); // Sesuaikan orientasi kertas

    $fileName = "SKILAS {$jadwal->name} {$jadwal->location} {$jadwal->formatted_date}.pdf";

    return $pdf->download($fileName);
}

public function exportSKILASExcel($id)
    {

        $jadwal = Jadwal::findOrFail($id);

        $jadwal->formatted_date = $jadwal->date 
        ? Carbon::parse($jadwal->date)->format('d-m-Y')
        : null;
    
        $fileName = "SKILAS {$jadwal->name} {$jadwal->location} {$jadwal->formatted_date}.xlsx";
    
        return Excel::download(new SKILAS($id), $fileName);
    }


    

    
}
