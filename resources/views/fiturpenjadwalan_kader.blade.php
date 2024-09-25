<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Aplikasi Posyandu - Jadwal Kegiatan</title>
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.0.0/dist/cdn.min.js" defer></script>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<style>
  body { padding-top: 64px; } /* Pastikan konten tidak tertutup navbar */
</style>
<body class="bg-gray-100" x-data="appData()">
  <!-- Container -->
  <div class="max-w-4xl mx-auto p-6">

    <!-- Navbar -->
    <nav class="bg-white shadow-md p-4 fixed top-0 left-0 right-0 z-10">
      <div class="container mx-auto flex justify-between items-center">
        <a href="#" class="text-2xl font-bold text-blue-500">E-Posyandu</a>
        <div class="text-blue-500 font-sans">Akun Admin</div>
      </div>
    </nav>

    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold">Jadwal Kegiatan Posyandu</h1>
    </div>

    <!-- Search Bar -->
    <div class="flex items-center mb-4">
      <input type="text" placeholder="Cari kegiatan..." class="w-full p-2 border rounded" x-model="searchTerm">
      <button @click="searchJadwal" class="ml-2 bg-blue-500 text-white px-4 py-2 rounded">Search</button>
    </div>

    <!-- Jadwal List -->
    <template x-for="jadwal in filteredJadwal" :key="jadwal.id">
      <div class="bg-white shadow-md rounded p-4 mb-4">
        <div class="flex items-center space-x-4">
          <!-- Icon Kalender -->
          <div>
            <img src="https://via.placeholder.com/50" alt="Kalender" class="w-12 h-12 rounded-full">
          </div>
          <!-- Jadwal Info -->
          <div class="flex-1">
            <h2 class="text-lg font-bold" x-text="jadwal.namaKegiatan"></h2>
            <p><strong>Tanggal:</strong> <span x-text="jadwal.tanggalKegiatan"></span></p>
            <p><strong>Lokasi:</strong> <span x-text="jadwal.lokasi"></span></p>
          </div>
        </div>
      </div>
    </template>

  </div>

  <!-- Alpine.js Logic -->
  <script>
    function appData() {
      return {
        searchTerm: '',
        jadwalList: [
          {
            id: '0001',
            namaKegiatan: 'Posyandu Balita',
            tanggalKegiatan: '2024-10-10',
            lokasi: 'Posyandu A'
          },
          {
            id: '0002',
            namaKegiatan: 'Pemeriksaan Ibu Hamil',
            tanggalKegiatan: '2024-10-15',
            lokasi: 'Posyandu B'
          }
        ],
        get filteredJadwal() {
          return this.jadwalList.filter(jadwal => 
            jadwal.namaKegiatan.toLowerCase().includes(this.searchTerm.toLowerCase()) || 
            jadwal.tanggalKegiatan.includes(this.searchTerm) ||
            jadwal.lokasi.toLowerCase().includes(this.searchTerm.toLowerCase())
          );
        },
        searchJadwal() {
          // Fungsi search otomatis menggunakan computed property 'filteredJadwal'
        }
      };
    }
  </script>
</body>
</html>
