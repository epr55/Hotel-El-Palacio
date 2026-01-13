<?php

namespace App\Http\Controllers;

use App\Models\Habitacion;
use App\Models\Servicio;
use Illuminate\Http\Request;

class ReservaController extends Controller
{
    public function completar(Request $request, $habitacionId)
    {
        // Obtener la habitación con su categoría
        $habitacion = Habitacion::with('categoria')->findOrFail($habitacionId);
        
        // Obtener todos los servicios disponibles
        $servicios = Servicio::all();
        
        // Obtener datos de la búsqueda (fechas, huéspedes)
        $checkin = $request->query('checkin');
        $checkout = $request->query('checkout');
        $huespedes = $request->query('huespedes', 2);
        
        // Calcular número de noches
        $checkinDate = \Carbon\Carbon::parse($checkin);
        $checkoutDate = \Carbon\Carbon::parse($checkout);
        $noches = $checkinDate->diffInDays($checkoutDate);
        
        // Calcular precio base
        $precioBase = $habitacion->precio * $noches;
        
        return view('completar-reserva', compact(
            'habitacion',
            'servicios',
            'checkin',
            'checkout',
            'huespedes',
            'noches',
            'precioBase'
        ));
    }
}
