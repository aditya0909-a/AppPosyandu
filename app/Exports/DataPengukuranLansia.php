<?php

namespace App\Exports;

use App\Models\PesertaPosyanduLansia;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class DataPengukuranLansia implements FromCollection, WithHeadings, WithStyles, WithColumnFormatting, WithEvents
{
    protected $jadwalId;

    public function __construct($jadwalId)
    {
        $this->jadwalId = $jadwalId;
    }

    public function collection()
{
    // Query data peserta posyandu balita berdasarkan jadwal_id
    $data = PesertaPosyanduLansia::whereHas('jadwals', function ($query) {
        $query->where('jadwal_id', $this->jadwalId);
    })
    ->with('dataKesehatan') // Menyertakan data kesehatan untuk setiap peserta
    ->get();

    // Memproses data peserta
    $processedData = $data->map(function ($peserta) {
        // Mengambil data kesehatan pertama untuk peserta ini
        $dataKesehatan = $peserta->dataKesehatan->first(); // Ambil data kesehatan pertama
        
        // Menyusun data yang ingin ditampilkan pada export
        return [
            'nama_peserta_lansia' => $peserta->nama_peserta_lansia,
            'TempatLahir_lansia' => $peserta->TempatLahir_lansia,
            'TanggalLahir_lansia' => $peserta->TanggalLahir_lansia,
            'NIK_lansia' => $peserta->NIK_lansia,
            'tinggi_lansia' => $dataKesehatan ? $dataKesehatan->tinggi_lansia : 'N/A',
            'berat_lansia' => $dataKesehatan ? $dataKesehatan->berat_lansia : 'N/A',
            'lingkar_lengan_lansia' => $dataKesehatan ? $dataKesehatan->lingkar_lengan_lansia : 'N/A',
            'lingkar_perut_lansia' => $dataKesehatan ? $dataKesehatan->lingkar_perut_lansia : 'N/A',
        ];
    });

    // Mengembalikan data yang sudah diproses, atau pesan jika tidak ada data
    return $processedData->isEmpty() 
        ? collect([['Tidak ada data untuk jadwal ini']]) 
        : $processedData;
}


    public function headings(): array
    {
        return [
            'Nama Lansia',
            'Tempat Lahir',
            'Tanggal Lahir',
            'NIK Lansia',
            'Tinggi Lansia (cm)',
            'Berat Lansia (cm)',
            'Lingkar Lengan Lansia (cm)',
            'Lingkar Perut Lansia (cm)'
        ];
    }

    public function styles($sheet)
    {
        $sheet->getStyle('A1:H1')->getFont()->setBold(true);
        $sheet->getStyle('A1:H1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    }

    public function columnFormats(): array
    {
        return [
            'C' => 'dd-mm-yyyy',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getStyle('A1:H' . $event->sheet->getHighestRow())
                    ->getBorders()->getAllBorders()
                    ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                foreach (range('A', 'H') as $column) {
                    $event->sheet->getColumnDimension($column)->setAutoSize(true);
                }
            },
        ];
    }
}
