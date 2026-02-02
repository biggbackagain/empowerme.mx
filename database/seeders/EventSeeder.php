<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event; // Importante para que encuentre el Modelo
use Carbon\Carbon;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        // Evento 1
        Event::create([
            'title' => 'Social Run: Amanecer',
            'description' => 'Únete a nuestra carrera matutina de 5km. Ritmo suave, todos son bienvenidos. Trae hidratación.',
            'start_date' => Carbon::now()->addDays(3)->setTime(7, 0),
            'location' => 'Entrada Principal del Parque',
            'capacity' => 30,
            'image_url' => 'https://images.unsplash.com/photo-1452626038306-9aae5e071dd3?auto=format&fit=crop&w=800&q=80',
        ]);

        // Evento 2
        Event::create([
            'title' => 'Yoga & Mindfulness',
            'description' => 'Una sesión para conectar mente y cuerpo. Ideal para principiantes que buscan reducir estrés.',
            'start_date' => Carbon::now()->addDays(7)->setTime(18, 30),
            'location' => 'Estudio EmpowerMe',
            'capacity' => 15,
            'image_url' => 'https://images.unsplash.com/photo-1599901860904-17e6ed7083a0?auto=format&fit=crop&w=800&q=80',
        ]);
        
        // Evento 3
        Event::create([
            'title' => 'Taller de Nutrición Deportiva',
            'description' => 'Aprende qué comer antes y después de entrenar para maximizar tu rendimiento.',
            'start_date' => Carbon::now()->addDays(10)->setTime(10, 0),
            'location' => 'Zoom (Online)',
            'capacity' => 100,
            'image_url' => 'https://images.unsplash.com/photo-1490645935967-10de6ba17061?auto=format&fit=crop&w=800&q=80',
        ]);
    }
}