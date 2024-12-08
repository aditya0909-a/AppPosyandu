<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesertaPosyanduBalita extends Model
{
    use HasFactory;

    protected $table = 'PesertaPosyanduBalita';
    protected $fillable = [
        'nama_peserta_balita',
        'TempatLahir_balita',
        'TanggalLahir_balita',
        'NIK_balita',
        'nama_orangtua_balita',
        'NIK_orangtua_balita',
        'alamat_balita',
        'wa_balita'
    ];

    // Relasi many-to-many dengan Jadwal
    public function jadwals()
    {
        return $this->belongsToMany(Jadwal::class, 'PesertaJadwal', 'peserta_id', 'jadwal_id')
                    ->withPivot('id') // Mengakses id pivot jika diperlukan
                    ->withTimestamps();
    }

    // Relasi ke Data Kesehatan
    public function dataKesehatan()
    {
        return $this->hasMany(DataKesehatanBalita::class, 'peserta_id', 'id');
    }
}
