@extends('layouts.master')

@section('title', 'Resultados de Búsqueda')

@section('content')

<style>
    .page-bg {
        background-color: #fcf8f3;
        min-height: 100vh;
        padding-bottom: 50px;
    }

    .hero-search-wrapper {
        padding: 40px 20px 20px;
        display: flex;
        justify-content: center;
    }

    .search-container {
        background-color: #fff;
        padding: 25px 35px;
        border-radius: 15px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.05);
        width: 100%;
        max-width: 1100px;
        border: 1px solid #eee;
    }

    .search-form {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        align-items: flex-end;
    }

    .form-group {
        flex: 1;
        min-width: 200px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #333;
    }

    .form-control {
        width: 100%;
        padding: 12px;
        border: 1px solid #ccc;
        border-radius: 10px;
    }

    .btn-search {
        width: 100%;
        padding: 13px;
        background-color: #E64A19;
        color: white;
        border: none;
        border-radius: 10px;
        font-weight: bold;
        font-size: 1.2rem;
        cursor: pointer;
    }

    .results-container {
        max-width: 1100px;
        margin: 20px auto;
        padding: 0 20px;
    }

    .room-card {
        display: flex;
        background: white;
        border-radius: 14px;
        margin-bottom: 22px;
        box-shadow: 0 6px 20px rgba(0,0,0,0.08);
        overflow: hidden;
        border: 1px solid #e2e2e2;
        transition: transform .2s ease, box-shadow .2s ease;
    }

    .room-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.12);
    }

    .room-image {
        width: 260px;
        min-width: 260px;
        background-color: #f3f3f3;
    }

    .room-info {
        padding: 20px 28px;
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .room-title {
        display: flex;
        align-items: baseline;
        gap: 10px;
    }

    .room-name {
        font-weight: 700;
        font-size: 1.4rem;
        color: #222;
    }

    .room-number {
        color: #999;
        font-size: 0.9rem;
    }

    .room-detail {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #555;
        font-weight: 600;
        font-size: 0.95rem;
    }

    .room-beds {
        display: flex;
        flex-direction: column;
        gap: 4px;
        color: #555;
        font-size: 0.95rem;
    }

    .room-icons {
        display: flex;
        flex-wrap: wrap;
        gap: 14px;
        font-size: 0.85rem;
        color: #777;
        margin-top: 6px;
    }

    .room-icons span {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .room-price {
        margin-top: 10px;
        font-weight: 700;
        font-size: 1.25rem;
        color: #E64A19;
    }

    .room-actions {
        padding: 20px 28px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        gap: 12px;
        background: #fafafa;
        border-left: 1px solid #eee;
    }

    .btn-room {
        background-color: #E64A19;
        color: white;
        text-align: center;
        padding: 10px 22px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 700;
        font-size: 0.9rem;
        transition: background-color .2s ease, transform .1s ease;
    }

    .btn-room:hover {
        background-color: #cf3f13;
        transform: scale(1.02);
    }

    .empty-results {
        text-align: center;
        padding: 60px;
        background: white;
        border-radius: 15px;
        border: 1px solid #eee;
        margin-top: 20px;
        color: #666;
    }
</style>

<div class="page-bg">

    <div class="hero-search-wrapper">
        <div class="search-container">
            <form class="search-form" action="{{ route('busqueda') }}" method="GET">

                <div class="form-group">
                    <label>Check-in</label>
                    <input class="form-control" type="date" name="checkin" value="{{ $checkin }}">
                </div>

                <div class="form-group">
                    <label>Check-out</label>
                    <input class="form-control" type="date" name="checkout" value="{{ $checkout }}">
                </div>

                <div class="form-group">
                    <label>Huéspedes</label>
                    <select class="form-control" name="huespedes">
                        @for ($i = 1; $i <= 5; $i++)
                            <option value="{{ $i }}" {{ (isset($huespedes) && $huespedes == $i) ? 'selected' : '' }}>
                                {{ $i }} {{ $i == 1 ? 'Huésped' : 'Huéspedes' }}
                            </option>
                        @endfor
                    </select>
                </div>

                <div class="form-group" style="flex:0.5; min-width:150px">
                    <button class="btn-search" type="submit">Buscar</button>
                </div>

            </form>
        </div>
    </div>

    <div class="results-container">

        @forelse($habitaciones as $hab)
            <div class="room-card">

                <div class="room-image">
                    @if($hab->imagen)
                        <img src="{{ $hab->imagen }}" alt="Habitación {{ $hab->numero }}">
                    @else
                        <div class="room-image-placeholder">🏨</div>
                    @endif
                </div>

                <div class="room-info">

                    <div class="room-title">
                        <span class="room-name">{{ $hab->categoria->nombre }}</span>
                        <span class="room-number">Habitación {{ $hab->numero }}</span>
                    </div>

                    <div class="room-detail">
                        👤 {{ $hab->categoria->capacidad }} personas
                    </div>

                    @if(($hab->camas_individual ?? 0) > 0 || ($hab->camas_doble ?? 0) > 0)
                        <div class="room-beds">
                            @if($hab->camas_individual > 0)
                                <div>🛏️ {{ $hab->camas_individual }} camas individuales</div>
                            @endif
                            @if($hab->camas_doble > 0)
                                <div>🛌 {{ $hab->camas_doble }} camas dobles</div>
                            @endif
                        </div>
                    @endif

                    <div class="room-icons">
                        <span>🚿 {{ $hab->aseos }} {{ $hab->aseos == 1 ? 'aseo' : 'aseos' }}</span>
                        @if($hab->balcon)<span>🌅 Balcón</span>@endif
                        @if($hab->escritorio)<span>💼 Trabajo</span>@endif
                        @if($hab->cuna)<span>👶 Cuna</span>@endif
                    </div>

                    <div class="room-price">
                        {{ $hab->precio }} € <span style="font-size:0.85rem; font-weight:500; color:#777">/ noche</span>
                    </div>


                </div>

                <div class="room-actions">
                    <a class="btn-room" href="{{ route('reserva.completar', ['habitacion' => $hab->id, 'checkin' => $checkin, 'checkout' => $checkout, 'huespedes' => $huespedes ?? 2]) }}">
                        Ver detalles
                    </a>
                    <a class="btn-room" href="{{ route('reserva.completar', ['habitacion' => $hab->id, 'checkin' => $checkin, 'checkout' => $checkout, 'huespedes' => $huespedes ?? 2]) }}">
                        Reservar ahora
                    </a>
                </div>

            </div>
        @empty
            <div class="empty-results">
                No hay habitaciones disponibles para estas fechas.
            </div>
        @endforelse

    </div>
</div>

@endsection
