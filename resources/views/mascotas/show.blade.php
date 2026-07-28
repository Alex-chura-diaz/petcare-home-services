@extends('layouts.dashboard')

@section('contenido')
    <a href="{{ route('mascotas.index') }}" class="btn btn-sm btn-outline-secondary mb-3">&larr; Volver</a>

    <div class="card mb-4">
        <div class="card-body">
            <h2>{{ $mascota->nombre }}</h2>
            <p class="text-muted mb-1">{{ ucfirst($mascota->especie) }} @if($mascota->raza) - {{ $mascota->raza }} @endif</p>

            @if($mascota->requiere_manejo_especial)
                <span class="badge bg-warning text-dark">Manejo especial</span>
                <p class="mt-2">{{ $mascota->notas_manejo_especial }}</p>
            @endif

            <ul class="list-unstyled mt-3">
                @if($mascota->fecha_nacimiento)
                    <li><strong>Nacimiento:</strong> {{ $mascota->fecha_nacimiento }}</li>
                @endif
                @if($mascota->sexo)
                    <li><strong>Sexo:</strong> {{ ucfirst($mascota->sexo) }}</li>
                @endif
                @if($mascota->peso)
                    <li><strong>Peso:</strong> {{ $mascota->peso }} kg</li>
                @endif
            </ul>
        </div>
    </div>

    <h4>Registros de vacunación</h4>

    @if($mascota->registrosVacunacion->isEmpty())
        <p class="text-muted">Todavía no hay vacunas registradas.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Vacuna</th>
                    <th>Aplicación</th>
                    <th>Vencimiento</th>
                    <th>Veterinario</th>
                    <th>Documento</th>
                    <th>Verificado</th>
                </tr>
            </thead>
            <tbody>
                @foreach($mascota->registrosVacunacion as $vacuna)
                    <tr>
                        <td>{{ $vacuna->nombre_vacuna }}</td>
                        <td>{{ $vacuna->fecha_aplicacion }}</td>
                        <td>{{ $vacuna->fecha_vencimiento ?? '—' }}</td>
                        <td>{{ $vacuna->proveedor->nombre_completo ?? '—' }}</td>
                        <td>
                            @if($vacuna->documento)
                                <a href="{{ asset('storage/' . $vacuna->documento) }}" target="_blank">Ver</a>
                            @else
                            —
                            @endif
            </td>


                        <td>
                            @if($vacuna->verificado)
                                <span class="badge bg-success">Sí</span>
                            @else
                                <span class="badge bg-secondary">No</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <h4 class="mt-4">Registrar nueva vacuna</h4>

         <form action="{{ route('vacunas.store', $mascota) }}" method="POST" class="row g-3" enctype="multipart/form-data">
            @csrf

            <div class="col-md-4">
                <label class="form-label">Nombre de la vacuna</label>
                <input type="text" name="nombre_vacuna" class="form-control" required>
            </div>

            <div class="col-md-4">
                <label class="form-label">Fecha de aplicación</label>
                <input type="date" name="fecha_aplicacion" class="form-control" required>
            </div>

            <div class="col-md-4">
                <label class="form-label">Fecha de vencimiento</label>
                <input type="date" name="fecha_vencimiento" class="form-control">
            </div>

            <div class="col-md-6">
                <label class="form-label">Veterinario</label>
                <select name="proveedor_id" class="form-select">
                    <option value="">Sin especificar</option>
                    @foreach($veterinarios as $veterinario)
                        <option value="{{ $veterinario->id }}">{{ $veterinario->nombre_completo }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Foto o PDF del carnet de vacunación</label>
                <input type="file" name="documento" class="form-control" accept=".pdf,.jpg,.jpeg,.png" required>
            </div>

            <div class="col-12">
                <button type="submit" class="btn btn-success">Registrar vacuna</button>
            </div>
        </form>    
@endsection