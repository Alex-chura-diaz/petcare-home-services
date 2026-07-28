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
    Schema::create('registros_vacunacion', function (Blueprint $table) {
        $table->id();
        $table->foreignId('mascota_id')->constrained('mascotas')->onDelete('cascade');
        $table->string('nombre_vacuna');
        $table->date('fecha_aplicacion');
        $table->date('fecha_vencimiento')->nullable();
        $table->string('documento');
        $table->string('nombre_veterinario')->nullable();
        $table->boolean('verificado')->default(false);
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('registro_vacunacion');
    }
};
