<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePesertaJadwalLansiaTable extends Migration
{
    public function up()
    {
        Schema::create('PesertaJadwalLansia', function (Blueprint $table) {
            $table->id();
            $table->foreignId('peserta_id')->constrained('PesertaPosyanduLansia')->onDelete('cascade');
            $table->foreignId('jadwal_id')->constrained('Jadwals')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('PesertaJadwalLansia');
    }
}
