    <?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistroController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\BusquedaController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\PagoController;

Route::get('/', function () {
    return view('inicio');
})->name('home');

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
    Route::get('/reserva/completar/{habitacion}', [ReservaController::class, 'completar'])
        ->middleware('auth')
        ->name('reserva.completar');

    Route::middleware(['auth'])->group(function () {
    
        // Ver el perfil
        Route::get('/perfil', function () { 
            return view('perfil'); 
        })->name('perfil');

        // Actualizar el perfil (Esta es la que faltaba)
        Route::put('/perfil/actualizar', [PerfilController::class, 'update'])->name('perfil.update');
        
        // Iniciar proceso de pago
        Route::post('/pago/init', [PagoController::class, 'initPayment'])->name('pago.init');
    });
    
    // Página de confirmación del pago (no requiere auth porque viene del TPV)
    Route::get('/pago/confirmado', [PagoController::class, 'pagoConfirmado'])->name('pago.confirmado');