@extends('layouts.master')

@section('title', 'Mis Reservas - Hotel El Palacio')

@section('content')
<div style="background-color: #fcf8f3; min-height: 100vh; padding: 40px 20px;">
    <div style="max-width: 1100px; margin: 0 auto;">
        
        <div style="
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        ">
            <div>
                <h1 style="font-family: 'Mozilla Headline', sans-serif; font-weight: bold; color: #1A1A1A; margin-bottom: 5px;">Mis Reservas</h1>
                <p style="color: #666; font-family: 'Mozilla Headline', sans-serif; margin: 0;">Gestiona todas tus reservas</p>
            </div>
            
            @php
                $tieneReservaFinalizada = $reservas->contains(function($reserva) {
                    $final = \Carbon\Carbon::parse($reserva->fecha_final);
                    return $final->isPast() || $reserva->estado == 'finalizada' || $reserva->estado == 'cancelada';
                });
            @endphp
            
            @if($tieneReservaFinalizada)
                <a href="{{ route('opiniones.crear') }}" style="
                    padding: 12px 25px;
                    background: #D39D55;
                    color: white;
                    text-decoration: none;
                    border-radius: 10px;
                    font-weight: 600;
                    font-family: Helvetica, sans-serif;
                    transition: background 0.3s, transform 0.2s;
                    display: inline-flex;
                    align-items: center;
                    gap: 8px;
                    box-shadow: 0 3px 10px rgba(211, 157, 85, 0.3);
                " class="btn-dejar-opinion">
                    ✍️ Dejar opinión
                </a>
            @endif
        </div>

        @forelse($reservas as $reserva)
            @php
                $inicio = \Carbon\Carbon::parse($reserva->fecha_inicio);
                $final = \Carbon\Carbon::parse($reserva->fecha_final);
                $hoy = \Carbon\Carbon::today();
                $noches = $inicio->diffInDays($final);
                
                // Una reserva está finalizada si la fecha final es menor a hoy 
                // o si el estado es 'finalizada' / 'cancelada'
                $esFinalizada = $final->isPast() || $reserva->estado == 'finalizada' || $reserva->estado == 'cancelada';
            @endphp

            <div class="reserva-card" style="background: white; border-radius: 12px; border: 1px solid #BDC1C7; margin-bottom: 25px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.05); opacity: {{ $esFinalizada ? '0.8' : '1' }};">
                
                <div style="padding: 15px 25px; border-bottom: 1px solid #eee; display: flex; justify-content: space-between; align-items: center; background-color: {{ $esFinalizada ? '#f9f9f9' : 'transparent' }};">
                    <div>
                        <span style="font-family: Helvetica, sans-serif; font-weight: bold; font-size: 1.1rem; color: #000;">
                            Habitación {{ $reserva->habitacion->categoria->nombre }}
                        </span>
                        <span style="font-family: 'Mozilla Headline', sans-serif; color: #999; margin-left: 10px;">
                            Habitación {{ $reserva->habitacion->numero }}
                        </span>
                        @if($esFinalizada)
                            <span style="margin-left: 15px; padding: 2px 10px; border-radius: 20px; background: #eee; font-size: 0.75rem; font-weight: bold; color: #777; text-transform: uppercase;">Finalizada</span>
                        @endif
                    </div>
                    <div style="text-align: right;">
                        <div style="font-family: Helvetica, sans-serif; font-weight: bold; font-size: 1.2rem; color: #000;">{{ $reserva->precio_total }}€</div>
                        <div style="font-family: 'Mozilla Headline', sans-serif; font-size: 0.8rem; color: #666; font-weight: bold;">Total</div>
                    </div>
                </div>

                <div style="padding: 20px 25px; display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; border-bottom: 1px solid #eee;">
                    <div style="display: flex; gap: 15px;">
                        <div style="color: #D39D55; font-size: 1.5rem;">📅</div>
                        <div>
                            <div style="font-family: 'Mozilla Headline', sans-serif; color: #999; font-size: 0.85rem; font-weight: bold;">Check-in</div>
                            <div style="font-family: Helvetica; color: #333; font-size: 0.95rem;">{{ $inicio->format('d \d\e F \d\e Y') }}</div>
                            <div style="font-family: Helvetica; color: #333; font-size: 0.9rem;">14:00</div>
                        </div>
                    </div>

                    <div style="display: flex; gap: 15px;">
                        <div style="color: #D39D55; font-size: 1.5rem;">📅</div>
                        <div>
                            <div style="font-family: 'Mozilla Headline', sans-serif; color: #999; font-size: 0.85rem; font-weight: bold;">Check-out</div>
                            <div style="font-family: Helvetica; color: #333; font-size: 0.95rem;">{{ $final->format('d \d\e F \d\e Y') }}</div>
                            <div style="font-family: Helvetica; color: #333; font-size: 0.9rem;">11:00</div>
                        </div>
                    </div>

                    <div style="display: flex; gap: 15px;">
                        <div style="color: #D39D55; font-size: 1.5rem;">🕒</div>
                        <div>
                            <div style="font-family: 'Mozilla Headline', sans-serif; color: #999; font-size: 0.85rem; font-weight: bold;">Duración</div>
                            <div style="font-family: Helvetica; color: #333; font-size: 0.95rem;">{{ $noches }} noches</div>
                            <div style="font-family: Helvetica; color: #333; font-size: 0.9rem;">1 Huésped</div>
                        </div>
                    </div>
                </div>

                <div style="padding: 15px 25px; display: flex; gap: 15px; align-items: center;">
                    
                    @if($esFinalizada)
                        <a href="javascript:void(0)" style="flex: 1; background-color: #E64A19; color: white; text-align: center; padding: 10px; border-radius: 8px; text-decoration: none; font-weight: bold; font-family: Helvetica, sans-serif;">
                            Ver detalles de la estancia
                        </a>
                    @else
                        <a href="{{ route('reserva.completar', ['habitacion' => $reserva->habitacion_id, 'reserva_id' => $reserva->id]) }}" 
                            style="flex: 2; background-color: #E64A19; color: white; text-align: center; padding: 10px; border-radius: 8px; text-decoration: none; font-weight: bold; font-family: Helvetica, sans-serif;">
                            Ver detalles
                        </a>
                        <a href="{{ route('reserva.completar', ['habitacion' => $reserva->habitacion_id, 'reserva_id' => $reserva->id]) }}" 
                            style="flex: 0.6; border: 1px solid #BDC1C7; color: #333; text-align: center; padding: 10px; border-radius: 8px; text-decoration: none; font-weight: bold; font-family: Helvetica; background: #F5F5F5;">
                            Modificar
                        </a>
                        <form action="{{ route('reservas.cancelar', $reserva->id) }}" method="POST" style="flex: 0.6; display: flex;">
                            @csrf
                            <button type="submit" style="width: 100%; border: 1px solid #ff4d4d; color: #ff4d4d; text-align: center; padding: 10px; border-radius: 8px; font-weight: bold; font-family: Helvetica; background: white; cursor: pointer;">
                                Cancelar
                            </button>
                        </form>
                    @endif

                </div>
            </div>
        @empty
            <div style="text-align: center; padding: 60px; background: white; border-radius: 12px; border: 1px solid #BDC1C7;">
                <p style="color: #666;">No tienes ninguna reserva registrada.</p>
            </div>
        @endforelse

    </div>
</div>

<style>
    .btn-dejar-opinion:hover {
        background: #C6903E;
        transform: scale(1.05);
    }
</style>
@endsection