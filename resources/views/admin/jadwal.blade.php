<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Posyandu Kegiatan</title>
    {{-- Import Library External: TailwindCSS & AlpineJS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
    <style>
        /* Custom Styling */
        body {
            background-color: #f3f4f6;
            font-family: 'Arial', sans-serif;
            padding-top: 50px;
        }
        .navbar, .glass-effect {
        background-color: rgba(0, 153, 204, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(0, 153, 204, 0.2);
        }

        
        .card {
            background-color: white;
            border-radius: 1rem;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background: linear-gradient(135deg, #00A9D1, #0077B5);
            padding: 1.5rem;
            color: white;
            border-radius: 1rem 1rem 0 0;
        }

        /* Table Styling */
        table th,
        table td {
            padding: 12px;
            text-align: left;
        }

        .table-container {
            overflow-x: auto;
        }
    </style>

<div class="max-w-4xl mx-auto p-6">
    <nav class="navbar fixed top-0 left-0 right-0 z-10 p-4 shadow-md">
        <div class="container mx-auto flex items-center">
            <button onclick="window.location.href = '/fiturpenjadwalan/admin'" class="text-[#0077B5] mr-4">
                &larr; Back
            </button>
            <a href="#" class="text-2xl font-bold text-[#0077B5]">Posyandu</a>
            <div class="ml-auto text-[#0077B5] font-sans">Akun Admin</div>
        </div>
    </nav>
</head>

<body>
    <div x-data="{ open: false }" class="max-w-4xl mx-auto mt-8 card">
        <!-- Card Header -->
        <div class="card-header">
            <h2 class="text-2xl font-semibold">Kegiatan Posyandu</h2>
            <p class="text-sm mt-1">Keterangan dan data hasil kegiatan yang dilakukan di Posyandu.</p>
        </div>

        <!-- Card Body -->
        <div class="p-6">
            <!-- Keterangan Kegiatan -->
            <div class="mb-6">
                <div class="text-lg font-semibold">Nama Kegiatan</div>
                <span class="font-normal">{{ $jadwal->name }}</span>
                <div class="text-lg font-semibold mt-2">Lokasi</div>
                <span class="font-normal">{{ $jadwal->location }}</span>
                <div class="text-lg font-semibold mt-2">Tanggal</div>
                <span class="font-normal">{{ $jadwal->formatted_date }}</span>
            </div>

            <!-- Rangkaian Kegiatan -->
            <div class="mb-6">
            <h3 class="text-xl font-semibold">Rangkaian Kegiatan:</h3>
                <ul class="list-disc pl-6 mt-2">
                 <li>Pendaftaran</li>
                 <li>Pengukuran Pertumbuhan</li>
                 @if($jadwal->imunisasi_status)
                     <li>{{ $jadwal->imunisasi_status }}</li>
                 @endif
                 @if($jadwal->obatcacing_status)
                     <li>{{ $jadwal->obatcacing_status }}</li>
                 @endif
                 @if($jadwal->susu_status)
                     <li>{{ $jadwal->susu_status }}</li>
                 @endif
                 @if($jadwal->pemeriksaan_status)
                     <li>{{ $jadwal->pemeriksaan_status }}</li>
                 @endif
                 @if($jadwal->teskognitif_status)
                     <li>{{ $jadwal->teskognitif_status }}</li>
                 @endif
                 @if($jadwal->teslihat_status)
                     <li>{{ $jadwal->teslihat_status }}</li>
                 @endif
                 @if($jadwal->tesdengar_status)
                     <li>{{ $jadwal->tesdengar_status }}</li>
                 @endif
                </ul>
            </div>

            <div class="mb-6">
                <h2 class="text-xl font-semibold mb-4">Unduh Data Kegiatan</h2>
                
                @if($peserta->isEmpty())
                    <p>Tidak ada Data Kegiatan.</p>
                @else
                <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-md">
                    <thead class="bg-blue-100">
                    </thead>
                    <tbody>
                        @php
                            // Daftar kegiatan dengan boolean sebagai kunci dan tautan
                            $dataKegiatan = [
                                'Daftar Hadir Peserta' => ['active' => true, 'link' => url('/daftar-hadir')],
                                'Data Pengukuran' => ['active' => true, 'link' => url('/data-pengukuran')],
                                'Data Imunisasi' => ['active' => $jadwal->imunisasi, 'link' => url('/data-imunisasi')],
                                'Data Pemberian Obat Cacing' => ['active' => $jadwal->obatcacing, 'link' => url('/data-obat-cacing')],
                                'Data Pemberian Susu' => ['active' => $jadwal->susu, 'link' => url('/data-susu')],
                                'Data pemeriksaan Kesehatan Lansia' => ['active' => $jadwal->pemeriksaan, 'link' => url('/data-pemeriksaan')],
                                'Data Tes Kognitif Lansia' => ['active' => $jadwal->teskognitif, 'link' => url('/data-tes-kognitif')],
                                'Data Tes Penglihatan Lansia' => ['active' => $jadwal->teslihat, 'link' => url('/data-tes-penglihatan')],
                                'Data Tes Pendengaran Lansia' => ['active' => $jadwal->tesdengar, 'link' => url('/data-tes-pendengaran')],
                            ];
                        @endphp
                
                        @foreach($dataKegiatan as $kegiatan => $data)
                            @if($data['active'])
                                <tr class="hover:bg-blue-50">
                                    <td class="border-b border-gray-300 px-4 py-2 text-sm text-gray-700">
                                        <a href="{{ $data['link'] }}" class="text-blue-500 hover:underline">{{ $kegiatan }}</a>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
                               
                @endif
            </div>

            <div class="mb-6">
                <h2 class="text-xl font-semibold mb-4">Daftar Peserta</h2>
                
                @if($peserta->isEmpty())
                    <p>Tidak ada peserta untuk jadwal ini.</p>
                @else
                    <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-md">
                        <thead class="bg-blue-100">
                            <tr>
                                <th class="border-b border-gray-300 px-4 py-2 text-left text-sm font-medium text-gray-700">No</th>
                                <th class="border-b border-gray-300 px-4 py-2 text-left text-sm font-medium text-gray-700">Nama Peserta</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($peserta as $index => $item)
                                <tr class="hover:bg-blue-50">
                                    <td class="border-b border-gray-300 px-4 py-2 text-sm text-gray-700">{{ $index + 1 }}</td>
                                    <td class="border-b border-gray-300 px-4 py-2 text-sm text-gray-700">
                                        {{ $item->nama_peserta_balita ?? $item->nama_peserta_lansia }}
                                    </td>                                   
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
                        

 </div>
 </div>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>

</body>


</html>
