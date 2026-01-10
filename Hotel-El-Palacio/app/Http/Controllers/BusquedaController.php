<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BusquedaController extends Controller
{
    public function index(Request $request)
    {
        // 1. Recogemos los datos que vienen del formulario del Home
        $checkin = $request->input('checkin');
        $checkout = $request->input('checkout');
        $huespedes = $request->input('huespedes');

        // 2. Pasamos esos datos a la vista 'busqueda.blade.php'
        return view('busqueda', compact('checkin', 'checkout', 'huespedes'));
    }
}