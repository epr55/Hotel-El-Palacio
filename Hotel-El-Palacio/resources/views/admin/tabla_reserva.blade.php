@extends('layouts.master')

@section('title', 'Gestión de habitaciones')

@section('content')

<style>
    /* CSS GENERICO TODAS LAS TABLAS */
    .table-wrapper {
        padding: 40px 20px;
        display: flex;
        justify-content: center;
    }

    .table-container {
        background-color: #fff;
        padding: 30px 35px;
        border-radius: 15px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.1);
        width: 100%;
        max-width: 1100px;
        border: 1px solid #eee;
    }

    .table-title {
        color: #D39D55;
        font-family: 'Mozilla Headline', sans-serif;
        font-size: 1.8rem;
        margin-bottom: 25px;
        text-align: center;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    thead {
        background-color: #FEF7EC;
    }

    thead th {
        border-bottom: 2px solid #D39D55;
    }

    th, td {
        padding: 14px 12px;
        font-size: 0.95rem;
        border-bottom: 1px solid #e0e0e0;
        border-right: 1px solid #dcdcdc;
    }

    th {
        text-align: center;
        font-weight: 600;
        color: #1A1A1A;
    }

    td {
        text-align: center;
    }

    th:last-child,
    td:last-child {
        border-right: none;
    }

    tbody tr:hover {
        background-color: #FAFAFA;
    }

    .action-buttons {
        display: flex;
        gap: 8px;
    }

    .btn-action {
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 600;
        border: none;
        cursor: pointer;
    }

    .btn-edit {
        background-color: #E15218;
        color: white;
    }

    .btn-delete {
        background-color: #dc2626;
        color: white;
    }

    .pagination-wrapper {
        display: flex;
        justify-content: center;
        margin-top: 20px;
        padding-top: 15px;
    }

    .pagination-wrapper nav, .pagination {
        background: transparent !important;
        box-shadow: none !important;
    }

    .pagination-wrapper p {
        display: none;
    }

    .pagination {
        gap: 6px;
    }

    .page-link {
        border-radius: 8px !important;
        border: 1px solid #e0e0e0;
        color: #1A1A1A;
        padding: 8px 14px;
        font-weight: 500;
    }

    .page-link:hover {
        background-color: #FEF7EC;
    }

    .page-item.active .page-link {
        background-color: #E15218;
        border-color: #E15218;
        color: white;
    }

    .page-item.disabled .page-link {
        color: #999;
    }

    .btn-back-admin {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 20px;
        padding: 8px 14px;
        background-color: #FEF7EC;
        color: #1A1A1A;
        border: 1px solid #e0e0e0;
        border-radius: 10px;
        font-size: 0.9rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .btn-back-admin:hover {
        background-color: #E15218;
        color: white;
        border-color: #E15218;
    }

    /*CSS SOLO TABLA RESERVA*/
    .estado-badge {
        padding: 6px 12px;
        border-radius: 12px;
        font-size: 0.8rem;
        font-weight: 700;
        display: inline-block;
        min-width: 95px;
        text-align: center;
    }

    .estado-confirmada {
        background-color: #dcfce7;
        color: #166534;
        border: 1px solid #86efac;
    }

    .estado-cancelada {
        background-color: #fee2e2;
        color: #991b1b;
        border: 1px solid #fca5a5;
    }

    .estado-pendiente {
        background-color: #fef3c7;
        color: #92400e;
        border: 1px solid #fde68a;
    }

    .servicios-lista {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        justify-content: center;
    }

    .servicio-badge {
        background-color: #eef2ff;
        color: #3730a3;
        border: 1px solid #c7d2fe;
        border-radius: 10px;
        padding: 4px 8px;
        font-size: 0.75rem;
        font-weight: 600;
        white-space: nowrap;
    }
</style>

<div class="table-wrapper">
    <div class="table-container">
        
        <h3 class="table-title">Reservas</h3>

        <a href="{{ route('home') }}" class="btn-back-admin">
            Atrás
        </a>

        <table>
            <thead>
                <tr>
                    <th>Usuario</th>
                    <th>Habitación</th>
                    <th>Estado</th>
                    <th>Inicio</th>
                    <th>Fin</th>
                    <th>Precio</th>
                    <th>Temporada</th>
                    <th>Servicios</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($reservas as $reserva)
                    <tr>

                        <td>{{ $reserva->usuario->name ?? '—' }}</td>
                        <td>{{ $reserva->habitacion->numero ?? '—' }}</td>
                        <td>
                            <span class="estado-badge 
                                {{ $reserva->estado === 'confirmada' ? 'estado-confirmada' : '' }}
                                {{ $reserva->estado === 'cancelada' ? 'estado-cancelada' : '' }}
                                {{ $reserva->estado === 'pendiente' ? 'estado-pendiente' : '' }}">
                                {{ $reserva->estado }}
                            </span>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($reserva->fecha_inicio)->format('d/m/Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($reserva->fecha_final)->format('d/m/Y') }}</td>
                        <td>{{ number_format($reserva->precio_total, 1) }}€</td>
                        <td>{{ $reserva->temporada->nombre ?? '—' }}</td>
                        <td>
                            @if ($reserva->servicios->count())
                                <div class="servicios-lista">
                                    @foreach ($reserva->servicios as $servicio)
                                        <span class="servicio-badge">
                                            {{ $servicio->nombre }}
                                        </span>
                                    @endforeach
                                </div>
                            @else
                                —
                            @endif
                        </td>
                        <td>
                            <div class="action-buttons">
                                <button class="btn-action btn-edit">Editar</button>
                                <button class="btn-action btn-delete">Eliminar</button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" style="text-align:center; padding:20px;">
                            No hay reservas registradas.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="pagination-wrapper">
            {{ $reservas->links('pagination::bootstrap-5') }}
        </div>

    </div>
</div>


@endsection