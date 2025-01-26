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
            <button onclick="history.back()" class="text-[#0077B5] mr-4">
                &larr; Back
            </button>            
            <a href="#" class="text-2xl font-bold text-[#0077B5]">Posyandu</a>
            <div class="ml-auto text-[#0077B5] font-sans">Akun Admin</div>
        </div>
    </nav>

    <div class=" p-5" style="background-color: #FFFFFF; padding-top: 100px;">
        <div x-data="{ showGrowthChart: false }">

            <div x-data="{ open: false }" class="max-w-4xl mx-auto mt-8 card">
                <!-- Card Header -->
                <div class="card-header">
                    <h2 class="text-2xl font-semibold ">Data Peserta</h2>
                    <h2 class="text-2xl font-semibold">Posyandu Lansia</h2>
                </div>

                <!-- Card Body -->
                <div class="p-6">
                    <!-- Keterangan Kegiatan -->
                    <div class="mb-6">
                        <div class="text-lg text-black font-semibold">Nama Lengkap</div>
                        <span class="font-normal">{{ $PesertaPosyanduLansia->nama_peserta_lansia }}</span>
                        <div class="text-lg text-black font-semibold mt-2">Tempat Lahir</div>
                        <span class="font-normal">{{ $PesertaPosyanduLansia->TempatLahir_lansia }}</span>
                        <div class="text-lg text-black font-semibold mt-2">Tanggal Lahir</div>
                        <span class="font-normal">{{ $PesertaPosyanduLansia->TanggalLahir_lansia }}</span>
                        <div class="text-lg text-black font-semibold mt-2">NIK Lansia</div>
                        <span class="font-normal">{{ $PesertaPosyanduLansia->NIK_lansia }}</span>
                        <div class="text-lg text-black font-semibold mt-2">Alamat Lansia</div>
                        <span class="font-normal">{{ $PesertaPosyanduLansia->alamat_lansia }}</span>
                        <div class="text-lg text-black font-semibold mt-2">Nomor WhatsApp</div>
                        <span class="font-normal">{{ $PesertaPosyanduLansia->wa_lansia }}</span>
                    </div>
                </div>
            </div>


            <script src="https://code.highcharts.com/highcharts.js"></script>
            <script src="https://code.highcharts.com/modules/series-label.js"></script>
            <script src="https://code.highcharts.com/modules/exporting.js"></script>
            <script src="https://code.highcharts.com/modules/export-data.js"></script>
            <script src="https://code.highcharts.com/modules/accessibility.js"></script>


            <div x-data="chartHandler" x-init="init({{ $PesertaPosyanduLansia->id }})">
                <h3 class="text-2xl font-semibold text-gray-800 mt-8">Lihat Diagram Perubahan Lansia</h3>

                <!-- Error Alert -->
                <div x-show="error"
                    class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mt-4"
                    role="alert">
                    <span x-text="error" class="block sm:inline"></span>
                </div>

                <!-- Loading State -->
                <div x-show="isLoading" class="flex justify-center items-center py-4">
                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-gray-900"></div>
                </div>

                <!-- Chart Buttons -->
                <div x-show="!isLoading && !error" class="flex flex-wrap justify-between gap-2 mt-4">
                    <button @click="showChart('tinggiBadan')"
                        class="button-primary rounded-lg flex-1 text-center px-4 py-2 text-sm hover:opacity-90 transition-opacity">
                        Tinggi Badan
                    </button>
                    <button @click="showChart('beratBadan')"
                        class="button-primary rounded-lg flex-1 text-center px-4 py-2 text-sm hover:opacity-90 transition-opacity">
                        Berat Badan
                    </button>
                    <button @click="showChart('lingkarLengan')"
                        class="button-primary rounded-lg flex-1 text-center px-4 py-2 text-sm hover:opacity-90 transition-opacity">
                        Lingkar Lengan
                    </button>
                    <button @click="showChart('lingkarPerut')"
                        class="button-primary rounded-lg flex-1 text-center px-4 py-2 text-sm hover:opacity-90 transition-opacity">
                        Lingkar Perut
                    </button>
                </div>

                <!-- Modal Diagram -->
                <div x-show="showGrowthChart" x-cloak @click.away="closeChart"
                    class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center z-50" x-transition>
                    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-lg relative" @click.stop>
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-xl font-bold" x-text="chartTitle"></h3>
                            <button @click="closeChart"
                                class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
                        </div>

                        <!-- Chart Stats -->
                        <div class="grid grid-cols-2 gap-4 mb-4 text-sm">
                            <div class="bg-gray-50 p-2 rounded">
                                <span class="font-semibold">Nilai Terendah:</span>
                                <span x-text="getCurrentStats().min"></span>
                            </div>
                            <div class="bg-gray-50 p-2 rounded">
                                <span class="font-semibold">Nilai Tertinggi:</span>
                                <span x-text="getCurrentStats().max"></span>
                            </div>
                        </div>

                        <!-- Pagination -->
                    <div class="flex justify-between items-center mb-4">
                            <button @click="prevPage()"
                                class="button-primary px-3 py-1 disabled:opacity-50 disabled:cursor-not-allowed"
                                :disabled="currentPage === 0">
                                Sebelumnya
                            </button>
                            <span class="text-sm">
                                Halaman <span x-text="currentPage + 1"></span> dari <span x-text="totalPages"></span>
                            </span>
                            <button @click="nextPage()"
                                class="button-primary px-3 py-1 disabled:opacity-50 disabled:cursor-not-allowed"
                                :disabled="(currentPage + 1) * itemsPerPage >= maxMonths">
                                Berikutnya
                            </button>
                        </div>

                        <div id="growthChart" style="width: 100%; height: 300px;"></div>

                        <!-- Last Updated -->
                        <div class="text-right text-sm text-gray-500 mt-2">
                            Terakhir diperbarui: <span x-text="formatLastUpdated()"></span>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                document.addEventListener('alpine:init', () => {
                    Alpine.data('chartHandler', () => ({
                        // State Management
                        showGrowthChart: false,
                        currentChart: null,
                        chartTitle: '',
                        chartInstance: null,
                        currentPage: 0,
                        itemsPerPage: 6,
                        chartData: {
                            labels: [],
                            tinggiBadan: { data: [] },
                            beratBadan: { data: [] },
                            lingkarLengan: { data: [] },
                            lingkarPerut: { data: [] },
                        },
                        pesertaId: null,
                        error: null,
                        isLoading: false,
            
                        // Fetch Data from API
                        async fetchGrowthData(pesertaId) {
                            if (!pesertaId) {
                                this.error = 'ID Peserta tidak valid!';
                                return;
                            }
            
                            this.isLoading = true;
                            this.error = null;
            
                            try {
                                const response = await fetch(`/api/chart-data-lansia/${pesertaId}`);
                                const data = await response.json();
            
                                if (!response.ok) {
                                    throw new Error(data.error || 'Terjadi kesalahan saat memuat data');
                                }
            
                                // Validate Data Structure
                                if (!data.labels || !Array.isArray(data.labels) ||
                                    !data.tinggiBadan || !Array.isArray(data.tinggiBadan.data) ||
                                    !data.beratBadan || !Array.isArray(data.beratBadan.data)) {
                                    throw new Error('Format data tidak valid');
                                }
            
                                this.chartData = data;
                                console.log('Data fetched:', data); // Debugging
            
                            } catch (error) {
                                this.error = error.message || 'Gagal memuat data grafik';
                                console.error('Error:', error);
                            } finally {
                                this.isLoading = false;
                            }
                        },
            
                        // Show Chart Modal
                        showChart(type) {
                            this.currentChart = type;
                            this.chartTitle = this.getChartTitle(type);
                            this.currentPage = 0; // Reset to first page
                            this.showGrowthChart = true;
                            this.$nextTick(() => this.initChart());
                        },
            
                        // Initialize Chart
                        initChart() {
                            const chartEl = document.getElementById('growthChart');
                            if (!chartEl) {
                                this.error = 'Elemen grafik tidak ditemukan';
                                return;
                            }
            
                            const chartConfig = this.chartData[this.currentChart];
                            if (!chartConfig || !chartConfig.data || !chartConfig.data.length) {
                                this.error = 'Data grafik tidak tersedia';
                                return;
                            }
            
                            try {
                                const options = {
                                    chart: { type: 'line', height: 300 },
                                    title: { text: chartConfig.label },
                                    xAxis: {
                                        categories: this.chartData.labels.slice(0, this.itemsPerPage),
                                        title: { text: 'Bulan-Tahun' },
                                    },
                                    yAxis: {
                                        title: { text: chartConfig.label },
                                        min: Math.min(...chartConfig.data.filter(d => d !== null)) || 0,
                                        max: Math.max(...chartConfig.data.filter(d => d !== null)) || 100,
                                    },
                                    tooltip: {
                                        formatter: function () {
                                            return `<b>${this.x}</b><br/>${this.series.name}: <b>${this.y}</b>`;
                                        },
                                    },
                                    series: [{
                                        name: chartConfig.label,
                                        data: chartConfig.data.slice(0, this.itemsPerPage),
                                    }],
                                    credits: { enabled: false },
                                };
            
                                this.chartInstance = Highcharts.chart(chartEl, options);
                            } catch (error) {
                                console.error('Error initializing chart:', error);
                                this.error = 'Gagal memuat grafik';
                            }
                        },
            
                        // Update Chart Pagination
                        updateChart() {
                            if (!this.chartInstance || !this.chartData[this.currentChart]) return;
            
                            const start = this.currentPage * this.itemsPerPage;
                            const end = start + this.itemsPerPage;
                            const chartConfig = this.chartData[this.currentChart];
            
                            this.chartInstance.xAxis[0].setCategories(this.chartData.labels.slice(start, end));
                            this.chartInstance.series[0].setData(chartConfig.data.slice(start, end));
                        },
            
                        nextPage() {
                            if ((this.currentPage + 1) * this.itemsPerPage < this.chartData.labels.length) {
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
            
                        // Helper Functions
                        getChartTitle(type) {
                            const titles = {
                                tinggiBadan: 'Diagram Tinggi Badan',
                                beratBadan: 'Diagram Berat Badan',
                                lingkarLengan: 'Diagram Lingkar Lengan',
                                lingkarPerut: 'Diagram Lingkar Perut',
                            };
                            return titles[type] || 'Diagram Pertumbuhan';
                        },
            
                        getCurrentStats() {
                            const chartConfig = this.chartData[this.currentChart];
                            if (!chartConfig || !chartConfig.data || chartConfig.data.length === 0) {
                                return { min: 0, max: 0 };
                            }
                            const validData = chartConfig.data.filter(d => d !== null && d !== undefined);
                            return {
                                min: validData.length ? Math.min(...validData) : 0,
                                max: validData.length ? Math.max(...validData) : 0,
                            };
                        },
            
                        get totalPages() {
                            return Math.ceil(this.chartData.labels.length / this.itemsPerPage);
                        },
            
                        formatLastUpdated() {
                            const now = new Date();
                            return now.toLocaleDateString('id-ID', {
                                day: '2-digit',
                                month: 'long',
                                year: 'numeric',
                                hour: '2-digit',
                                minute: '2-digit',
                            });
                        },
            
                        // Initialize Component
                        init(pesertaId) {
                            if (pesertaId) {
                                this.fetchGrowthData(pesertaId);
                            }
                        },
                    }));
                });
            </script>
            
                

            <!-- Kondisi BMI -->
            <div class="mb-6">
                <h3 class="text-2xl font-semibold text-gray-800 mt-8">Kondisi BMI Lansia</h3>
                <table class="w-full mt-4 bg-white shadow rounded-lg overflow-hidden text-gray-900 text-base">
                    <thead class="bg-[#008eb5] text-white">
                        <tr>
                            <th class="py-3 px-4 text-left font-medium">Nilai BMI</th>
                            <th class="py-3 px-4 text-left font-medium">Kategori</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <tr>
                            <td>{{ $bmi ?? 'Data tidak valid' }}</td>
                            <td>{{ $category ?? 'Data tidak valid' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Rentang BMI -->
            <div class="mt-4 text-sm text-gray-600">
                <p><strong>Rentang Nilai BMI:</strong></p>
                <div class="flex justify-between">
                    <ul class="list-disc pl-5">
                        <li><strong>Kurus</strong>: < 18.5</li>
                        <li><strong>Normal</strong>: 18.5 - 24.9</li>
                    </ul>
                    <ul class="list-disc pl-5">
                        <li><strong>Overweight</strong>: 25 - 29.9</li>
                        <li><strong>Obesitas</strong>: ≥ 30</li>
                    </ul>
                </div>
            </div>

            <!-- Tabel Tes Gula Darah dan Tensi -->
            <div class="mb-6">
                <h3 class="text-2xl font-semibold text-gray-800 mt-8">Gula Darah dan Tensi</h3>
                <table class="w-full mt-4 bg-white shadow rounded-lg overflow-hidden text-gray-900 text-base">
                    <thead class="bg-[#008eb5] text-white">
                        <tr>
                            <th class="py-3 px-4 text-left font-medium">Tanggal</th>
                            <th class="py-3 px-4 text-left font-medium">Gula Darah</th>
                            <th class="py-3 px-4 text-left font-medium">Tensi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($GCUData as $item)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($item['tanggal'])->locale('id')->format('Y/m/d') }}</td>
                                <td>{{ $item['guladarah'] }} mg/dL</td>
                                <td>{{ $item['tensi'] }} mmHg</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3">Data tidak ditemukan untuk imunisasi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Tabel Tes Asam Urat dan Kolesterol -->
            <div class="mb-6">
                <h3 class="text-2xl font-semibold text-gray-800 mt-8">Kolesterol dan Asam Urat</h3>
                <table class="w-full mt-4 bg-white shadow rounded-lg overflow-hidden text-gray-900 text-base">
                    <thead class="bg-[#008eb5] text-white">
                        <tr>
                            <th class="py-3 px-4 text-left font-medium">Tanggal</th>
                            <th class="py-3 px-4 text-left font-medium">Kolesterol</th>
                            <th class="py-3 px-4 text-left font-medium">Asam Urat</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($GCUData as $item)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($item['tanggal'])->locale('id')->format('Y/m/d') }}</td>
                                <td>{{ $item['kolesterol'] }} mg/dL</td>
                                <td>{{ $item['asamurat'] }} mg/dL</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3">Data tidak ditemukan untuk imunisasi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Tabel Tes Kognitif -->
            <div class="mb-6">
                <h3 class="text-2xl font-semibold text-gray-800 mt-8">Tes Kognitif</h3>
                <table class="w-full mt-4 bg-white shadow rounded-lg overflow-hidden text-gray-900 text-base">
                    <thead class="bg-[#008eb5] text-white">
                        <tr>
                            <th class="py-3 px-4 text-left font-medium">Tanggal</th>
                            <th class="py-3 px-4 text-left font-medium">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($KognitifData as $item)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($item['tanggal'])->locale('id')->format('Y/m/d') }}</td>
                                <td>{{ $item['keterangan_kognitif'] }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3">Data tidak ditemukan untuk imunisasi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Tabel Tes Kognitif -->
            <div class="mb-6">
                <h3 class="text-2xl font-semibold text-gray-800 mt-8">Tes Mobilisasi</h3>
                <table class="w-full mt-4 bg-white shadow rounded-lg overflow-hidden text-gray-900 text-base">
                    <thead class="bg-[#008eb5] text-white">
                        <tr>
                            <th class="py-3 px-4 text-left font-medium">Tanggal</th>
                            <th class="py-3 px-4 text-left font-medium">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($MobilisasiData as $item)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($item['tanggal'])->locale('id')->format('Y/m/d') }}</td>
                                <td>{{ $item['keterangan_mobilisasi'] }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3">Data tidak ditemukan untuk imunisasi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Tabel Tes Malnutrisi -->
            <div class="mb-6">
                <h3 class="text-2xl font-semibold text-gray-800 mt-8">Indikasi Malnutrisi</h3>
                <table class="w-full mt-4 bg-white shadow rounded-lg overflow-hidden text-gray-900 text-base">
                    <thead class="bg-[#008eb5] text-white">
                        <tr>
                            <th class="py-3 px-4 text-left font-medium">Tanggal</th>
                            <th class="py-3 px-4 text-left font-medium">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($MalnutrisiData as $item)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($item['tanggal'])->locale('id')->format('Y/m/d') }}</td>
                                <td>{{ $item['keterangan_malnutrisi'] }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3">Data tidak ditemukan untuk imunisasi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Indikasi Malnutrisi -->
            <div class="mt-4 text-sm text-gray-600">
                <p><strong>Indikasi Malnutrisi:</strong></p>
                <div class="flex justify-between">
                    <ul class="list-disc pl-5">
                        <li>Berat badan berkurang lebih dari 3 kilo dalam 3 bulan terakhir</li>
                        <li>Hilangnya nafsu makan</li>
                        <li>Lingkar lengan atas kurang dari 21 cm</li>
                    </ul>
                </div>
            </div>

            <!-- Tabel Tes Penglihatan -->
            <div class="mb-6">
                <h3 class="text-2xl font-semibold text-gray-800 mt-8">Tes Lihat</h3>
                <table class="w-full mt-4 bg-white shadow rounded-lg overflow-hidden text-gray-900 text-base">
                    <thead class="bg-[#008eb5] text-white">
                        <tr>
                            <th class="py-3 px-4 text-left font-medium">Tanggal</th>
                            <th class="py-3 px-4 text-left font-medium">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($LihatData as $item)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($item['tanggal'])->locale('id')->format('Y/m/d') }}</td>
                                <td>{{ $item['keterangan_lihat'] }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3">Data tidak ditemukan untuk imunisasi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Tabel Tes Pendengaran  -->
            <div class="mb-6">
                <h3 class="text-2xl font-semibold text-gray-800 mt-8">Tes Dengar</h3>
                <table class="w-full mt-4 bg-white shadow rounded-lg overflow-hidden text-gray-900 text-base">
                    <thead class="bg-[#008eb5] text-white">
                        <tr>
                            <th class="py-3 px-4 text-left font-medium">Tanggal</th>
                            <th class="py-3 px-4 text-left font-medium">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($DengarData as $item)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($item['tanggal'])->locale('id')->format('Y/m/d') }}</td>
                                <td>{{ $item['keterangan_dengar'] }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3">Data tidak ditemukan untuk imunisasi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Tabel Tes Depresi -->
            <div class="mb-6">
                <h3 class="text-2xl font-semibold text-gray-800 mt-8">Indikasi Depresi</h3>
                <table class="w-full mt-4 bg-white shadow rounded-lg overflow-hidden text-gray-900 text-base">
                    <thead class="bg-[#008eb5] text-white">
                        <tr>
                            <th class="py-3 px-4 text-left font-medium">Tanggal</th>
                            <th class="py-3 px-4 text-left font-medium">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($DepresiData as $item)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($item['tanggal'])->locale('id')->format('Y/m/d') }}</td>
                                <td>{{ $item['keterangan_depresi'] }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3">Data tidak ditemukan untuk imunisasi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>



           
</body>

</html>
