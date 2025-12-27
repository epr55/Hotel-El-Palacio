<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{
    protected $table = 'usuarios';

    protected $fillable = [
        'nombre','correo','telefono','password','admin','recepcionista'
    ];

    protected $hidden = ['password'];

    public function reservas()
    {
        return $this->hasMany(Reserva::class);
    }

    public function comentarios()
    {
        return $this->hasMany(Comentario::class);
    }
}
