@extends('layouts.master')

@section('title', 'Perfil')

@section('content')

<div class="login-wrapper">
    <div class="login-box register-box">

        <h3 class="login-title">MI PERFIL</h3>

        <form action="{{ route('perfil.update') }}" method="POST">
            @csrf
            @method('PUT')

            <label>Nombre</label>
            {{-- 'old' mantiene lo escrito si hay error, de lo contrario muestra el valor de la DB --}}
            <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}" required>

            <label>Email</label>
            {{-- Ojo: Verifica si en tu base de datos es 'email' o 'correo' --}}
            <input type="correo" name="correo" value="{{ old('correo', Auth::user()->correo) }}" required>

            <label>Teléfono</label>
            <input type="tel" name="telefono" value="{{ old('telefono', Auth::user()->telefono) }}">

            <hr style="border: 0; border-top: 1px solid #D39D55; margin: 20px 0; opacity: 0.3;">
            <p style="color: #D39D55; font-size: 0.9rem;">Dejar en blanco si no deseas cambiar la contraseña:</p>

            <label>Nueva Contraseña</label>
            <input type="password" name="password">

            <label>Confirmar nueva contraseña</label>
            <input type="password" name="password_confirmation">

            <div class="row-2-buttons" style="margin-top: 5px; display: flex; justify-content: center;">
                <button type="submit" class="btn-login-main" style="width: auto; padding: 10px 40px;">
                    Actualizar Datos
                </button>
            </div>
        </form>

    </div>
</div>

@endsection