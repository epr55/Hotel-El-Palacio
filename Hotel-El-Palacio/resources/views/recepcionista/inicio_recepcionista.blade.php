@extends('layouts.master')

@section('title', 'Panel de Recepción')

@section('content')

<style>
    .admin-wrapper {
        min-height: calc(100vh - 180px);
        padding: 60px 20px;
        display: flex;
        justify-content: center;
        align-items: flex-start;
    }

    .admin-container {
        background-color: #fff;
        padding: 40px 50px;
        border-radius: 18px;
        box-shadow: 0 12px 40px rgba(0,0,0,0.12);
        width: 100%;
        max-width: 1200px;
        border: 1px solid #eee;
    }

    .admin-title {
        text-align: center;
        color: #D39D55;
        margin-bottom: 30px;
        font-family: 'Mozilla Headline', sans-serif;
        font-size: 1.8rem;
        margin-top: 0;
    }

    .admin-subtitle {
        text-align: center;
        color: #777;
        margin-top: -15px;
        margin-bottom: 35px;
        font-size: 1rem;
    }

    .admin-divider {
        border: none;
        height: 1px;
        background: linear-gradient(to right, transparent, #D39D55, transparent);
        margin-bottom: 35px;
    }

    .admin-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 30px;
        max-width: 800px;
        margin: 0 auto;
    }

    .admin-card {
        border: 1.5px solid #BDC1C7;
        border-radius: 14px;
        padding: 32px 25px;
        min-height: 160px;
        text-align: center;
        background: #FFFAF3;
        box-shadow: 0 6px 18px rgba(0,0,0,0.1);
        position: relative;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .admin-card:hover {
        border-color: #D39D55;
        background-color: #FFF6E8;
        box-shadow: 0 10px 30px rgba(211,157,85,0.18);
        transform: translateY(-5px);
    }

    .admin-card::after {
        content: '';
        position: absolute;
        left: 50%;
        bottom: 10px;
        width: 0;
        height: 2px;
        background-color: #D39D55;
        transition: width 0.3s ease, left 0.3s ease;
        transform: translateX(-50%);
        border-radius: 2px;
    }

    .admin-card:hover::after {
        width: 80%;
    }

    .admin-card h4 {
        color: #1A1A1A;
        font-size: 1.25rem;
        margin-bottom: 15px;
    }

    .admin-card p {
        color: #666;
        font-size: 0.95rem;
        margin: 0;
    }

    .admin-link {
        text-decoration: none;
    }
</style>

<div class="admin-wrapper">
    <div class="admin-container">

        <h3 class="admin-title">Panel de Recepción</h3>
        <p class="admin-subtitle">
            Gestión de disponibilidad y estado de las habitaciones
        </p>

        <hr class="admin-divider">

        <div class="admin-grid">

            <a href="{{ route('recepcionista.disponibles') }}" class="admin-link">
                <div class="admin-card">
                    <h4>Habitaciones Disponibles</h4>
                    <p>Consultar y gestionar las habitaciones listas para ocupar</p>
                </div>
            </a>

            <a href="{{ route('recepcionista.bloqueo') }}" class="admin-link">
                <div class="admin-card">
                    <h4>Bloqueo de Habitaciones</h4>
                    <p>Marcar habitaciones por mantenimiento o limpieza</p>
                </div>
            </a>

        </div>
    </div>
</div>

@endsection