<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Domains\Usuarios\Models\User;
use App\Domains\Mascotas\Models\Mascota;
use App\Domains\Mascotas\Models\RegistroVacunacion;
use App\Domains\Servicios\Models\Servicio;
use App\Models\Sucursal;
use App\Models\Proveedor;
use App\Models\Reserva;

class PetCareSeeder extends Seeder
{
    public function run(): void
    {
        // Usuario
        $usuario = User::create([
            'name' => 'Juan Pérez',
            'email' => 'juan2@test.com',
            'password' => bcrypt('12345678'),
        ]);

        // Mascota
        $mascota = Mascota::create([
            'user_id' => $usuario->id,
            'nombre' => 'Rocky',
            'especie' => 'perro',
            'requiere_manejo_especial' => false,
        ]);

        // Vacuna
        RegistroVacunacion::create([
            'mascota_id' => $mascota->id,
            'nombre_vacuna' => 'Rabia',
            'fecha_aplicacion' => '2026-01-15',
            'fecha_vencimiento' => '2027-01-15',
            'documento' => 'certificados/rabia_rocky.pdf',
            'nombre_veterinario' => 'Dra. Gómez',
            'verificado' => true,
        ]);

        // Servicios
        $servicioPeluqueria = Servicio::create([
            'nombre' => 'Peluquería canina',
            'tipo' => 'peluqueria',
            'descripcion' => 'Baño, corte y cepillado',
            'precio_base' => 25.00,
            'duracion_minutos' => 60,
            'requiere_vacuna_verificada' => false,
            'disponible_visita_domicilio' => false,
            'disponible_recogida_entrega' => true,
            'estado' => 'activo',
        ]);

        $servicioVeterinaria = Servicio::create([
            'nombre' => 'Consulta veterinaria',
            'tipo' => 'veterinaria',
            'descripcion' => 'Chequeo general',
            'precio_base' => 40.00,
            'duracion_minutos' => 30,
            'requiere_vacuna_verificada' => true,
            'disponible_visita_domicilio' => true,
            'disponible_recogida_entrega' => false,
            'estado' => 'activo',
        ]);

        // Sucursal
        $sucursal = Sucursal::create([
            'nombre' => 'PetCare Centro',
            'direccion' => 'Av. Principal 123',
            'ciudad' => 'Yacuiba',
            'telefono' => '77712345',
            'estado' => 'activo',
        ]);

        // Proveedor
        $proveedor = Proveedor::create([
            'sucursal_id' => $sucursal->id,
            'nombre_completo' => 'Ana Ramírez',
            'correo' => 'ana@petcare.com',
            'telefono' => '77754321',
            'tipo' => 'empleado',
            'ofrece_visita_domicilio' => true,
            'zona_cobertura' => 'Zona Centro',
            'horario_disponibilidad' => ['lunes' => '9:00-17:00', 'martes' => '9:00-17:00'],
            'estado' => 'activo',
        ]);

        $proveedor->servicios()->attach([$servicioPeluqueria->id, $servicioVeterinaria->id]);

        // Reserva
        Reserva::create([
            'user_id' => $usuario->id,
            'mascota_id' => $mascota->id,
            'servicio_id' => $servicioPeluqueria->id,
            'proveedor_id' => $proveedor->id,
            'modalidad' => 'recogida_entrega',
            'fecha_hora' => '2026-08-05 14:00:00',
            'estado' => 'pendiente',
            'metodo_pago' => 'en_lugar',
            'notas' => 'Reserva de prueba desde seeder',
        ]);
    }
}