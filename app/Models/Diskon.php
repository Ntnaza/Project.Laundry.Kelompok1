<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diskon extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_diskon',
        'keterangan',
        'tipe',
        'nilai',
        'minimum_belanja',
        'berlaku_dari',
        'berlaku_sampai',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'berlaku_dari' => 'date',
        'berlaku_sampai' => 'date',
    ];
}
