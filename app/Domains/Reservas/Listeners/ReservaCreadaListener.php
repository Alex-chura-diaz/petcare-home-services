<?php

namespace App\Domains\Reservas\Listeners;

use App\Domains\Reservas\Events\ReservaCreada;
use App\Notifications\ReservaCreadaNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class ReservaCreadaListener implements ShouldQueue
{
    public function handle(ReservaCreada $event): void
    {
        $reserva = $event->reserva;

        $reserva->load(['usuario', 'mascota', 'servicio']);

        $reserva->usuario->notify(
            new ReservaCreadaNotification($reserva)
        );

        Log::info('Notificación de reserva creada enviada por RabbitMQ', [
            'reserva_id' => $reserva->id,
            'usuario_id' => $reserva->user_id,
            'mascota_id' => $reserva->mascota_id,
            'servicio_id' => $reserva->servicio_id,
        ]);
    }
}
