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
        Schema::create('utang', function (Blueprint $table) {
            $table->id('utang_id');
            $table->foreignId('pembelian_id');
            $table->date('tanggal');
            $table->decimal('uang_muka', 20, 1);
            $table->decimal('sisa_pembayaran', 20, 1);
            $table->date('tanggal_jatuh_tempo');
            $table->enum('status_pembayaran', ['L', 'U']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('utang');
    }
};
