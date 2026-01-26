<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('category_budgets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('category');
            $table->decimal('monthly_budget', 10, 2);
            $table->integer('year');
            $table->integer('month');
            $table->timestamps();
            
            $table->unique(['user_id', 'category', 'year', 'month']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('category_budgets');
    }
};
