<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Posyandu</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body { padding-top: 64px; } /* Pastikan konten tidak tertutup navbar */
  </style>
</head>
<body class="bg-gray-100">

  <!-- Navbar -->
  <nav class="bg-white shadow-md p-4 fixed top-0 left-0 right-0 z-10">
    <div class="container mx-auto flex justify-between items-center">
      <a href="#" class="text-2xl font-bold text-blue-500">E-Posyandu</a>
      <div class="text-blue-500 font-sans">Akun Kader</div> <!-- Keterangan akun "Kader" muncul di mobile -->
    </div>
  </nav>

  <!-- Search Bar -->
  <div class="container mx-auto my-4 flex justify-between items-center p-4 sm:p-8">
    <input type="text" id="search" placeholder="Cari jadwal..." class="w-3/4 p-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
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


</body>
</html>
