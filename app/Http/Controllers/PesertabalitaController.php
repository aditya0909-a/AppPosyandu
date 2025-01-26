<?php

namespace App\Http\Controllers;
use App\Models\PesertaPosyanduBalita;
use App\Models\DataKesehatanBalita;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class PesertabalitaController extends Controller
{
    public function DataKesehatan($pesertaId)
{
    $PesertaPosyanduBalita = PesertaPosyanduBalita::findOrFail($pesertaId);

    // Mengambil data kesehatan secara keseluruhan
    $data = DB::table('DataKesehatanBalita')
        ->where('peserta_id', $pesertaId)
        ->select('created_at', 'obat_cacing', 'susu', 'imunisasi', 'bulan_ke', 'tinggi_balita', 'berat_balita', 'lingkar_kepala_balita')
        ->get();

    // Mengambil data tertinggi dan terbaru untuk tinggi badan dan berat badan
    $latestData = DB::table('DataKesehatanBalita')
        ->where('peserta_id', $pesertaId)
        ->orderBy('created_at', 'desc')
        ->first(['tinggi_balita', 'berat_balita']);

    // Filter dan map untuk obat cacing
    $obatCacingData = $data->filter(function ($item) {
        return $item->obat_cacing === 'iya'; // Memastikan hanya data yang 'iya' yang diteruskan
    })->map(function ($item) {
        return [
            'tanggal' => Carbon::parse($item->created_at)->format('d-m-Y'),
            'keterangan_obat_cacing' => $item->obat_cacing === 'iya' ? 'Sudah Diberikan' : 'Belum Diberikan',
        ];
    });

    // Filter dan map untuk susu
    $susuData = $data->filter(function ($item) {
        return $item->susu === 'iya'; // Memastikan hanya data yang 'iya' yang diteruskan
    })->map(function ($item) {
        return [
            'tanggal' => Carbon::parse($item->created_at)->format('d-m-Y'),
            'keterangan_susu' => 'Sudah Diberikan', // Karena hanya yang 'iya' yang dikirim
        ];
    });
    
    // Filter dan map untuk imunisasi
    $imunisasiData = $data->filter(function ($item) {
        return !is_null($item->imunisasi);
    })->map(function ($item) {
        return [
            'tanggal' => Carbon::parse($item->created_at)->format('d-m-Y'),
            'jenis_imunisasi' => $item->imunisasi,
        ];
    });

    // Ambil data terbaru untuk tinggi badan dan berat badan
    $latestData = $data->sortByDesc('created_at')->first(); // Ambil data terbaru berdasarkan tanggal
    $latestTinggi = $latestData->tinggi_balita;
    $latestBerat = $latestData->berat_balita;

    // Hitung BMI
    $bmi = null;
    $category = null;
    if ($latestBerat && $latestTinggi) {
        $bmi = number_format($latestBerat / (($latestTinggi / 100) ** 2), 2); // BMI = berat / (tinggi^2)
        // Tentukan kategori BMI
        if ($bmi < 18.5) {
            $category = 'Kurus';
        } elseif ($bmi < 24.9) {
            $category = 'Normal';
        } elseif ($bmi < 29.9) {
            $category = 'Overweight';
        } else {
            $category = 'Obesitas';
        }
    }

    return view('pesertabalita.databalita', compact('PesertaPosyanduBalita', 'obatCacingData', 'susuData', 'imunisasiData', 'data', 'latestTinggi', 'latestBerat', 'bmi', 'category'));
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

        // Process and normalize the data using a loop
        $monthsRange = range(1, $data->max('bulan_ke'));
        $processedData = [];

        for ($i = 1; $i <= count($monthsRange); $i++) {
            $monthData = $data->firstWhere('bulan_ke', $i);
            $growthData = [
                'tinggi_balita' => $monthData ? (float) $monthData->tinggi_balita : null,
                'berat_balita' => $monthData ? (float) $monthData->berat_balita : null,
                'lingkar_kepala_balita' => $monthData ? (float) $monthData->lingkar_kepala_balita : null,
            ];

            foreach ($growthData as $key => $value) {
                if (is_null($value)) {
                    // Cari nilai sebelumnya
                    $previous = $data->where('bulan_ke', '<', $i)->sortByDesc('bulan_ke')->first();
                    $next = $data->where('bulan_ke', '>', $i)->sortBy('bulan_ke')->first();

                    if ($previous && $next) {
                        $x1 = $previous->bulan_ke;
                        $y1 = $previous->$key;
                        $x2 = $next->bulan_ke;
                        $y2 = $next->$key;

                        // Hitung nilai dengan persamaan garis lurus
                        $growthData[$key] = $y1 + (($y2 - $y1) / ($x2 - $x1)) * ($i - $x1);
                    }
                }

                // Bulatkan nilai float ke dua angka di belakang koma
                $growthData[$key] = isset($growthData[$key]) ? round($growthData[$key], 2) : null;
            }

            $processedData[] = $growthData;
        }

        // Prepare chart data structure
        $chartData = [
            'tinggiBadan' => [
                'label' => 'Tinggi Badan (cm)',
                'data' => array_map(fn($value) => round($value, 2), array_column($processedData, 'tinggi_balita')),
                'min' => round($data->min('tinggi_balita'), 2),
                'max' => round($data->max('tinggi_balita'), 2),
            ],
            'beratBadan' => [
                'label' => 'Berat Badan (kg)',
                'data' => array_map(fn($value) => round($value, 2), array_column($processedData, 'berat_balita')),
                'min' => round($data->min('berat_balita'), 2),
                'max' => round($data->max('berat_balita'), 2),
            ],
            'lingkarKepala' => [
                'label' => 'Lingkar Kepala (cm)',
                'data' => array_map(fn($value) => round($value, 2), array_column($processedData, 'lingkar_kepala_balita')),
                'min' => round($data->min('lingkar_kepala_balita'), 2),
                'max' => round($data->max('lingkar_kepala_balita'), 2),
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
}
