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
        // Forcefully drop the old unique constraint using raw SQL
        // This constraint is causing conflicts because it doesn't include budget_id
        try {
            DB::unprepared('ALTER TABLE `category_budgets` DROP INDEX `category_budgets_user_id_category_year_month_unique`');
        } catch (\Exception $e) {
            // Constraint might not exist or have a different name
            // Try alternative method
            try {
                DB::statement('ALTER TABLE `category_budgets` DROP INDEX IF EXISTS `category_budgets_user_id_category_year_month_unique`');
            } catch (\Exception $e2) {
                // If both fail, check if it exists first
                $constraintExists = DB::selectOne("
                    SELECT COUNT(*) as count 
                    FROM information_schema.STATISTICS 
                    WHERE TABLE_SCHEMA = DATABASE() 
                    AND TABLE_NAME = 'category_budgets' 
                    AND INDEX_NAME = 'category_budgets_user_id_category_year_month_unique'
                ");
                
                if ($constraintExists && $constraintExists->count > 0) {
                    // Force drop using a different approach
                    DB::unprepared('SET FOREIGN_KEY_CHECKS=0; ALTER TABLE `category_budgets` DROP INDEX `category_budgets_user_id_category_year_month_unique`; SET FOREIGN_KEY_CHECKS=1;');
                }
            }
        }
        
        // Ensure the new unique constraint exists (on budget_id, category, year, month)
        if (!Schema::hasColumn('category_budgets', 'budget_id')) {
            // budget_id column doesn't exist, skip constraint creation
            return;
        }
        
        // Check if the new constraint already exists
        $newConstraintExists = DB::selectOne("
            SELECT COUNT(*) as count 
            FROM information_schema.STATISTICS 
            WHERE TABLE_SCHEMA = DATABASE() 
            AND TABLE_NAME = 'category_budgets' 
            AND INDEX_NAME = 'category_budgets_budget_id_category_year_month_unique'
        ");
        
        if (!$newConstraintExists || $newConstraintExists->count == 0) {
            try {
                Schema::table('category_budgets', function (Blueprint $table) {
                    $table->unique(['budget_id', 'category', 'year', 'month'], 'category_budgets_budget_id_category_year_month_unique');
                });
            } catch (\Exception $e) {
                // Constraint might already exist with a different name
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Don't recreate the old constraint as it's incompatible with the new system
    }
};
