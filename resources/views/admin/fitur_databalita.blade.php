<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Peserta Posyandu Balita - Admin</title>
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

<body>

    <div x-data="appData()" class="max-w-4xl mx-auto p-6">
            <nav class="navbar fixed top-0 left-0 right-0 z-10 p-4 shadow-md">
                <div class="container mx-auto flex items-center">
                    <button onclick="window.location.href = '/dashboard/admin/{{ $userId }}'" class="text-[#0077B5] mr-4">
                        &larr; Back
                    </button>
                    <a href="#" class="text-2xl font-bold text-[#0077B5]">Posyandu</a>
                    <div class="ml-auto text-[#0077B5] font-sans">Akun Admin</div>
                </div>
            </nav>
        
            <div class="flex justify-between items-center mb-6 mt-8">
                <h1 class="text-2xl font-bold">Data Peserta Posyandu Balita</h1>
                <button @click="showAddModal = true" class="button-primary">Tambah Peserta</button>
            </div>
        
            <div class="flex items-center mb-4">
                <input type="text" placeholder="Cari peserta..." class="input-field" x-model="searchTerm">
            </div>
        
            <!-- Filtered PesertaPosyanduBalita List -->
            <template x-for="item in filteredPesertaPosyanduBalitas" :key="item.id">
                <div class="card mb-6">
                    <div class="flex justify-between items-center">
                        <a :href="`/admin.databalita/${item.id}`">
                            <h2 class="text-xl font-bold" x-text="item.nama_peserta_balita"></h2>
                        </a>
                        <button 
                            @click="openEditModal(
                                item.id,
                                item.nama_peserta_balita,
                                item.TempatLahir_balita,
                                item.TanggalLahir_balita,
                                item.NIK_balita,
                                item.nama_orangtua_balita,
                                item.NIK_orangtua_balita,
                                item.alamat_balita,
                                item.wa_balita
                            )"
                            class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Edit
                        </button>
                    </div>
                    <div class="text-sm text-gray-600" x-text="`Tanggal Lahir: ${new Date(item.TanggalLahir_balita).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' })}`"></div>
                    <div class="text-sm text-gray-600" x-text="`NIK: ${item.NIK_balita}`"></div>
                </div>
            </template>
    
    



            <!-- Modal Edit Pengguna -->
            <div x-show="showEditModal"
            class="modal-bg fixed inset-0 flex items-center justify-center">
                <form :action="'/pesertaposyandubalita/' + editPesertaPosyanduBalita.id" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="bg-white relative w-full max-w-xs sm:max-w-sm mx-4 p-4 sm:p-6 rounded-lg shadow-lg overflow-y-auto max-h-[500px]">
                        <h2 class="text-xl font-bold mb-4">Edit Peserta Posyandu Balita</h2>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Nama
                            </label>
                            <input type="text" name="nama_peserta_balita"
                                x-model="editPesertaPosyanduBalita.nama_peserta_balita"
                                class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('nama_peserta_balita')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Tempat Lahir
                            </label>
                            <input type="text" name="TempatLahir_balita" x-model="editPesertaPosyanduBalita.TempatLahir_balita"
                                class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('TempatLahir_balita')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Tanggal Lahir
                            </label>
                            <input type="date" name="TanggalLahir_balita" x-model="editPesertaPosyanduBalita.TanggalLahir_balita"
                                class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('TanggalLahir_balita')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                NIK
                            </label>
                            <input type="text" name="NIK_balita" x-model="editPesertaPosyanduBalita.NIK_balita"
                                class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('NIK_balita')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>


                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Nama Orang Tua Balita
                            </label>
                            <input type="text" name="nama_orangtua_balita"
                                x-model="editPesertaPosyanduBalita.nama_orangtua_balita"
                                class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('nama_orangtua_balita')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                NIK Orang Tua Balita
                            </label>
                            <input type="text" name="NIK_orangtua_balita"
                                x-model="editPesertaPosyanduBalita.NIK_orangtua_balita"
                                class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('NIK_orangtua_balita')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Alamat
                            </label>
                            <input type="text" name="alamat_balita" x-model="editPesertaPosyanduBalita.alamat_balita"
                                class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('alamat_balita')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Nomor Whatsapp
                            </label>
                            <input type="text" name="wa_balita" x-model="editPesertaPosyanduBalita.wa_balita"
                                class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('wa_balita')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end space-x-2">
                            <button type="button" @click="showEditModal = false"
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


        <!-- Modal Tambah Peserta -->

        <div x-show="showAddModal"
        class="modal-bg fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
            <form action="/pesertaposyandubalita" method="POST">
                @csrf
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
                        <input type="text" name="wa_balita" required
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
                            Simpan
                        </button>
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
                PesertaPosyanduBalitas: @json($PesertaPosyanduBalitas), // Data pengguna dari backend
                editPesertaPosyanduBalita: {
                    id: null,
                    nama_peserta_balita: '',
                    TempatLahir_balita: '',
                    TanggalLahir_balita: '',
                    NIK_balita: '',
                    nama_orangtua_balita: '',
                    NIK_orangtua_balita: '',
                    alamat_balita: '',
                    wa_balita: ''
                },
                openEditModal(id, nama_peserta_balita, TempatLahir_balita, TanggalLahir_balita, NIK_balita, nama_orangtua_balita, NIK_orangtua_balita,
                    alamat_balita, wa_balita) {
                    this.editPesertaPosyanduBalita = {
                        id,
                        nama_peserta_balita,
                        TempatLahir_balita,
                        TanggalLahir_balita,
                        NIK_balita,
                        nama_orangtua_balita,
                        NIK_orangtua_balita,
                        alamat_balita,
                        wa_balita
                    };
                    this.showEditModal = true;
                },
                get filteredPesertaPosyanduBalitas() {
                    if (!this.searchTerm) {
                        return this.PesertaPosyanduBalitas;
                    }
                    return this.PesertaPosyanduBalitas.filter(item => 
                        item.nama_peserta_balita.toLowerCase().includes(this.searchTerm.toLowerCase())
                    );
                }
            };
        }
    </script>


</body>

</html>
