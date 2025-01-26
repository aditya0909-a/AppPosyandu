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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


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

        #data-table tbody td {
        padding-left: 16px; /* Atur nilai padding sesuai kebutuhan */
        }

    </style>
</head>

<body x-data="appData()">

    <!-- Container Utama -->
    <div class="max-w-4xl mx-auto p-6">

        <!-- Navigasi -->
        <nav class="navbar fixed top-0 left-0 right-0 z-10 p-4 shadow-md">
            <div class="container mx-auto flex items-center">
                <button onclick="window.location.href = '/fiturposyandu/petugas/{{ $userId }}'" class="text-[#0077B5] mr-4">
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
                   @input.debounce="fetchDataPencarian" 
                   @focus="showResults = true" 
                   @blur="hideResults()" />

            <!-- Hasil Pencarian -->
            <ul x-show="showResults && results.length > 0" x-cloak class="search-results">
                <template x-for="(item, index) in results" :key="index">
                    <li @click="submitData(item)" class="cursor-pointer p-2 hover:bg-gray-200">
                        <span x-text="item.nama_peserta_lansia"></span>
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
            <form action="/pesertabarulansia" method="POST">
                @csrf
                <div class="bg-white relative w-full max-w-xs sm:max-w-sm mx-4 p-4 sm:p-6 rounded-lg shadow-lg overflow-y-auto max-h-[500px]">
                    <h2 class="text-xl font-bold mb-4">Peserta Baru Posyandu Lansia</h2>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">
                            Nama
                        </label>
                        <input type="text" name="nama_peserta_lansia" required
                            class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('nama_peserta_lansia')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">
                            Tempat lahir
                        </label>
                        <input type="text" name="TempatLahir_lansia" required
                            class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('TempatLahir_lansia')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">
                            Tanggal Lahir
                        </label>
                        <input type="date" name="TanggalLahir_lansia" required
                            class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('TanggalLahir_lansia')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">
                            NIK
                        </label>
                        <input type="text" name="NIK_lansia" required
                            class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('NIK_lansia')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>


                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">
                            Alamat
                        </label>
                        <input type="text" name="alamat_lansia" required
                            class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('alamat_lansia')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">
                            Nomor Whatsapp
                        </label>
                        <input type="number" name="wa_lansia" required
                            class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('wa_lansia')
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
                <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-md" id="data-table">
                    <thead class="bg-blue-100">
                        <tr>
                            <th class="border-b border-gray-300 px-4 py-2 text-left text-sm font-medium text-gray-700">Nama Peserta</th>
                            <th class="border-b border-gray-300 px-4 py-2 text-left text-sm font-medium text-gray-700"></th>
                        </tr>
                    </thead>
                    <tbody >
                       
                    </tbody>
                </table>
        </div>
          
    
    <!-- Script  -->
    <script>
        function appData() {
            return {
                searchTerm: "",
                results: [],
                peserta: [],
                pesertajadwal: [],
                loading: false,
                showResults: false,
                showAddModal: false,
                notification: "",
                jadwalId: "{{ request()->segment(4) }}",  // Ambil jadwalId dari URL
                
                // Dipanggil saat komponen dimuat
                init() {
                    this.fetchDataPeserta(); // Ambil data peserta lansia saat inisialisasi
                    this.fetchDataPesertaByJadwal(this.jadwalId); // Ambil data peserta berdasarkan jadwal 
                },

                fetchDataPeserta() {
                    axios.get('/api/datapesertalansia') // Endpoint Laravel
                        .then(response => {
                            this.peserta = response.data; // Simpan data ke dummyData
                        })
                        .catch(error => {
                            console.error("Error fetching data:", error);
                        });
                },

                // Pencarian data
                fetchDataPencarian() {
                    if (this.searchTerm.trim() === "") {
                        this.results = [];
                        this.showResults = false;
                        return;
                    }
                    this.loading = true;
    
                    // Simulasi pencarian dengan delay 300ms
                    setTimeout(() => {
                        this.results = this.peserta.filter(item =>
                            item.nama_peserta_lansia.toLowerCase().includes(this.searchTerm.toLowerCase())
                        );
                        this.loading = false;
                        this.showResults = true;
                    }, 300);
                },
    
                // Mengambil data peserta berdasarkan jadwal
                fetchDataPesertaByJadwal(jadwalId) {
                    axios.get(`/peserta/${jadwalId}`) // Endpoint Laravel dengan jadwalId
                        .then(response => {
                            this.pesertajadwal = response.data; // Simpan data ke pesertajadwal
                            this.updateTable(); // Memperbarui tampilan tabel setelah mendapatkan data
                        })
                        .catch(error => {
                            console.error("Error fetching data by jadwal:", error);
                        });
                },
    
                updateTable() {
                    const tableBody = document.getElementById('data-table').querySelector('tbody');
                    tableBody.innerHTML = ''; // Kosongkan tabel sebelum menambahkan data baru
            
                    this.pesertajadwal.forEach((item) => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${item.nama_peserta_lansia}</td>
                            <td>
                                <button 
                                    class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 focus:outline-none">
                                    Hapus
                                </button>
                            </td>
                        `;

                        // Menambahkan event listener pada tombol untuk menjalankan removePeserta
                        const removeButton = row.querySelector('button');
                        removeButton.addEventListener('click', () => this.removepeserta(item));

                        tableBody.appendChild(row);
                    });
                },

                // Hapus peserta berdasarkan item
                removepeserta(item) {
                    axios.post('/pendaftaran/fiturposyandulansia/destroy', {
                        _token: "{{ csrf_token() }}", // Token CSRF
                        jadwal_id: "{{ request()->segment(4) }}", // Ambil jadwal ID dari segment URL
                        peserta_id: item.id // ID peserta yang akan dihapus
                    })
                    .then(response => {
                        this.fetchDataPesertaByJadwal(this.jadwalId); // Panggil fungsi fetchDataPesertaByJadwal
                    })
                    .catch(error => {
                        console.error("Error:", error.response);
                        this.notification = "Terjadi kesalahan saat menghapus data. Silakan coba lagi.";
                    });
                },
    
                // Kirim data peserta
                submitData(item) {
                    this.showResults = false; // Sembunyikan hasil pencarian
                    this.searchTerm = ""; // Reset input

                    // Kirim data ke backend menggunakan Axios
                    axios.post('/pendaftaran/fiturposyandulansia/store', {
                        _token: "{{ csrf_token() }}", // Token CSRF Laravel
                        jadwal_id: "{{ request()->segment(4) }}", // ID jadwal
                        peserta_id: item.id // ID peserta
                    })
                    .then(response => {
                        this.fetchDataPesertaByJadwal(this.jadwalId); // Panggil fungsi fetchDataPesertaByJadwal
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat mendaftarkan peserta.');
                    });
                },

                hideResults() {
                    setTimeout(() => {
                        this.showResults = false;
                    }, 200);
                },

    
        
            };
        }
    </script>
    
    

</body>
</html>