<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mascota;
use App\Models\RegistroVacunacion;

class VacunaController extends Controller
{
    public function store(Request $request, Mascota $mascota)
    {
        $datos = $request->validate([
            'nombre_vacuna' => 'required|string',
            'fecha_aplicacion' => 'required|date',
            'fecha_vencimiento' => 'nullable|date',
            'proveedor_id' => 'nullable|exists:proveedores,id',
            'documento' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $datos['documento'] = $request->file('documento')->store('vacunas', 'public');
        $datos['mascota_id'] = $mascota->id;
        $datos['verificado'] = false;

        RegistroVacunacion::create($datos);

        return back()->with('success', 'Vacuna registrada correctamente. Un proveedor deberá verificarla.');
    }
}