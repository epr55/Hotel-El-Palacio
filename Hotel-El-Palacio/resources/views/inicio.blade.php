@extends('layouts.master')

@section('title', 'Inicio')

@section('content')
    <div class="hero-search-wrapper" style="
        padding: 40px 20px; 
        display: flex; 
        justify-content: center;
    ">
        <div class="search-container" style="
            background-color: #fff;
            padding: 25px 35px;
            border-radius: 15px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 1100px;
            border: 1px solid #eee;
        ">
            <h3 style="
                color: #D39D55; 
                margin-bottom: 20px; 
                font-family: 'Mozilla Headline', sans-serif; 
                font-size: 1.6rem;
                margin-top: 0;
            ">
                Encuentra tu habitación perfecta
            </h3>

            <form action="{{ route('busqueda') }}" method="GET" style="
                display: flex; 
                flex-wrap: wrap; 
                gap: 20px; 
                align-items: flex-end;
            ">
                <div style="flex: 1; min-width: 200px;">
                    <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">Check-in</label>
                    <input type="date" name="checkin" value="2025-12-27" style="
                        width: 100%; 
                        padding: 12px; 
                        border: 1px solid #ccc; 
                        border-radius: 10px;
                        font-size: 1rem;
                    ">
                </div>

                <div style="flex: 1; min-width: 200px;">
                    <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">Check-out</label>
                    <input type="date" name="checkout" value="2026-01-02" style="
                        width: 100%; 
                        padding: 12px; 
                        border: 1px solid #ccc; 
                        border-radius: 10px;
                        font-size: 1rem;
                    ">
                </div>

                <div style="flex: 1; min-width: 200px;">
                    <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">Huéspedes</label>
                    <select name="huespedes" style="
                        width: 100%; 
                        padding: 12px; 
                        border: 1px solid #ccc; 
                        border-radius: 10px;
                        font-size: 1rem;
                        background-color: white;
                    ">
                        <option value="1">1 Huésped</option>
                        <option value="2">2 Huéspedes</option>
                        <option value="3">3 Huéspedes</option>
                        <option value="4" selected>4 Huéspedes</option>
                    </select>
                </div>

                <div style="flex: 0.5; min-width: 150px;">
                    <button type="submit" style="
                        width: 100%; 
                        padding: 13px; 
                        background-color: #E64A19;
                        color: white; 
                        border: none; 
                        border-radius: 10px; 
                        font-weight: bold; 
                        font-size: 1.2rem;
                        cursor: pointer;
                        transition: background 0.3s;
                    ">
                        Buscar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Sección de Opiniones -->
    <div class="opiniones-wrapper" style="
        padding: 60px 20px;
        background: linear-gradient(135deg, #f5f5f5 0%, #ffffff 100%);
    ">
        <div class="opiniones-container" style="
            max-width: 1100px;
            margin: 0 auto;
        ">
            <h2 style="
                text-align: center;
                color: #D39D55;
                font-family: 'Mozilla Headline', sans-serif;
                font-size: 2.2rem;
                margin-bottom: 15px;
            ">
                ⭐ Opiniones de nuestros huéspedes
            </h2>
            
            <p style="
                text-align: center;
                color: #666;
                margin-bottom: 40px;
                font-size: 1.1rem;
            ">
                Experiencias reales de clientes que han disfrutado de nuestro servicio
            </p>

            <div class="comentarios-grid" style="
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
                gap: 25px;
                margin-bottom: 35px;
            ">
                @forelse($comentariosDestacados as $comentario)
                    <div class="comentario-card" style="
                        background: white;
                        padding: 30px;
                        border-radius: 15px;
                        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
                        border: 1px solid #eee;
                        transition: transform 0.3s, box-shadow 0.3s;
                    ">
                        <div class="estrellas" style="
                            color: #FFB900;
                            font-size: 1.3rem;
                            margin-bottom: 15px;
                        ">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $comentario->valoracion)
                                    ★
                                @else
                                    ☆
                                @endif
                            @endfor
                        </div>
                        
                        <p style="
                            color: #333;
                            font-size: 1.05rem;
                            line-height: 1.6;
                            margin-bottom: 20px;
                            font-style: italic;
                        ">
                            "{{ $comentario->descripcion }}"
                        </p>
                        
                        <div class="autor" style="
                            display: flex;
                            align-items: center;
                            gap: 10px;
                            color: #666;
                            font-size: 0.95rem;
                        ">
                            <strong style="color: #D39D55;">
                                — {{ $comentario->usuario->name ?? 'Usuario' }}
                            </strong>
                            @if($comentario->usuario && $comentario->usuario->reservas()->where('estado', 'confirmada')->exists())
                                <span style="
                                    background: #E8F5E9;
                                    color: #2E7D32;
                                    padding: 3px 10px;
                                    border-radius: 12px;
                                    font-size: 0.85rem;
                                    font-weight: 600;
                                ">
                                    ✓ Cliente confirmado
                                </span>
                            @endif
                        </div>
                        
                        <div style="
                            margin-top: 12px;
                            color: #999;
                            font-size: 0.85rem;
                        ">
                            {{ \Carbon\Carbon::parse($comentario->fecha)->format('d/m/Y') }}
                        </div>
                    </div>
                @empty
                    <div style="
                        grid-column: 1 / -1;
                        text-align: center;
                        padding: 40px;
                        color: #999;
                    ">
                        <p>No hay opiniones disponibles en este momento.</p>
                    </div>
                @endforelse
            </div>

            <div style="text-align: center;">
                <a href="{{ route('opiniones.todas') }}" style="
                    display: inline-block;
                    padding: 14px 35px;
                    background-color: #E64A19;
                    color: white;
                    text-decoration: none;
                    border-radius: 25px;
                    font-weight: 600;
                    font-size: 1.05rem;
                    transition: background-color 0.3s, transform 0.2s;
                    box-shadow: 0 3px 10px rgba(230, 74, 25, 0.3);
                ">
                    Ver todas las opiniones
                </a>
            </div>
        </div>
    </div>

    <style>
        .comentario-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.12);
        }
        
        a[href="{{ route('opiniones.todas') }}"]:hover {
            background-color: #D84315;
            transform: scale(1.05);
        }
    </style>
@endsection
