<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Habitacion;
use App\Models\Mantenimiento;
use App\Models\Reserva;
use Carbon\Carbon;

class RecepcionistaController extends Controller
{
    public function index() {
        return view('recepcionista.inicio_recepcionista');
    }

    public function disponibles(Request $request)
    {
        $fechaConsulta = $request->input('fecha', now()->format('Y-m-d'));

        $carbonFecha = Carbon::parse($fechaConsulta);
        $fechaAnterior = $carbonFecha->copy()->subDay()->format('Y-m-d');
        $fechaSiguiente = $carbonFecha->copy()->addDay()->format('Y-m-d');

        $habitaciones = Habitacion::with('categoria')->orderBy('numero')->get();

        foreach ($habitaciones as $hab) {
            
            $reservaActiva = Reserva::where('habitacion_id', $hab->id)
                ->where('estado', 'confirmada')
                ->whereDate('fecha_inicio', '<=', $fechaConsulta)
                ->whereDate('fecha_final', '>=', $fechaConsulta)
                ->first();

            $estaReservada = $reservaActiva ? true : false;

            $enMantenimiento = Mantenimiento::where('habitacion_id', $hab->id)
                ->whereDate('fecha_inicio', '<=', $fechaConsulta)
                ->where(function($query) use ($fechaConsulta) {
                    $query->whereNull('fecha_final')
                        ->orWhereDate('fecha_final', '>=', $fechaConsulta);
                })
                ->exists();

            if ($enMantenimiento) {
                $hab->estado_dinamico = 'mantenimiento';
            } elseif ($estaReservada) {
                $hab->estado_dinamico = 'ocupada';
                $hab->reserva_id = $reservaActiva->id;
            } else {
                $hab->estado_dinamico = 'disponible';
            }
        }

        $habitacionesPorPlanta = $habitaciones->groupBy(function($hab) {
            return floor($hab->numero / 100); 
        });

        return view('recepcionista.disponibles', compact(
            'habitacionesPorPlanta', 
            'fechaConsulta', 
            'fechaAnterior', 
            'fechaSiguiente'
        ));
    }

    public function cancelarReserva(Request $request)
    {
        $reserva = Reserva::findOrFail($request->reserva_id);
        $reserva->estado = 'cancelada';
        $reserva->save();

        return back()->with('success', 'Reserva cancelada correctamente.');
    }

    public function bloqueo() {
        $habitaciones = Habitacion::orderBy('numero')->get();

        $mantenimientosActivos = Mantenimiento::with(['habitacion', 'user'])
            ->whereDate('fecha_final', '>=', now()->format('Y-m-d'))
            ->orderBy('fecha_inicio', 'asc')
            ->get();

        return view('recepcionista.bloqueo', compact('habitaciones', 'mantenimientosActivos'));
    }

    public function cambiarEstado(Request $request) {
        $request->validate([
            'habitacion_id' => 'required|exists:habitaciones,id',
            'estado' => 'required|string',
            'fecha_inicio' => 'nullable|date',
            'fecha_final' => 'nullable|date|after_or_equal:fecha_inicio',
        ]);

        $habitacion = Habitacion::findOrFail($request->habitacion_id);
        
        $fechaAccion = $request->input('fecha_inicio', now()->format('Y-m-d'));

        if ($request->estado == 'mantenimiento') {
            $f_inicio = $request->input('fecha_inicio', now()->format('Y-m-d'));
            $f_final = $request->input('fecha_final') ?? $f_inicio;

            Mantenimiento::create([
                'habitacion_id' => $habitacion->id,
                'fecha_inicio'  => $f_inicio,
                'fecha_final'   => $f_final,
                'motivo'        => $request->input('motivo', 'Bloqueo manual desde recepción'),
                'user_id'       => auth()->id(),
            ]);

            $habitacion->estado = 'mantenimiento';
        }
        elseif ($request->estado == 'disponible') {
            Mantenimiento::where('habitacion_id', $habitacion->id)
                ->whereDate('fecha_inicio', '<=', $fechaAccion)
                ->whereDate('fecha_final', '>=', $fechaAccion)
                ->delete(); 

            $habitacion->estado = 'disponible';
        } else {
            $habitacion->estado = $request->estado;
        }

        $habitacion->save();

        return back()->with('success', 'Habitación ' . $habitacion->numero . ' actualizada con éxito.');
    }
}