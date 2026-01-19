@extends('layouts.master')

@section('title', 'Gestión de Usuarios')

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
        border-collapse:collapse;
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
        justify-content: center;
        gap: 8px;
    }

    .btn-action {
        position: relative;
        padding: 7px 14px;
        border-radius: 10px;
        font-size: 0.85rem;
        font-weight: 600;
        border: 1.5px solid transparent;
        cursor: pointer;
        background-color: transparent;
        transition: background-color 0.25s ease, border-color 0.25s ease;
    }

    .btn-action::after {
        content: '';
        position: absolute;
        left: 50%;
        bottom: 6px;
        width: 0;
        height: 2px;
        transform: translateX(-50%);
        transition: width 0.25s ease;
        border-radius: 2px;
    }

    .btn-edit {
        color: #6F540F;
        background-color: #FDECC8;
        border-color: #E6C27A;
    }


    .btn-edit::after {
        background-color: #D39D55;
    }

    .btn-edit:hover {
        border-color: #D39D55;
        background-color: #FFF6E8;
    }

    .btn-edit:hover::after {
        width: 60%;
    }

    .btn-delete {
        color: #7F1D1D;
        background-color: #FBDADA;
        border-color: #E57373;
    }

    .btn-delete::after {
        background-color: #DC2626;
    }

    .btn-delete:hover {
        border-color: #DC2626;
        background-color: #FDE8E8;
    }

    .btn-delete:hover::after {
        width: 70%;
    }

    .btn-add {
        color: #166534;
        background-color: #DCFCE7;
        border-color: #86EFAC;
    }

    .btn-add::after {
        background-color: #16A34A;
    }

    .btn-add:hover {
        border-color: #16A34A;
        background-color: #ECFDF5;
    }

    .btn-add:hover::after {
        width: 65%;
    }

    .pagination-wrapper {
        display: flex;
        justify-content: center;
        margin-top: 20px;
        padding-top: 15px;
    }

    .pagination-wrapper nav, .pagination {
        background: transparent;
        box-shadow: none;
    }

    .pagination-wrapper p {
        display: none;
    }

    .pagination {
        gap: 6px;
    }

    .page-link {
        border-radius: 8px;
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
    
    /*CSS SOLO TABLA USUARIOS */
    .role-badge {
        padding: 4px 10px;
        border-radius: 12px;
        font-size: 0.8rem;
        font-weight: 600;
        display: inline-block;
    }

    .role-admin {
        background-color: #fde68a;
        color: #92400e;
    }

    .role-recepcionista {
        background-color: #bfdbfe;
        color: #1e40af;
    }

    .role-user {
        background-color: #e5e7eb;
        color: #374151;
    }
</style>

<div class="table-wrapper">
    <div class="table-container">

        <h3 class="table-title">Usuarios registrados</h3>

        <div style="display:flex; justify-content: space-between; align-items:center; margin-bottom: 20px;">
            <a href="{{ route('home') }}" class="btn-back-admin">
                Atrás
            </a>

            <form action="{{ route('admin.formulario.insertar.usuario') }}" method="GET">
                <button type="submit" class="btn-action btn-add">
                    Añadir
                </button>
            </form>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Teléfono</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->correo }}</td>
                        <td>{{ $user->telefono ?? '—' }}</td>
                        <td>
                            @if ($user->admin)
                                <span class="role-badge role-admin">Admin</span>
                            @elseif ($user->recepcionista)
                                <span class="role-badge role-recepcionista">Recepcionista</span>
                            @else
                                <span class="role-badge role-user">Usuario</span>
                            @endif
                        </td>
                        <td>
                            <div class="action-buttons">
                                <form action="{{ route('admin.borrar.usuario', $user->id) }}" method="POST" onsubmit="return confirm('¿Seguro que quieres eliminar este usuario?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn-action btn-delete">
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align:center; padding:20px;">
                            No hay usuarios registrados.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="pagination-wrapper">
            {{ $users->links('pagination::bootstrap-5') }}
        </div>

    </div>
</div>

@endsection
