<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('budgets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('age');
            $table->decimal('income', 10, 2);
            $table->decimal('fixed_expenses', 10, 2);
            $table->decimal('wants', 10, 2);
            $table->decimal('savings', 10, 2);
            $table->decimal('other', 10, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('budgets');
    }
}; 