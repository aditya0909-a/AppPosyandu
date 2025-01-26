<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengukuran Balita - Petugas</title>
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
                <h1 class="text-3xl text-center font-bold">Pengukuran Balita</h1>
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
                <form :action="'/update-pengukuran/' + editData.id" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
            
                    <div class="bg-white p-6 rounded-lg shadow-lg max-w-md">
                        <h2 class="text-xl font-bold mb-4">Input Pengukuran</h2>
                                    
                        <div class="mb-4">
                            <label class="block text-sm font-bold text-gray-700">Tinggi Badan</label>
                            <div class="flex items-center">
                                <input 
                                    type="number" 
                                    name="tinggi_balita" 
                                    x-model="editData.tinggi_balita"
                                    step="0.01"
                                    class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                                >
                                <span class="ml-2 text-gray-700">cm</span>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-bold text-gray-700">Lingkar Kepala</label>
                            <div class="flex items-center">
                                <input 
                                    type="number" 
                                    name="lingkar_kepala_balita" 
                                    x-model="editData.lingkar_kepala_balita"
                                    step="0.01"
                                    class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                                >
                                <span class="ml-2 text-gray-700">cm</span>
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

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    
    <script>
        // Fungsi untuk menampilkan modal edit peserta
        function appData() {
            return {
                showEditModal: false,
                editData: {
                    id: null,
                    tinggi_balita: '',
                    lingkar_kepala_balita: '',
                },
                searchTerm: '', // Kata kunci pencarian
                pesertaList: [], // Menyimpan daftar peserta yang diambil dari server
                jadwalId: @json($jadwalId), // Jadwal ID dari backend
                
                // Membuka modal edit dan mengisi data peserta
                openEditModal(id, tinggi, kepala) {
                    this.editData = { 
                        id: id,
                        tinggi_balita: tinggi,
                        lingkar_kepala_balita: kepala,};
                    this.showEditModal = true;
                },

                // Memfilter peserta berdasarkan kata kunci pencarian
                filteredPeserta() {
                    return this.pesertaList.filter(item => 
                        item.nama_peserta_balita.toLowerCase().includes(this.searchTerm.toLowerCase())
                    );
                },

                // Mengambil data peserta dari server
                fetchPesertaData() {
                    axios.get(`/pesertabalita/${this.jadwalId}`)
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

                    // Urutkan peserta: tinggi_balita = 0 di atas
                    const sortedPeserta = this.filteredPeserta().sort((a, b) => {
                    const dataKesehatanA = a.data_kesehatan.find(dk => dk.jadwal_id === parseInt(this.jadwalId));
                    const dataKesehatanB = b.data_kesehatan.find(dk => dk.jadwal_id === parseInt(this.jadwalId));

                    const timestampA = dataKesehatanA ? new Date(dataKesehatanA.created_at).getTime() : Infinity;
                    const timestampB = dataKesehatanB ? new Date(dataKesehatanB.created_at).getTime() : Infinity;

                    const tinggiA = dataKesehatanA ? dataKesehatanA.tinggi_balita : 0;
                    const tinggiB = dataKesehatanB ? dataKesehatanB.tinggi_balita : 0;

                    const lingkarkepalaA = dataKesehatanA ? dataKesehatanA.lingkar_kepala_balita : 0;
                    const lingkarkepalaB = dataKesehatanB ? dataKesehatanB.lingkar_kepala_balita : 0;

                    // Prioritaskan jika salah satu dari ketiga atribut adalah 0
                    const aHasZero = tinggiA === 0 || lingkarkepalaA === 0 ;
                    const bHasZero = tinggiB === 0 || lingkarkepalaB === 0 ;

                    if (aHasZero && !bHasZero) return -1; // A di atas jika A memiliki 0 dan B tidak
                    if (!aHasZero && bHasZero) return 1;  // B di atas jika B memiliki 0 dan A tidak

                    // Jika keduanya tidak memiliki 0, urutkan berdasarkan tinggi badan
                    if (tinggiA === 0 && tinggiB !== 0) return -1; // Jika A 0, letakkan di atas
                    if (tinggiB === 0 && tinggiA !== 0) return 1;  // Jika B 0, letakkan di atas

                    // Jika tinggi sama, urutkan berdasarkan lingkar lengan
                    if (tinggiA === tinggiB) {
                        if (lingkarkepalaA === 0 && lingkarkepalaB !== 0) return -1; // A di atas jika 0
                        if (lingkarkepalaB === 0 && lingkarkepalaA !== 0) return 1;  // B di atas jika 0
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
                        card.classList.add(dataKesehatan && dataKesehatan.tinggi_balita && dataKesehatan.lingkar_kepala_balita > 0 ? 'bg-gray-200' : 'bg-white');

                        // Konten Kiri
                        const contentLeft = document.createElement('div');
                        const title = document.createElement('h2');
                        title.classList.add('text-xl', 'font-bold');
                        title.textContent = item.nama_peserta_balita;
                        contentLeft.appendChild(title);

                        const Tekstinggi = document.createElement('p');
                        Tekstinggi.classList.add('text-sm', 'text-gray-600');
                        Tekstinggi.textContent = `Tinggi Badan: ${dataKesehatan ? dataKesehatan.tinggi_balita : '-'}`;
                        contentLeft.appendChild(Tekstinggi);
                        card.appendChild(contentLeft);

                        const Tekslingkarkepala = document.createElement('p');
                        Tekslingkarkepala.classList.add('text-sm', 'text-gray-600', 'mb-2');
                        Tekslingkarkepala.textContent = `Lingkar kepala: ${dataKesehatan ? dataKesehatan.lingkar_kepala_balita : '-'}`;
                        contentLeft.appendChild(Tekslingkarkepala);
                        card.appendChild(contentLeft);

                        // Tombol di Kanan
                        if (dataKesehatan) {
                            const button = document.createElement('button');
                            button.classList.add('inline-flex', 'items-center', 'px-4', 'py-2', 'button-primary');
                            button.textContent = 'Input';
                            button.addEventListener('click', () => {
                                console.log("Button clicked:", dataKesehatan);
                                this.openEditModal(dataKesehatan.id, dataKesehatan.tinggi_balita, dataKesehatan.lingkar_kepala_balita);
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
