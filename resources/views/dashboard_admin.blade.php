<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Posyandu</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

  <!-- Navbar -->
  <nav class="bg-white shadow-md p-4">
    <div class="container mx-auto flex justify-between items-center">
      <a href="#" class="text-2xl font-bold text-blue-500">E-Posyandu</a>
      <div class="hidden lg:flex space-x-6 items-center">
        <a href="#" class="text-gray-700 hover:text-blue-500">Kelola Akun</a>
        <a href="#" class="text-gray-700 hover:text-blue-500">Penjadwalan</a>
        <a href="#" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Logout</a>
      </div>
    </div>
  </nav>

  <!-- Dashboard Grid -->
  <section class="container mx-auto py-10 px-4">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
      
      <!-- Data Anak -->
      <a href="/fitur_dataanak_admin" class="block bg-blue-500 text-white rounded-lg shadow-lg p-6 text-center transform hover:scale-105 transition-transform">
        <div class="text-4xl mb-4">👶</div>
        <h2 class="text-xl font-bold">Data Anak</h2>
      </a>

      <!-- Data Lansia -->
      <a href="/fitur_datalansia_admin" class="block bg-teal-500 text-white rounded-lg shadow-lg p-6 text-center transform hover:scale-105 transition-transform">
        <div class="text-4xl mb-4">👴</div>
        <h2 class="text-xl font-bold">Data Lansia</h2>
      </a>

      <!-- Penjadwalan -->
      <a href="/fitur_penjadwalan_admin" class="block bg-indigo-500 text-white rounded-lg shadow-lg p-6 text-center transform hover:scale-105 transition-transform">
        <div class="text-4xl mb-4">📅</div>
        <h2 class="text-xl font-bold">Penjadwalan</h2>
      </a>


      <!-- Kelola Akun -->
      <a href="/fitur_kelolaakun_admin" class="block bg-orange-500 text-white rounded-lg shadow-lg p-6 text-center transform hover:scale-105 transition-transform">
        <div class="text-4xl mb-4">⚙️</div>
        <h2 class="text-xl font-bold">Kelola Akun</h2>
      </a>

      <!-- Keluar -->
      <a href="/logout" class="block bg-red-500 text-white rounded-lg shadow-lg p-6 text-center transform hover:scale-105 transition-transform">
        <div class="text-4xl mb-4">🚪</div>
        <h2 class="text-xl font-bold">Keluar</h2>
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
