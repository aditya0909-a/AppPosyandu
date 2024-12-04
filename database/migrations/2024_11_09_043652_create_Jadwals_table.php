<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     *      */
    public function up() : void
    {
        Schema::create('jadwals', function (Blueprint $table) {
            $table->id();
            $table->enum('name', ['Posyandu Balita', 'Posyandu Lansia']); // Kolom enum untuk nama
            $table->enum('location', ['Bingin', 'Desa', 'Dajan Pangkung']); // Kolom enum untuk lokasi
            $table->date('date'); // Kolom tanggal
            $table->boolean('imunisasi')->default(false); // Kolom boolean imunisasi
            $table->boolean('obatcacing')->default(false); // Kolom boolean obatcacing
            $table->boolean('susu')->default(false); // Kolom boolean susu
            $table->boolean('kuisioner')->default(false); // Kolom boolean kuisioner
            $table->boolean('teskognitif')->default(false); // Kolom boolean teskognitif
            $table->boolean('tesdengar')->default(false); // Kolom boolean tesdengar
            $table->boolean('teslihat')->default(false); // Kolom boolean teslihat
            $table->boolean('tesmobilisasi')->default(false); // Kolom boolean tesmobilisasi
            $table->boolean('keluhan')->default(false); // Kolom boolean keluhan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
 
     */
    public function down() : void
    {
        Schema::dropIfExists('jadwals');
    }
};
