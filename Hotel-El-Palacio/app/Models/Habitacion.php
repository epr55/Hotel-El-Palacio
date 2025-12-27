<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Habitacion extends Model
{
    protected $table = 'habitaciones';

    protected $fillable = [
        'numero','precio','aseos','balcon','escritorio','cuna','categoria_id'
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function reservas()
    {
        return $this->hasMany(Reserva::class);
    }

    public function mantenimientos()
    {
        return $this->hasMany(Mantenimiento::class);
    }

    public function comentarios()
    {
        return $this->hasMany(Comentario::class);
    }
}
