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
       Schema::create('events', function (Blueprint $table) {
        $table->id();
        $table->string('title'); // Título: "Social Run 5K"
        $table->text('description'); // Detalles
        $table->dateTime('start_date'); // Fecha y hora
        $table->string('location'); // "Parque Central"
        $table->integer('capacity')->default(50); // Cupo límite
        $table->string('image_url')->nullable(); // Para la foto
        $table->timestamps();
    });

    // 2. Tabla Pivote (Relación: Muchos Usuarios <-> Muchos Eventos)
    Schema::create('event_user', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->foreignId('event_id')->constrained()->onDelete('cascade');
        $table->timestamps(); // Fecha de inscripción

        // Regla: Un usuario no puede registrarse dos veces al mismo evento
        $table->unique(['user_id', 'event_id']);
    });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
