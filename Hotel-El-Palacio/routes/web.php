<?php

    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\RegistroController;
    use App\Http\Controllers\LoginController;
    use App\Http\Controllers\PerfilController;
    use App\Http\Controllers\BusquedaController;
    use App\Http\Controllers\ReservaController;
    use App\Http\Controllers\PagoController;
    use App\Http\Controllers\InicioController;
    use App\Http\Controllers\MisReservasController;

    Route::get('/', [InicioController::class, 'home'])->name('home');

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

        //Rutas administracion
        Route::get('/admin/usuarios', [InicioController::class, 'tablaUsuarios'])->name('admin.usuarios');
        Route::get('/admin/habitaciones', [InicioController::class, 'tablaHabitaciones'])->name('admin.habitaciones');
        Route::get('/admin/reservas', [InicioController::class, 'tablaReservas'])->name('admin.reservas');
        Route::get('/admin/comentarios', [InicioController::class, 'tablaComentarios'])->name('admin.comentarios');

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
