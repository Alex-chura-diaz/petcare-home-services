<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PetCare Home Services - Proveedor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f1ee;
        }
        .sidebar {
            width: 260px;
            min-height: 100vh;
            background: linear-gradient(180deg, #2b2320, #5c3d2e);
            color: #fff;
            padding: 1.5rem 1rem;
            position: fixed;
            top: 0;
            left: 0;
        }
        .sidebar-brand {
            font-weight: 700;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1.75rem;
        }
        .sidebar-user {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            background: rgba(255,255,255,0.08);
            border-radius: 12px;
            padding: 0.75rem;
            margin-bottom: 1.5rem;
        }
        .sidebar-user-avatar {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: rgba(255,255,255,0.18);
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
            opacity: 0.7;
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
            background: rgba(255,255,255,0.08);
            color: #fff;
        }
        .sidebar .nav-link.active-link {
            background: #fff;
            color: #4a2f1f;
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
        .btn-primary {
            background-color: #5c3d2e;
            border-color: #5c3d2e;
        }
        .btn-primary:hover {
            background-color: #4a2f1f;
            border-color: #4a2f1f;
        }
    </style>
</head>
<body>

    <div class="d-flex flex-column flex-lg-row">
        <aside class="sidebar">
            <div class="sidebar-brand">
                🐾 PetCare <span class="fw-normal">Proveedor</span>
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
                        <a class="nav-link {{ request()->routeIs('proveedor.reservas') ? 'active-link' : '' }}" href="{{ route('proveedor.reservas') }}">
                            <i class="bi bi-calendar-check"></i> Reservas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('vacunas.verificar') ? 'active-link' : '' }}" href="{{ route('vacunas.verificar') }}">
                            <i class="bi bi-clipboard2-pulse"></i> Vacunas pendientes
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('mascotas.index') }}">
                            <i class="bi bi-arrow-left-right"></i> Vista dueño
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