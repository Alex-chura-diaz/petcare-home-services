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
    Schema::create('servicios', function (Blueprint $table) {
        $table->id();
        $table->string('nombre');
        $table->enum('tipo', ['peluqueria', 'veterinaria', 'paseo', 'hospedaje', 'visita_domicilio']);
        $table->text('descripcion')->nullable();
        $table->decimal('precio_base', 8, 2);
        $table->integer('duracion_minutos');
        $table->boolean('requiere_vacuna_verificada')->default(false);
        $table->boolean('disponible_visita_domicilio')->default(false);
        $table->boolean('disponible_recogida_entrega')->default(false);
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
    Schema::dropIfExists('servicios');
    }
};
