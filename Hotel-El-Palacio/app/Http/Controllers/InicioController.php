<?php

namespace App\Http\Controllers;

use App\Models\Comentario;
use App\Models\Habitacion;
use App\Models\Reserva;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class InicioController extends Controller
{
    public function home()
    {
        if (!Auth::check()) {
            return view('inicio');
        }

        $user = Auth::user();

        if ($user->admin) {
            return view('admin.inicio_admin');
        }

        else if ($user->recepcionista) {
            return view('recepcionista.inicio_recepcionista');
        }

        return view('inicio');
    }

    public function tablaUsuarios()
    {
        $users = User::orderBy('id')->paginate(10);

        return view('admin.tabla_usuario', compact('users'));
    }

    public function tablaReservas()
    {
        $reservas = Reserva::orderBy('id')->paginate(10);

        return view('admin.tabla_reserva', compact('reservas'));
    }

    public function tablaComentarios()
    {
        $comentarios = Comentario::with('usuario')->orderBy('id')->paginate(10);

        return view('admin.tabla_comentario', compact('comentarios'));
    }

    public function tablaHabitaciones()
    {
        $habitaciones = Habitacion::with('categoria')->orderBy('id')->paginate(10);
        return view('admin.tabla_habitacion', compact('habitaciones'));
    }
}
