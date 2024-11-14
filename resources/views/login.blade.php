<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Posyandu Login</title>
    {{-- Import Library External: TailwindCSS & AlpineJS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">

              <!-- Alert Section -->
              @if (session()->has('loginError'))
              <div id="alert" class="bg-red-500 bg-opacity-90 text-white p-4 rounded mb-4" role="alert">
                  {{ session('loginError') }}
              </div>
          @endif

    <div class="min-h-screen flex items-center justify-center p-4 sm:p-8">
        <div class="bg-white p-6 sm:p-8 rounded-lg shadow-lg w-full max-w-md">

            <!-- Logo -->
            <div class="text-center mb-6">
                <a href="/welcome" class="text-2xl sm:text-3xl font-bold text-blue-500">Posyandu</a>
                <p class="text-gray-600">Masuk ke akun Anda</p>
            </div>

            <!-- Login Form -->
            <form action="/login" method="post" class="space-y-4">
                @csrf
                <div>
                    <label for="id_user" class="block text-sm font-medium text-gray-700">ID Pengguna</label>
                    <input id="id_user" type="text" name="id_user" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input id="password" type="password" name="password" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="flex justify-between items-center">
                    <label class="flex items-center">
                        <input type="checkbox" name="remember"
                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <span class="ml-2 text-sm text-gray-600">Ingat Saya</span>
                    </label>
                </div>
                <button type="submit"
                    class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600">Login</button>
            </form>

            <!-- Divider -->
            <div class="mt-6 flex items-center justify-center">
                <span class="text-gray-500">&copy; 2024 Posyandu App. All rights reserved</span>
            </div>
        </div>
    </div>

</body>

</html>
