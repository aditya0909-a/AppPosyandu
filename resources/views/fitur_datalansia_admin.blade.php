<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Info Peserta - Posyandu</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

  <!-- Navbar -->
  <nav class="bg-white shadow-md p-4">
    <div class="container mx-auto flex justify-between items-center">
      <a href="#" class="text-2xl font-bold text-blue-500">E-Posyandu</a>
      <div class="hidden lg:flex space-x-6 items-center">
        <a href="#" class="text-gray-700 hover:text-blue-500">Dashboard</a>
        <a href="#" class="text-gray-700 hover:text-blue-500">Peserta</a>
        <a href="#" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Logout</a>
      </div>
    </div>
  </nav>

  <!-- Search Bar & Tambah Peserta Button -->
  <div class="container mx-auto my-4 flex justify-between">
    <input type="text" id="search" placeholder="Cari peserta..." class="w-3/4 p-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
    <button id="add-peserta-btn" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">+ Tambah Peserta</button>
  </div>

  <!-- Form Tambah Peserta (Modal) -->
  <div id="add-peserta-form" class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
      <h2 class="text-xl font-bold text-blue-500 mb-4">Tambah Peserta Baru</h2>
      <form id="peserta-form">
        <div class="mb-4">
          <label for="name" class="block text-sm font-medium text-gray-700">Nama Lansia</label>
          <input type="text" id="name" class="w-full p-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Masukkan nama lansia">
        </div>
        <div class="mb-4">
          <label for="id" class="block text-sm font-medium text-gray-700">NIK Lansia</label>
          <input type="text" id="id" class="w-full p-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Masukkan NIK lansia">
        </div>
        <div class="mb-4">
          <label for="birth" class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
          <input type="date" id="birth" class="w-full p-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div class="mb-4">
          <label for="type" class="block text-sm font-medium text-gray-700">Alamat</label>
          <input type="text" id="type" class="w-full p-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Masukkan alamat">
        </div>
        <div class="mb-4">
          <label for="faskes" class="block text-sm font-medium text-gray-700">No WhatsApp</label>
          <input type="text" id="faskes" class="w-full p-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Masukan no whatsApp">
        </div>
        <div class="flex justify-end space-x-2">
          <button type="button" id="cancel-btn" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">Batal</button>
          <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Simpan</button>
        </div>
      </form>
    </div>
  </div>

  <!-- List Peserta -->
  <section class="container mx-auto px-4">
    <div id="list-peserta" class="space-y-4">
      <!-- Peserta akan dirender di sini -->
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-gray-800 text-white py-4 mt-10">
    <div class="container mx-auto text-center">
      <p>&copy; 2024 E-Posyandu. All rights reserved.</p>
    </div>
  </footer>

  <script>
    const addPesertaBtn = document.getElementById('add-peserta-btn');
    const addPesertaForm = document.getElementById('add-peserta-form');
    const cancelBtn = document.getElementById('cancel-btn');
    const pesertaForm = document.getElementById('peserta-form');
    const listPeserta = document.getElementById('list-peserta');
    const searchInput = document.getElementById('search');

    // Sample Data Peserta
    let peserta = [
      {
        name: 'KAMAL',
        status: 'AKTIF',
        id: '0003175481981',
        type: 'Peserta (Pekerja Mandiri)',
        birth: '13-04-1952',
        faskes: 'Puskesmas Kuta I',
        kelas: 'Kelas 3'
      },
      {
        name: 'M ADITYA PANGESTU',
        status: 'AKTIF',
        id: '0003175481992',
        type: 'Anak (Pekerja Mandiri)',
        birth: '09-07-2001',
        faskes: 'Puskesmas Kuta II',
        kelas: 'Kelas 3'
      }
    ];

    // Function for Rendering List
    function renderList(data) {
      listPeserta.innerHTML = '';
      data.forEach(item => {
        const card = `<div class="bg-white shadow-lg rounded-lg p-4 flex items-center justify-between">
          <div class="flex items-center">
            <img src="https://via.placeholder.com/50" alt="Avatar" class="rounded-full mr-4">
            <div>
              <h2 class="text-lg font-bold text-blue-500">${item.name} <span class="text-green-500">(${item.status})</span></h2>
              <p class="text-gray-600">${item.id} | ${item.type}</p>
              <p class="text-gray-500"><span class="inline-block">📅 Lahir: ${item.birth}</span> | <span class="inline-block">🏥 Faskes 1: ${item.faskes}</span></p>
            </div>
          </div>
          <span class="bg-blue-500 text-white px-3 py-1 rounded-full">${item.kelas}</span>
        </div>`;
        listPeserta.innerHTML += card;
      });
    }

    // Initial Render
    renderList(peserta);

    // Filter List
    searchInput.addEventListener('input', (e) => {
      const searchText = e.target.value.toLowerCase();
      const filteredPeserta = peserta.filter(p => 
        p.name.toLowerCase().includes(searchText) ||
        p.id.includes(searchText)
      );
      renderList(filteredPeserta);
    });

    // Show Form
    addPesertaBtn.addEventListener('click', () => {
      addPesertaForm.classList.remove('hidden');
    });

    // Cancel Form
    cancelBtn.addEventListener('click', () => {
      addPesertaForm.classList.add('hidden');
    });

    // Submit Form
    pesertaForm.addEventListener('submit', (e) => {
      e.preventDefault();
      const newPeserta = {
        name: document.getElementById('name').value,
        status: 'AKTIF', // Status default
        id: document.getElementById('id').value,
        type: document.getElementById('type').value,
        birth: document.getElementById('birth').value,
        faskes: document.getElementById('faskes').value,
        kelas: 'Kelas 3' // Default kelas
      };
      peserta.push(newPeserta);
      renderList(peserta);
      addPesertaForm.classList.add('hidden');
      pesertaForm.reset();
    });
  </script>

</body>
</html>
