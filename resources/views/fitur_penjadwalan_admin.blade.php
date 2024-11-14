<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Aplikasi Posyandu - Jadwal Kegiatan</title>
  {{-- Import Library External: TailwindCSS & AlpineJS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<style>
  body { padding-top: 64px; } /* Pastikan konten tidak tertutup navbar */
</style>
<body class="bg-gray-100" x-data="appData()">
  <!-- Container -->
  <div class="max-w-4xl mx-auto p-6">

<!-- Navbar -->
<nav class="bg-white shadow-md p-4 fixed top-0 left-0 right-0 z-10">
  <div class="container mx-auto flex items-center">
    <!-- Back Button -->
    <button onclick="window.location.href = '/dashboard/admin'" class="text-blue-500 focus:outline-none mr-4">
      &larr; Back
  </button>
    <!-- Title -->
    <a href="#" class="text-2xl font-bold text-blue-500">Posyandu</a>
    <div class="ml-auto text-blue-500 font-sans">Akun Admin</div> <!-- Keterangan akun "Admin" muncul di mobile -->
  </div>
</nav>


    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold">Jadwal Kegiatan Posyandu</h1>
      <button @click="showAddModal = true" class="bg-blue-500 text-white px-2 py-1 rounded">Tambah Jadwal</button>
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

    <!-- Modal Tambah Jadwal -->
    <div x-show="showAddModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center">
      <div class="bg-white p-6 rounded shadow-lg max-w-lg w-full">
        <h2 class="text-xl mb-4">Tambah Jadwal Kegiatan</h2>
        <div class="mb-2">
          <label class="block mb-1">Nama Kegiatan</label>
          <input type="text" x-model="newJadwal.namaKegiatan" class="w-full p-2 border rounded">
        </div>
        <div class="mb-2">
          <label class="block mb-1">Tanggal Kegiatan</label>
          <input type="date" x-model="newJadwal.tanggalKegiatan" class="w-full p-2 border rounded">
        </div>
        <div class="mb-2">
          <label class="block mb-1">Lokasi</label>
          <input type="text" x-model="newJadwal.lokasi" class="w-full p-2 border rounded">
        </div>
        <div class="flex justify-end">
          <button @click="showAddModal = false" class="bg-gray-400 text-white px-4 py-2 rounded mr-2">Batal</button>
          <button @click="addJadwal" class="bg-blue-500 text-white px-4 py-2 rounded">Tambah</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Alpine.js Logic -->
  <script>
    function appData() {
      return {
        showAddModal: false,
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
        newJadwal: {
          namaKegiatan: '',
          tanggalKegiatan: '',
          lokasi: ''
        },
        get filteredJadwal() {
          return this.jadwalList.filter(jadwal => 
            jadwal.namaKegiatan.toLowerCase().includes(this.searchTerm.toLowerCase()) || 
            jadwal.tanggalKegiatan.includes(this.searchTerm) ||
            jadwal.lokasi.toLowerCase().includes(this.searchTerm.toLowerCase())
          );
        },
        searchJadwal() {
          // Fungsi search otomatis menggunakan computed property 'filteredJadwal'
        },
        addJadwal() {
          if (this.newJadwal.namaKegiatan && this.newJadwal.tanggalKegiatan && this.newJadwal.lokasi) {
            this.jadwalList.push({ ...this.newJadwal, id: Date.now().toString() });
            this.newJadwal = { namaKegiatan: '', tanggalKegiatan: '', lokasi: '' };
            this.showAddModal = false;
          }
        }
      };
    }
  </script>
</body>
</html>
