<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('management_company_rows', function (Blueprint $table) {
            $table->id();
            $table->string('section'); // managing, resource
            $table->string('num', 10);
            $table->text('content');
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('management_company_rows');
    }
};
