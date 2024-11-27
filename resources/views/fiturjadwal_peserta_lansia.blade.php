<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Posyandu</title>
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
          background: white;
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

    <div class="max-w-4xl mx-auto p-6">
      <nav class="navbar fixed top-0 left-0 right-0 z-10 p-4 shadow-md">
          <div class="container mx-auto flex items-center">
              <button onclick="window.location.href = '/dashboard/pesertaLansia'" class="text-[#0077B5] mr-4">
                  &larr; Back
              </button>
              <a href="#" class="text-2xl font-bold text-[#0077B5]">Posyandu</a>
              <div class="ml-auto text-[#0077B5] font-sans">Akun Peserta Lansia</div>
          </div>
      </nav>

      <div class="flex justify-center items-center mb-6 mt-8">
          <h1 class="text-3xl text-center font-bold">Jadwal Kegiatan Posyandu</h1>
      </div>

      <div class="flex items-center mb-4">
        <input type="text" placeholder="Cari jadwal..." class="input-field" x-model="searchTerm">
    </div>
      
    <!-- Filtered Jadwal List -->
    <template x-for="jadwal in filteredJadwals" :key="jadwal.id">
      <div class="card mb-6 p-4 border rounded shadow">
          <div class="flex justify-between items-center mb-2">
              <a :href="'/DataPenjadwalan_admin/' + jadwal.id">
                  <h2 class="text-xl font-bold" x-text="jadwal.nama_jadwal"></h2>
              </a>
          </div>
          <div class="text-sm text-gray-600">
              <div class="flex items-center">
                  <span class="font-semibold">Tanggal:</span>
                  <span class="ml-1" x-text="jadwal.tanggal_jadwal"></span>
              </div>
              <div class="flex items-center mt-1">
                  <span class="font-semibold">Lokasi:</span>
                  <span class="ml-1" x-text="jadwal.lokasi_jadwal"></span>
              </div>
              <div class="flex items-center mt-1">
                  <span class="font-semibold">Posyandu:</span>
                  <span class="ml-1" x-text="jadwal.Posyandu"></span>
              </div>
          </div>
      </div>
  </template>
  
       
  </div>

  <script>
    function appData() {
        return {
            searchTerm: '',
            Jadwals: @json($Jadwals), // Jadwal data from backend
                                    
            
            get filteredJadwals() {
                if (this.searchTerm === '') {
                    return this.Jadwals;
                }
                return this.Jadwals.filter(Jadwal => Jadwal.nama_jadwal.toLowerCase().includes(this.searchTerm.toLowerCase()));
            }
        };
    }
  </script>
</body>
</html>