<?php

namespace App\Http\Controllers;

use App\Models\Comentario;
use App\Models\Reserva;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComentarioController extends Controller
{
    public function crear(Request $request)
    {
        // Verificar que el usuario tenga al menos una reserva confirmada o finalizada
        $tieneReservaConfirmada = Reserva::where('user_id', Auth::id())
            ->whereIn('estado', ['confirmada', 'finalizada'])
            ->exists();
        
        if (!$tieneReservaConfirmada) {
            return redirect()->route('opiniones.todas')
                ->with('error', 'Debes tener una reserva confirmada para dejar una opinión.');
        }
        
        // Si viene de una reserva específica, pasarla a la vista
        $reserva_id = $request->query('reserva_id');
        
        return view('crear-opinion', compact('reserva_id'));
    }
    
    public function guardar(Request $request)
    {
        // Validar que el usuario tenga reservas confirmadas
        $tieneReservaConfirmada = Reserva::where('user_id', Auth::id())
            ->whereIn('estado', ['confirmada', 'finalizada'])
            ->exists();
        
        if (!$tieneReservaConfirmada) {
            return redirect()->route('opiniones.todas')
                ->with('error', 'Debes tener una reserva confirmada para dejar una opinión.');
        }
        
        // Validar los datos
        $request->validate([
            'valoracion' => 'required|integer|min:1|max:5',
            'descripcion' => 'required|string|min:10|max:500'
        ], [
            'valoracion.required' => 'Debes seleccionar una valoración.',
            'valoracion.min' => 'La valoración debe ser al menos 1 estrella.',
            'valoracion.max' => 'La valoración no puede ser mayor a 5 estrellas.',
            'descripcion.required' => 'Debes escribir un comentario.',
            'descripcion.min' => 'El comentario debe tener al menos 10 caracteres.',
            'descripcion.max' => 'El comentario no puede exceder 500 caracteres.'
        ]);
        
        // Crear el comentario
        Comentario::create([
            'valoracion' => $request->input('valoracion'),
            'descripcion' => $request->input('descripcion'),
            'fecha' => now(),
            'user_id' => Auth::id()
        ]);
        
        return redirect()->route('opiniones.todas')
            ->with('success', '¡Gracias por tu opinión! Tu comentario ha sido publicado.');
    }
}
