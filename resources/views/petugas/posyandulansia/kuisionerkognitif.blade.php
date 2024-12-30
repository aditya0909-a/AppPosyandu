<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kuisioner Tes Kognitif</title>
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
                <button onclick="window.location.href='/teskognitif/fiturposyandulansia/petugas/{{ $jadwalId }}'" class="text-[#0077B5] mr-4">
                    &larr; Back
                </button>
                <a href="#" class="text-2xl font-bold text-[#0077B5]">Posyandu</a>
                <div class="ml-auto text-[#0077B5] font-sans">Akun Petugas</div>
            </div>
        </nav>

        <div class="flex justify-center items-center mb-8 mt-8">
            <h1 class="text-3xl text-center font-bold">Kuisioner Tes Kognitif Dan Gejala Depresi</h1>
        </div>

        <div class="card bg-white p-6">
            <form action="{{ url('/update-kuisionerkognitif/' . $Id) }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="jadwalId" value="{{ $jadwalId }}">
                <h2 class="text-xl font-bold mb-4">Tes Kognitif</h2>
                <ol class="list-decimal ml-5 text-gray-700 mb-6">
                    <li>
                        Apakah Anda dapat mengingat tiga kata berikut? <br>
                        <strong>Bunga, Pintu, Nasi</strong>
                    </li>
                    <li class="mt-4">
                        Apakah Anda mengetahui:
                        <ul class="list-disc ml-5">
                            <li>Tanggal saat ini?</li>
                            <li>Lokasi tempat Anda berada?</li>
                        </ul>
                    </li>
                </ol>

                <div>
                    <label>
                        <input type="checkbox" id="kognitif-checkbox" name="kognitif2" value="0"> Berhasil menjawab dengan baik
                    </label>
                    <input type="hidden" id="kognitif1-hidden" name="kognitif1" value="0">
                </div>
                
                <div >
                    <label>
                        <input type="checkbox" name="kognitif1" value="1" > Tidak dapat mengulangi ketiga kata
                    </label>
                </div>
                <div >
                    <label>
                        <input type="checkbox" name="kognitif2" value="1" > Salah pada salah satu pertanyaan
                    </label>
                </div>

                <h2 class="text-xl font-bold mb-4 mt-6">Gejala Depresi</h2>
                <ol class="list-decimal ml-5 text-gray-700 mb-6">
                    <li>
                        Selama dua minggu terakhir, apakah anda merasa terganggu oleh perasaan sedih, tertekan, atau putus asa?
                        <div class="mt-2">
                            <label>
                                <input type="radio" name="depresi1" value="1" > Ya
                            </label>
                            <label class="ml-4">
                                <input type="radio" name="depresi1" value="0"> Tidak
                            </label>
                        </div>
                    </li>
                    <li class="mt-4">
                        Selama dua minggu terakhir, apakah anda merasa sedikit minat atau kesenangan dalam melakukan sesuatu?
                        <div class="mt-2">
                            <label>
                                <input type="radio" name="depresi2" value="1" > Ya
                            </label>
                            <label class="ml-4">
                                <input type="radio" name="depresi2" value="0"> Tidak
                            </label>
                        </div>
                    </li>
                </ol>

                <div class="flex justify-end">
                    <button type="submit" class="px-4 py-2 button-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('kognitif-checkbox').addEventListener('change', function() {
            const isChecked = this.checked;
    
            // Atur nilai untuk kedua kolom
            document.getElementById('kognitif1-hidden').value = isChecked ? '0' : '';
            this.value = isChecked ? '0' : '';
        });
    </script>
</body>

</html>
