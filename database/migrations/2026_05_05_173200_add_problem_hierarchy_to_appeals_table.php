<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('appeals', function (Blueprint $table) {
            $table->foreignId('problem_subcategory_id')
                ->nullable()
                ->after('problem_category_id')
                ->constrained('problem_subcategories')
                ->nullOnDelete();
            $table->foreignId('problem_detail_id')
                ->nullable()
                ->after('problem_subcategory_id')
                ->constrained('problem_details')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('appeals', function (Blueprint $table) {
            $table->dropForeign(['problem_subcategory_id']);
            $table->dropForeign(['problem_detail_id']);
            $table->dropColumn(['problem_subcategory_id', 'problem_detail_id']);
        });
    }
};
