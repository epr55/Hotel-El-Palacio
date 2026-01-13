<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Categoria extends Model
{
    use HasFactory;
    protected $table = 'categorias';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = ['id','nombre','capacidad','descripcion','camas'];

    public function habitaciones()
    {
        return $this->hasMany(Habitacion::class, 'categorias', 'id');
    }
}
