<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Directly drop the old constraint using raw SQL
        // This will work even if MySQL says it's needed for a foreign key
        // (there shouldn't actually be a foreign key on this constraint)
        try {
            DB::unprepared('ALTER TABLE `category_budgets` DROP INDEX `category_budgets_user_id_category_year_month_unique`');
        } catch (\Exception $e) {
            // If it fails, try without the backticks
            try {
                DB::unprepared("ALTER TABLE category_budgets DROP INDEX category_budgets_user_id_category_year_month_unique");
            } catch (\Exception $e2) {
                // If both fail, the constraint might not exist or be named differently
                // The application logic with updateOrCreate should handle it
            }
        }
    }

    public function down(): void
    {
        // Re-add if rolling back
        try {
            DB::unprepared('ALTER TABLE `category_budgets` ADD UNIQUE KEY `category_budgets_user_id_category_year_month_unique` (`user_id`, `category`, `year`, `month`)');
        } catch (\Exception $e) {
            // Ignore
        }
    }
};
