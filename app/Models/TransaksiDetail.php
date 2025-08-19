<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiDetail extends Model
{
    use HasFactory;

    public $timestamps = false; // Tabel ini tidak menggunakan created_at/updated_at

    protected $fillable = [
        'transaksi_id',
        'paket_id',
        'kuantitas',
        'subtotal',
    ];

    /**
     * Relasi ke model Paket.
     */
    public function paket()
    {
        return $this->belongsTo(Paket::class, 'paket_id');
    }
}
