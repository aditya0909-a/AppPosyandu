<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'location', 'date', 'imunisasi', 'obatcacing', 'susu',
        'pemeriksaan', 'teskognitif', 'tesdengar', 'teslihat', 'tesmobilisasi',
    ];

    // Relasi many-to-many dengan peserta balita
    public function pesertaBalita()
    {
        return $this->belongsToMany(PesertaPosyanduBalita::class, 'PesertaJadwalBalita', 'jadwal_id', 'peserta_id')
                    ->withPivot('id')
                    ->withTimestamps();
    }

    // Relasi many-to-many dengan peserta lansia
    public function pesertaLansia()
    {
        return $this->belongsToMany(PesertaPosyanduLansia::class, 'PesertaJadwalLansia', 'jadwal_id', 'peserta_id')
                    ->withPivot('id')
                    ->withTimestamps();
    }

    // Relasi ke Data Kesehatan Lansia
    public function dataKesehatanLansia()
    {
        return $this->hasMany(DataKesehatanLansia::class, 'jadwal_id', 'id');
    }
}
