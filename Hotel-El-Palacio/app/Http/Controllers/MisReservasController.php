<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class MisReservasController extends Controller
{
    public function index()
    {
        // todas las reservas del usuario
        $reservas = Auth::user()->reservas()
            ->with(['habitacion.categoria'])
            ->orderBy('fecha_inicio', 'desc')
            ->get();

        return view('mis-reservas', compact('reservas'));
    }
}