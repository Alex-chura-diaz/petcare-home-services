<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MascotaController;
use App\Http\Controllers\ReservaViewController;
use App\Http\Controllers\VacunaController;
use App\Http\Controllers\VerificacionVacunaController;
use App\Http\Controllers\ReservaProveedorController;
use App\Domains\Usuarios\Http\Controllers\NotificacionController;
use App\Domains\Usuarios\Http\Controllers\AuthController;
use App\Http\Controllers\ProveedorPerfilController;

Route::get('/login', [AuthController::class, 'mostrarLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/registro', [AuthController::class, 'mostrarRegistro'])->name('registro');
Route::post('/registro', [AuthController::class, 'registro'])->name('registro.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/', function () {
    return redirect()->route('mascotas.index');
});

// --- Rutas que requieren estar logueado (cualquier rol) ---
Route::middleware('auth')->group(function () {

    // Completar perfil de proveedor (sin el middleware perfil.proveedor, porque es acá donde se completa)
    Route::get('/proveedor/completar-perfil', [ProveedorPerfilController::class, 'mostrarFormulario'])->name('proveedor.completarPerfil');
    Route::post('/proveedor/completar-perfil', [ProveedorPerfilController::class, 'store'])->name('proveedor.completarPerfil.store');

    Route::get('/mascotas', [MascotaController::class, 'index'])->name('mascotas.index');
    Route::get('/mascotas/crear', [MascotaController::class, 'create'])->name('mascotas.create');
    Route::post('/mascotas', [MascotaController::class, 'store'])->name('mascotas.store');
    Route::get('/mascotas/{mascota}', [MascotaController::class, 'show'])->name('mascotas.show');

    Route::get('/reservas', [ReservaViewController::class, 'index'])->name('reservas.index');
    Route::get('/reservas/crear', [ReservaViewController::class, 'create'])->name('reservas.create');
    Route::post('/reservas', [ReservaViewController::class, 'store'])->name('reservas.store');

    Route::post('/mascotas/{mascota}/vacunas', [VacunaController::class, 'store'])->name('vacunas.store');

    Route::get('/notificaciones', [NotificacionController::class, 'index'])->name('notificaciones.index');

    // --- Rutas exclusivas del rol "proveedor", que además exigen perfil completo ---
    Route::middleware(['rol:proveedor', 'perfil.proveedor'])->group(function () {
        Route::get('/proveedor/reservas', [ReservaProveedorController::class, 'index'])->name('proveedor.reservas');
        Route::post('/proveedor/reservas/{reserva}/confirmar', [ReservaProveedorController::class, 'confirmar'])->name('proveedor.reservas.confirmar');
        Route::post('/proveedor/reservas/{reserva}/rechazar', [ReservaProveedorController::class, 'rechazar'])->name('proveedor.reservas.rechazar');
        Route::post('/proveedor/reservas/{reserva}/completar', [ReservaProveedorController::class, 'completar'])->name('proveedor.reservas.completar');
        Route::get('/vacunas/verificar', [VerificacionVacunaController::class, 'index'])->name('vacunas.verificar');
        Route::post('/vacunas/{vacuna}/verificar', [VerificacionVacunaController::class, 'verificar'])->name('vacunas.verificarUna');
    });
});