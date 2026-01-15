@extends('layouts.master')

@section('title', $success ? 'Pago Exitoso' : 'Error en el Pago')

@section('content')

<style>
    .resultado-container {
        max-width: 700px;
        margin: 80px auto;
        padding: 40px;
        text-align: center;
    }

    .resultado-card {
        background: white;
        border-radius: 20px;
        padding: 50px 40px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
    }

    .resultado-icono {
        font-size: 5rem;
        margin-bottom: 20px;
    }

    .resultado-titulo {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 20px;
        color: {{ $success ? '#27ae60' : '#e74c3c' }};
    }

    .resultado-mensaje {
        font-size: 1.1rem;
        color: #555;
        margin-bottom: 30px;
        line-height: 1.6;
    }

    .resultado-detalles {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 25px;
        margin: 30px 0;
        text-align: left;
    }

    .detalle-linea {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid #e0e0e0;
    }

    .detalle-linea:last-child {
        border-bottom: none;
    }

    .detalle-label {
        font-weight: 600;
        color: #333;
    }

    .detalle-valor {
        color: #666;
    }

    .btn-volver {
        display: inline-block;
        padding: 14px 40px;
        background-color: #E64A19;
        color: white;
        text-decoration: none;
        border-radius: 10px;
        font-size: 1rem;
        font-weight: 600;
        transition: background-color .2s ease, transform .1s ease;
    }

    .btn-volver:hover {
        background-color: #cf3f13;
        transform: translateY(-2px);
        color: white;
    }
</style>

<div class="resultado-container">
    <div class="resultado-card">
        
        <div class="resultado-icono">
            @if($success)
                ✅
            @else
                ❌
            @endif
        </div>

        <h2 class="resultado-titulo">
            @if($success)
                ¡Pago Completado!
            @else
                Error en el Pago
            @endif
        </h2>

        <p class="resultado-mensaje">{{ $mensaje }}</p>

        @if($success && isset($reserva))
            <div class="resultado-detalles">
                <h3 style="margin-bottom: 20px; color: #333;">Detalles de tu Reserva</h3>
                
                <div class="detalle-linea">
                    <span class="detalle-label">Habitación:</span>
                    <span class="detalle-valor">#{{ $reserva['habitacion_id'] }}</span>
                </div>

                <div class="detalle-linea">
                    <span class="detalle-label">Check-in:</span>
                    <span class="detalle-valor">{{ \Carbon\Carbon::parse($reserva['checkin'])->format('d/m/Y') }}</span>
                </div>

                <div class="detalle-linea">
                    <span class="detalle-label">Check-out:</span>
                    <span class="detalle-valor">{{ \Carbon\Carbon::parse($reserva['checkout'])->format('d/m/Y') }}</span>
                </div>

                <div class="detalle-linea">
                    <span class="detalle-label">Huéspedes:</span>
                    <span class="detalle-valor">{{ $reserva['huespedes'] }}</span>
                </div>

                <div class="detalle-linea">
                    <span class="detalle-label">Total pagado:</span>
                    <span class="detalle-valor" style="font-weight: 700; color: #E64A19;">{{ $reserva['importe'] }}€</span>
                </div>
            </div>

            <p style="font-size: 0.9rem; color: #777; margin-bottom: 30px;">
                Recibirás un correo de confirmación con todos los detalles de tu reserva.
            </p>
        @endif

        <a href="{{ route('home') }}" class="btn-volver">
            Volver al Inicio
        </a>

    </div>
</div>

@endsection
