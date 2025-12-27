<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mantenimiento extends Model
{
    protected $table = 'mantenimientos';

    protected $fillable = [
        'fecha_inicio','fecha_final','motivo','habitacion_id'
    ];

    public function habitacion()
    {
        return $this->belongsTo(Habitacion::class);
    }
}
