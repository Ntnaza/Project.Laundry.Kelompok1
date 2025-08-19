<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_transaksi',
        'pelanggan_id',
        'tgl_masuk',
        'tgl_selesai',
        'total_harga',
        'status',
        'catatan_pelanggan',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'tgl_masuk' => 'datetime',
        'tgl_selesai' => 'datetime',
    ];

    /**
     * Relasi ke model User (Pelanggan).
     */
    public function pelanggan()
    {
        return $this->belongsTo(User::class, 'pelanggan_id');
    }

    /**
     * Relasi ke model TransaksiDetail.
     */
    public function details()
    {
        return $this->hasMany(TransaksiDetail::class);
    }
}
