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
    <h2>Data Pemberian Obat Cacing {{ $jadwal->name }}</h2>
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
                <th>Nama Peserta</th>
                <th>Tempat Lahir</th>
                <th>Tanggal Lahir</th>
                <th>NIK Balita</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $index => $peserta)
                <tr>
                    <td>{{ $peserta->nama_peserta_balita }}</td>
                    <td>{{ $peserta->TempatLahir_balita }}</td>
                    <td>{{ \Carbon\Carbon::parse($peserta->TanggalLahir_balita)->locale('id')->isoFormat('D MMMM YYYY') }}</td>
                    <td>{{ $peserta->NIK_balita }}</td>
                    <!-- Menampilkan data kesehatan jika ada dan mengganti 'iya' dengan 'Sudah Diberikan' -->
                    <td>
                        @if ($peserta->dataKesehatan->isNotEmpty())
                            {{-- Memeriksa apakah nilai obat_cacing adalah 'iya' --}}
                            {{ $peserta->dataKesehatan->first()->obat_cacing === 'iya' ? 'Sudah Diberikan' : 'Belum Diberikan' }}
                        @else
                            N/A
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
