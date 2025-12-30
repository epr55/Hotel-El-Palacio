<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'correo' => $this->faker->unique()->safeEmail(),
            'telefono' => $this->faker->optional()->phoneNumber(),
            'password' => Hash::make('password'),
            'admin' => false,
            'recepcionista' => false,
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Usuario administrador
     */
    public function admin(): static
    {
        return $this->state(fn () => [
            'admin' => true,
            'recepcionista' => false,
        ]);
    }

    /**
     * Usuario recepcionista
     */
    public function recepcionista(): static
    {
        return $this->state(fn () => [
            'admin' => false,
            'recepcionista' => true,
        ]);
    }
}
