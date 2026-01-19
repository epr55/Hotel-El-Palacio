@extends('layouts.master')

@section('title', 'Insertar Reserva')

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

    /*CSS SOLO RESERVA*/
    .options-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 12px;
        margin-top: 10px;
    }

    .option-card {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 14px;
        border-radius: 14px;
        border: 1.5px solid #e0e0e0;
        background-color: #FAFAFA;
        font-weight: 600;
        cursor: pointer;
        transition: transform 0.2s ease, box-shadow 0.2s ease, background-color 0.2s ease, border-color 0.2s ease;
    }

    .option-card input {
        display: none;
    }

    .option-card:has(input:checked) {
        background-color: #FFF6E8;
        border-color: #D39D55;
        color: #6F540F;
    }

    .estado-pendiente {
        background-color: #FEF3C7;
        border-color: #FDE68A;
        color: #92400E;
    }

    .estado-confirmada {
        background-color: #DCFCE7;
        border-color: #86EFAC;
        color: #166534;
    }

    .estado-cancelada {
        background-color: #FEE2E2;
        border-color: #FCA5A5;
        color: #991B1B;
    }

    .option-card:has(input:checked).estado-pendiente {
        background-color: #FDE68A;
        border-color: #F59E0B;
    }

    .option-card:has(input:checked).estado-confirmada {
        background-color: #86EFAC;
        border-color: #16A34A;
    }

    .option-card:has(input:checked).estado-cancelada {
        background-color: #FCA5A5;
        border-color: #DC2626;
    }

    .estado-grid .option-card:has(input:checked) {
        transform: scale(1.06);
        box-shadow: 0 10px 25px rgba(0,0,0,0.22);
        border-width: 2.5px;
    }
</style>

<div class="form-wrapper">
    <div class="form-container">

        <h3 class="form-title">Insertar Reserva</h3>

        <form method="POST" action="{{ route('admin.insertar.reserva') }}">
            @csrf

            <div class="form-group">
                <label>Usuario</label>
                <select name="user_id" class="form-control" required>
                    <option value="">Seleccione un usuario</option>
                    @foreach($usuarios as $usuario)
                        <option value="{{ $usuario->id }}" {{ old('user_id') == $usuario->id ? 'selected' : '' }}>
                            {{ $usuario->name }} ({{ $usuario->correo }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Habitación</label>
                <select name="habitacion_id" class="form-control" required>
                    <option value="">Seleccione una habitación</option>
                    @foreach($habitaciones as $habitacion)
                        <option value="{{ $habitacion->id }}" {{ old('habitacion_id') == $habitacion->id ? 'selected' : '' }}>
                            Habitación {{ $habitacion->numero }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Fecha inicio</label>
                <input type="datetime-local" name="fecha_inicio" class="form-control" value="{{ old('fecha_inicio') }}" required>
            </div>

            <div class="form-group">
                <label>Fecha fin</label>
                <input type="datetime-local" name="fecha_final" class="form-control" value="{{ old('fecha_final') }}" required>
            </div>

            <div class="form-group">
                <label>Estado</label>

                <div class="options-grid estado-grid">
                    <label class="option-card estado-pendiente">
                        <input type="radio" name="estado" value="pendiente"
                            {{ old('estado', 'pendiente') == 'pendiente' ? 'checked' : '' }}>
                        Pendiente
                    </label>

                    <label class="option-card estado-confirmada">
                        <input type="radio" name="estado" value="confirmada"
                            {{ old('estado') == 'confirmada' ? 'checked' : '' }}>
                        Confirmada
                    </label>

                    <label class="option-card estado-cancelada">
                        <input type="radio" name="estado" value="cancelada"
                            {{ old('estado') == 'cancelada' ? 'checked' : '' }}>
                        Cancelada
                    </label>
                </div>
            </div>


            <div class="form-group">
                <label>Servicios contratados</label>
                <div class="options-grid">
                    @foreach($servicios as $servicio)
                        <label class="option-card">
                            <input type="checkbox" name="servicios[]" value="{{ $servicio->id }}" {{ in_array($servicio->id, old('servicios', [])) ? 'checked' : '' }}>
                            {{ $servicio->nombre }}
                        </label>
                    @endforeach
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
