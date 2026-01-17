@extends('layouts.master')

@section('title', 'Completar Reserva')

@section('content')

<style>
    .reserva-container {
        max-width: 1200px;
        margin: 40px auto;
        padding: 0 20px 60px;
    }

    .reserva-title {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 30px;
        color: #222;
    }

    .reserva-layout {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 30px;
    }

    .card-white {
        background: white;
        border-radius: 16px;
        padding: 25px 30px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.06);
        border: 1px solid #eee;
        margin-bottom: 25px;
    }

    .card-title {
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 20px;
        color: #333;
    }

    .habitacion-detalle {
        display: flex;
        gap: 25px;
    }

    .habitacion-img-placeholder {
        width: 260px;
        min-width: 260px;
        height: 180px;
        background: #f4f4f4;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .habitacion-info h4 {
        font-size: 1.2rem;
        font-weight: 700;
        margin-bottom: 12px;
    }

    .habitacion-info p {
        margin: 4px 0;
        font-size: 0.95rem;
        color: #555;
    }

    .servicio-item {
        display: flex;
        align-items: center;
        margin-bottom: 12px;
    }

    .servicio-checkbox {
        margin-right: 10px;
        transform: scale(1.1);
    }

    .servicio-label {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.95rem;
        cursor: pointer;
        flex-wrap: wrap;
    }

    .servicio-icono {
        font-size: 1.2rem;
    }

    .servicio-nombre {
        font-weight: 600;
    }

    .servicio-precio {
        color: #777;
        font-size: 0.85rem;
    }

    .servicio-cantidad {
        width: 70px;
        padding: 6px 8px;
        margin-left: 12px;
        border: 1px solid #ccc;
        border-radius: 8px;
        font-size: 0.9rem;
        text-align: center;
    }

    .servicio-cantidad:disabled {
        background-color: #f4f4f4;
        color: #999;
        cursor: not-allowed;
    }

    .precio-card {
        position: sticky;
        top: 30px;
    }

    .precio-linea {
        display: flex;
        justify-content: space-between;
        margin: 10px 0;
        font-size: 0.95rem;
        color: #555;
    }

    .precio-divider {
        margin: 20px 0;
        border: none;
        border-top: 1px solid #eee;
    }

    .total-servicios {
        font-weight: 600;
    }

    .precio-total {
        font-size: 1.2rem;
        margin-top: 10px;
        color: #E64A19;
    }

    .btn-confirmar {
        margin-top: 20px;
        width: 100%;
        padding: 14px;
        background-color: #E64A19;
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 1rem;
        font-weight: 700;
        cursor: pointer;
        transition: background-color .2s ease, transform .1s ease;
    }

    .btn-confirmar:hover {
        background-color: #cf3f13;
        transform: translateY(-1px);
    }

    @media (max-width: 900px) {
        .reserva-layout {
            grid-template-columns: 1fr;
        }

        .habitacion-detalle {
            flex-direction: column;
        }

        .habitacion-img-placeholder {
            width: 100%;
            height: 200px;
        }
    }
</style>


<div class="reserva-container">

    <h2 class="reserva-title">Completa tu Reserva</h2>

    <div class="reserva-layout">

        <div class="reserva-left">

            <div class="card-white">
                <h3 class="card-title">Detalles de la Habitación y Servicios</h3>

                <div class="habitacion-detalle">

                    <div class="habitacion-img-placeholder">
                        @if($habitacion->imagen)
                            <img src="{{ asset($habitacion->imagen) }}" alt="Habitación {{ $habitacion->numero }}">
                        @else
                            🏨
                        @endif
                    </div>

                    <div class="habitacion-info">
                        <h4>{{ $habitacion->categoria->nombre }} · Habitación {{ $habitacion->numero }}</h4>

                        <p><strong>Check-in:</strong> {{ \Carbon\Carbon::parse($checkin)->format('d/m/Y') }}</p>
                        <p><strong>Check-out:</strong> {{ \Carbon\Carbon::parse($checkout)->format('d/m/Y') }}</p>
                        <p><strong>Huéspedes:</strong> {{ $huespedes }}</p>

                        @if($habitacion->camas_individual > 0)
                            <p>🛏️ {{ $habitacion->camas_individual }} camas individuales</p>
                        @endif
                        @if($habitacion->camas_doble > 0)
                            <p>🛌 {{ $habitacion->camas_doble }} camas dobles</p>
                        @endif

                        <p><strong>Aseos:</strong> {{ $habitacion->aseos }} {{ $habitacion->aseos == 1 ? 'aseo' : 'aseos' }}</p>

                        @if($habitacion->balcon)<p>🌅 Balcón</p>@endif
                        @if($habitacion->escritorio)<p>💼 Zona de trabajo</p>@endif
                        @if($habitacion->cuna)<p>👶 Cuna disponible</p>@endif

                        <p><strong>Precio base:</strong> {{ $habitacion->precio }} € / noche ({{ $noches }} noches)</p>
                    </div>

                </div>
            </div>

            <div class="card-white">
                <h3 class="card-title">Servicios Extra (Opcional)</h3>

                <form id="servicios-form">
                    @foreach($servicios as $servicio)
                        @php 
                            $estaContratado = isset($serviciosContratadosIds) && in_array($servicio->id, $serviciosContratadosIds);
                        @endphp
                        <div class="servicio-item">
                            <input type="checkbox"
                                   class="servicio-checkbox"
                                   id="servicio-{{ $servicio->id }}"
                                   value="{{ $servicio->id }}"
                                   data-precio="{{ $servicio->precio }}"
                                   data-nombre="{{ $servicio->nombre }}"
                                   data-tipo="{{ $servicio->tipo_cobro }}"
                                   {{ $estaContratado ? 'checked' : '' }}>

                            <label for="servicio-{{ $servicio->id }}" class="servicio-label">
                                <span class="servicio-icono">
                                    @if($servicio->nombre === 'Desayuno buffet') 🍳
                                    @elseif($servicio->nombre === 'Parking privado') 🅿️
                                    @elseif($servicio->nombre === 'Acceso al Spa') 🧖
                                    @elseif($servicio->nombre === 'Traslado al aeropuerto') 🚗
                                    @elseif($servicio->nombre === 'Late check-out') 🕐
                                    @else 🏨
                                    @endif
                                </span>

                                <span class="servicio-nombre">{{ $servicio->nombre }}</span>
                                <span class="servicio-precio">({{ $servicio->precio }}€ {{ $servicio->descripcion }})</span>
                            </label>

                            @if(str_contains($servicio->tipo_cobro, 'personalizable'))
                                <input type="number"
                                    id="cantidad-{{ $servicio->id }}"
                                    class="servicio-cantidad"
                                    min="1"
                                    value="{{ $cantidadesContratadas[$servicio->id] ?? 1 }}"
                                    {{ $estaContratado ? '' : 'disabled' }}
                                    title="Número de personas para el servicio">
                            @endif
                        </div>
                    @endforeach
                </form>
            </div>

        </div>

        <div class="reserva-right">
            <div class="card-white precio-card">
                <h3 class="card-title">Desglose del Precio</h3>

                <div class="precio-linea">
                    <span>Habitación ({{ $noches }} noches)</span>
                    <span id="precio-habitacion">{{ $precioBase }}€</span>
                </div>

                <div id="servicios-seleccionados"></div>

                <hr class="precio-divider">

                <div class="precio-linea total-servicios">
                    <span>Total servicios</span>
                    <span id="total-servicios">0€</span>
                </div>

                <div class="precio-linea precio-total">
                    <strong>Total a pagar</strong>
                    <strong id="total-pagar">{{ $precioBase }}€</strong>
                </div>

                <form id="payment-form" method="POST" action="{{ route('pago.init') }}">
                    @csrf
                    <input type="hidden" name="reserva_id" value="{{ $reservaId ?? '' }}">
                    <input type="hidden" name="importe" id="importe-hidden" value="{{ $precioBase }}">
                    <input type="hidden" name="habitacion_id" value="{{ $habitacion->id }}">
                    <input type="hidden" name="checkin" value="{{ $checkin }}">
                    <input type="hidden" name="checkout" value="{{ $checkout }}">
                    <input type="hidden" name="huespedes" value="{{ $huespedes }}">
                    <input type="hidden" name="servicios" id="servicios-hidden" value="[]">
                    
                    <button class="btn-confirmar" type="submit">
                        {{ isset($reservaId) ? 'Guardar Cambios y Pagar Diferencia' : 'Confirmar Reserva y Pagar' }}
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>

@if(session('error'))
    <div class="alert alert-danger" style="margin: 20px auto; max-width: 1200px;">
        {{ session('error') }}
    </div>
@endif

<div id="reserva-data"
     data-precio-base="{{ $precioBase }}"
     data-noches="{{ $noches }}"
     data-huespedes="{{ $huespedes }}">
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const data = document.getElementById('reserva-data');
        const precioBase = parseFloat(data.dataset.precioBase);
        const noches = parseInt(data.dataset.noches);
        const huespedes = parseInt(data.dataset.huespedes);
        const checkboxes = document.querySelectorAll('.servicio-checkbox');
        const serviciosDiv = document.getElementById('servicios-seleccionados');
        const totalServiciosSpan = document.getElementById('total-servicios');
        const totalPagarSpan = document.getElementById('total-pagar');

        // Habilitar/deshabilitar inputs de cantidad
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const cantidadInput = document.getElementById('cantidad-' + this.value);
                if (cantidadInput) {
                    cantidadInput.disabled = !this.checked;
                    if (this.checked) cantidadInput.focus();
                }
                actualizarPrecios();
            });

            // Agregar listener a inputs de cantidad
            const cantidadInput = document.getElementById('cantidad-' + checkbox.value);
            if (cantidadInput) {
                cantidadInput.addEventListener('input', actualizarPrecios);
            }
        });

        function actualizarPrecios() {
            let totalServicios = 0;
            let serviciosHTML = '';

            checkboxes.forEach(checkbox => {
                if (checkbox.checked) {
                    const precio = parseFloat(checkbox.dataset.precio);
                    const nombre = checkbox.dataset.nombre;
                    const tipo = checkbox.dataset.tipo;
                    let precioTotal = 0;
                    let detalle = '';

                    switch(tipo) {
                        case 'por_persona_noche':
                            // Desayuno: precio x personas x noches
                            precioTotal = precio * huespedes * noches;
                            detalle = `${nombre} (${precio}€ x ${huespedes} pers. x ${noches} noches)`;
                            break;
                        
                        case 'por_noche':
                            // Parking, Cuna: precio x noches
                            precioTotal = precio * noches;
                            detalle = `${nombre} (${precio}€ x ${noches} noches)`;
                            break;
                        
                        case 'personalizable':
                            // Spa: precio x cantidad de sesiones (sin multiplicar por persona)
                            const cantidadInput = document.getElementById('cantidad-' + checkbox.value);
                            const cantidad = cantidadInput ? parseInt(cantidadInput.value) || 1 : 1;
                            precioTotal = precio * cantidad;
                            detalle = `${nombre} (${precio}€ x ${cantidad} sesión${cantidad > 1 ? 'es' : ''})`;
                            break;
                        
                        case 'personalizable_por_persona':
                            // Spa: precio x cantidad de sesiones x personas
                            const cantidadInputPP = document.getElementById('cantidad-' + checkbox.value);
                            const cantidadPP = cantidadInputPP ? parseInt(cantidadInputPP.value) || 1 : 1;
                            precioTotal = precio * cantidadPP * huespedes;
                            detalle = `${nombre} (${precio}€ x ${cantidadPP} sesión${cantidadPP > 1 ? 'es' : ''} x ${huespedes} pers.)`;
                            break;
                        
                        case 'unico':
                            // Traslado, Late checkout: precio fijo
                            precioTotal = precio;
                            detalle = `${nombre}`;
                            break;
                        
                        default:
                            precioTotal = precio;
                            detalle = nombre;
                    }
                    
                    totalServicios += precioTotal;
                    serviciosHTML += `
                        <div class="precio-linea">
                            <span>${detalle}:</span>
                            <span>${precioTotal}€</span>
                        </div>
                    `;
                }
            });

            serviciosDiv.innerHTML = serviciosHTML;
            totalServiciosSpan.textContent = totalServicios + '€';
            totalPagarSpan.textContent = (precioBase + totalServicios) + '€';
            
            // Actualizar el importe oculto del formulario
            document.getElementById('importe-hidden').value = precioBase + totalServicios;
            
            // Actualizar los servicios seleccionados para enviar al backend
            const serviciosSeleccionados = [];
            checkboxes.forEach(checkbox => {
                if (checkbox.checked) {
                    const cantidadInput = document.getElementById('cantidad-' + checkbox.value);
                    serviciosSeleccionados.push({
                        id: checkbox.value,
                        nombre: checkbox.dataset.nombre,
                        cantidad: cantidadInput ? parseInt(cantidadInput.value) || 1 : 1
                    });
                }
            });
            document.getElementById('servicios-hidden').value = JSON.stringify(serviciosSeleccionados);
        }
        
        // Inicializar valores al cargar
        actualizarPrecios();
        
        document.getElementById('payment-form').addEventListener('submit', function(e) {
            console.log('Importe:', document.getElementById('importe-hidden').value);
            console.log('Servicios:', document.getElementById('servicios-hidden').value);
        });
    });
</script>
@endsection

