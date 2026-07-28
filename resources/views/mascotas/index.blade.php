@extends('layouts.dashboard')

@section('contenido')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Mis mascotas</h2>
        <a href="{{ route('mascotas.create') }}" class="btn btn-primary">+ Agregar mascota</a>
    </div>

    @if($mascotas->isEmpty())
        <p class="text-muted">Todavía no registraste ninguna mascota.</p>
    @else
        <div class="row">
            @foreach($mascotas as $mascota)
                <div class="col-md-4 mb-3">
                    <div class="card">
                        @if($mascota->foto)
                            <img src="{{ asset('storage/' . $mascota->foto) }}" class="card-img-top" style="height: 200px; object-fit: cover;" alt="{{ $mascota->nombre }}">
                        @else
                            <div class="d-flex align-items-center justify-content-center bg-light" style="height: 200px;">
                                <span class="text-muted">🐾 Sin foto</span>
                            </div>
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $mascota->nombre }}</h5>
                            <p class="card-text text-muted mb-1">{{ ucfirst($mascota->especie) }}</p>
                            @if($mascota->requiere_manejo_especial)
                                <span class="badge bg-warning text-dark">Manejo especial</span>
                            @endif
                            <div class="mt-3">
                                <a href="{{ route('mascotas.show', $mascota) }}" class="btn btn-sm btn-outline-primary">Ver detalle</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection