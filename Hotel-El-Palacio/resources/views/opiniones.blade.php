@extends('layouts.master')

@section('title', 'Todas las opiniones')

@section('content')
    <div class="opiniones-page" style="
        padding: 40px 20px;
        background: linear-gradient(135deg, #f5f5f5 0%, #ffffff 100%);
        min-height: 80vh;
    ">
        <div class="container" style="
            max-width: 1100px;
            margin: 0 auto;
        ">
            <div style="margin-bottom: 40px;">
                <a href="{{ route('home') }}" style="
                    color: #D39D55;
                    text-decoration: none;
                    font-size: 1rem;
                    display: inline-flex;
                    align-items: center;
                    gap: 5px;
                ">
                    ← Volver al inicio
                </a>
            </div>

            <div style="
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 20px;
                flex-wrap: wrap;
                gap: 20px;
            ">
                <div>
                    <h1 style="
                        color: #D39D55;
                        font-family: 'Mozilla Headline', sans-serif;
                        font-size: 2.5rem;
                        margin: 0;
                    ">
                        ⭐ Todas las opiniones
                    </h1>
                </div>

                @auth
                    @php
                        $tieneReservaConfirmada = Auth::user()->reservas()
                            ->whereIn('estado', ['confirmada', 'finalizada'])
                            ->exists();
                    @endphp
                    
                    @if($tieneReservaConfirmada)
                        <a href="{{ route('opiniones.crear') }}" style="
                            padding: 12px 25px;
                            background: #E64A19;
                            color: white;
                            text-decoration: none;
                            border-radius: 10px;
                            font-weight: 600;
                            transition: background 0.3s, transform 0.2s;
                            display: inline-flex;
                            align-items: center;
                            gap: 8px;
                            box-shadow: 0 3px 10px rgba(230, 74, 25, 0.3);
                        " class="btn-escribir-opinion">
                            ✍️ Escribe tu opinión
                        </a>
                    @endif
                @endauth
            </div>

            <p style="
                text-align: center;
                color: #666;
                margin-bottom: 50px;
                font-size: 1.1rem;
            ">
                Lee lo que nuestros huéspedes tienen que decir sobre su experiencia
            </p>
            
            @if(session('success'))
                <div style="
                    background: #E8F5E9;
                    border-left: 4px solid #4CAF50;
                    padding: 15px 20px;
                    margin-bottom: 30px;
                    border-radius: 8px;
                    color: #2E7D32;
                    font-weight: 600;
                ">
                    ✓ {{ session('success') }}
                </div>
            @endif
            
            @if(session('error'))
                <div style="
                    background: #FFEBEE;
                    border-left: 4px solid #F44336;
                    padding: 15px 20px;
                    margin-bottom: 30px;
                    border-radius: 8px;
                    color: #C62828;
                    font-weight: 600;
                ">
                    ✗ {{ session('error') }}
                </div>
            @endif

            <div class="comentarios-lista" style="
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
                gap: 30px;
                margin-bottom: 40px;
            ">
                @forelse($comentarios as $comentario)
                    <div class="comentario-card" style="
                        background: white;
                        padding: 30px;
                        border-radius: 15px;
                        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
                        border: 1px solid #eee;
                        transition: transform 0.3s, box-shadow 0.3s;
                    ">
                        <div style="
                            display: flex;
                            justify-content: space-between;
                            align-items: flex-start;
                            margin-bottom: 15px;
                        ">
                            <div class="estrellas" style="
                                color: #FFB900;
                                font-size: 1.4rem;
                            ">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $comentario->valoracion)
                                        ★
                                    @else
                                        ☆
                                    @endif
                                @endfor
                            </div>
                            
                            <div style="
                                color: #999;
                                font-size: 0.9rem;
                            ">
                                {{ \Carbon\Carbon::parse($comentario->fecha)->format('d/m/Y') }}
                            </div>
                        </div>
                        
                        <p style="
                            color: #333;
                            font-size: 1.05rem;
                            line-height: 1.7;
                            margin-bottom: 20px;
                            font-style: italic;
                        ">
                            "{{ $comentario->descripcion }}"
                        </p>
                        
                        <div class="autor" style="
                            display: flex;
                            align-items: center;
                            gap: 10px;
                            flex-wrap: wrap;
                        ">
                            <strong style="
                                color: #D39D55;
                                font-size: 1rem;
                            ">
                                — {{ $comentario->usuario->name ?? 'Usuario' }}
                            </strong>
                            @if($comentario->usuario && $comentario->usuario->reservas()->where('estado', 'confirmada')->exists())
                                <span style="
                                    background: #E8F5E9;
                                    color: #2E7D32;
                                    padding: 4px 12px;
                                    border-radius: 12px;
                                    font-size: 0.85rem;
                                    font-weight: 600;
                                ">
                                    ✓ Cliente confirmado
                                </span>
                            @endif
                        </div>
                    </div>
                @empty
                    <div style="
                        grid-column: 1 / -1;
                        text-align: center;
                        padding: 60px 20px;
                        background: white;
                        border-radius: 15px;
                        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
                    ">
                        <p style="
                            color: #999;
                            font-size: 1.2rem;
                        ">
                            No hay opiniones disponibles en este momento.
                        </p>
                    </div>
                @endforelse
            </div>

            <!-- Paginación -->
            @if($comentarios->hasPages())
                <div style="
                    display: flex;
                    justify-content: center;
                    margin-top: 40px;
                ">
                    <div class="pagination-wrapper">
                        {{ $comentarios->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>

    <style>
        .comentario-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.12);
        }
        
        .btn-escribir-opinion:hover {
            background: #D84315;
            transform: scale(1.05);
        }
        
        /* Estilos de paginación mejorados */
        .pagination-wrapper nav {
            display: flex;
            justify-content: center;
        }
        
        .pagination-wrapper .flex {
            display: flex;
            gap: 8px;
            align-items: center;
            flex-wrap: wrap;
        }
        
        .pagination-wrapper p {
            display: none; /* Ocultar el texto "Showing X to Y of Z results" */
        }
        
        .pagination-wrapper a,
        .pagination-wrapper span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 40px;
            height: 40px;
            padding: 8px 12px;
            background: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            color: #333;
            text-decoration: none;
            font-size: 0.95rem;
            transition: all 0.3s;
            box-sizing: border-box;
        }
        
        .pagination-wrapper a:hover {
            background: #E64A19;
            color: white;
            border-color: #E64A19;
            transform: translateY(-2px);
        }
        
        .pagination-wrapper span[aria-current="page"] {
            background: #D39D55;
            color: white;
            border-color: #D39D55;
            font-weight: 600;
        }
        
        .pagination-wrapper span[aria-disabled="true"] {
            opacity: 0.4;
            cursor: not-allowed;
            background: #f5f5f5;
        }
        
        .pagination-wrapper svg {
            width: 16px;
            height: 16px;
        }
        
        /* Ajuste para los botones Previous y Next */
        .pagination-wrapper .relative {
            display: flex;
            gap: 8px;
        }
    </style>
@endsection
