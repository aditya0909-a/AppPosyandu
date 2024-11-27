<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Peserta Posyandu Balita - Admin</title>
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

  <!-- Pilihan Jadwal -->
  <div class="container mx-auto mt-6 px-4">
    <label for="jadwal" class="block text-xl font-semibold mb-2">Pilih Jadwal Posyandu:</label>
    <select id="jadwal" x-model="selectedJadwal" class="w-full p-3 bg-white border rounded-lg shadow-md mb-6">
      <option value="" disabled selected>Pilih jadwal...</option>
      <template x-for="jadwal in jadwalOptions" :key="jadwal">
        <option x-text="jadwal" :value="jadwal"></option>
      </template>
    </select>
  </div>

  <!-- Dashboard Grid -->
  <section class="container mx-auto py-10 px-4">
    <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-3 gap-6">
      
      <!-- Pendaftaran -->
      <a href="/fiturposyanduanak_pendaftaran_petugas" class="block button-primary text-white rounded-lg shadow-lg p-6 text-center transform hover:scale-105 transition-transform" x-show="selectedJadwal">
        <img src="{{ asset('icons/register.png') }}" alt="Pendaftaran" class="w-16 h-16 mx-auto mb-4">
        <h2 class="text-xl font-bold">Pendaftaran</h2>
        <p class="text-sm opacity-75">Pendaftaran peserta kegiatan posyandu balita</p>
      </a>

      <!-- Penimbangan -->
      <a href="/fiturposyanduanak_penimbangan_petugas" class="block button-primary text-white rounded-lg shadow-lg p-6 text-center transform hover:scale-105 transition-transform" x-show="selectedJadwal">
        <img src="{{ asset('icons/weight.png') }}" alt="Penimbangan" class="w-16 h-16 mx-auto mb-4">
        <h2 class="text-xl font-bold">Penimbangan</h2>
        <p class="text-sm opacity-75">Input data berat badan balita</p>
      </a>

      <!-- Pengukuran -->
      <a href="/fiturposyanduanak_pengukuran_petugas" class="block button-primary text-white rounded-lg shadow-lg p-6 text-center transform hover:scale-105 transition-transform" x-show="selectedJadwal">
        <img src="{{ asset('icons/height.png') }}" alt="Pengukuran" class="w-16 h-16 mx-auto mb-4">
        <h2 class="text-xl font-bold">Pengukuran</h2>
        <p class="text-sm opacity-75">Input data tinggi badan dan lingkar kepala balita</p>
      </a>

      <!-- Kuisioner -->
      <a href="/fiturposyanduanak_kuisioner_petugas" class="block button-primary text-white rounded-lg shadow-lg p-6 text-center transform hover:scale-105 transition-transform" x-show="selectedJadwal">
        <img src="{{ asset('icons/questionnaire.png') }}" alt="Kuisioner" class="w-16 h-16 mx-auto mb-4">
        <h2 class="text-xl font-bold">Kuisioner</h2>
        <p class="text-sm opacity-75">Kuisioner deteksi kesehatan balita</p>
      </a>

      <!-- Vitamin -->
      <a href="/fiturposyanduanak_vitamin_petugas" class="block button-primary text-white rounded-lg shadow-lg p-6 text-center transform hover:scale-105 transition-transform" x-show="selectedJadwal">
        <img src="{{ asset('icons/capsule.png') }}" alt="Vitamin" class="w-16 h-16 mx-auto mb-4">
        <h2 class="text-xl font-bold">Vitamin</h2>
        <p class="text-sm opacity-75">Checklist pemberian vitamin</p>
      </a>

      <!-- Susu -->
      <a href="/fiturposyanduanak_susu_petugas" class="block button-primary text-white rounded-lg shadow-lg p-6 text-center transform hover:scale-105 transition-transform" x-show="selectedJadwal">
        <img src="{{ asset('icons/milk.png') }}" alt="Susu" class="w-16 h-16 mx-auto mb-4">
        <h2 class="text-xl font-bold">Susu</h2>
        <p class="text-sm opacity-75">Checklist pemberian susu</p>
      </a>

      <!-- Imunisasi -->
      <a href="/fiturposyanduanak_imunisasi_petugas" class="block button-primary text-white rounded-lg shadow-lg p-6 text-center transform hover:scale-105 transition-transform" x-show="selectedJadwal">
        <img src="{{ asset('icons/injection.png') }}" alt="Imunisasi" class="w-16 h-16 mx-auto mb-4">
        <h2 class="text-xl font-bold">Imunisasi</h2>
        <p class="text-sm opacity-75">Checklist pemberian imunisasi</p>
      </a>

      <!-- Peserta Posyandu Anak -->
      <a href="/fiturposyanduanak_peserta_petugas" class="block button-primary text-white rounded-lg shadow-lg p-6 text-center transform hover:scale-105 transition-transform" x-show="selectedJadwal">
        <img src="{{ asset('icons/participant.png') }}" alt="Peserta Posyandu" class="w-16 h-16 mx-auto mb-4">
        <h2 class="text-xl font-bold">Peserta Posyandu</h2>
        <p class="text-sm opacity-75">List peserta posyandu hari ini</p>
      </a>
    </div>
  </section>

  <!-- Alpine.js Logic -->
  <script>
    function dashboardData() {
      return {
        selectedJadwal: '', // Nilai default untuk jadwal yang dipilih
        jadwalOptions: ['Jadwal 1', 'Jadwal 2', 'Jadwal 3'], // Opsi jadwal yang tersedia
      }
    }
  </script>
<script>
fetch('/api/jadwal')
.then(response => response.json())
.then(data => {
    console.log(data); // Data jadwal diterima di sini
});
</script>

</body>
</html>
