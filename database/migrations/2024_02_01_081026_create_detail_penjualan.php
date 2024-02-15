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
        Schema::create('detail_penjualan', function (Blueprint $table) {
            $table->id('detail_penjualan_id');
            $table->foreignId('penjualan_id');
            $table->foreignId('product_id');
            $table->decimal('harga_jual', 20,0)->default(0);
            $table->decimal('harga_diskon', 20,0)->default(0);
            $table->integer('jumlah')->default(0);
            $table->tinyInteger('diskon')->default(0);
            $table->decimal('sub_total', 20, 0);
            $table->enum('flg_return', ['Y','N']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_penjualan');
    }
};
