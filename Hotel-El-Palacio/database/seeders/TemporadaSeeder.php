<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Temporada;

class TemporadaSeeder extends Seeder
{
    public function run(): void
    {
        Temporada::insert([
            [
                'nombre' => 'Temporada Baja',
                'fecha_inicio' => '2024-01-01',
                'fecha_final' => '2024-03-31',
                'multiplicador' => 0.8
            ],
            [
                'nombre' => 'Temporada Media',
                'fecha_inicio' => '2024-04-01',
                'fecha_final' => '2024-06-30',
                'multiplicador' => 1.0
            ],
            [
                'nombre' => 'Temporada Alta',
                'fecha_inicio' => '2024-07-01',
                'fecha_final' => '2024-09-15',
                'multiplicador' => 1.3
            ],
            [
                'nombre' => 'Temporada Media',
                'fecha_inicio' => '2024-09-16',
                'fecha_final' => '2024-10-31',
                'multiplicador' => 1.0
            ],
            [
                'nombre' => 'Temporada Baja',
                'fecha_inicio' => '2024-11-01',
                'fecha_final' => '2024-12-31',
                'multiplicador' => 0.8
            ],
        ]);
    }
}
