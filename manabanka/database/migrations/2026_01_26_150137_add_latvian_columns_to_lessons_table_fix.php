<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('lessons', function (Blueprint $table) {
            if (!Schema::hasColumn('lessons', 'title_lv')) {
                $table->string('title_lv')->nullable()->after('title');
            }
            if (!Schema::hasColumn('lessons', 'description_lv')) {
                $table->text('description_lv')->nullable()->after('description');
            }
            if (!Schema::hasColumn('lessons', 'content_lv')) {
                $table->text('content_lv')->nullable()->after('content');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lessons', function (Blueprint $table) {
            if (Schema::hasColumn('lessons', 'title_lv')) {
                $table->dropColumn('title_lv');
            }
            if (Schema::hasColumn('lessons', 'description_lv')) {
                $table->dropColumn('description_lv');
            }
            if (Schema::hasColumn('lessons', 'content_lv')) {
                $table->dropColumn('content_lv');
            }
        });
    }
};
