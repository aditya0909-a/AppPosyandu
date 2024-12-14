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
        Schema::create('PesertaPosyanduLansia', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('nama_peserta_lansia');
            $table->string('TempatLahir_lansia');
            $table->date('TanggalLahir_lansia');
            $table->string('NIK_lansia');
            $table->string('alamat_lansia');
            $table->string('wa_lansia');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('PesertaPosyanduLansia');
    }
};

