<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PetCare Home Services</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f8;
        }
        .navbar {
            box-shadow: 0 2px 6px rgba(0,0,0,0.08);
        }
        .navbar-brand {
            font-weight: 600;
        }
        .nav-link {
            font-weight: 500;
        }
        .nav-link.active-link {
            border-bottom: 2px solid rgba(255,255,255,0.9);
        }
        .notif-icon {
            position: relative;
            font-size: 1.25rem;
        }
        .notif-badge {
            position: absolute;
            top: -6px;
            right: -10px;
            font-size: 0.65rem;
        }
        .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background-color: rgba(255,255,255,0.2);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }
        .card {
            border: none;
            box-shadow: 0 1px 4px rgba(0,0,0,0.08);
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">🐾 PetCare Home Services</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuPrincipal">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="menuPrincipal">
                @auth
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('mascotas.*') ? 'active-link' : '' }}" href="{{ route('mascotas.index') }}">
                                <i class="bi bi-heart-fill me-1"></i> Mascotas
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('reservas.*') ? 'active-link' : '' }}" href="{{ route('reservas.index') }}">
                                <i class="bi bi-calendar-check me-1"></i> Reservas
                            </a>
                        </li>
                        @if(auth()->user()->role === 'proveedor')
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('proveedor.*') ? 'active-link' : '' }}" href="{{ route('proveedor.reservas') }}">
                                    <i class="bi bi-briefcase-fill me-1"></i> Panel proveedor
                                </a>
                            </li>
                        @endif
                    </ul>

                    <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-3">
                        <li class="nav-item">
                            <a class="nav-link notif-icon" href="{{ route('notificaciones.index') }}" title="Notificaciones">
                                <i class="bi bi-bell-fill"></i>
                                @php
                                    $cantidadNoLeidas = auth()->user()->unreadNotifications->count();
                                @endphp
                                @if($cantidadNoLeidas > 0)
                                    <span class="badge bg-danger rounded-pill notif-badge">{{ $cantidadNoLeidas }}</span>
                                @endif
                            </a>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" role="button" data-bs-toggle="dropdown">
                                <span class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                                <span class="d-none d-lg-inline">{{ auth()->user()->name }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><span class="dropdown-item-text text-muted small">Sesión iniciada como</span></li>
                                <li><span class="dropdown-item-text fw-semibold">{{ ucfirst(auth()->user()->role) }}</span></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="bi bi-box-arrow-right me-2"></i>Cerrar sesión
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                @else
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Iniciar sesión</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('registro') }}">Registrarse</a>
                        </li>
                    </ul>
                @endauth
            </div>
        </div>
    </nav>

    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('contenido')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>