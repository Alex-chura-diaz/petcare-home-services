<?php

namespace App\Domains\Servicios\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    use HasFactory;

    protected $table = 'servicios';

    protected $fillable = [
        'nombre',
        'tipo',
        'descripcion',
        'precio_base',
        'duracion_minutos',
        'requiere_vacuna_verificada',
        'disponible_visita_domicilio',
        'disponible_recogida_entrega',
        'estado',
    ];

    public function proveedores()
    {
    return $this->belongsToMany(Proveedor::class, 'proveedor_servicio', 'servicio_id', 'proveedor_id');
    }
    public function reservas()
    {
    return $this->hasMany(Reserva::class, 'servicio_id');
    }

}