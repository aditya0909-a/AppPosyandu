<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataKesehatanBalita extends Model
{
    use HasFactory;

    protected $table = 'DataKesehatanBalita';
    protected $fillable = ['peserta_id','bulan_ke', 'tinggi_Balita', 'berat_balita', 'lingkar_kepala_balita', 'imunisasi', 'obat_cacing', 'susu', 'keluhan_balita', 'penanganan_balita'];

    public function peserta()
    {
        return $this->belongsTo(PesertaPosyanduBalita::class, 'peserta_id', 'id');
    }

}
