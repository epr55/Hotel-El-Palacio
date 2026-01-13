<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function show()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        // Mensaje de error genérico
        $errorMessage = 'Error al iniciar sesión, correo o contraseña incorrectos.';

        // Validación simple
        if (empty($request->correo) || empty($request->password)) {
            return back()->withErrors(['login' => $errorMessage])->onlyInput('correo');
        }

        // Intento de login
        if (Auth::attempt([
            'correo' => $request->correo,
            'password' => $request->password,
        ])) {
            $request->session()->regenerate();
            return redirect()->intended(route('home'))->with('success', '¡Bienvenido/a de nuevo!');
        }

        return back()->withErrors(['login' => $errorMessage])->onlyInput('correo');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Has cerrado sesión correctamente.');
    }

}