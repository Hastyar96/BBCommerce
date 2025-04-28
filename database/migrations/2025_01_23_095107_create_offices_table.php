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
        Schema::create('offices', function (Blueprint $table) {
            $table->id();

            // Unique office name
            $table->string('name')->unique();

            // Phone number (ensure correct format or validation later)
            $table->string('phone');

            // Latitude and Longitude with decimal precision
            $table->decimal('lat', 10, 8);
            $table->decimal('long', 11, 8); // Latitude has a precision of 10, longitude 11

            // Timestamps
            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offices');
    }
};
