<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePesertaJadwalBalitaTable extends Migration
{
    public function up()
    {
        Schema::create('PesertaJadwalBalita', function (Blueprint $table) {
            $table->id();
            $table->foreignId('peserta_id')->constrained('PesertaPosyanduBalita')->onDelete('cascade');
            $table->foreignId('jadwal_id')->constrained('Jadwals')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('PesertaJadwalBalita');
    }
}
