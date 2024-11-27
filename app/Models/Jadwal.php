<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;

    protected $table = 'Jadwal';
    protected $fillable = ['nama_jadwal','tanggal_jadwal','lokasi_jadwal','Posyandu','Imunisasi','obat_cacing','susu','tes_lansia','PMT_lansia',];
}
