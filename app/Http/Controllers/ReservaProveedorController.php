<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Domains\Reservas\Models\Reserva;
use App\Notifications\ReservaConfirmadaNotification;
use App\Notifications\ReservaCompletadaNotification;

class ReservaProveedorController extends Controller
{
    public function index()
    {
        $proveedorId = auth()->user()->proveedor->id;

        $pendientes = Reserva::with(['mascota', 'servicio', 'usuario'])
            ->where('estado', 'pendiente')
            ->where('proveedor_id', $proveedorId)
            ->orderBy('fecha_hora')
            ->get();

        $confirmadas = Reserva::with(['mascota', 'servicio', 'usuario'])
            ->where('estado', 'confirmada')
            ->where('proveedor_id', $proveedorId)
            ->orderBy('fecha_hora')
            ->get();

        return view('proveedor.reservas', compact('pendientes', 'confirmadas'));
    }

    public function confirmar(Reserva $reserva)
    {
        if ($reserva->proveedor_id !== auth()->user()->proveedor->id) {
            abort(403, 'Esta reserva no te pertenece.');
        }

        $reserva->update(['estado' => 'confirmada']);

        $reserva->usuario->notify(new ReservaConfirmadaNotification($reserva));

        return back()->with('success', 'Reserva confirmada correctamente.');
    }

    public function rechazar(Request $request, Reserva $reserva)
    {
        if ($reserva->proveedor_id !== auth()->user()->proveedor->id) {
            abort(403, 'Esta reserva no te pertenece.');
        }

        $datos = $request->validate([
            'motivo_rechazo' => 'required|string',
        ]);

        $reserva->update([
            'estado' => 'rechazada',
            'motivo_rechazo' => $datos['motivo_rechazo'],
        ]);

        return back()->with('success', 'Reserva rechazada.');
    }

    public function completar(Reserva $reserva)
    {
        if ($reserva->proveedor_id !== auth()->user()->proveedor->id) {
            abort(403, 'Esta reserva no te pertenece.');
        }

        $reserva->update(['estado' => 'completada']);

        $reserva->usuario->notify(new ReservaCompletadaNotification($reserva));

        return back()->with('success', 'Reserva marcada como completada.');
    }
}