<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Penjadwalan Posyandu</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

  <!-- Navbar -->
  <nav class="bg-white shadow-md p-4">
    <div class="container mx-auto flex justify-between items-center">
      <a href="#" class="text-2xl font-bold text-blue-500">E-Posyandu</a>
      <div class="hidden lg:flex space-x-6 items-center">
        <a href="#" class="text-gray-700 hover:text-blue-500">Dashboard</a>
        <a href="#" class="text-gray-700 hover:text-blue-500">Jadwal</a>
        <a href="#" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Logout</a>
      </div>
    </div>
  </nav>

  <!-- Search Bar -->
  <div class="container mx-auto my-4 flex justify-between items-center">
    <input type="text" id="search" placeholder="Cari jadwal..." class="w-3/4 p-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
    <button id="add-schedule-btn" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">+ Tambah Jadwal</button>
  </div>

  <!-- Form Tambah Jadwal (Modal) -->
  <div id="add-schedule-form" class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
      <h2 class="text-xl font-bold text-blue-500 mb-4">Tambah Jadwal Baru</h2>
      <form id="schedule-form">
        <div class="mb-4">
          <label for="title" class="block text-sm font-medium text-gray-700">Nama Jadwal</label>
          <input type="text" id="title" class="w-full p-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Masukkan nama jadwal">
        </div>
        <div class="mb-4">
          <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
          <input type="text" id="description" class="w-full p-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Masukkan deskripsi">
        </div>
        <div class="mb-4">
          <label for="date" class="block text-sm font-medium text-gray-700">Tanggal</label>
          <input type="datetime-local" id="date" class="w-full p-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div class="flex justify-end space-x-2">
          <button type="button" id="cancel-btn" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">Batal</button>
          <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Simpan</button>
        </div>
      </form>
    </div>
  </div>

  <!-- List Penjadwalan -->
  <section class="container mx-auto px-4">
    <div id="list-jadwal" class="space-y-4">

      <!-- Card Jadwal -->
      <div class="bg-white shadow-lg rounded-lg p-4 flex items-center justify-between">
        <div>
          <h2 class="text-lg font-bold text-blue-500">Jadwal Imunisasi</h2>
          <p class="text-gray-600">Vaksinasi imunisasi untuk balita</p>
          <p class="text-gray-500"><span class="inline-block">🗓️ Kamis, 27 Sep 2024 - 10:00 AM</span></p>
        </div>
        <div class="flex space-x-2 items-center">
          <span class="bg-green-500 text-white px-3 py-1 rounded-full">Pending</span>
          <button class="bg-blue-500 text-white p-2 rounded-md hover:bg-blue-600">📅</button>
        </div>
      </div>

      <!-- Card Jadwal -->
      <div class="bg-white shadow-lg rounded-lg p-4 flex items-center justify-between">
        <div>
          <h2 class="text-lg font-bold text-blue-500">Jadwal Posyandu Lansia</h2>
          <p class="text-gray-600">Pemeriksaan kesehatan untuk lansia</p>
          <p class="text-gray-500"><span class="inline-block">🗓️ Jumat, 28 Sep 2024 - 09:00 AM</span></p>
        </div>
        <div class="flex space-x-2 items-center">
          <span class="bg-green-500 text-white px-3 py-1 rounded-full">Pending</span>
          <button class="bg-blue-500 text-white p-2 rounded-md hover:bg-blue-600">📅</button>
        </div>
      </div>

    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-gray-800 text-white py-4 mt-10">
    <div class="container mx-auto text-center">
      <p>&copy; 2024 E-Posyandu. All rights reserved.</p>
    </div>
  </footer>

  <script>
    const addScheduleBtn = document.getElementById('add-schedule-btn');
    const addScheduleForm = document.getElementById('add-schedule-form');
    const cancelBtn = document.getElementById('cancel-btn');
    const scheduleForm = document.getElementById('schedule-form');
    const listJadwal = document.getElementById('list-jadwal');

    // Sample Data
    let jadwal = [
      {
        title: 'Jadwal Imunisasi',
        description: 'Vaksinasi imunisasi untuk balita',
        date: 'Kamis, 27 Sep 2024 - 10:00 AM',
        status: 'Pending'
      },
      {
        title: 'Jadwal Posyandu Lansia',
        description: 'Pemeriksaan kesehatan untuk lansia',
        date: 'Jumat, 28 Sep 2024 - 09:00 AM',
        status: 'Pending'
      }
    ];

    // Function for Rendering List
    function renderList(data) {
      listJadwal.innerHTML = '';
      data.forEach(item => {
        const card = `<div class="bg-white shadow-lg rounded-lg p-4 flex items-center justify-between">
          <div>
            <h2 class="text-lg font-bold text-blue-500">${item.title}</h2>
            <p class="text-gray-600">${item.description}</p>
            <p class="text-gray-500"><span class="inline-block">🗓️ ${item.date}</span></p>
          </div>
          <div class="flex space-x-2 items-center">
            <span class="bg-green-500 text-white px-3 py-1 rounded-full">${item.status}</span>
            <button class="bg-blue-500 text-white p-2 rounded-md hover:bg-blue-600">📅</button>
          </div>
        </div>`;
        listJadwal.innerHTML += card;
      });
    }

    // Initial Render
    renderList(jadwal);

    // Show Form
    addScheduleBtn.addEventListener('click', () => {
      addScheduleForm.classList.remove('hidden');
    });

    // Cancel Form
    cancelBtn.addEventListener('click', () => {
      addScheduleForm.classList.add('hidden');
    });

    // Submit Form
    scheduleForm.addEventListener('submit', (e) => {
      e.preventDefault();
      const newJadwal = {
        title: document.getElementById('title').value,
        description: document.getElementById('description').value,
        date: new Date(document.getElementById('date').value).toLocaleString(),
        status: 'Pending'
      };
      jadwal.push(newJadwal);
      renderList(jadwal);
      addScheduleForm.classList.add('hidden');
      scheduleForm.reset();
    });
  </script>

</body>
</html>
