<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tes Mobilisasi Lansia - Petugas</title>
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
            <h1 class="text-3xl text-center font-bold">Tes Mobilisasi Lansia</h1>
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

    </div>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>    

    <script>
        // Fungsi untuk menampilkan modal edit peserta
        function appData() {
            return {
                searchTerm: '', // Kata kunci pencarian
                pesertaList: [], // Daftar peserta dari server
                jadwalId: @json($jadwalId), // Jadwal ID dari backend
                userId: @json($userId), // User ID dari backend
    
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
                            this.pesertaList = response.data;
                            this.updatePesertaList();
                        })
                        .catch(error => {
                            console.error("Error fetching data:", error);
                        });
                },
    
                // Memperbarui daftar peserta di UI
                updatePesertaList() {
                    const pesertaListDiv = document.getElementById('pesertaList');
                    pesertaListDiv.innerHTML = ''; // Bersihkan elemen sebelumnya
    
                    // Urutkan peserta berdasarkan submitmobilisasi
                    const sortedPeserta = this.filteredPeserta().sort((a, b) => {
                        const dataKesehatanA = a.data_kesehatan.find(dk => dk.jadwal_id === parseInt(this.jadwalId));
                        const dataKesehatanB = b.data_kesehatan.find(dk => dk.jadwal_id === parseInt(this.jadwalId));

                        const timestampA = dataKesehatanA ? new Date(dataKesehatanA.created_at).getTime() : Infinity;
                        const timestampB = dataKesehatanB ? new Date(dataKesehatanB.created_at).getTime() : Infinity;
    
                        const submitmobilisasiA = dataKesehatanA ? dataKesehatanA.submitmobilisasi : 0;
                        const submitmobilisasiB = dataKesehatanB ? dataKesehatanB.submitmobilisasi : 0;
    
                        if (submitmobilisasiA === 0 && submitmobilisasiB !== 0) return -1;
                        if (submitmobilisasiB === 0 && submitmobilisasiA !== 0) return 1;

                        return timestampA - timestampB;
    
                        return 0;
                    });
    
                    // Render elemen peserta
                    sortedPeserta.forEach(item => {
                        const dataKesehatan = item.data_kesehatan.find(dk => dk.jadwal_id === parseInt(this.jadwalId));
                        const card = document.createElement('div');
                        card.classList.add('card', 'mb-6', 'p-4', 'rounded-lg');
                        card.classList.add(dataKesehatan && dataKesehatan.submitmobilisasi > 0 ? 'bg-gray-200' : 'bg-white');
    
                        const contentLeft = document.createElement('div');
    
                        // Nama peserta
                        const title = document.createElement('h2');
                        title.classList.add('text-xl', 'font-bold');
                        title.textContent = item.nama_peserta_lansia;
                        contentLeft.appendChild(title);
    
                        // Kondisi mobilisasi
                        const mobilisasiText = document.createElement('p');
                        mobilisasiText.classList.add('text-sm', 'text-gray-600', 'mb-2');
                        mobilisasiText.textContent = dataKesehatan && dataKesehatan.mobilisasi
                            ? 'Terdapat penurunan kemampuan mobilisasi'
                            : 'Kemampuan mobilisasi baik';
                        contentLeft.appendChild(mobilisasiText);
    
                        // Link kuisioner
                        if (dataKesehatan) {
                            const questionnaireLink = document.createElement('a');
                            questionnaireLink.href = `/kuisioner_mobilisasi/${dataKesehatan.id}/${dataKesehatan.jadwal_id}/${this.userId}`;
                            questionnaireLink.classList.add('inline-flex', 'items-center', 'px-4', 'py-2', 'button-primary');
                            questionnaireLink.textContent = 'Input';
                            contentLeft.appendChild(questionnaireLink);
                        }
    
                        card.appendChild(contentLeft);
                        pesertaListDiv.appendChild(card);
                    });
                },
    
                // Inisialisasi data saat halaman dimuat
                init() {
                    document.addEventListener("DOMContentLoaded", () => {
                        this.fetchPesertaData();
                    });
                }
            };
        }
    </script>
</body>

</html>
