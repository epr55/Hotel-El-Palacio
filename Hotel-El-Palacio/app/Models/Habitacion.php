<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Habitacion extends Model
{
    use HasFactory;
    protected $table = "habitaciones";
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = ['id','numero','precio','aseos','balcon','escritorio','cuna','categoria_id','camas'];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id', 'id');
    }

    public function reservas()
    {
        return $this->hasMany(Reserva::class, 'habitacion_id', 'id');
    }

    public function mantenimientos()
    {
        return $this->hasMany(Mantenimiento::class, 'habitacion_id', 'id');
    }
}