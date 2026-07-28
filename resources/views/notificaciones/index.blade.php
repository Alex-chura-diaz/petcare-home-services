@extends('layouts.dashboard')

@section('contenido')
    <h2>Notificaciones</h2>

    @if($notificaciones->isEmpty())
        <p class="text-muted">No tenés notificaciones todavía.</p>
    @else
        <div class="list-group mt-3">
            @foreach($notificaciones as $notificacion)
                <div class="list-group-item {{ $notificacion->read_at ? '' : 'list-group-item-light border-start border-primary border-3' }}">
                    <strong>{{ $notificacion->data['titulo'] }}</strong>
                    <p class="mb-1">{{ $notificacion->data['mensaje'] }}</p>
                    <small class="text-muted">{{ $notificacion->created_at->diffForHumans() }}</small>
                </div>
            @endforeach
        </div>
    @endif
@endsection