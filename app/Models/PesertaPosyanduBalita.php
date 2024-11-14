<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesertaPosyanduBalita extends Model
{
    use HasFactory;

    protected $table = 'PesertaPosyanduBalita';
    protected $fillable = ['nama_peserta_balita', 'TTL_balita', 'NIK_balita', 'nama_orangtua_balita', 'NIK_orangtua_balita', 'alamat_balita', 'wa_balita'];
}
