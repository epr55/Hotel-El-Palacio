@extends('layouts.master')

@section('title', 'Login')

@section('content')

<div class="login-wrapper">
    <div class="login-box">

        <h3 class="login-title">Iniciar Sesión</h3>

        <form method="POST" action="{{ route('login.post') }}">
            @csrf

            <label>Email *</label>
            <input type="email" name="correo" value="{{ old('correo') }}" required>

            <label>Contraseña *</label>
            <input type="password" name="password" required>

            <a href="#" class="forgot">¿Contraseña olvidada?</a>

            <button type="submit" class="btn-login-main">Iniciar sesión</button>
            <button type="button" class="btn-cancel">Cancelar</button>

            <p class="register-text">
                ¿Eres nuevo? <a href="{{ route('registro') }}">Regístrate aquí</a>
            </p>
        </form>

    </div>
</div>

@endsection
