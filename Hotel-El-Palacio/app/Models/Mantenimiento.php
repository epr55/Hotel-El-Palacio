<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mantenimiento extends Model
{
    use HasFactory;
    protected $table = 'mantenimientos';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = ['id','fecha_inicio','fecha_final','motivo','habitacion_id'];

    public function habitacion()
    {
        return $this->belongsTo(Habitacion::class, 'habitacion_id', 'id');
    }
}
