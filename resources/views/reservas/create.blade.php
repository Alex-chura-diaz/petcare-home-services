@extends('layouts.dashboard')

@section('contenido')
    <h2>Nueva reserva</h2>

    @if($errors->has('vacuna'))
        <div class="alert alert-danger">
            {{ $errors->first('vacuna') }}
        </div>
    @endif

    <form action="{{ route('reservas.store') }}" method="POST" class="mt-3">
        @csrf

        <div class="mb-3">
            <label class="form-label">Mascota</label>
            <select name="mascota_id" class="form-select" required>
                <option value="">Seleccioná una mascota</option>
                @foreach($mascotas as $mascota)
                    <option value="{{ $mascota->id }}" {{ old('mascota_id') == $mascota->id ? 'selected' : '' }}>
                        {{ $mascota->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Servicio</label>
            <select name="servicio_id" class="form-select" required>
                <option value="">Seleccioná un servicio</option>
                @foreach($servicios as $servicio)
                    <option value="{{ $servicio->id }}" {{ old('servicio_id') == $servicio->id ? 'selected' : '' }}>
                        {{ $servicio->nombre }} (${{ $servicio->precio_base }})
                        @if($servicio->requiere_vacuna_verificada) — requiere vacuna verificada @endif
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Proveedor</label>
            <select name="proveedor_id" class="form-select" required>
                <option value="">Seleccioná un proveedor</option>
                @foreach($proveedores as $proveedor)
                    <option value="{{ $proveedor->id }}" {{ old('proveedor_id') == $proveedor->id ? 'selected' : '' }}>
                        {{ $proveedor->nombre_completo }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Modalidad</label>
            <select name="modalidad" class="form-select" required>
                <option value="">Seleccioná una opción</option>
                <option value="recogida_entrega" {{ old('modalidad') == 'recogida_entrega' ? 'selected' : '' }}>Recogida y entrega</option>
                <option value="visita_domicilio" {{ old('modalidad') == 'visita_domicilio' ? 'selected' : '' }}>Visita a domicilio</option>
                <option value="en_local" {{ old('modalidad') == 'en_local' ? 'selected' : '' }}>En el local</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Dirección (solo si es visita a domicilio)</label>
            <input type="text" name="direccion_visita" class="form-control" value="{{ old('direccion_visita') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Fecha y hora</label>
            <input type="datetime-local" name="fecha_hora" class="form-control" value="{{ old('fecha_hora') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Método de pago</label>
            <select name="metodo_pago" class="form-select" required>
                <option value="">Seleccioná una opción</option>
                <option value="en_linea" {{ old('metodo_pago') == 'en_linea' ? 'selected' : '' }}>En línea</option>
                <option value="en_lugar" {{ old('metodo_pago') == 'en_lugar' ? 'selected' : '' }}>En el lugar</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Notas</label>
            <textarea name="notas" class="form-control">{{ old('notas') }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Crear reserva</button>
        <a href="{{ route('reservas.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection