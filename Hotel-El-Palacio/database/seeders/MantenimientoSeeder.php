<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Mantenimiento;
use App\Models\Habitacion;

class MantenimientoSeeder extends Seeder
{
    public function run(): void
    {
        $habitaciones = Habitacion::all();

        Mantenimiento::factory()->count(15)->create([
            'habitacion_id' => $habitaciones->random()->id,
        ]);
    }
}
