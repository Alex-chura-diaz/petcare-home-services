<?php

namespace App\Domains\Mascotas\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mascota extends Model
{
    use HasFactory;

    protected $table = 'mascotas';

    protected $fillable = [
        'user_id',
        'nombre',
        'especie',
        'raza',
        'fecha_nacimiento',
        'sexo',
        'peso',
        'requiere_manejo_especial',
        'notas_manejo_especial',
        'foto',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function registrosVacunacion()
    {
    return $this->hasMany(RegistroVacunacion::class, 'mascota_id');
    }
    public function reservas()
    {
    return $this->hasMany(Reserva::class, 'mascota_id');
    }
}