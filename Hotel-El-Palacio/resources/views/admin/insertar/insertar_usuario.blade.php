@extends('layouts.master')

@section('title', 'Insertar Usuario')

@section('content')

<style>
    /*CSS GENERICO FORMULARIOS*/
    .form-wrapper {
        padding: 40px 20px;
        display: flex;
        justify-content: center;
    }

    .form-container {
        background-color: #fff;
        padding: 45px 50px;
        border-radius: 18px;
        box-shadow: 0 15px 45px rgba(0,0,0,0.12);
        width: 100%;
        max-width: 760px;
        border: 1px solid #eee;
    }


    .form-title {
        color: #D39D55;
        font-family: 'Mozilla Headline', sans-serif;
        font-size: 1.9rem;
        margin-bottom: 35px;
        text-align: center;
    }


    .form-group {
        margin-bottom: 20px;
        text-align: left;
    }

    .form-group label {
        display: block;
        font-weight: 600;
        margin-bottom: 6px;
        color: #1A1A1A;
    }

    .form-control {
        width: 100%;
        padding: 12px 14px;
        border-radius: 12px;
        border: 1.5px solid #e0e0e0;
        font-size: 0.95rem;
        background-color: #FAFAFA;
        transition: border-color 0.2s ease, background-color 0.2s ease;
    }

    .form-control:focus {
        outline: none;
        border-color: #D39D55;
        background-color: #FFF6E8;
    }

    .form-actions {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 14px;
        margin-top: 35px;
    }

    .btn-primary,
    .btn-secondary {
        position: relative;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        height: 44px;
        min-width: 180px;
        padding: 0 22px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.9rem;
        line-height: 1;
        cursor: pointer;
        white-space: nowrap;
        background-color: transparent;
        border: 1.5px solid transparent;
        transition: background-color 0.25s ease, border-color 0.25s ease;
    }

    .btn-primary::after,
    .btn-secondary::after {
        content: '';
        position: absolute;
        left: 50%;
        bottom: 6px;
        width: 0;
        height: 2px;
        transform: translateX(-50%);
        transition: width 0.25s ease;
        border-radius: 2px;
    }

    .btn-primary {
        background-color: #D39D55;
        color: #ffffff;
        border-color: #D39D55;
    }

    .btn-primary::after {
        background-color: #ffffff;
    }

    .btn-primary:hover {
        background-color: #C48C44;
        border-color: #C48C44;
    }


    .btn-primary:hover::after {
        width: 55%;
    }

    .btn-secondary {
        background-color: #F4F4F5;
        color: #444;
        border-color: #d1d5db;
    }

    .btn-secondary::after {
        background-color: #9ca3af;
    }

    .btn-secondary:hover {
        background-color: #E5E7EB;
        border-color: #9ca3af;
    }

    .btn-secondary:hover::after {
        width: 55%;
    }

    /*CSS SOLO PARA USUARIOS*/
    .options-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 14px;
        margin-top: 10px;
    }

    .option-card {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 16px;
        border-radius: 14px;
        border: 2px solid #e0e0e0;
        background-color: #FAFAFA;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .option-card input {
        display: none;
    }

    .rol-user {
        background-color: #F3F4F6;
        color: #374151;
    }
    .option-card:has(input:checked).rol-user {
        background-color: #E5E7EB;
        border-color: #6B7280;
        transform: scale(1.03);
    }

    .rol-recepcionista {
        background-color: #E0F2FE;
        color: #075985;
    }
    .option-card:has(input:checked).rol-recepcionista {
        background-color: #BAE6FD;
        border-color: #0284C7;
        transform: scale(1.05);
        box-shadow: 0 8px 22px rgba(2,132,199,0.35);
    }

    .rol-admin {
        background-color: #fde68a;
        color: #92400e;
        border-color: #facc15;
    }

    .option-card:has(input:checked).rol-admin {
        background-color: #facc15;      /* amarillo más intenso */
        border-color: #eab308;
        transform: scale(1.07);
        box-shadow: 0 10px 30px rgba(234,179,8,0.45);
    }
</style>

<div class="form-wrapper">
    <div class="form-container">
        <h3 class="form-title">Insertar Usuario</h3>

        <form method="POST" action="{{ route('admin.insertar.usuario') }}">
            @csrf

            <div class="form-group">
                <label>Nombre</label>
                <input type="text" name="name" class="form-control"
                       value="{{ old('name') }}" required>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control"
                       value="{{ old('email') }}" required>
            </div>

            <div class="form-group">
            <label>Teléfono</label>
            <input type="text" name="telefono" class="form-control" value="{{ old('telefono') }}">
        </div>


            <div class="form-group">
                <label>Contraseña</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Confirmar contraseña</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Rol del usuario</label>

                <div class="options-grid">
                    <label class="option-card rol-user">
                        <input type="radio" name="rol" value="user" {{ old('rol', 'user') === 'user' ? 'checked' : '' }}>
                        Usuario
                    </label>

                    <label class="option-card rol-recepcionista">
                        <input type="radio" name="rol" value="recepcionista" {{ old('rol') === 'recepcionista' ? 'checked' : '' }}>
                        Recepcionista
                    </label>

                    <label class="option-card rol-admin">
                        <input type="radio" name="rol" value="admin" {{ old('rol') === 'admin' ? 'checked' : '' }}>
                        Administrador
                    </label>
                </div>
            </div>

            <div class="form-actions">
                <button type="button" class="btn-secondary" onclick="window.location='{{ url()->previous() }}'">
                    Cancelar
                </button>

                <button type="submit" class="btn-primary">
                    Insertar
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
