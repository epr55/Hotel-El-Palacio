<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $password = Hash::make('123456');

        User::factory()->admin()->create([
            'name' => 'Administrador',
            'correo' => 'admin@example.com',
            'password' => $password,
        ]);

        User::factory()->recepcionista()->create([
            'name' => 'Recepcion',
            'correo' => 'recepcion@example.com',
            'password' => $password,
        ]);

        User::factory()->create([
            'name' => 'Usuario',
            'correo' => 'usuario@example.com',
            'password' => $password,
        ]);

        User::factory()->count(10)->create([
            'password' => $password,
        ]);
    }
}