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
        Schema::create('ctgr_product', function (Blueprint $table) {
            $table->id('ctgr_product_id');
            $table->string('ctgr_product_code')->unique();
            $table->string('ctgr_product_name');
            $table->enum('status', ['Y', 'N'])->default('Y');
            $table->foreignId('record_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ctgr_product');
    }
};
