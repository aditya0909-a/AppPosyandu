<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Posyandu Kegiatan</title>
    {{-- Import Library External: TailwindCSS & AlpineJS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
    <style>
        /* Custom Styling */
        body {
            background-color: #f3f4f6;
            font-family: 'Arial', sans-serif;
            padding-top: 50px;
        }
        .navbar, .glass-effect {
        background-color: rgba(0, 153, 204, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(0, 153, 204, 0.2);
        }

        
        .card {
            background-color: white;
            border-radius: 1rem;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background: linear-gradient(135deg, #00A9D1, #0077B5);
            padding: 1.5rem;
            color: white;
            border-radius: 1rem 1rem 0 0;
        }

        .button-primary {
            background: linear-gradient(135deg, #0077B5, #0099CC);
            color: #FFFFFF;
            padding: 12px 24px;
            border-radius: 8px;
            transition: background 0.3s ease, transform 0.3s ease;
        }

        .button-primary:hover {
            background: linear-gradient(135deg, #0099CC, #0077B5);
            transform: scale(1.05);
        }

        /* Table Styling */
        table th,
        table td {
            padding: 12px;
            text-align: left;
        }

        .table-container {
            overflow-x: auto;
        }
    </style>

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
</head>

<body>
    <div x-data="{ open: false }" class="max-w-4xl mx-auto mt-8 card">
        <!-- Card Header -->
        <div class="card-header">
            <h2 class="text-2xl font-semibold">Kegiatan Posyandu</h2>
            <p class="text-sm mt-1">Keterangan dan data hasil kegiatan yang dilakukan di Posyandu.</p>
        </div>

        <!-- Card Body -->
        <div class="p-6">
            <!-- Keterangan Kegiatan -->
            <div class="mb-6">
                <div class="text-lg font-semibold">Nama Kegiatan: <span class="font-normal">{{ $jadwal->name }}</span></div>
                <div class="text-lg font-semibold mt-2">Lokasi: <span class="font-normal">{{ $jadwal->location }}</span></div>
                <div class="text-lg font-semibold mt-2">Tanggal: <span class="font-normal">{{ $jadwal->formatted_date }}</span></div>
            </div>

            <!-- Rangkaian Kegiatan -->
            <div class="mb-6">
                <h3 class="text-xl font-semibold">Rangkaian Kegiatan:</h3>
                <ul class="list-disc pl-6 mt-2">
                    <li>Pemeriksaan Kesehatan Umum</li>
                    <li>Pemberian Imunisasi</li>
                    <li>Penyuluhan Gizi dan Kesehatan</li>
                    <li>Distribusi Obat-obatan</li>
                </ul>
            </div>

            <div id="app">
                <!-- Tabel Kehadiran Peserta -->
                <div class="table-container mb-6">
                    <h3 class="text-xl font-semibold">Daftar Kehadiran Peserta:</h3>
                    <table class="min-w-full mt-2 table-auto border-collapse border border-gray-300">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border border-gray-300 px-4 py-2">No</th>
                                <th class="border border-gray-300 px-4 py-2">Nama Peserta</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Menggunakan v-for untuk mengiterasi peserta -->
                            <tr v-for="(pesertaItem, index) in peserta" :key="pesertaItem.id">
                                <td class="border border-gray-300 px-4 py-2">@{{ index + 1 }}</td>
                                <td class="border border-gray-300 px-4 py-2">@{{ pesertaItem.nama_peserta_balita }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            

           <!-- Tombol untuk Mengunduh Data -->
<div class="flex space-x-4" x-data="{ unduhanOptions: @entangle('unduhanOptions'), open: true }">
    
    <!-- Tombol Dinamis Berdasarkan Data Unduhan -->
    <template x-if="unduhanOptions">
        <div>
            <button x-show="unduhanOptions.daftar_hadir" class="button-primary w-1/3 mt-4">
                Unduh Kehadiran
            </button>

            <button x-show="unduhanOptions.data_pertumbuhan" class="button-primary w-1/3 mt-4">
                Unduh Data Pertumbuhan
            </button>

            <button x-show="unduhanOptions.data_pemberian_pmt" class="button-primary w-1/3 mt-4">
                Unduh Data Pemberian PMT
            </button>

            <button x-show="unduhanOptions.data_pemberian_obat_cacing" class="button-primary w-1/3 mt-4">
                Unduh Data Pemberian Obat Cacing
            </button>

            <button x-show="unduhanOptions.data_imunisasi" class="button-primary w-1/3 mt-4">
                Unduh Data Imunisasi
            </button>
        </div>
    </template>

</div>


 </div>
 </div>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>
<script>
    new Vue({
        el: '#app',
        data: {
            jadwalId: 1,  // ID Jadwal yang ingin diambil
            peserta: []  // Tempat menyimpan data peserta
        },
        mounted() {
            // Ambil data peserta berdasarkan jadwal_id
            this.fetchPesertaByJadwal();
        },
        methods: {
            fetchPesertaByJadwal() {
                fetch(`http://127.0.0.1:8000/jadwal/${this.jadwalId}/peserta`)
                    .then(response => response.json())
                    .then(data => {
                        this.peserta = data.peserta;  // Menyimpan data peserta ke dalam state
                    })
                    .catch(error => console.error('Error fetching data:', error));
            }
        }
    });
</script>


</body>


</html>
