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
        $errorMessage = 'Error al iniciar sesión, correo o contraseña incorrectos.';

        if (empty($request->correo) || empty($request->password)) {
            return back()->withErrors(['login' => $errorMessage])->onlyInput('correo');
        }

        $user = User::where('correo', $request->correo)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors(['login' => $errorMessage])->onlyInput('correo');
        }

        Auth::login($user);
        $request->session()->regenerate();
        return redirect()->route('home')->with('success', '¡Bienvenido/a de nuevo!');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Has cerrado sesión correctamente.');
    }

}