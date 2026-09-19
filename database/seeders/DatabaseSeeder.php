<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crear usuario sin usar factory() para evitar error de Faker en producción
        User::updateOrCreate(
            ['email' => 'admin@empowerme.mx'],
            [
                'name' => 'Admin',
                'password' => \Illuminate\Support\Facades\Hash::make('password'), // la contraseña será 'password'
                'email_verified_at' => now(),
                'is_admin' => true,
            ]
        );

        $this->call([
            ProgramSeeder::class,
        ]);
    }
}
