@extends('layouts.proveedor')

@section('contenido')
    <h2>Vacunas pendientes de verificación</h2>

    @if($vacunas->isEmpty())
        <p class="text-muted">No hay vacunas pendientes de verificar.</p>
    @else
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Mascota</th>
                    <th>Vacuna</th>
                    <th>Aplicación</th>
                    <th>Vencimiento</th>
                    <th>Veterinario</th>
                    <th>Comprobante</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach($vacunas as $vacuna)
                    <tr>
                        <td>{{ $vacuna->mascota->nombre }}</td>
                        <td>{{ $vacuna->nombre_vacuna }}</td>
                        <td>{{ $vacuna->fecha_aplicacion }}</td>
                        <td>{{ $vacuna->fecha_vencimiento ?? '—' }}</td>
                        <td>{{ $vacuna->proveedor->nombre_completo ?? '—' }}</td>
                        <td>
                            @if($vacuna->documento)
                                @php
                                    $extension = pathinfo($vacuna->documento, PATHINFO_EXTENSION);
                                @endphp
                                @if(in_array(strtolower($extension), ['jpg', 'jpeg', 'png']))
                                    <a href="{{ asset('storage/' . $vacuna->documento) }}" target="_blank">
                                        <img src="{{ asset('storage/' . $vacuna->documento) }}" alt="Comprobante" style="max-width: 80px; max-height: 80px; border-radius: 4px;">
                                    </a>
                                @else
                                    <a href="{{ asset('storage/' . $vacuna->documento) }}" target="_blank" class="btn btn-sm btn-outline-secondary">Ver PDF</a>
                                @endif
                            @else
                                <span class="text-muted">Sin comprobante</span>
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('vacunas.verificarUna', $vacuna) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-success">Verificar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection