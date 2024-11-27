<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataKesehatanLansia extends Model
{
    use HasFactory;

    protected $table = 'DataKesehatanLansia';
    protected $fillable = ['tinggi_lansia','berat_lansia','lingkar_lengan_lansia','lingkar_perut_lansia','kognitif_lokasi','kognitif_waktu','kognitif_kecemasan','dengar_bisik','dengar_langsung','lihat','mobilisasi','PMT','keluhan_lansia','obat_lansia' ];
}
