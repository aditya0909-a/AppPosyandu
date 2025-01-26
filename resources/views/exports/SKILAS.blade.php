<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SKILAS PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 15px;
            margin: 0;
            padding: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
        }
        th {
            background-color: #f0f0f0;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    @foreach($data as $index => $peserta)
    <div class="header">
        <h2>SKRINING LANSIA SEDERHANA (SKILAS)</h2>
        <p><strong>Nama:</strong> {{ $peserta->nama_peserta_lansia }} | <strong>NIK:</strong> {{ $peserta->NIK_lansia }}</p>
    </div>
    <table>
        <thead>
            <tr>
                <th>Kondisi Prioritas</th>
                <th>Pertanyaan</th>
                <th>Hasil</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Penurunan Kognitif</td>
                <td>
                    1. Mengingat tiga kata: bunga, pintu, nasi<br>
                    2. Orientasi terhadap waktu dan tempat:<br>
                       &nbsp;&nbsp;a. Tanggal berapa sekarang?<br>
                       &nbsp;&nbsp;b. Di mana Anda berada sekarang?<br>
                    3. Ulangi ketiga kata tadi.
                </td>
                <td>
                    <input type="checkbox" {{ $peserta->dataKesehatan->isNotEmpty() && $peserta->dataKesehatan->first()->kognitif1 ? 'checked' : '' }}> Jawaban salah<br>
                    <input type="checkbox" {{ $peserta->dataKesehatan->isNotEmpty() && $peserta->dataKesehatan->first()->kognitif2 ? 'checked' : '' }}> Tidak dapat mengulang 
                </td>
            </tr>
            <tr>
                <td>Keterbatasan Mobilisasi</td>
                <td>
                    Tes berdiri dari kursi: Berdiri dari kursi lima kali tanpa menggunakan tangan.
                </td>
                <td><input type="checkbox" {{ $peserta->dataKesehatan->isNotEmpty() && $peserta->dataKesehatan->first()->mobilitas ? 'checked' : '' }}> Tidak</td>
            </tr>
            <tr>
                <td>Malnutrisi</td>
                <td>
                    1. Apakah berat badan Anda berkurang >3 kg dalam 3 bulan terakhir?<br>
                    2. Apakah Anda hilang nafsu makan?<br>
                    3. Apakah ukuran lingkar lengan atas (LiLA) < 21 cm?
                </td>
                <td>
                    <input type="checkbox" {{ $peserta->dataKesehatan->isNotEmpty() && $peserta->dataKesehatan->first()->malnutrisi1 ? 'checked' : '' }}> Ya<br>
                    <input type="checkbox" {{ $peserta->dataKesehatan->isNotEmpty() && $peserta->dataKesehatan->first()->malnutrisi2 ? 'checked' : '' }}> Ya<br>
                    <input type="checkbox" {{ $peserta->dataKesehatan->isNotEmpty() && $peserta->dataKesehatan->first()->malnutrisi3 ? 'checked' : '' }}> Ya
                </td>
            </tr>
            <tr>
                <td>Gangguan Penglihatan</td>
                <td>
                    Apakah Anda mengalami masalah pada mata: kesulitan melihat jauh, membaca, penyakit mata, atau sedang dalam pengobatan medis?
                </td>
                <td><input type="checkbox" {{ $peserta->dataKesehatan->isNotEmpty() && $peserta->dataKesehatan->first()->lihat1 ? 'checked' : '' }}> Ya</td>
            </tr>
            <tr>
                <td>Gangguan Pendengaran</td>
                <td>Mendengar bisikan saat tes bisik.</td>
                <td><input type="checkbox" {{ $peserta->dataKesehatan->isNotEmpty() && $peserta->dataKesehatan->first()->dengar ? 'checked' : '' }}> Tidak</td>
            </tr>
            <tr>
                <td>Gejala Depresi</td>
                <td>
                    Selama dua minggu terakhir, apakah Anda merasa terganggu oleh:<br>
                    • Perasaan sedih, tertekan, atau putus asa?<br>
                    • Sedikit minat atau kesenangan dalam melakukan sesuatu?
                </td>
                <td>
                    <input type="checkbox" {{ $peserta->dataKesehatan->isNotEmpty() && $peserta->dataKesehatan->first()->depresi1 ? 'checked' : '' }}> Ya<br>
                    <input type="checkbox" {{ $peserta->dataKesehatan->isNotEmpty() && $peserta->dataKesehatan->first()->depresi2 ? 'checked' : '' }}> Ya
                </td>
            </tr>
        </tbody>
    </table>
    <p><strong>Keterangan :</strong> Jika ditemukan salah satu penurunan kapasitas intrinsik (jika ada salah satu atau lebih yang dicentang),
        maka skrining dilanjutkan oleh petugas kesehatan di Puskesmas sesuai alur asuhan lanjutan</p>
    @if(!$loop->last)
        <div class="page-break"></div>
    @endif
    @endforeach
</body>
</html>
