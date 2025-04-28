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
        Schema::create('currencies', function (Blueprint $table) {
            $table->id(); // Primary key

            // Unique currency name
            $table->string('name')->unique(); // Prevent duplicate currency names

            // ISO currency code (e.g., "USD", "EUR"), ensuring uniqueness
            $table->string('code', 3)->unique();

            // Currency symbol (e.g., "$", "€", "₹"), with an extended length
            $table->string('symbol', 15)->nullable();

            // Exchange rate with higher precision (consider increasing if needed)
            $table->decimal('exchange_rate', 18, 8)->default(1.00000000);

            // Active status
            $table->boolean('is_active')->default(true);

            // Timestamps
            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('currencies');
    }
};
