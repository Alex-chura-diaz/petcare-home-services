<?php

namespace App\Domains\Reservas\Http\Controllers;

use Illuminate\Http\Request;
use App\Domains\Reservas\Models\Reserva;
use App\Services\ReservaService;
use Exception;
use App\Http\Controllers\Controller;

class ReservaController extends Controller
{
    protected ReservaService $reservaService;

    public function __construct(ReservaService $reservaService)
    {
        $this->reservaService = $reservaService;
    }

    public function index()
    {
        $reservas = Reserva::with(['usuario', 'mascota', 'servicio', 'proveedor'])->get();
        return response()->json($reservas);
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'user_id' => 'required|exists:users,id',
            'mascota_id' => 'required|exists:mascotas,id',
            'servicio_id' => 'required|exists:servicios,id',
            'proveedor_id' => 'required|exists:proveedores,id',
            'modalidad' => 'required|in:recogida_entrega,visita_domicilio,en_local',
            'direccion_visita' => 'nullable|string',
            'fecha_hora' => 'required|date',
            'metodo_pago' => 'required|in:en_linea,en_lugar',
            'notas' => 'nullable|string',
        ]);

        try {
            $reserva = $this->reservaService->crear($datos);
            return response()->json($reserva, 201);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }
}