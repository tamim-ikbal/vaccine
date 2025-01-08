<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('doses', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->unsignedSmallInteger('vaccine_id');
            $table->string('name', 30);
            $table->unsignedSmallInteger('interval_days');
            $table->unsignedTinyInteger('sequence');
            $table->timestamps();

            $table->foreign('vaccine_id')->references('id')->on('vaccines');
            $table->unique(['vaccine_id', 'sequence'], 'vaccine_dose_sequence');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doses');
    }
};
