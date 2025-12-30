<?php

namespace Database\Factories;

use App\Models\Reserva;
use App\Models\User;
use App\Models\Habitacion;
use App\Models\Temporada;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReservaFactory extends Factory
{
    protected $model = Reserva::class;

    public function definition(): array
    {
        $inicio = $this->faker->dateTimeBetween('-1 month', '+1 month');
        $final = (clone $inicio)->modify('+'.rand(1,7).' days');

        return [
            'estado' => $this->faker->randomElement(['pendiente', 'confirmada', 'cancelada']),
            'fecha_inicio' => $inicio,
            'fecha_final' => $final,
            'precio_total' => $this->faker->numberBetween(100, 1500),
            'user_id' => User::inRandomOrder()->first()->id,
            'habitacion_id' => Habitacion::inRandomOrder()->first()->id,
            'temporada_id' => Temporada::inRandomOrder()->first()->id,
        ];
    }
}
