<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('budgets', function (Blueprint $table) {
            $table->integer('dependents')->nullable()->after('age');
            $table->string('debt')->nullable()->after('dependents');
            $table->string('goal')->nullable()->after('debt');
        });
    }

    public function down()
    {
        Schema::table('budgets', function (Blueprint $table) {
            $table->dropColumn(['dependents', 'debt', 'goal']);
        });
    }
}; 