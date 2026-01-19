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

    //======== FUNCIONES PARA EDITAR ========
    public function formularioEditarHabitacion($id)
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
    public function formularioEditarReserva($id)
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
            'fecha_inicio'   => 'required|date_format:Y-m-d\TH:i',
            'fecha_final'    => 'required|date_format:Y-m-d\TH:i|after:fecha_inicio',
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
            return redirect()->route('admin.reservas')->with('error','La habitación está en mantenimiento en esas fechas');
        }

        $reservaSolapada = Reserva::where('habitacion_id', $request->habitacion_id)->where('id', '!=', $id)->where(function ($q) use ($inicio, $fin) {
            $q->where('fecha_inicio', '<', $fin)->where('fecha_final', '>', $inicio);
        })->exists();

        if ($reservaSolapada) {
            return redirect()->route('admin.reservas')->with('error','La habitación ya está reservada en esas fechas');
        }

        $inicioTemp = $inicio->copy()->year(2000);

        $temporada = Temporada::where(function ($q) use ($inicioTemp) {
            $q->where(function ($q2) use ($inicioTemp) {
                $q2->whereColumn('fecha_inicio', '<=', 'fecha_final')->where('fecha_inicio', '<=', $inicioTemp)->where('fecha_final', '>=', $inicioTemp);
            })->orWhere(function ($q2) use ($inicioTemp) {
                $q2->whereColumn('fecha_inicio', '>', 'fecha_final')->where(function ($q3) use ($inicioTemp) {
                    $q3->where('fecha_inicio', '<=', $inicioTemp)->orWhere('fecha_final', '>=', $inicioTemp);
                });
            });
        })->first();

        if (!$temporada) {
            return redirect()->route('admin.reservas')->with('error', 'No existe temporada para la fecha de inicio seleccionada');
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
    public function formularioEditarCategoria($id)
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
    public function formularioEditarMantenimiento($id)
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
    public function formularioEditarTemporada($id)
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
                'fecha_final' => 'required|date|',
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
    public function formularioEditarServicio($id)
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

    //========FUNCIONES PARA INSERTAR========
    public function formularioInsertarHabitacion()
    {
        $usuario = Auth::user();
        if ($usuario && $usuario->admin == true) {
            $categorias = Categoria::all();
            return view('admin.insertar.insertar_habitacion', compact('categorias'));
        }
        return redirect()->route('home')->with('error', 'No tienes permisos'); 
    }

    public function insertarHabitacion(Request $request)
    {
        $usuario = Auth::user();

        if (!$usuario || !$usuario->admin) {
            return redirect()->route('home')->with('error', 'No tienes permisos');
        }

        $request->validate([
            'numero'            => 'required|integer|unique:habitaciones,numero',
            'precio'            => 'required|numeric|min:0',
            'categoria_id'      => 'required|exists:categorias,id',
            'imagen'            => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'camas_individual'  => 'required|integer|min:0',
            'camas_doble'       => 'required|integer|min:0',
            'aseos'             => 'required|integer|min:0',
        ]);

        $rutaImagen = null;

        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
            $nombreImagen = time() . '_' . uniqid() . '.' . $imagen->getClientOriginalExtension();
            $imagen->move(public_path('images'), $nombreImagen);
            $rutaImagen = 'images/' . $nombreImagen;
        }

        Habitacion::create([
            'numero'            => $request->numero,
            'precio'            => $request->precio,
            'categoria_id'      => $request->categoria_id,
            'imagen'            => $rutaImagen,
            'camas_individual'  => $request->camas_individual,
            'camas_doble'       => $request->camas_doble,
            'aseos'             => $request->aseos,
            'balcon'            => $request->has('balcon'),
            'escritorio'        => $request->has('escritorio'),
            'cuna'              => $request->has('cuna'),
        ]);

        return redirect()->route('admin.habitaciones')->with('success', 'Habitación creada correctamente');
    }
    //=============================================================================================================
    public function formularioInsertarReserva()
    {
        $usuario = Auth::user();
        if ($usuario && $usuario->admin == true) {
            $habitaciones = Habitacion::all();
            $usuarios = User::all();
            $servicios = Servicio::all();
            return view('admin.insertar.insertar_reserva', compact('habitaciones','usuarios','servicios'));
        }
        return redirect()->route('home')->with('error', 'No tienes permisos'); 
    }

    public function insertarReserva(Request $request)
    {
        $usuario = Auth::user();

        if (!$usuario || !$usuario->admin) {
            return redirect()->route('home')->with('error', 'No tienes permisos');
        }

        $request->validate([
            'user_id'        => 'required|exists:users,id',
            'habitacion_id'  => 'required|exists:habitaciones,id',
            'fecha_inicio'   => 'required|date_format:Y-m-d\TH:i',
            'fecha_final'    => 'required|date_format:Y-m-d\TH:i|after:fecha_inicio',
            'estado'         => 'required|in:pendiente,confirmada,cancelada',
            'servicios'      => 'nullable|array',
            'servicios.*'    => 'exists:servicios,id',
        ]);

        $inicio = Carbon::parse($request->fecha_inicio);
        $fin    = Carbon::parse($request->fecha_final);
        $noches = max(1, $inicio->diffInDays($fin));

        $mantenimientoActivo = Mantenimiento::where('habitacion_id', $request->habitacion_id)->where(function ($q) use ($inicio, $fin) {
            $q->where('fecha_inicio', '<', $fin)->where('fecha_final', '>', $inicio);
        })->exists();

        if ($mantenimientoActivo) {
            return redirect()->route('admin.reservas')->with('error', 'La habitación está en mantenimiento en esas fechas');
        }

        $reservaSolapada = Reserva::where('habitacion_id', $request->habitacion_id)->where(function ($q) use ($inicio, $fin) {
            $q->where('fecha_inicio', '<', $fin)->where('fecha_final', '>', $inicio);
        })->exists();

        if ($reservaSolapada) {
            return redirect()->route('admin.reservas')->with('error', 'La habitación ya está reservada en esas fechas');
        }

        $inicioTemp = $inicio->copy()->year(2000);
        $temporada = Temporada::where(function ($q) use ($inicioTemp) {
            $q->where(function ($q2) use ($inicioTemp) {
                $q2->whereColumn('fecha_inicio', '<=', 'fecha_final')
                ->where('fecha_inicio', '<=', $inicioTemp)
                ->where('fecha_final', '>=', $inicioTemp);
            })->orWhere(function ($q2) use ($inicioTemp) {
                $q2->whereColumn('fecha_inicio', '>', 'fecha_final')->where(function ($q3) use ($inicioTemp) {
                    $q3->where('fecha_inicio', '<=', $inicioTemp)->orWhere('fecha_final', '>=', $inicioTemp);
                });
            });
        })->first();

        if (!$temporada) {
            return redirect()->route('admin.reservas')->with('error', 'No existe temporada para la fecha seleccionada');
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

        $reserva = Reserva::create([
            'user_id'       => $request->user_id,
            'habitacion_id' => $request->habitacion_id,
            'fecha_inicio'  => $inicio,
            'fecha_final'   => $fin,
            'estado'        => $request->estado,
            'temporada_id'  => $temporada->id,
            'precio_total'  => $precioTotal,
        ]);

        $reserva->servicios()->sync($request->servicios ?? []);

        return redirect()->route('admin.reservas')->with('success', 'Reserva creada correctamente');
    }
    //=============================================================================================================
    public function formularioInsertarCategoria()
    {
        $usuario = Auth::user();
        if ($usuario && $usuario->admin == true) {
            return view('admin.insertar.insertar_categoria');
        }
        return redirect()->route('home')->with('error', 'No tienes permisos'); 
    }

    public function insertarCategoria(Request $request)
    {
        $usuario = Auth::user();

        if (!$usuario || !$usuario->admin) {
            return redirect()->route('home')->with('error', 'No tienes permisos');
        }

        $request->validate([
            'nombre'     => 'required|string|max:255',
            'capacidad'  => 'required|integer|min:1',
            'descripcion'=> 'nullable|string',
        ]);

        Categoria::create([
            'nombre'      => $request->nombre,
            'capacidad'   => $request->capacidad,
            'descripcion' => $request->descripcion,
        ]);

        return redirect()->route('admin.categorias')->with('success', 'Categoría creada correctamente');
    }
    //=============================================================================================================
    public function formularioInsertarMantenimiento()
    {
        $usuario = Auth::user();
        if ($usuario && $usuario->admin == true) {
            $habitaciones = Habitacion::all();
            return view('admin.insertar.insertar_mantenimiento', compact('habitaciones'));
        }
        return redirect()->route('home')->with('error', 'No tienes permisos'); 
    }

    public function insertarMantenimiento(Request $request)
    {
        $usuario = Auth::user();

        if (!$usuario || !$usuario->admin) {
            return redirect()->route('home')->with('error', 'No tienes permisos');
        }

        $request->validate([
            'habitacion_id' => 'required|exists:habitaciones,id',
            'fecha_inicio'  => 'required|date',
            'fecha_final'   => 'required|date|after_or_equal:fecha_inicio',
            'motivo'        => 'nullable|string',
        ]);

        $solapado = Mantenimiento::where('habitacion_id', $request->habitacion_id)->where(function ($q) use ($request) {
                $q->where('fecha_inicio', '<', $request->fecha_final)->where('fecha_final', '>', $request->fecha_inicio);
            })->exists();

        if ($solapado) {
            return back()->withInput()->with('error', 'Ya existe un mantenimiento para esa habitación en esas fechas');
        }

        Mantenimiento::create([
            'habitacion_id' => $request->habitacion_id,
            'fecha_inicio'  => $request->fecha_inicio,
            'fecha_final'   => $request->fecha_final,
            'motivo'        => $request->motivo,
        ]);

        return redirect()->route('admin.mantenimientos')->with('success', 'Mantenimiento creado correctamente');
    }
    //=============================================================================================================
    public function formularioInsertarTemporada()
    {
        $usuario = Auth::user();
        if ($usuario && $usuario->admin == true) {
            return view('admin.insertar.insertar_temporada');
        }
        return redirect()->route('home')->with('error', 'No tienes permisos'); 
    }
    public function insertarTemporada(Request $request)
    {
        $usuario = Auth::user();

        if (!$usuario || !$usuario->admin) {
            return redirect()->route('home')->with('error', 'No tienes permisos');
        }

        $request->validate([
            'nombre'        => 'required|string|max:255',
            'multiplicador' => 'required|numeric|min:0',
            'inicio_dia'    => 'required|integer|min:1|max:31',
            'inicio_mes'    => 'required|integer|min:1|max:12',
            'fin_dia'       => 'required|integer|min:1|max:31',
            'fin_mes'       => 'required|integer|min:1|max:12',
        ]);

        $anio = 2000;

        try {
            $fechaInicio = Carbon::createFromDate($anio, $request->inicio_mes, $request->inicio_dia);
            $fechaFinal  = Carbon::createFromDate($anio, $request->fin_mes, $request->fin_dia);
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Las fechas introducidas no son válidas');
        }

        Temporada::create([
            'nombre'        => $request->nombre,
            'multiplicador' => $request->multiplicador,
            'fecha_inicio'  => $fechaInicio,
            'fecha_final'   => $fechaFinal,
        ]);

        return redirect()->route('admin.temporadas')->with('success', 'Temporada creada correctamente');
    }
    //=============================================================================================================
    public function formularioInsertarServicio()
    {
        $usuario = Auth::user();
        if ($usuario && $usuario->admin == true) {
            return view('admin.insertar.insertar_servicio');
        }
        return redirect()->route('home')->with('error', 'No tienes permisos'); 
    }
    public function insertarServicio(Request $request)
    {
        $usuario = Auth::user();

        if (!$usuario || !$usuario->admin) {
            return redirect()
                ->route('home')
                ->with('error', 'No tienes permisos');
        }

        $request->validate([
            'nombre'      => 'required|string|max:255',
            'precio'      => 'required|numeric|min:0',
            'tipo_cobro'  => 'required|in:por_persona_noche,por_noche,personalizable_por_persona,unico',
            'descripcion' => 'nullable|string',
        ]);

        Servicio::create([
            'nombre'      => $request->nombre,
            'precio'      => $request->precio,
            'tipo_cobro'  => $request->tipo_cobro,
            'descripcion' => $request->descripcion,
        ]);

        return redirect()
            ->route('admin.servicios')
            ->with('success', 'Servicio creado correctamente');
    }
    //=============================================================================================================
    public function formularioInsertarUsuario()
    {
        $usuario = Auth::user();
        if ($usuario && $usuario->admin == true) {
            return view('admin.insertar.insertar_usuario');
        }
        return redirect()->route('home')->with('error', 'No tienes permisos'); 
    }

    public function insertarUsuario(Request $request)
    {
        $usuario = Auth::user();

        if (!$usuario || !$usuario->admin) {
            return redirect()->route('home')->with('error', 'No tienes permisos');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,correo',
            'telefono' => 'nullable|string|max:20',
            'password' => 'required|string|min:6|confirmed',
            'rol' => 'required|in:user,recepcionista,admin',
        ], [
            'email.unique' => 'Ya existe un usuario con ese email',
            'password.confirmed' => 'Las contraseñas no coinciden',
            'rol.required' => 'Debes seleccionar un rol',
        ]);

        User::create([
            'name' => $request->name,
            'correo' => $request->email,
            'telefono' => $request->telefono,
            'password' => bcrypt($request->password),
            'admin' => $request->rol === 'admin',
            'recepcionista' => $request->rol === 'recepcionista',
        ]);

        return redirect()->route('admin.usuarios')->with('success', 'Usuario creado correctamente');
    }

}
