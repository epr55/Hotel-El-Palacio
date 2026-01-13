<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categoria;

class CategoriaSeeder extends Seeder
{
    public function run(): void
    {
        Categoria::insert([
            [
                'nombre' => 'Individual',
                'capacidad' => 1,
                'descripcion' => 'Habitación individual ideal para viajes de negocios.',
            ],
            [
                'nombre' => 'Doble',
                'capacidad' => 2,
                'descripcion' => 'Habitación doble estándar.',
            ],
            [
                'nombre' => 'Doble Superior',
                'capacidad' => 2,
                'descripcion' => 'Habitación doble con mejores prestaciones.',
            ],
            [
                'nombre' => 'Familiar',
                'capacidad' => 4,
                'descripcion' => 'Habitación amplia para familias.',
            ],
            [
                'nombre' => 'Suite',
                'capacidad' => 2,
                'descripcion' => 'Suite de lujo con servicios premium.',
            ],
            [
                'nombre' => 'Triple',
                'capacidad' => 3,
                'descripcion' => 'Habitación para tres personas, ideal para grupos pequeños.',
            ],
            [
                'nombre' => 'Familiar Plus',
                'capacidad' => 5,
                'descripcion' => 'Habitación amplia para familias numerosas.',
            ],
        ]);
    }
}
