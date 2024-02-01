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
        Schema::create('piutang', function (Blueprint $table) {
            $table->id('piutang_id');
            $table->foreignId('penjualan_id');
            $table->string('nama_customer');
            $table->decimal('jumlah_piutang', 20, 0)->default(0);
            $table->decimal('uang_muka', 20, 0)->default(0);
            $table->decimal('sisa_piutang', 20, 0)->default(0);
            $table->date('tanggal_jatuh_tempo');
            $table->enum('status_pembayaran', ['L', 'U']);
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('piutang');
    }
};
