<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PosyanduGo Landing Page</title>
  {{-- Import Library External: TailwindCSS & AlpineJS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <div class="container">
</head>
<style>
  body { padding-top: 90px; } /* Pastikan konten tidak tertutup navbar */
  
</style>
<body class="bg-gray-100">

  <!-- Navbar -->
  <nav class=" bg-white navbar shadow-md p-4 fixed top-0 left-0 right-0 z-10">
    <div class="container mx-auto flex justify-between items-center p-4 sm:p-4">
      <a href="#" class="text-2xl font-bold text-[#0077B5]">Posyandu</a>
      <!-- Mobile menu button -->
      <div class="lg:hidden">
        <button id="menu-button" class="text-gray-500 focus:outline-none">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/>
          </svg>
        </button>
      </div>

     
      <!-- Links -->
      <div class="hidden lg:flex space-x-6 items-center">
        <a href="#features" class="text-gray-700 hover:text-blue-500">Features</a>
        <a href="#about" class="text-gray-700 hover:text-blue-500">About Us</a>
        <a href="#contact" class="text-gray-700 hover:text-blue-500">Contact</a>
      </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="hidden lg:hidden">
      <a href="#features" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Features</a>
      <a href="#about" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">About Us</a>
      <a href="#contact" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Contact</a>
    </div>
  </nav>

  <!-- Hero Section -->
  <section class="bg-[#0077B5] text-white py-20">
    <div class="container mx-auto text-center p-6 sm:p-8">
      <h1 class="text-4xl font-bold mb-4">Welcome to Posyandu App</h1>
      <p class="text-lg mb-6">Posyandu digital yang mempermudah pelayanan kesehatan balita dan lansia.</p>
      <a href="/login" class="bg-white text-[#0077B5] px-6 py-3 rounded font-semibold hover:bg-gray-100">Get Started</a>
    </div>
  </section>

  <!-- Features Section -->
  <section id="features" class="py-20">
    <div class="container mx-auto text-center p-6 sm:p-8">
      <h2 class="text-3xl font-bold mb-6">Features</h2>
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-lg shadow-lg">
          <h3 class="text-xl font-semibold mb-4">Pencatatan Kesehatan</h3>
          <p>Pencatatan riwayat kesehatan ibu dan anak menjadi lebih mudah dan praktis.</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-lg">
          <h3 class="text-xl font-semibold mb-4">Jadwal Imunisasi</h3>
          <p>Pengingat jadwal imunisasi agar anak tetap mendapatkan vaksin sesuai jadwal.</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-lg">
          <h3 class="text-xl font-semibold mb-4">Layanan Konsultasi</h3>
          <p>Konsultasi dengan tenaga medis yang profesional secara langsung melalui aplikasi.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- About Us Section -->
  <section id="about" class="bg-gray-100 py-20 p-6 sm:p-8">
    <div class="container mx-auto text-center">
      <h2 class="text-3xl font-bold mb-6">About Us</h2>
      <p class="text-lg">Kami berkomitmen untuk meningkatkan kesehatan ibu dan anak di Indonesia melalui aplikasi yang mudah diakses oleh masyarakat umum.</p>
    </div>
  </section>

  <!-- Contact Section -->
  <section id="contact" class="py-20 p-6 sm:p-8">
    <div class="container mx-auto text-center">
      <h2 class="text-3xl font-bold mb-6">Contact Us</h2>
      <p class="text-lg">Hubungi kami di email: <a href="mailto:info@posyanduapp.com" class="text-blue-500 hover:underline">info@posyanduapp.com</a></p>
    </div>
  </section>

  <!-- Footer -->
<footer class="bg-[#0077B5] text-white py-4 mt-10 text-center">
  <p>&copy; 2024 PosyanduGo. All rights reserved.</p>
</footer>

  <!-- Toggle Mobile Menu -->
  <script>
    const menuButton = document.getElementById('menu-button');
    const mobileMenu = document.getElementById('mobile-menu');

    menuButton.addEventListener('click', () => {
      mobileMenu.classList.toggle('hidden');
    });
  </script>

</body>
</html>
