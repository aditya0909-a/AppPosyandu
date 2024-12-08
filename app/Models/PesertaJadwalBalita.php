<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesertaJadwalBalita extends Model
{
    use HasFactory;

    protected $table = 'PesertaJadwalBalita'; // Nama tabel pivot
    protected $fillable = [
        'peserta_id', 
        'jadwal_id'
    ];

    // Relasi ke model PesertaPosyanduBalita
    public function peserta()
    {
        return $this->belongsTo(PesertaPosyanduBalita::class, 'peserta_id', 'id');
    }

    // Relasi ke model Jadwal
    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class, 'jadwal_id', 'id');
    }
}
