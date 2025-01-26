<?php

namespace App\Exports;

use App\Models\PesertaPosyanduBalita;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class DataObatcacingBalita implements FromCollection, WithHeadings, WithStyles, WithColumnFormatting, WithEvents
{
    protected $jadwalId;

    public function __construct($jadwalId)
    {
        $this->jadwalId = $jadwalId;
    }

    public function collection()
{
    // Query data peserta posyandu balita berdasarkan jadwal_id
    $data = PesertaPosyanduBalita::whereHas('jadwals', function ($query) {
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
            'nama_peserta_balita' => $peserta->nama_peserta_balita,
            'TempatLahir_balita' => $peserta->TempatLahir_balita,
            'TanggalLahir_balita' => $peserta->TanggalLahir_balita,
            'NIK_balita' => $peserta->NIK_balita,
            // Menambahkan pengecekan untuk nilai enum obat_cacing
            'obat_cacing' => $dataKesehatan && $dataKesehatan->obat_cacing === 'iya' ? 'Sudah Diberikan' : 'Belum Diberikan',
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
            'Nama Balita',
            'Tempat Lahir',
            'Tanggal Lahir',
            'NIK Balita',
            'Keterangan',
        ];
    }

    public function styles($sheet)
    {
        $sheet->getStyle('A1:E1')->getFont()->setBold(true);
        $sheet->getStyle('A1:E1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
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
                $event->sheet->getStyle('A1:E' . $event->sheet->getHighestRow())
                    ->getBorders()->getAllBorders()
                    ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                foreach (range('A', 'E') as $column) {
                    $event->sheet->getColumnDimension($column)->setAutoSize(true);
                }
            },
        ];
    }
}
