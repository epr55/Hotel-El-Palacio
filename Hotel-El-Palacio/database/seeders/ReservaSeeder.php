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
        Reserva::factory()->count(30)->create([]);
    }
}
