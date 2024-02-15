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
        Schema::create('pemasukkan', function (Blueprint $table) {
            $table->id('pemasukkan_id');
            $table->enum('jenis_pemasukkan', ['P','L'])->default('L');
            $table->date('tanggal_pemasukkan');
            $table->decimal('total_nominal', 20, 0);
            $table->text('keterangan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemasukkan');
    }
};
