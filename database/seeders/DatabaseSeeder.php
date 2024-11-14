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
            'TTL_balita'=> 'Lamongan, 23 Juli 2004',
            'NIK_balita'=> '1234567890223',
            'nama_orangtua_balita'=> 'Cak win',
            'NIK_orangtua_balita'=> '12345678912', 
            'alamat_balita'=> 'jl raya kuta no 99', 
            'wa_balita' => '081534526577'
           
        ]);

        \App\Models\PesertaPosyanduBalita::create([
            'nama_peserta_balita' => 'Bagas',
            'TTL_balita'=> 'Lamongan, 23 Juli 2004',
            'NIK_balita'=> '1234567890523',
            'nama_orangtua_balita'=> 'Cak so',
            'NIK_orangtua_balita'=> '12345658912', 
            'alamat_balita'=> 'jl raya kuta no 59', 
            'wa_balita' => '081534527577'
           
        ]);

        \App\Models\DataKesehatanBalita::create([
            'tinggi_balita' => 90,
            'berat_balita'=> 5,
            'lingkar_kepala_balita'=> 22,
            'imunisasi'=> 'DPT',
            'obat_cacing'=> 'iya', 
            'susu'=> 'iya', 
           
        ]);
        
    }
}
