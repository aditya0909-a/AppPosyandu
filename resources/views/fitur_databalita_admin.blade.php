<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Aplikasi Posyandu</title>
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
  <div class="container mx-auto flex items-center">
    <!-- Back Button -->
    <button onclick="history.back()" class="text-blue-500 focus:outline-none mr-4">
      &larr; Back
    </button>
    <!-- Title -->
    <a href="#" class="text-2xl font-bold text-blue-500">E-Posyandu</a>
    <div class="ml-auto text-blue-500 font-sans">Akun Admin</div> <!-- Keterangan akun "Kader" muncul di mobile -->
  </div>
</nav>


    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold">Peserta Posyandu Balita</h1>
      <button @click="showAddModal = true" class="bg-blue-500 text-white px-2 py-1 rounded">Tambah Peserta</button>
    </div>

    <!-- Search Bar -->
    <div class="flex items-center mb-4">
      <input type="text" placeholder="Cari peserta..." class="w-full p-2 border rounded" x-model="searchTerm">
      <button @click="searchPeserta" class="ml-2 bg-blue-500 text-white px-4 py-2 rounded">Search</button>
    </div>

    <!-- Peserta List -->
    <template x-for="peserta in filteredPeserta" :key="peserta.id">
      <div class="bg-white shadow-md rounded p-4 mb-4">
        <div class="flex items-center space-x-4">
          <!-- Avatar -->
          <div>
            <img src="https://via.placeholder.com/50" alt="Avatar" class="w-12 h-12 rounded-full">
          </div>
          <!-- Peserta Info -->
          <div class="flex-1">
            <h2 class="text-lg font-bold" x-text="peserta.nama"></h2>
            <p><strong>Lahir:</strong> <span x-text="peserta.lahir"></span></p>
          </div>
        </div>
      </div>
    </template>

    <!-- Modal Tambah Peserta -->
    <div x-show="showAddModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center">
      <div class="bg-white p-6 rounded shadow-lg max-w-lg w-full">
        <h2 class="text-xl mb-4">Tambah Peserta</h2>
        <div class="mb-2">
          <label class="block mb-1">Nama</label>
          <input type="text" x-model="newPeserta.nama" class="w-full p-2 border rounded">
        </div>
        <div class="mb-2">
          <label class="block mb-1">Lahir</label>
          <input type="date" x-model="newPeserta.lahir" class="w-full p-2 border rounded">
        </div>
        <div class="flex justify-end">
          <button @click="showAddModal = false" class="bg-gray-400 text-white px-4 py-2 rounded mr-2">Batal</button>
          <button @click="addPeserta" class="bg-blue-500 text-white px-4 py-2 rounded">Tambah</button>
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
        pesertaList: [
          {
            id: '0003175481981',
            nama: 'Kamal',
            lahir: '1952-04-13'
          },
          {
            id: '0003175481992',
            nama: 'M Aditya Pangestu',
            lahir: '2001-07-09'
          }
        ],
        newPeserta: {
          nama: '',
          lahir: ''
        },
        get filteredPeserta() {
          return this.pesertaList.filter(peserta => 
            peserta.nama.toLowerCase().includes(this.searchTerm.toLowerCase()) || 
            peserta.lahir.includes(this.searchTerm)
          );
        },
        searchPeserta() {
          // Fungsi search sudah otomatis berjalan karena menggunakan computed property 'filteredPeserta'
        },
        addPeserta() {
          if (this.newPeserta.nama && this.newPeserta.lahir) {
            this.pesertaList.push({ ...this.newPeserta });
            this.newPeserta = { nama: '', lahir: '' };
            this.showAddModal = false;
          }
        }
      };
    }
  </script>
</body>
</html>
