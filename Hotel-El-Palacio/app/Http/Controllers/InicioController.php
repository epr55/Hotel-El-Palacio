<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Comentario;
use App\Models\Habitacion;
use App\Models\Mantenimiento;
use App\Models\Reserva;
use App\Models\Servicio;
use App\Models\Temporada;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class InicioController extends Controller
{
    public function home()
    {
        // Obtener comentarios destacados (últimos 3 con buena valoración)
        $comentariosDestacados = Comentario::with('usuario')
            ->where('valoracion', '>=', 4)
            ->orderBy('fecha', 'desc')
            ->take(3)
            ->get();
        
        if (!Auth::check()) {
            return view('inicio', compact('comentariosDestacados'));
        }

        $user = Auth::user();
        if ($user->admin == true) {
            return view('admin.inicio_admin');
        }
        else if ($user->recepcionista == true) {
            return view('recepcionista.inicio_recepcionista');
        }
        return view('inicio', compact('comentariosDestacados'));
    }
    
    public function todasOpiniones()
    {
        $comentarios = Comentario::with('usuario')
            ->orderBy('fecha', 'desc')
            ->paginate(10);
        
        return view('opiniones', compact('comentarios'));
    }

    public function tablaUsuarios()
    {
        $user = Auth::user();
        if ($user->admin == true) {
            $users = User::orderBy('id')->paginate(10);
            return view('admin.tabla_usuario', compact('users'));
        }
        else {
            return redirect()->route('home')->with('error', 'No tienes permisos');
        }
    }

    public function tablaReservas()
    {
        $user = Auth::user();
        if ($user->admin == true) {
            $reservas = Reserva::orderBy('id')->paginate(10);
            return view('admin.tabla_reserva', compact('reservas'));
        }
        else {
            return redirect()->route('home')->with('error', 'No tienes permisos');
        }
    }

    public function tablaComentarios()
    {
        $user = Auth::user();
        if ($user->admin == true) {
            $comentarios = Comentario::with('usuario')->orderBy('id')->paginate(10);
            return view('admin.tabla_comentario', compact('comentarios'));
        }
        else {
            return redirect()->route('home')->with('error', 'No tienes permisos');
        }
    }

    public function tablaHabitaciones()
    {
        $user = Auth::user();
        if ($user->admin == true) {
            $habitaciones = Habitacion::with('categoria')->orderBy('id')->paginate(10);
            return view('admin.tabla_habitacion', compact('habitaciones'));
        }
        else {
            return redirect()->route('home')->with('error', 'No tienes permisos');
        }
    }

    public function tablaCategorias()
    {
        $user = Auth::user();
        if ($user->admin == true) {
            $categorias = Categoria::orderBy('id')->paginate(10);
            return view('admin.tabla_categoria', compact('categorias'));
        }
        else {
            return redirect()->route('home')->with('error', 'No tienes permisos');
        }
    }

    public function tablaMantenimientos()
    {
        $user = Auth::user();
        if ($user->admin == true) {
            $mantenimientos = Mantenimiento::with('habitacion')->orderBy('id')->paginate(10);
            return view('admin.tabla_mantenimiento', compact('mantenimientos'));
        }
        else {
            return redirect()->route('home')->with('error', 'No tienes permisos');
        }
    }

    public function tablaTemporadas()
    {
        $user = Auth::user();
        if ($user->admin == true) {
            $temporadas = Temporada::orderBy('id')->paginate(10);
            return view('admin.tabla_temporada', compact('temporadas'));
        }
        else {
            return redirect()->route('home')->with('error', 'No tienes permisos');
        }
    }

    public function tablaServicios()
    {
        $user = Auth::user();
        if ($user->admin == true) {
            $servicios = Servicio::orderBy('id')->paginate(10);
            return view('admin.tabla_servicio', compact('servicios'));
        }
        else {
            return redirect()->route('home')->with('error', 'No tienes permisos');
        }
    }
}
