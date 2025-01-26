<?php

namespace App\Http\Controllers;

use App\Models\PesertaPosyanduLansia;
use App\Models\DataKesehatanLansia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PesertalansiaController extends Controller
{
    public function DataKesehatan($id)
    {
        $PesertaPosyanduLansia = PesertaPosyanduLansia::findOrFail($id);
        $data = DB::table('DataKesehatanLansia')
            ->where('peserta_id', $id)
            ->select('created_at','keluhan_lansia', 'obat_lansia', 'mobilisasi', 'dengar', 'depresi1', 'depresi2', 'lihat1', 'lihat2', 'kognitif1', 'malnutrisi1', 'malnutrisi2', 'malnutrisi3', 'kognitif2', 'tinggi_lansia','guladarah_lansia','kolesterol_lansia','asamurat_lansia','tensi_lansia', 'berat_lansia', 'lingkar_lengan_lansia', 'lingkar_perut_lansia')
            ->get();

        $keluhanData = $data->map(function ($item) {
            return [
                'tanggal' => Carbon::parse($item->created_at)->format('d-m-Y'),
                'keluhan' => $item->keluhan_lansia,
                'obat' => $item->obat_lansia,
            ];
        });

        // Filter dan map untuk GCU
        $GCUData = $data->filter(function ($item) {
            // Pastikan kolom yang diperlukan tidak null
            return !is_null($item->guladarah_lansia) && !is_null($item->kolesterol_lansia) 
                && !is_null($item->tensi_lansia) && !is_null($item->asamurat_lansia);
        })->map(function ($item) {
            return [
                'tanggal' => Carbon::parse($item->created_at)->format('d-m-Y'),
                'guladarah' => $item->guladarah_lansia,
                'kolesterol' => $item->kolesterol_lansia,
                'tensi' => $item->tensi_lansia,
                'asamurat' => $item->asamurat_lansia,
            ];
        });

        $KognitifData = $data->map(function ($item) {
            return [
                'tanggal' => Carbon::parse($item->created_at)->format('d-m-Y'),
                // Cek apakah kognitif1 atau kognitif2 bernilai 1, jika ya maka 'Terdapat Penurunan Kognitif'
                'keterangan_kognitif' => $item->kognitif1 === 1 || $item->kognitif2 === 1 
                    ? 'Terdapat Penurunan Kemampuan Kognitif' 
                    : 'Kemampuan Kognitif Baik',
            ];
        });

        $MobilisasiData = $data->map(function ($item) {
            return [
                'tanggal' => Carbon::parse($item->created_at)->format('d-m-Y'),
                // Cek apakah kognitif1 atau kognitif2 bernilai 1, jika ya maka 'Terdapat Penurunan Kognitif'
                'keterangan_mobilisasi' => $item->mobilisasi === 1
                    ? 'Terdapat Penurunan Kemampuan mobilisasi' 
                    : 'Kemampuan mobilisasi Baik',
            ];
        });

        $MalnutrisiData = $data->map(function ($item) {
            return [
                'tanggal' => Carbon::parse($item->created_at)->format('d-m-Y'),
                'keterangan_malnutrisi' => $item->malnutrisi1 === 1 || $item->malnutrisi2 === 1 || $item->malnutrisi3 === 1
                    ? 'Terdapat indikasi' 
                    : 'Tidak ada indikasi malnutrisi',
            ];
        });

        $LihatData = $data->map(function ($item) {
            return [
                'tanggal' => Carbon::parse($item->created_at)->format('d-m-Y'),
                'keterangan_lihat' => $item->lihat1 === 1 || $item->lihat2 === 1
                    ? 'Terdapat penurunan penglihatan' 
                    : 'Penglihatan baik',
            ];
        });

        $DengarData = $data->map(function ($item) {
            return [
                'tanggal' => Carbon::parse($item->created_at)->format('d-m-Y'),
                'keterangan_dengar' => $item->dengar === 1
                    ? 'Terdapat penurunan pendengaran' 
                    : 'Pendengaran baik',
            ];
        });

        $DepresiData = $data->map(function ($item) {
            return [
                'tanggal' => Carbon::parse($item->created_at)->format('d-m-Y'),
                'keterangan_depresi' => $item->depresi1 === 1 || $item->depresi2 === 1
                    ? 'Terdapat indikasi depresi' 
                    : 'Tidak ada indikasi depresi',
            ];
        });
        

        // Ambil data terbaru untuk tinggi badan dan berat badan
    $latestData = $data->sortByDesc('created_at')->first(); // Ambil data terbaru berdasarkan tanggal
    $latestTinggi = $latestData->tinggi_lansia;
    $latestBerat = $latestData->berat_lansia;

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


        return view('pesertalansia.datalansia', compact('PesertaPosyanduLansia', 'data', 'DepresiData', 'DengarData', 'LihatData', 'MalnutrisiData', 'MobilisasiData', 'KognitifData', 'GCUData', 'latestTinggi', 'latestBerat', 'bmi', 'category'));
    }

    public function getChartDataByPeserta($peserta_id)
{
    try {
        // Validasi peserta_id
        if (!$peserta_id || !is_numeric($peserta_id)) {
            return response()->json([
                'error' => 'Invalid peserta ID provided'
            ], 400);
        }

        // Cek apakah peserta ada
        $peserta = PesertaPosyanduLansia::find($peserta_id);
        if (!$peserta) {
            return response()->json([
                'error' => 'Peserta not found'
            ], 404);
        }

        // Ambil data kesehatan peserta dan urutkan berdasarkan created_at (bulan-tahun)
        $data = DataKesehatanLansia::where('peserta_id', $peserta_id)
            ->orderBy('created_at')
            ->get();

        if ($data->isEmpty()) {
            return response()->json([
                'error' => 'No health data found for this peserta'
            ], 404);
        }

        // Buat rentang bulan penuh berdasarkan data
        $startDate = Carbon::parse($data->first()->created_at)->startOfMonth();
        $endDate = Carbon::parse($data->last()->created_at)->startOfMonth();
        $monthsRange = [];

        while ($startDate <= $endDate) {
            $monthsRange[] = $startDate->format('m-Y');
            $startDate->addMonth();
        }

        // Proses data dengan interpolasi
        $processedData = [];
        foreach ($monthsRange as $monthYear) {
            $monthData = $data->firstWhere(fn($item) => Carbon::parse($item->created_at)->format('m-Y') === $monthYear);

            $growthData = [
                'month_year' => $monthYear,
                'tinggi_lansia' => $monthData ? (float) $monthData->tinggi_lansia : null,
                'berat_lansia' => $monthData ? (float) $monthData->berat_lansia : null,
                'lingkar_lengan_lansia' => $monthData ? (float) $monthData->lingkar_lengan_lansia : null,
                'lingkar_perut_lansia' => $monthData ? (float) $monthData->lingkar_perut_lansia : null,
            ];

            // Interpolasi untuk data null
            foreach ($growthData as $key => $value) {
                if ($key === 'month_year' || !is_null($value)) {
                    continue;
                }

                // Cari nilai sebelumnya dan berikutnya
                $previous = $data->where('created_at', '<', Carbon::createFromFormat('m-Y', $monthYear))->sortByDesc('created_at')->first();
                $next = $data->where('created_at', '>', Carbon::createFromFormat('m-Y', $monthYear))->sortBy('created_at')->first();

                if ($previous && $next) {
                    $x1 = Carbon::parse($previous->created_at)->timestamp;
                    $y1 = $previous->$key;
                    $x2 = Carbon::parse($next->created_at)->timestamp;
                    $y2 = $next->$key;
                    $x = Carbon::createFromFormat('m-Y', $monthYear)->timestamp;

                    // Hitung interpolasi linear
                    $growthData[$key] = $y1 + (($y2 - $y1) / ($x2 - $x1)) * ($x - $x1);
                }
            }

            // Bulatkan hasil
            foreach ($growthData as $key => $value) {
                if ($key !== 'month_year' && !is_null($value)) {
                    $growthData[$key] = round($value, 2);
                }
            }

            $processedData[] = $growthData;
        }

        // Siapkan struktur data untuk chart
        $chartData = [
            'labels' => array_column($processedData, 'month_year'),
            'tinggiBadan' => [
                'label' => 'Tinggi Badan (cm)',
                'data' => array_column($processedData, 'tinggi_lansia'),
            ],
            'beratBadan' => [
                'label' => 'Berat Badan (kg)',
                'data' => array_column($processedData, 'berat_lansia'),
            ],
            'lingkarLengan' => [
                'label' => 'Lingkar Lengan (cm)',
                'data' => array_column($processedData, 'lingkar_lengan_lansia'),
            ],
            'lingkarPerut' => [
                'label' => 'Lingkar Perut (cm)',
                'data' => array_column($processedData, 'lingkar_perut_lansia'),
            ],
        ];

        return response()->json($chartData);
    } catch (\Exception $e) {
        return response()->json([
            'error' => 'An error occurred while processing the chart data'
        ], 500);
    }
}
}
