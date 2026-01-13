@extends('layouts.master')

@section('title', 'Login')

@section('content')

<div class="login-wrapper">
    <div class="login-box">

        <h3 class="login-title">Iniciar Sesión</h3>

        <form method="POST" action="{{ route('login.post') }}">
            @csrf

            <label>Email</label>
            <input type="email" name="correo" value="{{ old('correo') }}" 
                   placeholder="email@address.com">

            <label>Contraseña</label>
            <input type="password" name="password" 
                   placeholder="Tu contraseña">

            @if ($errors->any())
                <div class="text-danger small" style="margin-top: 10px; margin-bottom: 10px;">
                    <strong>{{ $errors->first() }}</strong>
                </div>
            @endif

            <button type="submit" class="btn-login-main">Iniciar sesión</button>
            <a href="{{ route('home') }}" style="text-decoration: none;">
                <button type="button" class="btn-cancel">Cancelar</button>
            </a>

            <p class="register-text">
                ¿Eres nuevo? <a href="{{ route('registro') }}">Regístrate aquí</a>
            </p>
        </form>

    </div>
</div>

@endsection
