<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            CategoriaSeeder::class,
            TemporadaSeeder::class,
            ServicioSeeder::class,
            HabitacionSeeder::class,
            MantenimientoSeeder::class,
            ComentarioSeeder::class,
            ReservaSeeder::class,
            ReservaServicioSeeder::class,
        ]);
    }
}
