@extends('layouts.master')

@section('title', 'Completar Reserva')

@section('content')

<div class="reserva-container">
    <h2 class="reserva-title">Completa tu Reserva</h2>
    
    <div class="reserva-layout">
        <!-- Panel Izquierdo: Detalles y Servicios -->
        <div class="reserva-left">
            
            <!-- Detalles de la Habitación -->
            <div class="card-white">
                <h3 class="card-title">Detalles de la Habitación y Servicios</h3>
                
                <div class="habitacion-detalle">
                    <div class="habitacion-img-placeholder">
                        @if($habitacion->imagen)
                            <img src="{{ $habitacion->imagen }}" alt="Habitación {{ $habitacion->numero }}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 12px;">
                        @else
                            <span style="font-size: 4rem;">🏨</span>
                        @endif
                    </div>
                    
                    <div class="habitacion-info">
                        <h4>{{ $habitacion->categoria->nombre ?? 'Habitación' }} - Habitación {{ $habitacion->numero }}</h4>
                        <p><strong>Check-in:</strong> {{ \Carbon\Carbon::parse($checkin)->format('d/m/Y') }}</p>
                        <p><strong>Check-out:</strong> {{ \Carbon\Carbon::parse($checkout)->format('d/m/Y') }}</p>
                        <p><strong>Huéspedes:</strong> {{ $huespedes }} personas</p>
                        <p><strong>Camas:</strong> {{ $habitacion->camas ?? 1 }} {{ ($habitacion->camas ?? 1) == 1 ? 'cama' : 'camas' }}</p>
                        <p><strong>Aseos:</strong> {{ $habitacion->aseos ?? 1 }}</p>
                        @if($habitacion->balcon)
                            <p>🌅 <strong>Balcón</strong></p>
                        @endif
                        @if($habitacion->escritorio)
                            <p>💼 <strong>Zona de trabajo</strong></p>
                        @endif
                        @if($habitacion->cuna)
                            <p>👶 <strong>Cuna disponible</strong></p>
                        @endif
                        <p><strong>Precio base:</strong> {{ $habitacion->precio }}€/noche ({{ $noches }} noches)</p>
                    </div>
                </div>
            </div>

            <!-- Servicios Extras -->
            <div class="card-white">
                <h3 class="card-title">Servicios Extra (Opcional)</h3>
                
                <form id="servicios-form">
                    @foreach($servicios as $servicio)
                        <div class="servicio-item">
                            <input type="checkbox" 
                                   id="servicio-{{ $servicio->id }}" 
                                   name="servicios[]" 
                                   value="{{ $servicio->id }}"
                                   data-precio="{{ $servicio->precio }}"
                                   data-nombre="{{ $servicio->nombre }}"
                                   data-tipo="{{ $servicio->tipo_cobro }}"
                                   class="servicio-checkbox">
                            <label for="servicio-{{ $servicio->id }}" class="servicio-label">
                                <span class="servicio-icono">
                                    @if($servicio->nombre == 'Desayuno buffet') 🍳
                                    @elseif($servicio->nombre == 'Parking privado') 🅿️
                                    @elseif($servicio->nombre == 'Acceso al Spa') 🧖
                                    @elseif($servicio->nombre == 'Cuna') 👶
                                    @elseif($servicio->nombre == 'Traslado al aeropuerto') 🚗
                                    @elseif($servicio->nombre == 'Late check-out') 🕐
                                    @else 🏨
                                    @endif
                                </span>
                                <span class="servicio-nombre">{{ $servicio->nombre }}</span>
                                <span class="servicio-precio">({{ $servicio->precio }}€{{ $servicio->descripcion }})</span>
                            </label>
                            @if($servicio->tipo_cobro == 'personalizable' || $servicio->tipo_cobro == 'personalizable_por_persona')
                                <input type="number" 
                                       id="cantidad-{{ $servicio->id }}"
                                       min="1" 
                                       value="1" 
                                       class="servicio-cantidad"
                                       style="width: 60px; padding: 5px; border: 1px solid #BDC1C7; border-radius: 5px; margin-left: 10px;"
                                       disabled>
                            @endif
                        </div>
                    @endforeach
                </form>
            </div>

        </div>

        <!-- Panel Derecho: Desglose del Precio -->
        <div class="reserva-right">
            <div class="card-white precio-card">
                <h3 class="card-title">Desglose del Precio</h3>
                
                <div class="precio-linea">
                    <span>Habitación ({{ $noches }} noches):</span>
                    <span id="precio-habitacion">{{ $precioBase }}€</span>
                </div>

                <div id="servicios-seleccionados">
                    <!-- Los servicios seleccionados aparecerán aquí -->
                </div>

                <hr class="precio-divider">

                <div class="precio-linea total-servicios">
                    <span>Total Servicios:</span>
                    <span id="total-servicios">0€</span>
                </div>

                <div class="precio-linea precio-total">
                    <strong>Total a Pagar:</strong>
                    <strong id="total-pagar">{{ $precioBase }}€</strong>
                </div>

                <button type="button" class="btn-confirmar">
                    Confirmar Reserva y Pagar
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const precioBase = {{ $precioBase }};
    const noches = {{ $noches }};
    const huespedes = {{ $huespedes }};
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
    }
});
</script>

@endsection
