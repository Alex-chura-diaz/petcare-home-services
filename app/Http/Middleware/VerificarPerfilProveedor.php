<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerificarPerfilProveedor
{
    /**
     * Si el usuario logueado es proveedor pero todavía no completó
     * su perfil en la tabla "proveedores", lo manda a completarlo.
     */
    public function handle(Request $request, Closure $next)
    {
        $usuario = auth()->user();

        if ($usuario && $usuario->role === 'proveedor' && !$usuario->proveedor) {
            return redirect()->route('proveedor.completarPerfil')
                ->with('error', 'Completá tu perfil de proveedor para continuar.');
        }

        return $next($request);
    }
}