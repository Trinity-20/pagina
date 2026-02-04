<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Usuario administrador
        User::create([
            'name' => 'Administrador',
            'email' => 'Joypuppi@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('Perezjoyce29'), // Cambia esta contraseña
            'remember_token' => \Illuminate\Support\Str::random(10),
        ]);

        // Usuario de prueba
        // User::create([
        //     'name' => 'Usuario de Prueba',
        //     'email' => 'test@example.com',
        //     'email_verified_at' => now(),
        //     'password' => Hash::make('test123'), // Cambia esta contraseña
        //     'remember_token' => \Illuminate\Support\Str::random(10),
        // ]);

        // // Usuario invitado
        // User::create([
        //     'name' => 'Invitado',
        //     'email' => 'guest@example.com',
        //     'email_verified_at' => null,
        //     'password' => Hash::make('guest123'), // Cambia esta contraseña
        //     'remember_token' => \Illuminate\Support\Str::random(10),
        // ]);

        // Usuarios adicionales (opcional)
        $this->createAdditionalUsers();
    }

    private function createAdditionalUsers(): void
    {
        $users = [
            [
                'name' => 'Juan Pérez',
                'email' => 'juan.perez@example.com',
                'password' => 'juan123',
            ],
            [
                'name' => 'María García',
                'email' => 'maria.garcia@example.com',
                'password' => 'maria123',
            ],
            [
                'name' => 'Carlos López',
                'email' => 'carlos.lopez@example.com',
                'password' => 'carlos123',
            ],
            [
                'name' => 'Ana Martínez',
                'email' => 'ana.martinez@example.com',
                'password' => 'ana123',
            ],
            [
                'name' => 'Pedro Sánchez',
                'email' => 'pedro.sanchez@example.com',
                'password' => 'pedro123',
            ],
        ];

        foreach ($users as $user) {
            User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'email_verified_at' => now(),
                'password' => Hash::make($user['password']),
                'remember_token' => \Illuminate\Support\Str::random(10),
            ]);
        }
    }
}