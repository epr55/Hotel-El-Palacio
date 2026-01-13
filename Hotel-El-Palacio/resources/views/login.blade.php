@extends('layouts.master')

@section('title', 'Login')

@section('content')

<div class="login-wrapper">
    <div class="login-box">

        <h3 class="login-title">Iniciar Sesión</h3>

        <p class="text-muted small text-center mb-3">* Campos obligatorios</p>

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Error al iniciar sesión</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login.post') }}">
            @csrf

            <label>Email *</label>
            <input type="email" name="correo" value="{{ old('correo') }}" 
                   class="@error('correo') is-invalid @enderror" required>
            @error('correo')
                <span class="text-danger small">{{ $message }}</span>
            @enderror

            <label>Contraseña *</label>
            <input type="password" name="password" 
                   class="@error('password') is-invalid @enderror" required>
            @error('password')
                <span class="text-danger small">{{ $message }}</span>
            @enderror

            <a href="#" class="forgot">¿Contraseña olvidada?</a>

            <button type="submit" class="btn-login-main">Iniciar sesión</button>
            <button type="button" class="btn-cancel" onclick="window.location.href='{{ route('home') }}'">Cancelar</button>

            <p class="register-text">
                ¿Eres nuevo? <a href="{{ route('registro') }}">Regístrate aquí</a>
            </p>
        </form>

    </div>
</div>

@endsection
