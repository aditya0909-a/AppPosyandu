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
            $table->enum('kognitif_lokasi', ['bisa', 'tidak'])->default('bisa');
            $table->enum('kognitif_waktu', ['bisa', 'tidak'])->default('bisa');
            $table->enum('kognitif_kecemasan', ['cemas', 'tidak'])->default('tidak');
            $table->enum('dengar_bisik', ['kurang baik', 'cukup_baik', 'baik'])->default('baik');
            $table->enum('dengar_langsung', ['kurang baik', 'cukup_baik', 'baik'])->default('baik');
            $table->enum('lihat', ['kurang baik', 'cukup_baik', 'baik'])->default('baik');
            $table->enum('mobilisasi', ['kurang baik', 'cukup_baik', 'baik'])->default('baik');
            $table->enum('PMT', ['iya', 'tidak'])->default('tidak');
            $table->float('tensi_lansia')->default(0);
            $table->float('guladarah_lansia')->default(0);
            $table->float('kolesterol_lansia')->default(0);
            $table->string('keluhan_lansia')->default('');
            $table->string('obat_lansia')->default('');
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
