<?php

namespace App\Domains\Mascotas\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Domains\Mascotas\Models\RegistroVacunacion;

class VerificacionVacunaController extends Controller
{
    public function index()
    {
        $proveedorId = auth()->user()->proveedor->id;

        $vacunas = RegistroVacunacion::with('mascota')
            ->where('verificado', false)
            ->where('proveedor_id', $proveedorId)
            ->get();

        return view('vacunas.verificar', compact('vacunas'));
    }

    public function verificar(RegistroVacunacion $vacuna)
    {
        if ($vacuna->proveedor_id !== auth()->user()->proveedor->id) {
            abort(403, 'Esta vacuna no te corresponde verificar.');
        }

        $vacuna->update(['verificado' => true]);

        return back()->with('success', 'Vacuna verificada correctamente.');
    }
}