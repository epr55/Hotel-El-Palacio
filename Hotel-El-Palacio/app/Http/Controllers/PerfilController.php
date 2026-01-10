<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PerfilController extends Controller
{
    /**
     * Actualiza los datos del perfil del usuario.
     */
    public function update(Request $request)
    {
        // 1. Obtener el usuario autenticado
        $user = Auth::user();

        // 2. Validar los datos recibidos
        $request->validate([
            'name'     => 'required|string|max:255',
            // Validamos que el email sea único, pero ignoramos el ID del usuario actual
            'correo'    => 'required|email|max:255|unique:users,correo,' . $user->id,
            'telefono' => 'nullable|string|max:20',
            // La contraseña solo se valida si el usuario escribió algo
            'password' => 'nullable|min:8|confirmed',
        ], [
            // Mensajes personalizados (opcional)
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'correo.unique' => 'Este correo ya está registrado por otro usuario.',
        ]);

        // 3. Asignar los nuevos valores
        $user->name = $request->name;
        $user->correo = $request->correo;
        $user->telefono = $request->telefono;

        // 4. Si el usuario escribió una nueva contraseña, la encriptamos y guardamos
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // 5. Guardar en la base de datos
        $user->save();

        // 6. Redirigir de vuelta con un mensaje de éxito
        return redirect()->route('perfil')->with('success', 'Tu perfil ha sido actualizado correctamente.');
    }
}