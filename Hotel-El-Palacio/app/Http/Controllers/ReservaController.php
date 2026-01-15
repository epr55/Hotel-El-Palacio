<?php

namespace App\Http\Controllers;

use App\Models\Habitacion;
use App\Models\Servicio;
use App\Models\Reserva;
use Illuminate\Http\Request;

class ReservaController extends Controller
{
    public function completar(Request $request, $habitacionId)
    {
        $habitacion = Habitacion::with('categoria')->findOrFail($habitacionId);
        $servicios = Servicio::all();

        $reservaId = $request->query('reserva_id');
        $serviciosContratadosIds = [];
        $cantidadesContratadas = [];

        if ($reservaId) {
            $reservaExistente = Reserva::with('servicios')->find($reservaId);
            
            if ($reservaExistente) {
                $serviciosContratadosIds = $reservaExistente->servicios->pluck('id')->toArray();
                
                $cantidadesContratadas = $reservaExistente->servicios->mapWithKeys(function ($servicio) {
                    return [$servicio->id => $servicio->pivot->cantidad_personas ?? 1];
                })->toArray();

                // Si no hay fechas en la URL, las cargamos de la reserva
                if (!$request->has('checkin')) {
                    $request->merge([
                        'checkin' => $reservaExistente->fecha_inicio,
                        'checkout' => $reservaExistente->fecha_final
                    ]);
                }
            }
        }
        
        $checkin = $request->input('checkin');
        $checkout = $request->input('checkout');
        $huespedes = $request->input('huespedes', 2);
        
        $checkinDate = \Carbon\Carbon::parse($checkin);
        $checkoutDate = \Carbon\Carbon::parse($checkout);
        $noches = (int) $checkinDate->diffInDays($checkoutDate);
        
        $nochesCalculo = $noches > 0 ? $noches : 0;
        $precioBase = $habitacion->precio * $nochesCalculo;
        
        return view('completar-reserva', compact(
            'habitacion',
            'servicios',
            'serviciosContratadosIds',
            'cantidadesContratadas',
            'reservaId',
            'checkin',
            'checkout',
            'huespedes',
            'noches',
            'precioBase'
        ));
    }

    public function cancelar($id)
    {
        // Buscamos la reserva asegurándonos de que sea del usuario actual
        $reserva = Reserva::where('id', $id)
                        ->where('user_id', auth()->id())
                        ->firstOrFail();

        // Cambiamos el estado
        $reserva->update([
            'estado' => 'cancelada'
        ]);

        return back()->with('success', 'Tu reserva ha sido cancelada correctamente.');
    }
}
