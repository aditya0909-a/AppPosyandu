
    <!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Posyandu - Kader</title>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.0.0/dist/cdn.min.js" defer></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
      body { padding-top: 64px; } /* Pastikan konten tidak tertutup navbar */
    </style>
  </head>
  <body class="bg-gray-100" x-data="dashboardData()">
  
<!-- Navbar -->
<nav class="bg-white shadow-md p-4 fixed top-0 left-0 right-0 z-10">
  <div class="container mx-auto flex items-center">
    <!-- Back Button -->
    <button onclick="history.back()" class="text-blue-500 focus:outline-none mr-4">
      &larr; Back
    </button>
    <!-- Title -->
    <a href="#" class="text-2xl font-bold text-blue-500">E-Posyandu</a>
    <div class="ml-auto text-blue-500 font-sans">Akun Kader</div> <!-- Keterangan akun "Kader" muncul di mobile -->
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
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
      
      <!-- Pendaftaran -->
      <a href="/fiturposyandulasia_pendaftaran_kader" class="block bg-gradient-to-r from-green-500 to-green-600 text-white rounded-lg shadow-lg p-6 text-center transform hover:scale-105 transition-transform" x-show="selectedJadwal">
        <div class="text-4xl mb-4">📓</div>
        <h2 class="text-xl font-bold">Pendaftaran</h2>
      </a>

      <!-- Penimbangan -->
      <a href="/fiturposyandulansia_penimbangan_kader" class="block bg-gradient-to-r from-green-500 to-green-600 text-white rounded-lg shadow-lg p-6 text-center transform hover:scale-105 transition-transform" x-show="selectedJadwal">
        <div class="text-4xl mb-4">⚖</div>
        <h2 class="text-xl font-bold">Penimbangan</h2>
      </a>

      <!-- Pengukuran -->
      <a href="/fiturposyandulansia_pengukuran_kader" class="block bg-gradient-to-r from-green-500 to-green-600 text-white rounded-lg shadow-lg p-6 text-center transform hover:scale-105 transition-transform" x-show="selectedJadwal">
        <div class="text-4xl mb-4">📏</div>
        <h2 class="text-xl font-bold">Pengukuran</h2>
      </a>

      <!-- Tes Kognitif -->
      <a href="/fiturposyandulansia_teskognitif_kader" class="block bg-gradient-to-r from-green-500 to-green-600 text-white rounded-lg shadow-lg p-6 text-center transform hover:scale-105 transition-transform" x-show="selectedJadwal">
        <div class="text-4xl mb-4">💡</div>
        <h2 class="text-xl font-bold">Tes Kognitif</h2>
      </a>

      <!-- Tes Dengar -->
      <a href="/fiturposyandulansia_tesdengar_kader" class="block bg-gradient-to-r from-green-500 to-green-600 text-white rounded-lg shadow-lg p-6 text-center transform hover:scale-105 transition-transform" x-show="selectedJadwal">
        <div class="text-4xl mb-4">🧏</div>
        <h2 class="text-xl font-bold">Tes Dengar</h2>
      </a>

      <!-- Tes Lihat -->
      <a href="/fiturposyandulansia_teslihat_kader" class="block bg-gradient-to-r from-green-500 to-green-600 text-white rounded-lg shadow-lg p-6 text-center transform hover:scale-105 transition-transform" x-show="selectedJadwal">
        <div class="text-4xl mb-4">🧐</div>
        <h2 class="text-xl font-bold">Tes Lihat</h2>
      </a>

      <!-- Tes Mobilisasi -->
      <a href="/fiturposyandulansia_tesmobilisasi_kader" class="block bg-gradient-to-r from-green-500 to-green-600 text-white rounded-lg shadow-lg p-6 text-center transform hover:scale-105 transition-transform" x-show="selectedJadwal">
        <div class="text-4xl mb-4">🚶‍♂️</div>
        <h2 class="text-xl font-bold">Tes Mobilisasi</h2>
      </a>


      <!-- Keluhan -->
      <a href="/fiturposyandulansia_keluhan_kader" class="block bg-gradient-to-r from-green-500 to-green-600 text-white rounded-lg shadow-lg p-6 text-center transform hover:scale-105 transition-transform" x-show="selectedJadwal">
        <div class="text-4xl mb-4">🧾</div>
        <h2 class="text-xl font-bold">Keluhan</h2>
      </a>

      <!-- Peserta Posyandu Lansia -->
      <a href="/fiturposyandulansia_peserta_kader" class="block bg-gradient-to-r from-green-500 to-green-600 text-white rounded-lg shadow-lg p-6 text-center transform hover:scale-105 transition-transform" x-show="selectedJadwal">
        <div class="text-4xl mb-4">👴</div>
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
  