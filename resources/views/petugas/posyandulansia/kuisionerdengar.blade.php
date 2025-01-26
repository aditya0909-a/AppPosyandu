<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kuisioner Tes Pendengaran</title>
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
                <button onclick="window.location.href='/tesdengar/fiturposyandulansia/{{ $userId }}/{{ $jadwalId }}'" class="text-[#0077B5] mr-4">
                    &larr; Back
                </button>
                <a href="#" class="text-2xl font-bold text-[#0077B5]">Posyandu</a>
                <div class="ml-auto text-[#0077B5] font-sans">Akun Petugas</div>
            </div>
        </nav>

        <div class="flex justify-center items-center mb-8 mt-8">
            <h1 class="text-3xl text-center font-bold">Kuisioner Tes Pendengaran Lansia</h1>
        </div>

        <div class="card bg-white p-6">
            <form action="{{ url('/update-kuisionerdengar/' . $Id) }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="jadwalId" value="{{ $jadwalId }}">
                <h2 class="text-xl font-bold mb-4">Tes Bisik</h2>
                <img src="{{ asset('images/tesdengar.jpg') }}" class="w-max h-max mx-auto mb-4">
                <ol class="list-decimal ml-5 text-gray-700 mb-6">
                    <li class="mt-2">
                        Pemeriksaan dilakukan di ruang kedap suara
                    </li>
                    <li class="mt-2">
                        Berdiri di belakang dengan jarak sekitar satu lengan, menghadap ke satu sisi orang yang diperiksa.
                    </li>
                    <li class="mt-2">
                        Minta orang yang diperiksa/asisten untuk menutup telinga sebelah (yang tidak diperiksa)
                    </li>
                    <li class="mt-2">
                        Perlahan bisikkan empat kata. seperti ikan, api, taman, sepeda.
                    </li>
                    <li class="mt-2">
                        Minta orang yang diperiksa untuk mengulang kata-kata Anda.
                    </li>
                    <li class="mt-2">
                        Kata-kata Anda harus diucapkan satu per satu 
                    </li>
                    <li class="mt-2">
                        Jika mengulangi lebih dari tiga kata dan Anda yakin bahwa dia dapat mendengar dengan jelas maka pendengaran normal.
                    </li>
                </ol>
                                
                <div >
                    <label>
                        <input type="checkbox" name="dengar" value="1" > <strong>Peserta tidak mendengar bisikan</strong>
                    </label>
                </div>
                <div class="mb-4" >
                    <label>
                        <input type="checkbox" name="dengar" value="0" > <strong>Peserta mendengar dengan baik</strong>
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
