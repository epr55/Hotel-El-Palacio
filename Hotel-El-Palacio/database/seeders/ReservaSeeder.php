<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reserva;
use App\Models\User;
use App\Models\Habitacion;
use App\Models\Temporada;

class ReservaSeeder extends Seeder
{
    public function run(): void
    {
        $usuarios = User::all();
        $habitaciones = Habitacion::all();
        $temporadas = Temporada::all();

        Reserva::factory()->count(30)->create([
            'user_id' => $usuarios->random()->id,
            'habitacion_id' => $habitaciones->random()->id,
            'temporada_id' => $temporadas->random()->id,
        ]);
    }
}
