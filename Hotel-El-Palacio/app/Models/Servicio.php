<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    protected $table = 'servicios';

    protected $fillable = ['nombre','precio','descripcion'];

    public function reservas()
    {
        return $this->belongsToMany(Reserva::class, 'reserva_servicio');
    }
}
