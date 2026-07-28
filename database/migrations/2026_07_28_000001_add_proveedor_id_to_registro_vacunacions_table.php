<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('registros_vacunacion', function (Blueprint $table) {
            $table->foreignId('proveedor_id')->nullable()->after('nombre_veterinario')->constrained('proveedores')->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::table('registros_vacunacion', function (Blueprint $table) {
            $table->dropForeign(['proveedor_id']);
            $table->dropColumn('proveedor_id');
        });
    }
};