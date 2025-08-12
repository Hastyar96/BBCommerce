<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
      public function up()
    {
        Schema::create('country_codes', function (Blueprint $table) {
            $table->id();
            $table->string('country_name');          // e.g. Iraq
            $table->string('iso_code', 2);           // e.g. IQ
            $table->string('dialing_code');          // e.g. 00964
            $table->string('flag_path')->nullable(); // e.g. flags/IQ.png or emoji 🇮🇶
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('country_codes');
    }
};
