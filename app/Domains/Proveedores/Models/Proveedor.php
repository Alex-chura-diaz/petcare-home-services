<?php

namespace App\Domains\Proveedores\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Domains\Servicios\Models\Servicio;
use App\Domains\Reservas\Models\Reserva;
use App\Domains\Usuarios\Models\User;

class Proveedor extends Model
{
    use HasFactory;

    protected $table = 'proveedores';

    protected $fillable = [
        'user_id',
        'sucursal_id',
        'nombre_completo',
        'correo',
        'telefono',
        'tipo',
        'ofrece_visita_domicilio',
        'zona_cobertura',
        'horario_disponibilidad',
        'documento_habilitacion',
        'estado',
    ];

    protected $casts = [
        'horario_disponibilidad' => 'array',
    ];

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class, 'sucursal_id');
    }

    public function servicios()
    {
        return $this->belongsToMany(Servicio::class, 'proveedor_servicio', 'proveedor_id', 'servicio_id');
    }
   public function reservas()
    {
    return $this->hasMany(Reserva::class, 'proveedor_id');
    } 
    public function usuario()
    {
    return $this->belongsTo(User::class, 'user_id');
    }
}