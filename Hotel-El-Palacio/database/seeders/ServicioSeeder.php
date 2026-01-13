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
                'descripcion' => 'Desayuno variado tipo buffet con opciones calientes y frías servido cada mañana.',
                'precio' => 15,
                'tipo_cobro' => 'por_persona_noche',
            ],
            [
                'nombre' => 'Parking privado',
                'descripcion' => 'Plaza de aparcamiento privada en el hotel con acceso cómodo y seguro durante la estancia.',
                'precio' => 10,
                'tipo_cobro' => 'por_noche',
            ],
            [
                'nombre' => 'Acceso al Spa',
                'descripcion' => 'Acceso a la zona wellness con piscina climatizada, sauna y circuito de relajación.',
                'precio' => 25,
                'tipo_cobro' => 'personalizable_por_persona',
            ],
            [
                'nombre' => 'Traslado al aeropuerto',
                'descripcion' => 'Servicio de traslado privado de ida y vuelta entre el hotel y el aeropuerto.',
                'precio' => 70,
                'tipo_cobro' => 'unico',
            ],
            [
                'nombre' => 'Late check-out',
                'descripcion' => 'Salida tardía de la habitación hasta las 15:00, sujeta a disponibilidad.',
                'precio' => 20,
                'tipo_cobro' => 'unico',
            ],
        ];

        foreach ($servicios as $servicio) {
            Servicio::create($servicio);
        }
    }
}

