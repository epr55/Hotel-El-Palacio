@extends('layouts.master')

@section('title', 'Registro')

@section('content')

<div class="login-wrapper">
    <div class="login-box register-box">

        <h3 class="login-title">Registro</h3>

        <form action="{{ route('registro.store') }}" method="POST">
            @csrf

            <label>Nombre</label>
            <input type="text" name="nombre" placeholder="Nombre" required>

            <label>Email</label>
            <input type="email" name="correo" placeholder="email@address.com" required>

            <label>Teléfono</label>
            <input type="tel" name="telefono" placeholder="123 456 789">

            <label>Contraseña</label>
            <input type="password" name="password" placeholder="************" required>

            <label>Confirmar contraseña</label>
            <input type="password" name="password_confirmation" placeholder="************" required>

            <div class="terms">
                <input type="checkbox" required>
                <label for="terms">Acepto los Términos de Servicio y la Política de Privacidad</label>
            </div>

            <div class="row-2-buttons">
                <button type="submit" class="btn-login-main">Añadir Usuario</button>
                <button type="button" class="btn-cancel">Cancelar</button>
            </div>

            <p class="register-text">
                ¿Ya tienes cuenta? <a href="{{ route('login') }}">Iniciar sesión</a>
            </p>

        </form>

    </div>
</div>

@endsection
