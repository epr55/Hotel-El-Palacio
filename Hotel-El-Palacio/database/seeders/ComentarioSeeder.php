<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Comentario;
use App\Models\User;

class ComentarioSeeder extends Seeder
{
    public function run(): void
    {
        $usuarios = User::all();

        Comentario::factory()->count(20)->create([]);
    }
}
