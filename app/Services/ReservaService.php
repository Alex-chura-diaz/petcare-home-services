<?php

namespace App\Services;

use App\Domains\Mascotas\Models\Mascota;
use App\Domains\Servicios\Models\Servicio;
use App\Domains\Reservas\Models\Reserva;
use Exception;

class ReservaService
{
    public function crear(array $datos): Reserva
    {
        $servicio = Servicio::findOrFail($datos['servicio_id']);
        $mascota = Mascota::findOrFail($datos['mascota_id']);

        if ($servicio->requiere_vacuna_verificada) {
            $tieneVacunaValida = $mascota->registrosVacunacion()
                ->where('verificado', true)
                ->where(function ($query) {
                    $query->whereNull('fecha_vencimiento')
                          ->orWhere('fecha_vencimiento', '>=', now());
                })
                ->exists();

            if (!$tieneVacunaValida) {
                throw new Exception('La mascota no tiene una vacuna verificada y vigente, requerida para este servicio.');
            }
        }

        return Reserva::create($datos);
    }
}