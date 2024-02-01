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
        Schema::create('pembelian', function (Blueprint $table) {
            $table->id('pembelian_id');
            $table->bigInteger('nota')->unique();
            $table->foreignId('supplier_id');
            $table->date('tanggal_pembelian');
            $table->enum('jenis_pembelian', ['cash', 'credit']);
            $table->integer('total_item');
            $table->decimal('total_harga', 20, 0)->default(0);
            $table->tinyInteger('diskon')->default(0);
            $table->decimal('total_bayar', 20, 0)->default(0);
            $table->enum('status_pembayaran', ['L', 'U']);
            $table->text('catatan')->nullable();
            $table->foreignId('record_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembelian');
    }
};
