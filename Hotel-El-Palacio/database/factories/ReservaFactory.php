<?php

namespace Database\Factories;

use App\Models\Reserva;
use App\Models\User;
use App\Models\Habitacion;
use App\Models\Temporada;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class ReservaFactory extends Factory
{
    protected $model = Reserva::class;

    public function definition(): array
    {
        $fechaFaker = $this->faker->dateTimeBetween('-1 month', '+1 month');
        
        $inicio = Carbon::instance($fechaFaker)->startOfDay();
        
        $final = (clone $inicio)->addDays(rand(1, 7));

        return [
            'estado' => $this->faker->randomElement(['pendiente', 'confirmada', 'cancelada']),
            'fecha_inicio' => $inicio->toDateTimeString(),
            'fecha_final' => $final->toDateTimeString(),
            'precio_total' => $this->faker->numberBetween(100, 1500),
            'user_id' => User::inRandomOrder()->first()->id ?? 1,
            'habitacion_id' => Habitacion::inRandomOrder()->first()->id ?? 1,
            'temporada_id' => Temporada::inRandomOrder()->first()->id ?? 1,
        ];
    }
}