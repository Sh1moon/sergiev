<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('appeals', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->after('id')->constrained()->onDelete('cascade');
            $table->text('response')->nullable()->after('body');
            $table->timestamp('responded_at')->nullable()->after('response');
            $table->foreignId('responded_by')->nullable()->after('responded_at')->constrained('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('appeals', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['responded_by']);
            $table->dropColumn(['user_id', 'response', 'responded_at', 'responded_by']);
        });
    }
};
