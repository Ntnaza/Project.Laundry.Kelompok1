<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('diskons', function (Blueprint $table) {
            $table->id();
            $table->string('kode_diskon')->unique();
            $table->text('keterangan');
            $table->enum('tipe', ['persen', 'nominal']);
            $table->decimal('nilai', 10, 2);
            $table->decimal('minimum_belanja', 10, 2)->default(0);
            $table->date('berlaku_dari');
            $table->date('berlaku_sampai');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('diskons');
    }
};
