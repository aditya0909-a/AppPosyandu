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
        Schema::create('Jadwal', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('nama_jadwal');
            $table->date('tanggal_jadwal');
            $table->enum('lokasi_jadwal', ['BanjarDesa', 'BanjarBingin', 'BanjarDajanPakung']);
            $table->enum('Posyandu', ['PosyanduBalita', 'PosyanduLansia']);
            $table->enum('Imunisasi', ['iya', 'tidak']);
            $table->enum('obat_cacing', ['iya', 'tidak']);
            $table->enum('susu', ['iya', 'tidak']);
            $table->enum('tes_lansia', ['iya', 'tidak']);
            $table->enum('PMT_lansia', ['iya', 'tidak']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Jadwal');
    }
};
