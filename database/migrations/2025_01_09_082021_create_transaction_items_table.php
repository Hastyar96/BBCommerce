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
        Schema::create('transaction_items', function (Blueprint $table) {
            $table->id();

            // Foreign keys
            $table->unsignedBigInteger('transaction_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('currency_id');
            $table->unsignedBigInteger('office_id')->nullable();

            // Quantity, pricing, and discount
            $table->decimal('quantity', 10, 2);
            $table->decimal('price_per_unit', 10, 2);
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('total_price', 10, 2);

            // Optional fields
            $table->string('note')->nullable();

            // Gift flag as boolean
            $table->boolean('is_gift')->default(false);

            // Additional pricing details
            $table->decimal('buy_price', 10, 2);
            $table->decimal('price_single', 10, 2);
            $table->decimal('wholesale_price', 10, 2);

            // Timestamps
            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_items');
    }
};
