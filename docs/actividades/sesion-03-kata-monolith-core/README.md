# Revisión arquitectónica del monolito inicial

## Proyecto: PetCare Home Services

### Materia

**MICROSERVICES, EVENT-DRIVEN Y CLOUD-NATIVE**

### Actividad 3

**Realizar una revisión arquitectónica del monolito inicial.**

**Refactorizar el código en paquetes/namespaces estrictamente separados por dominio.**

---

# 1. Arquitectura inicial — V1

El proyecto inicialmente utiliza una arquitectura **monolítica con Laravel 9**, donde el código está organizado principalmente por **tipo técnico**.

### Estructura inicial

```text
app/
├── Http/
│   └── Controllers/
├── Models/
├── Notifications/
├── Services/
└── Providers/
```

En esta estructura, los componentes de los diferentes dominios están mezclados en las mismas carpetas.

Por ejemplo:

```text
app/
├── Models/
│   ├── User.php
│   ├── Mascota.php
│   ├── Servicio.php
│   ├── Proveedor.php
│   └── Reserva.php
│
├── Http/
│   └── Controllers/
│       ├── UserController.php
│       ├── MascotaController.php
│       ├── ServicioController.php
│       ├── ProveedorController.php
│       └── ReservaController.php
│
└── Services/
```

### Problema principal

La organización por componentes técnicos dificulta identificar claramente los límites entre los dominios del negocio.

Los principales dominios identificados son:

* Usuarios
* Mascotas
* Servicios
* Proveedores
* Reservas

---

# 2. Arquitectura propuesta — V2

Como resultado de la revisión, se propone reorganizar el monolito utilizando una estructura **orientada a dominios**.

Cada dominio tendrá su propio espacio de organización y namespace.

### Nueva estructura

```text
app/
└── Domains/
    │
    ├── Usuarios/
    │   ├── Models/
    │   │   └── User.php
    │   ├── Services/
    │   └── ...
    │
    ├── Mascotas/
    │   ├── Models/
    │   │   ├── Mascota.php
    │   │   └── RegistroVacunacion.php
    │   ├── Services/
    │   └── ...
    │
    ├── Servicios/
    │   ├── Models/
    │   │   └── Servicio.php
    │   ├── Services/
    │   └── ...
    │
    ├── Proveedores/
    │   ├── Models/
    │   │   ├── Proveedor.php
    │   │   └── Sucursal.php
    │   ├── Services/
    │   └── ...
    │
    └── Reservas/
        ├── Models/
        │   └── Reserva.php
        ├── Services/
        └── ...
```

Los namespaces también estarán separados por dominio:

```text
App\Domains\Usuarios
App\Domains\Mascotas
App\Domains\Servicios
App\Domains\Proveedores
App\Domains\Reservas
```

---

# 3. Antes vs. Después

| V1 — Monolito inicial             | V2 — Organización por dominios |
| --------------------------------- | ------------------------------ |
| Organización por tipo técnico     | Organización por dominio       |
| `app/Models`                      | `app/Domains/*/Models`         |
| `app/Services`                    | `app/Domains/*/Services`       |
| Límites poco claros               | Límites de dominio explícitos  |
| Código distribuido                | Código agrupado por dominio    |
| Mayor dificultad de mantenimiento | Mayor cohesión y organización  |

### Antes

```text
app/
├── Models/
├── Http/Controllers/
├── Services/
└── Notifications/
```

### Ahora

```text
app/
└── Domains/
    ├── Usuarios/
    ├── Mascotas/
    ├── Servicios/
    ├── Proveedores/
    └── Reservas/
```

---

# 4. Resultado de la revisión

La principal mejora propuesta es pasar de una organización basada en **componentes técnicos** a una organización basada en **dominios del negocio**.

```text
             MONOLITO
                │
                ↓
       ┌─────────────────┐
       │     Domains     │
       └─────────────────┘
          │   │   │   │   │
          ↓   ↓   ↓   ↓   ↓
       Usuarios
       Mascotas
       Servicios
       Proveedores
       Reservas
```

Esta estructura permite identificar mejor las responsabilidades de cada dominio y establece una base para continuar con la **modularización del monolito**.
