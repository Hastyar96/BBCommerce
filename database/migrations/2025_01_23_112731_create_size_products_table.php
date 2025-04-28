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
        Schema::create('size_products', function (Blueprint $table) {
            $table->id();

            // Foreign keys without constraints
            $table->unsignedBigInteger('main_product_id');
            $table->unsignedBigInteger('forward_product_id');

            // Size field (keep as string if sizes vary widely)
            $table->string('size');

            // Timestamps
            $table->timestamps();

            // Composite unique constraint
            $table->unique(['main_product_id', 'forward_product_id']);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('size_products');
    }
};
