<?php

namespace App\Domains\Usuarios\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Domains\Mascotas\Models\Mascota;
use App\Domains\Proveedores\Models\Proveedor;
use App\Models\Reserva;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function mascotas()
    {
    return $this->hasMany(Mascota::class, 'user_id');
    }

    public function reservas()
    {
    return $this->hasMany(Reserva::class, 'user_id');
    }
    public function proveedor()
    {
    return $this->hasOne(Proveedor::class, 'user_id');
    }

 }
