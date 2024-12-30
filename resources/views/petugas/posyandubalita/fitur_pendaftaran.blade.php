<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Peserta Posyandu</title>

    
    <!-- Vite CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/axios@1.4.0/dist/axios.min.js"></script>

    <!-- Styles -->
    <style>
        body {
            background-color: #E6F7FF;
            color: #4A4A4A;
            padding-top: 64px;
            font-family: Arial, sans-serif;
        }

        .button-primary {
            background: linear-gradient(135deg, #0077B5, #0099CC);
            color: #FFFFFF;
            padding: 8px 10px;
            font-size: 1rem;
            border-radius: 8px;
            transition: transform 0.2s;
        }

        .search-input {
            width: 100%;
            padding: 12px 20px;
            border: 1px solid #ccc;
            border-radius: 24px;
            font-size: 1.1rem;
            outline: none;
            transition: all 0.3s ease;
        }

        .search-results {
            position: absolute;
            width: 100%;
            max-height: 250px;
            overflow-y: auto;
            background-color: #ffffff;
            border: 1px solid #d1d5db;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
            z-index: 10;
            padding: 8px 0;
            font-size: 1.2rem;
        }

        .participant-list {
            margin-top: 16px;
            padding: 16px;
            background-color: #FFFFFF;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body x-data="appData()">

    <!-- Container Utama -->
    <div class="max-w-4xl mx-auto p-6">

        <!-- Navigasi -->
        <nav class="navbar fixed top-0 left-0 right-0 z-10 p-4 shadow-md">
            <div class="container mx-auto flex items-center">
                <button onclick="window.location.href = '/fiturposyandu/petugas'" class="text-[#0077B5] mr-4">
                    &larr; Back
                </button>
                <a href="#" class="text-2xl font-bold text-[#0077B5]">Posyandu</a>
                <div class="ml-auto text-[#0077B5] font-sans">Akun Petugas</div>
            </div>
        </nav>


        <!-- Judul Halaman -->
        <div class="flex justify-between items-center mb-2 mt-4">
            <h1 class="text-2xl font-bold">Pendaftaran Peserta Posyandu</h1>
            <button @click="showAddModal = true" class="button-primary">Peserta Baru</button>
        </div>

        <!-- Komponen Pencarian dan Daftar -->
        <div class="relative mt-4">

            <!-- Input Pencarian -->
            <input type="text" placeholder="Cari peserta..." class="search-input" x-model="searchTerm" 
                   @input.debounce="fetchData" 
                   @focus="showResults = true" 
                   @blur="hideResults()" />

            <!-- Hasil Pencarian -->
            <ul x-show="showResults && results.length > 0" x-cloak class="search-results">
                <template x-for="(item, index) in results" :key="index">
                    <li @click="submitData(item)" class="cursor-pointer p-2 hover:bg-gray-200">
                        <span x-text="item.nama_peserta_balita"></span>
                    </li>
                </template>
                <li x-show="loading" class="p-2 text-gray-500">Loading...</li>
                <li x-show="!loading && results.length === 0 && searchTerm" class="p-2 text-gray-500">
                    No results found
                </li>
            </ul>

            
            
            <!-- Modal Peserta Baru -->

        <div x-show="showAddModal"
        class="modal-bg fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
            <form action="/pesertabarubalita" method="POST">
                @csrf
                <div class="bg-white relative w-full max-w-xs sm:max-w-sm mx-4 p-4 sm:p-6 rounded-lg shadow-lg overflow-y-auto max-h-[500px]">
                    <h2 class="text-xl font-bold mb-4">Peserta Baru Posyandu balita</h2>

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
                            Nama Orang Tua
                        </label>
                        <input type="text" name="nama_orangtua_balita" required
                            class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('nama_orangtua_balita')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">
                            NIK
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
                            class="px-4 py-2 button-primary">
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

        <div class="mb-6 mt-8">
            <h2 class="text-xl mb-4">Daftar Hadir Peserta</h2>
            
            
            @if($peserta->isEmpty())
                <p>Tidak ada peserta untuk jadwal ini.</p>
            @else
                <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-md">
                    <thead class="bg-blue-100">
                        <tr>
                            <th class="border-b border-gray-300 px-4 py-2 text-left text-sm font-medium text-gray-700">Nama Peserta</th>
                            <th class="border-b border-gray-300 px-4 py-2 text-left text-sm font-medium text-gray-700"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($peserta as $index => $item)
                            <tr class="hover:bg-blue-50">
                                <td class="border-b border-gray-300 px-4 py-2 text-sm text-gray-700">
                                    {{  $item->nama_peserta_balita }}
                                </td>
                                <td class="border-b border-gray-300 px-4 py-2 text-sm text-gray-700">
                                    <button 
                                        class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 focus:outline-none"
                                        @click="removeParticipant({{ json_encode($item) }}, {{ $index }})">
                                        Hapus
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

        
           
    
    <!-- Script  -->
    <script>

            function appData() {
            return {
                searchTerm: "",
                results: [],
                participants: [],
                loading: false,
                showResults: false,
                showAddModal: false,
                notification: "",
    
                // Data Dummy
                dummyData: [], // Data akan diambil dari server
    
                // Fetch data dari server saat komponen dimuat
                fetchDummyData() {
                    axios.get('/api/datapesertabalita') // Endpoint Laravel
                        .then(response => {
                            this.dummyData = response.data; // Simpan data ke dummyData
                        })
                        .catch(error => {
                            console.error("Error fetching data:", error);
                        });
                },
                    
                // Pencarian data
                fetchData() {
                    if (this.searchTerm.trim() === "") {
                        this.results = [];
                        this.showResults = false;
                        return;
                    }
                    this.loading = true;
    
                    // Simulasi pencarian dengan delay 300ms
                    setTimeout(() => {
                        this.results = this.dummyData.filter(item =>
                            item.nama_peserta_balita.toLowerCase().includes(this.searchTerm.toLowerCase())
                        );
                        this.loading = false;
                        this.showResults = true;
                    }, 300);
                },
    
                                
                // Kirim data peserta
                submitData(item) {
                    this.showResults = false; // Sembunyikan hasil pencarian
                    this.searchTerm = ""; // Reset input

                    // Kirim data ke backend menggunakan Axios
                    axios.post('/pendaftaran/fiturposyandubalita/store', {
                        _token: "{{ csrf_token() }}", // Token CSRF Laravel
                        jadwal_id: "{{ request()->segment(4) }}", // ID jadwal
                        peserta_id: item.id // ID peserta
                    })
                    .then(response => {
                        // Tambahkan peserta ke daftar hadir
                        
                        this.results = [];
                        this.searchTerm = "";
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat mendaftarkan peserta.');
                    });
                },
    
                // Hapus peserta
                
                removeParticipant(participant, index) {
                this.notification = ""; // Reset notifikasi

                axios.post('/pendaftaran/fiturposyandubalita/destroy', {
                    _token: "{{ csrf_token() }}", // Token CSRF
                    jadwal_id: "{{ request()->segment(4) }}", // Ambil jadwal ID dari segment URL
                    peserta_id: participant.id // ID peserta yang akan dihapus
                })
                .then(response => {
                    if (response.data.success) {
                        // Hapus peserta dari daftar hadir
                        this.participants.splice(index, 1);
                        this.notification = "Peserta berhasil dihapus.";
                    } else {
                        this.notification = "Gagal menghapus data. " + response.data.message;
                    }
                })
                .catch(error => {
                    console.error("Error:", error.response);
                    this.notification = "Terjadi kesalahan saat menghapus data. Silakan coba lagi.";
                });
                },

    
                // Sembunyikan hasil pencarian
                hideResults() {
                    setTimeout(() => {
                        this.showResults = false;
                    }, 200);
                },
    
                // Dipanggil saat komponen dimuat
                init() {
                    this.fetchDummyData();
                }

                
            };
        }
    
    </script>
    

</body>
</html>
