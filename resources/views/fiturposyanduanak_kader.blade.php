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

  <!-- Dashboard Grid -->
  <section class="container mx-auto py-10 px-4">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
      
      <!-- Pendaftaran -->
      <a href="/fiturposyanduanak_pendaftaran_kader" class="block bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg shadow-lg p-6 text-center transform hover:scale-105 transition-transform">
        <div class="text-4xl mb-4">📓</div>
        <h2 class="text-xl font-bold">Pendaftaran</h2>
      </a>

      <!-- Penimbangan -->
      <a href="/fiturposyanduanak_penimbangan_kader" class="block bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg shadow-lg p-6 text-center transform hover:scale-105 transition-transform">
        <div class="text-4xl mb-4">⚖</div>
        <h2 class="text-xl font-bold">Penimbangan</h2>
      </a>

      <!-- Pengukuran -->
      <a href="/fiturposyanduanak_pengukuran_kader" class="block bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg shadow-lg p-6 text-center transform hover:scale-105 transition-transform">
        <div class="text-4xl mb-4">📏</div>
        <h2 class="text-xl font-bold">Pengukuran</h2>
      </a>

      <!-- Kuisioner -->
      <a href="/fiturposyanduanak_kuisioner_kader" class="block bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg shadow-lg p-6 text-center transform hover:scale-105 transition-transform">
        <div class="text-4xl mb-4">🧾</div>
        <h2 class="text-xl font-bold">Kuisioner</h2>
      </a>

      <!-- Vitamin -->
      <a href="/fiturposyanduanak_vitamin_kader" class="block bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg shadow-lg p-6 text-center transform hover:scale-105 transition-transform">
        <div class="text-4xl mb-4">💊</div>
        <h2 class="text-xl font-bold">Vitamin</h2>
      </a>

      <!-- Susu -->
      <a href="/fiturposyanduanak_susu_kader" class="block bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg shadow-lg p-6 text-center transform hover:scale-105 transition-transform">
        <div class="text-4xl mb-4">🥛</div>
        <h2 class="text-xl font-bold">Susu</h2>
      </a>

      <!-- Peserta Posyandu Anak -->
      <a href="/fiturposyanduanak_peserta_kader" class="block bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg shadow-lg p-6 text-center transform hover:scale-105 transition-transform">
        <div class="text-4xl mb-4">👶</div>
        <h2 class="text-xl font-bold">Peserta Posyandu</h2>
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
