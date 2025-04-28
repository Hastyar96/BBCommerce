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
        Schema::create('goal_langs', function (Blueprint $table) {
            $table->id();

            // Foreign keys without constraints
            $table->unsignedBigInteger('goal_id');
            $table->unsignedBigInteger('language_id');

            // Translated fields
            $table->string('name');  // Translated name of the goal
            $table->text('description')->nullable();  // Translated description of the goal (optional)

            // Timestamps
            $table->timestamps();

            // Ensure unique combination of goal and language
            $table->unique(['goal_id', 'language_id']);
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('goal_langs');
    }
};
