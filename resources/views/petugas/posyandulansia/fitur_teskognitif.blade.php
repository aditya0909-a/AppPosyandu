<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tes Kognitif Lansia - Petugas</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            background-color: #E6F7FF;
            color: #4A4A4A;
            padding-top: 64px;
            font-family: Arial, sans-serif;
        }

        .navbar {
            background-color: rgba(0, 153, 204, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(0, 153, 204, 0.2);
        }

        .button-primary {
            background: linear-gradient(135deg, #0077B5, #0099CC);
            color: #FFFFFF;
            padding: 8px 16px;
            font-size: 1rem;
            border-radius: 8px;
            transition: transform 0.2s;
        }

        .button-primary:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .input-field {
            width: 100%;
            padding: 8px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.2s;
        }

        .input-field:focus {
            border-color: #0077B5;
            outline: none;
        }

        .card {
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 20px;
            transition: transform 0.2s;
        }

        .card:hover {
            transform: translateY(-5px);
        }

    </style>
</head>

<body>
    <div class="max-w-4xl mx-auto p-6">
        <nav class="navbar fixed top-0 left-0 right-0 z-10 p-4 shadow-md">
            <div class="container mx-auto flex items-center">
                <button onclick="window.location.href = '/fiturposyandu/petugas'" class="text-[#0077B5] mr-4">
                    &larr; Back
                </button>
                <a href="#" class="text-2xl font-bold text-[#0077B5]">Posyandu</a>
                <div class="ml-auto text-[#0077B5] font-sans">Akun Petugas</div>
            </div>
        </nav>

        <div class="flex justify-center items-center mb-6 mt-8">
            <h1 class="text-3xl text-center font-bold">Tes Kognitif dan Gejala Depresi Lansia</h1>
        </div>

        <div class="flex items-center mb-4">
            <input type="text" placeholder="Cari peserta..." class="input-field" id="searchInput">
        </div>

        @php
        $sortedPeserta = $peserta->sortBy(function ($item) use ($jadwalId) {
            $dataKesehatan = $item->dataKesehatan->firstWhere('jadwal_id', $jadwalId);

            if (isset($dataKesehatan)) {
                $isComplete = $dataKesehatan->submitkognitif;
                return $isComplete ? 1 : 0;
            }

            return 1;
        });
        @endphp

        <div id="pesertaList">
            @foreach($sortedPeserta as $index => $item)
                @php
                    $dataKesehatan = $item->dataKesehatan->firstWhere('jadwal_id', $jadwalId);
                @endphp

                <div class="card mb-6 p-4 rounded-lg {{ isset($dataKesehatan) && $dataKesehatan->submitkognitif ? 'bg-gray-200' : 'bg-white' }} flex justify-between items-center">
                    <div>
                        <h2 class="text-xl font-bold">{{ $item->nama_peserta_lansia }}</h2>
                        <p class="text-sm text-gray-600">
                            @if (isset($dataKesehatan) && ($dataKesehatan->kognitif1 || $dataKesehatan->kognitif2))
                                Terdapat penurunan kognitif
                            @else
                                Kemampuan kognitif baik
                            @endif
                        </p>
                        
                        <p class="text-sm text-gray-600">
                            @if (isset($dataKesehatan) && ($dataKesehatan->depresi1 || $dataKesehatan->depresi2))
                                Terdepat gejala depresi
                            @else
                                Tidak terdapat gejala depresi
                            @endif
                        </p>
                    </div>

                    @if(isset($dataKesehatan))
                        <a href="/kuisioner_kognitif/{{ $dataKesehatan->id }}/{{ $dataKesehatan->jadwal_id }}"
                           class="inline-flex items-center px-4 py-2 button-primary">
                            Input
                        </a>
                    @endif
                </div>
            @endforeach
        </div>

    </div>

    <script>
        document.getElementById('searchInput').addEventListener('input', function () {
            const term = this.value.toLowerCase();
            const pesertaCards = document.querySelectorAll('#pesertaList .card');
            pesertaCards.forEach(card => {
                const nama = card.querySelector('h2').textContent.toLowerCase();
                card.style.display = nama.includes(term) ? 'block' : 'none';
            });
        });
    </script>
</body>

</html>
