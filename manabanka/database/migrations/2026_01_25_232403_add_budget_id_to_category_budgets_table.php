<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Check if column exists, if not add it
        if (!Schema::hasColumn('category_budgets', 'budget_id')) {
            Schema::table('category_budgets', function (Blueprint $table) {
                $table->foreignId('budget_id')->nullable()->after('user_id');
            });
        }
        
        // Add foreign key constraint if column exists
        if (Schema::hasColumn('category_budgets', 'budget_id')) {
            try {
                Schema::table('category_budgets', function (Blueprint $table) {
                    $table->foreign('budget_id')->references('id')->on('budgets')->onDelete('cascade');
                });
            } catch (\Exception $e) {
                // Foreign key might already exist
            }
        }
        
        // Remove old unique constraint if it exists
        try {
            Schema::table('category_budgets', function (Blueprint $table) {
                // $table->dropUnique(['user_id', 'category', 'year', 'month']);
            });
        } catch (\Exception $e) {
            // Constraint might not exist, continue
        }
        
        // Add new unique constraint with budget_id
        try {
            Schema::table('category_budgets', function (Blueprint $table) {
                $table->unique(['budget_id', 'category', 'year', 'month']);
            });
        } catch (\Exception $e) {
            // Index might already exist
        }
    }

    public function down(): void
    {
        Schema::table('category_budgets', function (Blueprint $table) {
            $table->dropForeign(['budget_id']);
            // $table->dropUnique(['budget_id', 'category', 'year', 'month']);
            $table->dropColumn('budget_id');
            $table->unique(['user_id', 'category', 'year', 'month']);
        });
    }
};
