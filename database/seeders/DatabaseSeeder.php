<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        \App\Models\User::create([
            'name' => 'M Aditya Pangestu',
            'id_user' => 'adit123',
            'password' => '$2y$12$ukfMOJ9t8RNSYDYW4deH/uGhBAZbuPg5yCyghm/Ku35oY8KFTHd3a',
            'role' => 'admin',
        ]);


        \App\Models\User::create([
            'name' => 'Amel',
            'id_user' => 'amel123',
            'password' => '$2y$12$ukfMOJ9t8RNSYDYW4deH/uGhBAZbuPg5yCyghm/Ku35oY8KFTHd3a',
            'role' => 'petugas',
        ]);

        \App\Models\User::create([
            'name' => 'bagas',
            'id_user' => 'bagas123',
            'password' => '$2y$12$ukfMOJ9t8RNSYDYW4deH/uGhBAZbuPg5yCyghm/Ku35oY8KFTHd3a',
            'role' => 'pesertabalita',
        ]);

        \App\Models\User::create([
            'name' => 'alvin',
            'id_user' => 'alvin123',
            'password' => '$2y$12$ukfMOJ9t8RNSYDYW4deH/uGhBAZbuPg5yCyghm/Ku35oY8KFTHd3a',
            'role' => 'pesertalansia',
        ]);

        \App\Models\PesertaPosyanduBalita::create([
            'nama_peserta_balita' => 'alvin',
            'TempatLahir_balita'=> 'Lamongan',
            'TanggalLahir_balita' => '2004-07-26',
            'NIK_balita'=> '1234567890223',
            'nama_orangtua_balita'=> 'Cak win',
            'NIK_orangtua_balita'=> '12345678912', 
            'alamat_balita'=> 'jl raya kuta no 99', 
            'wa_balita' => '081534526577',
           
        ]);

        \App\Models\PesertaPosyanduBalita::create([
            'nama_peserta_balita' => 'Bagas',
            'TempatLahir_balita'=> 'Lamongan',
            'TanggalLahir_balita' => '2004-07-23',
            'NIK_balita'=> '1234567890523',
            'nama_orangtua_balita'=> 'Cak so',
            'NIK_orangtua_balita'=> '12345658912', 
            'alamat_balita'=> 'jl raya kuta no 59', 
            'wa_balita' => '081534527577',
           
        ]);

        \App\Models\DataKesehatanBalita::create([
            'peserta_id' => 1,
            'tinggi_balita' => 90,
            'berat_balita'=> 5,
            'lingkar_kepala_balita'=> 22,
            'imunisasi'=> 'DPT',
            'obat_cacing'=> 'iya', 
            'susu'=> 'iya',
            'keluhan_balita'=> 'BAB lebih sering dari biasanya, tinja encer atau cair, kadang disertai demam',
            'penanganan_balita'=> 'Berikan oralit untuk mencegah dehidrasi, 
Berikan makanan yang mudah dicerna seperti bubur atau pisang,
Jaga kebersihan diri dan lingkungan sekitar, 
Jika diare berlangsung lama atau disertai darah, segera bawa ke dokter',   
           
        ]);

        \App\Models\DataKesehatanBalita::create([
            'peserta_id' => 1,
            'tinggi_balita' => 95,
            'berat_balita'=> 8,
            'lingkar_kepala_balita'=> 25,
            'imunisasi'=> 'BCG',
            'keluhan_balita'=> 'Kulit di area popok menjadi merah, gatal, dan mungkin timbul lepuhan',
            'penanganan_balita'=> 'Ganti popok secara teratur dan bersihkan area popok dengan air hangat,
Biarkan kulit bayi terbuka sejenak agar bisa bernapas,
Oleskan krim ruam popok yang mengandung seng oksida',
           
        ]);

        \App\Models\DataKesehatanBalita::create([
            'peserta_id' => 2,
            'tinggi_balita' => 90,
            'berat_balita'=> 5,
            'lingkar_kepala_balita'=> 22,
            'imunisasi'=> 'BCG',
            'obat_cacing'=> 'iya', 
            'susu'=> 'iya',
            'keluhan_balita'=> 'Susah BAB, tinja keras dan kering, perut kembung',
            'penanganan_balita'=> 'Perbanyak asupan makanan berserat seperti buah-buahan dan sayuran,
Berikan banyak cairan,
Lakukan pijatan perut secara lembut,
Jika konstipasi berlangsung lama, konsultasikan ke dokter', 
           
        ]);

        \App\Models\DataKesehatanBalita::create([
            'peserta_id' => 2,
            'tinggi_balita' => 95,
            'berat_balita'=> 8,
            'lingkar_kepala_balita'=> 25,
            'imunisasi'=> 'BCG',
           
        ]);

        \App\Models\PesertaPosyanduLansia::create([
            'nama_peserta_lansia' => 'Bagas',
            'TTL_lansia'=> 'Lamongan, 23 Juli 1960',
            'NIK_lansia'=> '1234567890523', 
            'alamat_lansia'=> 'jl raya kuta no 59', 
            'wa_lansia' => '081534527577',
           
        ]);

        \App\Models\DataKesehatanLansia::create([
            'tinggi_lansia' => 150,
            'berat_lansia'=> 60,
            'lingkar_lengan_lansia'=> 15,
            'lingkar_perut_lansia'=> 40,
            'kognitif_lokasi'=> 'bisa', 
            'kognitif_waktu'=> 'bisa', 
            'kognitif_kecemasan'=> 'tidak', 
            'dengar_bisik'=> 'baik',
            'dengar_langsung'=> 'baik',
            'lihat'=> 'baik', 
            'mobilisasi'=> 'baik',
            'PMT'=> 'iya',     
            'keluhan_lansia'=> 'hipertensi', 
            'obat_lansia'=> 'diuretik', 
           
        ]);

        \App\Models\Jadwal::create([
            'nama_jadwal' => 'Posyandu Balita Bingin',
            'tanggal_jadwal'=> '2025-09-08',
            'lokasi_jadwal'=> 'BanjarDesa', 
            'Posyandu'=> 'PosyanduBalita', 
            'Imunisasi' => 'iya',
            'obat_cacing' => 'iya',
            'susu' => 'iya',
            'tes_lansia' => 'tidak',
            'PMT_lansia' => 'tidak',
           
        ]);

        
    }
}
