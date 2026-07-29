<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Domains\Usuarios\Models\User;

class NotificacionController extends Controller
{
    public function index()
    {
        $usuario = User::find(auth()->id());

        $notificaciones = $usuario->notifications;

        $usuario->unreadNotifications->markAsRead();

        return view('notificaciones.index', compact('notificaciones'));
    }
}