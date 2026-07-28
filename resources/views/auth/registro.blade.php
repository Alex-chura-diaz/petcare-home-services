@extends('layouts.app')

@section('contenido')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2>Crear cuenta</h2>

            <form action="{{ route('registro.post') }}" method="POST" class="mt-3">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Nombre completo</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required autofocus>
                </div>

                <div class="mb-3">
                    <label class="form-label">Correo electrónico</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Contraseña</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Confirmar contraseña</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tipo de cuenta</label>
                    <select name="role" class="form-select" required>
                        <option value="dueño">Dueño de mascota</option>
                        <option value="proveedor">Proveedor de servicios</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Crear cuenta</button>
            </form>

            <p class="mt-3">
                ¿Ya tenés cuenta? <a href="{{ route('login') }}">Iniciá sesión</a>
            </p>
        </div>
    </div>
@endsection