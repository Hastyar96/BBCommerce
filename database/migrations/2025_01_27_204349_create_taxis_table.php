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
        Schema::create('taxis', function (Blueprint $table) {
            $table->id();

            // Basic fields
            $table->string('name')->nullable();  // Taxi name (optional)
            $table->unsignedBigInteger('office_id')->nullable();  // Link to offices table
            $table->string('tablo')->nullable();  // Tablo or any identifier
            $table->string('xawan_name')->nullable();  // Xawan name (optional)
            $table->string('phone')->nullable();  // Taxi phone number (optional)

            // Timestamps
            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('taxis');
    }
};
