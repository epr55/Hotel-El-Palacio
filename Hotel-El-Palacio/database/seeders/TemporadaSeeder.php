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
                'fecha_inicio' => '2000-01-07',
                'fecha_final'  => '2000-03-31',
                'multiplicador' => 0.8
            ],
            [
                'nombre' => 'Temporada Media',
                'fecha_inicio' => '2000-04-01',
                'fecha_final'  => '2000-06-30',
                'multiplicador' => 1.0
            ],
            [
                'nombre' => 'Temporada Alta',
                'fecha_inicio' => '2000-07-01',
                'fecha_final'  => '2000-09-15',
                'multiplicador' => 1.3
            ],
            [
                'nombre' => 'Temporada Halloween',
                'fecha_inicio' => '2000-10-25',
                'fecha_final'  => '2000-11-02',
                'multiplicador' => 1.1
            ],
            [
                'nombre' => 'Temporada Media Otoño',
                'fecha_inicio' => '2000-09-16',
                'fecha_final'  => '2000-10-24',
                'multiplicador' => 1.0
            ],
            [
                'nombre' => 'Temporada Navidad',
                'fecha_inicio' => '2000-12-20',
                'fecha_final'  => '2000-01-06',
                'multiplicador' => 1.2
            ],
            [
                'nombre' => 'Temporada Baja Invierno',
                'fecha_inicio' => '2000-01-07',
                'fecha_final'  => '2000-02-15',
                'multiplicador' => 0.8
            ],
        ]);
    }
}

