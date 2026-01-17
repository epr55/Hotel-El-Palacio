<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Comentario;
use App\Models\Habitacion;
use App\Models\Mantenimiento;
use App\Models\Reserva;
use App\Models\Servicio;
use App\Models\Temporada;
use Carbon\Carbon;

class AdminController extends Controller
{
    //======== FUNCIONES PARA BORRAR ========
    public function borrarUser($id)
    {
        $usuario = Auth::user();
        if ($usuario && $usuario->admin == true) {
            $user = User::findOrFail($id);
            $user->delete();
            return redirect()->route('admin.usuarios')->with('success', 'Usuario eliminado correctamente');
        }
        return redirect()->route('home')->with('error', 'No tienes permisos');
    }

    public function borrarHabitacion($id)
    {
        $usuario = Auth::user();
        if ($usuario && $usuario->admin == true) {
            $habitacion = Habitacion::findOrFail($id);
            $habitacion->delete();
            return redirect()->route('admin.habitaciones')->with('success', 'Habitacion eliminada correctamente');
        }
        return redirect()->route('home')->with('error', 'No tienes permisos');
    }

    public function borrarReserva($id)
    {
        $usuario = Auth::user();
        if ($usuario && $usuario->admin == true) {
            $reserva = Reserva::findOrFail($id);
            $reserva->delete();
            return redirect()->route('admin.reservas')->with('success', 'Reserva eliminada correctamente');
        }
        return redirect()->route('home')->with('error', 'No tienes permisos');
    }

    public function borrarComentario($id)
    {
        $usuario = Auth::user();
        if ($usuario && $usuario->admin == true) {
            $comentario = Comentario::findOrFail($id);
            $comentario->delete();
            return redirect()->route('admin.comentarios')->with('success', 'Comentario eliminado correctamente');
        }
        return redirect()->route('home')->with('error', 'No tienes permisos');
    }

    public function borrarCategoria($id)
    {
        $usuario = Auth::user();
        if ($usuario && $usuario->admin == true) {
            $categoria = Categoria::findOrFail($id);
            $categoria->delete();
            return redirect()->route('admin.categorias')->with('success', 'Categoria eliminada correctamente');
        }
        return redirect()->route('home')->with('error', 'No tienes permisos');
    }

    public function borrarMantenimiento($id)
    {
        $usuario = Auth::user();
        if ($usuario && $usuario->admin == true) {
            $mantenimiento = Mantenimiento::findOrFail($id);
            $mantenimiento->delete();
            return redirect()->route('admin.mantenimientos')->with('success', 'Mantenimiento eliminado correctamente');
        }
        return redirect()->route('home')->with('error', 'No tienes permisos');
    }

    public function borrarTemporada($id)
    {
        $usuario = Auth::user();
        if ($usuario && $usuario->admin == true) {
            $temporada = Temporada::findOrFail($id);
            $temporada->delete();
            return redirect()->route('admin.temporadas')->with('success', 'Temporada eliminada correctamente');
        }
        return redirect()->route('home')->with('error', 'No tienes permisos');
    }

    public function borrarServicio($id)
    {
        $usuario = Auth::user();
        if ($usuario && $usuario->admin == true) {
            $servicio = Servicio::findOrFail($id);
            $servicio->delete();
            return redirect()->route('admin.servicios')->with('success', 'Servicio eliminado correctamente');
        }
        return redirect()->route('home')->with('error', 'No tienes permisos');
    }

    //======== FUNCIONES EDITAR ========
    public function formularioHabitacion($id)
    {
        $usuario = Auth::user();
        if ($usuario && $usuario->admin == true) {
            $habitacion = Habitacion::findOrFail($id);
            $categorias = Categoria::all();
            return view('admin.editar.editar_habitacion', compact('habitacion', 'categorias'));
        }
        return redirect()->route('home')->with('error', 'No tienes permisos'); 
    }

    public function editarHabitacion(Request $request, $id)
    {
        $usuario = Auth::user();
        if ($usuario && $usuario->admin == true) {
            $request->validate([
                'numero' => 'required|integer',
                'precio' => 'required|numeric|min:0',
                'categoria_id' => 'required|exists:categorias,id',
            ]);

            $habitacion = Habitacion::findOrFail($id);

            $habitacion->update([
                'numero' => $request->numero,
                'precio' => $request->precio,
                'categoria_id' => $request->categoria_id,
                'balcon' => $request->has('balcon'),
                'escritorio' => $request->has('escritorio'),
                'cuna' => $request->has('cuna'),
            ]);

            return redirect()->route('admin.habitaciones')->with('success', 'Habitacion editada correctamente');
        }
        return redirect()->route('home')->with('error', 'No tienes permisos'); 
    }
    //=============================================================================================================
    public function formularioReserva($id)
    {
        $usuario = Auth::user();
        if ($usuario && $usuario->admin == true) {
            $reserva = Reserva::findOrFail($id);
            $usuarios = User::all();
            $habitaciones = Habitacion::all();
            $servicios = Servicio::all();
            return view('admin.editar.editar_reserva', compact('reserva', 'usuarios', 'habitaciones', 'servicios'));
        }
        return redirect()->route('home')->with('error', 'No tienes permisos'); 
    }

    public function editarReserva(Request $request, $id)
    {
        $usuario = Auth::user();

        if (!$usuario || !$usuario->admin) {
            return redirect()->route('home')->with('error', 'No tienes permisos');
        }

        $request->validate([
            'user_id'        => 'required|exists:users,id',
            'habitacion_id'  => 'required|exists:habitaciones,id',
            'fecha_inicio'   => 'required|date',
            'fecha_final'    => 'required|date|after:fecha_inicio',
            'estado'         => 'required|in:pendiente,confirmada,cancelada',
            'servicios'      => 'nullable|array',
            'servicios.*'    => 'exists:servicios,id',
        ]);

        $reserva = Reserva::findOrFail($id);

        $inicio = Carbon::parse($request->fecha_inicio);
        $fin    = Carbon::parse($request->fecha_final);
        $noches = max(1, $inicio->diffInDays($fin));

        $mantenimientoActivo = Mantenimiento::where('habitacion_id', $request->habitacion_id)->where(function ($q) use ($inicio, $fin) {
            $q->where('fecha_inicio', '<', $fin)->where('fecha_final', '>', $inicio);
        })->exists();

        if ($mantenimientoActivo) {
            return back()->withInput()->withErrors([
                'habitacion_id' => 'La habitación está en mantenimiento en esas fechas'
            ]);
        }

        $reservaSolapada = Reserva::where('habitacion_id', $request->habitacion_id)->where('id', '!=', $id)->where(function ($q) use ($inicio, $fin) {
            $q->where('fecha_inicio', '<', $fin)->where('fecha_final', '>', $inicio);
        })->exists();

        if ($reservaSolapada) {
            return back()->withInput()->withErrors([
                'habitacion_id' => 'La habitación ya está reservada en esas fechas'
            ]);
        }

        $temporada = Temporada::where('fecha_inicio', '<=', $inicio)->where('fecha_final', '>=', $fin)->first();

        if (!$temporada) {
            return back()->withInput()->withErrors([
                'fecha_inicio' => 'No existe una temporada definida para las fechas seleccionadas'
            ]);
        }

        $habitacion = Habitacion::findOrFail($request->habitacion_id);

        $precioBase = $habitacion->precio * $noches * $temporada->multiplicador;

        $precioServicios = 0;
        $servicios = Servicio::whereIn('id', $request->servicios ?? [])->get();

        foreach ($servicios as $servicio) {
            switch ($servicio->tipo_cobro) {
                case 'por_persona_noche':
                    $precioServicios += $servicio->precio * $habitacion->categoria->capacidad * $noches;
                    break;

                case 'por_noche':
                    $precioServicios += $servicio->precio * $noches;
                    break;

                case 'personalizable_por_persona':
                    $precioServicios += $servicio->precio * $habitacion->categoria->capacidad;
                    break;

                case 'unico':
                    $precioServicios += $servicio->precio;
                    break;
            }
        }

        $precioTotal = $precioBase + $precioServicios;

        $reserva->update([
            'user_id'       => $request->user_id,
            'habitacion_id' => $request->habitacion_id,
            'fecha_inicio'  => $inicio,
            'fecha_final'   => $fin,
            'estado'        => $request->estado,
            'temporada_id'  => $temporada->id,
            'precio_total'  => $precioTotal,
        ]);

        $reserva->servicios()->sync($request->servicios ?? []);

        return redirect()->route('admin.reservas')->with('success', 'Reserva editada correctamente');
    }
    //=============================================================================================================
    public function formularioCategoria($id)
    {
        $usuario = Auth::user();
        if ($usuario && $usuario->admin == true) {
            $categoria = Categoria::findOrFail($id);
            return view('admin.editar.editar_categoria', compact('categoria'));
        }
        return redirect()->route('home')->with('error', 'No tienes permisos'); 
    }

    public function editarCategoria(Request $request, $id)
    {
        $usuario = Auth::user();
        if ($usuario && $usuario->admin == true) {
            $request->validate([
                'nombre' => 'required|string|max:255',
                'capacidad' => 'required|integer|min:1',
                'descripcion' => 'nullable|string',
            ]);

            $categoria = Categoria::findOrFail($id);

            $categoria->update([
                'nombre' => $request->nombre,
                'capacidad' => $request->capacidad,
                'descripcion' => $request->descripcion,
            ]);

            return redirect()->route('admin.categorias')->with('success', 'Categoria editada correctamente');
        }
        return redirect()->route('home')->with('error', 'No tienes permisos'); 
    }
    //=============================================================================================================
    public function formularioMantenimiento($id)
    {
        $usuario = Auth::user();
        if ($usuario && $usuario->admin == true) {
            $mantenimiento = Mantenimiento::findOrFail($id);
            $habitaciones = Habitacion::all();
            return view('admin.editar.editar_mantenimiento', compact('mantenimiento', 'habitaciones'));
        }
        return redirect()->route('home')->with('error', 'No tienes permisos'); 
    }

    public function editarMantenimiento(Request $request, $id)
    {
        $usuario = Auth::user();
        if ($usuario && $usuario->admin == true) {
            $request->validate([
                'habitacion_id' => 'required|exists:habitaciones,id',
                'fecha_inicio' => 'required|date',
                'fecha_final' => 'required|date|after_or_equal:fecha_inicio',
                'motivo' => 'nullable|string',
            ]);

            $mantenimiento = Mantenimiento::findOrFail($id);

            $mantenimiento->update([
                'habitacion_id' => $request->habitacion_id,
                'fecha_inicio' => $request->fecha_inicio,
                'fecha_final' => $request->fecha_final,
                'motivo' => $request->motivo
            ]);

            return redirect()->route('admin.mantenimientos')->with('success', 'Mantenimiento editado correctamente');
        }
        return redirect()->route('home')->with('error', 'No tienes permisos'); 
    }
    //=============================================================================================================
    public function formularioTemporada($id)
    {
        $usuario = Auth::user();
        if ($usuario && $usuario->admin == true) {
            $temporada = Temporada::findOrFail($id);
            return view('admin.editar.editar_temporada', compact('temporada'));
        }
        return redirect()->route('home')->with('error', 'No tienes permisos'); 
    }

    public function editarTemporada(Request $request, $id)
    {
        $usuario = Auth::user();
        if ($usuario && $usuario->admin == true) {
            $request->validate([
                'nombre' => 'required|string|max:255',
                'multiplicador' => 'required|numeric|min:0',
                'fecha_inicio' => 'required|date',
                'fecha_final' => 'required|date|after_or_equal:fecha_inicio',
            ]);

            $temporada = Temporada::findOrFail($id);

            $temporada->update([
                'nombre' => $request->nombre,
                'multiplicador' => $request->multiplicador,
                'fecha_inicio' => $request->fecha_inicio,
                'fecha_final' => $request->fecha_final,
            ]);

            return redirect()->route('admin.temporadas')->with('success', 'Temporada editada correctamente');
        }
        return redirect()->route('home')->with('error', 'No tienes permisos'); 
    }
    //=============================================================================================================
    public function formularioServicio($id)
    {
        $usuario = Auth::user();
        if ($usuario && $usuario->admin == true) {
            $servicio = Servicio::findOrFail($id);
            return view('admin.editar.editar_servicio', compact('servicio'));
        }
        return redirect()->route('home')->with('error', 'No tienes permisos'); 
    }

    public function editarServicio(Request $request, $id)
    {
        $usuario = Auth::user();
        if ($usuario && $usuario->admin == true) {
            $request->validate([
                'nombre' => 'required|string|max:255',
                'precio' => 'required|numeric|min:0',
                'tipo_cobro' => 'required|string',
                'descripcion' => 'nullable|string',
            ]);
            $servicio = Servicio::findOrFail($id);

            $servicio->update([
                'nombre' => $request->nombre,
                'precio' => $request->precio,
                'tipo_cobro' => $request->tipo_cobro,
                'descripcion' => $request->descripcion,
            ]);

            return redirect()->route('admin.servicios')->with('success', 'Servicio editado correctamente');
        }
        return redirect()->route('home')->with('error', 'No tienes permisos'); 
    }
}
