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

class DataPemeriksaanLansia implements FromCollection, WithHeadings, WithStyles, WithColumnFormatting, WithEvents
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
            'tensi_lansia' => $dataKesehatan ? $dataKesehatan->tensi_lansia : 'N/A',
            'guladarah_lansia' => $dataKesehatan ? $dataKesehatan->guladarah_lansia : 'N/A',
            'asamurat_lansia' => $dataKesehatan ? $dataKesehatan->asamurat_lansia : 'N/A',
            'kolesterol_lansia' => $dataKesehatan ? $dataKesehatan->kolesterol_lansia : 'N/A',
            'keluhan_lansia' => $dataKesehatan ? $dataKesehatan->keluhan_lansia : 'N/A',
            'obat_lansia' => $dataKesehatan ? $dataKesehatan->obat_lansia : 'N/A',
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
            'Tensi Lansia (mmHg)',
            'Gula Darah Lansia (mg/dL)',
            'Asam Urat Lansia (mg/dL)',
            'Kolesterol Lansia (mg/dL)',
            'Keluhan Lansia',
            'Obat Lansia'
        ];
    }

    public function styles($sheet)
    {
        $sheet->getStyle('A1:J1')->getFont()->setBold(true);
        $sheet->getStyle('A1:J1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
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
                $event->sheet->getStyle('A1:J' . $event->sheet->getHighestRow())
                    ->getBorders()->getAllBorders()
                    ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                foreach (range('A', 'J') as $column) {
                    $event->sheet->getColumnDimension($column)->setAutoSize(true);
                }
            },
        ];
    }
}
