<?php

namespace Database\Seeders;

use App\Models\Program;
use Illuminate\Database\Seeder;

class ProgramSeeder extends Seeder
{
    /**
     * Carga los 3 programas de "Move Your Company" con contenido inicial.
     * Liz puede editar título, resumen, qué incluye, precio y foto desde
     * el panel de administración (Administrar Programas) cuando guste.
     */
    public function run(): void
    {
        $programs = [
            [
                'title' => 'Wellness Day',
                'summary' => 'Una experiencia de bienestar diseñada para romper la rutina, activar a tu equipo y fortalecer sus conexiones a través del movimiento.',
                'includes' => "Sesión de activación física guiada por instructores certificados\nDinámicas de conexión e integración de equipo\nEspacio de bienestar mental y emocional\nKit de bienvenida para cada participante\nMemoria fotográfica del evento",
                'price' => 'Cotiza con nosotros',
                'image_url' => '/images/programas/wellness-day.jpg',
                'order' => 1,
            ],
            [
                'title' => 'Empowerme 30',
                'summary' => 'Un programa de 30 días que impulsa hábitos saludables, constancia y comunidad, motivando a cada colaborador a moverse, conectar y descubrir de lo que es capaz.',
                'includes' => "30 días de retos y actividades guiadas\nSeguimiento y acompañamiento del equipo Empowerme\nComunidad de apoyo entre colaboradores\nMedición de resultados y cierre con reconocimiento\nMaterial de seguimiento de hábitos",
                'price' => 'Cotiza con nosotros',
                'image_url' => '/images/programas/empowerme-30.jpg',
                'order' => 2,
            ],
            [
                'title' => 'Team Experience',
                'summary' => 'Una experiencia de integración donde el movimiento y los retos colaborativos se convierten en herramientas para fortalecer la comunicación, la confianza y el trabajo en equipo.',
                'includes' => "Retos colaborativos diseñados para tu equipo\nDinámicas de comunicación y confianza\nFacilitación por coaches de Empowerme\nEspacio y logística adaptados a tu empresa\nCierre con retroalimentación grupal",
                'price' => 'Cotiza con nosotros',
                'image_url' => '/images/programas/team-experience.jpg',
                'order' => 3,
            ],
        ];

        foreach ($programs as $data) {
            Program::updateOrCreate(
                ['slug' => \Illuminate\Support\Str::slug($data['title'])],
                $data
            );
        }
    }
}
