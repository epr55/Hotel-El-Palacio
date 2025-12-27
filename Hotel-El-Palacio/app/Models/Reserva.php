<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    protected $table = 'reservas';

    protected $fillable = [
        'fecha_inicio','fecha_final','precio_total',
        'usuario_id','habitacion_id','temporada_id'
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }

    public function habitacion()
    {
        return $this->belongsTo(Habitacion::class);
    }

    public function temporada()
    {
        return $this->belongsTo(Temporada::class);
    }

    public function servicios()
    {
        return $this->belongsToMany(Servicio::class, 'reserva_servicio');
    }
}
