<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ensure category_budgets.user_id uses ON DELETE CASCADE toward users.
     * Fixes DBs where the FK was recreated without CASCADE (e.g. after FOREIGN_KEY_CHECKS=0 maintenance).
     */
    public function up(): void
    {
        if (Schema::getConnection()->getDriverName() !== 'mysql' || ! Schema::hasTable('category_budgets')) {
            return;
        }

        $db = DB::getDatabaseName();
        $names = DB::table('information_schema.KEY_COLUMN_USAGE')
            ->where('TABLE_SCHEMA', $db)
            ->where('TABLE_NAME', 'category_budgets')
            ->where('COLUMN_NAME', 'user_id')
            ->where('REFERENCED_TABLE_NAME', 'users')
            ->distinct()
            ->pluck('CONSTRAINT_NAME');

        foreach ($names as $name) {
            DB::statement('ALTER TABLE `category_budgets` DROP FOREIGN KEY `'.$name.'`');
        }

        Schema::table('category_budgets', function (Blueprint $table) {
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();
        });
    }

    /**
     * Rollback is intentionally not implemented: restoring a prior broken FK variant is unsafe.
     */
    public function down(): void
    {
        //
    }
};
