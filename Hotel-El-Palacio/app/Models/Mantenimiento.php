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

    protected $fillable = [
        'fecha_inicio',
        'fecha_final',
        'motivo',
        'habitacion_id',
        'user_id'
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_final'  => 'date',
    ];

    public function habitacion()
    {
        return $this->belongsTo(Habitacion::class, 'habitacion_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}