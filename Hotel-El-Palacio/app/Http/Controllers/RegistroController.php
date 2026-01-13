<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegistroController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => ['required','string','max:255'],
            'correo' => ['required','email:rfc,dns','unique:users,correo'],
            'telefono' => ['nullable','string','regex:/^[+]?[0-9]{9,15}$/'],
            'password' => ['required','confirmed','min:6'],
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.max' => 'El nombre no puede tener más de 255 caracteres.',
            'correo.required' => 'El email es obligatorio.',
            'correo.email' => 'Debes proporcionar un email válido con formato correcto.',
            'correo.unique' => 'Este email ya está registrado.',
            'telefono.regex' => 'El teléfono debe tener entre 9 y 15 dígitos (puede empezar con +).',
            'password.required' => 'La contraseña es obligatoria.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres.',
        ]);

        $user = User::create([
            'name' => $request->nombre,
            'correo' => $request->correo,
            'telefono' => $request->telefono,
            'password' => Hash::make($request->password),
            'admin' => false,
            'recepcionista' => false,
        ]);

        // Login automático después del registro
        Auth::login($user);

        return redirect()->route('home')->with('success', '¡Bienvenido/a! Tu cuenta ha sido creada exitosamente.');
    }
}
