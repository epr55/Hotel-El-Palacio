<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Comentario;
use App\Models\User;
use App\Models\Reserva;
use Carbon\Carbon;

class ComentarioSeeder extends Seeder
{
    public function run(): void
    {
        // Obtener usuarios que NO sean admin ni recepcionista y que tengan reservas confirmadas
        $usuariosConReservas = User::where('admin', false)
            ->where('recepcionista', false)
            ->whereHas('reservas', function($query) {
                $query->whereIn('estado', ['confirmada', 'finalizada']);
            })
            ->get();

        // Si no hay suficientes usuarios con reservas, crear algunas reservas primero
        if ($usuariosConReservas->count() < 8) {
            // Obtener usuarios normales sin reservas
            $usuariosSinReservas = User::where('admin', false)
                ->where('recepcionista', false)
                ->whereDoesntHave('reservas')
                ->take(8 - $usuariosConReservas->count())
                ->get();
            
            foreach ($usuariosSinReservas as $usuario) {
                Reserva::create([
                    'estado' => 'confirmada',
                    'fecha_inicio' => Carbon::now()->subDays(rand(10, 60)),
                    'fecha_final' => Carbon::now()->subDays(rand(5, 50)),
                    'precio_total' => rand(150, 500),
                    'user_id' => $usuario->id,
                    'habitacion_id' => rand(1, 10),
                    'temporada_id' => 1
                ]);
            }
            
            // Recargar usuarios con reservas
            $usuariosConReservas = User::where('admin', false)
                ->where('recepcionista', false)
                ->whereHas('reservas', function($query) {
                    $query->whereIn('estado', ['confirmada', 'finalizada']);
                })
                ->get();
        }

        // Opiniones realistas con diferentes valoraciones
        $opiniones = [
            [
                'valoracion' => 5,
                'descripcion' => 'Excelente servicio y habitaciones muy cómodas. El personal fue extremadamente atento y las instalaciones están impecables. Sin duda volveremos.',
                'dias_atras' => 5
            ],
            [
                'valoracion' => 5,
                'descripcion' => 'Una experiencia inolvidable. La ubicación es perfecta, cerca de todo pero en una zona tranquila. Las habitaciones son espaciosas y muy limpias.',
                'dias_atras' => 12
            ],
            [
                'valoracion' => 4,
                'descripcion' => 'Muy buena estancia en general. El desayuno es variado y delicioso. Solo mejoraría el tiempo de respuesta del servicio de habitaciones.',
                'dias_atras' => 8
            ],
            [
                'valoracion' => 5,
                'descripcion' => 'Hotel elegante y con mucho estilo. El spa es maravilloso y el restaurante tiene una carta exquisita. Personal muy profesional.',
                'dias_atras' => 20
            ],
            [
                'valoracion' => 4,
                'descripcion' => 'Buena relación calidad-precio. Las camas son comodísimas y el wifi funciona perfectamente. Parking amplio y seguro.',
                'dias_atras' => 15
            ],
            [
                'valoracion' => 5,
                'descripcion' => 'Nos encantó todo. Las vistas desde la habitación son espectaculares y el personal hace que te sientas como en casa. Totalmente recomendable.',
                'dias_atras' => 30
            ],
            [
                'valoracion' => 4,
                'descripcion' => 'Estancia muy agradable. La limpieza es impecable y la decoración es moderna y elegante. El gimnasio está bien equipado.',
                'dias_atras' => 18
            ],
            [
                'valoracion' => 5,
                'descripcion' => 'Perfecto para una escapada romántica. La atención al detalle es extraordinaria y los servicios adicionales son de primera calidad.',
                'dias_atras' => 25
            ],
            [
                'valoracion' => 4,
                'descripcion' => 'Hotel con encanto y muy bien situado. El check-in fue rápido y eficiente. La piscina está muy cuidada y es un plus genial.',
                'dias_atras' => 10
            ],
            [
                'valoracion' => 5,
                'descripcion' => 'La mejor opción de la zona sin duda. Habitaciones amplias, baño moderno y una cama increíblemente cómoda. Volveremos seguro.',
                'dias_atras' => 35
            ],
            [
                'valoracion' => 4,
                'descripcion' => 'Muy recomendable. El ambiente es tranquilo y relajante. El personal de recepción muy amable y dispuesto a ayudar en todo momento.',
                'dias_atras' => 22
            ],
            [
                'valoracion' => 5,
                'descripcion' => 'Simplemente perfecto. Desde la llegada hasta la salida todo fue impecable. Las instalaciones son de lujo y el trato es exquisito.',
                'dias_atras' => 40
            ],
            [
                'valoracion' => 4,
                'descripcion' => 'Experiencia muy positiva. La zona común es acogedora y el servicio de conserjería muy útil. Repetiríamos sin dudarlo.',
                'dias_atras' => 28
            ],
            [
                'valoracion' => 5,
                'descripcion' => 'Todo estuvo a la altura de nuestras expectativas. Habitación silenciosa, aire acondicionado perfecto y un servicio impecable.',
                'dias_atras' => 33
            ]
        ];

        // Asignar opiniones a usuarios con reservas confirmadas
        $usuariosDisponibles = $usuariosConReservas->shuffle();
        
        foreach ($opiniones as $index => $opinion) {
            if ($index >= $usuariosDisponibles->count()) {
                break;
            }
            
            $usuario = $usuariosDisponibles[$index];
            
            Comentario::create([
                'valoracion' => $opinion['valoracion'],
                'descripcion' => $opinion['descripcion'],
                'fecha' => Carbon::now()->subDays($opinion['dias_atras']),
                'user_id' => $usuario->id
            ]);
        }
    }
}
