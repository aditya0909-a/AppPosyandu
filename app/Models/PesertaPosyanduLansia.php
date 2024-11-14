<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesertaPosyanduLansia extends Model
{
    use HasFactory;

    protected $table = 'PesertaPosyanduLansia';
    protected $fillable = ['nama_peserta_lansia', 'TTL_lansia', 'NIK_lansia', 'alamat_lansia', 'wa_lansia'];
}
