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

    /*CSS SOLO TABLA HABITACIONES*/
    .table-imagen {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #ddd;
    }
    .img-modal {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.85);
        z-index: 9999;
        justify-content: center;
        align-items: center;
    }

    .img-modal img {
        width: 30vw;
        height: 30vw;
        border-radius: 12px;
        box-shadow: 0 20px 50px rgba(0,0,0,0.5);
    }

    .img-modal:target {
        display: flex;
    }

    .img-modal-close {
        position: absolute;
        top: 30px;
        right: 40px;
        font-size: 28px;
        color: white;
        text-decoration: none;
        font-weight: bold;
    }
</style>

<div class="table-wrapper">
    <div class="table-container">
        
        <h3 class="table-title">Habitaciones</h3>

        <a href="{{ route('home') }}" class="btn-back-admin">
            Atras
        </a>

        <table>
            <thead>
                <tr>
                    <th>Imagen</th>
                    <th>Numero</th>
                    <th>Categoría</th>
                    <th>Precio</th>
                    <th>Camas Individuales</th>
                    <th>Camas Dobles</th>
                    <th>Aseos</th>
                    <th>Balcón</th>
                    <th>Escritorio</th>
                    <th>Cuna</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($habitaciones as $habitacion)
                    @php
                        $nombre = App\Models\Categoria::find($habitacion->categoria_id)->nombre;
                    @endphp
                    <tr>
                        <td>
                            <a href="#img-{{ $habitacion->id }}">
                                <img class="table-imagen" src="{{ asset($habitacion->imagen) }}">
                            </a>

                            <div id="img-{{ $habitacion->id }}" class="img-modal">
                                <a href="#" class="img-modal-close">✕</a>
                                <img src="{{ asset($habitacion->imagen) }}">
                            </div>
                        </td>
                        <td>{{ $habitacion->numero }}</td>
                        <td>{{ $nombre ?? '—' }}</td>
                        <td>{{ number_format($habitacion->precio, 1) }}€</td>
                        <td>{{ $habitacion->camas_individual }}</td>
                        <td>{{ $habitacion->camas_doble }}</td>
                        <td>{{ $habitacion->aseos ? 'Sí' : 'No' }}</td>
                        <td>{{ $habitacion->balcon ? 'Sí' : 'No' }}</td>
                        <td>{{ $habitacion->escritorio ? 'Sí' : 'No' }}</td>
                        <td>{{ $habitacion->cuna ? 'Sí' : 'No' }}</td>
                        <td>
                            <div class="action-buttons">
                                <button class="btn-action btn-edit">Editar</button>
                                <button class="btn-action btn-delete">Eliminar</button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" style="text-align:center; padding:20px;">
                            No hay habitaciones registradas.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="pagination-wrapper">
            {{ $habitaciones->links('pagination::bootstrap-5') }}
        </div>

    </div>
</div>

@endsection