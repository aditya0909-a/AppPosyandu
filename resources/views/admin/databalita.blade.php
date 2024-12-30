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

    <div class=" p-5" style="background-color: #FFFFFF; padding-top: 100px;">
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


            <script src="https://code.highcharts.com/highcharts.js"></script>
            <script src="https://code.highcharts.com/modules/series-label.js"></script>
            <script src="https://code.highcharts.com/modules/exporting.js"></script>


            <div x-data="chartHandler" x-init="init({{ $PesertaPosyanduBalita->id }})">
                <h3 class="text-2xl font-semibold text-gray-800 mt-8">Lihat Diagram Pertumbuhan</h3>

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
                    <button @click="showChart('lingkarKepala')"
                        class="button-primary rounded-lg flex-1 text-center px-4 py-2 text-sm hover:opacity-90 transition-opacity">
                        Lingkar Kepala
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
                        showGrowthChart: false,
                        currentChart: null,
                        chartTitle: '',
                        chartInstance: null,
                        currentPage: 0,
                        itemsPerPage: 6,
                        chartData: {},
                        maxMonths: 0,
                        pesertaId: null,
                        error: null,
                        isLoading: false,

                        async fetchGrowthData(pesertaId) {
                            if (!pesertaId) {
                                this.error = 'ID Peserta tidak valid!';
                                return;
                            }

                            this.isLoading = true;
                            this.error = null;

                            try {
                                const response = await fetch(/api/chart-data/${pesertaId});
                                const data = await response.json();

                                if (!response.ok) {
                                    throw new Error(data.error || 'Terjadi kesalahan saat memuat data');
                                }

                                if (!data || !data.metadata) {
                                    throw new Error('Format data tidak valid');
                                }

                                this.chartData = data;
                                this.maxMonths = data.metadata.totalMonths;

                            } catch (error) {
                                this.error = error.message || 'Gagal memuat data grafik';
                                console.error('Error:', error);
                            } finally {
                                this.isLoading = false;
                            }
                        },

                        showChart(type) {
                            this.currentChart = type;
                            this.chartTitle = this.getChartTitle(type);
                            this.currentPage = 0; // Reset to first page
                            this.showGrowthChart = true;
                            this.$nextTick(() => this.initChart());
                        },

                        initChart() {
                            const chartEl = document.getElementById('growthChart');
                            const start = this.currentPage * this.itemsPerPage;
                            const end = start + this.itemsPerPage;
                            const chartConfig = this.chartData[this.currentChart];

                            // Validasi jika konfigurasi atau data tidak tersedia
                            if (!chartConfig || !chartConfig.data || !chartConfig.data.length) {
                                this.error = 'Data grafik tidak tersedia';
                                return;
                            }

                            // Transformasi data menjadi format yang sesuai dengan Highcharts
                            const formattedData = chartConfig.data
                                .slice(start, end)
                                .map((value, index) => ({
                                    x: index + 1, // Bulan ke- (dimulai dari 1)
                                    y: value !== null ? parseFloat(value) || 0 :
                                    0, // Ganti null menjadi 0
                                    bulan_ke: index + 1 // Menyimpan info bulan ke-
                                }));

                            // Konfigurasi Highcharts
                            const options = {
                                chart: {
                                    type: 'line',
                                    height: 300,
                                    style: {
                                        fontFamily: 'inherit'
                                    },
                                    zoomType: 'xy' // Mengaktifkan zoom pada grafik
                                },
                                title: {
                                    text: chartConfig.label
                                },
                                xAxis: {
                                    title: {
                                        text: 'Usia (Bulan)'
                                    },
                                    // BENAR
                                    labels: {
                                        formatter: function() {
                                            return Bulan ${this.value};
                                        }
                                    }
                                },
                                yAxis: {
                                    title: {
                                        text: chartConfig.label
                                    },
                                    min: Math.min(...chartConfig.data.filter(d => d !== null)) ||
                                        0, // Nilai minimum
                                    max: Math.max(...chartConfig.data.filter(d => d !== null)) ||
                                        100 // Nilai maksimum (default)
                                },
                                tooltip: {
                                    formatter: function() {
                                        const point = this.point;
                                        return `<b>Bulan ke-${point.bulan_ke}</b><br/>
                        ${this.series.name}: <b>${point.y}</b>`;
                                    },
                                    style: {
                                        padding: '10px'
                                    }
                                },
                                series: [{
                                    name: chartConfig.label,
                                    data: formattedData,
                                    lineWidth: 2,
                                    marker: {
                                        enabled: true,
                                        radius: 6,
                                        symbol: 'circle',
                                        states: {
                                            hover: {
                                                enabled: true,
                                                radius: 8
                                            }
                                        }
                                    },
                                    states: {
                                        hover: {
                                            lineWidth: 3
                                        }
                                    },
                                    point: {
                                        events: {
                                            // Event klik untuk menampilkan informasi detail
                                            click: function() {
                                                const point = this;
                                                Swal.fire({
                                                    title: Detail Bulan ke-${point.bulan_ke},


                                                    html: `
                                <div class="text-left">
                                    <p class="mb-2"><strong>Bulan:</strong> ${point.bulan_ke}</p>
                                    <p class="mb-2"><strong>Nilai:</strong> ${point.y}</p>
                                    <p class="mb-2"><strong>Status:</strong> ${this.series.name}</p>
                                </div>
                            `,
                                                    icon: 'info',
                                                    confirmButtonText: 'Tutup'
                                                });
                                            }
                                        }
                                    }
                                }],
                                plotOptions: {
                                    line: {
                                        connectNulls: true, // Sambungkan garis meskipun ada nilai null
                                        animation: {
                                            duration: 1000
                                        },
                                        cursor: 'pointer',
                                        dataLabels: {
                                            enabled: true,
                                            formatter: function() {
                                                return this.y;
                                            }
                                        }
                                    }
                                },
                                credits: {
                                    enabled: false
                                },
                                legend: {
                                    enabled: false
                                }
                            };

                            // Inisialisasi grafik menggunakan Highcharts
                            this.chartInstance = Highcharts.chart(chartEl, options);
                        },
                        updateChart() {
                            if (!this.chartInstance || !this.chartData[this.currentChart]) return;

                            const start = this.currentPage * this.itemsPerPage;
                            const end = start + this.itemsPerPage;
                            const chartConfig = this.chartData[this.currentChart];

                            this.chartInstance.xAxis[0].setCategories(this.generateLabels(start, end));
                            this.chartInstance.series[0].setData(chartConfig.data.slice(start, end));
                        },

                        get totalPages() {
                            return Math.ceil(this.maxMonths / this.itemsPerPage);
                        },

                        getCurrentStats() {
                            const chartConfig = this.chartData[this.currentChart] || {};
                            return {
                                min: chartConfig.min?.toFixed(1) || '0',
                                max: chartConfig.max?.toFixed(1) || '0'
                            };
                        },

                        formatLastUpdated() {
                            if (!this.chartData.metadata?.lastUpdated) return '-';
                            return new Date(this.chartData.metadata.lastUpdated).toLocaleDateString('id-ID', {
                                year: 'numeric',
                                month: 'long',
                                day: 'numeric',
                                hour: '2-digit',
                                minute: '2-digit'
                            });
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
                            }, (_, i) => Bulan ${start + i + 1});
                        },
                        getChartTitle(type) {
                            const titles = {
                                tinggiBadan: 'Diagram Tinggi Badan',
                                beratBadan: 'Diagram Berat Badan',
                                lingkarKepala: 'Diagram Lingkar Kepala'
                            };
                            return titles[type] || 'Diagram Pertumbuhan';
                        },

                        init(pesertaId) {
                            if (pesertaId) {
                                this.fetchGrowthData(pesertaId);
                            }
                        }
                    }));
                });
            </script>



            <!-- Tabel Imunisasi -->
            <div class="mb-6">
                <h3 class="text-2xl font-semibold text-gray-800 mt-8">Tabel Imunisasi</h3>
                <table class="w-full mt-4 bg-white shadow rounded-lg overflow-hidden text-gray-900 text-base">
                    <thead class="bg-[#008eb5] text-white">
                        <tr>
                            <th class="py-3 px-4 text-left font-medium">Jenis Imunisasi</th>
                            <th class="py-3 px-4 text-left font-medium">Tanggal Pemberian</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($imunisasiData as $item)
                            <tr>
                                <td>{{ $item['jenis_imunisasi'] }}</td>
                                <td>{{ $item['tanggal'] }}</td>
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

            <!-- Tabel Pemberian Vitamin -->
            <div class="mb-6">
                <h3 class="text-2xl font-semibold text-gray-800">Tabel Pemberian Vitamin</h3>
                <table class="w-full mt-4 bg-white shadow rounded-lg overflow-hidden text-gray-900 text-base">
                    <thead class="bg-[#008eb5] text-white">
                        <tr>
                            <th class="py-3 px-4 text-left font-medium">Tanggal Pemberian</th>
                            <th class="py-3 px-4 text-left font-medium">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($vitaminData as $item)
                            <tr>
                                <td>{{ $item['tanggal'] }}</td>
                                <td>{{ $item['keterangan_vitamin'] }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2">Data tidak ditemukan untuk pemberian Vitamin.</td>
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
        </div>

</body>

</html>