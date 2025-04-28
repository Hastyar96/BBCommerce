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
        Schema::create('product_tastes', function (Blueprint $table) {
            $table->id();

            // Foreign keys without constraints
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('taste_id');

            // Timestamps
            $table->timestamps();

            // Composite unique constraint
            $table->unique(['product_id', 'taste_id']);
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_tastes');
    }
};
