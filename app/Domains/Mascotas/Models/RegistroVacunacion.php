<?php
namespace App\Domains\Mascotas\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Proveedor;

class RegistroVacunacion extends Model
{
    use HasFactory;

    protected $table = 'registros_vacunacion';

    protected $fillable = [
        'mascota_id',
        'nombre_vacuna',
        'fecha_aplicacion',
        'fecha_vencimiento',
        'documento',
        'nombre_veterinario',
        'proveedor_id',
        'verificado',
    ];

    public function mascota()
    {
        return $this->belongsTo(Mascota::class, 'mascota_id');
    }

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'proveedor_id');
    }
}