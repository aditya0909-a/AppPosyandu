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
  <div class="container mx-auto flex items-center">
    <!-- Title -->
    <a href="#" class="text-2xl font-bold text-blue-500">E-Posyandu</a>
    <div class="ml-auto text-blue-500 font-sans">Akun Kader</div> <!-- Keterangan akun "Kader" muncul di mobile -->
  </div>
</nav>


  <!-- Dashboard Grid -->
  <section class="container mx-auto py-10 px-4">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
      
      <!-- Posyandu Balita -->
      <a href="/fiturposyandubalita_kader" class="block bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg shadow-xl p-6 text-center transform hover:scale-105 transition-transform duration-300">
        <div class="text-4xl mb-4">👶</div>
        <h2 class="text-xl font-bold">Posyandu Balita</h2>
      </a>

      <!-- Posyandu Lansia -->
      <a href="/fiturposyandulansia_kader" class="block bg-gradient-to-r from-green-500 to-green-600 text-white rounded-lg shadow-xl p-6 text-center transform hover:scale-105 transition-transform duration-300">
        <div class="text-4xl mb-4">👴</div>
        <h2 class="text-xl font-bold">Posyandu Lansia</h2>
      </a>

       <!-- Imunisasi -->
       <a href="/fiturimunisasi_kader" class="block bg-gradient-to-r from-yellow-500 to-orange-500 text-white rounded-lg shadow-xl p-6 text-center transform hover:scale-105 transition-transform duration-300">
        <div class="text-4xl mb-4">💉</div>
        <h2 class="text-xl font-bold">Imunisasi</h2>
      </a>

       <!-- Jadwal -->
       <a href="/fiturpenjadwalan_kader" class="block bg-gradient-to-r from-purple-500 to-purple-600 text-white rounded-lg shadow-xl p-6 text-center transform hover:scale-105 transition-transform duration-300">
        <div class="text-4xl mb-4">📆</div>
        <h2 class="text-xl font-bold">Jadwal</h2>
      </a>

      <!-- Keluar -->
      <a href="/logout" class="block bg-gradient-to-r from-red-600 to-red-700 text-white rounded-lg shadow-xl p-6 text-center transform hover:scale-105 transition-transform duration-300">
        <div class="text-4xl mb-4">🗝️</div>
        <h2 class="text-xl font-bold">Logout</h2>
      </a>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-gray-800 text-white py-4 mt-10">
    <div class="container mx-auto text-center">
      <p>&copy; 2024 E-Posyandu. All rights reserved.</p>
    </div>
  </footer>

</body>
</html>
