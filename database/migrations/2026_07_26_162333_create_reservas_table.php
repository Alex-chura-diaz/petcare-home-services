<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
public function up(): void
{
    Schema::create('reservas', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        $table->foreignId('mascota_id')->constrained('mascotas')->onDelete('cascade');
        $table->foreignId('servicio_id')->constrained('servicios')->onDelete('cascade');
        $table->foreignId('proveedor_id')->constrained('proveedores')->onDelete('cascade');
        $table->enum('modalidad', ['recogida_entrega', 'visita_domicilio', 'en_local']);
        $table->string('direccion_visita')->nullable();
        $table->dateTime('fecha_hora');
        $table->enum('estado', ['pendiente', 'confirmada', 'rechazada', 'en_progreso', 'completada', 'cancelada'])->default('pendiente');
        $table->text('motivo_rechazo')->nullable();
        $table->enum('metodo_pago', ['en_linea', 'en_lugar']);
        $table->text('notas')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
public function down(): void
{
    Schema::dropIfExists('reservas');
}
};
