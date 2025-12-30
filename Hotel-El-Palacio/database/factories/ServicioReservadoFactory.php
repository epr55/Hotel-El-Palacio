<?php

namespace Database\Factories;

use App\Models\Reserva;
use App\Models\Servicio;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServicioReservaFactory extends Factory
{
    protected $table = 'servicio_reserva';

    public function definition(): array
    {
        return [
            'reserva_id' => Reserva::inRandomOrder()->first()->id,
            'servicio_id' => Servicio::inRandomOrder()->first()->id,
        ];
    }
}
