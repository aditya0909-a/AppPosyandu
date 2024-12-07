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

    <!-- Container -->
    <div class="max-w-4xl mx-auto p-6">
        <nav class="navbar fixed top-0 left-0 right-0 z-10 p-4 shadow-md">
            <div class="container mx-auto flex items-center">
                <button onclick="window.location.href = '/dashboard/admin'" class="text-[#0077B5] mr-4">
                    &larr; Back
                </button>
                <a href="#" class="text-2xl font-bold text-[#0077B5]">Posyandu</a>
                <div class="ml-auto text-[#0077B5] font-sans">Akun Admin</div>
            </div>
        </nav>

        <div class="flex justify-between items-center mb-4 mt-8">
            <h1 class="text-2xl font-bold">Daftar Jadwal Posyandu</h1>
            <button @click="showAddModal = true" class="button-primary px-4 py-2") >Tambah Jadwal</button>
        </div>

        <div class="flex items-center mb-4">
            <input type="text" placeholder="Cari jadwal..." class="input-field" x-model="searchTerm">
        </div>

    
        <!-- Filtered Jadwal List -->
<template x-for="jadwal in filteredJadwals" :key="jadwal.id">
    <div 
        class="card mb-6 p-4 rounded-lg" 
        :class="{
            'bg-gray-200': normalizeDate(jadwal.date) < normalizeDate(new Date()), // Abu-abu jika sudah lewat
            'bg-white': normalizeDate(jadwal.date) >= normalizeDate(new Date()) // Putih jika belum
        }">
        <div class="flex justify-between items-center">
            <a :href="'/DataPenjadwalan_admin/' + jadwal.id">
                <h2 class="text-xl font-bold" x-text="jadwal.name"></h2>
            </a>
            <button
                @click="openEditModal(jadwal.id, jadwal.name, jadwal.date, jadwal.location)"
                class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
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
<div x-show="showAddModal" class="modal-bg fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
    <form method="POST" action="{{ route('jadwal.store') }}" @submit="saveJadwal" class="space-y-4">
        @csrf
        <div class="bg-white relative w-full max-w-xs sm:max-w-sm mx-4 p-4 sm:p-6 rounded-lg shadow-lg overflow-y-auto max-h-[500px]">
            <h2 class="text-xl font-bold mb-4">Tambah Jadwal Posyandu</h2>

            <!-- Nama Posyandu -->
            <div class="mb-2">
                <label class="block text-gray-700 text-sm font-bold mb-2">Nama Posyandu</label>
                <select id="name" name="name" class="w-full p-2 border rounded" x-model="posyanduType">
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
                <label class="block text-gray-700 text-sm font-bold mb-2">Lokasi Jadwal</label>
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
                <label class="block text-gray-700 text-sm font-bold mb-2">Tanggal Jadwal</label>
                <input id="date" type="date" name="date" required class="w-full p-2 border rounded">
                @error('date')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Checkbox Posyandu Balita -->
            <div x-show="posyanduType === 'Posyandu Balita'">
                <div class="mb-2 flex items-center">
                    <input id="imunisasi" type="checkbox" name="imunisasi" class="mr-2">
                    <label for="imunisasi" class="inline-block">Imunisasi</label>
                </div>
                <div class="mb-2 flex items-center">
                    <input id="obatcacing" type="checkbox" name="obatcacing" class="mr-2">
                    <label for="obatcacing" class="inline-block">Obat Cacing</label>
                </div>
                <div class="mb-2 flex items-center">
                    <input id="susu" type="checkbox" name="susu" class="mr-2">
                    <label for="susu" class="inline-block">Susu</label>
                </div>
                <div class="mb-2 flex items-center">
                    <input id="kuisioner" type="checkbox" name="kuisioner" class="mr-2">
                    <label for="kuisioner" class="inline-block">Kuisioner</label>
                </div>
                <div class="mb-2 flex items-center">
                    <input id="keluhan" type="checkbox" name="keluhan" class="mr-2">
                    <label for="keluhan" class="inline-block">Keluhan</label>
                </div>
            </div>

            <!-- Checkbox Posyandu Lansia -->
            <div x-show="posyanduType === 'Posyandu Lansia'">
                <div class="mb-2 flex items-center">
                    <input id="teskognitif" type="checkbox" name="teskognitif" class="mr-2">
                    <label for="teskognitif" class="inline-block">Tes Kognitif</label>
                </div>
                <div class="mb-2 flex items-center">
                    <input id="tesdengar" type="checkbox" name="tesdengar" class="mr-2">
                    <label for="tesdengar" class="inline-block">Tes Dengar</label>
                </div>
                <div class="mb-2 flex items-center">
                    <input id="teslihat" type="checkbox" name="teslihat" class="mr-2">
                    <label for="teslihat" class="inline-block">Tes Lihat</label>
                </div>
                <div class="mb-2 flex items-center">
                    <input id="tesmobilisasi" type="checkbox" name="tesmobilisasi" class="mr-2">
                    <label for="tesmobilisasi" class="inline-block">Tes Mobilisasi</label>
                </div>
                <div class="mb-2 flex items-center">
                    <input id="keluhan" type="checkbox" name="keluhan" class="mr-2">
                    <label for="keluhan" class="inline-block">Keluhan</label>
                </div>
            </div>

            <div class="flex justify-end">
                <button @click="resetAddModal" type="button" class="bg-gray-400 text-white px-4 py-2 rounded mr-2">Batal</button>
                <button type="submit" class="button-primary">Tambah</button>
            </div>
        </div>
    </form>
</div>


 <!-- Modal Edit Jadwal -->
 <div x-show="showEditModal" class="modal-bg fixed inset-0 flex items-center justify-center">
    <form @submit.prevent="updateJadwal" class="space-y-4">
        @csrf
        @method('PUT')
        <div class="bg-white relative w-full max-w-xs sm:max-w-sm mx-4 p-4 sm:p-6 rounded-lg shadow-lg overflow-y-auto max-h-[500px]">
            <h2 class="text-xl font-bold mb-4">Edit Jadwal Posyandu</h2>

            <!-- Nama Posyandu -->
            <div class="mb-2">
                <label class="block text-gray-700 text-sm font-bold mb-2">Nama Posyandu</label>
                <select id="name" name="name" class="w-full p-2 border rounded" x-model="editJadwal.name">
                    <option value="Posyandu Balita" :selected="editJadwal.name === 'Posyandu Balita'">Posyandu Balita</option>
                    <option value="Posyandu Lansia" :selected="editJadwal.name === 'Posyandu Lansia'">Posyandu Lansia</option>
                </select>
                @error('name')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Lokasi -->
            <div class="mb-2">
                <label class="block text-gray-700 text-sm font-bold mb-2">Lokasi Jadwal</label>
                <select id="location" name="location" class="w-full p-2 border rounded" x-model="editJadwal.location">
                    <option value="Bingin" :selected="editJadwal.location === 'Bingin'">Bingin</option>
                    <option value="Desa" :selected="editJadwal.location === 'Desa'">Desa</option>
                    <option value="Dajan Pangkung" :selected="editJadwal.location === 'Dajan Pangkung'">Dajan Pangkung</option>
                </select>
                @error('location')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tanggal Jadwal -->
            <div class="mb-2">
                <label class="block text-gray-700 text-sm font-bold mb-2">Tanggal Jadwal</label>
                <input id="date" type="datetime-local" name="date" :value="editJadwal.date" required class="w-full p-2 border rounded">
                @error('date')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Checkbox Posyandu Balita -->
            <div x-show="editJadwal.name === 'Posyandu Balita'">
                <div class="mb-2 flex items-center">
                    <input id="imunisasi" type="checkbox" name="imunisasi" x-model="editJadwal.imunisasi" class="mr-2">
                    <label for="imunisasi" class="inline-block">Imunisasi</label>
                </div>
                <div class="mb-2 flex items-center">
                    <input id="obatcacing" type="checkbox" name="obatcacing" x-model="editJadwal.obatcacing" class="mr-2">
                    <label for="obatcacing" class="inline-block">Obat Cacing</label>
                </div>
                <div class="mb-2 flex items-center">
                    <input id="susu" type="checkbox" name="susu" x-model="editJadwal.susu" class="mr-2">
                    <label for="susu" class="inline-block">Susu</label>
                </div>
                <div class="mb-2 flex items-center">
                    <input id="kuisioner" type="checkbox" name="kuisioner" x-model="editJadwal.kuisioner" class="mr-2">
                    <label for="kuisioner" class="inline-block">Kuisioner</label>
                </div>
                <div class="mb-2 flex items-center">
                    <input id="keluhan" type="checkbox" name="keluhan" x-model="editJadwal.keluhan" class="mr-2">
                    <label for="keluhan" class="inline-block">Keluhan</label>
                </div>
            </div>

            <!-- Checkbox Posyandu Lansia -->
            <div x-show="editJadwal.name === 'Posyandu Lansia'">
                <div class="mb-2 flex items-center">
                    <input id="teskognitif" type="checkbox" name="teskognitif" x-model="editJadwal.teskognitif" class="mr-2">
                    <label for="teskognitif" class="inline-block">Tes Kognitif</label>
                </div>
                <div class="mb-2 flex items-center">
                    <input id="tesdengar" type="checkbox" name="tesdengar" x-model="editJadwal.tesdengar" class="mr-2">
                    <label for="tesdengar" class="inline-block">Tes Dengar</label>
                </div>
                <div class="mb-2 flex items-center">
                    <input id="teslihat" type="checkbox" name="teslihat" x-model="editJadwal.teslihat" class="mr-2">
                    <label for="teslihat" class="inline-block">Tes Lihat</label>
                </div>
                <div class="mb-2 flex items-center">
                    <input id="tesmobilisasi" type="checkbox" name="tesmobilisasi" x-model="editJadwal.tesmobilisasi" class="mr-2">
                    <label for="tesmobilisasi" class="inline-block">Tes Mobilisasi</label>
                </div>
                <div class="mb-2 flex items-center">
                    <input id="keluhan" type="checkbox" name="keluhan" x-model="editJadwal.keluhan" class="mr-2">
                    <label for="keluhan" class="inline-block">Keluhan</label>
                </div>
            </div>

            <div class="flex justify-end space-x-2">
                <button type="button" @click="showEditModal = false"
                    class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 transition-colors">
                    Batal
                </button>
                <button type="submit" class="button-primary">
                    Simpan Perubahan
                </button>
            </div>
        </div>
    </form>
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
                name: '',
                date: '',
                location: ''
            },

            // Normalize Date to Remove Time
        normalizeDate(date) {
            const d = new Date(date);
            return new Date(d.getFullYear(), d.getMonth(), d.getDate());
        },
            
        openEditModal(id, name, date, location) {
    console.log(id, name, date, location); // Log parameters
    const jadwal = this.Jadwals.find(j => j.id === id);
    console.log(jadwal); // Log the selected jadwal object
    this.editJadwal = {
        id: jadwal.id,
        name: jadwal.name,
        date: jadwal.date,
        location: jadwal.location,
        imunisasi: jadwal.imunisasi,
        obatcacing: jadwal.obatcacing,
        susu: jadwal.susu,
        kuisioner: jadwal.kuisioner,
        keluhan: jadwal.keluhan,
        teskognitif: jadwal.teskognitif,
        tesdengar: jadwal.tesdengar,
        teslihat: jadwal.teslihat,
        teskognitif: jadwal.teskognitif
    };
    this.showEditModal = true; // Show modal after setting data
}
,

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
get filteredJadwals() {
    const today = new Date();

    // Sort jadwals so that future dates come first
    return this.Jadwals
        .filter(jadwal => jadwal.name.toLowerCase().includes(this.searchTerm.toLowerCase()))
        .sort((a, b) => {
            // Compare jadwal.date, placing future dates first
            const dateA = new Date(a.date);
            const dateB = new Date(b.date);
            return dateA >= today ? -1 : 1; // Future dates should come first
        });
}

            
        };
    }
</script>

    
</body>
</html>
