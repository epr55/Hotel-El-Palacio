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
            $seleccionados = $servicios->random(rand(1, 3));

            $datosPivot = $seleccionados->mapWithKeys(function ($servicio) {
                return [$servicio->id => ['cantidad_personas' => 2]];
            });

            $reserva->servicios()->attach($datosPivot->toArray());
        });
    }
}
