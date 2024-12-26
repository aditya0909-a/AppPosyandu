<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Posyandu - Admin</title>
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
            background: linear-gradient(135deg, #0077B5, #0099CC) !important;
            color: #FFFFFF !important;
            padding: 8px 16px !important;
            font-size: 1rem;
            border-radius: 8px !important;
            transition: transform 0.2s !important;
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
    @if ($errors->any())
        <div class="p-4 mb-4 text-red-700 bg-red-100 rounded">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 9000)"
            class="fixed z-50 max-w-md p-4 mb-4 bg-green-100 border border-green-200 rounded-lg shadow-lg top-20 right-4"
            role="alert">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="text-sm font-medium text-green-800">{{ session('success') }}</span>
                <button @click="show = false"
                    class="ml-auto rounded-lg p-1.5 text-green-500 hover:bg-green-200 inline-flex h-8 w-8 items-center justify-center">
                    <span class="sr-only">Close</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    @endif


    @if (session('error'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
            class="fixed z-50 max-w-md p-4 mb-4 bg-red-100 border border-red-200 rounded-lg shadow-lg top-20 right-4"
            role="alert">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="text-sm font-medium text-red-800">{{ session('error') }}</span>
                <button @click="show = false"
                    class="ml-auto rounded-lg p-1.5 text-red-500 hover:bg-red-200 inline-flex h-8 w-8 items-center justify-center">
                    <span class="sr-only">Close</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    @endif

    <!-- Container -->
    <div class="max-w-4xl p-6 mx-auto">
        <nav class="fixed top-0 left-0 right-0 z-10 p-4 shadow-md navbar">
            <div class="container flex items-center mx-auto">
                <button onclick="window.location.href = '/dashboard/admin'" class="text-[#0077B5] mr-4">
                    &larr; Back
                </button>
                <a href="#" class="text-2xl font-bold text-[#0077B5]">Posyandu</a>
                <div class="ml-auto text-[#0077B5] font-sans">Akun Admin</div>
            </div>
        </nav>

        <div class="flex items-center justify-between mt-8 mb-4">
            <h1 class="text-2xl font-bold">Daftar Jadwal Posyandu</h1>
            <button @click="showAddModal = true" class="px-4 py-2 button-primary">Tambah Jadwal</button>
        </div>

        <div class="flex items-center mb-4">
            <input type="text" placeholder="Cari jadwal..." class="input-field" x-model="searchTerm">
        </div>


        <!-- Filtered Jadwal List -->
        <template x-for="jadwal in filteredJadwals" :key="jadwal.id">
            <div class="p-4 mb-6 rounded-lg card"
                :class="{
                    'bg-gray-200': normalizeDate(jadwal.date) < normalizeDate(new Date()), // Abu-abu jika sudah lewat
                    'bg-white': normalizeDate(jadwal.date) >= normalizeDate(new Date()) // Putih jika belum
                }">
                <div class="flex items-center justify-between">
                    <a :href="'/DataPenjadwalan_admin/' + jadwal.id">
                        <h2 class="text-xl font-bold" x-text="jadwal.name"></h2>
                    </a>
                    <button
                        @click="openEditModal(
                        jadwal.id, 
                        jadwal.name, 
                        jadwal.location, 
                        jadwal.date, 
                        jadwal.imunisasi, 
                        jadwal.obatcacing, 
                        jadwal.susu, 
                        jadwal.kuisioner, 
                        jadwal.keluhan, 
                        jadwal.teskognitif, 
                        jadwal.tesdengar, 
                        jadwal.teslihat, 
                        jadwal.tesmobilisasi
                    )"
                        class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Edit
                    </button>
                </div>
                <div class="text-sm text-gray-600">Tanggal: <span x-text="jadwal.formatted_date"></span></div>
                <div class="text-sm text-gray-600">Lokasi: <span x-text="jadwal.location"></span></div>
            </div>
        </template>


        <!-- Modal Tambah Jadwal -->
        <div x-show="showAddModal"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 modal-bg">
            <form method="POST" action="/jadwal/tambah" class="space-y-4">
                @csrf
                <div
                    class="bg-white relative w-full max-w-xs sm:max-w-sm mx-4 p-4 sm:p-6 rounded-lg shadow-lg overflow-y-auto max-h-[500px]">
                    <h2 class="mb-4 text-xl font-bold">Tambah Jadwal Posyandu</h2>

                    <!-- Nama Posyandu -->
                    <div class="mb-2">
                        <label class="block mb-2 text-sm font-bold text-gray-700">Nama Posyandu</label>
                        <select id="name" name="name" class="w-full p-2 border rounded"
                            x-model="posyanduType">
                            <option value="">Pilih Posyandu</option>
                            <option value="Posyandu Balita">Posyandu Balita</option>
                            <option value="Posyandu Lansia">Posyandu Lansia</option>
                        </select>
                        @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Lokasi -->
                    <div class="mb-2">
                        <label class="block mb-2 text-sm font-bold text-gray-700">Lokasi Jadwal</label>
                        <select id="location" name="location" class="w-full p-2 border rounded">
                            <template x-for="location in locations" :key="location">
                                <option :value="location" x-text="location"></option>
                            </template>
                        </select>
                        @error('location')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tanggal Jadwal -->
                    <div class="mb-2">
                        <label class="block mb-2 text-sm font-bold text-gray-700">Tanggal Jadwal</label>
                        <input id="date" type="date" name="date" required
                            class="w-full p-2 border rounded">
                        @error('date')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Checkbox Posyandu Balita -->
                    <div x-show="posyanduType === 'Posyandu Balita'">
                        <div class="flex items-center mb-2">
                            <input id="imunisasi" type="checkbox" name="imunisasi" value="1" class="mr-2">
                            <label for="imunisasi" class="inline-block">Imunisasi</label>
                        </div>
                        <div class="flex items-center mb-2">
                            <input id="obatcacing" type="checkbox" name="obatcacing" value="1" class="mr-2">
                            <label for="obatcacing" class="inline-block">Obat Cacing</label>
                        </div>
                        <div class="flex items-center mb-2">
                            <input id="susu" type="checkbox" name="susu" value="1" class="mr-2">
                            <label for="susu" class="inline-block">Susu</label>
                        </div>
                        <div class="flex items-center mb-2">
                            <input id="kuisioner" type="checkbox" name="kuisioner" value="1" class="mr-2">
                            <label for="kuisioner" class="inline-block">Kuisioner</label>
                        </div>
                        <div class="flex items-center mb-2">
                            <input id="keluhan" type="checkbox" name="keluhan" value="1" class="mr-2">
                            <label for="keluhan" class="inline-block">Keluhan</label>
                        </div>
                    </div>

                    <!-- Checkbox Posyandu Lansia -->
                    <div x-show="posyanduType === 'Posyandu Lansia'">
                        <div class="flex items-center mb-2">
                            <input id="teskognitif" type="checkbox" name="teskognitif" value="1"
                                class="mr-2">
                            <label for="teskognitif" class="inline-block">Tes Kognitif</label>
                        </div>
                        <div class="flex items-center mb-2">
                            <input id="tesdengar" type="checkbox" name="tesdengar" value="1" class="mr-2">
                            <label for="tesdengar" class="inline-block">Tes Dengar</label>
                        </div>
                        <div class="flex items-center mb-2">
                            <input id="teslihat" type="checkbox" name="teslihat" value="1" class="mr-2">
                            <label for="teslihat" class="inline-block">Tes Lihat</label>
                        </div>
                        <div class="flex items-center mb-2">
                            <input id="tesmobilisasi" type="checkbox" name="tesmobilisasi" value="1"
                                class="mr-2">
                            <label for="tesmobilisasi" class="inline-block">Tes Mobilisasi</label>
                        </div>
                        <div class="flex items-center mb-2">
                            <input id="keluhan" type="checkbox" name="keluhan" value="1" class="mr-2">
                            <label for="keluhan" class="inline-block">Keluhan</label>
                        </div>
                    </div>


                    <div class="flex justify-end">
                        <button @click="resetAddModal" type="button"
                            class="px-4 py-2 mr-2 text-white bg-gray-400 rounded">Batal</button>
                        <button type="submit" class="button-primary">Tambah</button>
                    </div>
                </div>
            </form>
        </div>


        <!-- Modal Edit Jadwal -->
        <div x-show="showEditModal" class="fixed inset-0 flex items-center justify-center modal-bg">
            <form :action="'/jadwal/update/' + editJadwal.id" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <div
                    class="bg-white relative w-full max-w-xs sm:max-w-sm mx-4 p-4 sm:p-6 rounded-lg shadow-lg overflow-y-auto max-h-[500px]">
                    <h2 class="mb-4 text-xl font-bold">Edit Jadwal Posyandu</h2>

                    <!-- Nama Posyandu -->
                    <div class="mb-2">
                        <label for="name" class="block mb-2 text-sm font-bold text-gray-700">Nama Posyandu</label>
                        <select id="name" name="name" class="w-full p-2 border rounded"
                            x-model="editJadwal.name">
                            <option value="Posyandu Balita">Posyandu Balita</option>
                            <option value="Posyandu Lansia">Posyandu Lansia</option>
                        </select>
                        @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Lokasi -->
                    <div class="mb-2">
                        <label for="location" class="block mb-2 text-sm font-bold text-gray-700">Lokasi Jadwal</label>
                        <select id="location" name="location" class="w-full p-2 border rounded"
                            x-model="editJadwal.location">
                            <option value="Bingin">Bingin</option>
                            <option value="Desa">Desa</option>
                            <option value="Dajan Pangkung">Dajan Pangkung</option>
                        </select>
                        @error('location')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tanggal Jadwal -->
                    <div class="mb-2">
                        <label for="date" class="block mb-2 text-sm font-bold text-gray-700">Tanggal
                            Jadwal</label>
                        <input id="date" type="datetime-local" name="date" x-model="editJadwal.date"
                            required class="w-full p-2 border rounded">
                        @error('date')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Checkbox untuk Posyandu Balita -->
                    <template x-if="editJadwal.name === 'Posyandu Balita'">
                        <div>
                            <div class="flex items-center mb-2">
                                <input id="imunisasi" type="checkbox" name="imunisasi"
                                    x-model="editJadwal.imunisasi" :value="1" :unchecked-value="0"
                                    class="mr-2">
                                <label for="imunisasi">Imunisasi</label>
                            </div>
                            <div class="flex items-center mb-2">
                                <input id="obatcacing" type="checkbox" name="obatcacing"
                                    x-model="editJadwal.obatcacing" :value="1" :unchecked-value="0"
                                    class="mr-2">
                                <label for="obatcacing">Obat Cacing</label>
                            </div>
                            <div class="flex items-center mb-2">
                                <input id="susu" type="checkbox" name="susu" x-model="editJadwal.susu"
                                    :value="1" :unchecked-value="0" class="mr-2">
                                <label for="susu">Susu</label>
                            </div>
                            <div class="flex items-center mb-2">
                                <input id="kuisioner" type="checkbox" name="kuisioner"
                                    x-model="editJadwal.kuisioner" :value="1" :unchecked-value="0"
                                    class="mr-2">
                                <label for="kuisioner">Kuisioner</label>
                            </div>
                            <div class="flex items-center mb-2">
                                <input id="keluhan" type="checkbox" name="keluhan" x-model="editJadwal.keluhan"
                                    :value="1" :unchecked-value="0" class="mr-2">
                                <label for="keluhan">Keluhan</label>
                            </div>
                        </div>
                    </template>

                    <!-- Checkbox untuk Posyandu Lansia -->
                    <template x-if="editJadwal.name === 'Posyandu Lansia'">
                        <div>
                            <div class="flex items-center mb-2">
                                <input id="teskognitif" type="checkbox" name="teskognitif"
                                    x-model="editJadwal.teskognitif" :value="1" :unchecked-value="0"
                                    class="mr-2">
                                <label for="teskognitif">Tes Kognitif</label>
                            </div>
                            <div class="flex items-center mb-2">
                                <input id="tesdengar" type="checkbox" name="tesdengar"
                                    x-model="editJadwal.tesdengar" :value="1" :unchecked-value="0"
                                    class="mr-2">
                                <label for="tesdengar">Tes Dengar</label>
                            </div>
                            <div class="flex items-center mb-2">
                                <input id="teslihat" type="checkbox" name="teslihat" x-model="editJadwal.teslihat"
                                    :value="1" :unchecked-value="0" class="mr-2">
                                <label for="teslihat">Tes Lihat</label>
                            </div>
                            <div class="flex items-center mb-2">
                                <input id="tesmobilisasi" type="checkbox" name="tesmobilisasi"
                                    x-model="editJadwal.tesmobilisasi" :value="1" :unchecked-value="0"
                                    class="mr-2">
                                <label for="tesmobilisasi">Tes Mobilisasi</label>
                            </div>
                            <div class="flex items-center mb-2">
                                <input id="keluhan" type="checkbox" name="keluhan" x-model="editJadwal.keluhan"
                                    :value="1" :unchecked-value="0" class="mr-2">
                                <label for="keluhan">Keluhan</label>
                            </div>
                        </div>
                    </template>


                    <!-- Tombol Aksi -->
                    <div class="flex justify-end space-x-2">
                        <button type="button" @click="showEditModal = false"
                            class="px-4 py-2 text-gray-700 transition-colors bg-gray-300 rounded hover:bg-gray-400">
                            Batal
                        </button>
                        <button type="submit" class="px-4 py-2 text-white bg-blue-500 rounded hover:bg-blue-600">
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>
        </div>

    </div>
    <script>
        function appData() {
            return {

                showAddModal: false,
                showEditModal: false,
                searchTerm: '',
                posyanduType: '', // Untuk mengontrol pilihan jenis Posyandu (Balita/Lansia)
                locations: ['Bingin', 'Desa', 'Dajan Pangkung'], // Lokasi tersedia
                Jadwals: @json($Jadwals), // Data jadwal dari backend

                editJadwal: {
                    id: null,
                    name: null,
                    date: '',
                    location: '',
                    imunisasi: false,
                    obatcacing: false,
                    susu: false,
                    kuisioner: false,
                    keluhan: false,
                    teskognitif: false,
                    tesdengar: false,
                    teslihat: false,
                    tesmobilisasi: false,
                },


                // Normalize Date to Remove Time
                normalizeDate(date) {
                    const d = new Date(date);
                    return new Date(d.getFullYear(), d.getMonth(), d.getDate());
                },


                openEditModal(
                    id, name, location, date, imunisasi, obatcacing, susu, kuisioner, keluhan, teskognitif, tesdengar,
                    teslihat, tesmobilisasi
                ) {
                    this.editJadwal = {
                        id,
                        name,
                        location,
                        date: new Date(date).toISOString().slice(0, 16), // Format untuk input type="datetime-local"
                        imunisasi: imunisasi, // Konversi ke boolean
                        obatcacing: obatcacing,
                        susu: susu,
                        kuisioner: kuisioner,
                        keluhan: keluhan,
                        teskognitif: teskognitif,
                        tesdengar: tesdengar,
                        teslihat: teslihat,
                        tesmobilisasi: tesmobilisasi,
                    };

                    // Tampilkan modal
                    this.showEditModal = true;
                },




                // Update jadwal
                updateJadwal() {
                    // Make sure to send the updated jadwal data to the server via an AJAX request
                    this.showEditModal = false;
                    alert("Jadwal berhasil diperbarui!");
                },

                // Fungsi membuka modal tambah jadwal
                openAddModal() {
                    this.resetAddModal();
                    this.showAddModal = true;
                },

                // Reset data modal tambah jadwal
                resetAddModal() {
                    this.posyanduType = '';
                    this.showAddModal = false;
                },

                // Simpan data dari modal tambah jadwal
                saveJadwal(event) {
                    event.preventDefault();
                    console.log("Jadwal baru disimpan:", {
                        posyanduType: this.posyanduType,
                    });
                    this.resetAddModal();
                },

                // Fungsi filter jadwal berdasarkan pencarian
                // get filteredJadwals() {
                //     const today = new Date();

                //     // Sort jadwals so that future dates come first
                //     return this.Jadwals
                //         .filter(jadwal => jadwal.name.toLowerCase().includes(this.searchTerm.toLowerCase()))
                //         .sort((a, b) => {
                //             // Compare jadwal.date, placing future dates first
                //             const dateA = new Date(a.date);
                //             const dateB = new Date(b.date);
                //             return dateA >= today ? -1 : 1; // Future dates should come first
                //         });
                // }

                get filteredJadwals() {
                    const today = new Date();

                    // Sort jadwals so that future dates come first
                    return this.Jadwals
                        .filter(jadwal => jadwal.name.toLowerCase().includes(this.searchTerm.toLowerCase()))
                        .sort((a, b) => {
                            const dateA = new Date(a.date);
                            const dateB = new Date(b.date);

                            // Pastikan tanggal sudah normal, tanpa waktu
                            const normalizedDateA = new Date(dateA.getFullYear(), dateA.getMonth(), dateA
                        .getDate());
                            const normalizedDateB = new Date(dateB.getFullYear(), dateB.getMonth(), dateB
                        .getDate());

                            // Letakkan tanggal yang lebih baru di depan
                            return normalizedDateA >= normalizedDateB ? -1 : 1;
                        });
                }



            };
        }
    </script>


</body>

</html>
