<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataKesehatanLansia extends Model
{
    use HasFactory;

    protected $table = 'DataKesehatanLansia';
    protected $fillable = [
        'peserta_id',
        'jadwal_id', // Tambahkan kolom untuk referensi jadwal
        'tinggi_lansia',
        'berat_lansia',
        'lingkar_lengan_lansia',
        'lingkar_perut_lansia',
        'kognitif_lokasi',
        'kognitif_waktu',
        'kognitif_kecemasan',
        'dengar_bisik',
        'dengar_langsung',
        'lihat',
        'mobilisasi',
        'PMT',
        'tensi_lansia',
        'guladarah_lansia',
        'kolesterol_lansia',
        'keluhan_lansia',
        'obat_lansia'
    ];

    public function peserta()
    {
        return $this->belongsTo(PesertaPosyanduLansia::class, 'peserta_id', 'id');
    }

    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class, 'jadwal_id', 'id');
    }
}

