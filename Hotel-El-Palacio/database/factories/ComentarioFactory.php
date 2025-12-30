<?php

namespace Database\Factories;

use App\Models\Comentario;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ComentarioFactory extends Factory
{
    protected $model = Comentario::class;

    public function definition(): array
    {
        return [
            'valoracion' => $this->faker->numberBetween(1, 5),
            'descripcion' => $this->faker->paragraph(),
            'fecha' => $this->faker->date(),
            'user_id' => User::inRandomOrder()->first()->id,
        ];
    }
}
