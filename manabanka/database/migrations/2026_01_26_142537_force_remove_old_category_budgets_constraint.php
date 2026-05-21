<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Drop the foreign key on user_id first
        try {
            DB::statement('ALTER TABLE `category_budgets` DROP FOREIGN KEY `category_budgets_user_id_foreign`');
        } catch (\Exception $e) {
            // might not exist
        }

        // Now drop the unique index safely
        try {
            DB::statement('ALTER TABLE `category_budgets` DROP INDEX `category_budgets_user_id_category_year_month_unique`');
        } catch (\Exception $e) {
            // already gone
        }

        // Re-add foreign key
        try {
            Schema::table('category_budgets', function (Blueprint $table) {
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            });
        } catch (\Exception $e) {}

        // Add new unique constraint
        try {
            Schema::table('category_budgets', function (Blueprint $table) {
                $table->unique(['budget_id', 'category', 'year', 'month'], 'category_budgets_budget_id_category_year_month_unique');
            });
        } catch (\Exception $e) {}
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Don't recreate the old constraint as it's incompatible with the new system
    }
};
