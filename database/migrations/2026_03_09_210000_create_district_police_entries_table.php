<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('district_police_entries', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('sort_order')->default(0);
            $table->string('admin_district')->nullable(); // Административный участок
            $table->text('responsible')->nullable();      // Ответственный
            $table->text('substitute')->nullable();       // Замещает ответственного
            $table->text('residential_sector')->nullable(); // Жилой сектор
            $table->text('reception_days')->nullable();  // Дни приема граждан
            $table->text('leadership_reception_days')->nullable(); // Дни приема ответственного от руководства
            $table->text('reception_place')->nullable();  // Место приема граждан
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('district_police_entries');
    }
};
