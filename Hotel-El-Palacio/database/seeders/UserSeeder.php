<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::factory()->admin()->create([
            'name' => 'Administrador',
            'correo' => 'admin@hotel.com',
        ]);

        // Recepcionista
        User::factory()->recepcionista()->create([
            'name' => 'Recepcion',
            'correo' => 'recepcion@hotel.com',
        ]);

        // Usuarios normales
        User::factory()->count(10)->create();
    }
}
