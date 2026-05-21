<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Drop the old unique constraint by name
        try {
            DB::statement('ALTER TABLE `category_budgets` DROP INDEX `category_budgets_user_id_category_year_month_unique`');
        } catch (\Exception $e) {
            // Constraint might not exist or have different name, try alternative
            try {
                Schema::table('category_budgets', function (Blueprint $table) {
                    // $table->dropUnique(['user_id', 'category', 'year', 'month']);
                });
            } catch (\Exception $e2) {
                // If both fail, the constraint might already be removed
            }
        }
        
        // Ensure the new unique constraint exists
        try {
            Schema::table('category_budgets', function (Blueprint $table) {
                $table->unique(['budget_id', 'category', 'year', 'month']);
            });
        } catch (\Exception $e) {
            // Constraint might already exist
        }
    }

    public function down(): void
    {
        // Re-add the old constraint if needed
        try {
            Schema::table('category_budgets', function (Blueprint $table) {
                // $table->dropUnique(['budget_id', 'category', 'year', 'month']);
                $table->unique(['user_id', 'category', 'year', 'month']);
            });
        } catch (\Exception $e) {
            // Ignore errors
        }
    }
};
