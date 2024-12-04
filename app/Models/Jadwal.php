<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;

    /**
     * Kolom yang dapat diisi (mass assignable).
     *
     * @var array
     */
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

    /**
     * Casting atribut ke tipe data tertentu.
     *
     * @var array
     */
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
}
