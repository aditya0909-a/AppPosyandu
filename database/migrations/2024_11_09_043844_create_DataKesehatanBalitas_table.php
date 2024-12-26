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
            $table->float('tinggi_balita')->default(0);
            $table->float('berat_balita')->default(0);
            $table->float('lingkar_kepala_balita')->default(0);
            $table->string('imunisasi')->nullable()->default(''); // imunisasi terbatas pada pilihan tertentu
            $table->enum('obat_cacing', ['tidak', 'iya'])->default('tidak'); // pemberihan obat cacing terbatas pada pilihan tertentu
            $table->enum('susu', ['tidak', 'iya'])->default('tidak'); // pemberihan susu terbatas pada pilihan tertentu
            $table->enum('vitamin', ['tidak', 'iya'])->default('tidak'); // pemberihan vitamin terbatas pada pilihan tertentu
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
