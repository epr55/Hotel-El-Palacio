<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegistroController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => ['required','string','max:255'],
            'correo' => ['required','email','unique:users,correo'],
            'telefono' => ['nullable','string','max:20'],
            'password' => ['required','confirmed','min:6'],
        ]);

        $user = User::create([
            'name' => $request->nombre,
            'correo' => $request->correo,
            'telefono' => $request->telefono,
            'password' => Hash::make($request->password),
            'admin' => false,
            'recepcionista' => false,

        ]);

        $user->save();

        return redirect()->route('login')->with('success', 'Registro completado. Ahora puedes iniciar sesión.');
    }
}
