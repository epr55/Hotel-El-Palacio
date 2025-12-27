@extends('layouts.master')

@section('title', 'Login')

@section('content')

<div class="login-wrapper">
    <div class="login-box">

        <h3 class="login-title">Iniciar Sesión</h3>

        <form>

            <label>Email *</label>
            <input type="email" placeholder="email@address.com" required>

            <label>Contraseña *</label>
            <input type="password" placeholder="************" required>

            <a href="#" class="forgot">¿Contraseña olvidada?</a>

            <button type="submit" class="btn-login-main">Iniciar sesión</button>
            <button type="button" class="btn-cancel">Cancelar</button>

            <p class="register-text">
                ¿Eres nuevo? <a href="#">Regístrate aquí</a>
            </p>

        </form>

    </div>
</div>

@endsection
