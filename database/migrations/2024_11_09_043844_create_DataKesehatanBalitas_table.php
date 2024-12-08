<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('DataKesehatanBalita', function (Blueprint $table) {
            $table->id();

            // Relasi ke tabel PesertaPosyanduBalita
            $table->foreignId('peserta_id')
                ->constrained('PesertaPosyanduBalita')
                ->onDelete('cascade');

            // Relasi ke tabel Jadwal
            $table->foreignId('jadwal_id')
                ->constrained('Jadwals')
                ->onDelete('cascade');

            $table->integer('bulan_ke')->default(0); // Nilai default berupa angka
            $table->integer('tinggi_balita');
            $table->integer('berat_balita');
            $table->integer('lingkar_kepala_balita');
            $table->enum('imunisasi', ['tidak', 'polio', 'DPT', 'Hib', 'campak', 'BCG', 'MMR', 'Varicella', 'Rotavirus', 'PCV']); // imunisasi terbatas pada pilihan tertentu
            $table->enum('obat_cacing', ['tidak', 'iya']); // pemberihan obat cacing terbatas pada pilihan tertentu
            $table->enum('susu', ['tidak', 'iya']); // pemberihan susu terbatas pada pilihan tertentu
            $table->string('keluhan_balita')->nullable()->default('');
            $table->string('penanganan_balita')->nullable()->default('');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('DatakesehatanBalita');
    }
};
