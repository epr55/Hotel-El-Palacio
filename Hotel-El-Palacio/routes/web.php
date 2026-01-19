<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\RegistroController;
    use App\Http\Controllers\LoginController;
    use App\Http\Controllers\PerfilController;
    use App\Http\Controllers\BusquedaController;
    use App\Http\Controllers\ReservaController;
    use App\Http\Controllers\PagoController;
    use App\Http\Controllers\InicioController;
    use App\Http\Controllers\MisReservasController;
    use App\Http\Controllers\RecepcionistaController;
    use App\Http\Controllers\ComentarioController;

    Route::get('/', [InicioController::class, 'home'])->name('home');
    
    Route::get('/opiniones', [InicioController::class, 'todasOpiniones'])->name('opiniones.todas');

    Route::get('/login', [LoginController::class, 'show'])->name('login');

    //Ruta para llevar a la pagina de registro
    Route::get('/registro', function () {return view('registro');})->name('registro');

    //Ruta post registro
    Route::post('/registro', [RegistroController::class, 'store'])->name('registro.store');

    //Ruta post login
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');

    //Ruta para el logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    //Ruta para el buscador
    Route::get('/busqueda', [BusquedaController::class, 'index'])->name('busqueda');

    //Ruta para completar reserva (requiere autenticación)
    Route::get('/reserva/completar/{habitacion}', [ReservaController::class, 'completar'])->middleware('auth')->name('reserva.completar');

    //Rutas middleware
    Route::middleware(['auth'])->group(function () {
        // Ver el perfil
        Route::get('/perfil', function () { return view('perfil'); })->name('perfil');
        
        // Rutas de opiniones (requieren autenticación)
        Route::get('/opiniones/crear', [ComentarioController::class, 'crear'])->name('opiniones.crear');
        Route::post('/opiniones/guardar', [ComentarioController::class, 'guardar'])->name('opiniones.guardar');

        //Rutas administracion (ver tablas)
        Route::get('/admin/usuarios', [InicioController::class, 'tablaUsuarios'])->name('admin.usuarios');
        Route::get('/admin/habitaciones', [InicioController::class, 'tablaHabitaciones'])->name('admin.habitaciones');
        Route::get('/admin/reservas', [InicioController::class, 'tablaReservas'])->name('admin.reservas');
        Route::get('/admin/comentarios', [InicioController::class, 'tablaComentarios'])->name('admin.comentarios');
        Route::get('/admin/categorias', [InicioController::class, 'tablaCategorias'])->name('admin.categorias');
        Route::get('/admin/mantenimientos', [InicioController::class, 'tablaMantenimientos'])->name('admin.mantenimientos');
        Route::get('/admin/temporadas', [InicioController::class, 'tablaTemporadas'])->name('admin.temporadas');
        Route::get('/admin/servicios', [InicioController::class, 'tablaServicios'])->name('admin.servicios');

        //Rutas recepcionista
        Route::prefix('recepcionista')->name('recepcionista.')->group(function () {
            Route::get('/inicio', [RecepcionistaController::class, 'index'])->name('inicio');
            Route::get('/habitaciones-disponibles', [RecepcionistaController::class, 'disponibles'])->name('disponibles');
            Route::get('/bloqueo-habitaciones', [RecepcionistaController::class, 'bloqueo'])->name('bloqueo');
            Route::post('/habitaciones/cambiar-estado', [RecepcionistaController::class, 'cambiarEstado'])->name('cambiarEstado');
            Route::post('/reservas/cancelar', [RecepcionistaController::class, 'cancelarReserva'])->name('cancelarReserva');
        });

        Route::get('/clientes/buscar', [RecepcionistaController::class, 'buscarCliente'])->name('clientes.buscar');
        Route::post('/clientes/crear-rapido', [RecepcionistaController::class, 'crearClienteRapido'])->name('clientes.crearRapido');

        //Rutas administracion (borrar)
        Route::delete('/admin/borrar/usuario/{id}', [AdminController::class, 'borrarUser'])->name('admin.borrar.usuario');
        Route::delete('/admin/borrar/habitacion/{id}', [AdminController::class, 'borrarHabitacion'])->name('admin.borrar.habitacion');
        Route::delete('/admin/borrar/reserva/{id}', [AdminController::class, 'borrarReserva'])->name('admin.borrar.reserva');
        Route::delete('/admin/borrar/comentario/{id}', [AdminController::class, 'borrarComentario'])->name('admin.borrar.comentario');
        Route::delete('/admin/borrar/categoria/{id}', [AdminController::class, 'borrarCategoria'])->name('admin.borrar.categoria');
        Route::delete('/admin/borrar/mantenimiento/{id}', [AdminController::class, 'borrarMantenimiento'])->name('admin.borrar.mantenimiento');
        Route::delete('/admin/borrar/temporada/{id}', [AdminController::class, 'borrarTemporada'])->name('admin.borrar.temporada');
        Route::delete('/admin/borrar/servicio/{id}', [AdminController::class, 'borrarServicio'])->name('admin.borrar.servicio');

        //Rutas administracion (ir a editar)
        Route::get('/admin/formulario/editar/habitacion/{id}', [AdminController::class, 'formularioEditarHabitacion'])->name('admin.formulario.editar.habitacion');
        Route::get('/admin/formulario/editar/reserva/{id}', [AdminController::class, 'formularioEditarReserva'])->name('admin.formulario.editar.reserva');
        Route::get('/admin/formulario/editar/categoria/{id}', [AdminController::class, 'formularioEditarCategoria'])->name('admin.formulario.editar.categoria');
        Route::get('/admin/formulario/editar/mantenimiento/{id}', [AdminController::class, 'formularioEditarMantenimiento'])->name('admin.formulario.editar.mantenimiento');
        Route::get('/admin/formulario/editar/temporada/{id}', [AdminController::class, 'formularioEditarTemporada'])->name('admin.formulario.editar.temporada');
        Route::get('/admin/formulario/editar/servicio/{id}', [AdminController::class, 'formularioEditarServicio'])->name('admin.formulario.editar.servicio');

        //Rutas administracion (editar)
        Route::put('/admin/editar/habitacion/{id}', [AdminController::class, 'editarHabitacion'])->name('admin.editar.habitacion');
        Route::put('/admin/editar/reserva/{id}', [AdminController::class, 'editarReserva'])->name('admin.editar.reserva');
        Route::put('/admin/editar/categoria/{id}', [AdminController::class, 'editarCategoria'])->name('admin.editar.categoria');
        Route::put('/admin/editar/mantenimiento/{id}', [AdminController::class, 'editarMantenimiento'])->name('admin.editar.mantenimiento');
        Route::put('/admin/editar/temporada/{id}', [AdminController::class, 'editarTemporada'])->name('admin.editar.temporada');
        Route::put('/admin/editar/servicio/{id}', [AdminController::class, 'editarServicio'])->name('admin.editar.servicio');

        //Rutas administracion (ir a insertar)
        Route::get('/admin/formulario/insertar/habitacion', [AdminController::class, 'formularioInsertarHabitacion'])->name('admin.formulario.insertar.habitacion');
        Route::get('/admin/formulario/insertar/reserva', [AdminController::class, 'formularioInsertarReserva'])->name('admin.formulario.insertar.reserva');
        Route::get('/admin/formulario/insertar/categoria', [AdminController::class, 'formularioInsertarCategoria'])->name('admin.formulario.insertar.categoria');
        Route::get('/admin/formulario/insertar/mantenimiento', [AdminController::class, 'formularioInsertarMantenimiento'])->name('admin.formulario.insertar.mantenimiento');
        Route::get('/admin/formulario/insertar/temporada', [AdminController::class, 'formularioInsertarTemporada'])->name('admin.formulario.insertar.temporada');
        Route::get('/admin/formulario/insertar/servicio', [AdminController::class, 'formularioInsertarServicio'])->name('admin.formulario.insertar.servicio');
        Route::get('/admin/formulario/insertar/usuario', [AdminController::class, 'formularioInsertarUsuario'])->name('admin.formulario.insertar.usuario');

        //Rutas administracion (insertar)
        Route::post('/admin/insertar/habitacion', [AdminController::class, 'insertarHabitacion'])->name('admin.insertar.habitacion');
        Route::post('/admin/insertar/reserva', [AdminController::class, 'insertarReserva'])->name('admin.insertar.reserva');
        Route::post('/admin/insertar/categoria', [AdminController::class, 'insertarCategoria'])->name('admin.insertar.categoria');
        Route::post('/admin/insertar/mantenimiento', [AdminController::class, 'insertarMantenimiento'])->name('admin.insertar.mantenimiento');
        Route::post('/admin/insertar/temporada', [AdminController::class, 'insertarTemporada'])->name('admin.insertar.temporada');
        Route::post('/admin/insertar/servicio', [AdminController::class, 'insertarServicio'])->name('admin.insertar.servicio');
        Route::post('/admin/insertar/usuario', [AdminController::class, 'insertarUsuario'])->name('admin.insertar.usuario');

        // Actualizar el perfil
        Route::put('/perfil/actualizar', [PerfilController::class, 'update'])->name('perfil.update');
        
        // Iniciar proceso de pago
        Route::post('/pago/init', [PagoController::class, 'initPayment'])->name('pago.init');

        //Ruta para la página de mis reservas
        Route::get('/mis-reservas', [MisReservasController::class, 'index'])->name('reservas.usuario');

        //Ruta para cancelar una reserva
        Route::post('/reservas/{id}/cancelar', [ReservaController::class, 'cancelar'])->name('reservas.cancelar');
    });
    
    // Página de confirmación del pago (no requiere auth porque viene del TPV)
    Route::get('/pago/confirmado', [PagoController::class, 'pagoConfirmado'])->name('pago.confirmado');

    //Rutas no existentes
    Route::fallback(function () {return redirect()->route('home');});
