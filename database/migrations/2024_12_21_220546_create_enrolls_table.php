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
        Schema::create('enrolls', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('vaccine_center_id');
            $table->string('name', 100);
            $table->string('email', 100);
            $table->string('phone', 20);
            $table->string('nid', 30)->unique();
            $table->date('dob');
            $table->date('schedule_at')->nullable();
            $table->timestamps();

            $table->foreign('vaccine_center_id')->on('vaccine_centers')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrolls');
    }
};
