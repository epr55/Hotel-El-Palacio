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
                'tipo_cobro' => 'por_persona_noche',
            ],
            [
                'nombre' => 'Parking privado',
                'descripcion' => '/día',
                'precio' => 10,
                'tipo_cobro' => 'por_noche',
            ],
            [
                'nombre' => 'Acceso al Spa',
                'descripcion' => '/sesión',
                'precio' => 25,
                'tipo_cobro' => 'personalizable_por_persona',
            ],
            [
                'nombre' => 'Traslado al aeropuerto',
                'descripcion' => '/total (ida y vuelta)',
                'precio' => 70,
                'tipo_cobro' => 'unico',
            ],
            [
                'nombre' => 'Late check-out',
                'descripcion' => '/reserva',
                'precio' => 20,
                'tipo_cobro' => 'unico',
            ],
        ];

        foreach ($servicios as $servicio) {
            Servicio::create($servicio);
        }
    }
}
