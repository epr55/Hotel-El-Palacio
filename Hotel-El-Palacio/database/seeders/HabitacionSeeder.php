<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Habitacion;
use App\Models\Categoria;

class HabitacionSeeder extends Seeder
{
    public function run(): void
    {
        $cat = Categoria::all()->keyBy('nombre');

        for ($n = 101; $n <= 105; $n++) {
            Habitacion::create([
                'numero' => $n,
                'camas_individual' => 1,
                'camas_doble' => 0,
                'precio' => 60,
                'aseos' => 1,
                'balcon' => false,
                'escritorio' => true,
                'cuna' => false,
                'imagen' => 'images/individual-1.png',
                'categoria_id' => $cat['Individual']->id,
            ]);
        }

        for ($n = 106; $n <= 110; $n++) {
            Habitacion::create([
                'numero' => $n,
                'camas_individual' => 1,
                'camas_doble' => 0,
                'precio' => 70,
                'aseos' => 1,
                'balcon' => true,
                'escritorio' => true,
                'cuna' => false,
                'imagen' => 'images/individual-2.png',
                'categoria_id' => $cat['Individual']->id,
            ]);
        }

        for ($n = 111; $n <= 115; $n++) {
            Habitacion::create([
                'numero' => $n,
                'camas_individual' => 2,
                'camas_doble' => 0,
                'precio' => 90,
                'aseos' => 1,
                'balcon' => false,
                'escritorio' => true,
                'cuna' => false,
                'imagen' => 'images/doble-1.png',
                'categoria_id' => $cat['Doble']->id,
            ]);
        }

        for ($n = 201; $n <= 210; $n++) {
            Habitacion::create([
                'numero' => $n,
                'camas_individual' => 0,
                'camas_doble' => 1,
                'precio' => 95,
                'aseos' => 1,
                'balcon' => true,
                'escritorio' => true,
                'cuna' => true,
                'imagen' => 'images/doble-2.png',
                'categoria_id' => $cat['Doble']->id,
            ]);
        }

        for ($n = 211; $n <= 215; $n++) {
            Habitacion::create([
                'numero' => $n,
                'camas_individual' => 0,
                'camas_doble' => 1,
                'precio' => 120,
                'aseos' => 1,
                'balcon' => true,
                'escritorio' => true,
                'cuna' => false,
                'imagen' => 'images/doble-3.png',
                'categoria_id' => $cat['Doble Superior']->id,
            ]);
        }

        for ($n = 301; $n <= 304; $n++) {
            Habitacion::create([
                'numero' => $n,
                'camas_individual' => 0,
                'camas_doble' => 1,
                'precio' => 260,
                'aseos' => 2,
                'balcon' => true,
                'escritorio' => true,
                'cuna' => true,
                'imagen' => 'images/suite.png',
                'categoria_id' => $cat['Suite']->id,
            ]);
        }

        for ($n = 305; $n <= 311; $n++) {
            Habitacion::create([
                'numero' => $n,
                'camas_individual' => 2,
                'camas_doble' => 1,
                'precio' => 150,
                'aseos' => 2,
                'balcon' => true,
                'escritorio' => false,
                'cuna' => true,
                'imagen' => 'images/familiar-1.png',
                'categoria_id' => $cat['Familiar']->id,
            ]);
        }

        for ($n = 312; $n <= 315; $n++) {
            Habitacion::create([
                'numero' => $n,
                'camas_individual' => 0,
                'camas_doble' => 1,
                'precio' => 130,
                'aseos' => 1,
                'balcon' => true,
                'escritorio' => true,
                'cuna' => true,
                'imagen' => 'images/doble-4.png',
                'categoria_id' => $cat['Doble Superior']->id,
            ]);
        }

        for ($n = 401; $n <= 405; $n++) {
            Habitacion::create([
                'numero' => $n,
                'camas_individual' => 3,
                'camas_doble' => 0,
                'precio' => 140,
                'aseos' => 1,
                'balcon' => true,
                'escritorio' => true,
                'cuna' => false,
                'imagen' => 'images/triple-1.png',
                'categoria_id' => $cat['Triple']->id,
            ]);
        }

        for ($n = 406; $n <= 407; $n++) {
            Habitacion::create([
                'numero' => $n,
                'camas_individual' => 1,
                'camas_doble' => 1,
                'precio' => 150,
                'aseos' => 1,
                'balcon' => false,
                'escritorio' => false,
                'cuna' => true,
                'imagen' => 'images/triple-2.png',
                'categoria_id' => $cat['Triple']->id,
            ]);
        }

        for ($n = 408; $n <= 409; $n++) {
            Habitacion::create([
                'numero' => $n,
                'camas_individual' => 1,
                'camas_doble' => 1,
                'precio' => 170,
                'aseos' => 2,
                'balcon' => true,
                'escritorio' => false,
                'cuna' => true,
                'imagen' => 'images/triple-2.png',
                'categoria_id' => $cat['Triple']->id,
            ]);
        }

        for ($n = 410; $n <= 415; $n++) {
            Habitacion::create([
                'numero' => $n,
                'camas_individual' => 3,
                'camas_doble' => 1,
                'precio' => 300,
                'aseos' => 2,
                'balcon' => true,
                'escritorio' => false,
                'cuna' => true,
                'imagen' => 'images/familiar-2.png',
                'categoria_id' => $cat['Familiar Plus']->id,
            ]);
        }
    }
}
