<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Habitacion; // Asegúrate de que el nombre del modelo sea este

class BusquedaController extends Controller
{
   public function index(Request $request)
    {
        $checkin = $request->input('checkin');
        $checkout = $request->input('checkout');
        $huespedes = $request->input('huespedes');

        $habitaciones = Habitacion::with('categoria')
            ->whereHas('categoria', function($q) use ($huespedes) {
                $q->where('capacidad', $huespedes); 
            })
            ->whereDoesntHave('reservas', function($q) use ($checkin, $checkout) {
                $q->where('fecha_inicio', '<', $checkout)
                ->where('fecha_final', '>', $checkin);
            })
            ->orderBy('precio', 'asc')
            ->get();

        return view('busqueda', compact('habitaciones', 'checkin', 'checkout', 'huespedes'));
    }
}