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

## 4. Mapa general 

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


## 4.1 Flujo del evento Reserva

Cuando se crea una reserva, el flujo es:

```text
ReservaService
      │
      ▼
Reserva::create()
      │
      ▼
ReservaCreada
      │
      ▼
EventBus::publish()
```

---

# 5. Actividad 2 — Bus de eventos en memoria

## 5.1 Interfaz `EventBus`

Para evitar que el dominio dependa directamente de una implementación concreta, se creó la interfaz:

```text
app/Infrastructure/Events/EventBus.php
```

La interfaz define dos operaciones:

```php
public function publish(object $event): void;

public function subscribe(string $eventClass, callable $listener): void;
```

Estas operaciones representan:

* `publish()` → publicar un evento.
* `subscribe()` → registrar un listener para un evento.

## 5.2 Implementación inicial

La primera implementación fue:

```text
InMemoryEventBus
```

Su arquitectura era:

```text
ReservaService
      │
      ▼
EventBus
      │
      ▼
InMemoryEventBus
      │
      ▼
ReservaCreadaListener
```

El `InMemoryEventBus` almacenaba los listeners en memoria y los ejecutaba cuando se publicaba el evento correspondiente.

## 5.3 Ventajas

El bus en memoria permitió:

* Separar el dominio de la infraestructura.
* Definir una abstracción común mediante `EventBus`.
* Registrar listeners de forma sencilla.
* Probar el mecanismo de eventos sin depender inicialmente de un broker externo.

## 5.4 Limitaciones

Sin embargo, el bus en memoria presenta algunas limitaciones:

* Los mensajes solamente existen dentro del proceso actual.
* No existe persistencia externa de los mensajes.
* No permite distribuir fácilmente los eventos entre diferentes procesos.
* No proporciona las capacidades propias de un broker de mensajes.
* La aplicación debe permanecer activa para ejecutar los listeners.

Por estas razones se decidió evolucionar hacia RabbitMQ.

---

# 6. Actividad 3 — Refactorización hacia RabbitMQ

## 6.1 ¿Por qué RabbitMQ?

RabbitMQ permite utilizar un broker de mensajes externo para almacenar y distribuir los mensajes entre productores y consumidores.

Esto permite separar:

```text
Productor
```

de:

```text
Consumidor
```

En este proyecto:

```text
Laravel
   │
   ▼
RabbitMQ
   │
   ▼
Laravel Queue Worker
```

## 6.2 Implementación de `LaravelEventBus`

Se creó:

```text
app/Infrastructure/Events/LaravelEventBus.php
```

Esta implementación mantiene la misma interfaz:

```text
EventBus
```

pero utiliza el sistema de eventos de Laravel:

```text
LaravelEventBus
      │
      ▼
Laravel Events
      │
      ▼
Laravel Queue
      │
      ▼
RabbitMQ
```

Esto permite cambiar la implementación del bus sin modificar la lógica principal del dominio.

## 6.3 Cambio realizado en `AppServiceProvider`

La aplicación dejó de utilizar:

```php
InMemoryEventBus
```

y pasó a utilizar:

```php
LaravelEventBus
```

La dependencia se registra mediante:

```php
$this->app->singleton(EventBus::class, function () {
    return new LaravelEventBus();
});
```

De esta forma, cuando una clase necesita `EventBus`, Laravel proporciona la implementación configurada.

---

# 7. Listener procesado mediante RabbitMQ

El listener:

```text
ReservaCreadaListener
```

implementa:

```php
Illuminate\Contracts\Queue\ShouldQueue
```

Esto indica que su ejecución debe realizarse mediante el sistema de colas.

El flujo final es:

```text
ReservaCreada
      │
      ▼
ReservaCreadaListener
      │
      │ ShouldQueue
      ▼
Laravel Queue
      │
      ▼
RabbitMQ
      │
      ▼
queue:work rabbitmq
      │
      ▼
handle()
```

Dentro del listener se procesa la reserva y se genera la notificación correspondiente.

---

# 8. Configuración de RabbitMQ

La aplicación utiliza RabbitMQ como conexión de cola.

En el archivo `.env` se configuró:

```env
QUEUE_CONNECTION=rabbitmq
```

RabbitMQ proporciona la cola:

```text
default
```

La administración del servidor RabbitMQ puede visualizarse mediante RabbitMQ Management.

En un entorno local se puede acceder a:

```text
http://localhost:15672
```

---

# 9. Ejecución del worker

Para iniciar el consumidor de mensajes se utiliza:

```powershell
php artisan queue:work rabbitmq
```

Este proceso permanece ejecutándose y espera nuevos mensajes en RabbitMQ.

Cuando recibe un evento pendiente, se muestra:

```text
App\Domains\Reservas\Listeners\ReservaCreadaListener
RUNNING
```

y posteriormente:

```text
App\Domains\Reservas\Listeners\ReservaCreadaListener
DONE
```

Esto demuestra que el listener fue ejecutado correctamente.

---

# 10. Verificación de la cola

Para consultar el estado de la cola RabbitMQ se utiliza:

```powershell
rabbitmqctl.bat list_queues name messages messages_ready messages_unacknowledged
```

Por ejemplo:

```text
name     messages    messages_ready    messages_unacknowledged
default  2           2                 0
```

Esto significa que existen dos mensajes pendientes de procesamiento.

Después de ejecutar:

```powershell
php artisan queue:work rabbitmq
```

los mensajes fueron procesados.

El estado final fue:

```text
name     messages    messages_ready    messages_unacknowledged
default  0           0                 0
```

Esto demuestra que los mensajes fueron consumidos correctamente.

---

# 11. Verificación de la notificación

Después de procesar el evento, se verificó la creación de una notificación en la tabla:

```text
notifications
```

La notificación contiene información como:

```text
titulo:
Nueva reserva creada

mensaje:
Tu reserva de "Consulta veterinaria" para blue
el 21/08/2026 21:30 fue creada y está pendiente
de confirmación.
```

Por lo tanto, se comprobó el flujo completo:

```text
Reserva creada
      ↓
Evento ReservaCreada
      ↓
RabbitMQ
      ↓
ReservaCreadaListener
      ↓
ReservaCreadaNotification
      ↓
notifications
```

---

# 12. Evidencias de funcionamiento

Para demostrar la implementación se realizaron las siguientes verificaciones:

### Eventos registrados

```powershell
php artisan event:list
```

Resultado esperado:

```text
App\Domains\Reservas\Events\ReservaCreada
    ⇂ App\Domains\Reservas\Listeners\ReservaCreadaListener (ShouldQueue)
```

### Worker

```powershell
php artisan queue:work rabbitmq
```

Resultado:

```text
ReservaCreadaListener RUNNING
ReservaCreadaListener DONE
```

### Estado de RabbitMQ

```powershell
rabbitmqctl.bat list_queues name messages messages_ready messages_unacknowledged
```

Resultado final:

```text
default    0    0    0
```

### Notificación

La notificación fue almacenada correctamente en:

```text
notifications
```

---

# 13. Comparación de las implementaciones

| Característica              | InMemoryEventBus       | RabbitMQ             |
| --------------------------- | ---------------------- | -------------------- |
| Ejecución                   | En memoria             | Broker externo       |
| Persistencia de mensajes    | No                     | Sí                   |
| Distribución entre procesos | Limitada               | Sí                   |
| Desacoplamiento             | Sí                     | Sí                   |
| Manejo mediante workers     | No directamente        | Sí                   |
| Escalabilidad               | Limitada               | Mayor                |
| Dependencia externa         | No                     | RabbitMQ             |
| Uso en el proyecto          | Implementación inicial | Implementación final |

---

# 14. Arquitectura final

La implementación final queda estructurada de la siguiente manera:

```text
┌─────────────────────┐
│    ReservaService   │
└──────────┬──────────┘
           │
           │ publish()
           ▼
┌─────────────────────┐
│   LaravelEventBus   │
└──────────┬──────────┘
           │
           ▼
┌─────────────────────┐
│      RabbitMQ       │
│   Queue: default    │
└──────────┬──────────┘
           │
           ▼
┌─────────────────────┐
│    Queue Worker     │
│ queue:work rabbitmq │
└──────────┬──────────┘
           │
           ▼
┌─────────────────────┐
│ ReservaCreada       │
│ Listener            │
└──────────┬──────────┘
           │
           ▼
┌─────────────────────┐
│ ReservaCreada       │
│ Notification        │
└──────────┬──────────┘
           │
           ▼
┌─────────────────────┐
│    Base de datos    │
│    notifications    │
└─────────────────────┘
```

---

# 15. Conclusiones

La implementación permitió evolucionar progresivamente el manejo de eventos del proyecto.

Inicialmente se realizó el mapeo de los eventos del dominio y se creó una abstracción mediante `EventBus`.

Posteriormente se implementó `InMemoryEventBus`, permitiendo comprobar el funcionamiento del patrón de eventos sin introducir inicialmente dependencias externas.

Finalmente, el bus fue refactorizado para utilizar Laravel y RabbitMQ como infraestructura de mensajería. El listener `ReservaCreadaListener` fue configurado para ejecutarse mediante `ShouldQueue`.

Las pruebas realizadas confirmaron que los eventos son publicados, enviados a RabbitMQ, procesados por el worker y finalmente utilizados para generar la notificación correspondiente.

Por lo tanto, se completaron las tres actividades planteadas:

1. **Mapear los eventos del dominio.**
2. **Conectar e implementar un bus de eventos en memoria.**
3. **Refactorizar el bus de eventos para utilizar un broker de mensajes externo, utilizando RabbitMQ.**
