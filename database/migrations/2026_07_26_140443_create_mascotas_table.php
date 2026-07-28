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
    Schema::create('mascotas', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->string('nombre');
        $table->string('especie');
        $table->string('raza')->nullable();
        $table->date('fecha_nacimiento')->nullable();
        $table->enum('sexo', ['macho', 'hembra'])->nullable();
        $table->decimal('peso', 5, 2)->nullable();
        $table->boolean('requiere_manejo_especial')->default(false);
        $table->text('notas_manejo_especial')->nullable();
        $table->string('foto')->nullable();
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
    Schema::dropIfExists('mascotas');
    }
};
