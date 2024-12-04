<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Posyandu Login</title>
    {{-- Import Library External: TailwindCSS & AlpineJS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Menggunakan path gambar di Laravel dengan helper asset */
        body {
            background-image: url('{{ asset('images/background.jpg') }}');
            background-size: cover;
            background-position: center;
        }

        .overlay {
            background-color: rgba(0, 118, 181, 0.704);
            padding: 2rem;
            border-radius: 0.5rem;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
            max-width: 100%; /* Batas lebar maksimum */
            
        }
        
        .button-primary {
      background: linear-gradient(135deg, #0077B5, #0099CC);
      color: #FFFFFF;
    }
    </style>
</head>

<body>
    <form action="{{ route('jadwal.store') }}" method="POST">
        @csrf
        <label>Jenis Posyandu:</label>
        <select name="jenis_posyandu" required>
            @foreach ($jenis_posyandu as $jenis)
                <option value="{{ $jenis }}">{{ ucfirst($jenis) }}</option>
            @endforeach
        </select>
    
        <label>Tanggal:</label>
        <input type="date" name="tanggal" required>
    
        <label>Pilih Fitur:</label>
        @foreach ($fitur as $item)
            <div>
                <input type="checkbox" name="fitur[]" value="{{ $item->id }}">
                {{ $item->nama_fitur }}
            </div>
        @endforeach
    
        <button type="submit">Simpan</button>
    </form>
    
</body>

</html>
