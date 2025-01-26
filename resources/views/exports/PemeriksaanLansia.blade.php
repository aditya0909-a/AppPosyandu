<!DOCTYPE html>
<html>
<head>
    <title>Export PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 100%;
        }
        .header-info {
            width: 100%;
            margin-bottom: 10px; /* Spasi bawah antara header dan tabel */
        }
        .header-info table {
            width: 100%;
            border-collapse: collapse;
            border: none;
        }
        .header-info td {
            padding: 0; /* Hilangkan padding pada sel tabel header */
            border: none; /* Hilangkan border pada sel tabel header */
        }
        h2 {
            text-align: center;
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 15px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 5px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Data Pemeriksaan {{ $jadwal->name }}</h2>
    <div class="header-info">
        <table>
            <tr>
                <td style="text-align: left;">Tanggal: {{ \Carbon\Carbon::parse($jadwal->date)->locale('id')->isoFormat('D MMMM YYYY') }}</td>
                <td style="text-align: right;">Lokasi: {{ $jadwal->location }}</td>
            </tr>
        </table>
    </div>
    <table>
        <thead>
            <tr>
                <th>Nama Lansia</th>
                <th>Tempat Lahir</th>
                <th>Tanggal Lahir</th>
                <th>Tensi Lansia (mmHg)</th>
                <th>Gula Darah Lansia (mg/dL)</th>
                <th>Asam Urat Lansia (mg/dL)</th>
                <th>Kolesterol Lansia (mg/dL)'</th>
                <th>Keluhan Lansia</th>
                <th>Obat Lansia</th>       
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $index => $peserta)
                <tr>
                    <td>{{ $peserta->nama_peserta_lansia }}</td>
                    <td>{{ $peserta->TempatLahir_lansia }}</td>
                    <td>{{ \Carbon\Carbon::parse($peserta->TanggalLahir_lansia)->locale('id')->isoFormat('D MMMM YYYY') }}</td>
                    <!-- Menampilkan data kesehatan jika ada -->
                    <td>{{ $peserta->dataKesehatan->isNotEmpty() ? $peserta->dataKesehatan->first()->tensi_lansia : 'N/A' }}</td>
                    <td>{{ $peserta->dataKesehatan->isNotEmpty() ? $peserta->dataKesehatan->first()->guladarah_lansia : 'N/A' }}</td>
                    <td>{{ $peserta->dataKesehatan->isNotEmpty() ? $peserta->dataKesehatan->first()->kolesterol_lansia : 'N/A' }}</td>
                    <td>{{ $peserta->dataKesehatan->isNotEmpty() ? $peserta->dataKesehatan->first()->asamurat_lansia : 'N/A' }}</td>
                    <td>{{ $peserta->dataKesehatan->isNotEmpty() ? $peserta->dataKesehatan->first()->keluhan_lansia : 'N/A' }}</td>
                    <td>{{ $peserta->dataKesehatan->isNotEmpty() ? $peserta->dataKesehatan->first()->obat_lansia : 'N/A' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
