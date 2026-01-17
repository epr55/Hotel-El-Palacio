@extends('layouts.master')

@section('title', 'Gestión de Bloqueos')

@section('content')

<style>
    .bloqueo-wrapper {
        padding: 40px 20px;
        max-width: 1000px;
        margin: 0 auto;
        font-family: 'Segoe UI',
        sans-serif;
    }
    
    .admin-title {
        font-size: 1.8rem;
        font-weight: bold;
        margin-bottom: 25px;
        color: #333;
    }

    .card-bloqueo {
        background: #fff;
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        margin-bottom: 30px;
        border: 1px solid #eee;
    }

    .card-title {
        text-align: center;
        color: #b8864a;
        font-weight: bold;
        margin-bottom: 20px;
        font-size: 1.2rem;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1.5fr 1fr 1fr;
        gap: 15px;
        margin-bottom: 15px;
    }

    .form-group { display: flex; flex-direction: column; }
    .form-group label { font-weight: bold; font-size: 0.85rem; margin-bottom: 5px; color: #555; }

    .form-control {
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 8px;
        font-size: 0.95rem;
        outline: none;
    }
    .form-control:focus { border-color: #D39D55; }

    .btn-aplicar {
        background-color: #e64a19; 
        color: white;
        border: none;
        width: 100%;
        padding: 12px;
        border-radius: 8px;
        font-weight: bold;
        cursor: pointer;
        margin-top: 10px;
        transition: background 0.3s;
        text-transform: uppercase;
        font-size: 0.9rem;
    }
    .btn-aplicar:hover { background-color: #d84315; }

    .active-block-item {
        border: 1px solid #eee;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 15px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #fff;
    }

    .block-info { flex-grow: 1; }
    .block-room { font-weight: bold; color: #333; margin-bottom: 8px; font-size: 1.1rem; display: block; }

    .block-details {
        display: flex;
        gap: 25px;
        font-size: 0.9rem;
        color: #666;
        align-items: center;
    }

    .icon-text { display: flex; align-items: center; gap: 8px; }
    .icon-orange { color: #e64a19; font-size: 1.1rem; }

    .btn-desbloquear {
        background: white;
        color: #dc3545;
        border: 1px solid #dc3545;
        padding: 8px 25px;
        border-radius: 8px;
        cursor: pointer;
        font-weight: bold;
        transition: all 0.3s;
    }
    .btn-desbloquear:hover { background: #dc3545; color: white; }

    .alert-success {
        background: #d4edda;
        color: #155724;
        padding: 15px;
        border-radius: 10px;
        margin-bottom: 20px;
        border: 1px solid #c3e6cb;
    }
</style>

<div class="bloqueo-wrapper"> <h2 class="admin-title">Gestión de Bloqueos</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card-bloqueo">
        <div class="card-title">Bloquear Habitación</div>
        <form action="{{ route('recepcionista.cambiarEstado') }}" method="POST">
            @csrf
            <input type="hidden" name="estado" value="mantenimiento">
            
            <div class="form-grid">
                <div class="form-group">
                    <label>Habitación</label>
                    <select name="habitacion_id" class="form-control" required>
                        <option value="">Seleccionar Habitación...</option>
                        @foreach($habitaciones as $hab)
                            <option value="{{ $hab->id }}">Habitación {{ $hab->numero }} - {{ $hab->categoria->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Fecha Inicio</label>
                    <input type="date" name="fecha_inicio" class="form-control" value="{{ now()->format('Y-m-d') }}" required>
                </div>
                <div class="form-group">
                    <label>Fecha Fin</label>
                    <input type="date" name="fecha_final" class="form-control" required>
                </div>
            </div>

            <div class="form-group" style="margin-top: 15px;">
                <label>Motivo</label>
                <textarea name="motivo" class="form-control" rows="2" placeholder="Mantenimiento aire acondicionado" required></textarea>
            </div>

            <button type="submit" class="btn-aplicar">Aplicar Bloqueo</button>
        </form>
    </div>

    <div class="card-bloqueo">
        <div class="card-title">Bloqueos Activos</div>
        
        @if($mantenimientosActivos->isEmpty())
            <p style="text-align: center; color: #999; padding: 20px;">No hay bloqueos activos en este momento.</p>
        @else
            @foreach($mantenimientosActivos as $mant)
                <div class="active-block-item">
                    <div class="block-info">
                        <span class="block-room">Habitación {{ $mant->habitacion->numero }} - {{ $mant->habitacion->categoria->nombre }}</span>
                        <div class="block-details">
                            <div class="icon-text">
                                <span class="icon-orange">📅</span> 
                                {{ \Carbon\Carbon::parse($mant->fecha_inicio)->format('d M') }} - {{ \Carbon\Carbon::parse($mant->fecha_final)->format('d M Y') }}
                            </div>
                            <div class="icon-text">
                                <span class="icon-orange">⚠️</span> 
                                Motivo: {{ $mant->motivo }}
                            </div>
                            <div class="icon-text">
                                <span class="icon-orange">👤</span> 
                                Por: {{ $mant->user->name ?? 'Sistema' }}
                            </div>
                        </div>
                    </div>
                    
                    <form action="{{ route('recepcionista.cambiarEstado') }}" method="POST">
                        @csrf
                        <input type="hidden" name="habitacion_id" value="{{ $mant->habitacion_id }}">
                        <input type="hidden" name="estado" value="disponible">
                        <input type="hidden" name="fecha_inicio" value="{{ $mant->fecha_inicio->format('Y-m-d') }}"> 
                        <button type="submit" class="btn-desbloquear">Desbloquear</button>
                    </form>
                </div>
            @endforeach
        @endif
    </div>
</div>

@endsection