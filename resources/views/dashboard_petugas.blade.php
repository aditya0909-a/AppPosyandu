<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Posyandu</title>
    
    <style>
        body {
            padding-top: 64px;
        }
    </style>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
        
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        </head>

<body class="bg-gray-100">

    <!-- Navbar -->
    <nav class="bg-white shadow-md p-4 fixed top-0 left-0 right-0 z-10">
        <div class="container mx-auto flex items-center ">
            <!-- Title -->
            <a href="#" class="text-2xl font-bold text-blue-500 font-poppins">Posyandu</a>
            <div class="ml-auto text-blue-500 font-poppins ">Akun Petugas</div>
            <!-- Keterangan akun "Petugas" muncul di mobile -->
        </div>
    </nav>


    <!-- Dashboard Grid -->
    <section class="container mx-auto py-10 px-4 font-poppins">
        <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Posyandu Balita -->
            <a href="/fiturposyandubalita_petugas"
                class="block bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg shadow-xl p-6 text-center transform hover:scale-105 transition-transform duration-300">
                <img src="{{ asset('icons/baby.png') }}" alt="Posyandu Balita" class="w-12 h-12 mx-auto">
                <h2 class="text-xl font-bold">Posyandu Balita</h2>
            </a>

            <!-- Posyandu Lansia -->
            <a href="/fiturposyandulansia_petugas"
                class="block bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg shadow-xl p-6 text-center transform hover:scale-105 transition-transform duration-300">
                <img src="{{ asset('icons/grandparents.png') }}" alt="Posyandu Lansia" class="w-12 h-12 mx-auto">
                <h2 class="text-xl font-bold">Posyandu Lansia</h2>
            </a>

            <!-- Jadwal -->
            <a href="/fiturpenjadwalan_petugas"
                class="block bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg shadow-xl p-6 text-center transform hover:scale-105 transition-transform duration-300">
                <img src="{{ asset('icons/schedule.png') }}" alt="Jadwal" class="w-12 h-12 mx-auto">
                <h2 class="text-xl font-bold">Jadwal</h2>
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
