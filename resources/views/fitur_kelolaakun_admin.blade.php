<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Akun Pengguna - Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<style>
    body {
        padding-top: 64px;
    }

    /* Pastikan konten tidak tertutup navbar */
</style>

<body class="bg-gray-100" x-data="appData()">
    @if (session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
            class="mb-4 rounded-lg border border-green-200 bg-green-100 p-4 fixed top-20 right-4 z-50 max-w-md shadow-lg"
            role="alert">
            <div class="flex items-center gap-2">
                <svg class="h-5 w-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="text-sm font-medium text-green-800">{{ session('success') }}</span>
                <button @click="show = false"
                    class="ml-auto rounded-lg p-1.5 text-green-500 hover:bg-green-200 inline-flex h-8 w-8 items-center justify-center">
                    <span class="sr-only">Close</span>
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
            class="mb-4 rounded-lg border border-red-200 bg-red-100 p-4 fixed top-20 right-4 z-50 max-w-md shadow-lg"
            role="alert">
            <div class="flex items-center gap-2">
                <svg class="h-5 w-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="text-sm font-medium text-red-800">{{ session('error') }}</span>
                <button @click="show = false"
                    class="ml-auto rounded-lg p-1.5 text-red-500 hover:bg-red-200 inline-flex h-8 w-8 items-center justify-center">
                    <span class="sr-only">Close</span>
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    @endif
    <!-- Container -->
    <div class="max-w-4xl mx-auto p-6">

        <!-- Navbar -->
        <nav class="bg-white shadow-md p-4 fixed top-0 left-0 right-0 z-10">
            <div class="container mx-auto flex items-center">
                <!-- Back Button -->
                <button onclick="window.location.href = '/dashboard/admin'" class="text-blue-500 focus:outline-none mr-4">
                    &larr; Back
                </button>
                <!-- Title -->
                <a href="#" class="text-2xl font-bold text-blue-500">Posyandu</a>
                <div class="ml-auto text-blue-500 font-sans">Akun Admin</div>
                <!-- Keterangan akun "Admin" muncul di mobile -->
            </div>
        </nav>


        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Kelola Akun Pengguna</h1>
            <button @click="showAddModal = true" class="bg-blue-500 text-white px-2 py-1 rounded">Tambah Akun</button>
        </div>

       <!-- Search Bar -->
       <div class="flex items-center mb-4">
        <input type="text" placeholder="Cari pengguna..." class="w-full p-2 border rounded" x-model="searchTerm">
    </div>

    <!-- Filtered User List -->
    <template x-for="user in filteredUsers" :key="user.id">
        <div class="bg-white shadow-lg rounded-lg p-6 mb-6 hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center space-x-6">
                <div class="flex-1">
                    <div class="flex justify-between items-start">
                        <h2 class="text-xl font-bold text-gray-800 mb-1" x-text="user.name"></h2>
                        <button @click="openEditModal(user.id, user.name, user.id_user, user.role)" class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Edit
                        </button>
                    </div>
                    <div class="text-sm text-gray-600">ID: <span x-text="user.id_user"></span></div>
                    <div class="text-sm text-gray-600">Role: <span x-text="user.role"></span></div>
                </div>
            </div>
        </div>
    </template>

       
        <!-- Modal Edit Pengguna -->
        <div x-show="showEditModal"
            class="fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center z-50">
            <form :action="'/users/' + editUser.id" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <div class="bg-white p-6 rounded shadow-lg max-w-lg w-full">
                    <h2 class="text-xl font-bold mb-4">Edit Akun Pengguna</h2>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">
                            Nama
                        </label>
                        <input type="text" name="name" x-model="editUser.name"
                            class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">
                            ID Pengguna
                        </label>
                        <input type="text" name="id_user" x-model="editUser.id_user"
                            class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('id_user')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">
                            Password Baru (Kosongkan jika tidak ingin mengubah)
                        </label>
                        <input type="password" name="password"
                            class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">
                            Role
                        </label>
                        <select name="role" x-model="editUser.role"
                            class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="admin">Admin</option>
                            <option value="petugas">Petugas</option>
                            <option value="pesertabalita">Peserta Balita</option>
                            <option value="pesertalansia">Peserta Lansia</option>
                        </select>
                        @error('role')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end space-x-2">
                        <button type="button" @click="showEditModal = false"
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 transition-colors">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition-colors">
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>
        </div>

      
<!-- Modal Tambah Pengguna -->
        <div x-show="showAddModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center">
            <form action="/register" method="post" class="space-y-4">
                @csrf
                <div class="bg-white p-6 rounded shadow-lg max-w-lg w-full">
                    <h2 class="text-xl mb-4">Tambah Akun Pengguna</h2>
                    <div class="mb-2">
                        <label class="block mb-1">Nama</label>
                        <input id="name" type="text" name="name" required
                            class="w-full p-2 border rounded">
                        @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-2">
                        <label class="block mb-1">Id Pengguna</label>
                        <input id="id_User" type="text" name="id_user" required
                            class="w-full p-2 border rounded">
                        @error('id_user')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-2">
                        <label class="block mb-1">Password</label>
                        <input id="password" type="password" name="password" required
                            class="w-full p-2 border rounded">
                        @error('password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-2">
                        <label class="block mb-1">Role</label>
                        <select id="role" name="role" class="w-full p-2 border rounded">
                            <option value="admin">Admin</option>
                            <option value="petugas">Petugas</option>
                            <option value="pesertabalita">Peserta Balita</option>
                            <option value="pesertalansia">Peserta Lansia</option>
                        </select>
                        @error('role')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end">
                        <button @click="showAddModal = false"
                            class="bg-gray-400 text-white px-4 py-2 rounded mr-2">Batal</button>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Tambah</button>

                    </div>
                </div>
            </form>
        </div>
    </div>

   <!-- Alpine.js Data -->
   <script>
    function appData() {
        return {
            showAddModal: false,
            showEditModal: false,
            searchTerm: '',
            users: @json($users), // Data pengguna dari backend
            editUser: {
                id: null,
                name: '',
                id_user: '',
                role: ''
            },
            openEditModal(id, name, id_user, role) {
                this.editUser = { id, name, id_user, role };
                this.showEditModal = true;
            },
            get filteredUsers() {
                if (this.searchTerm === '') {
                    return this.users;
                }
                return this.users.filter(user => user.name.toLowerCase().includes(this.searchTerm.toLowerCase()));
            }
        };
    }
</script>

</body>

</html>
