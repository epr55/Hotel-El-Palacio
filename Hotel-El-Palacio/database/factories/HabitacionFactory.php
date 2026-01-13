<?php

namespace Database\Factories;

use App\Models\Habitacion;
use App\Models\Categoria;
use Illuminate\Database\Eloquent\Factories\Factory;

class HabitacionFactory extends Factory
{
    protected $model = Habitacion::class;

    public function definition(): array
    {
        static $numerosDisponibles = null;

        if ($numerosDisponibles === null) {
            $numerosDisponibles = array_merge(
                range(101, 115),
                range(201, 215),
                range(301, 315)
            );

            shuffle($numerosDisponibles);
        }

        return [
            'numero' => array_shift($numerosDisponibles),
            'camas_individual' => $this->faker->numberBetween(1,5),
            'camas_doble' => $this->faker->numberBetween(1,5),
            'precio' => $this->faker->numberBetween(50, 300),
            'aseos' => $this->faker->numberBetween(1, 3),
            'balcon' => $this->faker->boolean(),
            'escritorio' => $this->faker->boolean(),
            'cuna' => $this->faker->boolean(),
            'imagen' => $this->faker->imageUrl(),
            'categoria_id' => Categoria::inRandomOrder()->first()->id,
        ];
    }
}
