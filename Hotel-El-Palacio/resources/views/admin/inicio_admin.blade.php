@extends('layouts.master')

@section('title', 'Panel de Administración')

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
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 20px;
    }

    .admin-card {
        border: 1.5px solid #BDC1C7;
        border-radius: 14px;
        padding: 32px 25px;
        min-height: 140px;
        text-align: center;
        background: #FFFAF3;
        box-shadow: 0 6px 18px rgba(0,0,0,0.1);
        position: relative;
        transition: box-shadow 0.3s ease, border-color 0.3s ease, background-color 0.3s ease;
        cursor: pointer;
    }

    .admin-card:hover {
        border-color: #D39D55;
        background-color: #FFF6E8;
        box-shadow: 0 10px 30px rgba(211,157,85,0.18);
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
        font-size: 1.15rem;
        margin-bottom: 12px;
    }

    .admin-card p {
        color: #666;
        font-size: 0.90rem;
        margin: 0;
    }

    .admin-link {
        text-decoration: none;
    }
</style>

<div class="admin-wrapper">
    <div class="admin-container">

        <h3 class="admin-title">Panel de Administración</h3>
        <p class="admin-subtitle">
            Gestiona todos los elementos del hotel desde un único panel
        </p>

        <hr class="admin-divider">

        <div class="admin-grid">

            <a href="{{ route('admin.usuarios') }}" class="admin-link">
                <div class="admin-card">
                    <h4>Usuarios</h4>
                    <p>Gestión de usuarios</p>
                </div>
            </a>

            <a href="{{ route('admin.habitaciones') }}" class="admin-link">
                <div class="admin-card">
                    <h4>Habitaciones</h4>
                    <p>Gestion de habitaciones</p>
                </div>
            </a>

            <a href="{{ route('admin.reservas') }}" class="admin-link">
                <div class="admin-card">
                    <h4>Reservas</h4>
                    <p>Gestion de reservas</p>
                </div>
            </a>

            <a href="{{ route('admin.comentarios') }}" class="admin-link">
                <div class="admin-card">
                    <h4>Comentarios</h4>
                    <p>Gestion de comentarios</p>
                </div>
            </a>

            <a href="{{ route('admin.categorias') }}" class="admin-link">
                <div class="admin-card">
                    <h4>Categorías</h4>
                    <p>Gestión de categorías</p>
                </div>
            </a>

            <a href="{{ route('admin.mantenimientos') }}" class="admin-link">
                <div class="admin-card">
                    <h4>Mantenimientos</h4>
                    <p>Gestión de mantenimientos</p>
                </div>
            </a>

            <a href="{{ route('admin.temporadas') }}" class="admin-link">
                <div class="admin-card">
                    <h4>Temporadas</h4>
                    <p>Gestión de temporadas</p>
                </div>
            </a>

            <a href="{{ route('admin.servicios') }}" class="admin-link">
                <div class="admin-card">
                    <h4>Servicios</h4>
                    <p>Gestión de servicios</p>
                </div>
            </a>
        </div>
    </div>
</div>

@endsection
