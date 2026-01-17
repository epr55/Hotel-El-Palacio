@extends('layouts.master')

@section('title', 'Disponibilidad por Fecha')

@section('content')

<style>
    .disponibles-wrapper { padding: 40px 20px; max-width: 1300px; margin: 0 auto; }
    
    .fecha-selector {
        background: #fff;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        margin-bottom: 30px;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 20px;
    }

    .btn-nav-fecha {
        background-color: #D39D55;
        color: white;
        width: 45px;
        height: 45px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        font-size: 1.5rem;
        font-weight: bold;
        transition: all 0.3s ease;
        border: none;
    }

    .btn-nav-fecha:hover {
        background-color: #b8864a;
        transform: scale(1.1);
        color: white;
    }

    .fecha-input {
        padding: 10px 15px;
        border: 2px solid #D39D55;
        border-radius: 8px;
        font-size: 1.1rem;
        outline: none;
        text-align: center;
    }

    .modal-input-group {
        text-align: left;
        margin-bottom: 15px;
    }
    .modal-input-group label {
        display: block;
        font-weight: bold;
        margin-bottom: 5px;
        color: #555;
        font-size: 0.9rem;
    }
    .modal-input-group input {
        width: 100%;
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 5px;
    }

    .btn-consultar {
        background-color: #D39D55;
        color: white;
        border: none;
        padding: 11px 20px;
        border-radius: 8px;
        cursor: pointer;
        font-weight: bold;
        transition: background 0.3s;
    }

    .btn-consultar:hover { background-color: #b8864a; }

    .planta-section { background: #fff; border-radius: 15px; padding: 20px; margin-bottom: 30px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border-top: 4px solid #D39D55; }
    .habitaciones-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(120px, 1fr)); gap: 15px; }
    
    .habitacion-item { 
        border-radius: 10px; 
        padding: 15px 10px; 
        text-align: center; 
        color: white; 
        transition: transform 0.2s; 
        border: none;
        cursor: pointer;
        width: 100%;
    }
    .habitacion-item:hover { transform: scale(1.05); }
    
    .status-disponible { background-color: #28a745; }
    .status-ocupada { background-color: #dc3545; }
    .status-mantenimiento { background-color: #ffc107; color: #333; }

    .habitacion-numero { font-weight: bold; font-size: 1.4rem; display: block; }
    .habitacion-tipo { font-size: 0.75rem; text-transform: uppercase; opacity: 0.9; }

    .leyenda { display: flex; gap: 25px; margin-bottom: 30px; justify-content: center; }
    .leyenda-item { display: flex; align-items: center; gap: 10px; font-weight: 500; }
    .color-box { width: 18px; height: 18px; border-radius: 4px; }

    .modal-recepcion {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0; top: 0; width: 100%; height: 100%;
        background-color: rgba(0,0,0,0.5);
        align-items: center;
        justify-content: center;
    }
    .modal-content {
        background-color: white;
        padding: 30px;
        border-radius: 15px;
        width: 100%;
        max-width: 400px;
        text-align: center;
        box-shadow: 0 5px 20px rgba(0,0,0,0.2);
    }
    .btn-opcion {
        display: block;
        width: 100%;
        padding: 12px;
        margin: 10px 0;
        border-radius: 8px;
        text-decoration: none;
        font-weight: bold;
        border: none;
        cursor: pointer;
        font-size: 1rem;
    }
    .btn-block { background-color: #ffc107; color: #333; }
    .btn-cancel { background-color: #dc3545; color: white; }
    .btn-success { background-color: #28a745; color: white; }
    .btn-secondary { background-color: #6c757d; color: white; }
    .quick-reserva { background: #f8f9fa; border: 1px dashed #28a745; padding: 15px; border-radius: 10px; margin-bottom: 20px; }
</style>

<div class="disponibles-wrapper">
    <h2 class="admin-title">Disponibilidad de Habitaciones</h2>

    <div class="fecha-selector">
        <a href="{{ route('recepcionista.disponibles', ['fecha' => $fechaAnterior]) }}" class="btn-nav-fecha">‹</a>

        <form action="{{ route('recepcionista.disponibles') }}" method="GET" id="form-fecha" style="display: flex; gap: 10px; align-items: center;">
            <label for="fecha" style="font-weight: bold; color: #555;">Consultar fecha:</label>
            <input type="date" name="fecha" id="fecha" class="fecha-input" value="{{ $fechaConsulta }}" onchange="this.form.submit()">
            <button type="submit" class="btn-consultar">Actualizar</button>
        </form>

        <a href="{{ route('recepcionista.disponibles', ['fecha' => $fechaSiguiente]) }}" class="btn-nav-fecha">›</a>
    </div>

    <div class="leyenda">
        <div class="leyenda-item"><div class="color-box status-disponible"></div> Disponible</div>
        <div class="leyenda-item"><div class="color-box status-ocupada"></div> Ocupada</div>
        <div class="leyenda-item"><div class="color-box status-mantenimiento"></div> Mantenimiento</div>
    </div>

    @foreach($habitacionesPorPlanta as $planta => $habitaciones)
        <div class="planta-section">
            <h3 style="margin-bottom: 20px; color: #333;">Planta {{ $planta }}</h3>
            <div class="habitaciones-grid">
                @foreach($habitaciones as $hab)
                    <button class="habitacion-item status-{{ $hab->estado_dinamico }}" 
                            onclick="abrirModal('{{ $hab->id }}', '{{ $hab->numero }}', '{{ $hab->estado_dinamico }}', '{{ $hab->reserva_id ?? '' }}', '{{ $hab->categoria->capacidad }}')">
                        <span class="habitacion-numero">{{ $hab->numero }}</span>
                        <span class="habitacion-tipo">{{ $hab->categoria->nombre }}</span>
                    </button>
                @endforeach
            </div>
        </div>
    @endforeach
</div>

<div id="modalGestion" class="modal-recepcion">
    <div class="modal-content">
        <h3 id="modalTitulo" style="margin-bottom: 20px; color: #333;">Habitación</h3>
        <div id="contenedorBotones"></div>
        <button onclick="cerrarModal()" class="btn-opcion btn-secondary">Cerrar</button>
    </div>
</div>

<script>
    function abrirModal(id, numero, estado, reservaId, capacidad) {
        const modal = document.getElementById('modalGestion');
        const titulo = document.getElementById('modalTitulo');
        const contenedor = document.getElementById('contenedorBotones');
        
        const fechaQueEstoyViendo = document.getElementById('fecha').value;

        titulo.innerText = 'Gestión Habitación ' + numero;
        contenedor.innerHTML = '';
        modal.style.display = 'flex';

        if (estado === 'disponible') {
            let d = new Date(fechaQueEstoyViendo);
            d.setDate(d.getDate() + 1);
            let fechaSalidaSugerida = d.toISOString().split('T')[0];

            contenedor.innerHTML = `
                <div class="quick-reserva">
                    <p style="margin-bottom:10px; font-weight:bold; color:#28a745;">Nueva Reserva</p>
                    <div class="modal-input-group">
                        <label>Check-in:</label>
                        <input type="date" id="res_inicio" value="${fechaQueEstoyViendo}">
                    </div>
                    <div class="modal-input-group">
                        <label>Check-out:</label>
                        <input type="date" id="res_fin" value="${fechaSalidaSugerida}">
                    </div>
                    <div class="modal-input-group">
                        <label>Huéspedes (Máx: ${capacidad}):</label>
                        <input type="number" id="res_huespedes" value="1" min="1" max="${capacidad}">
                    </div>
                    <button onclick="irAReserva('${id}')" class="btn-opcion btn-success">Continuar Reserva</button>
                </div>

                <hr>

                <form action="{{ route('recepcionista.cambiarEstado') }}" method="POST">
                    @csrf
                    <input type="hidden" name="habitacion_id" value="${id}">
                    <input type="hidden" name="estado" value="mantenimiento">
                    
                    <div class="modal-input-group">
                        <label>Inicio Bloqueo:</label>
                        <input type="date" name="fecha_inicio" value="${fechaQueEstoyViendo}" required>
                    </div>
                    <div class="modal-input-group">
                        <label>Fin Bloqueo:</label>
                        <input type="date" name="fecha_final" value="${fechaQueEstoyViendo}" required>
                    </div>

                    <button type="submit" class="btn-opcion btn-block">Bloquear por Mantenimiento</button>
                </form>
            `;
        } else if (estado === 'ocupada') {
            contenedor.innerHTML = `
                <form action="{{ route('recepcionista.cancelarReserva') }}" method="POST" onsubmit="return confirm('¿Seguro que quieres cancelar esta reserva?')">
                    @csrf
                    <input type="hidden" name="reserva_id" value="${reservaId}">
                    <button type="submit" class="btn-opcion btn-cancel">Cancelar Reserva Actual</button>
                </form>
                <hr>
                <form action="{{ route('recepcionista.cambiarEstado') }}" method="POST">
                    @csrf
                    <input type="hidden" name="habitacion_id" value="${id}">
                    <input type="hidden" name="estado" value="mantenimiento">
                    
                    <div class="modal-input-group">
                        <label>Inicio Mantenimiento:</label>
                        <input type="date" name="fecha_inicio" value="${fechaQueEstoyViendo}" required>
                    </div>
                    <div class="modal-input-group">
                        <label>Fin Mantenimiento:</label>
                        <input type="date" name="fecha_final" value="${fechaQueEstoyViendo}" required>
                    </div>

                    <button type="submit" class="btn-opcion btn-block">Forzar Mantenimiento</button>
                </form>
            `;
        } else if (estado === 'mantenimiento') {
            contenedor.innerHTML = `
                <form action="{{ route('recepcionista.cambiarEstado') }}" method="POST">
                    @csrf
                    <input type="hidden" name="habitacion_id" value="${id}">
                    <input type="hidden" name="estado" value="disponible">
                    
                    <input type="hidden" name="fecha_inicio" value="${fechaQueEstoyViendo}">
                    
                    <p style="margin-bottom:15px; color:#666;">La habitación está bloqueada para el día ${fechaQueEstoyViendo}.</p>
                    <button type="submit" class="btn-opcion btn-success">Eliminar Bloqueo</button>
                </form>
            `;
        }
    }

    function irAReserva(habId) {
        const inicio = document.getElementById('res_inicio').value;
        const fin = document.getElementById('res_fin').value;
        const huespedes = document.getElementById('res_huespedes').value;
        
        if(!inicio || !fin || !huespedes) {
            alert('Por favor selecciona fechas y número de huéspedes.');
            return;
        }

        window.location.href = `/reserva/completar/${habId}?fecha_inicio=${inicio}&fecha_final=${fin}&huespedes=${huespedes}`;
    }

    function cerrarModal() {
        document.getElementById('modalGestion').style.display = 'none';
    }

    window.onclick = function(event) {
        if (event.target == document.getElementById('modalGestion')) {
            cerrarModal();
        }
    }
</script>

@endsection