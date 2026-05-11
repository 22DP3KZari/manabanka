<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Speed up typical filters: by user + date range, and budget-scoped spending.
     */
    public function up(): void
    {
        Schema::table('spendings', function (Blueprint $table) {
            $table->index(['user_id', 'date'], 'spendings_user_id_date_index');
            $table->index(['user_id', 'budget_id', 'date'], 'spendings_user_budget_date_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('spendings', function (Blueprint $table) {
            $table->dropIndex('spendings_user_id_date_index');
            $table->dropIndex('spendings_user_budget_date_index');
        });
    }
};
