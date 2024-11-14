<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Posyandu - Petugas</title>
  {{-- Import Library External: TailwindCSS & AlpineJS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
  <style>
    body { padding-top: 64px; } /* Pastikan konten tidak tertutup navbar */
  </style>
</head>
<body class="bg-gray-100" x-data="dashboardData()">

<!-- Navbar -->
<nav class="bg-white shadow-md p-4 fixed top-0 left-0 right-0 z-10">
  <div class="container mx-auto flex items-center">
    <button onclick="window.location.href = '/dashboard/petugas'" class="text-blue-500 focus:outline-none mr-4">
      &larr; Back
  </button>
    <!-- Title -->
    <a href="#" class="text-2xl font-bold text-blue-500">Posyandu</a>
    <div class="ml-auto text-blue-500 font-sans">Akun Petugas</div> <!-- Keterangan akun "Petugas" muncul di mobile -->
  </div>
</nav>

  <!-- Pilihan Jadwal -->
  <div class="container mx-auto mt-6 px-4">
    <label for="jadwal" class="block text-lg font-semibold mb-2">Pilih Jadwal Posyandu:</label>
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
      <a href="/fiturposyanduanak_pendaftaran_petugas" class="block bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg shadow-lg p-6 text-center transform hover:scale-105 transition-transform" x-show="selectedJadwal">
        <img src="{{ asset('icons/register.png') }}" alt="Pendaftaran" class="w-12 h-12 mx-auto">
        <h2 class="text-xl font-bold">Pendaftaran</h2>
      </a>

      <!-- Penimbangan -->
      <a href="/fiturposyanduanak_penimbangan_petugas" class="block bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg shadow-lg p-6 text-center transform hover:scale-105 transition-transform" x-show="selectedJadwal">
        <img src="{{ asset('icons/weight.png') }}" alt="Penimbangan" class="w-12 h-12 mx-auto">
        <h2 class="text-xl font-bold">Penimbangan</h2>
      </a>

      <!-- Pengukuran -->
      <a href="/fiturposyanduanak_pengukuran_petugas" class="block bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg shadow-lg p-6 text-center transform hover:scale-105 transition-transform" x-show="selectedJadwal">
        <img src="{{ asset('icons/height.png') }}" alt="Pengukuran" class="w-12 h-12 mx-auto">
        <h2 class="text-xl font-bold">Pengukuran</h2>
      </a>

      <!-- Kuisioner -->
      <a href="/fiturposyanduanak_kuisioner_petugas" class="block bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg shadow-lg p-6 text-center transform hover:scale-105 transition-transform" x-show="selectedJadwal">
        <img src="{{ asset('icons/questionnaire.png') }}" alt="Kuisioner" class="w-12 h-12 mx-auto">
        <h2 class="text-xl font-bold">Kuisioner</h2>
      </a>

      <!-- Vitamin -->
      <a href="/fiturposyanduanak_vitamin_petugas" class="block bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg shadow-lg p-6 text-center transform hover:scale-105 transition-transform" x-show="selectedJadwal">
        <img src="{{ asset('icons/capsule.png') }}" alt="Vitamin" class="w-12 h-12 mx-auto">
        <h2 class="text-xl font-bold">Vitamin</h2>
      </a>

      <!-- Susu -->
      <a href="/fiturposyanduanak_susu_petugas" class="block bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg shadow-lg p-6 text-center transform hover:scale-105 transition-transform" x-show="selectedJadwal">
        <img src="{{ asset('icons/milk.png') }}" alt="Susu" class="w-12 h-12 mx-auto">
        <h2 class="text-xl font-bold">Susu</h2>
      </a>

      <!-- Imunisasi -->
      <a href="/fiturposyanduanak_imunisasi_petugas" class="block bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg shadow-lg p-6 text-center transform hover:scale-105 transition-transform" x-show="selectedJadwal">
        <img src="{{ asset('icons/injection.png') }}" alt="Imunisasi" class="w-12 h-12 mx-auto">
        <h2 class="text-xl font-bold">Imunisasi</h2>
      </a>

      <!-- Peserta Posyandu Anak -->
      <a href="/fiturposyanduanak_peserta_petugas" class="block bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg shadow-lg p-6 text-center transform hover:scale-105 transition-transform" x-show="selectedJadwal">
        <img src="{{ asset('icons/participant.png') }}" alt="Peserta Posyandu" class="w-12 h-12 mx-auto">
        <h2 class="text-xl font-bold">Peserta Posyandu</h2>
      </a>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-gray-800 text-white py-4 mt-10">
    <div class="container mx-auto text-center">
      <p>&copy; 2024 E-Posyandu. All rights reserved.</p>
    </div>
  </footer>

  <!-- Alpine.js Logic -->
  <script>
    function dashboardData() {
      return {
        selectedJadwal: '', // Nilai default untuk jadwal yang dipilih
        jadwalOptions: ['Jadwal 1', 'Jadwal 2', 'Jadwal 3'], // Opsi jadwal yang tersedia
      }
    }
  </script>

</body>
</html>
