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
        Schema::create('DataKesehatanLansia', function (Blueprint $table) {
            $table->id();
            // Relasi ke tabel PesertaPosyanduBalita
            $table->foreignId('peserta_id')
                ->constrained('PesertaPosyanduLansia')
                ->onDelete('cascade');

            // Relasi ke tabel Jadwal
            $table->foreignId('jadwal_id')
                ->constrained('Jadwals')
                ->onDelete('cascade');

            $table->timestamps();
            $table->float('tinggi_lansia')->default(0);
            $table->float('berat_lansia')->default(0);
            $table->float('lingkar_lengan_lansia')->default(0);
            $table->float('lingkar_perut_lansia')->default(0);
            $table->boolean('submitkognitif')->default(false); // Kolom boolean teskognitif
            $table->boolean('kognitif1')->default(false); // Kolom boolean teskognitif
            $table->boolean('kognitif2')->default(false); // Kolom boolean teskognitif
            $table->boolean('mobilisasi')->default(false); // Kolom boolean tesmobilisasi
            $table->boolean('submitmobilisasi')->default(false); // Kolom boolean tesmobilisasi
            $table->boolean('malnutrisi1')->default(false); // Kolom boolean tesmalnutrisi
            $table->boolean('malnutrisi2')->default(false); // Kolom boolean tesmalnutrisi
            $table->boolean('malnutrisi3')->default(false); // Kolom boolean tesmalnutrisi
            $table->boolean('lihat1')->default(false); // Kolom boolean teslihat
            $table->boolean('lihat2')->default(false); // Kolom boolean teslihat
            $table->boolean('submitlihat')->default(false); // Kolom boolean teslihat
            $table->boolean('dengar')->default(false); // Kolom boolean tesdengar
            $table->boolean('submitdengar')->default(false); // Kolom boolean tesdengar
            $table->boolean('depresi1')->default(false); // Kolom boolean tesdepresi
            $table->boolean('depresi2')->default(false); // Kolom boolean tesdepresi
            $table->float('tensi_lansia')->default(0);
            $table->float('guladarah_lansia')->default(0);
            $table->float('kolesterol_lansia')->default(0);
            $table->string('keluhan_lansia')->default('');
            $table->string('obat_lansia')->default('');
            $table->boolean('PMT')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('DataKesehatanLansia');
    }
};
