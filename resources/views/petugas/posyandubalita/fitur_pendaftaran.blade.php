<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Peserta Balita - Petugas</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            background-color: #E6F7FF;
            color: #4A4A4A;
            padding-top: 64px;
            font-family: Arial, sans-serif;
        }

        .navbar {
            background-color: rgba(0, 153, 204, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(0, 153, 204, 0.2);
        }

        .button-primary {
            background: linear-gradient(135deg, #0077B5, #0099CC);
            color: #FFFFFF;
            padding: 8px 16px;
            font-size: 1rem;
            border-radius: 8px;
            transition: transform 0.2s;
        }

        .button-primary:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        
        .input-field {
            width: 100%;
            padding: 8px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.2s;
        }

        .input-field:focus {
            border-color: #0077B5;
            outline: none;
        }

        .card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 20px;
            transition: transform 0.2s;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .modal-bg {
            background-color: rgba(0, 0, 0, 0.5);
        }
    </style>
</head>

<body x-data="appData()">

    @if (session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
        class="mb-4 fixed top-20 right-4 z-50 max-w-md shadow-lg glass-effect" role="alert">
        <div class="flex items-center gap-2">
            <span class="text-green-800 font-medium">{{ session('success') }}</span>
            <button @click="show = false" class="ml-auto p-1 text-green-500 hover:bg-green-200">
                <span class="sr-only">Close</span>
                &times;
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

    <div class="max-w-4xl mx-auto p-6">
        <nav class="navbar fixed top-0 left-0 right-0 z-10 p-4 shadow-md">
            <div class="container mx-auto flex items-center">
                <button onclick="window.location.href = '/fiturposyandubalita/petugas'" class="text-[#0077B5] mr-4">
                    &larr; Back
                </button>
                <a href="#" class="text-2xl font-bold text-[#0077B5]">Posyandu</a>
                <div class="ml-auto text-[#0077B5] font-sans">Akun Petugas</div>
            </div>
        </nav>

        <div class="flex justify-between items-center mb-6 mt-8">
            <h1 class="text-2xl font-bold">Pendaftaran Peserta Posyandu</h1>
            <button @click="showAddModal = true" class="button-primary">Peserta Baru</button>
        </div>

        <div x-data="searchBar()" class="max-w-4xl mx-auto p-6">
            <div class="relative">
                <input
                    type="text"
                    placeholder="Cari peserta..."
                    class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-200"
                    x-model="searchTerm"
                    @input.debounce="fetchData"
                    @focus="showResults = true"
                    @blur="hideResults()"
                />
                <ul
                    x-show="showResults && results.length > 0"
                    x-cloak
                    class="absolute w-full bg-white border border-gray-300 rounded-md shadow-md mt-1 max-h-40 overflow-auto"
                >
                    <template x-for="(item, index) in results" :key="index">
                        <li
                            class="p-2 hover:bg-gray-100 cursor-pointer"
                            @click="selectResult(item)"
                        >
                            <span x-text="item.name"></span>
                        </li>
                    </template>
                    <li x-show="loading" class="p-2 text-gray-500">Loading...</li>
                    <li x-show="!loading && results.length === 0 && searchTerm" class="p-2 text-gray-500">No results found</li>
                </ul>
            </div>
        </div>
    
        <script>
            function searchBar() {
                return {
                    searchTerm: "",
                    results: [],
                    loading: false,
                    showResults: false,
                    fetchData() {
                        if (this.searchTerm.trim() === "") {
                            this.results = [];
                            return;
                        }
    
                        this.loading = true;
    
                        // Ganti '/api/search' dengan URL API Laravel
                        fetch(`/api/search?query=${encodeURIComponent(this.searchTerm)}`)
                            .then((response) => response.json())
                            .then((data) => {
                                this.results = data;
                            })
                            .catch((error) => console.error("Error fetching data:", error))
                            .finally(() => {
                                this.loading = false;
                            });
                    },
                    selectResult(item) {
                        this.searchTerm = item.name; // Set searchTerm to the selected result
                        this.showResults = false;
                    },
                    hideResults() {
                        setTimeout(() => (this.showResults = false), 200); // Delay to ensure click registers
                    },
                };
            }
        </script>

        
        
        <!-- Modal Tambah Peserta -->

        <div x-show="showAddModal"
        class="modal-bg fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
            <form action="/pesertaposyandubalita" method="POST">
                @csrf
                @method('PUT')
                <div class="bg-white relative w-full max-w-xs sm:max-w-sm mx-4 p-4 sm:p-6 rounded-lg shadow-lg overflow-y-auto max-h-[500px]">
                    <h2 class="text-xl font-bold mb-4">Tambah Peserta Posyandu Balita</h2>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">
                            Nama
                        </label>
                        <input type="text" name="nama_peserta_balita" required
                            class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('nama_peserta_balita')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">
                            Tempat lahir
                        </label>
                        <input type="text" name="TempatLahir_balita" required
                            class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('TempatLahir_balita')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">
                            Tanggal Lahir
                        </label>
                        <input type="date" name="TanggalLahir_balita" required
                            class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('TanggalLahir_balita')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">
                            NIK
                        </label>
                        <input type="text" name="NIK_balita" required
                            class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('NIK_balita')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>


                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">
                            Nama Orang Tua Balita
                        </label>
                        <input type="text" name="nama_orangtua_balita" required
                            class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('nama_orangtua_balita')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">
                            NIK Orang Tua Balita
                        </label>
                        <input type="text" name="NIK_orangtua_balita" required
                            class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('NIK_orangtua_balita')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">
                            Alamat
                        </label>
                        <input type="text" name="alamat_balita" required
                            class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('alamat_balita')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">
                            Nomor Whatsapp
                        </label>
                        <input type="number" name="wa_balita" required
                            class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('wa_balita')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end space-x-2">
                        <button type="button" @click="showAddModal = false"
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 transition-colors">
                            Batal
                        </button>
                        <button type="submit"
                        class="button-primary">
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>
        </div>


   

</body>

</html>
