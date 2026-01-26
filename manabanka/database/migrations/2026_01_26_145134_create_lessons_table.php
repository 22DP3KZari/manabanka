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
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->text('content'); // Full lesson content (can be HTML/markdown)
            $table->string('category'); // e.g., 'etf', 'sp500', 'basics', 'risk'
            $table->integer('order')->default(0); // Order within category
            $table->integer('duration_minutes')->nullable(); // Estimated reading time
            $table->string('difficulty')->default('beginner'); // beginner, intermediate, advanced
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lessons');
    }
};
