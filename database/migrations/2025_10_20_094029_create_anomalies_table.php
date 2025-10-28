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
        Schema::create('anomalies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->text('symptoms');
            $table->text('solutions');
            $table->text('preventions');
            $table->text('causes');
            $table->string('category');
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->foreignId('plant_id')->constrained('plants')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anomalies');
    }
};
