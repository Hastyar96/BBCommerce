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
        Schema::create('product_prices', function (Blueprint $table) {
            $table->id();

            // Foreign keys should be unsignedBigInteger, not string
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('currency_id');

            // Price with decimal precision
            $table->decimal('price', 10, 2);

            // Status field
            $table->boolean('is_active')->default(true);

            // JSON field for office IDs
            $table->json('office_ids')->nullable();

            // Timestamps
            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_prices');
    }
};
