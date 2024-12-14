<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Posyandu</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])



    <style>
        /* Default Styling */
        body {
            background-color: #FFFFFF;
            /* Biru Muda */
            color: #4A4A4A;
            padding-left: 16px;
            padding-right: 16px;
        }

        .navbar,
        .glass-effect {
            background-color: rgba(0, 153, 204, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(0, 153, 204, 0.2);
        }

        .button-primary {
            background: linear-gradient(135deg, #0077B5, #0099CC);
            color: #FFFFFF;

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

        /* Responsif untuk layar kecil (mobile) */
        @media (max-width: 768px) {
            body {
                padding-left: 8px;
                /* Kurangi padding samping */
                padding-right: 8px;
            }

            .container {
                padding: 8px;
            }

            /* Navbar */
            nav {
                padding: 8px;
                /* Navbar padding lebih kecil */
            }


            /* Header */
            h2,
            h3 {
                font-size: 1.25rem;
                /* Perkecil ukuran font judul */
            }

            /* Tabel */
            table {
                font-size: 0.875rem;
                /* Perkecil font tabel */
            }

            th,
            td {
                padding: 8px;
                /* Kurangi padding dalam tabel */
            }

            /* Tombol */
            button {
                padding: 8px 12px;
                /* Kurangi padding tombol */
                font-size: 0.875rem;
                /* Perkecil font tombol */
            }
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar fixed top-0 left-0 right-0 z-10 p-4 shadow-md">
        <div class="container mx-auto flex items-center">
            <button onclick="window.location.href = '/fiturdatabalita/admin'" class="text-[#0077B5] mr-4">
                &larr; Back
            </button>
            <a href="#" class="text-2xl font-bold text-[#0077B5]">Posyandu</a>
            <div class="ml-auto text-[#0077B5] font-sans">Akun Admin</div>
        </div>
    </nav>

    <body class=" p-5" style="background-color: #FFFFFF; padding-top: 100px;">
        <div x-data="{ showGrowthChart: false }">
            
            <div x-data="{ open: false }" class="max-w-4xl mx-auto mt-8 card">
                <!-- Card Header -->
                <div class="card-header">
                    <h2 class="text-2xl font-semibold ">Data Peserta</h2>
                    <h2 class="text-2xl font-semibold">Posyandu Balita</h2>
                </div>
        
                <!-- Card Body -->
                <div class="p-6">
                    <!-- Keterangan Kegiatan -->
                    <div class="mb-6">
                        <div class="text-lg text-black font-semibold">Nama Lengkap</div>
                        <span class="font-normal">{{ $PesertaPosyanduBalita->nama_peserta_balita }}</span>
                        <div class="text-lg text-black font-semibold mt-2">Tempat Lahir</div>
                        <span class="font-normal">{{ $PesertaPosyanduBalita->TempatLahir_balita }}</span>
                        <div class="text-lg text-black font-semibold mt-2">Tanggal Lahir</div>
                        <span class="font-normal">{{ $PesertaPosyanduBalita->TanggalLahir_balita }}</span>
                        <div class="text-lg text-black font-semibold mt-2">NIK Balita</div>
                        <span class="font-normal">{{ $PesertaPosyanduBalita->NIK_balita }}</span>
                        <div class="text-lg text-black font-semibold mt-2">Nama Orang Tua</div>
                        <span class="font-normal">{{ $PesertaPosyanduBalita->nama_orangtua_balita }}</span>
                        <div class="text-lg text-black font-semibold mt-2">NIK Orang Tua</div>
                        <span class="font-normal">{{ $PesertaPosyanduBalita->NIK_orangtua_balita }}</span>
                        <div class="text-lg text-black font-semibold mt-2">Alamat Balita</div>
                        <span class="font-normal">{{ $PesertaPosyanduBalita->alamat_balita }}</span>
                        <div class="text-lg text-black font-semibold mt-2">Nomor WhatsApp</div>
                        <span class="font-normal">{{ $PesertaPosyanduBalita->wa_balita }}</span>
                    </div>
                </div>
            </div>

            <div x-data="chartHandler" x-init="init({{ $PesertaPosyanduBalita->id }})">

                <h3 class="text-2xl font-semibold text-gray-800 mt-8">Lihat Diagram Pertumbuhan</h3>
                <div class="flex flex-wrap justify-between gap-2 mt-4">
                    <button @click="showChart('tinggiBadan')"
                        class="button-primary rounded-lg flex-1 text-center px-4 py-2 text-sm">
                        Tinggi Badan
                    </button>
                    <button @click="showChart('beratBadan')"
                        class="button-primary rounded-lg flex-1 text-center px-4 py-2 text-sm">
                        Berat Badan
                    </button>
                    <button @click="showChart('lingkarKepala')"
                        class="button-primary rounded-lg flex-1 text-center px-4 py-2 text-sm">
                        Lingkar Kepala
                    </button>
                </div>

                <!-- Modal Diagram -->
                <div x-show="showGrowthChart" x-cloak @click.away="closeChart"
                    class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center z-50" x-transition>
                    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-lg relative">
                        <h3 class="text-xl font-bold mb-4" x-text="chartTitle"></h3>
                        <button @click="closeChart" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">
                            &times;
                        </button>

                        <div class="flex justify-between mb-4">
                            <button @click="prevPage()" class="button-primary px-3 py-1" :disabled="currentPage === 0">
                                Sebelumnya
                            </button>
                            <button @click="nextPage()" class="button-primary px-3 py-1"
                                :disabled="(currentPage + 1) * itemsPerPage >= maxMonths">
                                Berikutnya
                            </button>
                        </div>

                        <div id="growthChart" style="width: 100%; height: 300px;"></div>
                    </div>
                </div>
            </div>


            <script src="https://code.highcharts.com/highcharts.js"></script>

            <script>
                document.addEventListener('alpine:init', () => {
                    Alpine.data('chartHandler', () => ({
                        showGrowthChart: false,
                        currentChart: null,
                        chartTitle: '',
                        chartInstance: null,
                        currentPage: 0,
                        itemsPerPage: 6,
                        chartData: {},
                        maxMonths: 0,
                        pesertaId: null,

                        async fetchGrowthData(pesertaId) {
                            if (!pesertaId) {
                                console.error('Peserta ID tidak valid!');
                                return;
                            }
                            this.pesertaId = pesertaId;

                            try {
                                const response = await fetch(`/api/chart-data/${pesertaId}`);
                                if (!response.ok) {
                                    throw new Error(`HTTP error! status: ${response.status}`);
                                }
                                this.chartData = await response.json();
                                this.maxMonths = Math.max(
                                    this.chartData.tinggiBadan?.data.length || 0,
                                    this.chartData.beratBadan?.data.length || 0,
                                    this.chartData.lingkarKepala?.data.length || 0
                                );
                                console.log('Data berhasil dimuat:', this.chartData);
                            } catch (error) {
                                console.error('Gagal memuat data grafik:', error);
                            }
                        },

                        showChart(type) {
                            this.currentChart = type;
                            this.chartTitle = this.getChartTitle(type);
                            this.showGrowthChart = true;
                            this.$nextTick(() => this.initChart());
                        },

                        initChart() {
                            const chartEl = document.getElementById('growthChart');
                            const start = this.currentPage * this.itemsPerPage;
                            const end = start + this.itemsPerPage;
                            const chartConfig = this.chartData[this.currentChart];

                            if (!chartConfig) {
                                console.error('Data grafik tidak tersedia.');
                                return;
                            }

                            this.chartInstance = Highcharts.chart(chartEl, {
                                chart: {
                                    type: 'line',
                                    height: 300
                                },
                                title: {
                                    text: chartConfig.label
                                },
                                xAxis: {
                                    categories: this.generateLabels(start, end),
                                    title: {
                                        text: 'Usia (Bulan)'
                                    }
                                },
                                yAxis: {
                                    title: {
                                        text: 'Ukuran'
                                    }
                                },
                                series: [{
                                    name: chartConfig.label,
                                    data: chartConfig.data.slice(start, end)
                                }]
                            });
                        },

                        updateChart() {
                            const start = this.currentPage * this.itemsPerPage;
                            const end = start + this.itemsPerPage;
                            const chartConfig = this.chartData[this.currentChart];

                            if (this.chartInstance) {
                                this.chartInstance.xAxis[0].setCategories(this.generateLabels(start, end));
                                this.chartInstance.series[0].setData(chartConfig.data.slice(start, end));
                            }
                        },

                        nextPage() {
                            if ((this.currentPage + 1) * this.itemsPerPage < this.maxMonths) {
                                this.currentPage++;
                                this.updateChart();
                            }
                        },

                        prevPage() {
                            if (this.currentPage > 0) {
                                this.currentPage--;
                                this.updateChart();
                            }
                        },

                        closeChart() {
                            this.showGrowthChart = false;
                            if (this.chartInstance) {
                                this.chartInstance.destroy();
                                this.chartInstance = null;
                            }
                        },

                        generateLabels(start, end) {
                            return Array.from({
                                length: end - start
                            }, (_, i) => `Bulan ${start + i + 1}`);
                        },

                        getChartTitle(type) {
                            switch (type) {
                                case 'tinggiBadan':
                                    return 'Diagram Tinggi Badan';
                                case 'beratBadan':
                                    return 'Diagram Berat Badan';
                                case 'lingkarKepala':
                                    return 'Diagram Lingkar Kepala';
                                default:
                                    return 'Diagram Pertumbuhan';
                            }
                        },

                        init(pesertaId) {
                            this.fetchGrowthData(pesertaId);
                        }
                    }));
                });
            </script>


            {{-- <div x-data="chartHandler">
            <h3 class="text-2xl font-semibold text-gray-800 mt-8">Lihat Diagram Pertumbuhan</h3>
            <div class="flex flex-wrap justify-between gap-2 mt-4">
                <button @click="showChart('tinggiBadan')" class="button-primary rounded-lg flex-1 text-center px-4 py-2 text-sm">
                    Tinggi Badan
                </button>
                <button @click="showChart('beratBadan')" class="button-primary rounded-lg flex-1 text-center px-4 py-2 text-sm">
                    Berat Badan
                </button>
                <button @click="showChart('lingkarKepala')" class="button-primary rounded-lg flex-1 text-center px-4 py-2 text-sm">
                    Lingkar Kepala
                </button>
            </div>
        
            <!-- Modal Diagram -->
            <div x-show="showGrowthChart" x-cloak @click.away="closeChart"
                class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center z-50" x-transition>
                <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-lg relative">
                    <h3 class="text-xl font-bold mb-4" x-text="chartTitle"></h3>
                    <button @click="closeChart" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">
                        &times;
                    </button>
        
                    <div class="flex justify-between mb-4">
                        <button @click="prevPage()" class="button-primary px-3 py-1" :disabled="currentPage === 0">
                            Sebelumnya
                        </button>
                        <button @click="nextPage()" class="button-primary px-3 py-1"
                            :disabled="(currentPage + 1) * itemsPerPage >= maxMonths">
                            Berikutnya
                        </button>
                    </div>
        
                    <div id="growthChart" style="width: 100%; height: 300px;"></div>
                </div>
            </div>
        </div>
        
        <script src="https://code.highcharts.com/highcharts.js"></script>
        
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('chartHandler', () => ({
                    showGrowthChart: false, // State untuk menampilkan modal grafik
                    currentChart: null, // Menyimpan tipe grafik saat ini
                    chartTitle: '', // Judul grafik
                    chartInstance: null, // Instance Highcharts untuk kontrol grafik
                    currentPage: 0, // Halaman data saat ini untuk pagination
                    itemsPerPage: 6, // Jumlah data per halaman
                    chartData: {}, // Data untuk grafik, diisi dengan data dummy
        
                    // Data dummy untuk grafik
                    initializeDummyData() {
                        this.chartData = {
                            tinggiBadan: {
                                label: 'Tinggi Badan (cm)',
                                data: [48, 50, 52, 54, 56, 58, 60, 62, 64, 66, 68, 70]
                            },
                            beratBadan: {
                                label: 'Berat Badan (kg)',
                                data: [3.2, 3.5, 4.0, 4.5, 5.0, 5.5, 6.0, 6.5, 7.0, 7.5, 8.0, 8.5]
                            },
                            lingkarKepala: {
                                label: 'Lingkar Kepala (cm)',
                                data: [32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43]
                            }
                        };
                    },
        
                    // Fungsi untuk menampilkan grafik berdasarkan tipe
                    showChart(type) {
                        console.log(`Chart ${type} dipanggil`);
                        this.currentChart = type;
                        this.chartTitle = this.getChartTitle(type);
                        this.showGrowthChart = true;
        
                        this.$nextTick(() => this.initChart());
                    },
        
                    closeChart() {
                        this.showGrowthChart = false;
                        if (this.chartInstance) {
                            this.chartInstance.destroy(); // Hapus instance Highcharts
                            this.chartInstance = null;
                        }
                    },
        
                    nextPage() {
                        const totalData = this.chartData[this.currentChart]?.data.length || 0;
                        if ((this.currentPage + 1) * this.itemsPerPage < totalData) {
                            this.currentPage++;
                            this.updateChart();
                        }
                    },
        
                    prevPage() {
                        if (this.currentPage > 0) {
                            this.currentPage--;
                            this.updateChart();
                        }
                    },
        
                    async initChart() {
                        const chartEl = document.getElementById('growthChart');
                        const start = this.currentPage * this.itemsPerPage;
                        const end = start + this.itemsPerPage;
                        const chartConfig = this.chartData[this.currentChart];
        
                        // Pastikan data ada sebelum inisialisasi grafik
                        if (!chartConfig) {
                            console.error('Chart data is not available');
                            return;
                        }
        
                        // Inisialisasi Highcharts
                        this.chartInstance = Highcharts.chart(chartEl, {
                            chart: { type: 'line', height: 300 },
                            title: { text: chartConfig.label },
                            xAxis: {
                                categories: this.generateLabels(start, end),
                                title: { text: 'Usia (Bulan)' }
                            },
                            yAxis: {
                                title: { text: 'Ukuran' }
                            },
                            series: [
                                {
                                    name: chartConfig.label,
                                    data: chartConfig.data.slice(start, end)
                                }
                            ]
                        });
                    },
        
                    updateChart() {
                        const start = this.currentPage * this.itemsPerPage;
                        const end = start + this.itemsPerPage;
                        const chartConfig = this.chartData[this.currentChart];
        
                        if (this.chartInstance) {
                            this.chartInstance.xAxis[0].setCategories(this.generateLabels(start, end));
                            this.chartInstance.series[0].setData(chartConfig.data.slice(start, end));
                        }
                    },
        
                    generateLabels(start, end) {
                        return Array.from({ length: end - start }, (_, i) => `Bulan ${start + i + 1}`);
                    },
        
                    getChartTitle(type) {
                        switch (type) {
                            case 'tinggiBadan':
                                return 'Diagram Tinggi Badan';
                            case 'beratBadan':
                                return 'Diagram Berat Badan';
                            case 'lingkarKepala':
                                return 'Diagram Lingkar Kepala';
                            default:
                                return 'Diagram Pertumbuhan';
                        }
                    },
        
                    // Inisialisasi data dummy ketika komponen dimuat
                    init() {
                        this.initializeDummyData();
                    }
                }));
            });
        </script> --}}



            <!-- Tabel Imunisasi -->
            <div class="mb-6">
                <h3 class="text-2xl font-semibold text-gray-800 mt-8">Tabel Imunisasi</h3>
                <table class="w-full mt-4 bg-white shadow rounded-lg overflow-hidden text-gray-900 text-base">
                    <thead class="bg-[#008eb5] text-white">
                        <tr>
                            <th class="py-3 px-4 text-left font-medium">Jenis Imunisasi</th>
                            <th class="py-3 px-4 text-left font-medium">Tanggal Pemberian</th>
                            <th class="py-3 px-4 text-left font-medium">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($imunisasiData as $item)
                            <tr>
                                <td>{{ $item['jenis_imunisasi'] }}</td>
                                <td>{{ $item['tanggal'] }}</td>
                                <td>{{ $item['keterangan_imunisasi'] }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3">Data tidak ditemukan untuk imunisasi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Tabel Pemberian Obat Cacing -->
            <div class="mb-6">
                <h3 class="text-2xl font-semibold text-gray-800">Tabel Pemberian Obat Cacing</h3>
                <table class="w-full mt-4 bg-white shadow rounded-lg overflow-hidden text-gray-900 text-base">
                    <thead class="bg-[#008eb5] text-white">
                        <tr>
                            <th class="py-3 px-4 text-left font-medium">Tanggal Pemberian</th>
                            <th class="py-3 px-4 text-left font-medium">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($obatCacingData as $item)
                            <tr>
                                <td>{{ $item['tanggal'] }}</td>
                                <td>{{ $item['keterangan_obat_cacing'] }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2">Data tidak ditemukan untuk pemberian obat cacing.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Tabel Pemberian Bantuan Susu -->
            <div class="mb-6">
                <h3 class="text-2xl font-semibold text-gray-800">Tabel Pemberian Bantuan Susu</h3>
                <table class="w-full mt-4 bg-white shadow rounded-lg overflow-hidden text-gray-900 text-base">
                    <thead class="bg-[#008eb5] text-white">
                        <tr>
                            <th class="py-3 px-4 text-left font-medium">Tanggal Pemberian</th>
                            <th class="py-3 px-4 text-left font-medium">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($susuData as $item)
                            <tr>
                                <td>{{ $item['tanggal'] }}</td>
                                <td>{{ $item['keterangan_susu'] }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2">Data tidak ditemukan untuk pemberian bantuan susu.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>


            <!-- Tabel Keluhan -->
            <div class="mb-6">
                <h3 class="text-2xl font-semibold text-gray-800">Tabel Keluhan</h3>
                <table class="w-full mt-4 bg-white shadow rounded-lg overflow-hidden text-gray-900 text-base">
                    <thead class="bg-[#008eb5] text-white">
                        <tr>
                            <th class="py-3 px-4 text-left font-medium">Tanggal</th>
                            <th class="py-3 px-4 text-left font-medium">Keluhan</th>
                            <th class="py-3 px-4 text-left font-medium">Penanganan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($keluhanData as $item)
                            <tr>
                                <td>{{ $item['tanggal'] }}</td>
                                <td>{{ $item['keluhan'] }}</td>
                                <td>{{ $item['penanganan'] }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2">Data tidak ditemukan untuk pemberian bantuan susu.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
    </body>

</html>
