<?php

namespace App\Domains\Usuarios\Http\Controllers;

use Illuminate\Http\Request;
use App\Domains\Usuarios\Models\User;
use App\Http\Controllers\Controller;

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