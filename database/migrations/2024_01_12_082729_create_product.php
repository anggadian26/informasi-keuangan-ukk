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
        Schema::create('product', function (Blueprint $table) {
            $table->id('product_id');
            $table->foreignId('sub_ctgr_product_id');
            $table->string('product_code');
            $table->string('product_name');
            $table->string('merek');
            $table->decimal('product_purcase', 20, 0);
            $table->decimal('product_price', 20, 0);
            $table->enum('status', ['Y', 'N']);
            $table->foreignId('record_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product');
    }
};
