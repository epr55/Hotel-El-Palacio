@extends('layouts.master')

@section('title', 'Registro')

@section('content')

<div class="login-wrapper">
    <div class="login-box register-box">

        <h3 class="login-title">Registro</h3>

        <p class="text-muted small text-center mb-3">* Campos obligatorios</p>

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>¡Ups! Hay algunos errores:</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('registro.store') }}" method="POST">
            @csrf

            <label>Nombre *</label>
            <input type="text" name="nombre" placeholder="Nombre" value="{{ old('nombre') }}" 
                   class="@error('nombre') is-invalid @enderror" required>
            @error('nombre')
                <span class="text-danger small">{{ $message }}</span>
            @enderror

            <label>Email *</label>
            <input type="email" name="correo" placeholder="email@address.com" value="{{ old('correo') }}" 
                   class="@error('correo') is-invalid @enderror" 
                   pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" 
                   title="Introduce un email válido (ejemplo@dominio.com)" required>
            @error('correo')
                <span class="text-danger small">{{ $message }}</span>
            @enderror

            <label>Teléfono</label>
            <input type="tel" name="telefono" placeholder="123456789 o +34123456789" value="{{ old('telefono') }}" 
                   class="@error('telefono') is-invalid @enderror"
                   pattern="[+]?[0-9]{9,15}" 
                   title="Introduce un teléfono válido (9-15 dígitos, puede empezar con +)">
            @error('telefono')
                <span class="text-danger small">{{ $message }}</span>
            @enderror

            <label>Contraseña *</label>
            <input type="password" name="password" 
                   class="@error('password') is-invalid @enderror" required>
            @error('password')
                <span class="text-danger small">{{ $message }}</span>
            @enderror

            <label>Confirmar contraseña *</label>
            <input type="password" name="password_confirmation" required>

            <div class="terms">
                <input type="checkbox" id="terms" required>
                <label for="terms" style="cursor: pointer;">Acepto los Términos de Servicio y la Política de Privacidad</label>
            </div>

            <div class="row-2-buttons">
                <button type="submit" class="btn-login-main">Registrar</button>
                <button type="button" class="btn-cancel" onclick="window.location.href='{{ route('home') }}'">Cancelar</button>
            </div>

            <p class="register-text">
                ¿Ya tienes cuenta? <a href="{{ route('login') }}">Iniciar sesión</a>
            </p>

        </form>

    </div>
</div>

@endsection
