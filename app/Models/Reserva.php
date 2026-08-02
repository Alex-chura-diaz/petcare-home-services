<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Domains\Usuarios\Models\User;
use App\Domains\Mascotas\Models\Mascota;
use App\Domains\Servicios\Models\Servicio;
use App\Domains\Proveedores\Models\Proveedor;

class Reserva extends Model
{
    use HasFactory;

    protected $table = 'reservas';

    protected $fillable = [
        'user_id',
        'mascota_id',
        'servicio_id',
        'proveedor_id',
        'modalidad',
        'direccion_visita',
        'fecha_hora',
        'estado',
        'motivo_rechazo',
        'metodo_pago',
        'notas',
    ];

    protected $casts = [
        'fecha_hora' => 'datetime',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function mascota()
    {
        return $this->belongsTo(Mascota::class, 'mascota_id');
    }

    public function servicio()
    {
        return $this->belongsTo(Servicio::class, 'servicio_id');
    }

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'proveedor_id');
    }
}
