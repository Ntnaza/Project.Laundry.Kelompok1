<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            // Hapus kolom yang berhubungan dengan pembayaran online
            $table->dropColumn(['status_pembayaran', 'payment_url']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            // Jika perlu mengembalikan, tambahkan kolomnya lagi
            $table->string('status_pembayaran')->default('Belum Lunas')->after('status');
            $table->string('payment_url')->nullable()->after('status_pembayaran');
        });
    }
};
