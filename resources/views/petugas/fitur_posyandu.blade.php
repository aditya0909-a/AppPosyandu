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

<body x-data="dashboardData()">

@if (session('success'))
<div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
  class="mb-4 fixed top-20 right-4 z-50 max-w-md shadow-lg glass-effect" role="alert">
  <div class="flex items-center gap-2">
      <span class="text-green-800 font-medium">{{ session('success') }}</span>
      <button @click="show = false" class="ml-auto p-1 text-green-500 hover:bg-green-200">
          <span class="sr-only">Close</span>
          &times;
      </button>
  </div>
</div>
@endif

@if (session('error'))
  <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
      class="mb-4 rounded-lg border border-red-200 bg-red-100 p-4 fixed top-20 right-4 z-50 max-w-md shadow-lg"
      role="alert">
      <div class="flex items-center gap-2">
          <svg class="h-5 w-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <span class="text-sm font-medium text-red-800">{{ session('error') }}</span>
          <button @click="show = false"
              class="ml-auto rounded-lg p-1.5 text-red-500 hover:bg-red-200 inline-flex h-8 w-8 items-center justify-center">
              <span class="sr-only">Close</span>
              <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M6 18L18 6M6 6l12 12" />
              </svg>
          </button>
      </div>
  </div>
@endif

<div >
  <nav class="navbar fixed top-0 left-0 right-0 z-10 p-4 shadow-md">
      <div class="container mx-auto flex items-center">
          <button onclick="window.location.href = '/dashboard/petugas'" class="text-[#0077B5] mr-4">
              &larr; Back
          </button>
          <a href="#" class="text-2xl font-bold text-[#0077B5]">Posyandu</a>
          <div class="ml-auto text-[#0077B5] font-sans">Akun Petugas</div>
      </div>
  </nav>
  
<body>
    
    <div x-data="dashboardData()" x-init="init({{$Jadwals}})"> </div>
    <!-- Pilihan Jadwal -->
    <div class="container mx-auto mt-6 px-4">
        <label for="jadwal" class="block text-xl font-semibold mb-2">Pilih Jadwal Posyandu:</label>
        <select id="jadwal" x-model="selectedJadwal" class="w-full p-3 bg-white border rounded-lg shadow-md mb-3">
            <option value="" disabled selected>Pilih jadwal...</option>
            <template x-for="jadwal in jadwalOptions" :key="jadwal.date">
                <option x-text="`${jadwal.name} - ${jadwal.location} (${jadwal.date})`" :value="jadwal.date"></option>
            </template>
        </select>


    <!-- Dashboard Grid -->
    <section class="container mx-auto py-6 px-2">
        <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Tampilkan item dashboard hanya jika jadwal cocok -->
            <template x-for="item in filteredDashboardItems" :key="item.title">
                
                <a :href="item.link" class="block button-primary text-white rounded-lg shadow-lg p-6 text-center transform hover:scale-105 transition-transform">
                    <img :src="item.image" alt="" class="w-16 h-16 mx-auto mb-4">
                    <h2 class="text-xl font-bold" x-text="item.title"></h2>
                    <p class="text-sm opacity-75" x-text="item.description"></p>
                </a>
            </template>
        </div>
    </section>

    <script>
        function dashboardData() {
            return {
                // Enum untuk nama Posyandu
                posyanduTypes: {
                    BALITA: 'Posyandu Balita',
                    LANSIA: 'Posyandu Lansia'
                },
    
                // Jadwal yang dipilih
                selectedJadwal: '',
    
                
                jadwalOption: [], // Awalnya kosong
            
           // Fungsi untuk memuat data jadwal dari API
           async fetchJadwalOptions() {
                try {
                    const response = await fetch('/api/jadwal-options');
                    if (!response.ok) throw new Error(`Error: ${response.status} - ${response.statusText}`);
                    
                    const data = await response.json();
                    
                    if (!Array.isArray(data.jadwalOptions)) {
                        throw new Error('Data jadwalOptions tidak valid.');
                    }

                    this.jadwalOptions = data.jadwalOptions;
                    console.log('Jadwal berhasil dimuat:', this.jadwalOptions);
                } catch (error) {
                    console.error('Gagal memuat data jadwal:', error);
                }
            },
            },        

                    
                // Data item dashboard (tanpa properti jadwal)
                dashboardItems: [
                    {
                        title: 'Pendaftaran',
                        description: 'Pendaftaran peserta kegiatan posyandu balita.',
                        image: '{{ asset("icons/register.png") }}', // URL gambar
                        link: '/pendaftaran/fiturposyandubalita/petugas',
                        key: 'pendaftaran_balita'
                    },
                    {
                        title: 'Penimbangan',
                        description: 'Input data berat badan balita.',
                        image: '{{ asset("icons/weight.png") }}', // URL gambar
                        link: '/penimbangan/fiturposyandubalita/petugas',
                        key: 'penimbangan_balita'
                    },
                    {
                        title: 'Pengukuran',
                        description: 'Input data tinggi badan dan lingkar kepala balita.',
                        image: '{{ asset('icons/height.png') }}', // URL gambar
                        link: '/pengukuran/fiturposyandubalita/petugas',
                        key: 'pengukuran_balita'
                    },
                    {
                        title: 'Kuisioner',
                        description: 'Kuisioner deteksi kesehatan balita',
                        image: '{{ asset('icons/questionnaire.png') }}', // URL gambar
                        link: '/kuisioner/fiturposyandubalita/petugas',
                        key: 'kuisioner'
                    },
                    {
                        title: 'Vitamin',
                        description: 'Checklist pemberian vitamin.',
                        image: '{{ asset('icons/capsule.png') }}', // URL gambar
                        link: '/vitamin/fiturposyandubalita/petugas',
                        key: 'vitamin'
                    },
                    {
                        title: 'Susu',
                        description: 'Checklist pemberian susu.',
                        image: '{{ asset('icons/milk.png') }}', // URL gambar
                        link: '/susu/fiturposyandubalita/petugas',
                        key: 'obatCacing'
                    },
                    {
                        title: 'Imunisasi',
                        description: 'Checklist pemberian imunisasi.',
                        image: '{{ asset('icons/injection.png') }}', // URL gambar
                        link: '/imunisasi/fiturposyandubalita/petugas',
                        key: 'imunisasi'
                    },
                    {
                        title: 'Pemberian Obat Cacing',
                        description: 'Checklist pemberian obat cacing.',
                        image: '{{ asset('icons/injection.png') }}', // URL gambar
                        link: '/obatcacing/fiturposyandubalita/petugas',
                        key: 'obatcacing'
                    },
                    {
                        title: 'List Kehadiran',
                        description: 'List peserta posyandu hari ini.',
                        image: '{{ asset('icons/participant.png') }}', // URL gambar
                        link: '/peserta/fiturposyandubalita/petugas',
                        key: 'pesertaposyandu_balita'
                    },
                    {
                        title: 'Pendaftaran',
                        description: 'Pendaftaran peserta kegiatan posyandu lansia.',
                        image: '{{ asset("icons/register.png") }}', // URL gambar
                        link: '/pendaftaran/fiturposyandulansia/petugas',
                        key: 'pendaftaran_lansia'
                    },
                    {
                        title: 'Penimbangan',
                        description: 'Input data berat badan lansia.',
                        image: '{{ asset("icons/weight.png") }}', // URL gambar
                        link: '/penimbangan/fiturposyandulansia/petugas',
                        key: 'penimbangan_lansia'
                    },
                    {
                        title: 'Pengukuran',
                        description: 'Input data tinggi badan, lingkar perut dan lingkar lengan lansia.',
                        image: '{{ asset('icons/height.png') }}', // URL gambar
                        link: '/pengukuran/fiturposyandulansia/petugas',
                        key: 'pengukuran_lansia'
                    },
                    {
                        title: 'Tes Kognitif',
                        description: 'Kuisioner tes kemampuan kognitif lansia.',
                        image: '{{ asset('icons/idea.png') }}', // URL gambar
                        link: '/teskognitif/fiturposyandulansia/petugas',
                        key: 'teskognitif'
                    },
                    {
                        title: 'Tes Dengar',
                        description: 'Input data hasil tes dengar lansia',
                        image: '{{ asset('icons/ear.png') }}', // URL gambar
                        link: '/tesdengar/fiturposyandulansia/petugas',
                        key: 'tesdengar'
                    },
                    {
                        title: 'Tes Lihat',
                        description: 'Input data hasil tes lihat lansia',
                        image: '{{ asset('icons/biometric.png') }}', // URL gambar
                        link: '/teslihat/fiturposyandulansia/petugas',
                        key: 'teslihat'
                    },
                    {
                        title: 'Tes Mobilisasi',
                        description: 'Input data hasil tes mobilisasi lansia',
                        image: '{{ asset('icons/mobilisasi.png') }}', // URL gambar
                        link: '/tesmobilisasi/fiturposyandulansia/petugas',
                        key: 'tesmobilisasi'
                    },
                    {
                        title: 'Informasi Keluhan',
                        description: 'Input data keluhan lansia',
                        image: '{{ asset('icons/questionnaire.png') }}', // URL gambar
                        link: '/keluhan/fiturposyandulansia/petugas',
                        key: 'keluhan'
                    },
                    {
                        title: 'List Kehadiran',
                        description: 'List peserta posyandu hari ini.',
                        image: '{{ asset('icons/participant.png') }}', // URL gambar
                        link: '/peserta/fiturposyandulansia/petugas',
                        key: 'pesertaposyandu_lansia'
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
                        current.pesertaposyandu_balita = true; // Default true
                        current.imunisasi = current.imunisasi ?? false; // Opsional
                        current.obatcacing = current.obatcacing ?? false; // Opsional
                        current.susu = current.susu ?? false; // Opsional
                        current.vitamin = current.vitamin ?? false; // Opsional
                        current.kuisioner = current.kuisioner ?? false; // Opsional
                        current.pendaftaran_lansia = false; // Default false
                        current.penimbangan_lansia = false; // Default false
                        current.pengukuran_lansia = false; // Default false
                        current.teskognitif = current.teskognitif ?? false; // Opsional
                        current.tesdengar = current.tesdengar ?? false; // Opsional
                        current.teslihat = current.teslihat ?? false; // Opsional
                        current.keluhan = current.keluhan ?? false; // Opsional
                        current.pesertaposyandu_lansia = false; // Default false
                    }     
                    if (current && current.name === this.posyanduTypes.LANSIA) {
                        // Aturan default untuk Posyandu lansia
                        current.pendaftaran_lansia = true; // Default true
                        current.penimbangan_lansia = true; // Default true
                        current.pengukuran_lansia = true; // Default true
                        current.pesertaposyandu_lansia = true; // Default true
                    }                    
    
                    return current;
                },
    
                // Mengembalikan item dashboard berdasarkan jadwal yang dipilih
                get filteredDashboardItems() {
                    const currentJadwal = this.currentJadwal;
                    if (!currentJadwal) return []; // Jika tidak ada jadwal yang dipilih, kembalikan array kosong
                    return this.dashboardItems.filter(item => currentJadwal[item.key]);
                }
            };
        }
    </script>    
</body>
</html>
