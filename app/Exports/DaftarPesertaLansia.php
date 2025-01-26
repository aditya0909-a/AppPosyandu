<?php

namespace App\Exports;

use App\Models\PesertaPosyandulansia;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class DaftarPesertaLansia implements FromCollection, WithHeadings, WithStyles, WithColumnFormatting, WithEvents
{
    protected $jadwalId;

    public function __construct($jadwalId)
    {
        $this->jadwalId = $jadwalId;
    }

    public function collection()
    {
        $data = PesertaPosyanduLansia::whereHas('jadwals', function ($query) {
            $query->where('jadwal_id', $this->jadwalId);
        })->get([
            'nama_peserta_lansia',
            'TempatLahir_lansia',
            'TanggalLahir_lansia',
            'NIK_lansia',
            'alamat_lansia',
            'wa_lansia'
        ]);

        return $data->isEmpty() 
            ? collect([['Tidak ada data untuk jadwal ini']])
            : $data;
    }

    public function headings(): array
    {
        return [
            'Nama Lansia',
            'Tempat Lahir',
            'Tanggal Lahir',
            'NIK',
            'Alamat',
            'Nomor WhatsApp'
        ];
    }

    public function styles($sheet)
    {
        $sheet->getStyle('A1:F1')->getFont()->setBold(true);
        $sheet->getStyle('A1:F1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
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
                $event->sheet->getStyle('A1:F' . $event->sheet->getHighestRow())
                    ->getBorders()->getAllBorders()
                    ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                foreach (range('A', 'F') as $column) {
                    $event->sheet->getColumnDimension($column)->setAutoSize(true);
                }
            },
        ];
    }
}
