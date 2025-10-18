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
        Schema::create('soil_analyses', function (Blueprint $table) {
            $table->id();
            $table->text('sensor_data')->nullable();
            $table->text('crops_recommanded')->nullable();
            $table->text('description')->nullable();
            $table->string('sensor_model')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('soil_analyses');
    }
};
