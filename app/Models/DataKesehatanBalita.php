<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataKesehatanBalita extends Model
{
    use HasFactory;

    protected $table = 'DataKesehatanBalita';
    protected $fillable = ['tinggi_Balita', 'berat_balita', 'lingkar_kepala_balita', 'imunisasi', 'obat_cacing', 'susu'];
}
