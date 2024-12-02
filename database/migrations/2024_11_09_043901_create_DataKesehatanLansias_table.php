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
            $table->timestamps();
            $table->integer('tinggi_lansia');
            $table->integer('berat_lansia');
            $table->integer('lingkar_lengan_lansia');
            $table->integer('lingkar_perut_lansia');
            $table->enum('kognitif_lokasi', ['bisa', 'tidak']); 
            $table->enum('kognitif_waktu', ['bisa', 'tidak']);
            $table->enum('kognitif_kecemasan', ['cemas', 'tidak']); 
            $table->enum('dengar_bisik', ['tidak_baik', 'kurang baik', 'cukup_baik', 'baik', 'sangat_baik']); 
            $table->enum('dengar_langsung', ['tidak_baik', 'kurang baik', 'cukup_baik', 'baik', 'sangat_baik']);
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
