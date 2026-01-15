@extends('layouts.master')

@section('title', 'Panel de Administración')

@section('content')

<style>
    .admin-wrapper {
        padding: 40px 20px;
        display: flex;
        justify-content: center;
    }

    .admin-container {
        background-color: #fff;
        padding: 30px 40px;
        border-radius: 15px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.1);
        width: 100%;
        max-width: 1100px;
        border: 1px solid #eee;
    }

    .admin-title {
        color: #D39D55;
        margin-bottom: 30px;
        font-family: 'Mozilla Headline', sans-serif;
        font-size: 1.8rem;
        margin-top: 0;
        
    }

    .admin-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 20px;
    }

    .admin-card {
        border: 1.5px solid #BDC1C7;
        border-radius: 12px;
        padding: 25px;
        text-align: center;
        background: #FFFAF3;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        transition: transform 0.2s, box-shadow 0.2s;
        cursor: pointer;
    }

    .admin-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.12);
    }

    .admin-card h4 {
        color: #1A1A1A;
        margin-bottom: 10px;
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

        <h3 class="admin-title">Panel de Administración</h3>

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

        </div>
    </div>
</div>

@endsection
