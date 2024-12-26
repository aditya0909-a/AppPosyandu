<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemberian Obat Cacing Balita - Petugas</title>
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
                    <button onclick="window.location.href = '/fiturposyandu/petugas'" class="text-[#0077B5] mr-4">
                        &larr; Back
                    </button>
                    <a href="#" class="text-2xl font-bold text-[#0077B5]">Posyandu</a>
                    <div class="ml-auto text-[#0077B5] font-sans">Akun Petugas</div>
                </div>
            </nav>

            <div class="flex justify-center items-center mb-6 mt-8">
                <h1 class="text-3xl text-center font-bold">Checklist Pemberian Obat Cacing</h1>
            </div>

            <div class="flex items-center mb-4">
                <input type="text" placeholder="Cari peserta..." class="input-field" id="searchInput">
            </div>

            @php
            $sortedPeserta = $peserta->sortBy(function ($item) use ($jadwalId) {
                $dataKesehatan = $item->dataKesehatan->firstWhere('jadwal_id', $jadwalId);

                // Nilai prioritas: enum 'tidak' (0) -> prioritas tinggi
                return isset($dataKesehatan) && $dataKesehatan->obat_cacing === 'tidak' ? 0 : 1;
            });
            @endphp

        
            <div id="pesertaList">
                @foreach($sortedPeserta as $index => $item)
                    @php
                        $dataKesehatan = $item->dataKesehatan->firstWhere('jadwal_id', $jadwalId);
                    @endphp

                    @if(isset($dataKesehatan) && $dataKesehatan->obat_cacing === 'iya')
                    <div class="card mb-6 p-4 rounded-lg bg-gray-200 flex justify-between items-center">
                    @else
                        <div class="card mb-6 p-4 rounded-lg bg-white flex justify-between items-center">
                    @endif

                        <!-- Konten Kiri -->
                        <div>
                            <h2 class="text-xl font-bold">{{ $item->nama_peserta_balita ?? $item->nama_peserta_lansia }}</h2>
                            <p class="text-sm text-gray-600">
                                Status: 
                                {{ isset($dataKesehatan) ? ($dataKesehatan->obat_cacing === 'iya' ? 'Sudah Diberikan' : 'Belum Diberikan') : '-' }}
                            </p>
                        </div>

                        <!-- Tombol di Kanan -->
                        @if(isset($dataKesehatan))
                            <button 
                                @click="openEditModal({{ $dataKesehatan->id }}, '{{ $dataKesehatan->obat_cacing }}')"
                                class="inline-flex items-center px-4 py-2 button-primary">
                                Input
                            </button>
                        @endif
                    </div>
                @endforeach
            </div>
            

            <!-- Modal Edit -->
            <div x-show="showEditModal" class="modal-bg fixed inset-0 flex items-center justify-center">
                <form :action="'/update-obatcacing/' + editData.id" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
            
                    <div class="bg-white p-6 rounded-lg shadow-lg max-w-md">
                        <h2 class="text-xl font-bold mb-4">Checklist Pemberian</h2>
                                  
                        <div class="mb-4">
                            <label class="block text-sm font-bold text-gray-700">Status Obat Cacing</label>
                            <select 
                                name="obat_cacing" 
                                x-model="editData.obat_cacing"
                                class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                            >
                                <option value="" disabled>Pilih Status</option>
                                <option value="iya">Sudah Diberikan</option>
                                <option value="tidak">Belum Diberikan</option>
                            </select>
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
                obat_cacing: ''
            },
            openEditModal(id, obat_cacing) {
                this.editData = {
                    id: id,
                    obat_cacing: obat_cacing,
                };
                this.showEditModal = true;
            }
        };
        }

    </script>
</body>

</html>
