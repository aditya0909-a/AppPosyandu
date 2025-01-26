<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Posyandu - Admin</title>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
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

<body>
    
    <!-- Container -->
    <div x-data="appData()" class="max-w-4xl p-6 mx-auto">
        <nav class="fixed top-0 left-0 right-0 z-10 p-4 shadow-md navbar">
            <div class="container flex items-center mx-auto">
                <button onclick="window.location.href = '/dashboard/admin/{{ $userId }}'" class="text-[#0077B5] mr-4">
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
            <input type="text" id="searchInput" placeholder="Cari Jadwal" class="input-field">
        </div>

            @php
                // Mengambil waktu saat ini
                $today = \Carbon\Carbon::now()->startOfDay();

                // Mengurutkan jadwal
                $sortedJadwals = collect($Jadwals)->sortBy(function($jadwal) use ($today) {
                    return \Carbon\Carbon::parse($jadwal['date'])->isPast() ? 1 : 0; // Memprioritaskan yang tidak lewat
                })->values(); // Mengembalikan collection dengan index yang direset
            @endphp

            @foreach ($sortedJadwals as $jadwal)
                <div class="p-4 mb-6 rounded-lg card 
                    {{ \Carbon\Carbon::parse($jadwal['date'])->isPast() ? 'bg-gray-200' : 'bg-white' }}">
                    <div class="flex items-center justify-between">
                        <!-- Link ke detail jadwal -->
                        @if ($jadwal['name'] === 'Posyandu Balita')
                            <a href="{{ url('/admin/jadwalbalita/' . $jadwal['id']) }}">
                                <h2 class="text-xl font-bold">{{ $jadwal['name'] }}</h2>
                            </a>
                        @elseif ($jadwal['name'] === 'Posyandu Lansia')
                            <a href="{{ url('/admin/jadwallansia/' . $jadwal['id']) }}">
                                <h2 class="text-xl font-bold">{{ $jadwal['name'] }}</h2>
                            </a>
                        @endif
                        <!-- Tombol Edit -->
                        <button 
                            @click="
                                openEditModal(
                                    {{ $jadwal['id'] }},
                                    '{{ $jadwal['name'] }}',
                                    '{{ $jadwal['location'] }}',
                                    '{{ $jadwal['date'] }}',
                                    {{ $jadwal['imunisasi'] ? 'true' : 'false' }},
                                    {{ $jadwal['obatcacing'] ? 'true' : 'false' }},
                                    {{ $jadwal['susu'] ? 'true' : 'false' }},
                                    {{ $jadwal['teskognitif'] ? 'true' : 'false' }},
                                    {{ $jadwal['tesdengar'] ? 'true' : 'false' }},
                                    {{ $jadwal['teslihat'] ? 'true' : 'false' }},
                                    {{ $jadwal['tesmobilisasi'] ? 'true' : 'false' }},
                                    {{ $jadwal['pemeriksaan'] ? 'true' : 'false' }}
                                )
                            "
                            class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Edit
                        </button>
                    </div>

                    <!-- Informasi Tambahan -->
                    <div class="text-sm text-gray-600">
                        Tanggal: {{ \Carbon\Carbon::parse($jadwal['date'])->locale('id')->isoFormat('D MMMM YYYY') }}
                    </div>
                    <h3 class="text-sm text-gray-600">Lokasi: {{ $jadwal['location'] }}</h3>
                </div>
            @endforeach
     

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
                            <input id="pemeriksaan" type="checkbox" name="pemeriksaan" value="1" class="mr-2">
                            <label for="pemeriksaan" class="inline-block">pemeriksaan</label>
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
                            <input id="pemeriksaan" type="checkbox" name="pemeriksaan" value="1" class="mr-2">
                            <label for="pemeriksaan" class="inline-block">pemeriksaan</label>
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
                <div class="bg-white relative w-full max-w-xs sm:max-w-sm mx-4 p-4 sm:p-6 rounded-lg shadow-lg overflow-y-auto max-h-[500px]">
                    <h2 class="mb-4 text-xl font-bold">Edit Jadwal Posyandu</h2>

                    <!-- Nama Posyandu -->
                    <div class="mb-2">
                        <label for="name" class="block mb-2 text-sm font-bold text-gray-700">Nama Posyandu</label>
                        <select id="name" name="name" class="w-full p-2 border rounded" x-model="editJadwal.name">
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
                        <select id="location" name="location" class="w-full p-2 border rounded" x-model="editJadwal.location">
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
                        <label for="date" class="block mb-2 text-sm font-bold text-gray-700">Tanggal Jadwal</label>
                        <input id="date" type="date" name="date" x-model="editJadwal.date" required class="w-full p-2 border rounded">
                        @error('date')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Checkbox -->
                    <template x-if="editJadwal.name === 'Posyandu Balita'">
                        <div>
                            <div class="flex items-center mb-2">
                                <input id="imunisasi" type="checkbox" name="imunisasi" x-model="editJadwal.imunisasi" class="mr-2">
                                <label for="imunisasi">Imunisasi</label>
                            </div>
                            <div class="flex items-center mb-2">
                                <input id="obatcacing" type="checkbox" name="obatcacing" x-model="editJadwal.obatcacing" class="mr-2">
                                <label for="obatcacing">Obat Cacing</label>
                            </div>
                            <div class="flex items-center mb-2">
                                <input id="susu" type="checkbox" name="susu" x-model="editJadwal.susu" class="mr-2">
                                <label for="susu">Susu</label>
                            </div>
                        </div>
                    </template>
                    <template x-if="editJadwal.name === 'Posyandu Lansia'">
                        <div>
                            <div class="flex items-center mb-2">
                                <input id="teskognitif" type="checkbox" name="teskognitif" x-model="editJadwal.teskognitif" class="mr-2">
                                <label for="teskognitif">Tes Kognitif</label>
                            </div>
                            <div class="flex items-center mb-2">
                                <input id="tesdengar" type="checkbox" name="tesdengar" x-model="editJadwal.tesdengar" class="mr-2">
                                <label for="tesdengar">Tes Dengar</label>
                            </div>
                            <div class="flex items-center mb-2">
                                <input id="teslihat" type="checkbox" name="teslihat" x-model="editJadwal.teslihat" class="mr-2">
                                <label for="teslihat">Tes Lihat</label>
                            </div>
                            <div class="flex items-center mb-2">
                                <input id="tesmobilisasi" type="checkbox" name="tesmobilisasi" x-model="editJadwal.tesmobilisasi" class="mr-2">
                                <label for="tesmobilisasi">Tes Mobilisasi</label>
                            </div>
                            <div class="flex items-center mb-2">
                                <input id="pemeriksaan" type="checkbox" name="pemeriksaan" x-model="editJadwal.pemeriksaan" class="mr-2">
                                <label for="pemeriksaan">Pemeriksaan</label>
                            </div>
                        </div>
                    </template>

                    <!-- Tombol Aksi -->
                    <div class="flex justify-end space-x-2">
                        <button type="button" @click="showEditModal = false" class="px-4 py-2 text-gray-700 transition-colors bg-gray-300 rounded hover:bg-gray-400">Batal</button>
                        <button type="submit" class="button-primary">Simpan Perubahan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Event listener untuk pencarian
            const searchInput = document.getElementById('searchInput');
            if (searchInput) {
                searchInput.addEventListener('input', function () {
                    var searchTerm = this.value.toLowerCase();
                    var cards = document.querySelectorAll('.card'); // Mengambil semua card
    
                    cards.forEach(function (card) {
                        var name = card.querySelector('h2').textContent.toLowerCase(); // Menyaring berdasarkan nama
                        var location = card.querySelector('h3').textContent.toLowerCase(); // Menyaring berdasarkan lokasi
                        
                        // Tampilkan card jika nama atau lokasi mengandung kata kunci pencarian
                        if (name.includes(searchTerm) || location.includes(searchTerm)) {
                            card.style.display = '';
                        } else {
                            card.style.display = 'none';
                        }
                    });
                });
            }
        });
    
        function appData() {
            return {
                // State Control
                showAddModal: false,
                showEditModal: false,
                searchTerm: '',
                posyanduType: '',
                locations: ['Bingin', 'Desa', 'Dajan Pangkung'],
    
                // Data dari Backend
                Jadwals: @json($Jadwals),
    
                // Data untuk Edit Jadwal
                editJadwal: {
                    id: null,
                    name: '',
                    date: '',
                    location: '',
                    imunisasi: false,
                    obatcacing: false,
                    susu: false,
                    teskognitif: false,
                    tesdengar: false,
                    teslihat: false,
                    tesmobilisasi: false,
                    pemeriksaan: false,
                },
    
                // Modal Management
                openEditModal(id, name, location, date, imunisasi, obatcacing, susu, teskognitif, tesdengar, teslihat, tesmobilisasi, pemeriksaan) {
                    this.editJadwal = {
                        id,
                        name,
                        location,
                        date,
                        imunisasi,
                        obatcacing,
                        susu,
                        teskognitif,
                        tesdengar,
                        teslihat,
                        tesmobilisasi,
                        pemeriksaan,
                    };
                    this.showEditModal = true;
                },
                closeModal() {
                    this.showEditModal = false;
                    this.showAddModal = false;
                },
                openAddModal() {
                    this.resetAddModal();
                    this.showAddModal = true;
                },
                resetAddModal() {
                    this.posyanduType = '';
                    this.showAddModal = false;
                },
    
                // Simpan Data Baru
                saveJadwal(event) {
                    event.preventDefault();
                    console.log("Jadwal baru disimpan:", {
                        posyanduType: this.posyanduType,
                    });
                    this.resetAddModal();
                },
            };
        }
        
    </script>


</body>

</html>