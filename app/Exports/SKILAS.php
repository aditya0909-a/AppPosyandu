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

class SKILAS implements FromCollection, WithHeadings, WithStyles, WithColumnFormatting, WithEvents
{
    protected $jadwalId;

    public function __construct($jadwalId)
    {
        $this->jadwalId = $jadwalId;
    }

    public function collection()
    {
        // Query data peserta posyandu lansia berdasarkan jadwal_id
        $data = PesertaPosyanduLansia::whereHas('jadwals', function ($query) {
            $query->where('jadwal_id', $this->jadwalId);
        })
        ->with('dataKesehatan') // Menyertakan data kesehatan untuk setiap peserta
        ->get();
    
        // Memproses data peserta
        $processedData = $data->map(function ($peserta) {
            // Mengambil data kesehatan pertama untuk peserta ini
            $dataKesehatan = $peserta->dataKesehatan->first();
    
            // Konversi boolean ke simbol checkbox
            $convertToCheckbox = fn($value) => $value ? '✔' : '';
    
            // Menyusun data yang ingin ditampilkan pada export
            return [
                'Nama Peserta Lansia' => $peserta->nama_peserta_lansia,
                'Tempat Lahir' => $peserta->TempatLahir_lansia,
                'Tanggal Lahir' => $peserta->TanggalLahir_lansia,
                'NIK' => $peserta->NIK_lansia,
                'Kognitif 1' => $dataKesehatan ? $convertToCheckbox($dataKesehatan->kognitif1) : 'N/A',
                'Kognitif 2' => $dataKesehatan ? $convertToCheckbox($dataKesehatan->kognitif2) : 'N/A',
                'Mobilisasi' => $dataKesehatan ? $convertToCheckbox($dataKesehatan->mobilisasi) : 'N/A',
                'Malnutrisi 1' => $dataKesehatan ? $convertToCheckbox($dataKesehatan->malnutrisi1) : 'N/A',
                'Malnutrisi 2' => $dataKesehatan ? $convertToCheckbox($dataKesehatan->malnutrisi2) : 'N/A',
                'Malnutrisi 3' => $dataKesehatan ? $convertToCheckbox($dataKesehatan->malnutrisi3) : 'N/A',
                'Gangguan Penglihatan' => $dataKesehatan ? $convertToCheckbox($dataKesehatan->lihat1) : 'N/A',
                'Gangguan Pendengaran' => $dataKesehatan ? $convertToCheckbox($dataKesehatan->dengar) : 'N/A',
                'Depresi 1' => $dataKesehatan ? $convertToCheckbox($dataKesehatan->depresi1) : 'N/A',
                'Depresi 2' => $dataKesehatan ? $convertToCheckbox($dataKesehatan->depresi2) : 'N/A',
            ];
        });
    
        // Mengembalikan data yang sudah diproses
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
            'Kognitif : Salah pada salah satu pertanyaan',
            'Kognitif : Tidak dapat mengulang ketiga kata',
            'Mobilisasi : Tidak dapat berdiri di kursi sebanyak 5 ',
            'Malnutrisi : Berat badan Anda berkurang >3 kg dalam 3 bulan',
            'Malnutrisi : Hilang nafsu makan',
            'Malnutrisi : Lingkar lengan atas (LiLA) <21 cm',
            'Lihat : kesulitan melihat jauh, membaca, atau penyakit mata',
            'Dengar : Tidak mendengar bisikan saat tes bisik ',
            'Depresi : Perasaan sedih, tertekan, atau putus asa',
            'Depresi : Sedikit minat atau kesenangan dalam melakukan sesuatu'
        ];
    }

    public function styles($sheet)
    {
        $sheet->getStyle('A1:N1')->getFont()->setBold(true);
        $sheet->getStyle('A1:N1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
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
                $event->sheet->getStyle('A1:N' . $event->sheet->getHighestRow())
                    ->getBorders()->getAllBorders()
                    ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                foreach (range('A', 'N') as $column) {
                    $event->sheet->getColumnDimension($column)->setAutoSize(true);
                }
            },
        ];
    }
}
