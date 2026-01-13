@extends('layouts.master')

@section('title', 'Resultados de Búsqueda')

@section('content')
<div style="background-color: #fcf8f3; min-height: 100vh; padding-bottom: 50px;">
    
    <div class="hero-search-wrapper" style="padding: 40px 20px 20px 20px; display: flex; justify-content: center;">
        <div class="search-container" style="
            background-color: #fff;
            padding: 25px 35px;
            border-radius: 15px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.05);
            width: 100%;
            max-width: 1100px;
            border: 1px solid #eee;
        ">
            <form action="{{ route('busqueda') }}" method="GET" style="display: flex; flex-wrap: wrap; gap: 20px; align-items: flex-end;">
                <div style="flex: 1; min-width: 200px;">
                    <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">Check-in</label>
                    <input type="date" name="checkin" value="{{ $checkin }}" style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 10px;">
                </div>

                <div style="flex: 1; min-width: 200px;">
                    <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">Check-out</label>
                    <input type="date" name="checkout" value="{{ $checkout }}" style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 10px;">
                </div>

                <div style="flex: 1; min-width: 200px;">
                    <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">Huéspedes</label>
                    <select name="huespedes" style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 10px; background-color: white;">
                        @for ($i = 1; $i <= 5; $i++)
                            <option value="{{ $i }}" {{ (isset($huespedes) && $huespedes == $i) || old('huespedes') == $i ? 'selected' : '' }}>
                                {{ $i }} {{ $i == 1 ? 'Huésped' : 'Huéspedes' }}
                            </option>
                        @endfor
                    </select>
                </div>

                <div style="flex: 0.5; min-width: 150px;">
                    <button type="submit" style="width: 100%; padding: 13px; background-color: #E64A19; color: white; border: none; border-radius: 10px; font-weight: bold; font-size: 1.2rem; cursor: pointer;">
                        Buscar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="results-container" style="max-width: 1100px; margin: 20px auto; padding: 0 20px;">
        
        @forelse($habitaciones as $hab)
            <div class="room-card" style="
                display: flex; 
                background: white; 
                border-radius: 10px; 
                margin-bottom: 15px; 
                box-shadow: 0 2px 10px rgba(0,0,0,0.06); 
                overflow: hidden;
                border: 1px solid #d1d1d1;
                height: 170px; /* Altura reducida para que sea más estrecha */
            ">
                <div style="width: 240px; min-width: 240px; background-color: #f0f0f0; border-right: 1px solid #eee;">
                    <div style="height: 100%; display: flex; align-items: center; justify-content: center; color: #ccc;">
                        <span style="font-size: 2.5rem;">🏨</span>
                    </div>
                </div>

                <div style="padding: 15px 25px; flex: 1; display: flex; flex-direction: column; justify-content: center; gap: 2px;">
                    
                    <div style="display: flex; align-items: baseline; gap: 8px; margin-bottom: 5px;">
                        <span style="font-family: Helvetica, Arial, sans-serif; font-weight: bold; color: black; font-size: 1.3rem;">
                            {{ $hab->categoria->nombre }}
                        </span>
                        <span style="font-family: 'Mozilla Headline', sans-serif; font-weight: normal; color: #999; font-size: 0.95rem;">
                            Habitación {{ $hab->numero }}
                        </span>
                    </div>

                    <div style="display: flex; align-items: center; gap: 8px; color: #666; font-family: 'Mozilla Headline', sans-serif; font-weight: bold; font-size: 0.95rem;">
                        <span style="font-size: 1rem;">👤</span> {{ $hab->categoria->capacidad }} {{ $hab->categoria->capacidad == 1 ? 'persona' : 'personas' }}
                    </div>
                    
                    <div style="display: flex; align-items: center; gap: 8px; color: #666; font-family: 'Mozilla Headline', sans-serif; font-weight: bold; font-size: 0.95rem;">
                        <span style="font-size: 1rem;">🛌️</span> {{ $hab->camas ?? 1 }} {{ ($hab->camas ?? 1) == 1 ? 'cama' : 'camas' }}
                    </div>

                    <div style="font-family: 'Mozilla Headline', sans-serif; font-weight: bold; color: #666; font-size: 1.1rem; margin-top: 5px;">
                        {{ $hab->precio }}€/noche
                    </div>
                </div>

                <div style="padding: 15px 25px; display: flex; flex-direction: column; justify-content: center; gap: 10px;">
                    <a href="{{ route('reserva.completar', ['habitacion' => $hab->id, 'checkin' => $checkin, 'checkout' => $checkout, 'huespedes' => $huespedes ?? 2]) }}" style="
                        background-color: #E64A19; 
                        color: white; 
                        text-align: center; 
                        padding: 8px 20px; 
                        border-radius: 8px; 
                        text-decoration: none; 
                        font-family: Helvetica, sans-serif;
                        font-weight: bold;
                        font-size: 0.9rem;
                        min-width: 150px;
                    ">
                        Ver detalles
                    </a>
                    <a href="{{ route('reserva.completar', ['habitacion' => $hab->id, 'checkin' => $checkin, 'checkout' => $checkout, 'huespedes' => $huespedes ?? 2]) }}" style="
                        background-color: #E64A19; 
                        color: white; 
                        text-align: center; 
                        padding: 8px 20px; 
                        border-radius: 8px; 
                        text-decoration: none; 
                        font-family: Helvetica, sans-serif;
                        font-weight: bold;
                        font-size: 0.9rem;
                        min-width: 150px;
                    ">
                        Reservar ahora
                    </a>
                </div>
            </div>
        @empty
            <div style="text-align: center; padding: 60px; background: white; border-radius: 15px; border: 1px solid #eee; margin-top: 20px; font-family: 'Mozilla Headline', sans-serif; color: #666;">
                <p>No hay habitaciones disponibles para estas fechas.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection