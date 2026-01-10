@extends('layouts.master')

@section('title', 'Resultados de Búsqueda')

@section('content')
    <div class="hero-search-wrapper" style="
        padding: 0 20px; 
        margin-top: 40px; /* Esto lo baja respecto al navbar */
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
                    <input type="date" name="checkin" value="{{ $checkin }}" style="
                        width: 100%; 
                        padding: 12px; 
                        border: 1px solid #ccc; 
                        border-radius: 10px;
                        font-size: 1rem;
                    ">
                </div>

                <div style="flex: 1; min-width: 200px;">
                    <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">Check-out</label>
                    <input type="date" name="checkout" value="{{ $checkout }}" style="
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
                        <option value="1" {{ $huespedes == 1 ? 'selected' : '' }}>1 Huésped</option>
                        <option value="2" {{ $huespedes == 2 ? 'selected' : '' }}>2 Huéspedes</option>
                        <option value="3" {{ $huespedes == 3 ? 'selected' : '' }}>3 Huéspedes</option>
                        <option value="4" {{ $huespedes == 4 ? 'selected' : '' }}>4 Huéspedes</option>
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
                    ">
                        Buscar
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection