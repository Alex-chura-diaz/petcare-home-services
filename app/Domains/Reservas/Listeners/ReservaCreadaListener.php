<?php

namespace App\Domains\Reservas\Listeners;

use App\Domains\Reservas\Events\ReservaCreada;
use Illuminate\Support\Facades\Log;

class ReservaCreadaListener
{
    public function handle(ReservaCreada $event): void
    {
        Log::info('Evento ReservaCreada recibido', [
            'reserva_id' => $event->reserva->id,
            'mascota_id' => $event->reserva->mascota_id,
            'proveedor_id' => $event->reserva->proveedor_id,
            'servicio_id' => $event->reserva->servicio_id,
        ]);
    }
}