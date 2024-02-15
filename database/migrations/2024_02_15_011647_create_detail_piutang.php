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
        Schema::create('detail_piutang', function (Blueprint $table) {
            $table->id('detail_piutang_id');
            $table->foreignId('piutang_id');
            $table->date('detail_tanggal');
            $table->decimal('bayar', 20, 0);
            $table->decimal('sisa', 20, 0);
            $table->foreignId('record_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_piutang');
    }
};
