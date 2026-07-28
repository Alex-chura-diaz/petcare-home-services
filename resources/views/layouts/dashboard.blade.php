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
            background-color: #f4f6fb;
        }
        .sidebar {
            width: 260px;
            min-height: 100vh;
            background: linear-gradient(180deg, #6d5bd0, #4b3fa8);
            color: #fff;
            padding: 1.5rem 1rem;
            position: fixed;
            top: 0;
            left: 0;
        }
        .sidebar-brand {
            font-weight: 700;
            font-size: 1.15rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1.75rem;
        }
        .sidebar-user {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            background: rgba(255,255,255,0.1);
            border-radius: 12px;
            padding: 0.75rem;
            margin-bottom: 1.5rem;
        }
        .sidebar-user-avatar {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: rgba(255,255,255,0.25);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            flex-shrink: 0;
        }
        .sidebar-user-name {
            font-weight: 600;
            font-size: 0.9rem;
            line-height: 1.1;
        }
        .sidebar-user-role {
            font-size: 0.75rem;
            opacity: 0.75;
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,0.85);
            border-radius: 10px;
            padding: 0.6rem 0.9rem;
            margin-bottom: 0.25rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }
        .sidebar .nav-link:hover {
            background: rgba(255,255,255,0.1);
            color: #fff;
        }
        .sidebar .nav-link.active-link {
            background: rgba(255,255,255,0.95);
            color: #4b3fa8;
        }
        .sidebar-logout {
            position: absolute;
            bottom: 1.5rem;
            left: 1rem;
            right: 1rem;
        }
        .contenido-principal {
            margin-left: 260px;
            padding: 1.75rem 2rem;
        }
        @media (max-width: 991px) {
            .sidebar {
                position: static;
                width: 100%;
                min-height: auto;
            }
            .contenido-principal {
                margin-left: 0;
            }
        }
        .card {
            border: none;
            box-shadow: 0 1px 4px rgba(0,0,0,0.08);
        }
    </style>
</head>
<body>

    <div class="d-flex flex-column flex-lg-row">
        <aside class="sidebar">
            <div class="sidebar-brand">
                🐾 PetCare <span class="fw-normal">Home Services</span>
            </div>

            @auth
                <div class="sidebar-user">
                    <div class="sidebar-user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                    <div>
                        <div class="sidebar-user-name">{{ auth()->user()->name }}</div>
                        <div class="sidebar-user-role">{{ ucfirst(auth()->user()->role) }}</div>
                    </div>
                </div>

                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('mascotas.*') ? 'active-link' : '' }}" href="{{ route('mascotas.index') }}">
                            <i class="bi bi-heart-fill"></i> Mis mascotas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('reservas.*') ? 'active-link' : '' }}" href="{{ route('reservas.index') }}">
                            <i class="bi bi-calendar-check"></i> Reservas
                        </a>
                    </li>
                    @if(auth()->user()->role === 'proveedor')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('proveedor.*') ? 'active-link' : '' }}" href="{{ route('proveedor.reservas') }}">
                                <i class="bi bi-briefcase-fill"></i> Panel proveedor
                            </a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('notificaciones.*') ? 'active-link' : '' }}" href="{{ route('notificaciones.index') }}">
                            <i class="bi bi-bell-fill"></i> Notificaciones
                            @php
                                $cantidadNoLeidas = auth()->user()->unreadNotifications->count();
                            @endphp
                            @if($cantidadNoLeidas > 0)
                                <span class="badge bg-danger rounded-pill ms-auto">{{ $cantidadNoLeidas }}</span>
                            @endif
                        </a>
                    </li>
                </ul>

                <div class="sidebar-logout">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-light w-100">
                            <i class="bi bi-box-arrow-right"></i> Cerrar sesión
                        </button>
                    </form>
                </div>
            @endauth
        </aside>

        <main class="contenido-principal flex-grow-1">
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
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>