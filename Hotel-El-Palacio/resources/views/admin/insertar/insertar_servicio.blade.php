@extends('layouts.master')

@section('title', 'Insertar Servicio')

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

    /*CSS SOLO SERVICIOS*/
    .tipo-cobro-hint {
        font-size: 0.85rem;
        color: #666;
        margin-top: 4px;
    }
</style>

<div class="form-wrapper">
    <div class="form-container">

        <h3 class="form-title">Insertar Servicio</h3>

        <form action="{{ route('admin.insertar.servicio') }}" method="POST">
            @csrf

            <div class="form-group">
                <label>Nombre</label>
                <input type="text" name="nombre" class="form-control" value="{{ old('nombre') }}" required>
            </div>

            <div class="form-group">
                <label>Precio (€)</label>
                <input type="number" step="0.01" name="precio" class="form-control" value="{{ old('precio') }}" required>
            </div>

            <div class="form-group">
                <label>Tipo de cobro</label>
                <select name="tipo_cobro" class="form-control" required>
                    <option value="">Seleccione un tipo</option>

                    <option value="por_persona_noche"
                        {{ old('tipo_cobro') == 'por_persona_noche' ? 'selected' : '' }}>
                        Por persona y noche
                    </option>

                    <option value="por_noche"
                        {{ old('tipo_cobro') == 'por_noche' ? 'selected' : '' }}>
                        Por noche
                    </option>

                    <option value="personalizable_por_persona"
                        {{ old('tipo_cobro') == 'personalizable_por_persona' ? 'selected' : '' }}>
                        Por persona (personalizable)
                    </option>

                    <option value="unico"
                        {{ old('tipo_cobro') == 'unico' ? 'selected' : '' }}>
                        Pago único
                    </option>
                </select>
                <div class="tipo-cobro-hint">
                    Define cómo se aplica el precio del servicio
                </div>
            </div>

            <div class="form-group">
                <label>Descripción</label>
                <textarea name="descripcion" class="form-control" rows="4">{{ old('descripcion') }}</textarea>
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
