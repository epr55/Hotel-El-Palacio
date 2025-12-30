<?php

namespace Database\Factories;

use App\Models\Mantenimiento;
use App\Models\Habitacion;
use Illuminate\Database\Eloquent\Factories\Factory;

class MantenimientoFactory extends Factory
{
    protected $model = Mantenimiento::class;

    public function definition(): array
    {
        $inicio = $this->faker->dateTimeBetween('-1 month', '+1 month');
        $final = (clone $inicio)->modify('+'.rand(1,7).' days');

        return [
            'fecha_inicio' => $inicio,
            'fecha_final' => $final,
            'motivo' => $this->faker->sentence(),
            'habitacion_id' => Habitacion::inRandomOrder()->first()->id,
        ];
    }
}
