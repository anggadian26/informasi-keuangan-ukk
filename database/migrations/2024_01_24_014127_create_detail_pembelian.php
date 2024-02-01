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
        Schema::create('detail_pembelian', function (Blueprint $table) {
            $table->id('detail_pembelian_id');
            $table->foreignId('pembelian_id');
            $table->foreignId('product_id');
            $table->decimal('harga_beli', 20, 1);
            $table->decimal('harga_jual', 20, 1);
            $table->integer('jumlah');
            $table->decimal('sub_total', 20, 1);
            $table->enum('flg_return', ['Y', 'N']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_pembelian');
    }
};
