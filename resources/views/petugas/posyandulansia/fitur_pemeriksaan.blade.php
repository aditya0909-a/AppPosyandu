<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengukuran Lansia - Petugas</title>
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
        transition: transform 0.1s, box-shadow 0.1s; /* Percepat transisi */
        }
        
        .button-primary:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        
        .button-primary:active {
            transform: scale(0.95); /* Sedikit mengecil saat ditekan */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2); /* Bayangan lebih dalam saat ditekan */
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
    <div x-data="appData()" x-init="init()" class="max-w-4xl mx-auto p-6">
            <nav class="navbar fixed top-0 left-0 right-0 z-10 p-4 shadow-md">
                <div class="container mx-auto flex items-center">
                    <button onclick="window.location.href = '/fiturposyandu/petugas/{{ $userId }}'" class="text-[#0077B5] mr-4">
                        &larr; Back
                    </button>
                    <a href="#" class="text-2xl font-bold text-[#0077B5]">Posyandu</a>
                    <div class="ml-auto text-[#0077B5] font-sans">Akun Petugas</div>
                </div>
            </nav>

            <div class="flex justify-between items-center mb-6 mt-8">
                <h1 class="text-3xl text-center font-bold">Pemeriksaan Dokter</h1>
                <button @click="fetchPesertaData()" class="button-primary">Refresh Data</button>
            </div>

            <div class="flex items-center mb-4">
                <input 
                    type="text" 
                    placeholder="Cari peserta..." 
                    class="input-field" 
                    id="searchInput"
                    x-model="searchTerm"
                    @input="updatePesertaList()"
                >
            </div>
            
                
            <div id="pesertaList">
                <!-- Tempat untuk menampilkan data peserta -->
            </div>

            <!-- Modal Edit Pengguna -->
            <div x-show="showEditModal" class="modal-bg fixed inset-0 flex items-center justify-center">
                <form :action="'/update-pemeriksaan/' + editData.id" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
            
                    <div class="modal-content bg-white rounded-lg p-6 overflow-auto" style="max-width: 600px; max-height: 50vh;">
                        <h2 class="text-xl font-bold mb-4">Input Pemeriksaan</h2>
                                    
                        <div class="mb-4">
                            <label class="block text-sm font-bold text-gray-700">Tensi</label>
                            <div class="flex items-center">
                                <input 
                                    type="number" 
                                    name="tensi_lansia" 
                                    x-model="editData.tensi_lansia"
                                    step="0.01"
                                    class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                                >
                                <span class="ml-2 text-gray-700">mmHg</span>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-bold text-gray-700">Kolesterol</label>
                            <div class="flex items-center">
                                <input 
                                    type="number" 
                                    name="kolesterol_lansia" 
                                    x-model="editData.kolesterol_lansia"
                                    step="0.01"
                                    class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                                >
                                <span class="ml-2 text-gray-700">mg/dL</span>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-bold text-gray-700">Asam urat</label>
                            <div class="flex items-center">
                                <input 
                                    type="number" 
                                    name="asamurat_lansia" 
                                    x-model="editData.asamurat_lansia"
                                    step="0.01"
                                    class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                                >
                                <span class="ml-2 text-gray-700">mg/dL</span>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-bold text-gray-700">Gula Darah</label>
                            <div class="flex items-center">
                                <input 
                                    type="number" 
                                    name="guladarah_lansia" 
                                    x-model="editData.guladarah_lansia"
                                    step="0.01"
                                    class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                                >
                                <span class="ml-2 text-gray-700">mg/dL</span>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-bold text-gray-700">Diagnosis</label>
                            <div class="flex items-center">
                                <input 
                                    type="text" 
                                    name="keluhan_lansia" 
                                    x-model="editData.keluhan_lansia"
                                    step="0.01"
                                    class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                                >
                                <span class="ml-2 text-white">mg/dL</span>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-bold text-gray-700">Obat</label>
                            <div class="flex items-center">
                                <input 
                                    type="text" 
                                    name="obat_lansia" 
                                    x-model="editData.obat_lansia"
                                    step="0.01"
                                    class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                                >
                                <span class="ml-2 text-white">mg/dL</span>
                            </div>
                        </div>
                                              
                        <div class="flex justify-end">
                            <button type="button" @click="showEditModal = false"
                                class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Batal</button>
                            <button type="submit" class="ml-2 px-4 py-2 button-primary">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
            
        
    </div>

    <script>
        document.getElementById('searchInput').addEventListener('input', function () {
            const term = this.value.toLowerCase();
            const pesertaCards = document.querySelectorAll('#pesertaList .card');
            pesertaCards.forEach(card => {
                const nama = card.querySelector('h2').textContent.toLowerCase();
                card.style.display = nama.includes(term) ? 'block' : 'none';
            });
        });

        function appData() {
        return {
            showEditModal: false,
            editData: {
                id: null,
                tensi_lansia: '',
                guladarah_lansia: '',
                kolesterol_lansia: '',
                asamurat_lansia: '',
                keluhan_lansia: '',
                obat_lansia: ''
            },
            openEditModal(id, tensi, guladarah, kolesterol, asamurat, keluhan, obat) {
                this.editData = {
                    id: id,
                    tensi_lansia: tensi,
                    guladarah_lansia: guladarah,
                    kolesterol_lansia: kolesterol,
                    asamurat_lansia: asamurat,
                    keluhan_lansia: keluhan,
                    obat_lansia: obat,
                };
                this.showEditModal = true;
            }
        };
        }

    </script>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    
<script>
    // Fungsi untuk menampilkan modal edit peserta
    function appData() {
        return {
            showEditModal: false,
            editData: {
                id: null,
                tensi_lansia: '',
                guladarah_lansia: '',
                kolesterol_lansia: '',
                asamurat_lansia: '',
                keluhan_lansia: '',
                obat_lansia: '',
            },
            searchTerm: '', // Kata kunci pencarian
            pesertaList: [], // Menyimpan daftar peserta yang diambil dari server
            jadwalId: @json($jadwalId), // Jadwal ID dari backend
            
            // Membuka modal edit dan mengisi data peserta
            openEditModal(id, tensi, guladarah, kolesterol, asamurat, keluhan, obat) {
                this.editData = { 
                    id: id,
                    tensi_lansia: tensi,
                    guladarah_lansia: guladarah,
                    kolesterol_lansia: kolesterol,
                    asamurat_lansia: asamurat,
                    keluhan_lansia: keluhan,
                    obat_lansia: obat,};
                this.showEditModal = true;
            },

            // Memfilter peserta berdasarkan kata kunci pencarian
            filteredPeserta() {
                return this.pesertaList.filter(item => 
                    item.nama_peserta_lansia.toLowerCase().includes(this.searchTerm.toLowerCase())
                );
            },

            // Mengambil data peserta dari server
            fetchPesertaData() {
                axios.get(`/peserta/${this.jadwalId}`)
                    .then(response => {
                        this.pesertaList = response.data; // Menyimpan data peserta
                        this.updatePesertaList(); // Perbarui tampilan
                    })
                    .catch(error => {
                        console.error("Error fetching data:", error);
                    });
            },

            // Memperbarui daftar peserta di UI
            updatePesertaList() {
                const pesertaListDiv = document.getElementById('pesertaList');
                pesertaListDiv.innerHTML = ''; // Bersihkan elemen sebelumnya

                // Urutkan peserta: tinggi_lansia = 0 di atas
                const sortedPeserta = this.filteredPeserta().sort((a, b) => {
                const dataKesehatanA = a.data_kesehatan.find(dk => dk.jadwal_id === parseInt(this.jadwalId));
                const dataKesehatanB = b.data_kesehatan.find(dk => dk.jadwal_id === parseInt(this.jadwalId));

                const timestampA = dataKesehatanA ? new Date(dataKesehatanA.created_at).getTime() : Infinity;
                const timestampB = dataKesehatanB ? new Date(dataKesehatanB.created_at).getTime() : Infinity;

                const guladarahA = dataKesehatanA ? dataKesehatanA.guladarah_lansia : 0;
                const guladarahB = dataKesehatanB ? dataKesehatanB.guladarah_lansia : 0;

                const kolesterolA = dataKesehatanA ? dataKesehatanA.kolesterol_lansia : 0;
                const kolesterolB = dataKesehatanB ? dataKesehatanB.kolesterol_lansia : 0;

                const asamuratA = dataKesehatanA ? dataKesehatanA.asamurat_lansia : 0;
                const asamuratB = dataKesehatanB ? dataKesehatanB.asamurat_lansia : 0;

                // Prioritaskan jika salah satu dari ketiga atribut adalah 0
                const aHasZero = guladarahA === 0 || kolesterolA === 0 || asamuratA === 0;
                const bHasZero = guladarahB === 0 || kolesterolB === 0 || asamuratB === 0;

                if (aHasZero && !bHasZero) return -1; // A di atas jika A memiliki 0 dan B tidak
                if (!aHasZero && bHasZero) return 1;  // B di atas jika B memiliki 0 dan A tidak

                // Jika keduanya tidak memiliki 0, urutkan berdasarkan guladarah badan
                if (guladarahA === 0 && guladarahB !== 0) return -1; // Jika A 0, letakkan di atas
                if (guladarahB === 0 && guladarahA !== 0) return 1;  // Jika B 0, letakkan di atas

                // Jika guladarah sama, urutkan berdasarkan lingkar lengan
                if (guladarahA === guladarahB) {
                    if (kolesterolA === 0 && kolesterolB !== 0) return -1; // A di atas jika 0
                    if (kolesterolB === 0 && kolesterolA !== 0) return 1;  // B di atas jika 0
                }

                // Jika lingkar lengan juga sama, urutkan berdasarkan lingkar perut
                if (kolesterolA === kolesterolB) {
                    if (asamuratA === 0 && asamuratB !== 0) return -1; // A di atas jika 0
                    if (asamuratB === 0 && asamuratA !== 0) return 1;  // B di atas jika 0
                }

                return timestampA - timestampB;

                // Jika semua sama, pertahankan urutan
                return 0;
            });


                // Render elemen berdasarkan urutan
                sortedPeserta.forEach(item => {
                    const dataKesehatan = item.data_kesehatan.find(dk => dk.jadwal_id === parseInt(this.jadwalId));
                    const card = document.createElement('div');
                    card.classList.add('card', 'mb-6', 'p-4', 'rounded-lg');
                    card.classList.add(dataKesehatan && dataKesehatan.guladarah_lansia && dataKesehatan.kolesterol_lansia && dataKesehatan.asamurat_lansia > 0 ? 'bg-gray-200' : 'bg-white');

                    // Konten Kiri
                    const contentLeft = document.createElement('div');
                    const title = document.createElement('h2');
                    title.classList.add('text-xl', 'font-bold');
                    title.textContent = item.nama_peserta_lansia;
                    contentLeft.appendChild(title);

                    const Teksguladarah = document.createElement('p');
                    Teksguladarah.classList.add('text-sm', 'text-gray-600');
                    Teksguladarah.textContent = `Gula Darah: ${dataKesehatan ? dataKesehatan.guladarah_lansia : '-'}`;
                    contentLeft.appendChild(Teksguladarah);
                    card.appendChild(contentLeft);

                    const Tekskolesterol = document.createElement('p');
                    Tekskolesterol.classList.add('text-sm', 'text-gray-600');
                    Tekskolesterol.textContent = `Kolesterol: ${dataKesehatan ? dataKesehatan.kolesterol_lansia : '-'}`;
                    contentLeft.appendChild(Tekskolesterol);
                    card.appendChild(contentLeft);

                    const Teksasamurat = document.createElement('p');
                    Teksasamurat.classList.add('text-sm', 'text-gray-600', 'mb-2');
                    Teksasamurat.textContent = `Asam urat: ${dataKesehatan ? dataKesehatan.asamurat_lansia : '-'}`;
                    contentLeft.appendChild(Teksasamurat);
                    card.appendChild(contentLeft);

                    // Tombol di Kanan
                    if (dataKesehatan) {
                        const button = document.createElement('button');
                        button.classList.add('inline-flex', 'items-center', 'px-4', 'py-2', 'button-primary');
                        button.textContent = 'Input';
                        button.addEventListener('click', () => {
                            console.log("Button clicked:", dataKesehatan);
                            this.openEditModal(dataKesehatan.id, dataKesehatan.guladarah_lansia, dataKesehatan.kolesterol_lansia, dataKesehatan.asamurat_lansia);
                        });
                        card.appendChild(button);
                    }

                    pesertaListDiv.appendChild(card);
                });
            },


            // Inisialisasi data saat halaman dimuat
            init() {
                document.addEventListener("DOMContentLoaded", () => {
                    this.fetchPesertaData(); // Ambil data peserta
                });
            }
        };
    }
</script>
</body>

</html>
