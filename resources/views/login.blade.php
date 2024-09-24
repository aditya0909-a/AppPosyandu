<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Posyandu App</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

  <!-- Container -->
  <div class="min-h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
      <!-- Logo -->
      <div class="text-center mb-6">
        <h1 class="text-3xl font-bold text-blue-500">Posyandu</h1>
        <p class="text-gray-600">Masuk ke akun Anda</p>
      </div>

      <!-- Login Form -->
      <form action="#" method="POST" class="space-y-4">
        <div>
          <label for="id" class="block text-sm font-medium text-gray-700">Id</label>
          <input id="id" type="id" name="id" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div>
          <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
          <input id="password" type="password" name="password" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div class="flex justify-between items-center">
          <label class="flex items-center">
            <input type="checkbox" name="remember" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
            <span class="ml-2 text-sm text-gray-600">Ingat Saya</span>
          </label>
          <a href="#" class="text-sm text-blue-500 hover:underline">Lupa password?</a>
        </div>
        <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600">Login</button>
      </form>

      <!-- Divider -->
      <div class="mt-6 flex items-center justify-center">
        <span class="text-gray-500">Belum punya akun?</span>
        <a href="#register" id="register-btn" class="ml-2 text-blue-500 hover:underline">Daftar</a>
      </div>
    </div>
  </div>

  <!-- Register Modal -->
  <div id="register-modal" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden flex items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md relative">
      <button id="close-register" class="absolute top-2 right-2 text-gray-600 hover:text-gray-800">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>
      
      <h2 class="text-center text-2xl font-bold mb-4 text-blue-500">Daftar Akun Baru</h2>
      <form action="/register" method="POST" class="space-y-4">
        @csrf
        <div>
          <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
          <input id="name" type="text" name="name" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div>
          <label for="id_user" class="block text-sm font-medium text-gray-700">Id</label>
          <input id="id_user" type="text" name="id_user" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div>
          <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
          <input id="password" type="password" name="password" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600">Daftar</button>
      </form>
    </div>
  </div>

  <!-- Script to Handle Modal -->
  <script>
    const registerBtn = document.getElementById('register-btn');
    const registerModal = document.getElementById('register-modal');
    const closeRegister = document.getElementById('close-register');

    registerBtn.addEventListener('click', (e) => {
      e.preventDefault();
      registerModal.classList.remove('hidden');
    });

    closeRegister.addEventListener('click', () => {
      registerModal.classList.add('hidden');
    });

    window.addEventListener('click', (e) => {
      if (e.target === registerModal) {
        registerModal.classList.add('hidden');
      }
    });
  </script>
</body>
</html>
