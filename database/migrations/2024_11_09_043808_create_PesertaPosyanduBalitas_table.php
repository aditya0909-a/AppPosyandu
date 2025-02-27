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
        Schema::create('PesertaPosyanduBalita', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('nama_peserta_balita');
            $table->string('TempatLahir_balita');
            $table->date('TanggalLahir_balita');
            $table->string('NIK_balita');
            $table->string('nama_orangtua_balita');
            $table->string('NIK_orangtua_balita');
            $table->string('alamat_balita');
            $table->string('wa_balita');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('PesertaPosyanduBalita', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
        Schema::dropIfExists('PesertaPosyanduBalita');
    }
};

