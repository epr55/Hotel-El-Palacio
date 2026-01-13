<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Habitacion;

class HabitacionSeeder extends Seeder
{
    public function run(): void
    {
        $habitaciones = [
            // Categoría 1 - Familiar
            ['numero' => 101, 'categoria_id' => 1, 'capacidad' => 4, 'precio' => 200, 'imagen' => 'https://images.unsplash.com/photo-1611892440504-42a792e24d32?w=400', 'camas' => 4, 'aseos' => 2, 'balcon' => false, 'escritorio' => true, 'cuna' => false],
            ['numero' => 108, 'categoria_id' => 1, 'capacidad' => 4, 'precio' => 155, 'imagen' => 'https://images.unsplash.com/photo-1618773928121-c32242e63f39?w=400', 'camas' => 2, 'aseos' => 2, 'balcon' => false, 'escritorio' => false, 'cuna' => false],
            ['numero' => 205, 'categoria_id' => 1, 'capacidad' => 4, 'precio' => 185, 'imagen' => 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?w=400', 'camas' => 3, 'aseos' => 2, 'balcon' => false, 'escritorio' => true, 'cuna' => false],
            ['numero' => 212, 'categoria_id' => 1, 'capacidad' => 4, 'precio' => 170, 'imagen' => 'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=400', 'camas' => 3, 'aseos' => 2, 'balcon' => true, 'escritorio' => true, 'cuna' => false],
            ['numero' => 306, 'categoria_id' => 1, 'capacidad' => 4, 'precio' => 140, 'imagen' => 'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=400', 'camas' => 2, 'aseos' => 2, 'balcon' => false, 'escritorio' => true, 'cuna' => false],
            
            // Categoría 2 - Triple Estándar
            ['numero' => 203, 'categoria_id' => 2, 'capacidad' => 3, 'precio' => 140, 'imagen' => 'https://images.unsplash.com/photo-1611892440504-42a792e24d32?w=400', 'camas' => 2, 'aseos' => 2, 'balcon' => true, 'escritorio' => true, 'cuna' => false],
            ['numero' => 210, 'categoria_id' => 2, 'capacidad' => 3, 'precio' => 120, 'imagen' => 'https://images.unsplash.com/photo-1596394516093-501ba68a0ba6?w=400', 'camas' => 2, 'aseos' => 2, 'balcon' => true, 'escritorio' => true, 'cuna' => true],
            ['numero' => 213, 'categoria_id' => 2, 'capacidad' => 3, 'precio' => 100, 'imagen' => 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?w=400', 'camas' => 2, 'aseos' => 2, 'balcon' => false, 'escritorio' => true, 'cuna' => false],
            ['numero' => 309, 'categoria_id' => 2, 'capacidad' => 3, 'precio' => 130, 'imagen' => 'https://images.unsplash.com/photo-1611892440504-42a792e24d32?w=400', 'camas' => 2, 'aseos' => 2, 'balcon' => true, 'escritorio' => true, 'cuna' => true],
            ['numero' => 313, 'categoria_id' => 2, 'capacidad' => 3, 'precio' => 110, 'imagen' => 'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=400', 'camas' => 2, 'aseos' => 2, 'balcon' => false, 'escritorio' => true, 'cuna' => false],
            
            // Categoría 3 - Triple Confort
            ['numero' => 112, 'categoria_id' => 3, 'capacidad' => 3, 'precio' => 150, 'imagen' => 'https://images.unsplash.com/photo-1618773928121-c32242e63f39?w=400', 'camas' => 2, 'aseos' => 2, 'balcon' => true, 'escritorio' => true, 'cuna' => true],
            ['numero' => 115, 'categoria_id' => 3, 'capacidad' => 3, 'precio' => 190, 'imagen' => 'https://images.unsplash.com/photo-1618773928121-c32242e63f39?w=400', 'camas' => 2, 'aseos' => 2, 'balcon' => false, 'escritorio' => false, 'cuna' => false],
            ['numero' => 215, 'categoria_id' => 3, 'capacidad' => 3, 'precio' => 170, 'imagen' => 'https://images.unsplash.com/photo-1566665797739-1674de7a421a?w=400', 'camas' => 2, 'aseos' => 2, 'balcon' => true, 'escritorio' => true, 'cuna' => true],
            ['numero' => 301, 'categoria_id' => 3, 'capacidad' => 3, 'precio' => 180, 'imagen' => 'https://images.unsplash.com/photo-1611892440504-42a792e24d32?w=400', 'camas' => 2, 'aseos' => 2, 'balcon' => false, 'escritorio' => true, 'cuna' => true],
            ['numero' => 308, 'categoria_id' => 3, 'capacidad' => 3, 'precio' => 160, 'imagen' => 'https://images.unsplash.com/photo-1578683010236-d716f9a3f461?w=400', 'camas' => 2, 'aseos' => 2, 'balcon' => true, 'escritorio' => true, 'cuna' => true],
            
            // Categoría 4 - Suite Familiar
            ['numero' => 106, 'categoria_id' => 4, 'capacidad' => 6, 'precio' => 218, 'imagen' => 'https://images.unsplash.com/photo-1590490360182-c33d57733427?w=400', 'camas' => 3, 'aseos' => 2, 'balcon' => true, 'escritorio' => true, 'cuna' => false],
            ['numero' => 109, 'categoria_id' => 4, 'capacidad' => 6, 'precio' => 264, 'imagen' => 'https://images.unsplash.com/photo-1618773928121-c32242e63f39?w=400', 'camas' => 3, 'aseos' => 2, 'balcon' => false, 'escritorio' => false, 'cuna' => false],
            ['numero' => 202, 'categoria_id' => 4, 'capacidad' => 6, 'precio' => 295, 'imagen' => 'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=400', 'camas' => 3, 'aseos' => 2, 'balcon' => false, 'escritorio' => true, 'cuna' => true],
            ['numero' => 206, 'categoria_id' => 4, 'capacidad' => 6, 'precio' => 260, 'imagen' => 'https://images.unsplash.com/photo-1596394516093-501ba68a0ba6?w=400', 'camas' => 3, 'aseos' => 2, 'balcon' => true, 'escritorio' => true, 'cuna' => true],
            ['numero' => 315, 'categoria_id' => 4, 'capacidad' => 6, 'precio' => 289, 'imagen' => 'https://images.unsplash.com/photo-1611892440504-42a792e24d32?w=400', 'camas' => 3, 'aseos' => 2, 'balcon' => true, 'escritorio' => false, 'cuna' => false],
            
            // Categoría 5 - Triple Premium
            ['numero' => 103, 'categoria_id' => 5, 'capacidad' => 3, 'precio' => 200, 'imagen' => 'https://images.unsplash.com/photo-1618773928121-c32242e63f39?w=400', 'camas' => 2, 'aseos' => 2, 'balcon' => false, 'escritorio' => true, 'cuna' => false],
            ['numero' => 104, 'categoria_id' => 5, 'capacidad' => 3, 'precio' => 220, 'imagen' => 'https://images.unsplash.com/photo-1611892440504-42a792e24d32?w=400', 'camas' => 2, 'aseos' => 2, 'balcon' => true, 'escritorio' => true, 'cuna' => false],
            ['numero' => 107, 'categoria_id' => 5, 'capacidad' => 3, 'precio' => 230, 'imagen' => 'https://images.unsplash.com/photo-1566665797739-1674de7a421a?w=400', 'camas' => 2, 'aseos' => 2, 'balcon' => true, 'escritorio' => false, 'cuna' => false],
            ['numero' => 204, 'categoria_id' => 5, 'capacidad' => 3, 'precio' => 210, 'imagen' => 'https://images.unsplash.com/photo-1566665797739-1674de7a421a?w=400', 'camas' => 2, 'aseos' => 2, 'balcon' => true, 'escritorio' => true, 'cuna' => false],
            ['numero' => 207, 'categoria_id' => 5, 'capacidad' => 3, 'precio' => 240, 'imagen' => 'https://images.unsplash.com/photo-1590490360182-c33d57733427?w=400', 'camas' => 2, 'aseos' => 2, 'balcon' => true, 'escritorio' => false, 'cuna' => false],
            
            // Categoría 6 - Individual
            ['numero' => 401, 'categoria_id' => 6, 'capacidad' => 1, 'precio' => 59, 'imagen' => 'https://images.unsplash.com/photo-1618773928121-c32242e63f39?w=400', 'camas' => 1, 'aseos' => 1, 'balcon' => true, 'escritorio' => false, 'cuna' => false],
            ['numero' => 402, 'categoria_id' => 6, 'capacidad' => 1, 'precio' => 78, 'imagen' => 'https://images.unsplash.com/photo-1578683010236-d716f9a3f461?w=400', 'camas' => 1, 'aseos' => 1, 'balcon' => true, 'escritorio' => true, 'cuna' => false],
            ['numero' => 403, 'categoria_id' => 6, 'capacidad' => 1, 'precio' => 60, 'imagen' => 'https://images.unsplash.com/photo-1596394516093-501ba68a0ba6?w=400', 'camas' => 1, 'aseos' => 1, 'balcon' => true, 'escritorio' => true, 'cuna' => false],
            ['numero' => 404, 'categoria_id' => 6, 'capacidad' => 1, 'precio' => 72, 'imagen' => 'https://images.unsplash.com/photo-1578683010236-d716f9a3f461?w=400', 'camas' => 1, 'aseos' => 1, 'balcon' => true, 'escritorio' => false, 'cuna' => false],
            ['numero' => 405, 'categoria_id' => 6, 'capacidad' => 1, 'precio' => 50, 'imagen' => 'https://images.unsplash.com/photo-1618773928121-c32242e63f39?w=400', 'camas' => 1, 'aseos' => 1, 'balcon' => true, 'escritorio' => true, 'cuna' => false],
            
            // Categoría 7 - Doble
            ['numero' => 501, 'categoria_id' => 7, 'capacidad' => 2, 'precio' => 97, 'imagen' => 'https://images.unsplash.com/photo-1618773928121-c32242e63f39?w=400', 'camas' => 1, 'aseos' => 1, 'balcon' => true, 'escritorio' => true, 'cuna' => true],
            ['numero' => 502, 'categoria_id' => 7, 'capacidad' => 2, 'precio' => 99, 'imagen' => 'https://images.unsplash.com/photo-1618773928121-c32242e63f39?w=400', 'camas' => 2, 'aseos' => 1, 'balcon' => true, 'escritorio' => false, 'cuna' => false],
            ['numero' => 503, 'categoria_id' => 7, 'capacidad' => 2, 'precio' => 99, 'imagen' => 'https://images.unsplash.com/photo-1618773928121-c32242e63f39?w=400', 'camas' => 1, 'aseos' => 1, 'balcon' => false, 'escritorio' => true, 'cuna' => true],
            ['numero' => 504, 'categoria_id' => 7, 'capacidad' => 2, 'precio' => 113, 'imagen' => 'https://images.unsplash.com/photo-1590490360182-c33d57733427?w=400', 'camas' => 2, 'aseos' => 1, 'balcon' => true, 'escritorio' => true, 'cuna' => true],
            ['numero' => 505, 'categoria_id' => 7, 'capacidad' => 2, 'precio' => 93, 'imagen' => 'https://images.unsplash.com/photo-1618773928121-c32242e63f39?w=400', 'camas' => 1, 'aseos' => 1, 'balcon' => true, 'escritorio' => true, 'cuna' => false],
            
            // Categoría 8 - Familiar Grande
            ['numero' => 601, 'categoria_id' => 8, 'capacidad' => 5, 'precio' => 205, 'imagen' => 'https://images.unsplash.com/photo-1618773928121-c32242e63f39?w=400', 'camas' => 3, 'aseos' => 2, 'balcon' => true, 'escritorio' => false, 'cuna' => false],
            ['numero' => 602, 'categoria_id' => 8, 'capacidad' => 5, 'precio' => 240, 'imagen' => 'https://images.unsplash.com/photo-1618773928121-c32242e63f39?w=400', 'camas' => 3, 'aseos' => 2, 'balcon' => true, 'escritorio' => true, 'cuna' => false],
            ['numero' => 603, 'categoria_id' => 8, 'capacidad' => 5, 'precio' => 220, 'imagen' => 'https://images.unsplash.com/photo-1611892440504-42a792e24d32?w=400', 'camas' => 3, 'aseos' => 2, 'balcon' => false, 'escritorio' => true, 'cuna' => false],
            ['numero' => 604, 'categoria_id' => 8, 'capacidad' => 5, 'precio' => 193, 'imagen' => 'https://images.unsplash.com/photo-1590490360182-c33d57733427?w=400', 'camas' => 3, 'aseos' => 2, 'balcon' => false, 'escritorio' => false, 'cuna' => false],
            ['numero' => 605, 'categoria_id' => 8, 'capacidad' => 5, 'precio' => 227, 'imagen' => 'https://images.unsplash.com/photo-1578683010236-d716f9a3f461?w=400', 'camas' => 3, 'aseos' => 2, 'balcon' => true, 'escritorio' => true, 'cuna' => false],
        ];

        foreach ($habitaciones as $habitacion) {
            Habitacion::create($habitacion);
        }
    }
}
