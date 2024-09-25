<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kelola Akun Pengguna - Admin</title>
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
    <a href="#" class="text-2xl font-bold text-blue-500">Posyandu</a>
    <div class="ml-auto text-blue-500 font-sans">Akun Admin</div> <!-- Keterangan akun "Kader" muncul di mobile -->
  </div>
</nav>


    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold">Kelola Akun Pengguna</h1>
      <button @click="showAddModal = true" class="bg-blue-500 text-white px-2 py-1 rounded">Tambah Akun</button>
    </div>

    <!-- Search Bar -->
    <div class="flex items-center mb-4">
      <input type="text" placeholder="Cari pengguna..." class="w-full p-2 border rounded" x-model="searchTerm">
      <button @click="searchUser" class="ml-2 bg-blue-500 text-white px-4 py-2 rounded">Search</button>
    </div>

    <!-- Daftar Pengguna -->
    <template x-for="user in filteredUsers" :key="user.id">
      <div class="bg-white shadow-md rounded p-4 mb-4">
        <div class="flex items-center space-x-4">
          <!-- Avatar Placeholder -->
          <div>
            <img src="https://via.placeholder.com/50" alt="Avatar" class="w-12 h-12 rounded-full">
          </div>
          <!-- Info Pengguna -->
          <div class="flex-1">
            <h2 class="text-lg font-bold" x-text="user.nama"></h2>
            <p><strong>Id :</strong> <span x-text="user.id_pengguna"></span></p>
            <p><strong>Password :</strong> <span x-password="user.password"></span></p>
            <p><strong>Role :</strong> <span x-text="user.role"></span></p>
          </div>
        </div>
      </div>
    </template>

    <!-- Modal Tambah Pengguna -->
    <div x-show="showAddModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center">
      <div class="bg-white p-6 rounded shadow-lg max-w-lg w-full">
        <h2 class="text-xl mb-4">Tambah Akun Pengguna</h2>
        <div class="mb-2">
          <label class="block mb-1">Nama</label>
          <input type="text" x-model="newUser.nama" class="w-full p-2 border rounded">
        </div>
        <div class="mb-2">
          <label class="block mb-1">Id Pengguna</label>
          <input type="text" x-model="newUser.id_pengguna" class="w-full p-2 border rounded">
        </div>
        <div class="mb-2">
          <label class="block mb-1">Password</label>
          <input type="password" x-model="newUser.password" class="w-full p-2 border rounded">
        </div>
        <div class="mb-2">
          <label class="block mb-1">Role</label>
          <select x-model="newUser.role" class="w-full p-2 border rounded">
            <option value="Admin">Admin</option>
            <option value="Petugas">Petugas</option>
            <option value="Peserta">Peserta</option>
          </select>
        </div>
        <div class="flex justify-end">
          <button @click="showAddModal = false" class="bg-gray-400 text-white px-4 py-2 rounded mr-2">Batal</button>
          <button @click="addUser" class="bg-blue-500 text-white px-4 py-2 rounded">Tambah</button>
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
        usersList: [
          {
            id: '0001',
            nama: 'Ayu Susanti',
            id_pengguna: 'ayususanti09071990',
            password:'ayu123',
            role: 'Admin'
          },
          {
            id: '0002',
            nama: 'Budi Santoso',
            id_pengguna: 'budisantoso09081992',
            password:'budi123',
            role: 'Petugas'
          }
        ],
        newUser: {
          nama: '',
          id_pengguna: '',
          password: '',
          role: 'Pengguna' // Default role is 'Pengguna'
        },
        get filteredUsers() {
          return this.usersList.filter(user => 
            user.nama.toLowerCase().includes(this.searchTerm.toLowerCase()) || 
            user.id_pengguna.toLowerCase().includes(this.searchTerm.toLowerCase()) ||
            user.role.toLowerCase().includes(this.searchTerm.toLowerCase())
          );
        },
        searchUser() {
          // Pencarian otomatis bekerja melalui computed property 'filteredUsers'
        },
        addUser() {
          if (this.newUser.nama && this.newUser.id_pengguna && this.newUser.role) {
            this.usersList.push({ ...this.newUser, id: Date.now().toString() });
            this.newUser = { nama: '', email: '', role: 'Pengguna' };
            this.showAddModal = false;
          }
        }
      };
    }
  </script>
</body>
</html>
