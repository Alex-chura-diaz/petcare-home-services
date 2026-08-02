<?php

namespace App\Domains\Proveedores\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model
{
    use HasFactory;

    protected $table = 'sucursales';

    protected $fillable = [
        'nombre',
        'direccion',
        'ciudad',
        'telefono',
        'estado',
    ];

    public function proveedores()
    {
        return $this->hasMany(Proveedor::class, 'sucursal_id');
    }
}