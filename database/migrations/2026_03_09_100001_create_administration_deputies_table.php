<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('administration_deputies', function (Blueprint $table) {
            $table->id();
            $table->string('photo')->nullable();
            $table->string('name');
            $table->string('position')->nullable();
            $table->text('description')->nullable();
            $table->text('contacts')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->string('slug')->nullable()->unique();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('administration_deputies');
    }
};
