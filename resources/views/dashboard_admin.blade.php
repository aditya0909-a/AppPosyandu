<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Posyandu</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <style>
    body { padding-top: 64px; } /* Pastikan konten tidak tertutup navbar */
  </style>
</head>
<body class="bg-gray-100">

<!-- Navbar -->
<nav class="bg-white shadow-md p-4 fixed top-0 left-0 right-0 z-10">
  <div class="container mx-auto flex items-center">
    <!-- Title -->
    <a href="#" class="text-2xl font-bold text-blue-500">Posyandu</a>
    <div class="ml-auto text-blue-500 font-sans">Akun Admin</div> <!-- Keterangan akun "Admin" muncul di mobile -->
  </div>
</nav>

  <!-- Dashboard Grid -->
  <section class="container mx-auto py-10 px-4 p-6 sm:p-8">
    <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-3 gap-6">
      
      <!-- Data Balita -->
      <a href="/fitur_databalita_admin" class="block bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg shadow-lg p-6 text-center transform hover:scale-105 transition-transform">
        <img src="{{ asset('icons/baby.png') }}" alt="Data Balita" class="w-12 h-12 mx-auto">
        <h2 class="text-xl font-bold">Data Balita</h2>
      </a>

      <!-- Data Lansia -->
      <a href="/fitur_datalansia_admin" class="block bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg shadow-lg p-6 text-center transform hover:scale-105 transition-transform">
        <img src="{{ asset('icons/grandparents.png') }}" alt="Data Lansia" class="w-12 h-12 mx-auto">
        <h2 class="text-xl font-bold">Data Lansia</h2>
      </a>

      <!-- Penjadwalan -->
      <a href="/fitur_penjadwalan_admin" class="block bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg shadow-lg p-6 text-center transform hover:scale-105 transition-transform">
        <img src="{{ asset('icons/schedule.png') }}" alt="Penjadwalan" class="w-12 h-12 mx-auto">
        <h2 class="text-xl font-bold">Penjadwalan</h2>
      </a>


      <!-- Kelola Akun -->
      <a href="/fitur_kelolaakun_admin" class="block bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg shadow-lg p-6 text-center transform hover:scale-105 transition-transform">
        <img src="{{ asset('icons/account.png') }}" alt="Kelola Akun" class="w-12 h-12 mx-auto">
        <h2 class="text-xl font-bold">Kelola Akun</h2>
      </a>

      <!-- Keluar -->
      <form action="/logout" method="POST">
        @csrf
        <button class="w-full h-full" type="submit">
            <div
                class=" bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg shadow-xl p-6 text-center transform hover:scale-105 transition-transform duration-300">
                <img src="{{ asset('icons/logout.png') }}" alt="Keluar" class="w-12 h-12 mx-auto">
                <h2 class="text-xl font-bold">Logout</h2>
            </div>
        </button>

    </form>
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
