<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Posyandu</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
      body {
        background-color: #E6F7FF; /* Biru Muda */
        color: #4A4A4A;
        padding-top: 64px;
        font-family: Arial, sans-serif;
      }
      .navbar, .glass-effect {
        background-color: rgba(0, 153, 204, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(0, 153, 204, 0.2);
      }
      .button-primary {
        background: linear-gradient(135deg, #0077B5, #0099CC);
        color: #FFFFFF;
      }
    </style>
  </head>

<body class="bg-gray-100">

    <!-- Navbar -->
<nav class="navbar shadow-md p-4 fixed top-0 left-0 right-0 z-10 glass-effect">
    <div class="container mx-auto flex items-center justify-between">
      <a href="#" class="text-3xl font-bold text-[#0077B5]">Posyandu</a>
      <div class="text-[#0077B5] font-sans">Akun Peserta Balita</div>
    </div>
  </nav>


    <!-- Dashboard Grid -->
<section class="container mx-auto py-10 px-4 p-6 sm:p-8">
    <h1 class="text-2xl font-bold text-center mb-8">Pilih Menu</h1>
    <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-3 gap-6">

            <!-- Data Peserta -->
            <a href="{{ url('/pesertabalita.databalita/' . $peserta->id) }}"
                class="block button-primary text-white rounded-lg shadow-lg p-6 text-center transform hover:scale-105 transition-transform">
                <img src="{{ asset('icons/baby.png') }}" alt="Data Peserta" class="w-16 h-16 mx-auto mb-4">
                <h2 class="text-xl font-bold">Data Peserta</h2>
                <p class="text-sm opacity-75">Informasi dan data kesehatan balita</p>
            </a>


            <!-- Jadwal -->
            <a href="/fiturjadwal/pesertabalita/{{ $userId }}"
                class="block button-primary text-white rounded-lg shadow-lg p-6 text-center transform hover:scale-105 transition-transform">
                <img src="{{ asset('icons/schedule.png') }}" alt="Jadwal" class="w-16 h-16 mx-auto mb-4">
                <h2 class="text-xl font-bold">Jadwal</h2>
                <p class="text-sm opacity-75">Informasi jadwal kegiatan posyandu</p>
            </a>
             <!-- Keluar -->
            <form action="/logout" method="POST">
                @csrf
                <button class="w-full h-full" type="submit">
                    <div
                        class="block button-primary text-white rounded-lg shadow-lg p-6 text-center transform hover:scale-105 transition-transform">
                        <img src="{{ asset('icons/logout.png') }}" alt="Keluar" class="w-16 h-16 mx-auto mb-4">
                        <h2 class="text-xl font-bold">Logout</h2>
                        <p class="text-sm opacity-75">Keluar dari akun peserta balita</p>
                    </div>
                </button>

            </form>
        </div>
    </section>

    <!-- Footer -->
<footer class="bg-[#0077B5] text-white py-4 mt-10 text-center">
    <p>&copy; 2024 E-Posyandu. All rights reserved.</p>
  </footer>

</body>

</html>
