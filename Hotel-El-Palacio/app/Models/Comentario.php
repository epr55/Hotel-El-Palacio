<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comentario extends Model
{
    use HasFactory;
    protected $table = "comentarios";
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = ['id','valoracion','descripcion','fecha','user_id'];

    public function usuario()
    {
        return $this->belongsTo(User::class,'user_id', 'id');
    }
}
