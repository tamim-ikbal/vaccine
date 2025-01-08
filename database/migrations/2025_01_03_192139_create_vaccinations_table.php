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
        Schema::create('vaccinations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('enroll_id')->constrained();
            $table->unsignedSmallInteger('dose_id')->nullable();
            $table->dateTime('schedule_at');
            $table->dateTime('vaccinated_at')->nullable();
            $table->timestamps();

            $table->foreign('dose_id')->references('id')->on('doses')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vaccinations');
    }
};
