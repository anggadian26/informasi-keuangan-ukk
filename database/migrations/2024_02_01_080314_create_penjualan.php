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
        Schema::create('penjualan', function (Blueprint $table) {
            $table->id('penjualan_id');
            $table->bigInteger('nota')->unique();
            $table->date('tanggal_penjualan');
            $table->enum('jenis_transaksi', ['cash', 'credit']);
            $table->enum('flg_member', ['Y', 'N']);
            $table->foreignId('member_id')->nullable();
            $table->integer('total_item');
            $table->decimal('total_harga', 20, 0)->default(0);
            $table->tinyInteger('diskon')->default(0);
            $table->decimal('harga_akhir', 20, 0)->default(0);
            $table->decimal('bayar', 20, 0);
            $table->decimal('kembalian', 20, 0);
            $table->enum('status_pembayaran', ['L', 'N']);
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
        Schema::dropIfExists('penjualan');
    }
};
