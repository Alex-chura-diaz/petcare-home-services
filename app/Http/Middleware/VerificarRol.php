<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerificarRol
{
    /**
     * Verifica que el usuario logueado tenga uno de los roles permitidos.
     * Uso en rutas: ->middleware('rol:proveedor') o ->middleware('rol:proveedor,admin')
     */
    public function handle(Request $request, Closure $next, ...$rolesPermitidos)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Tenés que iniciar sesión para acceder.');
        }

        if (!in_array(auth()->user()->role, $rolesPermitidos)) {
            abort(403, 'No tenés permiso para acceder a esta sección.');
        }

        return $next($request);
    }
}