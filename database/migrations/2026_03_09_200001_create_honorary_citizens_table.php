<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('honorary_citizens', function (Blueprint $table) {
            $table->id();
            $table->string('category'); // e.g. "Загорск и Загорский район", "Сергиево-Посадский район"
            $table->string('person_name');
            $table->text('person_info')->nullable();
            $table->string('awarded_by');
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('honorary_citizens');
    }
};
