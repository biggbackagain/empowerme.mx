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
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // "Wellness Day"
            $table->string('slug')->unique(); // "wellness-day" (para la URL pública)
            $table->text('summary'); // Resumen corto (el que se ve en la tarjeta de inicio)
            $table->text('includes')->nullable(); // "Qué incluye" - una línea por punto
            $table->string('price')->nullable(); // Texto libre: "$X,XXX MXN" o "Cotiza con nosotros"
            $table->string('image_url')->nullable();
            $table->integer('order')->default(0); // Para controlar el orden en el sitio
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programs');
    }
};
