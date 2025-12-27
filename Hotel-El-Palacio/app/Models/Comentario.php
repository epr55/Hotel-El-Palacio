<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    protected $table = 'comentarios';

    protected $fillable = [
        'valoracion','descripcion','fecha','usuario_id','habitacion_id'
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }

    public function habitacion()
    {
        return $this->belongsTo(Habitacion::class);
    }
}
