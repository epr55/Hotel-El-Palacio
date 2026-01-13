<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Servicio extends Model
{
    use HasFactory;
    protected $table = 'servicios';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = ['id','nombre','precio','descripcion','tipo_cobro'];

    public function reservas()
    {
        return $this->belongsToMany(Reserva::class, 'servicios_reservados', 'servicio_id', 'reserva_id');
    }
}
