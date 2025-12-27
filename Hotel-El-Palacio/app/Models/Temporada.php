<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Temporada extends Model
{
    protected $table = 'temporadas';

    protected $fillable = [
        'nombre','multiplicador','fecha_inicio','fecha_final'
    ];

    public function reservas()
    {
        return $this->hasMany(Reserva::class);
    }
}
