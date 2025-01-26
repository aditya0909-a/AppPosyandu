<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Petugas</title>
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
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 20px;
            transition: transform 0.2s;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .modal-bg {
            background-color: rgba(0, 0, 0, 0.5);
        }

        
    </style>
</head>

<body>

    @if (session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
            class="fixed z-50 max-w-md mb-4 shadow-lg top-20 right-4 glass-effect" role="alert">
            <div class="flex items-center gap-2">
                <span class="font-medium text-green-800">{{ session('success') }}</span>
                <button @click="show = false" class="p-1 ml-auto text-green-500 hover:bg-green-200">
                    <span class="sr-only">Close</span>
                    &times;
                </button>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
            class="fixed z-50 max-w-md p-4 mb-4 bg-red-100 border border-red-200 rounded-lg shadow-lg top-20 right-4"
            role="alert">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="text-sm font-medium text-red-800">{{ session('error') }}</span>
                <button @click="show = false"
                    class="ml-auto rounded-lg p-1.5 text-red-500 hover:bg-red-200 inline-flex h-8 w-8 items-center justify-center">
                    <span class="sr-only">Close</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    @endif

    <div>
        <nav class="fixed top-0 left-0 right-0 z-10 p-4 shadow-md navbar">
            <div class="container flex items-center mx-auto">
                <button onclick="window.location.href = '/dashboard/petugas/{{ $userId }}'" class="text-[#0077B5] mr-4">
                    &larr; Back
                </button>
                <a href="#" class="text-2xl font-bold text-[#0077B5]">Posyandu</a>
                <div class="ml-auto text-[#0077B5] font-sans">Akun Petugas</div>
            </div>
        </nav>

        <div x-data="dashboardData">
            <!-- Pilihan Jadwal -->
            <div class="container px-4 mx-auto mt-6">
                <label for="jadwal" class="block mb-2 text-xl font-semibold">Pilih Jadwal Posyandu:</label>
                <select id="jadwal" x-model="selectedJadwal"
                    class="w-full p-3 mb-3 text-gray-800 bg-white border rounded-lg shadow-md">
                    <option value="" disabled selected>Pilih jadwal...</option>
                    <template x-for="jadwal in jadwalOptions" :key="jadwal.date">
                        <option :value="jadwal.date" x-text="jadwal.name + ' - ' + jadwal.location + ' (' + jadwal.formatted_date + ')'">
                        </option>
                        
                        
                    </template>
                </select>


                <!-- Dashboard Grid -->
                <section class="container px-2 py-6 mx-auto">
                    <div class="grid grid-cols-2 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                        <!-- Tampilkan item dashboard hanya jika jadwal cocok -->
                        <template x-for="item in filteredDashboardItems" :key="item.title">
                            <a
                                :href="`${item.link}/${(jadwalOptions.find(j => j.date === selectedJadwal)?.id) || ''}`"
                                class="block p-6 text-center text-white transition-transform transform rounded-lg shadow-lg button-primary hover:scale-105">
                                <img :src="item.image" alt="" class="w-16 h-16 mx-auto mb-4">
                                <h2 class="text-xl font-bold" x-text="item.title"></h2>
                                <p class="text-sm opacity-75" x-text="item.description"></p>
                            </a>
                        </template>
                    </div>
                </section>
                
            </div>
        </div>
        
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('dashboardData', () => ({
                    // Enum untuk nama Posyandu
                    posyanduTypes: {
                        BALITA: 'Posyandu Balita',
                        LANSIA: 'Posyandu Lansia'
                    },
        
                    // Jadwal yang dipilih
                    selectedJadwal: '',
        
                    jadwalOptions: [],
        
                    init() {
                        this.fetchJadwalOptions();
                    },
        
                    async fetchJadwalOptions() {
                        try {
                            const response = await fetch('/api/jadwal-options');
                            if (!response.ok) throw new Error('Gagal memuat jadwal');
        
                            const data = await response.json();
        
                            // Ambil jadwal hanya untuk hari ini
                            const today = new Date().toISOString().split('T')[0]; // Format: YYYY-MM-DD
                            this.jadwalOptions = (data.jadwalOptions || []).filter(jadwal => jadwal.date.startsWith(today));
                        } catch (error) {
                            this.errorMessage = 'Gagal memuat jadwal: ' + error.message;
                            console.error(error);
                        }
                    },
        
                    // Data item dashboard (tanpa properti jadwal)
                    dashboardItems: [
                        {
                            title: 'Pendaftaran',
                            description: 'Pendaftaran peserta kegiatan posyandu balita.',
                            image: '{{ asset('icons/register.png') }}', // URL gambar
                            link: '/pendaftaran/fiturposyandubalita/{{ $userId }}',
                            key: 'pendaftaran_balita'
                        },
                        {
                            title: 'Penimbangan',
                            description: 'Input data berat badan balita.',
                            image: '{{ asset('icons/weight.png') }}', // URL gambar
                            link: '/penimbangan/fiturposyandubalita/{{ $userId }}',
                            key: 'penimbangan_balita'
                        },
                        {
                            title: 'Pengukuran',
                            description: 'Input data tinggi badan dan lingkar kepala balita.',
                            image: '{{ asset('icons/height.png') }}', // URL gambar
                            link: '/pengukuran/fiturposyandubalita/{{ $userId }}',
                            key: 'pengukuran_balita'
                        },
                        {
                            title: 'Susu',
                            description: 'Checklist pemberian susu.',
                            image: '{{ asset('icons/milk.png') }}', // URL gambar
                            link: '/susu/fiturposyandubalita/{{ $userId }}',
                            key: 'susu'
                        },
                        {
                            title: 'Imunisasi',
                            description: 'Checklist pemberian imunisasi.',
                            image: '{{ asset('icons/injection.png') }}', // URL gambar
                            link: '/imunisasi/fiturposyandubalita/{{ $userId }}',
                            key: 'imunisasi'
                        },
                        {
                            title: 'Pemberian Obat Cacing',
                            description: 'Checklist pemberian obat cacing.',
                            image: '{{ asset('icons/obatcacing.png') }}', // URL gambar
                            link: '/obatcacing/fiturposyandubalita/{{ $userId }}',
                            key: 'obatcacing'
                        },
                        {
                            title: 'Pendaftaran',
                            description: 'Pendaftaran peserta kegiatan posyandu lansia.',
                            image: '{{ asset('icons/register.png') }}', // URL gambar
                            link: '/pendaftaran/fiturposyandulansia/{{ $userId }}',
                            key: 'pendaftaran_lansia'
                        },
                        {
                            title: 'Penimbangan',
                            description: 'Input data berat badan lansia.',
                            image: '{{ asset('icons/weight.png') }}', // URL gambar
                            link: '/penimbangan/fiturposyandulansia/{{ $userId }}',
                            key: 'penimbangan_lansia'
                        },
                        {
                            title: 'Pengukuran',
                            description: 'Input data tinggi badan, lingkar perut dan lingkar lengan lansia.',
                            image: '{{ asset('icons/height.png') }}', // URL gambar
                            link: '/pengukuran/fiturposyandulansia/{{ $userId }}',
                            key: 'pengukuran_lansia'
                        },
                        {
                            title: 'Tes Kognitif',
                            description: 'Kuisioner tes kemampuan kognitif dan gejala depresi lansia.',
                            image: '{{ asset('icons/idea.png') }}', // URL gambar
                            link: '/teskognitif/fiturposyandulansia/{{ $userId }}',
                            key: 'teskognitif'
                        },
                        {
                            title: 'Tes Dengar',
                            description: 'Input data hasil tes dengar lansia',
                            image: '{{ asset('icons/ear.png') }}', // URL gambar
                            link: '/tesdengar/fiturposyandulansia/{{ $userId }}',
                            key: 'tesdengar'
                        },
                        {
                            title: 'Tes Lihat',
                            description: 'Input data hasil tes lihat lansia',
                            image: '{{ asset('icons/biometric.png') }}', // URL gambar
                            link: '/teslihat/fiturposyandulansia/{{ $userId }}',
                            key: 'teslihat'
                        },
                        {
                            title: 'Tes Mobilisasi',
                            description: 'Input data hasil tes mobilisasi lansia',
                            image: '{{ asset('icons/mobilisasi.png') }}', // URL gambar
                            link: '/tesmobilisasi/fiturposyandulansia/{{ $userId }}',
                            key: 'tesmobilisasi'
                        },
                        {
                            title: 'Pemeriksaan Dokter',
                            description: 'Cek tensi, gula darah, kolestrol, dan keluhan lansia',
                            image: '{{ asset('icons/questionnaire.png') }}', // URL gambar
                            link: '/pemeriksaan/fiturposyandulansia/{{ $userId }}',
                            key: 'pemeriksaan'
                        },

                    ],
        
                    // Mengembalikan jadwal saat ini berdasarkan pilihan
                    get currentJadwal() {
                        const current = this.jadwalOptions.find(j => j.date === this.selectedJadwal);
        
                        if (current && current.name === this.posyanduTypes.BALITA) {
                            // Aturan default untuk Posyandu Balita
                            current.pendaftaran_balita = true; // Default true
                            current.penimbangan_balita = true; // Default true
                            current.pengukuran_balita = true; // Default true
                            current.imunisasi = current.imunisasi ?? false; // Opsional
                            current.obatcacing = current.obatcacing ?? false; // Opsional
                            current.susu = current.susu ?? false; // Opsional
                            current.pendaftaran_lansia = false; // Default false
                            current.penimbangan_lansia = false; // Default false
                            current.pengukuran_lansia = false; // Default false
                            current.teskognitif = current.teskognitif ?? false; // Opsional
                            current.tesdengar = current.tesdengar ?? false; // Opsional
                            current.teslihat = current.teslihat ?? false; // Opsional
                            current.pemeriksaan = current.pemeriksaan ?? false; // Opsional
                        }
                        if (current && current.name === this.posyanduTypes.LANSIA) {
                            // Aturan default untuk Posyandu Lansia
                            current.pendaftaran_lansia = true; // Default true
                            current.penimbangan_lansia = true; // Default true
                            current.pengukuran_lansia = true; // Default true
                            current.pemeriksaan = current.pemeriksaan ?? true; // Opsional
                        }
        
                        return current;
                    },
        
                    // Mengembalikan item dashboard berdasarkan jadwal yang dipilih
                    get filteredDashboardItems() {
                        const currentJadwal = this.currentJadwal;
                        if (!currentJadwal)
                            return []; // Jika tidak ada jadwal yang dipilih, kembalikan array kosong
                        return this.dashboardItems.filter(item => currentJadwal[item.key]);
                    }
                }));
            });
        </script>
        

</body>

</html>