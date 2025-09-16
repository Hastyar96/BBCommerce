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
        Schema::create('faq_langs', function (Blueprint $table) {
            $table->id();
             $table->foreignId('faq_id')->constrained()->onDelete('cascade');
            $table->string('lang', 10); // e.g., 'en', 'fr', 'es'
            $table->string('question');
            $table->text('answer');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faq_langs');
    }
};
