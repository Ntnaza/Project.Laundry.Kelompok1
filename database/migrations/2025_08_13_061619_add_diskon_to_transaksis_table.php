<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->decimal('subtotal', 10, 2)->after('pelanggan_id');
            $table->decimal('jumlah_diskon', 10, 2)->default(0)->after('subtotal');
            // Ganti nama kolom 'total_harga' menjadi 'total_bayar' agar lebih jelas
            $table->renameColumn('total_harga', 'total_bayar');
        });
    }

    public function down(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->dropColumn('subtotal');
            $table->dropColumn('jumlah_diskon');
            $table->renameColumn('total_bayar', 'total_harga');
        });
    }
};
