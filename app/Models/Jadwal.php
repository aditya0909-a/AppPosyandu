<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'location',
        'date',
        'imunisasi',
        'obatcacing',
        'susu',
        'kuisioner',
        'teskognitif',
        'tesdengar',
        'teslihat',
        'tesmobilisasi',
        'keluhan',
    ];

    protected $casts = [
        'date' => 'date',
        'imunisasi' => 'boolean',
        'obatcacing' => 'boolean',
        'susu' => 'boolean',
        'kuisioner' => 'boolean',
        'teskognitif' => 'boolean',
        'tesdengar' => 'boolean',
        'teslihat' => 'boolean',
        'tesmobilisasi' => 'boolean',
        'keluhan' => 'boolean',
    ];

    // Relasi many-to-many dengan peserta balita
    public function pesertaBalita()
    {
        return $this->belongsToMany(PesertaPosyanduBalita::class, 'PesertaJadwal', 'jadwal_id', 'peserta_id')
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
