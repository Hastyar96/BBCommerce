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
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            // Use unsignedBigInteger for foreign keys instead of string
            $table->unsignedBigInteger('brand_id');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('goal_id');
            $table->unsignedBigInteger('tag_id');

            // Define size-related columns
            $table->string('size_type');
            $table->json('size'); // JSON type for storing multiple sizes

            // Status & Boolean fields
            $table->boolean('status')->default(true); // Active by default
            $table->boolean('for_gift')->default(false); // Default inactive
            $table->boolean('for_sell')->default(true); // Default active
            $table->boolean('for_buy')->default(true); // Default active

            // Numeric price field
            $table->decimal('buy_price', 10, 2);

            // Optional note
            $table->text('note')->nullable();

            // Timestamps
            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
