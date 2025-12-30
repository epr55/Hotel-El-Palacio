<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reserva extends Model
{
    use HasFactory;
    protected $table = "reservas";
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = ['id','estado','fecha_inicio','fecha_final','precio_total','user_id','habitacion_id','temporada_id'];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function habitacion()
    {
        return $this->belongsTo(Habitacion::class, 'habitacion_id', 'id');
    }

    public function temporada()
    {
        return $this->belongsTo(Temporada::class, 'temporada_id', 'id');
    }

    public function servicios()
    {
        return $this->belongsToMany(Servicio::class, 'servicios_reservados', 'reserva_id', 'servicio_id');
    }

}
