@extends('layouts.master')

@section('title','Insertar Habitación')

@section('content')

<style>
    /*CSS GENERICO FORMULARIOS*/
    .form-wrapper {
        padding: 40px 20px;
        display: flex;
        justify-content: center;
    }

    .form-container {
        background-color: #fff;
        padding: 45px 50px;
        border-radius: 18px;
        box-shadow: 0 15px 45px rgba(0,0,0,0.12);
        width: 100%;
        max-width: 760px;
        border: 1px solid #eee;
    }


    .form-title {
        color: #D39D55;
        font-family: 'Mozilla Headline', sans-serif;
        font-size: 1.9rem;
        margin-bottom: 35px;
        text-align: center;
    }


    .form-group {
        margin-bottom: 20px;
        text-align: left;
    }

    .form-group label {
        display: block;
        font-weight: 600;
        margin-bottom: 6px;
        color: #1A1A1A;
    }

    .form-control {
        width: 100%;
        padding: 12px 14px;
        border-radius: 12px;
        border: 1.5px solid #e0e0e0;
        font-size: 0.95rem;
        background-color: #FAFAFA;
        transition: border-color 0.2s ease, background-color 0.2s ease;
    }

    .form-control:focus {
        outline: none;
        border-color: #D39D55;
        background-color: #FFF6E8;
    }

    .form-actions {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 14px;
        margin-top: 35px;
    }

    .btn-primary,
    .btn-secondary {
        position: relative;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        height: 44px;
        min-width: 180px;
        padding: 0 22px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.9rem;
        line-height: 1;
        cursor: pointer;
        white-space: nowrap;
        background-color: transparent;
        border: 1.5px solid transparent;
        transition: background-color 0.25s ease, border-color 0.25s ease;
    }

    .btn-primary::after,
    .btn-secondary::after {
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

    .btn-primary {
        background-color: #D39D55;
        color: #ffffff;
        border-color: #D39D55;
    }

    .btn-primary::after {
        background-color: #ffffff;
    }

    .btn-primary:hover {
        background-color: #C48C44;
        border-color: #C48C44;
    }


    .btn-primary:hover::after {
        width: 55%;
    }

    .btn-secondary {
        background-color: #F4F4F5;
        color: #444;
        border-color: #d1d5db;
    }

    .btn-secondary::after {
        background-color: #9ca3af;
    }

    .btn-secondary:hover {
        background-color: #E5E7EB;
        border-color: #9ca3af;
    }

    .btn-secondary:hover::after {
        width: 55%;
    }

    /*CSS SOLO HABITACION*/
    .options-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
        gap: 12px;
        margin-top: 10px;
    }

    .option-card {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 14px 16px;
        border-radius: 14px;
        border: 1.5px solid #e0e0e0;
        background-color: #FAFAFA;
        font-weight: 600;
        cursor: pointer;
        transition: background-color 0.2s ease, border-color 0.2s ease;
    }

    .option-card input {
        display: none;
    }

    .option-card:has(input:checked) {
        background-color: #FFF6E8;
        border-color: #D39D55;
        color: #6F540F;
    }

    .option-card:hover {
        background-color: #FEF7EC;
        border-color: #D39D55;
    }

</style>

<div class="form-wrapper">
    <div class="form-container">
        <h3 class="form-title">Insertar Habitación</h3>

        <form method="POST" action="{{ route('admin.insertar.habitacion') }}" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label>Número</label>
                <input type="number" name="numero" class="form-control" value="{{ old('numero') }}" required>
            </div>

            <div class="form-group">
                <label>Precio</label>
                <input type="number" step="0.01" name="precio" class="form-control" value="{{ old('precio') }}" required>
            </div>

            <div class="form-group">
                <label>Distribución de camas</label>

                <div style="display:flex; gap:12px;">
                    <input type="number" name="camas_individual" class="form-control" min="0" placeholder="Individuales" value="{{ old('camas_individual') }}" required>
                    <input type="number" name="camas_doble" class="form-control" min="0" placeholder="Dobles" value="{{ old('camas_doble') }}" required>
                </div>
            </div>
            
            <div class="form-group">
                <label>Número de aseos</label>
                <input type="number" name="aseos" class="form-control" min="0" value="{{ old('aseos', 1) }}" required>
            </div>

            <div class="form-group">
                <label>Imagen de la habitación</label>
                <input type="file" name="imagen" class="form-control" accept="image/*">
                <small style="color:#666;">
                    Formatos permitidos: JPG, PNG, WEBP
                </small>
            </div>


            <div class="form-group">
                <label>Categoría</label>
                <select name="categoria_id" class="form-control" required>
                    <option value="">Seleccione una categoria</option>
                    @foreach($categorias as $categoria)
                        <option value="{{ $categoria->id }}" {{ old('categoria_id') == $categoria->id ? 'selected' : '' }}>
                            {{ $categoria->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Servicios de la habitación</label>
                <div class="options-grid">
                    <label class="option-card">
                        <input type="checkbox" name="balcon" value="1" {{ old('balcon') ? 'checked' : '' }}>
                        <span>Balcón</span>
                    </label>

                    <label class="option-card">
                        <input type="checkbox" name="escritorio" value="1" {{ old('escritorio') ? 'checked' : '' }}>
                        <span>Escritorio</span>
                    </label>

                    <label class="option-card">
                        <input type="checkbox" name="cuna" value="1" {{ old('cuna') ? 'checked' : '' }}>
                        <span>Cuna</span>
                    </label>
                </div>
            </div>

            <div class="form-actions">
                <button type="button" class="btn-secondary" onclick="window.location='{{ url()->previous() }}'">
                    Cancelar
                </button>

                <button type="submit" class="btn-primary">
                    Insertar
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
