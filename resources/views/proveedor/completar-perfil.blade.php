@extends('layouts.app')

@section('contenido')
    <div class="row justify-content-center">
        <div class="col-md-7">
            <h2>Completá tu perfil de proveedor</h2>
            <p class="text-muted">Necesitamos estos datos antes de que puedas recibir reservas.</p>

            <form action="{{ route('proveedor.completarPerfil.store') }}" method="POST" class="mt-3">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Teléfono</label>
                    <input type="text" name="telefono" class="form-control" value="{{ old('telefono') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tipo de proveedor</label>
                    <select name="tipo" class="form-select" required>
                        <option value="">Seleccioná una opción</option>
                        <option value="empleado">Empleado</option>
                        <option value="contratista">Contratista</option>
                        <option value="franquicia">Franquicia</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Sucursal</label>
                    <select name="sucursal_id" class="form-select">
                        <option value="">Sin sucursal asignada</option>
                        @foreach($sucursales as $sucursal)
                            <option value="{{ $sucursal->id }}">{{ $sucursal->nombre }} ({{ $sucursal->ciudad }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" name="ofrece_visita_domicilio" value="1" class="form-check-input" id="visitaDomicilio">
                    <label class="form-check-label" for="visitaDomicilio">Ofrezco visitas a domicilio</label>
                </div>

                <div class="mb-3">
                    <label class="form-label">Zona de cobertura</label>
                    <input type="text" name="zona_cobertura" class="form-control" placeholder="Ej: Zona norte, Yacuiba centro">
                </div>

                <div class="mb-3">
                    <label class="form-label">Servicios que ofrecés</label>
                    @foreach($servicios as $servicio)
                        <div class="form-check">
                            <input type="checkbox" name="servicios[]" value="{{ $servicio->id }}" class="form-check-input" id="servicio{{ $servicio->id }}">
                            <label class="form-check-label" for="servicio{{ $servicio->id }}">{{ $servicio->nombre }}</label>
                        </div>
                    @endforeach
                </div>

                <button type="submit" class="btn btn-primary">Guardar perfil</button>
            </form>
        </div>
    </div>
@endsection