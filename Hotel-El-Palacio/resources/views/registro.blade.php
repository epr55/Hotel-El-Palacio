@extends('layouts.master')

@section('title', 'Registro')

@section('content')

<div class="login-wrapper">
    <div class="login-box register-box">

        <h3 class="login-title">Registro</h3>

        <form>

            <div class="row-2">
                <div>
                    <label>Nombre</label>
                    <input type="text" placeholder="Nombre">
                </div>
                <div>
                    <label>Apellido</label>
                    <input type="text" placeholder="Apellido">
                </div>
            </div>

            <label>Email</label>
            <input type="email" placeholder="email@address.com">

            <label>Teléfono</label>
            <input type="tel" placeholder="123 456 789">

            <label>Contraseña</label>
            <input type="password" placeholder="************">

            <div class="terms">
                <input type="checkbox">
                <span>Acepto los términos y condiciones</span>
            </div>

            <div class="row-2-buttons">
                <button class="btn-login-main">Añadir Usuario</button>
                <button type="button" class="btn-cancel">Cancelar</button>
            </div>

            <p class="register-text">
                ¿Ya tienes cuenta? <a href="{{ route('login') }}">Iniciar sesión</a>
            </p>

        </form>

    </div>
</div>

@endsection
