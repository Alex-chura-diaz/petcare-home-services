<?php

namespace App\Domains\Proveedores\Http\Controllers;

use Illuminate\Http\Request;
use App\Domains\Proveedores\Models\Proveedor;
use App\Domains\Proveedores\Models\Sucursal;
use App\Domains\Servicios\Models\Servicio;
use App\Http\Controllers\Controller;

class ProveedorPerfilController extends Controller
{
    public function mostrarFormulario()
    {
        $sucursales = Sucursal::where('estado', 'activo')->get();
        $servicios = Servicio::where('estado', 'activo')->get();

        return view('proveedor.completar-perfil', compact('sucursales', 'servicios'));
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'telefono' => 'required|string|max:30',
            'tipo' => 'required|in:empleado,contratista,franquicia',
            'sucursal_id' => 'nullable|exists:sucursales,id',
            'ofrece_visita_domicilio' => 'nullable|boolean',
            'zona_cobertura' => 'nullable|string|max:255',
            'servicios' => 'nullable|array',
            'servicios.*' => 'exists:servicios,id',
        ]);

        $proveedor = Proveedor::create([
            'user_id' => auth()->id(),
            'sucursal_id' => $datos['sucursal_id'] ?? null,
            'nombre_completo' => auth()->user()->name,
            'correo' => auth()->user()->email,
            'telefono' => $datos['telefono'],
            'tipo' => $datos['tipo'],
            'ofrece_visita_domicilio' => $request->has('ofrece_visita_domicilio'),
            'zona_cobertura' => $datos['zona_cobertura'] ?? null,
            'estado' => 'activo',
        ]);

        $proveedor->servicios()->sync($datos['servicios'] ?? []);

        return redirect()->route('proveedor.reservas')->with('success', 'Perfil de proveedor completado correctamente.');
    }
}