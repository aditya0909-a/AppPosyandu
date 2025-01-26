<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesertaPosyanduLansia extends Model
{
    use HasFactory;

    protected $table = 'PesertaPosyanduLansia';
    protected $fillable = [
        'nama_peserta_lansia',
        'user_id',
        'TempatLahir_lansia',
        'TanggalLahir_lansia',
        'NIK_lansia',
        'alamat_lansia',
        'wa_lansia'
    ];
 
    public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}

    // Relasi many-to-many dengan jadwal
    public function jadwals()
    {
        return $this->belongsToMany(Jadwal::class, 'PesertaJadwalLansia', 'peserta_id', 'jadwal_id')
                    ->withPivot('id')
                    ->withTimestamps();
    }

    // Relasi ke Data Kesehatan Lansia
    public function dataKesehatan()
    {
        return $this->hasMany(DataKesehatanLansia::class, 'peserta_id', 'id');
    }
}
