@extends('layouts.master')

@section('title', 'Detalles de la Habitación')

@section('content')

<style>
    .detalles-container {
        max-width: 1200px;
        margin: 50px auto;
        padding: 0 24px 80px;
    }

    .top-actions {
        margin-bottom: 25px;
        display: flex;
        justify-content: flex-start;
    }

    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 10px 18px;
        border-radius: 12px;
        background: #F4F4F5;
        color: #444;
        font-weight: 700;
        text-decoration: none;
        border: 1.5px solid #d1d5db;
        transition: all .2s ease;
    }

    .btn-back:hover {
        background: #E5E7EB;
        transform: translateY(-1px);
    }

    .detalles-title {
        font-size: 2.4rem;
        font-weight: 800;
        margin-bottom: 34px;
        color: #1A1A1A;
        text-align: center;
        line-height: 1.15;
    }

    .detalles-grid {
        display: grid;
        grid-template-columns: 2.2fr 1.3fr;
        gap: 28px;
        align-items: start;
    }

    .card {
        background: white;
        border-radius: 22px;
        padding: 28px;
        box-shadow: 0 15px 45px rgba(0,0,0,0.08);
        border: 1px solid #eee;
    }

    .card-title {
        font-size: 1.35rem;
        font-weight: 900;
        margin-bottom: 18px;
        color: #333;
    }

    .habitacion-layout {
        display: grid;
        grid-template-columns: 260px 1fr;
        gap: 26px;
        align-items: start;
    }

    .habitacion-img {
        width: 260px;
        height: 260px;
        border-radius: 18px;
        background: #f3f3f3;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        font-size: 3.5rem;
        box-shadow: 0 12px 30px rgba(0,0,0,0.10);
        border: 1px solid #ececec;
    }

    .habitacion-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .habitacion-info {
        display: flex;
        flex-direction: column;
        gap: 12px;
        min-width: 0;
    }

    .habitacion-info h4 {
        font-size: 1.45rem;
        font-weight: 900;
        margin: 0;
        color: #1A1A1A;
    }

    .info-list {
        display: grid;
        gap: 10px;
        margin-top: 2px;
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        gap: 14px;
        padding: 10px 12px;
        border-radius: 14px;
        background: #FAFAFA;
        border: 1px solid #ededed;
        font-size: 1.02rem;
        color: #444;
    }

    .info-row strong {
        color: #222;
        white-space: nowrap;
    }

    .info-row span {
        text-align: right;
        color: #555;
        font-weight: 600;
    }

    .badges {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 2px;
    }

    .badge {
        padding: 8px 14px;
        border-radius: 999px;
        font-size: 0.9rem;
        font-weight: 800;
        background: #FEF7EC;
        color: #8A6A1A;
        border: 1px solid #E6C27A;
    }

    .extra-block {
        margin-top: 18px;
        padding-top: 16px;
        border-top: 1px solid #eee;
    }

    .extra-title {
        font-size: 1.05rem;
        font-weight: 900;
        color: #333;
        margin-bottom: 10px;
    }

    .comentarios-list {
        display: grid;
        gap: 12px;
    }

    .comentario {
        background: #FFF6E8;
        border: 1px solid #F0D9B8;
        border-radius: 16px;
        padding: 12px 14px;
    }

    .comentario-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        margin-bottom: 6px;
        font-size: 0.92rem;
        color: #6F540F;
        font-weight: 800;
    }

    .comentario-text {
        margin: 0;
        color: #4a4a4a;
        font-size: 0.98rem;
        line-height: 1.35;
    }

    .comentario-fecha {
        font-weight: 700;
        color: #8A6A1A;
        font-size: 0.85rem;
        white-space: nowrap;
    }

    .servicios-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 12px;
    }

    .servicio-card {
        background: #FAFAFA;
        border-radius: 18px;
        padding: 14px 14px;
        border: 1.5px solid #e0e0e0;
        text-align: left;
        font-size: 1rem;
        font-weight: 800;
        color: #333;
        display: grid;
        gap: 6px;
        transition: transform .18s ease, box-shadow .18s ease, border-color .18s ease;
    }

    .servicio-card:hover {
        transform: translateY(-1px);
        box-shadow: 0 12px 28px rgba(0,0,0,0.10);
        border-color: #D39D55;
        background: #FFFDF9;
    }

    .servicio-line {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }

    .servicio-nombre {
        font-weight: 900;
        color: #222;
    }

    .servicio-pill {
        padding: 6px 10px;
        border-radius: 999px;
        font-size: 0.85rem;
        font-weight: 900;
        background: #FEF7EC;
        border: 1px solid #E6C27A;
        color: #6F540F;
        white-space: nowrap;
    }

    .servicio-precio {
        font-size: 0.95rem;
        color: #444;
        font-weight: 800;
    }

    .servicio-sub {
        font-size: 0.9rem;
        color: #777;
        font-weight: 600;
    }

    @media (max-width: 950px) {
        .detalles-grid {
            grid-template-columns: 1fr;
        }

        .habitacion-layout {
            grid-template-columns: 1fr;
        }

        .habitacion-img {
            width: 260px;
            height: 260px;
            margin: 0 auto;
        }

        .info-row span {
            text-align: left;
        }
    }

    .reserva-cta {
        margin-top: 20px;
        padding: 16px 18px;
        border-radius: 18px;
        background: linear-gradient(135deg, #D39D55, #C48C44);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 14px;
        cursor: pointer;
        text-decoration: none;
        font-weight: 900;
        box-shadow: 0 14px 32px rgba(211,157,85,0.35);
        transition: all .22s ease;
    }

    .reserva-cta:hover {
        transform: translateY(-2px);
        box-shadow: 0 18px 40px rgba(211,157,85,0.45);
        background: linear-gradient(135deg, #C48C44, #B8833E);
    }

    .reserva-cta-left {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .reserva-cta-title {
        font-size: 1.05rem;
        letter-spacing: 0.2px;
    }

    .reserva-cta-sub {
        font-size: 0.9rem;
        font-weight: 700;
        opacity: 0.9;
    }

    .reserva-cta-action {
        font-size: 1.15rem;
        font-weight: 900;
        white-space: nowrap;
    }
</style>

<div class="detalles-container">

    <div class="top-actions">
        <a href="{{ route('home') }}" class="btn-back">
            Atras
        </a>
    </div>

    <h2 class="detalles-title">
        {{ $habitacion->categoria->nombre }} · Habitación {{ $habitacion->numero }}
    </h2>

    <div class="detalles-grid">
        <div class="card">
            <h3 class="card-title">Información de la habitación</h3>

            <div class="habitacion-layout">
                <div class="habitacion-img">
                    @if($habitacion->imagen)
                        <img src="{{ asset($habitacion->imagen) }}" alt="Habitación {{ $habitacion->numero }}">
                    @else
                        🏨
                    @endif
                </div>

                <div class="habitacion-info">
                    <h4>{{ $habitacion->categoria->nombre }}</h4>

                    <div class="info-list">
                        <div class="info-row">
                            <strong>Precio</strong>
                            <span>{{ number_format($habitacion->precio, 2) }} € / noche</span>
                        </div>

                        <div class="info-row">
                            <strong>Capacidad</strong>
                            <span>{{ $habitacion->categoria->capacidad }} personas</span>
                        </div>

                        @if($habitacion->camas_individual > 0)
                            <div class="info-row">
                                <strong>Camas individuales</strong>
                                <span>{{ $habitacion->camas_individual }}</span>
                            </div>
                        @endif

                        @if($habitacion->camas_doble > 0)
                            <div class="info-row">
                                <strong>Camas dobles</strong>
                                <span>{{ $habitacion->camas_doble }}</span>
                            </div>
                        @endif

                        <div class="info-row">
                            <strong>Aseos</strong>
                            <span>{{ $habitacion->aseos }} {{ $habitacion->aseos == 1 ? 'aseo' : 'aseos' }}</span>
                        </div>
                    </div>

                    <div class="badges">
                        @if($habitacion->balcon)<span class="badge">🌅 Balcón</span>@endif
                        @if($habitacion->escritorio)<span class="badge">💼 Escritorio</span>@endif
                        @if($habitacion->cuna)<span class="badge">👶 Cuna</span>@endif
                    </div>
                    <a class="reserva-cta" href="{{ route('reserva.completar', $habitacion->id) }} ?checkin={{ request('checkin') }} &checkout={{ request('checkout') }} &huespedes={{ request('huespedes', $habitacion->categoria->capacidad) }}">
                        <div class="reserva-cta-left">
                            <div class="reserva-cta-title">
                                Reserva esta habitación
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="card">
            <h3 class="card-title">Servicios disponibles</h3>

            @if($servicios->count())
                <div class="servicios-grid">
                    @foreach($servicios as $servicio)
                        @php
                            $tipo = str_replace('_', ' ', $servicio->tipo_cobro);
                        @endphp

                        <div class="servicio-card">
                            <div class="servicio-line">
                                <div class="servicio-nombre">{{ $servicio->nombre }}</div>
                                <div class="servicio-pill">{{ ucfirst($tipo) }}</div>
                            </div>

                            <div class="servicio-line">
                                <div class="servicio-sub">
                                    {{ $servicio->descripcion ?? 'Servicio disponible para añadir en la reserva.' }}
                                </div>
                                <div class="servicio-precio">
                                    {{ number_format($servicio->precio, 2) }}€
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p style="font-size:0.95rem; color:#777; margin:0;">
                    No hay servicios disponibles actualmente.
                </p>
            @endif
        </div>

    </div>
</div>

@endsection
