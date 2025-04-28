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
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();

            // Action field (consider using enum for predefined actions)
            $table->string('action'); // e.g., 'purchase', 'sale', 'stock_adjustment'

            // Foreign keys without constraints
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('taste_id')->nullable();
            $table->decimal('quantity_changed', 10, 2);

            // Foreign key for office, nullable in case the action wasn't tied to a specific office
            $table->unsignedBigInteger('office_id')->nullable();

            // Timestamps
            $table->timestamps();

            // Optionally, add a user_id to track who performed the action
            $table->unsignedBigInteger('user_id')->nullable();

            // Optionally, add an active status flag
            $table->boolean('is_active')->default(true);
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
