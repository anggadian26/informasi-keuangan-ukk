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
        Schema::create('return_barang', function (Blueprint $table) {
            $table->id('return_barang_id');
            $table->date('tanggal');
            $table->decimal('nota_penjualan', 20, 0);
            $table->foreignId('product_id');
            $table->integer('jumlah_return');
            $table->foreignId('record_id');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('return_barang');
    }
};
