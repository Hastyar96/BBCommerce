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
        Schema::create('product_langs', function (Blueprint $table) {
            $table->id();

            // Foreign keys without constraints
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('language_id');

            // Increase p_name length and change p_description to text
            $table->string('p_name', 500); // Allow longer product names
            $table->text('p_description'); // Support longer descriptions

            // Timestamps
            $table->timestamps();

            // Ensure unique product-language combinations
            $table->unique(['product_id', 'language_id']);
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_langs');
    }
};
