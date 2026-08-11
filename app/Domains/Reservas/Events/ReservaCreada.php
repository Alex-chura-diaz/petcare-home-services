<?php

namespace App\Domains\Reservas\Events;

use App\Domains\Reservas\Models\Reserva;

class ReservaCreada
{
    public function __construct(
        public readonly Reserva $reserva
    ) {
    }
}