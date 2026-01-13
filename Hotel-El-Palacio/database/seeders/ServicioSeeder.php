<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Servicio;

class ServicioSeeder extends Seeder
{
    public function run(): void
    {
        $servicios = [
            [
                'nombre' => 'Desayuno buffet',
                'descripcion' => '/pers./día',
                'precio' => 15,
            ],
            [
                'nombre' => 'Parking privado',
                'descripcion' => '/día',
                'precio' => 10,
            ],
            [
                'nombre' => 'Acceso al Spa',
                'descripcion' => '/sesión/pers.',
                'precio' => 25,
            ],
            [
                'nombre' => 'Traslado al aeropuerto',
                'descripcion' => '/total (ida y vuelta)',
                'precio' => 70,
            ],
            [
                'nombre' => 'Late check-out',
                'descripcion' => '/reserva',
                'precio' => 20,
            ],
        ];

        foreach ($servicios as $servicio) {
            Servicio::create($servicio);
        }
    }
}
