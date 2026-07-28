@extends('layouts.dashboard')

@section('contenido')
    <h2>Agregar mascota</h2>

    <form action="{{ route('mascotas.store') }}" method="POST" class="mt-3" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label class="form-label">Nombre</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Especie</label>
            <select name="especie" class="form-select" required>
                <option value="">Seleccioná una opción</option>
                <option value="perro">Perro</option>
                <option value="gato">Gato</option>
                <option value="ave">Ave</option>
                <option value="otro">Otro</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Raza</label>
            <input type="text" name="raza" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Fecha de nacimiento</label>
            <input type="date" name="fecha_nacimiento" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Sexo</label>
            <select name="sexo" class="form-select">
                <option value="">Sin especificar</option>
                <option value="macho">Macho</option>
                <option value="hembra">Hembra</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Peso (kg)</label>
            <input type="number" step="0.01" name="peso" class="form-control">
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" name="requiere_manejo_especial" value="1" class="form-check-input" id="manejoEspecial">
            <label class="form-check-label" for="manejoEspecial">Requiere manejo especial</label>
        </div>

        <div class="mb-3">
            <label class="form-label">Notas de manejo especial</label>
            <textarea name="notas_manejo_especial" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Foto de la mascota</label>
            <input type="file" name="foto" class="form-control" accept=".jpg,.jpeg,.png">
        </div>

        <button type="submit" class="btn btn-primary">Guardar mascota</button>
        <a href="{{ route('mascotas.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection