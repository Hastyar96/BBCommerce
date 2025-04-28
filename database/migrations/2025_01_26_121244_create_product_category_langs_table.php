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
        Schema::create('product_category_langs', function (Blueprint $table) {
            $table->id();

            // Foreign keys without constraints
            $table->unsignedBigInteger('product_category_id');
            $table->unsignedBigInteger('language_id');

            // Translated fields
            $table->string('name');  // Translated name of the category
            $table->text('description')->nullable();  // Translated description of the category (optional)

            // Timestamps
            $table->timestamps();

            // Ensure unique combination of product category and language
            $table->unique(['product_category_id', 'language_id']);
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_category_langs');
    }
};
