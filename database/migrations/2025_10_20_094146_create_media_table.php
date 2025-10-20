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
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->string('file_name');
            $table->string('file_path');
            $table->string('file_type');
            $table->string('media_category');
            $table->unsignedBigInteger('size_bytes');
            $table->integer('width')->nullable();
            $table->integer('height')->nullable();
            $table->float('duration_seconds')->nullable();
            $table->text('thumbnail_url')->nullable();
            $table->string('owner_type');
            $table->string('owner_id');
            $table->string('source')->nullable();
            $table->string('status')->default('active');
            $table->jsonb('metadata')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
