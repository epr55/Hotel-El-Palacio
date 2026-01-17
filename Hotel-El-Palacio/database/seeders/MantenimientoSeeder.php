<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Mantenimiento;
use App\Models\Habitacion;

class MantenimientoSeeder extends Seeder
{
    public function run(): void
    {
        Mantenimiento::factory()->count(15)->create([]);
    }
}
