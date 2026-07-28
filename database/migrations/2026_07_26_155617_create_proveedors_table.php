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
    Schema::create('proveedores', function (Blueprint $table) {
        $table->id();
        $table->foreignId('sucursal_id')->nullable()->constrained('sucursales')->onDelete('set null');
        $table->string('nombre_completo');
        $table->string('correo');
        $table->string('telefono');
        $table->enum('tipo', ['empleado', 'contratista', 'franquicia']);
        $table->boolean('ofrece_visita_domicilio')->default(false);
        $table->string('zona_cobertura')->nullable();
        $table->json('horario_disponibilidad')->nullable();
        $table->string('documento_habilitacion')->nullable();
        $table->enum('estado', ['activo', 'inactivo'])->default('activo');
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
    Schema::dropIfExists('proveedores');
}
};
