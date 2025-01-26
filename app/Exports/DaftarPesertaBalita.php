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

class DaftarPesertaBalita implements FromCollection, WithHeadings, WithStyles, WithColumnFormatting, WithEvents
{
    protected $jadwalId;

    public function __construct($jadwalId)
    {
        $this->jadwalId = $jadwalId;
    }

    public function collection()
    {
        $data = PesertaPosyanduBalita::whereHas('jadwals', function ($query) {
            $query->where('jadwal_id', $this->jadwalId);
        })->get([
            'nama_peserta_balita',
            'TempatLahir_balita',
            'TanggalLahir_balita',
            'NIK_balita',
            'nama_orangtua_balita',
            'NIK_orangtua_balita',
            'alamat_balita',
            'wa_balita'
        ]);

        return $data->isEmpty() 
            ? collect([['Tidak ada data untuk jadwal ini']])
            : $data;
    }

    public function headings(): array
    {
        return [
            'Nama Balita',
            'Tempat Lahir',
            'Tanggal Lahir',
            'NIK Balita',
            'Nama Orang Tua Balita',
            'NIK Orang Tua',
            'Alamat',
            'Nomor WhatsApp'
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
