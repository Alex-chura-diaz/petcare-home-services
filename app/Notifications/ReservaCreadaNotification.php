<?php

namespace App\Notifications;

use App\Domains\Reservas\Models\Reserva;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ReservaCreadaNotification extends Notification
{
    use Queueable;

    protected Reserva $reserva;

    public function __construct(Reserva $reserva)
    {
        $this->reserva = $reserva;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'titulo' => 'Nueva reserva creada',
            'mensaje' => 'Tu reserva de "' . $this->reserva->servicio->nombre . '" para ' . $this->reserva->mascota->nombre . ' el ' . $this->reserva->fecha_hora->format('d/m/Y H:i') . ' fue creada y está pendiente de confirmación.',
            'reserva_id' => $this->reserva->id,
        ];
    }
}
