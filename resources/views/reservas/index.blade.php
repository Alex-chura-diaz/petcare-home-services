@extends('layouts.dashboard')

@section('contenido')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Mis reservas</h2>
        <a href="{{ route('reservas.create') }}" class="btn btn-primary">+ Nueva reserva</a>
    </div>

    @if($reservas->isEmpty())
        <p class="text-muted">Todavía no hiciste ninguna reserva.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Mascota</th>
                    <th>Servicio</th>
                    <th>Proveedor</th>
                    <th>Fecha y hora</th>
                    <th>Modalidad</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reservas as $reserva)
                    <tr>
                        <td>{{ $reserva->mascota->nombre }}</td>
                        <td>{{ $reserva->servicio->nombre }}</td>
                        <td>{{ $reserva->proveedor->nombre_completo }}</td>
                        <td>{{ $reserva->fecha_hora->format('d/m/Y H:i') }}</td>
                        <td>{{ ucfirst(str_replace('_', ' ', $reserva->modalidad)) }}</td>
                        <td>
                            @php
                                $colores = [
                                    'pendiente' => 'warning',
                                    'confirmada' => 'success',
                                    'rechazada' => 'danger',
                                    'en_progreso' => 'info',
                                    'completada' => 'primary',
                                    'cancelada' => 'secondary',
                                ];
                            @endphp
                            <span class="badge bg-{{ $colores[$reserva->estado] ?? 'secondary' }}">
                                {{ ucfirst($reserva->estado) }}
                            </span>
                            @if($reserva->estado === 'rechazada' && $reserva->motivo_rechazo)
                                    <div class="text-muted small mt-1">{{ $reserva->motivo_rechazo }}</div>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection