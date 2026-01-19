<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Temporada extends Model
{
    use HasFactory;
    protected $table = "temporadas";
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = ['id','nombre','multiplicador','fecha_inicio','fecha_final'];

    public function reservas()
    {
        return $this->hasMany(Reserva::class, 'temporadas', 'id');
    }
}
