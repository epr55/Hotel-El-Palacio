<?php

namespace Database\Factories;

use App\Models\Servicio;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServicioFactory extends Factory
{
    protected $model = Servicio::class;

    public function definition(): array
    {
        return [
            'nombre' => $this->faker->unique()->word(),
            'precio' => $this->faker->numberBetween(5, 100),
            'descripcion' => $this->faker->sentence(),
        ];
    }
}
