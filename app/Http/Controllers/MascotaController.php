<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Domains\Mascotas\Models\Mascota;

class MascotaController extends Controller
{
    public function index()
    {
        $mascotas = Mascota::where('user_id', auth()->id())->get();
        return view('mascotas.index', compact('mascotas'));
    }

    public function create()
    {
        return view('mascotas.create');
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'nombre' => 'required|string',
            'especie' => 'required|string',
            'raza' => 'nullable|string',
            'fecha_nacimiento' => 'nullable|date',
            'sexo' => 'nullable|in:macho,hembra',
            'peso' => 'nullable|numeric',
            'requiere_manejo_especial' => 'nullable|boolean',
            'notas_manejo_especial' => 'nullable|string',
            'foto' => 'nullable|file|mimes:jpg,jpeg,png|max:5120',
        ]);

        $datos['user_id'] = auth()->id();
        $datos['requiere_manejo_especial'] = $request->has('requiere_manejo_especial');

        if ($request->hasFile('foto')) {
            $datos['foto'] = $request->file('foto')->store('mascotas', 'public');
        } else {
            $datos['foto'] = null;
        }

        Mascota::create($datos);

        return redirect()->route('mascotas.index')->with('success', 'Mascota creada correctamente.');
    }

    public function show(Mascota $mascota)
    {
        $mascota->load('registrosVacunacion');
        $veterinarios = \App\Domains\Proveedores\Models\Proveedor::whereHas('servicios', function ($query) {
            $query->where('tipo', 'veterinaria');
        })->where('estado', 'activo')->get();

        return view('mascotas.show', compact('mascota', 'veterinarios'));
    }
}