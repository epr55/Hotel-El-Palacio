<?php

namespace Database\Factories;

use App\Models\Temporada;
use Illuminate\Database\Eloquent\Factories\Factory;

class TemporadaFactory extends Factory
{
    protected $model = Temporada::class;

    public function definition(): array
    {
        $inicio = $this->faker->dateTimeBetween('-1 year', 'now');
        $fin = (clone $inicio)->modify('+'.rand(10, 60).' days');

        return [
            'nombre' => $this->faker->word(),
            'multiplicador' => $this->faker->randomFloat(1, 1, 1.5),
            'fecha_inicio' => $inicio,
            'fecha_final' => $fin,
        ];
    }
}
