<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiDetail extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'transaksi_id',
        'paket_id',
        'kuantitas',
        'harga', // <-- PASTIKAN BARIS INI ADA
        'subtotal',
    ];

    /**
     * Mendapatkan paket yang terkait dengan detail transaksi.
     */
    public function paket()
    {
        return $this->belongsTo(Paket::class);
    }
}

