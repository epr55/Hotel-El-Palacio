<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Mantenimiento;
use App\Models\Habitacion;

class MantenimientoSeeder extends Seeder
{
    public function run(): void
    {
        $mantenimientos = Mantenimiento::factory()->count(15)->create();

        foreach ($mantenimientos as $mantenimiento) {
            
            if (is_null($mantenimiento->fecha_final) || $mantenimiento->fecha_final >= now()->format('Y-m-d')) {
                
                Habitacion::where('id', $mantenimiento->habitacion_id)->update([
                    'estado' => 'mantenimiento'
                ]);
            }
        }
    }
}