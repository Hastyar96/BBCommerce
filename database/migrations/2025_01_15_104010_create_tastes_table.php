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
        Schema::create('tastes', function (Blueprint $table) {
            $table->id();

            // Unique taste name
            $table->string('name')->unique();

            // Optional active status for soft deletes
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
        Schema::dropIfExists('tastes');
    }
};
