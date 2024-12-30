<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kuisioner Tes Penglihatan</title>
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
        }
    </style>
</head>

<body>
    <div class="max-w-4xl mx-auto p-6">
        <nav class="navbar fixed top-0 left-0 right-0 z-10 p-4 shadow-md">
            <div class="container mx-auto flex items-center">
                <button onclick="window.location.href='/teslihat/fiturposyandulansia/petugas/{{ $jadwalId }}'" class="text-[#0077B5] mr-4">
                    &larr; Back
                </button>
                <a href="#" class="text-2xl font-bold text-[#0077B5]">Posyandu</a>
                <div class="ml-auto text-[#0077B5] font-sans">Akun Petugas</div>
            </div>
        </nav>

        <div class="flex justify-center items-center mb-8 mt-8">
            <h1 class="text-3xl text-center font-bold">Kuisioner Tes Penglihatan Lansia</h1>
        </div>

        <div class="card bg-white p-6">
            <form action="{{ url('/update-kuisionerlihat/' . $Id) }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="jadwalId" value="{{ $jadwalId }}">
                <h2 class="text-xl font-bold mb-4">Kuisioner</h2>
                <ol class="list-decimal ml-5 text-gray-700 mb-3">
                    <li class="mt-2">
                        Apakah Anda mengalami masalah pada mata: 
                        <ul class="list-disc ml-5">
                            <li>kesulitan melihat jauh, membaca, penyakit mata,</li>
                            <li>atau sedang dalam pengobata pengobatan medis medis (diabetes, tekanan darah tinggi)</li>
                        </ul>
                        Jika tidak, lakukan <strong>Tes Melihat</strong>
                    </li>                    
                </ol>
                <div>
                    <label>
                        <input type="checkbox" name="lihat1" value="1" > <strong>Iya, terdapat masalah penglihatan </strong>
                    </label>
                </div>

                <h2 class="text-xl font-bold mb-4 mt-4">Tes Melihat</h2>
                <ol class="list-decimal ml-5 text-gray-700 mb-3">
                    <li class="mt-2">
                        Jalan 20 langkah = 6 meter
                    </li>
                    <img src="{{ asset('images/teslihat1.jpg') }}" class="w-max h-max mx-auto mb-4">
                    <li class="mt-2">
                        Posisi orang yang akan diperiksa dengan pemeriksa berhadapan
                    </li>
                    <li class="mt-2">
                        Pemeriksaan dilakukan pada tempat terang atau dengan pencahayaan yang bagus
                    </li>
                    <li class="mt-2">
                        Jari pemeriksa dan mata yang diperiksa harus sejajar
                    </li>
                    <li class="mt-2">
                        Mata diperiksa secara bergantian dengan menutup salah satu mata yang lain
                    </li>                    
                    <li class="mt-2">
                        Jari tangan pemeriksa saat melakukan pemeriksaan hitung jari tidak boleh berurutan
                    </li>
                    <img src="{{ asset('images/teslihat2.jpg') }}" class="w-max h-max mx-auto mb-4">
                    <li class="mt-2">
                        Hitung jawaban 3 kali benar secara berturut-turut pada masing-masing mata. Apabila kurang dari 3, maka terdapat gangguan penglihatan.
                    </li>
                    <img src="{{ asset('images/teslihat3.jpg') }}" class="w-max h-max mx-auto mb-4">
                </ol>
                <div>
                    <label>
                        <input type="checkbox" name="lihat2" value="1" > <strong>Terdapat gangguan penglihatan</strong>
                    </label>
                </div>
                <div class="mb-4">
                    <label>
                        <input type="checkbox" name="lihat2" value="0" > <strong>Tidak ada gangguan penglihatan</strong>
                    </label>
                </div>
                
                <div class="flex justify-end">
                    <button type="submit" class="px-4 py-2 button-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
