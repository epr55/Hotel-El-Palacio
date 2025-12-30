    <?php

    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\RegistroController;
    use App\Http\Controllers\LoginController;

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