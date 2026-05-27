<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('appeals', function (Blueprint $table) {
            $table->foreignId('problem_category_id')
                ->nullable()
                ->after('user_id')
                ->constrained('problem_categories')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('appeals', function (Blueprint $table) {
            $table->dropForeign(['problem_category_id']);
            $table->dropColumn('problem_category_id');
        });
    }
};
