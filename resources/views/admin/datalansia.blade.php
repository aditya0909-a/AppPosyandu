<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Posyandu</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    body { padding-top: 64px; } /* Pastikan konten tidak tertutup navbar */
  </style>
</head>
<body class="bg-gray-100">

 <!-- Navbar -->
 <nav class="bg-white shadow-md p-4 fixed top-0 left-0 right-0 z-10">
    <div class="container mx-auto flex items-center">
        <!-- Back Button -->
        <button onclick="window.location.href = '/fitur_datalansia_admin'" class="text-blue-500 focus:outline-none mr-4">
            &larr; Back
        </button>
        <!-- Title -->
        <a href="#" class="text-2xl font-bold text-blue-500">Posyandu</a>
        <div class="ml-auto text-blue-500 font-sans">Akun Admin</div>
        <!-- Keterangan akun "Admin" muncul di mobile -->
    </div>
</nav>

<body class="bg-gray-100 p-5">
    <div class="container mx-auto bg-white p-6 rounded-lg shadow-lg" x-data="{ showGrowthChart: false }">
        <!-- Header -->
        <h2 class="text-2xl font-bold text-center mb-6">Data Peserta Posyandu Lansia</h2>

        <!-- Informasi Dasar Balita -->
        <div class="mb-6">
            <h3 class="text-xl font-semibold text-gray-700">Informasi Balita</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p><strong>Nama Balita:</strong> {{ $PesertaPosyanduBalita->nama_peserta_balita}}</p>
                    <p><strong>TTL Balita:</strong> {{$PesertaPosyanduBalita->TTL_balita}}</p>
                    <p><strong>NIK Balita:</strong> {{$PesertaPosyanduBalita->NIK_balita}}</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p><strong>Nama Orang Tua:</strong> {{$PesertaPosyanduBalita->nama_orangtua_balita}}</p>
                    <p><strong>NIK Orang Tua:</strong> {{$PesertaPosyanduBalita->NIK_orangtua_balita}}</p>
                    <p><strong>Alamat:</strong> {{$PesertaPosyanduBalita->alamat_balita}}</p>
                    <p><strong>Nomor WhatsApp:</strong> {{$PesertaPosyanduBalita->wa_balita}}</p>
                </div>
            </div>
        </div>
        
        <!-- Tombol untuk Buka Diagram -->
        <button @click="showGrowthChart = true"
            class="mt-4 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
            Lihat Diagram Pertumbuhan
        </button>

        <!-- Modal Diagram Pertumbuhan -->
        <div x-show="showGrowthChart" x-cloak @click.away="showGrowthChart = false"
            class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center z-50" x-transition
            x-init="$watch('showGrowthChart', value => {
                if (value) {
                    setTimeout(() => initChart(), 100);
                }
            })">
            <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-lg relative">
                <h3 class="text-xl font-bold mb-4">Diagram Pertumbuhan Balita</h3>
                <!-- Tombol Tutup -->
                <button @click="showGrowthChart = false"
                    class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">
                    &times;
                </button>

                <!-- Canvas untuk Grafik -->
                <canvas id="growthChart" width="400" height="200"></canvas>
            </div>
        </div>
    </div>

    <script>
        // Script untuk Menginisialisasi Grafik
        function initChart() {
            const ctx = document.getElementById('growthChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['0 bulan', '1 bulan', '2 bulan', '3 bulan', '4 bulan', '5 bulan', '6 bulan'],
                    datasets: [{
                            label: 'Berat Badan (kg)',
                            data: [3.5, 4.2, 5.0, 5.8, 6.5, 7.1, 7.8],
                            borderColor: 'rgba(54, 162, 235, 1)',
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            borderWidth: 2,
                            fill: true
                        },
                        {
                            label: 'Tinggi Badan (cm)',
                            data: [50, 54, 58, 62, 65, 68, 70],
                            borderColor: 'rgba(75, 192, 192, 1)',
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderWidth: 2,
                            fill: true
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top'
                        }
                    },
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Usia'
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Pertumbuhan'
                            }
                        }
                    }
                }
            });
        }
    </script>

    <!-- Tabel Vaksinasi -->
    <div class="mb-6">
        <h3 class="text-xl font-semibold text-gray-700">Tabel Vaksinasi</h3>
        <table class="w-full mt-4 bg-white shadow rounded-lg overflow-hidden">
            <thead class="bg-blue-500 text-white">
                <tr>
                    <th class="p-2 text-left">Jenis Vaksin</th>
                    <th class="p-2 text-left">Tanggal Pemberian</th>
                    <th class="p-2 text-left">Keterangan</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                <tr class="border-t">
                    <td class="p-2">BCG</td>
                    <td class="p-2">01-03-2021</td>
                    <td class="p-2">Sudah diberikan</td>
                </tr>
                <tr class="border-t">
                    <td class="p-2">Polio</td>
                    <td class="p-2">05-05-2021</td>
                    <td class="p-2">Sudah diberikan</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Tabel Pemberian Obat Cacing -->
    <div class="mb-6">
        <h3 class="text-xl font-semibold text-gray-700">Tabel Pemberian Obat Cacing</h3>
        <table class="w-full mt-4 bg-white shadow rounded-lg overflow-hidden">
            <thead class="bg-green-500 text-white">
                <tr>
                    <th class="p-2 text-left">Tanggal Pemberian</th>
                    <th class="p-2 text-left">Dosis</th>
                    <th class="p-2 text-left">Keterangan</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                <tr class="border-t">
                    <td class="p-2">10-08-2022</td>
                    <td class="p-2">1 tablet</td>
                    <td class="p-2">Sudah diberikan</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Tabel Pemberian Bantuan Susu -->
    <div>
        <h3 class="text-xl font-semibold text-gray-700">Tabel Pemberian Bantuan Susu</h3>
        <table class="w-full mt-4 bg-white shadow rounded-lg overflow-hidden">
            <thead class="bg-purple-500 text-white">
                <tr>
                    <th class="p-2 text-left">Tanggal Pemberian</th>
                    <th class="p-2 text-left">Jumlah</th>
                    <th class="p-2 text-left">Keterangan</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                <tr class="border-t">
                    <td class="p-2">15-09-2022</td>
                    <td class="p-2">2 kotak</td>
                    <td class="p-2">Sudah diberikan</td>
                </tr>
                <tr class="border-t">
                    <td class="p-2">20-10-2022</td>
                    <td class="p-2">1 kotak</td>
                    <td class="p-2">Sudah diberikan</td>
                </tr>
            </tbody>
        </table>
    </div>
    </div>
</body>

</html>
