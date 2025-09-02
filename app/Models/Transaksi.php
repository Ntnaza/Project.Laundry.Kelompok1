<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $casts = [
        'tgl_masuk' => 'datetime',
        'tgl_selesai' => 'datetime',
    ];

    protected $fillable = [
        'kode_transaksi',
        'pelanggan_id',
        'subtotal',
        'jumlah_diskon',
        'total_bayar',
        'tgl_masuk',
        'tgl_selesai',
        'status',
        'status_pembayaran', // TAMBAHKAN INI
        'payment_url',       // TAMBAHKAN INI
        'catatan_pelanggan',
    ];

    public function pelanggan()
    {
        return $this->belongsTo(User::class, 'pelanggan_id');
    }

    public function details()
    {
        return $this->hasMany(TransaksiDetail::class);
    }
}
