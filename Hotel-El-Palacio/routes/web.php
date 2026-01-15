<?php

    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\RegistroController;
    use App\Http\Controllers\LoginController;
    use App\Http\Controllers\PerfilController;
    use App\Http\Controllers\BusquedaController;
    use App\Http\Controllers\ReservaController;
    use App\Http\Controllers\InicioController;

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

    //Ruta para completar reserva
    Route::get('/reserva/completar/{habitacion}', [ReservaController::class, 'completar'])->name('reserva.completar');

    Route::middleware(['auth'])->group(function () {
    
        // Ver el perfil
        Route::get('/perfil', function () { 
            return view('perfil'); 
        })->name('perfil');

        // Actualizar el perfil (Esta es la que faltaba)
        Route::put('/perfil/actualizar', [PerfilController::class, 'update'])->name('perfil.update');
        
    });

    Route::middleware(['auth'])->prefix('admin')->group(function () {

        Route::get('/admin/usuarios', [InicioController::class, 'tablaUsuarios'])->name('admin.usuarios');

        Route::get('/admin/habitaciones', [InicioController::class, 'tablaHabitaciones'])->name('admin.habitaciones');

        Route::get('/admin/reservas', [InicioController::class, 'tablaReservas'])->name('admin.reservas');

        Route::get('/admin/comentarios', [InicioController::class, 'tablaComentarios'])->name('admin.comentarios');
    });

    Route::fallback(function () {
        return redirect()->route('home');
    });