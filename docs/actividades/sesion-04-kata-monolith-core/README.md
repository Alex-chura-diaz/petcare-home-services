# Actividad 3 – Eventos de Dominio

## Actividades

- **PROYECTO:** Mapear los eventos de dominio.
- **PROYECTO:** Conectar/implementar un bus de eventos en memoria.
- **PROYECTO:** Refactorizar el bus de eventos para utilizar un broker de mensajes externo como RabbitMQ, ActiveMQ o Kafka.

---

## 1. Mapeo de eventos de dominio

### Objetivo

Identificar los hechos importantes que ocurren dentro de los dominios de **PetCare Home Services** y representarlos mediante eventos de dominio.

Un evento representa un hecho que **ya ocurrió** en el sistema.

Ejemplo:

```text
Usuario crea una reserva
        ↓
ReservaCreada
```

---

## 2. Dominios analizados

Se analizaron los principales dominios del proyecto:

- Usuarios
- Mascotas
- Proveedores
- Reservas
- Servicios

A partir de las operaciones existentes en los controladores y modelos se identificaron los siguientes eventos.

---

## 3. Eventos identificados

| Dominio | Evento | Cuándo ocurre |
|---|---|---|
| Usuarios | `UsuarioRegistrado` | Cuando un usuario completa su registro |
| Mascotas | `MascotaRegistrada` | Cuando se registra una mascota |
| Mascotas | `VacunaRegistrada` | Cuando se registra una vacunación |
| Reservas | `ReservaCreada` | Cuando se crea una reserva |
| Reservas | `ReservaConfirmada` | Cuando se confirma una reserva |
| Reservas | `ReservaRechazada` | Cuando se rechaza una reserva |
| Reservas | `ReservaCompletada` | Cuando se completa una reserva |
| Proveedores | `ProveedorRegistrado` | Cuando se registra un proveedor |

---

## 4. Eventos principales seleccionados

Para la implementación se comenzará con los siguientes eventos:

```text
UsuarioRegistrado
MascotaRegistrada
VacunaRegistrada
ProveedorRegistrado
ReservaCreada
ReservaConfirmada
ReservaCompletada
```

Los eventos `ReservaRechazada` y `ProveedorRegistrado` quedan identificados para una posible ampliación.

---

## 5. Mapa general

```text
Usuarios
└── UsuarioRegistrado

Mascotas
├── MascotaRegistrada
└── VacunaRegistrada

Reservas
├── ReservaCreada
├── ReservaConfirmada
├── ReservaRechazada
└── ReservaCompletada

Proveedores
└── ProveedorRegistrado
```

---

## 6. Ejemplo del flujo

Para una reserva:

```text
Usuario
   ↓
Crea una reserva
   ↓
ReservaController
   ↓
ReservaCreada
   ↓
Event Bus
   ↓
Listeners
```

El evento `ReservaCreada` podrá contener información como:

```text
reservaId
mascotaId
proveedorId
servicioId
fecha
```

Los datos definitivos dependerán de los atributos existentes en el modelo `Reserva`.

---

## 7. Evolución de la actividad

La implementación se realizará en tres etapas.

### Etapa 1 – Mapeo

```text
Dominio
   ↓
Hecho importante
   ↓
Evento de dominio
```

### Etapa 2 – Bus en memoria

```text
Dominio
   ↓
Evento
   ↓
Event Bus
   ↓
Listeners
```

### Etapa 3 – Broker externo

```text
Dominio
   ↓
Evento
   ↓
Event Bus
   ↓
RabbitMQ
   ↓
Consumers
```

De esta manera, el proyecto evolucionará desde un bus de eventos en memoria hacia una arquitectura orientada a eventos utilizando un broker externo.

---

## Resultado

Se realizó el mapeo inicial de los eventos de dominio de **PetCare Home Services**, identificando los principales hechos del negocio que podrán ser publicados y consumidos por diferentes componentes del sistema.

Este mapeo servirá como base para la implementación del **bus de eventos en memoria** y posteriormente su integración con un **broker de mensajes externo**.