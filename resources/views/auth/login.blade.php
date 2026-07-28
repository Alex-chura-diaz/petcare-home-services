@extends('layouts.app')

@section('contenido')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2>Iniciar sesión</h2>

            <form action="{{ route('login.post') }}" method="POST" class="mt-3">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Correo electrónico</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
                </div>

                <div class="mb-3">
                    <label class="form-label">Contraseña</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary">Ingresar</button>
            </form>

            <p class="mt-3">
                ¿No tenés cuenta? <a href="{{ route('registro') }}">Registrate acá</a>
            </p>
        </div>
    </div>
@endsection