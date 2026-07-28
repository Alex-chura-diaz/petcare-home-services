@extends('layouts.proveedor')

@section('contenido')
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
        <h2 class="mb-0">Reservas pendientes</h2>
        <div class="input-group" style="max-width: 320px;">
            <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
            <input type="text" id="buscadorPendientes" class="form-control" placeholder="Buscar por dueño, mascota o servicio...">
        </div>
    </div>

    @if($pendientes->isEmpty())
        <p class="text-muted">No hay reservas pendientes.</p>
    @else
        <table class="table table-bordered mt-3" id="tablaPendientes">
            <thead>
                <tr>
                    <th>Dueño</th>
                    <th>Mascota</th>
                    <th>Servicio</th>
                    <th>Fecha y hora</th>
                    <th>Modalidad</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pendientes as $reserva)
                    <tr data-busqueda="{{ strtolower(($reserva->usuario->name ?? '') . ' ' . $reserva->mascota->nombre . ' ' . $reserva->servicio->nombre) }}">
                        <td>{{ $reserva->usuario->name ?? '—' }}</td>
                        <td>{{ $reserva->mascota->nombre }}</td>
                        <td>{{ $reserva->servicio->nombre }}</td>
                        <td>{{ $reserva->fecha_hora }}</td>
                        <td>{{ $reserva->modalidad }}</td>
                        <td>
                            <form action="{{ route('proveedor.reservas.confirmar', $reserva) }}" method="POST" style="display:inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-success">Confirmar</button>
                            </form>

                            <form action="{{ route('proveedor.reservas.rechazar', $reserva) }}" method="POST" style="display:inline">
                                @csrf
                                <input type="text" name="motivo_rechazo" placeholder="Motivo" required style="width:120px">
                                <button type="submit" class="btn btn-sm btn-danger">Rechazar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <p class="text-muted small" id="sinResultadosPendientes" style="display:none;">No se encontraron reservas que coincidan con la búsqueda.</p>
    @endif

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mt-5">
        <h2 class="mb-0">Reservas confirmadas</h2>
        <div class="input-group" style="max-width: 320px;">
            <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
            <input type="text" id="buscadorConfirmadas" class="form-control" placeholder="Buscar por dueño, mascota o servicio...">
        </div>
    </div>

    @if($confirmadas->isEmpty())
        <p class="text-muted">No hay reservas confirmadas.</p>
    @else
        <table class="table table-bordered mt-3" id="tablaConfirmadas">
            <thead>
                <tr>
                    <th>Dueño</th>
                    <th>Mascota</th>
                    <th>Servicio</th>
                    <th>Fecha y hora</th>
                    <th>Modalidad</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($confirmadas as $reserva)
                    <tr data-busqueda="{{ strtolower(($reserva->usuario->name ?? '') . ' ' . $reserva->mascota->nombre . ' ' . $reserva->servicio->nombre) }}">
                        <td>{{ $reserva->usuario->name ?? '—' }}</td>
                        <td>{{ $reserva->mascota->nombre }}</td>
                        <td>{{ $reserva->servicio->nombre }}</td>
                        <td>{{ $reserva->fecha_hora }}</td>
                        <td>{{ $reserva->modalidad }}</td>
                        <td>
                            <form action="{{ route('proveedor.reservas.completar', $reserva) }}" method="POST" style="display:inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-primary">Completar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <p class="text-muted small" id="sinResultadosConfirmadas" style="display:none;">No se encontraron reservas que coincidan con la búsqueda.</p>
    @endif

    <script>
        function activarBuscador(inputId, tablaId, mensajeVacioId) {
            const input = document.getElementById(inputId);
            const tabla = document.getElementById(tablaId);
            const mensajeVacio = document.getElementById(mensajeVacioId);
            if (!input || !tabla) return;

            input.addEventListener('input', function () {
                const texto = this.value.trim().toLowerCase();
                const filas = tabla.querySelectorAll('tbody tr');
                let visibles = 0;

                filas.forEach(function (fila) {
                    const coincide = fila.dataset.busqueda.includes(texto);
                    fila.style.display = coincide ? '' : 'none';
                    if (coincide) visibles++;
                });

                if (mensajeVacio) {
                    mensajeVacio.style.display = visibles === 0 ? '' : 'none';
                }
            });
        }

        activarBuscador('buscadorPendientes', 'tablaPendientes', 'sinResultadosPendientes');
        activarBuscador('buscadorConfirmadas', 'tablaConfirmadas', 'sinResultadosConfirmadas');
    </script>
@endsection