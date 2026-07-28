<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function mostrarLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $datos = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($datos)) {
            $request->session()->regenerate();
            return redirect()->route('mascotas.index')->with('success', 'Sesión iniciada correctamente.');
        }

        return back()->withErrors(['email' => 'Las credenciales no coinciden con nuestros registros.'])->onlyInput('email');
    }

    public function mostrarRegistro()
    {
        return view('auth.registro');
    }

    public function registro(Request $request)
    {
        $datos = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:dueño,proveedor',
        ]);

        $usuario = User::create([
            'name' => $datos['name'],
            'email' => $datos['email'],
            'password' => Hash::make($datos['password']),
            'role' => $datos['role'],
        ]);

        Auth::login($usuario);

        if ($usuario->role === 'proveedor') {
            return redirect()->route('proveedor.completarPerfil')->with('success', 'Cuenta creada. Completá tu perfil de proveedor.');
        }

        return redirect()->route('mascotas.index')->with('success', 'Cuenta creada correctamente.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Sesión cerrada.');
    }
}