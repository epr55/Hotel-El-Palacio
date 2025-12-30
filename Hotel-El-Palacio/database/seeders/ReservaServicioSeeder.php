<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reserva;
use App\Models\Servicio;

class ReservaServicioSeeder extends Seeder
{
    public function run(): void
    {
        $servicios = Servicio::all();

        Reserva::all()->each(function ($reserva) use ($servicios) {
            $reserva->servicios()->attach(
                $servicios->random(rand(1, 3))->pluck('id')->toArray()
            );
        });
    }
}
