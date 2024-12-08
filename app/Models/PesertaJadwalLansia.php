<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesertaJadwalLansia extends Model
{
    use HasFactory;

    protected $table = 'PesertaJadwalLansia'; // Nama tabel pivot
    protected $fillable = [
        'peserta_id', 
        'jadwal_id'
    ];

    // Relasi ke model PesertaPosyanduLansia
    public function peserta()
    {
        return $this->belongsTo(PesertaPosyanduLansia::class, 'peserta_id', 'id');
    }

    // Relasi ke model Jadwal
    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class, 'jadwal_id', 'id');
    }
}
