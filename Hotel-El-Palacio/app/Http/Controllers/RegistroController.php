<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegistroController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => ['required','string','max:255'],
            'correo' => ['required','email','unique:usuarios,correo'],
            'telefono' => ['nullable','string','max:20'],
            'password' => ['required','confirmed','min:6'],
        ]);

        Usuario::create([
            'nombre' => $request->nombre,
            'correo' => $request->correo,
            'telefono' => $request->telefono,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login')
            ->with('success', 'Registro completado. Ahora puedes iniciar sesión.');
    }
}
