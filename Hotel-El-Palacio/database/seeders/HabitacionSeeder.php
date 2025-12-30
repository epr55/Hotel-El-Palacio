<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Habitacion;
use App\Models\Categoria;

class HabitacionSeeder extends Seeder
{
    public function run(): void
    {
        $categorias = Categoria::all();

        foreach ($categorias as $categoria) {
            Habitacion::factory()
                ->count(5)
                ->create([
                    'categoria_id' => $categoria->id
                ]);
        }
    }
}
