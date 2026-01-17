<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reserva;
use App\Models\Habitacion;

class ReservaSeeder extends Seeder
{
    public function run(): void
    {
        $reservas = Reserva::factory()->count(30)->create();

        foreach ($reservas as $reserva) {
            Habitacion::where('id', $reserva->habitacion_id)->update([
                'estado' => 'ocupada'
            ]);
        }
    }
}