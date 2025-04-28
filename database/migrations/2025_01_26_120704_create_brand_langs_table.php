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
        Schema::create('brand_langs', function (Blueprint $table) {
            $table->id();

            // Foreign keys without constraints
            $table->unsignedBigInteger('brand_id');
            $table->unsignedBigInteger('language_id');

            // Localized brand information
            $table->string('name');  // Translated brand name
            $table->text('description')->nullable();  // Translated description (optional)

            // Timestamps
            $table->timestamps();

            // Ensure unique brand-language combination
            $table->unique(['brand_id', 'language_id']);
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brand_langs');
    }
};
