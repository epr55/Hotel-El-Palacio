<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistroController;

Route::get('/', function () {
    return view('inicio');
});

Route::get('/login', function () {
    return view('login');
}) -> name('login');

//Ruta para llevar a la pagina de registro
Route::get('/registro', function () {
    return view('registro');
}) -> name('registro');

//Ruta post registro
Route::post('/registro', [RegistroController::class, 'store'])
    ->name('registro.store');
