<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('administration_departments', function (Blueprint $table) {
            $table->id();
            $table->string('management_name');
            $table->string('head_text')->nullable();
            $table->string('schedule_text')->nullable();
            $table->text('body')->nullable(); // list items, one per line
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('administration_departments');
    }
};
