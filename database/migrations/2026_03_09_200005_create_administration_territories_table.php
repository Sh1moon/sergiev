<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('administration_territories', function (Blueprint $table) {
            $table->id();
            $table->string('management');
            $table->string('leader')->nullable();
            $table->text('contacts')->nullable();
            $table->string('address')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('administration_territories');
    }
};
