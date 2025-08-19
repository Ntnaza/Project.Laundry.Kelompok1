<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->string('kode_transaksi')->unique();
            $table->foreignId('pelanggan_id')->constrained('users')->onDelete('cascade');
            $table->dateTime('tgl_masuk');
            $table->dateTime('tgl_selesai')->nullable();
            $table->decimal('total_harga', 10, 2);
            $table->enum('status', ['Baru', 'Diproses', 'Selesai', 'Diambil']);
            $table->text('catatan_pelanggan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
