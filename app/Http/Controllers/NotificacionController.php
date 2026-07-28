<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

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